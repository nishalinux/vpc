<?php 
Class ProcessFlow_Reports_View extends Vtiger_Index_View {

	public function process(Vtiger_Request $request) { 
        global $adb;
        //$adb->setDebug(true);
		       
        $viewer = $this->getViewer($request);
		$moduleName = $request->getModule();       
        $viewer->assign('MODULE', $moduleName);	
        $current_time = date('Y-m-d H:i:s');
		$viewer->assign('CURRENT_TIME',$current_time);	 
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
        
        if(!empty($recordId)){ 
			$module_model = new ProcessFlow_Record_Model();
			$viewer->assign('PROCESSFLOW_MODEL',$module_model);
			$viewer->assign('RECORD_ID',$recordId);
			
        }
         
        $params = array();
        $params['processmasterid'] =$request->get('processmasterid');
        $params['pf_process_status'] =$request->get('pf_process_status');
        $params['date_start'] =$request->get('date_start');
        $params['date_end'] =$request->get('date_end');
        $params['fields'] =$request->get('fields');
    
		//echo '<pre>';print_r($request);echo '</pre>';

        $viewer->assign('PROCESS_RECORDS_DATA', $this->getReportData($params));
        $viewer->assign('PROCESS_STATUS_DATA', $this->getProcessStatusList());
        $viewer->assign('PROCESS_MASTER_LIST', $this->getProcessMasterList());
        $viewer->assign('PROCESSFLOW_FIELDS', $this->getFieldsForPF());
		$viewer->view('Reports.tpl', $moduleName);
    }
    
    protected function preProcessTplName(Vtiger_Request $request) {
		return 'ReportsViewPreProcess.tpl';
	}
    
    function getHeaderScripts1(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
			//'~libraries/jquery/jquery.dform-1.1.0.min.js'
		);
		 
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

    public function getReportData($params){
        global $adb;
		$all_fields_headers = $this->getFieldsForPF();

		//echo '<pre>';print_r($params);echo '</pre>';

		$final = array();
		$fields = '';
		if(!empty($params['fields']) && count($params['fields']) > 0){
			 
			$fields  = implode(',',$params['fields']);
			foreach($params['fields'] as $k => $f){ 
				$final['headers'][] = $all_fields_headers[$f];
			}
		}else{
			
			$final['headers'] = array('Processflow Name','Process Master','Pf No','Started DateTime','End DateTime','End Product Category','Status','Project');
			$fields = " vtiger_processflow.processflowname as 'Processflow Name',
						vtiger_processmaster.processmastername as 'Process Master',
						vtiger_processflow.processflow_no as 'Pf No',
						vtiger_processflow.process_flow_start_time as 'Started DateTime',
						vtiger_processflow.process_flow_end_time as 'End DateTime',
						vtiger_productcategory.productcategory as 'End Product Category',
						vtiger_processflow.pf_process_status as 'Status',
						vtiger_project.projectname as 'Project' ";
		}

			//print($fields);

        $q = "SELECT " . $fields . " FROM
                vtiger_processflow 
                LEFT JOIN vtiger_processflowcf ON vtiger_processflow.processflowid = vtiger_processflowcf.processflowid
                LEFT JOIN vtiger_processmaster ON vtiger_processflow.processmasterid = vtiger_processmaster.processmasterid
                LEFT JOIN vtiger_crmentity ON vtiger_processflow.processflowid = vtiger_crmentity.crmid
                LEFT JOIN vtiger_project ON vtiger_processflow.pf_project_id = vtiger_project.projectid
                LEFT JOIN vtiger_productcategory ON vtiger_processflow.end_product_category = vtiger_productcategory.productcategoryid
            WHERE
			vtiger_crmentity.deleted = 0";
            if($params['processmasterid'] != ''){
                $q .= " and vtiger_processmaster.processmasterid = ".$params['processmasterid'];
            }

            if($params['pf_process_status'] != ''){
                $q .= " and vtiger_processflow.pf_process_status = '".$params['pf_process_status'] . "'";
			}
			if($params['date_start'] != '' && $params['date_end'] != ''){
				$start = strtotime($params['date_start']);
				$start = date("Y-m-d H:i:s", $start);
				
				$end = strtotime($params['date_end']);
				$end = date("Y-m-d H:i:s", $end);

				$q .= " and (vtiger_processflow.process_flow_start_time  BETWEEN '".$start. "' and '".$end."') ";

			}

			//echo $q;
		 $result = $adb->pquery($q,array());
        
		if($adb->num_rows($result) > 0 ){ 
			while($data = $adb->fetchByAssoc($result)){ 
				$final['data'][] = $data;
			}
		}
		return $final;
    }
	
	public function getFieldsForPF()
	{
		global $adb;
		$result = $adb->pquery("SELECT columnname,tablename,fieldname,fieldlabel  FROM vtiger_field where tabid = ( SELECT t.tabid FROM vtiger_tab t where t.name='ProcessFlow') and presence = 2 ORDER BY  sequence ASC ",array());
		$final = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetchByAssoc($result)){ 
				$k = $data['tablename'].'.'.$data['columnname'];
				if($k == 'vtiger_processflow.processmasterid'){
					$k = 'vtiger_processmaster.processmastername';
				}else if( $k == 'vtiger_processflow.pf_project_id'){
					$k = 'vtiger_project.projectname';
				}
				$final[$k] = $data['fieldlabel'];
			}
		}
		return $final;
	}

	public function getProcessMasterList(){
		 
		global $adb;
		$result = $adb->pquery("SELECT * FROM vtiger_processmaster where is_draft = 0 and is_deleted = 0",array());
		$final = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetch_array($result)){ 
				$final[$data['processmasterid']] = $data['processmastername'];
			}
		}
		return $final;
    }
    
	public function getProcessStatusList(){
		 
		global $adb;
		$result = $adb->pquery("SELECT pf_process_status FROM vtiger_pf_process_status ORDER BY sortorderid ASC",array());
		$final = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetch_array($result)){ 
				$final[$data['pf_process_status']] = $data['pf_process_status'];
			}
		}
		return $final;
	}
	public function getProductList(){
		global $adb;
		$result = $adb->pquery("SELECT productid,productname FROM vtiger_products p left join vtiger_crmentity c on p.productid = c.crmid where deleted = 0",array());
		$final = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$final[$data['productid']] = $data['productname'];
			}
		}
		return $final;
	}
	public function getProductCategoryList(){
		 
		global $adb;
		$result = $adb->pquery("SELECT productcategoryid, productcategory FROM vtiger_productcategory ORDER BY sortorderid ASC",array());
		$final = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$final[$data['productcategoryid']] = $data['productcategory'];
			}
		}
		return $final;
	}
  

}