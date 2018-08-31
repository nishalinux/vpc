<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_ExportData_Action extends Vtiger_Mass_Action {

	function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModuleActionPermission($moduleModel->getId(), 'Export')) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	/**
	 * Function is called by the controller
	 * @param Vtiger_Request $request
	 */
	function process(Vtiger_Request $request) {
		$this->ExportData($request);
	}

	private $moduleInstance;
	private $focus;

	/**
	 * Function exports the data based on the mode
	 * @param Vtiger_Request $request
	 */
	function ExportData(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();
		$moduleName = $request->get('source_module');

	//Added by YOGITA: 10Nov17 :starts--->
		$selected_ids = $request->get('selected_ids');
		$selected_ids = implode(',',$selected_ids);
		$mode = $request->get('mode');
	//Added by YOGITA: 10Nov17 :ends --->
	
		$this->moduleInstance = Vtiger_Module_Model::getInstance($moduleName);
		$this->moduleFieldInstances = $this->moduleInstance->getFields();
		$this->focus = CRMEntity::getInstance($moduleName);
	
	//Added By Yogita: 10Nov17 :starts -->	
		if($moduleName == 'Events'){
			$query = "SELECT vtiger_crmentity.description, vtiger_activity_reminder.reminder_time, GROUP_CONCAT(DISTINCT vtiger_cntactivityrel.contactid SEPARATOR ',' ) contactid, vtiger_seactivityrel.crmid,vtiger_activity.invoiceid, vtiger_activity.duration_seconds, vtiger_activity.subject, vtiger_crmentity.smownerid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_activity.time_end, vtiger_activity.duration_hours, vtiger_activity.duration_minutes, vtiger_activity.eventstatus, vtiger_activity.sendnotification, vtiger_activity.activitytype, vtiger_activity.location, vtiger_crmentity.createdtime, vtiger_crmentity.modifiedtime, vtiger_activity.priority, vtiger_activity.notime, vtiger_activity.visibility, vtiger_crmentity.modifiedby, vtiger_activity.recurringtype,GROUP_CONCAT(DISTINCT vtiger_invitees.inviteeid SEPARATOR ',') inviteeid, vtiger_activity.activityid 
			FROM vtiger_activity 
			INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid 
			LEFT JOIN vtiger_activity_reminder ON vtiger_activity.activityid = vtiger_activity_reminder.activity_id 
			LEFT JOIN vtiger_cntactivityrel ON vtiger_activity.activityid = vtiger_cntactivityrel.activityid 
			LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid 
			LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id 
			LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid 
			LEFT JOIN vtiger_users AS vtiger_usersmodifiedby ON vtiger_crmentity.modifiedby = vtiger_usersmodifiedby.id 
			LEFT JOIN vtiger_groups AS vtiger_groupsmodifiedby ON vtiger_crmentity.modifiedby = vtiger_groupsmodifiedby.groupid 
			LEFT JOIN vtiger_invitees ON vtiger_invitees.activityid = vtiger_activity.activityid 
			LEFT JOIN vtiger_activitycf ON vtiger_activitycf.activityid = vtiger_activity.activityid 
			WHERE vtiger_crmentity.deleted=0 ";
			
			$query1 = "SELECT vtiger_crmentity.description, vtiger_activity_reminder.reminder_time, vtiger_cntactivityrel.contactid, vtiger_seactivityrel.crmid, vtiger_activity.invoiceid, vtiger_activity.duration_seconds,vtiger_activity.subject, vtiger_crmentity.smownerid, vtiger_activity.date_start, vtiger_activity.time_start, vtiger_activity.time_start, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_activity.time_end, vtiger_activity.duration_hours, vtiger_activity.duration_minutes, vtiger_activity.status, vtiger_activity.sendnotification, vtiger_activity.activitytype, vtiger_activity.location, vtiger_crmentity.createdtime, vtiger_crmentity.modifiedtime, vtiger_activity.priority, vtiger_activity.notime, vtiger_activity.visibility, vtiger_crmentity.modifiedby, vtiger_activity.recurringtype, GROUP_CONCAT(DISTINCT vtiger_invitees.inviteeid SEPARATOR ',') inviteeid, vtiger_activity.activityid
			FROM vtiger_activity 
			INNER JOIN vtiger_crmentity ON vtiger_activity.activityid = vtiger_crmentity.crmid 
			LEFT JOIN vtiger_activity_reminder ON vtiger_activity.activityid = vtiger_activity_reminder.activity_id 
			LEFT JOIN vtiger_cntactivityrel ON vtiger_activity.activityid = vtiger_cntactivityrel.activityid 
			LEFT JOIN vtiger_seactivityrel ON vtiger_activity.activityid = vtiger_seactivityrel.activityid 
			LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id 
			LEFT JOIN vtiger_groups ON vtiger_crmentity.smownerid = vtiger_groups.groupid 
			LEFT JOIN vtiger_users AS vtiger_usersmodifiedby ON vtiger_crmentity.modifiedby = vtiger_usersmodifiedby.id 
			LEFT JOIN vtiger_groups AS vtiger_groupsmodifiedby ON vtiger_crmentity.modifiedby = vtiger_groupsmodifiedby.groupid 
			LEFT JOIN vtiger_invitees ON vtiger_invitees.activityid = vtiger_activity.activityid 
			LEFT JOIN vtiger_activitycf ON vtiger_activitycf.activityid = vtiger_activity.activityid 
			WHERE vtiger_crmentity.deleted=0 ";
			
			if($mode == 'ExportAllEvents'){
				$query .= " AND (vtiger_activity.activityid > 0 AND vtiger_activity.activitytype NOT IN('Task')) GROUP BY vtiger_activity.activityid";
			}
			if($mode == 'ExportAllTasks'){
				$query = $query1." AND (vtiger_activity.activityid > 0 AND vtiger_activity.activitytype IN('Task')) GROUP BY vtiger_activity.activityid";
			}
			//ExportSelectedEvents, ExportSelectedTasks , ExportAllEvents, ExportAllTasks
			if($mode == 'ExportSelectedEvents' ){
				$query .= " AND (vtiger_activity.activityid IN($selected_ids) AND vtiger_activity.activitytype NOT IN('Task')) GROUP BY vtiger_activity.activityid";
			}
			if($mode == 'ExportSelectedTasks' ){
				$query = $query1." AND (vtiger_activity.activityid IN($selected_ids) AND vtiger_activity.activitytype IN('Task')) GROUP BY vtiger_activity.activityid";
			}
			
		}else{
			$query = $this->getExportQuery($request);
		}

	//Added By Yogita: 10Nov17 :ends
	
		//$query = $this->getExportQuery($request);
		$result = $db->pquery($query, array());

		$headers = array();
		//Query generator set this when generating the query
		if(!empty($this->accessibleFields)) {
			$accessiblePresenceValue = array(0,2);
			foreach($this->accessibleFields as $fieldName) {
				$fieldModel = $this->moduleFieldInstances[$fieldName];
				// Check added as querygenerator is not checking this for admin users
				$presence = $fieldModel->get('presence');
				if(in_array($presence, $accessiblePresenceValue)) {
					$headers[] = $fieldModel->get('label');
				}
			}
		} else {
			foreach($this->moduleFieldInstances as $field) $headers[] = $field->get('label');
		}
		$translatedHeaders = array();
		foreach($headers as $header) $translatedHeaders[] = vtranslate(html_entity_decode($header, ENT_QUOTES), $moduleName);

		$entries = array();
		
//Added By Yogita: 10nov17 :starts		
		if($moduleName == 'Events' ){
			$translatedHeaders[] = 'InviteUsers';			
			$translatedHeaders[] = 'ActivityId';			
			for($j=0; $j<$db->num_rows($result); $j++) {
			   $cal_data_arr = $db->fetchByAssoc($result, $j);
  
			   if($cal_data_arr['contactid']!= ''){
					//$contact_name_array = getEntityName('Contacts',array('id'=>$cal_data_arr['contactid']));
					//$cal_data_arr['contactid'] =  $contact_name_array[$cal_data_arr['contactid']]; 
					
					$cids = $cal_data_arr['contactid'];
					$cids = explode(',',$cids);
					$contact_name_array = array();			 
					foreach($cids as $k =>$cid){					 
						 $contact_name = getEntityName('Contacts',array('id'=>trim($cid)));			 
						$contact_name_array[] = $contact_name[trim($cid)];
					}  
					$cal_data_arr['contactid'] =  implode(',',$contact_name_array);
			   }
			   if($cal_data_arr['inviteeid']!= ''){
				   $invitees = $cal_data_arr['inviteeid'];
				   $invitees = explode(',',$invitees);
					$users_name_array = array();
					foreach($invitees as $k =>$invitee){
						 $user_name = getEntityName('Users',array('id'=>$invitee));	
						 
						$users_name_array[] = $user_name[trim($invitee)];
					}
					$cal_data_arr['inviteeid'] =  implode(',',$users_name_array);
			   }
			   if($cal_data_arr['invoiceid']!= ''){
					$invoice = $cal_data_arr['invoiceid'];
					$invoice_arr = getEntityName('Invoice',array('id'=>$cal_data_arr['invoiceid']));
					$invoice_name = $invoice_arr[$invoice];
					$cal_data_arr['invoiceid'] =  $invoice_name;
			   }
			   			   
				if($mode != 'ExportAllEvents' || $mode != 'ExportSelectedEvents'){
					if($cal_data_arr['smownerid']!= ''){
						$name_val = $cal_data_arr['smownerid'];
						$name = Vtiger_Util_Helper::getOwnerName($name_val);
						$cal_data_arr['smownerid'] =  $name;
					}
					if($cal_data_arr['modifiedby']!= ''){
						$mname_val = $cal_data_arr['modifiedby'];
						$mname = Vtiger_Util_Helper::getOwnerName($mname_val);
						$cal_data_arr['modifiedby'] =  $mname;
					}
					if($cal_data_arr['crmid'] != ''){
						$parent_module = getSalesEntityType($cal_data_arr['crmid']);
						$name_arr = getEntityName($parent_module,array('id'=>$cal_data_arr['crmid']));
						$name = $name_arr[$cal_data_arr['crmid']];
						$cal_data_arr['crmid']= $parent_module.'::::'.$name;
					}
					$entries[$j] = ($cal_data_arr);
					
				}else{
					$entries[$j] = $this->sanitizeValues($cal_data_arr);
					$entries[$j]['InviteUsers'] = $cal_data_arr['inviteeid'];
					$entries[$j]['ActivityId'] = $cal_data_arr['activityid'];
				}	
			  }
		}else{
			for($j=0; $j<$db->num_rows($result); $j++) {
				$entries[] = $this->sanitizeValues($db->fetchByAssoc($result, $j));
			}	
		}
//Added By Yogita: 10nov17 :starts

		$this->output($request, $translatedHeaders, $entries);
	}

	/**
	 * Function that generates Export Query based on the mode
	 * @param Vtiger_Request $request
	 * @return <String> export query
	 */
	function getExportQuery(Vtiger_Request $request) {
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$mode = $request->getMode();
		$cvId = $request->get('viewname');
		$moduleName = $request->get('source_module');

		$queryGenerator = new QueryGenerator($moduleName, $currentUser);
		$queryGenerator->initForCustomViewById($cvId);
		$fieldInstances = $this->moduleFieldInstances;

        $accessiblePresenceValue = array(0,2);
		foreach($fieldInstances as $field) {
            // Check added as querygenerator is not checking this for admin users
            $presence = $field->get('presence');
            if(in_array($presence, $accessiblePresenceValue)) {
                $fields[] = $field->getName();
            }
        }
		$queryGenerator->setFields($fields);
		$query = $queryGenerator->getQuery();

		if(in_array($moduleName, getInventoryModules())){
			$query = $this->moduleInstance->getExportQuery($this->focus, $query);
		}

		$this->accessibleFields = $queryGenerator->getFields();

		switch($mode) {
			case 'ExportAllData' :	return $query;
									break;

			case 'ExportCurrentPage' :	$pagingModel = new Vtiger_Paging_Model();
										$limit = $pagingModel->getPageLimit();

										$currentPage = $request->get('page');
										if(empty($currentPage)) $currentPage = 1;

										$currentPageStart = ($currentPage - 1) * $limit;
										if ($currentPageStart < 0) $currentPageStart = 0;
										$query .= ' LIMIT '.$currentPageStart.','.$limit;

										return $query;
										break;

			case 'ExportSelectedRecords' :	$idList = $this->getRecordsListFromRequest($request);
											$baseTable = $this->moduleInstance->get('basetable');
											$baseTableColumnId = $this->moduleInstance->get('basetableid');
											if(!empty($idList)) {
												if(!empty($baseTable) && !empty($baseTableColumnId)) {
													$idList = implode(',' , $idList);
													$query .= ' AND '.$baseTable.'.'.$baseTableColumnId.' IN ('.$idList.')';
												}
											} else {
												$query .= ' AND '.$baseTable.'.'.$baseTableColumnId.' NOT IN ('.implode(',',$request->get('excluded_ids')).')';
											}
											return $query;
											break;


			default :	return $query;
						break;
		}
	}

	/**
	 * Function returns the export type - This can be extended to support different file exports
	 * @param Vtiger_Request $request
	 * @return <String>
	 */
	function getExportContentType(Vtiger_Request $request) {
		$type = $request->get('export_type');
		if(empty($type)) {
			return 'text/csv';
		}
	}

	/**
	 * Function that create the exported file
	 * @param Vtiger_Request $request
	 * @param <Array> $headers - output file header
	 * @param <Array> $entries - outfput file data
	 */
	function output($request, $headers, $entries) {
		$moduleName = $request->get('source_module');
		$fileName = str_replace(' ','_',decode_html(vtranslate($moduleName, $moduleName)));
		$exportType = $this->getExportContentType($request);

		header("Content-Disposition:attachment;filename=$fileName.csv");
		header("Content-Type:$exportType;charset=UTF-8");
		header("Expires: Mon, 31 Dec 2000 00:00:00 GMT" );
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
		header("Cache-Control: post-check=0, pre-check=0", false );

		$header = implode("\", \"", $headers);
		$header = "\"" .$header;
		$header .= "\"\r\n";
		echo $header;

		foreach($entries as $row) {
			$line = implode("\",\"",$row);
			$line = "\"" .$line;
			$line .= "\"\r\n";
			echo $line;
		}
	}

	private $picklistValues;
	private $fieldArray;
	private $fieldDataTypeCache = array();
	/**
	 * this function takes in an array of values for an user and sanitizes it for export
	 * @param array $arr - the array of values
	 */
	function sanitizeValues($arr){
		$db = PearDatabase::getInstance();
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$roleid = $currentUser->get('roleid');
		if(empty ($this->fieldArray)){
			$this->fieldArray = $this->moduleFieldInstances;
			foreach($this->fieldArray as $fieldName => $fieldObj){
				//In database we have same column name in two tables. - inventory modules only
				if($fieldObj->get('table') == 'vtiger_inventoryproductrel' && ($fieldName == 'discount_amount' || $fieldName == 'discount_percent')){
					$fieldName = 'item_'.$fieldName;
					$this->fieldArray[$fieldName] = $fieldObj;
				} else {
					$columnName = $fieldObj->get('column');
					$this->fieldArray[$columnName] = $fieldObj;
				}
			}
		}
		$moduleName = $this->moduleInstance->getName();
		foreach($arr as $fieldName=>&$value){
			if(isset($this->fieldArray[$fieldName])){
				$fieldInfo = $this->fieldArray[$fieldName];
			}else {
				unset($arr[$fieldName]);
				continue;
			}
			$value = trim(decode_html($value),"\"");
			$uitype = $fieldInfo->get('uitype');
			$fieldname = $fieldInfo->get('name');

			if(!$this->fieldDataTypeCache[$fieldName]) {
				$this->fieldDataTypeCache[$fieldName] = $fieldInfo->getFieldDataType();
			}
			$type = $this->fieldDataTypeCache[$fieldName];

			if($fieldname != 'hdnTaxType' && ($uitype == 15 || $uitype == 16 || $uitype == 33)){
				if(empty($this->picklistValues[$fieldname])){
					$this->picklistValues[$fieldname] = $this->fieldArray[$fieldname]->getPicklistValues();
				}
				// If the value being exported is accessible to current user
				// or the picklist is multiselect type.
				if($uitype == 33 || $uitype == 16 || array_key_exists($value,$this->picklistValues[$fieldname])){
					// NOTE: multipicklist (uitype=33) values will be concatenated with |# delim
					$value = trim($value);
				} else {
					$value = '';
				}
			} elseif($uitype == 52 || $type == 'owner') {
				$value = Vtiger_Util_Helper::getOwnerName($value);
			}elseif($type == 'reference'){
				$value = trim($value);
				if(!empty($value)) {
					$parent_module = getSalesEntityType($value);
					$displayValueArray = getEntityName($parent_module, $value);
					if(!empty($displayValueArray)){
						foreach($displayValueArray as $k=>$v){
							$displayValue = $v;
						}
					}
					if(!empty($parent_module) && !empty($displayValue)){
						$value = $parent_module."::::".$displayValue;
					}else{
						$value = "";
					}
				} else {
					$value = '';
				}
			} elseif($uitype == 72 || $uitype == 71) {
                $value = CurrencyField::convertToUserFormat($value, null, true, true);
			} elseif($uitype == 7 && $fieldInfo->get('typeofdata') == 'N~O' || $uitype == 9){
				$value = decimalFormat($value);
			} else if($type == 'date' || $type == 'datetime'){
                $value = DateTimeField::convertToUserFormat($value);
            }
			if($moduleName == 'Documents' && $fieldname == 'description'){
				$value = strip_tags($value);
				$value = str_replace('&nbsp;','',$value);
				array_push($new_arr,$value);
			}
		}
		return $arr;
	}
}