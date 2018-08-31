<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Class Calendar_Edit_View extends Vtiger_Edit_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('Events');
		$this->exposeMethod('Calendar');
		//$this->exposeMethod('step1');
		$this->exposeMethod('step2');
		$this->exposeMethod('step3');
	}
	function step2(Vtiger_Request $request){
		 $viewer = $this->getViewer ($request);
		 $moduleName = $request->get('module');
		 $record = $request->get('record');
		  $currentUser = Users_Record_Model::getCurrentUserModel();

		 if(!empty($record) && $request->get('isDuplicate') == true) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			
		}else if(!empty($record)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			
			$viewer->assign('RECORD_ID', $record);
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			
		}
		$eventModule = Vtiger_Module_Model::getInstance($moduleName);
		$recordModel->setModuleFromInstance($eventModule);

		$moduleModel = $recordModel->getModule();
		$data = $request->getAll();
		foreach ($data as $name => $value) {
			$recordModel->set($name, $value);
		}
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$existingRelatedContacts = $recordModel->getRelatedContactInfo();

		//To add contact ids that is there in the request . Happens in gotoFull form mode of quick create
		$requestContactIdValue = $request->get('contact_id');
		if(!empty($requestContactIdValue)) {
			$existingRelatedContacts[] = array('name' => Vtiger_Util_Helper::getRecordName($requestContactIdValue) ,'id' => $requestContactIdValue);
		}
		
        $viewer->assign('RELATED_CONTACTS', $existingRelatedContacts);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('RECORD_MODEL', $recordModel);
		$accessibleUsers = $currentUser->getAccessibleUsers();
		$viewer->assign('ACCESSIBLE_USERS', $accessibleUsers);
		$viewer->assign('INVITIES_SELECTED', $recordModel->getInvities());
        $viewer->assign('CURRENT_USER', $currentUser);
		$viewer->assign('RECORD_ID', $record);
		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel,
									Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_EDIT);
		$viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
		$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());
		$viewer->view('step2.tpl',"Calendar");
	}
	function step3(Vtiger_Request $request){
		 $viewer = $this->getViewer ($request);
	     $moduleName = $request->get('module');
		 $record = $request->get('record');

		 if(!empty($record) && $request->get('isDuplicate') == true) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			
		}else if(!empty($record)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			
			$viewer->assign('RECORD_ID', $record);
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			
		}
		$eventModule = Vtiger_Module_Model::getInstance($moduleName);
		$recordModel->setModuleFromInstance($eventModule);
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$moduleModel = $recordModel->getModule();
		$data = $request->getAll();
		foreach ($data as $name => $value) {
			$recordModel->set($name, $value);
		}
		$selectedusers = $request->get('selectedusers');
		foreach ($selectedusers as $k => $v ){
			$usernames[] = getEntityname('Users',$v);
		}
		$contacts = explode(";",$request->get('contactidlist'));
		foreach ($contacts as $k => $v ){
			$contactusers[]= getEntityname('Contacts',$v);
		}
		
		$viewer->assign('EVENTUSERS', $usernames);
		$viewer->assign('EVENTCONTACTS', $contactusers);
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('RECORD_MODEL', $recordModel);
		$viewer->assign('RECORD_ID', $record);
		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel,
									Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_EDIT);
		$viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
		$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());
		 $viewer->view('step3.tpl',"Calendar");
	}

	function process(Vtiger_Request $request) {
		$mode = $request->getMode();

		$recordId = $request->get('record');
		if(!empty($recordId) && empty($mode)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
			$mode = $recordModel->getType();
		}

		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request, $mode);
			return;
		}
		$this->Calendar($request, 'Calendar');
	}

	function Events($request, $moduleName) {
		
        $currentUser = Users_Record_Model::getCurrentUserModel();
		$viewer = $this->getViewer ($request);
		$record = $request->get('record');

		 if(!empty($record) && $request->get('isDuplicate') == true) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
		}else if(!empty($record)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
			$viewer->assign('RECORD_ID', $record);
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
		}
		$SUBJECT = $recordModel->get('subject');
		$eventModule = Vtiger_Module_Model::getInstance($moduleName);
		$recordModel->setModuleFromInstance($eventModule);

		$moduleModel = $recordModel->getModule();
		$fieldList = $moduleModel->getFields();
		$requestFieldList = array_intersect_key($request->getAll(), $fieldList);

		foreach($requestFieldList as $fieldName=>$fieldValue){
			$fieldModel = $fieldList[$fieldName];
			$specialField = false;
			// We collate date and time part together in the EditView UI handling 
			// so a bit of special treatment is required if we come from QuickCreate 
			if (empty($record) && ($fieldName == 'time_start' || $fieldName == 'time_end') && !empty($fieldValue)) { 
				$specialField = true; 
				// Convert the incoming user-picked time to GMT time 
				// which will get re-translated based on user-time zone on EditForm 
				$fieldValue = DateTimeField::convertToDBTimeZone($fieldValue)->format("H:i"); 
			} 
            if (empty($record) && ($fieldName == 'date_start' || $fieldName == 'due_date') && !empty($fieldValue)) { 
                if($fieldName == 'date_start'){
                    $startTime = Vtiger_Time_UIType::getTimeValueWithSeconds($requestFieldList['time_start']);
                    $startDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($fieldValue." ".$startTime);
                    list($startDate, $startTime) = explode(' ', $startDateTime);
                    $fieldValue = Vtiger_Date_UIType::getDisplayDateValue($startDate);
                }else{
                    $endTime = Vtiger_Time_UIType::getTimeValueWithSeconds($requestFieldList['time_end']);
                    $endDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($fieldValue." ".$endTime);
                    list($endDate, $endTime) = explode(' ', $endDateTime);
                    $fieldValue = Vtiger_Date_UIType::getDisplayDateValue($endDate);
                }
            }
            
			if($fieldModel->isEditable() || $specialField) { 
				$recordModel->set($fieldName, $fieldModel->getDBInsertValue($fieldValue));
			}
		}
		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel,
									Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_EDIT);

		$viewMode = $request->get('view_mode');
		if(!empty($viewMode)) {
			$viewer->assign('VIEW_MODE', $viewMode);
		}
		
        $userChangedEndDateTime = $request->get('userChangedEndDateTime');
		//If followup value is passed from request to process the value and sent to client
		$requestFollowUpDate = $request->get('followup_date_start');
		$requestFollowUpTime = $request->get('followup_time_start');
		$followUpStatus = $request->get('followup');
		$eventStatus = $request->get('eventstatus');
		
		if(!empty($requestFollowUpDate)){
			$followUpDate = $requestFollowUpDate;
		}
		if(!empty($requestFollowUpTime)){
			$followUpTime = $requestFollowUpTime;
		}
		if($followUpStatus == 'on'){
			$viewer->assign('FOLLOW_UP_STATUS',TRUE);
		}
		if($eventStatus == 'Held'){
			$viewer->assign('SHOW_FOLLOW_UP',TRUE);
		}else{
			$viewer->assign('SHOW_FOLLOW_UP',FALSE);
		}
        
		$viewer->assign('USER_CHANGED_END_DATE_TIME',$userChangedEndDateTime);
		$viewer->assign('FOLLOW_UP_DATE',$followUpDate);
		$viewer->assign('FOLLOW_UP_TIME',$followUpTime);
		$viewer->assign('RECURRING_INFORMATION', $recordModel->getRecurrenceInformation());
		$viewer->assign('TOMORROWDATE', Vtiger_Date_UIType::getDisplayDateValue(date('Y-m-d', time()+86400)));
		
		$viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
		$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());

		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CURRENTDATE', date('Y-n-j'));
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$existingRelatedContacts = $recordModel->getRelatedContactInfo();

		//To add contact ids that is there in the request . Happens in gotoFull form mode of quick create
		$requestContactIdValue = $request->get('contact_id');
		if(!empty($requestContactIdValue)) {
			$existingRelatedContacts[] = array('name' => Vtiger_Util_Helper::getRecordName($requestContactIdValue) ,'id' => $requestContactIdValue);
		}
		
        $viewer->assign('RELATED_CONTACTS', $existingRelatedContacts);

		$isRelationOperation = $request->get('relationOperation');

		//if it is relation edit
		$viewer->assign('IS_RELATION_OPERATION', $isRelationOperation);
		if($isRelationOperation) {
			$viewer->assign('SOURCE_MODULE', $request->get('sourceModule'));
			$viewer->assign('SOURCE_RECORD', $request->get('sourceRecord'));
		}
		$picklistDependencyDatasource = Vtiger_DependencyPicklist::getPicklistDependencyDatasource($moduleName);
        $accessibleUsers = $currentUser->getAccessibleUsers();
		
		$viewer->assign('PICKIST_DEPENDENCY_DATASOURCE',Zend_Json::encode($picklistDependencyDatasource));
		$viewer->assign('ACCESSIBLE_USERS', $accessibleUsers);
        $viewer->assign('INVITIES_SELECTED', $recordModel->getInvities());
        $viewer->assign('CURRENT_USER', $currentUser);
		$viewer->assign('SUBJECT',$SUBJECT);


		$viewer->view('EditHeader.tpl', "Calendar");
		$viewer->view('step1.tpl',"Calendar");
	}

	function Calendar($request, $moduleName) {
		parent::process($request);
	}
		/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$mode = $request->get('mode');
		if($mode == 'Events' || $mode == 'step1' || $mode == 'step2' || $mode == 'step3'){
			$jsFileNames = array(
				'modules.Calendar.resources.Edit',
				'modules.Calendar.resources.Edit1',
				'modules.Calendar.resources.Edit2',
				'modules.Calendar.resources.Edit3',
			);
		}else{
			$jsFileNames = array(
				'modules.Calendar.resources.ToDo'
				);
		}

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}