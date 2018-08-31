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
        
        $params = $custom_fields = array();
		$params['processmasterid'] =$request->get('processmasterid');
		if(!empty($params['processmasterid']) && $params['processmasterid'] > 0 ){
			$custom_fields  = $this->getCustomFormInfo($params['processmasterid']);
		}
        $params['customformfields'] =$request->get('customformfields');
        $params['pf_process_status'] =$request->get('pf_process_status');
        $params['date_start'] =$request->get('date_start');
        $params['date_end'] =$request->get('date_end');
        $params['fields'] =$request->get('fields');
    
		#echo '<pre>';print_r($request);echo '</pre>';

        $viewer->assign('CUSTOMFIELDS', $custom_fields);
        $viewer->assign('PROCESS_RECORDS_DATA', $this->getReportData($params));
        $viewer->assign('PROCESS_STATUS_DATA', $this->getProcessStatusList());
        $viewer->assign('PROCESS_MASTER_LIST', $this->getProcessMasterList());
        $viewer->assign('PROCESSFLOW_FIELDS', $this->getFieldsForPF());
		$viewer->view('Reports.tpl', $moduleName);
    }
	
	public function getCustomFormInfo($processmasterid){
		global $adb;
		$mcdata = "SELECT pu.customform FROM vtiger_processflow_unitprocess pu  WHERE pu.processmasterid=? order by pu.sequence";
		$mcviewname_result = $adb->pquery($mcdata, array($processmasterid));
		$field = array();
		$unit_instance_data_info = array();
		$i = 0;  
		while($mcrow = $adb->fetch_array($mcviewname_result))
		{
			$customform = $mcrow['customform'];
			$customform_info = json_decode(stripslashes(html_entity_decode($customform)), true);
			$frmData = $customform_info['html'];
			if(count($frmData) > 0){
				foreach($frmData as $key=>$fieldData){
					$field[$fieldData['html']['name']] = $fieldData['html']['caption'];
				}
			}
		}
		return $field;
	}


    protected function preProcessTplName(Vtiger_Request $request) {
		return 'ReportsViewPreProcess.tpl';
	}
    
    public function getHeaderScripts1(Vtiger_Request $request) {
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
		$final = array();
		$fields = '';
		#$final['headers'][] = 'id';
		$customformfields = $params['customformfields'];
		
		# crm fields and headers
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

		#custom form fields and headers
		if($params['processmasterid'] != ''){
			$custom_form_headers = $this->getCustomFormHeaders($params['processmasterid'],$customformfields);
			#$this->_print_r($custom_form_headers);

			foreach($custom_form_headers as $k=>$v){
				$final['headers'][] = $v;
			}
			#$this->_print_r($final['headers']);
		}
		#end
		
		

        $q = "SELECT vtiger_processflow.processflowid, " . $fields . " FROM
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
			
			
		# echo $q;
		 $result = $adb->pquery($q,array());
        
		if($adb->num_rows($result) > 0 ){ 
			while($data = $adb->fetchByAssoc($result)){ 
				
				 $all_customformfields_values = array();
				if(count($customformfields) > 0){ 

					$all_customformfields_values = $this->getCustomFormData($customformfields,$data['processflowid']);
					foreach($customformfields as $a){
						$data[$a] = '';
					}
					
					if(count($all_customformfields_values) > 0){
						foreach($all_customformfields_values as $k=>$v){
							$data[$k] = $v;
						}
					}
				}
				
				$finaldata = $data;
				foreach($data as $k=>$v){
					if($k == 'smownerid'){
						$finaldata[$k] = getUserFullName($v);
					}
				}
				
				unset($finaldata['processflowid']);
				#$this->_print_r($final['headers']);
				#$this->_print_r($finaldata);
				$final['data'][] = $finaldata;
			}
		}
		return $final;
	}
	
	public function getCustomFormData($customformfields,$id){
		global $adb;
		#$adb->setDebug(true);
		$result = $adb->pquery("SELECT unit_instance_data FROM vtiger_processflow_unitprocess_instance WHERE process_instanceid =?",array($id));
		$fv = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetchByAssoc($result)){ 
				$unit_instance_data = $data['unit_instance_data'];
				$customform_values = json_decode(stripslashes(html_entity_decode($unit_instance_data)), true);
				
				if(count($customform_values['quantity_data']) > 0){
					foreach($customform_values['quantity_data'] as $ck => $cdata){
						if(in_array($cdata['name'],$customformfields)){
							$fv[$cdata['name']] = $cdata['value'];
						}
					}
				}
			}
		}
		return $fv;
	}

	public function getCustomFormHeaders($processmasterid,$customformfields){
		global $adb;
		#$adb->setDebug(true);
		$result = $adb->pquery("SELECT customform FROM vtiger_processflow_unitprocess where processmasterid  = ?",array($processmasterid));
		$fv = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetchByAssoc($result)){ 
				$customform = $data['customform'];
				$customform = json_decode(stripslashes(html_entity_decode($customform)), true);
				if(count($customform['html'] > 0)){
					foreach($customform['html'] as $ck => $cdata){ 
						if(in_array($cdata['html']['name'],$customformfields)){
							$fv[$cdata['html']['name']] = $cdata['html']['caption'];
						}
					}
				} 
			}
		}
		#$adb->setDebug(false);
		return $fv;
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
  
	function _print_r($data){
		echo '<pre>';
		print_r($data);
		echo '</pre>';
		return true;
	}
}