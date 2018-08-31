<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_RelatedList_View extends Vtiger_Index_View {
	
	function process(Vtiger_Request $request) {
	
		$moduleName = $request->getModule();
		$relatedModuleName = $request->get('relatedModule');
		global $adb;
			global $log;
		//$adb->setDebug(true);
		if($relatedModuleName == 'ProjectTask'){ 
		 
			$parentId = $request->get('record');
			$label = $request->get('tab_label');
			$viewer = $this->getViewer($request); 
			
			$requestedPage = $request->get('page');
			if(empty($requestedPage)) {
				$requestedPage = 1;
			}

			$pagingModel = new Vtiger_Paging_Model();
			$pagingModel->set('page',$requestedPage);

			$parentRecordModel = Vtiger_Record_Model::getInstanceById($parentId, $moduleName);
			$relationListView = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $relatedModuleName, $label);
			$orderBy = $request->get('orderby');
			$sortOrder = $request->get('sortorder');
			if($sortOrder == 'ASC') {
				$nextSortOrder = 'DESC';
				$sortImage = 'icon-chevron-down';
			} else {
				$nextSortOrder = 'ASC';
				$sortImage = 'icon-chevron-up';
			}
			if(!empty($orderBy)) {
				$relationListView->set('orderby', $orderBy);
				$relationListView->set('sortorder',$sortOrder);
			}
			$models = $relationListView->getEntries($pagingModel);
			$links = $relationListView->getLinks();
			$header = $relationListView->getHeaders();
			$noOfEntries = count($models);

			$relationModel = $relationListView->getRelationModel();
			$relatedModuleModel = $relationModel->getRelationModuleModel();
			$relationField = $relationModel->getRelationField();

			//print_r($models);
			$viewer->assign('RELATED_RECORDS' , $models);
			$viewer->assign('PARENT_RECORD', $parentRecordModel);
			$viewer->assign('RELATED_LIST_LINKS', $links);
			$viewer->assign('RELATED_HEADERS', $header);
			$viewer->assign('RELATED_MODULE', $relatedModuleModel);
			$viewer->assign('RELATED_ENTIRES_COUNT', $noOfEntries);
			$viewer->assign('RELATION_FIELD', $relationField);

			if (PerformancePrefs::getBoolean('LISTVIEW_COMPUTE_PAGE_COUNT', false)) {
				$totalCount = $relationListView->getRelatedEntriesCount();
				$pageLimit = $pagingModel->getPageLimit();
				$pageCount = ceil((int) $totalCount / (int) $pageLimit);

				if($pageCount == 0){
					$pageCount = 1;
				}
				$viewer->assign('PAGE_COUNT', $pageCount);
				$viewer->assign('TOTAL_ENTRIES', $totalCount);
				$viewer->assign('PERFORMANCE', true);
			}

			$viewer->assign('MODULE', $moduleName);
			$viewer->assign('PAGING', $pagingModel);

			$viewer->assign('ORDER_BY',$orderBy);
			$viewer->assign('SORT_ORDER',$sortOrder);
			$viewer->assign('NEXT_SORT_ORDER',$nextSortOrder);
			$viewer->assign('SORT_IMAGE',$sortImage);
			$viewer->assign('COLUMN_NAME',$orderBy);

			$viewer->assign('IS_EDITABLE', $relationModel->isEditable());
			$viewer->assign('IS_DELETABLE', $relationModel->isDeletable());
			$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
			$viewer->assign('VIEW', $request->get('view'));
			
			//PCM Start
		
			$query = "SELECT DISTINCT vtiger_crmentity.crmid,vtiger_projecttask.projecttasknumber,vtiger_projecttask.projecttaskname, vtiger_projecttask.projecttasktype, vtiger_crmentity.smownerid, vtiger_projecttask.projecttaskprogress, vtiger_projecttask.startdate, vtiger_projecttask.enddate,vtiger_projecttaskcf.*,vtiger_seattachmentsrel.attachmentsid,vtiger_crmentityrel.relcrmid 		
			FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON vtiger_project.projectid = vtiger_projecttask.projectid LEFT JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid  left join vtiger_seattachmentsrel ON vtiger_seattachmentsrel.crmid = vtiger_crmentity.crmid
			left join vtiger_crmentityrel  ON vtiger_crmentityrel.crmid = vtiger_crmentity.crmid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_projecttaskcf.pcm_active = 1 AND vtiger_project.projectid = $parentId ";
			
			$task_records  = $adb->query($query); 
			
			$array_Tasks = array();
			
			 
			$key =0;
				
			while($task_record = $adb->fetch_array($task_records)) {
				//print_r($task_record);
			 
				//pcm_active 
				$crmid = $task_record['crmid'];
				//$attachmentsid = $task_record['attachmentsid'];
				$relcrmid = $task_record['relcrmid'];
				$TaskUpgradedFromId = $task_record['pcm_task_ref_id'];
			 
				$tools = "<a href='index.php?module=$relatedModuleName&view=Detail&record=$crmid&mode=showDetailViewByMode&requestMode=full'><i title='Full Details' class='icon-th-list alignMiddle'></i></a>&nbsp;";
				
				if($relationModel->isEditable()){
					$tools .= "<a href='index.php?module=$relatedModuleName&view=Edit&record=$crmid'><i title='Edit' class='icon-pencil alignMiddle'></i></a>&nbsp;";
				} 
				if ($relationModel->isDeletable()){
					$tools .= "<a class='relationDelete'><i title='Delete' class='icon-trash alignMiddle'></i></a>";
				} 							
				
				if(!empty($relcrmid)){
					//PO
					$tools .= "<a href='index.php?module=PurchaseOrder&view=Detail&record=$relcrmid' target='_blank'><i title='PO Details' class='icon-folder-open alignMiddle'></i></a>";
				}else{
					//PO
					$tools .= "<a   href='index.php?module=ProjectTask&relatedModule=PurchaseOrder&view=Detail&record=$crmid&mode=showRelatedList&tab_label=PurchaseOrder' target='_blank'><i title='Create PO' class='icon-folder-close alignMiddle'></i></a>";
				}
				 
				//CO
				$taskname = $task_record['projecttaskname'];
				$tools .= "<a id='create_co_$crmid' href='javascript:void()' data-task='$taskname'
					onclick=\"co($crmid,'$taskname');\"><i title='Create CO' class='icon-cog alignMiddle' ></i></a>";
			
				//documents 
				//index.php?module=ProjectTask&relatedModule=Documents&view=Detail&record=165&mode=showRelatedList&tab_label=Documents
				$tools .= "<a href='index.php?module=ProjectTask&relatedModule=Documents&view=Detail&record=$crmid&mode=showRelatedList&tab_label=Documents'><i title='Documents' class='icon-file alignMiddle'></i></a>";
				
				if(!empty($TaskUpgradedFromId) && $TaskUpgradedFromId > 0){
					//Reference
					$tools .= "<a href='index.php?module=$relatedModuleName&view=Edit&record=$TaskUpgradedFromId'><i title='Reference Task' class='icon-remove-circle alignMiddle'></i></a>&nbsp;";
				}
				
				
				$array_Tasks[$key]['id'] = $crmid;
				$array_Tasks[$key]['text'] = $taskname;
				$array_Tasks[$key]['parent'] = ($task_record['pcm_parent_task_id'] == '' ) ? '#' : $task_record['pcm_parent_task_id'];
				$array_Tasks[$key]['type'] = 'default';
				
				$array_Tasks[$key]['data']['type'] = $task_record['projecttasktype'];
				
				$array_Tasks[$key]['data']['user'] = getUserFullName($task_record['smownerid']);
				
				$array_Tasks[$key]['data']['Budget'] = number_format($task_record['pcm_task_budget_dollars'], 2, '.', ',');			$array_Tasks[$key]['data']['Task_Hours'] = $task_record['cf_842'];
				$array_Tasks[$key]['data']['Progress_in_Hours'] = $task_record['pcm_progress_hours'];
				$array_Tasks[$key]['data']['Progress_Allotted_Dollars'] = $task_record['pcm_progress_dollars'];
				$array_Tasks[$key]['data']['startdate'] = $task_record['startdate'];
				$array_Tasks[$key]['data']['enddate'] = $task_record['enddate'];
				
				$curdate=strtotime(date('Y-m-d'));
				$mydate=strtotime($task_record['enddate']);
				
				$delay = 'false';
				
				if($curdate > $mydate)
				{
					$delay = 'True';
				}
				$array_Tasks[$key]['data']['delay'] = $delay;
				$array_Tasks[$key]['data']['tools'] = $tools; 
				$key++;
			}		 
			  
			// $viewer->assign('SCRIPTS', $this->getHeaderScripts($request));
			$viewer->assign('FOLDERS_DATA', json_encode($array_Tasks));	 
			$viewer->assign('SCRIPTS', $this->getHeaderScripts($request));
		 //end PCM
		 
			return $viewer->view('RelatedListProjectTask.tpl', $moduleName, 'true'); 
				
		}else{ 
			/*-----------Vtiger Default--------------*/
			$parentId = $request->get('record');
			$label = $request->get('tab_label');
			$requestedPage = $request->get('page');
			if(empty($requestedPage)) {
				$requestedPage = 1;
			}

			$pagingModel = new Vtiger_Paging_Model();
			$pagingModel->set('page',$requestedPage);

			$parentRecordModel = Vtiger_Record_Model::getInstanceById($parentId, $moduleName);
			$relationListView = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $relatedModuleName, $label);
			$orderBy = $request->get('orderby');
			$sortOrder = $request->get('sortorder');
			if($sortOrder == 'ASC') {
				$nextSortOrder = 'DESC';
				$sortImage = 'icon-chevron-down';
			} else {
				$nextSortOrder = 'ASC';
				$sortImage = 'icon-chevron-up';
			}
			if(!empty($orderBy)) {
				$relationListView->set('orderby', $orderBy);
				$relationListView->set('sortorder',$sortOrder);
			}
			$models = $relationListView->getEntries($pagingModel);
			$links = $relationListView->getLinks();
			$header = $relationListView->getHeaders();
			$noOfEntries = count($models);

			$relationModel = $relationListView->getRelationModel();
			$relatedModuleModel = $relationModel->getRelationModuleModel();
			$relationField = $relationModel->getRelationField();

			$viewer = $this->getViewer($request);
			$viewer->assign('RELATED_RECORDS' , $models);
			$viewer->assign('PARENT_RECORD', $parentRecordModel);
			$viewer->assign('RELATED_LIST_LINKS', $links);
			$viewer->assign('RELATED_HEADERS', $header);
			$viewer->assign('RELATED_MODULE', $relatedModuleModel);
			$viewer->assign('RELATED_ENTIRES_COUNT', $noOfEntries);
			$viewer->assign('RELATION_FIELD', $relationField);

			if (PerformancePrefs::getBoolean('LISTVIEW_COMPUTE_PAGE_COUNT', false)) {
				$totalCount = $relationListView->getRelatedEntriesCount();
				$pageLimit = $pagingModel->getPageLimit();
				$pageCount = ceil((int) $totalCount / (int) $pageLimit);

				if($pageCount == 0){
					$pageCount = 1;
				}
				$viewer->assign('PAGE_COUNT', $pageCount);
				$viewer->assign('TOTAL_ENTRIES', $totalCount);
				$viewer->assign('PERFORMANCE', true);
			}

			$viewer->assign('MODULE', $moduleName);
			$viewer->assign('PAGING', $pagingModel);

			$viewer->assign('ORDER_BY',$orderBy);
			$viewer->assign('SORT_ORDER',$sortOrder);
			$viewer->assign('NEXT_SORT_ORDER',$nextSortOrder);
			$viewer->assign('SORT_IMAGE',$sortImage);
			$viewer->assign('COLUMN_NAME',$orderBy);

			$viewer->assign('IS_EDITABLE', $relationModel->isEditable());
			$viewer->assign('IS_DELETABLE', $relationModel->isDeletable());
			$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
			$viewer->assign('VIEW', $request->get('view'));		

			return $viewer->view('RelatedList.tpl', $moduleName, 'true');
			/*-----------Vtiger Default--------------*/
		}
	}
	
	public function getHeaderScripts(Vtiger_Request $request)
    {
		global $log;
		$log->debug('Anjaneya 213');
		$jsFileNames           = array(
            '~/libraries/jstree/jstree.js',
            '~/libraries/jstree/jstreegrid.js'
        );
        $headerScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$log->debug('Anjaneya 219');
	   return $headerScriptInstances;
    }
}