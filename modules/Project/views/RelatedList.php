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
		
			/*$query = "SELECT DISTINCT vtiger_crmentity.crmid,vtiger_projecttask.projecttasknumber,vtiger_projecttask.projecttaskname, vtiger_projecttask.projecttasktype, vtiger_crmentity.smownerid, vtiger_projecttask.projecttaskprogress, vtiger_projecttask.startdate, vtiger_projecttask.enddate,vtiger_projecttaskcf.*,vtiger_seattachmentsrel.attachmentsid,vtiger_crmentityrel.relcrmid 		
			FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON vtiger_project.projectid = vtiger_projecttask.projectid LEFT JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid  left join vtiger_seattachmentsrel ON vtiger_seattachmentsrel.crmid = vtiger_crmentity.crmid
			left join vtiger_crmentityrel  ON vtiger_crmentityrel.crmid = vtiger_crmentity.crmid
			WHERE vtiger_crmentity.deleted = 0 AND vtiger_projecttaskcf.pcm_active = 1 AND vtiger_project.projectid = $parentId "; */
			
			
			#Mandaterty fields :: enddate, projecttaskstatus
			#database_field => UI Field
			$dynamic_fields = array('projecttasktype'=>'type','smownerid'=>'Assigned_To','pcm_task_budget_dollars'=>'Budget','cf_842'=>'Task_Hours','pcm_progress_hours'=>'Progress_in_Hours','pcm_progress_dollars'=>'Progress_Allotted_Dollars','startdate'=>'startdate','enddate'=>'enddate','projecttaskstatus'=>'status');

			$UI_CO = array();
			$UI_CO['columns'] = array();
			$z = 1;
			$UI_CO['columns'][0] = array('width'=>'15%' , 'header'=>'Project Task Name');
			foreach($dynamic_fields as $key=>$val){ 
				$width = (70/count($dynamic_fields)) . '%';
				$UI_CO['columns'][$z] = array('width'=>$width, 'header'=>$val,'value'=>$val);
				$z++;
			}
			$UI_CO['columns'][$z] = array('width'=>'15%', 'header'=>'Tools','value'=>'tools');		 
			/*{
				'columns': [
					{ 'width':'15%','header': "Project Task Name" },				  
					{ 'width':'10%','header': "Type",'value': "type" },				  
					{ 'width':'7%','header': "Assigned To",'value': "Assigned_To" },				  
					{ 'width':'10%','header': "Budget",'value': "Budget" },	
					{ 'width':'5%','header': "Task Hours",'value': "Task_Hours" },	
					{ 'width':'5%','header': "Pro.H",'value': "Progress_in_Hours" },	
					{ 'width':'5%','header': "Pro.A D",'value': "Progress_Allotted_Dollars" },	
					{ 'width':'10%','header': "Start Date",'value': "startdate" },	
					{ 'width':'10%','header': "End Date",'value': "enddate" },	
					{ 'width':'5%','header': "Delay",'value': "delay" },	
					{ 'width':'15%','header': "Tools",'value': "tools"  }				  
				],
				resizable:true 
			} */



			$query = "select c.crmid, pt.projecttaskstatus,pt.projecttasknumber, pt.projecttaskname, pt.projecttasktype, c.smownerid, pt.projecttaskprogress, pt.startdate, pt.enddate, ptf . * , sa.attachmentsid, cr.relcrmid from vtiger_projecttask pt LEFT JOIN vtiger_projecttaskcf ptf ON ptf.projecttaskid = pt.projecttaskid INNER JOIN vtiger_crmentity c ON c.crmid = pt.projecttaskid LEFT JOIN vtiger_users ON vtiger_users.id = c.smownerid LEFT JOIN vtiger_groups g ON g.groupid = c.smownerid LEFT JOIN vtiger_seattachmentsrel sa ON sa.crmid = c.crmid LEFT JOIN vtiger_crmentityrel cr ON cr.crmid = c.crmid WHERE c.deleted =0 AND ptf.pcm_active =1 AND pt.projectid = $parentId ";
			
			$task_records  = $adb->query($query); 
			$task_records1  = $adb->query($query); 			
			$array_Tasks = array();			 
			$key =0;
			$crmid_array = array();
		 	while($task_record1 = $adb->fetch_array($task_records1)) {
			 	$crmid_array[] = $task_record1['crmid'];
			 }			
			$tasklist_options = array();
			$red = array();
			$green = array();
			while($task_record = $adb->fetch_array($task_records)) { 
				 
				$crmid = $task_record['crmid'];
				$taskname = $task_record['projecttaskname'];				
				$tasklist_options[$crmid] = $taskname;
				$attachmentsid = $task_record['attachmentsid'];
				$relcrmid = $task_record['relcrmid'];
				$TaskUpgradedFromId = $task_record['pcm_task_ref_id'];
			 
				$tools = "<a href='index.php?module=$relatedModuleName&view=Detail&record=$crmid&mode=showDetailViewByMode&requestMode=full'><i title='Full Details' class='icon-th-list alignMiddle'></i></a>&nbsp;";
				
				if($relationModel->isEditable()){
					$tools .= "<a href='index.php?module=$relatedModuleName&view=Edit&record=$crmid'><i title='Edit' class='icon-pencil alignMiddle'></i></a>&nbsp;";
				} 
				if ($relationModel->isDeletable()){
					$tools .= "<a id='delete_$crmid' href='javascript:void()' onclick=\"project_task_delete($crmid,'$taskname');\"><i title='Delete' class='icon-trash alignMiddle'></i></a>";
				} 							
				
				if(!empty($relcrmid)){
					//PO
					$tools .= "<a href='index.php?module=PurchaseOrder&view=Detail&record=$relcrmid' target='_blank'><i title='PO Details' class='icon-folder-open alignMiddle'></i></a>";
				}else{
					//PO
					$tools .= "<a   href='index.php?module=ProjectTask&relatedModule=PurchaseOrder&view=Detail&record=$crmid&mode=showRelatedList&tab_label=PurchaseOrder' target='_blank'><i title='Create PO' class='icon-folder-close alignMiddle'></i></a>";
				}
				 
				//CO
				//$taskname = $task_record['projecttaskname'];
				$tools .= "<a id='create_co_$crmid' href='javascript:void()' data-task='$taskname'
					onclick=\"co($crmid,'$taskname');\"><i title='Create CO' class='icon-cog alignMiddle' ></i></a>";
			
				//documents 
				//index.php?module=ProjectTask&relatedModule=Documents&view=Detail&record=165&mode=showRelatedList&tab_label=Documents
				$tools .= "<a href='index.php?module=ProjectTask&relatedModule=Documents&view=Detail&record=$crmid&mode=showRelatedList&tab_label=Documents'><i title='Documents' class='icon-file alignMiddle'></i></a>";
				
				if(!empty($TaskUpgradedFromId) && $TaskUpgradedFromId > 0){
					//Reference
					$tools .= "<a href='index.php?module=$relatedModuleName&view=Edit&record=$TaskUpgradedFromId'><i title='Reference Task' class='icon-remove-circle alignMiddle'></i></a>&nbsp;";
				}
				
				$parent_id = '#';
				if($task_record['pcm_parent_task_id'] != '' && in_array($task_record['pcm_parent_task_id'],$crmid_array)){
					$parent_id = $task_record['pcm_parent_task_id'];
				}

				
						
				$array_Tasks[$key]['id'] = $crmid;
				$array_Tasks[$key]['text'] = $taskname;
				$array_Tasks[$key]['parent'] = $parent_id;
				$array_Tasks[$key]['type'] = 'default';
				//$array_Tasks[$key][$crmid.'_anchor'] = array( "class" => "red" );
				

				#Colorizer records for Closed tasks
				
				if($task_record['enddate']){
					$pt_progress = $task_record['projecttaskstatus'];
					 
					$pt_enddate = strtotime($task_record['enddate']);				
					$today_date= strtotime(date('Y-m-d'));			

					if($pt_enddate < $today_date &&  ($pt_progress == 'In Progress' ||  $pt_progress=='Awaiting Client'))
					{
						$red[] = '#' . $crmid . '_anchor';

					}elseif($pt_progress == 'Completed'){

						$green[] = '#' . $crmid . '_anchor';

					}else{

					}
				} 
				
				//dynamic fields
				foreach($dynamic_fields as $db_field => $ui_field ){ 
				 
					if($db_field == 'smownerid'){ 
						 $formate_value =  getUserFullName($task_record[$db_field]); 
					}else if(in_array($db_field,array('pcm_task_budget_dollars','pcm_progress_hours','pcm_progress_dollars'))){
						$formate_value =  number_format($task_record[$db_field], 2, '.', ',');
					}else{
						$formate_value =  $task_record[$db_field];
					}
					$array_Tasks[$key]['data'][$ui_field] = $formate_value;
				} 

				//end
				/*$array_Tasks[$key]['data']['type'] = $task_record['projecttasktype'];
				$array_Tasks[$key]['data']['Assigned_To'] = getUserFullName($task_record['smownerid']);				
				$array_Tasks[$key]['data']['Budget'] = number_format($task_record['pcm_task_budget_dollars'], 2, '.', ',');
				$array_Tasks[$key]['data']['Task_Hours'] = $task_record['cf_842'];
				$array_Tasks[$key]['data']['Progress_in_Hours'] = number_format($task_record['pcm_progress_hours'], 2, '.', ','); 
				$array_Tasks[$key]['data']['Progress_Allotted_Dollars'] = number_format($task_record['pcm_progress_dollars'], 2, '.', ','); 
				$array_Tasks[$key]['data']['startdate'] = $task_record['startdate'];
				$array_Tasks[$key]['data']['enddate'] = $task_record['enddate'];*/
				
				$curdate=strtotime(date('Y-m-d'));
				$mydate=strtotime($task_record['enddate']);				
				$delay = 'false';				
				if($curdate > $mydate) { $delay = 'True'; 	}

				$array_Tasks[$key]['data']['delay'] = $delay;
				$array_Tasks[$key]['data']['tools'] = $tools; 
				$key++;
			}		 
			//print_r($tasklist_options);
			// $viewer->assign('SCRIPTS', $this->getHeaderScripts($request));
			$viewer->assign('COLUMN_HEADER', json_encode($UI_CO));	 
			$viewer->assign('PROJECTTASK_OPTIONS', $tasklist_options);	 
			$viewer->assign('FOLDERS_DATA', json_encode($array_Tasks));	 
			$viewer->assign('SCRIPTS', $this->getHeaderScripts($request));
			
			$viewer->assign('RED', implode(',',$red));
			$viewer->assign('GREEEN', implode(',',$green));	
		 
			return $viewer->view('RelatedListProjectTask.tpl', $moduleName, 'true'); 
			
			//end PCM
				
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
            '~/libraries/jstree/jstreegrid_new.js'
        );
        $headerScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		 
	   return $headerScriptInstances;
    }
}