<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class MailManager_MassActionAjax_View extends Vtiger_MassActionAjax_View {

	protected function getEmailFieldsInfo(Vtiger_Request $request) {
		$sourceModules = Array();
		$linkToModule = $request->get('linktomodule');
		if (!empty($linkToModule)) {
			$selectedIds = $request->get('selected_ids');
			foreach ($selectedIds as $id) {
				if ($id) {
					$sourceModules[] = getSalesEntityType($id);
				}
			}
		} else {
			$sourceModules[] = $request->getModule();
		}

		$totalRecordCount = 0;

		foreach ($sourceModules as $sourceModule) {
			$emailFieldsInfo = array();
			$moduleModel = Vtiger_Module_Model::getInstance($sourceModule);
			$recipientPrefModel = Vtiger_RecipientPreference_Model::getInstance($sourceModule);

			if ($recipientPrefModel)
				$recipientPrefs = $recipientPrefModel->getPreferences();
			$moduleEmailPrefs = $recipientPrefs[$moduleModel->getId()];
			$emailFields = $moduleModel->getFieldsByType('email');
			$accesibleEmailFields = array();

			foreach ($emailFields as $index => $emailField) {
				$fieldName = $emailField->getName();
				if ($emailField->isViewable()) {
					if ($moduleEmailPrefs && in_array($emailField->getId(), $moduleEmailPrefs)) {
						$emailField->set('isPreferred', true);
					}
					$accesibleEmailFields[$fieldName] = $emailField;
				}
			}

			$emailFields = $accesibleEmailFields;
			if (count($emailFields) > 0) {
				$recordIds = $this->getRecordsListFromRequest($request);
				global $current_user;
				$baseTableId = $moduleModel->get('basetableid');
				$queryGen = new QueryGenerator($moduleModel->getName(), $current_user);
				$selectFields = array_keys($emailFields);
				array_push($selectFields, 'id');
				$queryGen->setFields($selectFields);
				$query = $queryGen->getQuery();
				$query = $query . ' AND crmid IN (' . generateQuestionMarks($recordIds) . ')';
				$emailOptout = $moduleModel->getField('emailoptout');
				if ($emailOptout) {
					$query .= ' AND ' . $emailOptout->get('column') . ' = 0';
				}

				$db = PearDatabase::getInstance();
				$result = $db->pquery($query, $recordIds);
				$num_rows = $db->num_rows($result);

				if ($num_rows > 0) {
					for ($i = 0; $i < $num_rows; $i++) {
						$emailFieldsList = array();
						foreach ($emailFields as $emailField) {
							$emailValue = $db->query_result($result, $i, $emailField->get('column'));
							if (!empty($emailValue)) {
								$emailFieldsList[$emailValue] = $emailField;
							}
						}
						if (!empty($emailFieldsList)) {
							$recordId = $db->query_result($result, $i, $baseTableId);
							$emailFieldsInfo[$moduleModel->getName()][$recordId] = $emailFieldsList;
						}
					}
				}
			}
			$totalRecordCount = $totalRecordCount + count($recordIds);
		}

		$viewer = $this->getViewer($request);
		$viewer->assign('RECORDS_COUNT', $totalRecordCount);

		if ($recipientPrefModel && !empty($recipientPrefs)) {
			$viewer->assign('RECIPIENT_PREF_ENABLED', true);
		}

		$viewer->assign('EMAIL_FIELDS', $emailFields);

		$viewer->assign('PREF_NEED_TO_UPDATE', $this->isPreferencesNeedToBeUpdated($request));
		return $emailFieldsInfo;
	}
function getRecordsListFromRequest(Vtiger_Request $request, $module = false) {
		$cvId = $request->get('viewname');
		$selectedIds = $request->get('selected_ids');
		$excludedIds = $request->get('excluded_ids');
        if(empty($module)) {
            $module = $request->getModule();
        }
		if(!empty($selectedIds) && $selectedIds != 'all') {
			if(!empty($selectedIds) && count($selectedIds) > 0) {
				return $selectedIds;
			}
		}
		
		$sourceRecord = $request->get('sourceRecord');
		$sourceModule = $request->get('sourceModule');
		if ($sourceRecord && $sourceModule) {
			$sourceRecordModel = Vtiger_Record_Model::getInstanceById($sourceRecord, $sourceModule);
			return $sourceRecordModel->getSelectedIdsList($module, $excludedIds);
		}

		$customViewModel = CustomView_Record_Model::getInstanceById($cvId);
		if($customViewModel) {
			$searchKey = $request->get('search_key');
			$searchValue = $request->get('search_value');
			$operator = $request->get('operator');
			if(!empty($operator)) {
				$customViewModel->set('operator', $operator);
				$customViewModel->set('search_key', $searchKey);
				$customViewModel->set('search_value', $searchValue);
			}
            $customViewModel->set('search_params', $request->get('search_params'));
			return $customViewModel->getRecordIds($excludedIds,$module);
		}
	}
	function showComposeEmailForm(Vtiger_Request $request) {
		global $log,$adb;
		//$adb->setDebug(true);
		//error_reporting(E_ERROR);
 		$moduleName = 'Emails';
		$sourceModule = "MailManager";//$request->getModule();
		$cvId = $request->get('viewname');
		$selectedIds = $request->get('selected_ids');
		$excludedIds = $request->get('excluded_ids');
		$step = $request->get('step');
		$selectedFields = $request->get('selectedFields');
		$relatedLoad = $request->get('relatedLoad');
 
		$moduleModel = Vtiger_Module_Model::getInstance($sourceModule);
		$emailFields = $moduleModel->getFieldsByType('email');
 //print_r($emailFields);
        $accesibleEmailFields = array();
        $emailColumnNames = array();
        $emailColumnModelMapping = array();

        foreach($emailFields as $index=>$emailField) {
            $fieldName = $emailField->getName();
            if($emailField->isViewable()) {
                $accesibleEmailFields[] = $emailField;
                $emailColumnNames[] = $emailField->get('column');
                $emailColumnModelMapping[$emailField->get('column')] = $emailField;
            }
        }
        $emailFields = $accesibleEmailFields;
 
        $emailFieldCount = count($emailFields);
        $tableJoined = array();
        if($emailFieldCount > 0) {
            $recordIds = $this->getRecordsListFromRequest($request);

            $moduleMeta = $moduleModel->getModuleMeta();
            $wsModuleMeta = $moduleMeta->getMeta();
            $tabNameIndexList = $wsModuleMeta->getEntityTableIndexList();

            $queryWithFromClause = 'SELECT '. implode(',',$emailColumnNames). ' FROM vtiger_crmentity ';
            foreach($emailFields as $emailFieldModel) {
                $fieldTableName = $emailFieldModel->table;
                if(in_array($fieldTableName, $tableJoined)){
                    continue;
                }

                $tableJoined[] = $fieldTableName;
                $queryWithFromClause .= ' INNER JOIN '.$fieldTableName .
                            ' ON '.$fieldTableName.'.'.$tabNameIndexList[$fieldTableName].'= vtiger_crmentity.crmid';
            }
            $query =  $queryWithFromClause . ' WHERE vtiger_crmentity.deleted = 0 AND crmid IN ('.  generateQuestionMarks($recordIds).') AND (';

            for($i=0; $i<$emailFieldCount;$i++) {
                for($j=($i+1);$j<$emailFieldCount;$j++){
                    $query .= ' (' . $emailFields[$i]->getName() .' != \'\' and '. $emailFields[$j]->getName().' != \'\')';
                    if(!($i == ($emailFieldCount-2) && $j == ($emailFieldCount-1))) {
                        $query .= ' or ';
                    }
                }
            }
            $query .=') LIMIT 1';
 

            $db = PearDatabase::getInstance();
            $result = $db->pquery($query,$recordIds);

            $num_rows = $db->num_rows($result);

            if($num_rows == 0) {
                $query = $queryWithFromClause . ' WHERE vtiger_crmentity.deleted = 0 AND crmid IN ('.  generateQuestionMarks($recordIds).') AND (';
                foreach($emailColumnNames as $index =>$columnName) {
                    $query .= " $columnName != ''";
                    //add glue or untill unless it is the last email field
                    if($index != ($emailFieldCount -1 ) ){
                        $query .= ' or ';
                    }
                }
                $query .= ') LIMIT 1';
                $result = $db->pquery($query, $recordIds);
                if($db->num_rows($result) > 0) {
                    //Expecting there will atleast one row 
                    $row = $db->query_result_rowdata($result,0);

                    foreach($emailColumnNames as $emailColumnName) {
                        if(!empty($row[$emailColumnName])) {
                            //To send only the single email field since it is only field which has value
                            $emailFields = array($emailColumnModelMapping[$emailColumnName]);
                            break;
                        }
                    }
                }else{
                    //No Record which has email field value
                    foreach($emailColumnNames as $emailColumnName) {
                        //To send only the single email field since it has no email value
                        $emailFields = array($emailColumnModelMapping[$emailColumnName]);
                        break;
                    }
                }
            }
        }

		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE', $moduleName);
        $viewer->assign('SOURCE_MODULE',$sourceModule);
		$viewer->assign('VIEWNAME', $cvId);
		$viewer->assign('SELECTED_IDS', $selectedIds);
		$viewer->assign('EXCLUDED_IDS', $excludedIds);
		$viewer->assign('EMAIL_FIELDS', $emailFields);
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
        
        $searchKey = $request->get('search_key');
        $searchValue = $request->get('search_value');
		$operator = $request->get('operator');
        if(!empty($operator)) {
			$viewer->assign('OPERATOR',$operator);
			$viewer->assign('ALPHABET_VALUE',$searchValue);
            $viewer->assign('SEARCH_KEY',$searchKey);
		}
        
        $searchParams = $request->get('search_params');
        if(!empty($searchParams)) {
            $viewer->assign('SEARCH_PARAMS',$searchParams);
        }

		$to = $request->get('to');
		if (!$to) {
			$to = array();
		}
		$viewer->assign('TO', $to);

		$parentModule = $request->get('sourceModule');
		$parentRecord = $request->get('sourceRecord');
		if (!empty($parentModule)) {
			$viewer->assign('PARENT_MODULE', $parentModule);
			$viewer->assign('PARENT_RECORD', $parentRecord);
			$viewer->assign('RELATED_MODULE', $sourceModule);
		}
		if ($relatedLoad) {
			$viewer->assign('RELATED_LOAD', true);
		}

		if($step == 'step1') {

			echo $viewer->view('MailManagerCompose.tpl', $moduleName, true);
			exit;
		}
	}

}
