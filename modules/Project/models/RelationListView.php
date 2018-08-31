<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Project_RelationListView_Model extends Vtiger_RelationListView_Model {

	public function getCreateViewUrl() {
		$createViewUrl = parent::getCreateViewUrl();
		
		$relationModuleModel = $this->getRelationModel()->getRelationModuleModel();
		if($relationModuleModel->getName() == 'HelpDesk') {
			if($relationModuleModel->getField('parent_id')->isViewable()) {
				$createViewUrl .='&parent_id='.$this->getParentRecordModel()->get('linktoaccountscontacts');
			}
		}
		return $createViewUrl;
	} 

	public function getEntries($pagingModel) {
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);

		$parentModule = $this->getParentRecordModel()->getModule();
		$relationModule = $this->getRelationModel()->getRelationModuleModel();
		$relationModuleName = $relationModule->get('name');

		$relatedColumnFields = $relationModule->getConfigureRelatedListFields();
		if(count($relatedColumnFields) <= 0){
			$relatedColumnFields = $relationModule->getRelatedListFields();
		}
		
		if($relationModuleName == 'Calendar') {
			//Adding visibility in the related list, showing records based on the visibility
			$relatedColumnFields['visibility'] = 'visibility';
		}
		
		if($relationModuleName == 'PriceBooks') {
			//Adding fields in the related list
			$relatedColumnFields['unit_price'] = 'unit_price';
			$relatedColumnFields['listprice'] = 'listprice';
			$relatedColumnFields['currency_id'] = 'currency_id';
		}
		
        if ($relationModuleName == 'Documents') {
            $relatedColumnFields['filelocationtype'] = 'filelocationtype';
            $relatedColumnFields['filestatus'] = 'filestatus';
        }
        
		$query = $this->getRelationQuery();

		if ($this->get('whereCondition')) {
			$query = $this->updateQueryWithWhereCondition($query);
		}

		$startIndex = $pagingModel->getStartIndex();
		$pageLimit = $pagingModel->getPageLimit();

		$orderBy = $this->getForSql('orderby');
		$sortOrder = $this->getForSql('sortorder');
		if($orderBy) {

            $orderByFieldModuleModel = $relationModule->getFieldByColumn($orderBy);
            if($orderByFieldModuleModel && $orderByFieldModuleModel->isReferenceField()) {
                //If reference field then we need to perform a join with crmentity with the related to field
                $queryComponents = $split = spliti(' where ', $query);
                $selectAndFromClause = $queryComponents[0];
                $whereCondition = $queryComponents[1];
                $qualifiedOrderBy = 'vtiger_crmentity'.$orderByFieldModuleModel->get('column');
                $selectAndFromClause .= ' LEFT JOIN vtiger_crmentity AS '.$qualifiedOrderBy.' ON '.
                                        $orderByFieldModuleModel->get('table').'.'.$orderByFieldModuleModel->get('column').' = '.
										$qualifiedOrderBy.'.crmid ';
										
										


                $query = $selectAndFromClause.' WHERE '.$whereCondition;
                $query .= ' ORDER BY '.$qualifiedOrderBy.'.label '.$sortOrder;
            } elseif($orderByFieldModuleModel && $orderByFieldModuleModel->isOwnerField()) {
				 $query .= ' ORDER BY COALESCE(CONCAT(vtiger_users.first_name,vtiger_users.last_name),vtiger_groups.groupname) '.$sortOrder;
			} else{
                // Qualify the the column name with table to remove ambugity
                $qualifiedOrderBy = $orderBy;
                $orderByField = $relationModule->getFieldByColumn($orderBy);
                if ($orderByField) {
					$qualifiedOrderBy = $relationModule->getOrderBySql($qualifiedOrderBy);
				}
                $query = "$query ORDER BY $qualifiedOrderBy $sortOrder";
				}
		}
 
		#process flow where condtion for Project Summery view 
		if($relationModuleName == 'ProcessFlow' && $_REQUEST['pf_process_status'] != '') { 
			$s = urldecode($_REQUEST['pf_process_status']);
			if($s != '' && $s != 'all'){
				$query = $query . " and vtiger_processflow.pf_process_status = '$s' ";
			}
		}
		

		$limitQuery = $query .' LIMIT '.$startIndex.','.$pageLimit;
		$result = $db->pquery($limitQuery, array());
		$relatedRecordList = array();
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$groupsIds = Vtiger_Util_Helper::getGroupsIdsForUsers($currentUser->getId());
		for($i=0; $i< $db->num_rows($result); $i++ ) {
			$row = $db->fetch_row($result,$i);
            $recordId = $db->query_result($result,$i,'crmid');
			$newRow = array();
			foreach($row as $col=>$val){
				if(array_key_exists($col,$relatedColumnFields)){
                   if ($relationModuleName == 'Documents' && $col == 'filename') {
                        $fileName = $db->query_result($result, $i, 'filename');
                        $downloadType = $db->query_result($result, $i, 'filelocationtype');
                        $status = $db->query_result($result, $i, 'filestatus');
                        $fileIdQuery = "select attachmentsid from vtiger_seattachmentsrel where crmid=?";

                        $fileIdRes = $db->pquery($fileIdQuery, array($recordId));

                        $fileId = $db->query_result($fileIdRes, 0, 'attachmentsid');

                        if ($fileName != '' && $status == 1) {
                            if ($downloadType == 'I') {

                                $val = '<a onclick="Javascript:Documents_Index_Js.updateDownloadCount(\'index.php?module=Documents&action=UpdateDownloadCount&record=' . $recordId . '\');"' .
                                        ' href="index.php?module=Documents&action=DownloadFile&record=' . $recordId . '&fileid=' . $fileId . '"' .
                                        ' title="' . getTranslatedString('LBL_DOWNLOAD_FILE', $relationModuleName) .
                                        '" >' . textlength_check($val) .
                                        '</a>';
                            } elseif ($downloadType == 'E') {
                                $val = '<a onclick="Javascript:Documents_Index_Js.updateDownloadCount(\'index.php?module=Documents&action=UpdateDownloadCount&record=' . $recordId . '\');"' .
                                        ' href="' . $fileName . '" target="_blank"' .
                                        ' title="' . getTranslatedString('LBL_DOWNLOAD_FILE', $relationModuleName) .
                                        '" >' . textlength_check($val) .
                                        '</a>';
                            } else {
                                $val = ' --';
                            }
                        }
                    }
                   $newRow[$relatedColumnFields[$col]] = $val;
                }
            }
			//To show the value of "Assigned to"
			$ownerId = $row['smownerid'];
			$newRow['assigned_user_id'] = $row['smownerid'];
			if($relationModuleName == 'Calendar') {
				$visibleFields = array('activitytype','date_start','time_start','due_date','time_end','assigned_user_id','visibility','smownerid','parent_id');
				$visibility = true;
				if(in_array($ownerId, $groupsIds)) {
					$visibility = false;
				} else if($ownerId == $currentUser->getId()){
					$visibility = false;
				}
				if(!$currentUser->isAdminUser() && $newRow['activitytype'] != 'Task' && $newRow['visibility'] == 'Private' && $ownerId && $visibility) {
					foreach($newRow as $data => $value) {
						if(in_array($data, $visibleFields) != -1) {
							unset($newRow[$data]);
						}
					}
					$newRow['subject'] = vtranslate('Busy','Events').'*';
				}
				if($newRow['activitytype'] == 'Task') {
					unset($newRow['visibility']);
				}
				
			}
			
			$record = Vtiger_Record_Model::getCleanInstance($relationModule->get('name'));
            $record->setData($newRow)->setModuleFromInstance($relationModule);
            $record->setId($row['crmid']);
			$relatedRecordList[$row['crmid']] = $record;
		}
		$pagingModel->calculatePageRange($relatedRecordList);

		$nextLimitQuery = $query. ' LIMIT '.($startIndex+$pageLimit).' , 1';
		$nextPageLimitResult = $db->pquery($nextLimitQuery, array());
		if($db->num_rows($nextPageLimitResult) > 0){
			$pagingModel->set('nextPageExists', true);
		}else{
			$pagingModel->set('nextPageExists', false);
		}
		return $relatedRecordList;
	}

}
