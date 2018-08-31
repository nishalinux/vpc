<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
require_once 'modules/ProcessFlow/RetrieveGridDetails.php';
Class ProcessFlow_Edit_View extends Vtiger_Edit_View {

	public function process(Vtiger_Request $request) {
 
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
        $recordModel = $this->record;
        if(!$recordModel){
            if (!empty($recordId)) {
                $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
            } else {
                $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
            }
        }

		global $adb;		 
		$pickBlocks = Array();
		$pickListsBlocks = Array();
		$pbResult = $adb->pquery("SELECT DISTINCT picklistfieldname FROM vtiger_pickblocks, vtiger_tab where vtiger_tab.tabid=vtiger_pickblocks.tabid and name= ?", Array($moduleName));
		while ($plrow = $adb->fetch_row($pbResult)){
			$picklistfieldname = $plrow["picklistfieldname"];
			$plbResult = $adb->pquery("SELECT vtiger_pickblocks.*, vtiger_blocks.blocklabel FROM vtiger_pickblocks, vtiger_tab, vtiger_blocks where vtiger_tab.tabid=vtiger_pickblocks.tabid and name= ? and picklistfieldname=? and vtiger_pickblocks.blockid = vtiger_blocks.blockid", Array($moduleName, $picklistfieldname));
			while ($plbrow = $adb->fetch_row($plbResult)){
				$pickListsBlocks[$plbrow["picklistitem"]] = Array($plbrow["blockid"], $plbrow["blocklabel"]);
			}
			$pickBlocks[$picklistfieldname] = $pickListsBlocks;
			$pickListsBlocks = Array();
		}
		$pbResult = $adb->pquery("SELECT * from vtiger_dvpanels,vtiger_tab where vtiger_tab.tabid=vtiger_dvpanels.tabid and name= ?", Array($moduleName));
		$panelTabs = Array();
		while ($row = $adb->fetch_row($pbResult)){
			$panelTabs[$row["panellabel"]] = $row["blockids"];
		}

		$viewer = $this->getViewer($request); 
		$viewer->assign('GALLERY_DETAILS', $recordModel->getGalleryEditDetails());
		$viewer->assign('PANELTABS', $panelTabs);
		$viewer->assign('PICKBLOCKS', $pickBlocks);
		$viewer->assign('PROCESS_MASTER_LIST', $this->getProcessMasterList($recordId));
		$viewer->assign('PRODUCTS_LIST', $this->getProductList());
		$viewer->assign('PRODUCTS_CATEGORY_LIST', $this->getProductCategoryList());
		$current_time = date('Y-m-d H:i:s');
		$viewer->assign('CURRENT_TIME',$current_time);
		$viewer->assign('RECORD_ID',$recordId);
		
		/*Manasa added on APR 15 2018 grids*/
		$grid1 = RetrieveGridDetails($recordId,'grid1');
		$grid2 = RetrieveGridDetails($recordId,'grid2');
		$grid3 = RetrieveGridDetails($recordId,'grid3');
		$grid4 = RetrieveGridDetails($recordId,'grid4');
	 
		$viewer->assign('GRID1', $grid1);
		$viewer->assign('GRID2', $grid2);
		$viewer->assign('GRID3', $grid3);
		$viewer->assign('GRID4', $grid4);

		#Product category(productcategory)
		$picklistValues = Vtiger_Util_Helper::getPickListValues('productcategory');
		$fieldPickListValues = array();	 
		foreach($picklistValues as $pckey=>$value) {
			$fieldPickListValues[$pckey] = vtranslate($value,'Products');
		}
		$viewer->assign('PRODUCT_CATEGORIES', $fieldPickListValues);

		#Assets category (cf_829)
		$picklistValues = Vtiger_Util_Helper::getPickListValues('cf_829');
		$fieldPickListValues = array();	 
		foreach($picklistValues as $pckey=>$value) {
			$fieldPickListValues[$pckey] = vtranslate($value,'Assets');
		}
		$viewer->assign('ASSET_CATEGORIES', $fieldPickListValues);
		
		#processmaster details
		$processmaster_json_data = $this->getProcessMasterDataFromRecordid($recordId);
		$viewer->assign('PROCESSMASTER_JSON_DATA', $processmaster_json_data);
		 

		/*ended here*/
		parent::process($request);
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
			'~libraries/jquery/jquery.dform-1.1.0.min.js',
			'libraries.jquery.multiplefileupload.jquery_MultiFile',
			"libraries.jquery.ckeditor.ckeditor",
			"libraries.jquery.ckeditor.adapters.jquery",
			'libraries.vtDZinerSupport',
			'layouts.vlayout.modules.ProcessFlow.resources.Grids',//Only for Grids added manasa 15th apr 2018				
		);
		 
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	public function getProcessMasterDataFromRecordid($recordId){
		global $adb;
		$q = "SELECT pm.is_vessels,pm.is_tools,pm.is_machinery FROM vtiger_processmaster pm left join  vtiger_processflow pf on pm.processmasterid = pf.processmasterid where pf.processflowid = ?";
		$result = $adb->pquery($q,array($recordId));
		$result = $adb->fetch_array($result);
		return $result;
	}

	public function getProcessMasterList($recordId){
		 
		global $adb;
		if($recordId > 0 && $recordId != ''){
			$result = $adb->pquery("SELECT processmasterid, processmastername FROM vtiger_processmaster where is_draft = 0",array());
		}else{
			$result = $adb->pquery("SELECT processmasterid, processmastername FROM vtiger_processmaster where is_draft = 0 and is_deleted = 0",array());
		}
		$final = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetch_array($result)){ 
				$final[$data['processmasterid']] = $data['processmastername'];
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

	public function getProcessData($recordId){
		global $adb;
		#get process manager id 
		$result = $adb->pquery("SELECT p.*,c.smownerid FROM vtiger_processflow p left join vtiger_crmentity c on p.processflowid = c.crmid where p.processflowid = ?",array($recordId));

		$processflowData = $adb->fetch_array($result);
		//echo '<pre>';print_r($processflowData);
		$final_array = array();
		$final_array['assigne_role'] = $this->getRoleidFromUserId($processflowData['smownerid']);
		$final_array['assigne_users'] = $this->getUserFullNames($processflowData['pf_assignee']);
		$final_array['assignee_data'] = $this->getAssigneeData($recordId);
		$final_array['products_data'] = $this->getProductsData($processflowData['raw_materials']);
		$final_array['created_by'] = $processflowData['smownerid'];

		$final_array['process_master_id'] = $processflowData['processmasterid'];
		$final_array['termination_status'] = $processflowData['pf_termination'];
		$final_array['process_start_date_time'] = $processflowData['process_flow_start_time'];
		$final_array['process_name'] = $processflowData['processflowname'];
		
		$processmaster_data = $this->getProcessMasterData($processflowData['processmasterid']);
		$final_array['supervisor_roleid'] = $processmaster_data['supervisor_roleid'];
		$final_array['operator_roleid'] = $processmaster_data['operator_roleid'];
		$final_array['sound_notifications'] = $processmaster_data['sound_notifications'];


		$final_array['process_list'] = $this->getProcessFlowUnitprocess($processflowData['processmasterid']);
		$final_array['process_instance_list'] = $this->getProcessFlowUnitprocessInstance($recordId);
		$final_array['process_Block_list'] = $this->getBlockTypeList();
		$final_array['process_destails']   = $this->getProcessDetails($recordId); 

		$ct_array = array_filter(array_map(function($arr){
						if ($arr['process_status'] == 1)
							return $arr['unitprocessid'];
						}, $final_array['process_instance_list']));
		$final_array['current_task'] = $this->getCurrentTask($recordId);

		$final_array['total_tasks'] = count($final_array['process_list']);
		
		$process_instance_list = $this->pf_array_count($final_array['process_instance_list'], 'process_status', '2');
		$final_array['total_completed_tasks'] = $process_instance_list;
		$final_array['total_not_started_tasks'] =  count($final_array['process_list']) - $process_instance_list;
		$final_array['total_tasks_Waiting'] = $this->getWaitingTasksCount($recordId);
	 

		 
		return $final_array;
	}

	public function getAssigneeData($recordId){
		global $adb;
		$q = "SELECT unitprocessid,assignee_user_id FROM vtiger_processflow_assignee where processflowid = ?";
		$result = $adb->pquery($q, array($recordId));
		$rows = $adb->num_rows($result);
		$finaldata = array();
		if($rows > 0){
			while($data = $adb->fetch_array($result)){
				$finaldata[$data['unitprocessid']] = $data['assignee_user_id'];   
			}
			return $finaldata;
		}
		return $finaldata;
	}

	 
	public function getProductsData($products_list){
        global $adb;
        $final = array();       
        if(trim($products_list) != ''){
            $result = $adb->pquery("SELECT productid,productname FROM vtiger_products p left join vtiger_crmentity c on p.productid = c.crmid where p.productid in ($products_list) ",array());
            if($adb->num_rows($result) >0 ){
                while($data = $adb->fetch_array($result)){
                    $final[$data['productid']] = $data['productname'];
                }
            }
        }
		return $final;
	}



	public function getUserFullNames($users){
		if(!empty($users)){
			$users = explode(';',$users);
			$data = array();
			foreach($users as $user){
				$data[$user] = getUserFullName($user);
			}
			return $data;
		}
		return array();

	}
	public function getCurrentTask($recordId){
		global $adb;
		$q = "SELECT count(*) as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and process_status = 2 group by unitprocessid";
		$result = $adb->pquery($q, array($recordId));
		return $adb->num_rows($result)+1;
	}

	public function getWaitingTasksCount($recordId){
		global $adb;
		$q = "SELECT count(*) as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and process_status = 4 group by unitprocessid";
		$result = $adb->pquery($q, array($recordId));
		return $adb->num_rows($result);
	}

	public function getProcessMasterData($pmid){
		global $adb;
		$q = "SELECT * FROM vtiger_processmaster where processmasterid = ?";
		$result = $adb->pquery($q,array($pmid));
		$result = $adb->fetch_array($result);
		return $result;
	}

	public function pf_array_count($array, $key, $value = NULL)
	{
		$c = 0;
		if (is_null($value)) {
			foreach ($array as $i => $subarray) {
				$c += ($subarray[$key] != '');
			}
		} else {
			foreach ($array as $i => $subarray) {
				$c += ($subarray[$key] == $value);
			}
		}
		return $c;
	}

	public function getProcessFlowUnitprocess($pid)
    { 
		global $adb;
		//$adb->setDebug(true);
       	# $sql = "SELECT u.unitprocessid,u.post_unitprocess, u.blocktype,u.description, u.unitprocess_time, ui.start_time,ui.end_time,ui.process_status, u.customicon, u.customform FROM vtiger_processflow_unitprocess u left join vtiger_processflow_unitprocess_instance ui on u.unitprocessid = ui.unitprocessid where u.processmasterid = ?  ORDER BY  u.sequence ASC " ; 
		$sql = "SELECT * FROM vtiger_processflow_unitprocess u where u.processmasterid = ?  ORDER BY  u.sequence ASC " ; 
		$result = $adb->pquery($sql,array($pid));
		$process_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$process_list[$data['unitprocessid']] = $data;   
			}
		} 
        return $process_list;
	}

	public function getProcessFlowUnitprocessInstance($recordId){
		global $adb; 
		$q = "SELECT distinct unitprocessid,unit_instanceid,start_time,end_time,process_status,process_iteration,unit_instance_data  FROM vtiger_processflow_unitprocess_instance where process_instanceid = ?";
		$result = $adb->pquery($q,array($recordId));
		$process_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				 
				$data['start_time'] = $this->convertTimeToUserTimezone($data['start_time']);
				$data['end_time'] = $this->convertTimeToUserTimezone($data['end_time']); 
				$process_list[$data['unitprocessid']] = $data;   
			}
		} 
        return $process_list;
	}

	public function convertTimeToUserTimezone($time){
		global $adb;
		$userid = $_SESSION['authenticated_user_id'];
		$sql= $adb->pquery("SELECT time_zone FROM vtiger_users where id = ?",array($userid));
		$timezone = $adb->fetch_array($sql);  
		//date_default_timezone_set('UTC');
		$datetime = new DateTime($time,new DateTimeZone('UTC')); 
	
		$la_time = new DateTimeZone($timezone['time_zone']);
		
		$datetime->setTimezone($la_time);
		return $datetime->format('Y-m-d H:i:s');
	}

	public function getBlockTypeList(){
		global $adb;
		$sql = "SELECT processblocktypeid ,blocktype_icon  FROM vtiger_process_block_types " ;
		$result = $adb->pquery($sql,array());
		$process_block_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$process_block_list[$data['processblocktypeid']] = $data['blocktype_icon'];   
			}
		}   
        return $process_block_list;
	}

	public function getProcessDetails($recordId)
	{
		global $adb; 
		$current_time = date('Y-m-d H:i:s');
		// SELECT *, timediff(NOW() , process_flow_start_time) AS elapsed_time FROM vtiger_processflow where processflowid = 93
		$sql = "SELECT *, timediff(? , process_flow_start_time) AS elapsed_time FROM vtiger_processflow where processflowid = ?" ;
		$result = $adb->pquery($sql,array($current_time,$recordId));        
        return $adb->fetch_array($result) ;
	}

	function getRoleidFromUserId($userid){
	 
		global $adb; 
		$sql = "SELECT roleid FROM `vtiger_user2role` where userid = ?" ;
		$result = $adb->pquery($sql,array($userid));        
		$data = $adb->fetch_array($result);
		return $data['roleid'];
	}

}