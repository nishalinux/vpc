<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Class Changes_Edit_View extends Vtiger_Edit_View {
	
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$moduleName = $request->getModule();
		$modulePopUpFile = 'modules.'.$moduleName.'.resources.Edit';
		unset($headerScriptInstances[$modulePopUpFile]);


		$jsFileNames = array(
				'modules.Changes.resources.Edit',
		);
		$jsFileNames[] = $modulePopUpFile;
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
	public function process(Vtiger_Request $request) {
		$viewer = $this->getViewer ($request);
		
		$moduleName = $request->getModule();
		$record = $request->get('record');
        if(!empty($record) && $request->get('isDuplicate') == true) {
            $recordModel = $this->record?$this->record:Vtiger_Record_Model::getInstanceById($record, $moduleName);
			$viewer->assign('MODE', '');

			//While Duplicating record, If the related record is deleted then we are removing related record info in record model
			$mandatoryFieldModels = $recordModel->getModule()->getMandatoryFieldModels();
			foreach ($mandatoryFieldModels as $fieldModel) {
				if ($fieldModel->isReferenceField()) {
					$fieldName = $fieldModel->get('name');
					if (Vtiger_Util_Helper::checkRecordExistance($recordModel->get($fieldName))) {
						$recordModel->set($fieldName, '');
					}
				}
			}  
        }else if(!empty($record)) {
            $recordModel = $this->record?$this->record:Vtiger_Record_Model::getInstanceById($record, $moduleName);
            $viewer->assign('RECORD_ID', $record);
            $viewer->assign('MODE', 'edit');
        } else {
            $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
            $viewer->assign('MODE', '');
        }
        if(!$this->record){
            $this->record = $recordModel;
        }
        
		 
		$moduleModel = $recordModel->getModule();
		$fieldList = $moduleModel->getFields();
		//print_r($fieldList);
		$requestFieldList = array_intersect_key($request->getAll(), $fieldList);
		foreach($requestFieldList as $fieldName=>$fieldValue){
			$fieldModel = $fieldList[$fieldName];
			$specialField = false;
			
			if($fieldModel->isEditable() || $specialField) {
				$recordModel->set($fieldName, $fieldModel->getDBInsertValue($fieldValue));
			}
		}
		//custom
		$taskid = $request->get('taskid');
		$co_mode = $request->get('mode');
		
		if(!empty($taskid)){
			$viewer->assign('OLD_TASK_ID', $taskid);
			$viewer->assign('CO_MODE', $co_mode);
			$task_data = $this->getTaskDetails($request);
			$task_data['c_old_task_ref'] = $taskid;
			$task_data['c_co_mode'] = $co_mode;
			foreach($task_data as $fieldName=>$fieldValue){
				$fieldModel = $fieldList[$fieldName];					 
				$recordModel->set($fieldName, $fieldModel->getDBInsertValue($fieldValue));					 
			}			
		} 
		//end	
		
		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_EDIT);
		$picklistDependencyDatasource = Vtiger_DependencyPicklist::getPicklistDependencyDatasource($moduleName);

		$viewer->assign('PICKIST_DEPENDENCY_DATASOURCE',Zend_Json::encode($picklistDependencyDatasource));
		$viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
		$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CURRENTDATE', date('Y-n-j'));
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		 
		$viewer->assign('SCRIPTS',$this->getHeaderScripts($request));
		//{$FIELD_MODEL->get('fieldvalue')}
		
		
		$viewer->view('EditView.tpl', $moduleName);
	}
	
	public function getTaskDetails(Vtiger_Request $request){
		global $adb,$current_user;
		$projecttaskid = $request->get('taskid');
		$query = $adb->pquery("SELECT * FROM vtiger_projecttask left join vtiger_projecttaskcf on vtiger_projecttask.projecttaskid = vtiger_projecttaskcf.projecttaskid where vtiger_projecttask.projecttaskid = ?",array($projecttaskid));
		$row = $adb->fetch_array($query);	 
		//$result['c_start_date'] = $row['startdate'];
		//$result['c_end_date'] = $row['enddate'];
		
		$dateformat = str_replace(array('yyyy', 'mm','dd'), array('Y', 'm', 'd'), $current_user->date_format);
		$dateformat = 'm-d-Y';
		if($row['startdate'] != ''){
			$result['c_start_date'] = date($dateformat, strtotime($row['startdate']));
		}
		if($row['enddate'] != ''){
			$result['c_end_date'] = date($dateformat, strtotime($row['enddate']));
		}
		
		$result['c_task_budget'] = $row['pcm_task_budget_dollars'];
		$result['c_hourly_charges'] = $row['pcm_hourly_charges'];
		$result['c_task_budget_hours'] = $row['pcm_task_budget_hours'];			 
		return $result;
	}
	
}