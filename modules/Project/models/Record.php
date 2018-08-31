<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

 Class Project_Record_Model extends Vtiger_Record_Model {

	/**
	 * Function to get the summary information for module
	 * @return <array> - values which need to be shown as summary
	 */
	public function getSummaryInfo() {
		$adb = PearDatabase::getInstance();
		
		$query ='SELECT smownerid,enddate,projecttaskstatus,projecttaskpriority
				FROM vtiger_projecttask
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_projecttask.projecttaskid
							AND vtiger_crmentity.deleted=0
						WHERE vtiger_projecttask.projectid = ? ';

		$result = $adb->pquery($query, array($this->getId()));

		$tasksOpen = $taskCompleted = $taskDue = $taskDeferred = $numOfPeople = 0;
        $highTasks = $lowTasks = $normalTasks = $otherTasks = 0;
		$currentDate = date('Y-m-d');
		$inProgressStatus = array('Open', 'In Progress');
		$usersList = array();

		while($row = $adb->fetchByAssoc($result)) {
			$projectTaskStatus = $row['projecttaskstatus'];
			switch($projectTaskStatus){

				case 'Open' : $tasksOpen++;
							   break;

				case 'Deferred' : $taskDeferred++;
							   break;

				case 'Completed': $taskCompleted++;
								break;
			}
            $projectTaskPriority = $row['projecttaskpriority'];
            switch($projectTaskPriority){
                case 'high' : $highTasks++;break;
                case 'low' : $lowTasks++;break;
                case 'normal' : $normalTasks++;break;
                default : $otherTasks++;break;
            }
            
			if(!empty($row['enddate']) && (strtotime($row['enddate']) < strtotime($currentDate)) &&
					(in_array($row['projecttaskstatus'], $inProgressStatus))) {
				$taskDue++;
			}
			$usersList[] = $row['smownerid'];
		}
		
		$usersList = array_unique($usersList);
		$numOfPeople = count($usersList);

		$summaryInfo['projecttaskstatus'] =  array(
			'LBL_TASKS_OPEN' => $tasksOpen,
			'Progress' => $this->get('progress'),
			'LBL_TASKS_DUE' => $taskDue,
			'LBL_TASKS_COMPLETED' => $taskCompleted,
		);
        
        $summaryInfo['projecttaskpriority'] =  array(
			'LBL_TASKS_HIGH' => $highTasks,
			'LBL_TASKS_NORMAL' => $normalTasks,
			'LBL_TASKS_LOW' => $lowTasks,
			'LBL_TASKS_OTHER' => $otherTasks,
		);
        
        return $summaryInfo;
	}

	public function getSummaryInfoProcessFlow($recordId) { 
		global $adb; 
		//$adb->setDebug(true);
		$widget_arr = array();

		#total process 
		#$q = "select pf.processflowid,pf.processmasterid from vtiger_processflow pf  left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted = 0 and pf.pf_project_id = ?";
		$q = "select count(pf.processflowid) as total from vtiger_processflow pf  left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted = 0 and pf.pf_project_id = ?";
		$result = $adb->pquery($q,array($recordId));
		$total_process = $adb->FetchByAssoc($result);
		/*if($adb->num_rows($result) > 0){
			while($cresult  = $adb->FetchByAssoc($result)){
				$fq = "SELECT count(pfu.unitprocessid) as total_process from vtiger_processflow_unitprocess pfu where pfu.processmasterid = ?";
				$tp_result = $adb->pquery($fq,array($cresult['processmasterid']));
				$tp_result = $adb->FetchByAssoc($tp_result);
				$total_process += $tp_result['total_process'];
			}
		}*/
		$widget_arr[0]['Number of Process Flows']['total'] = $total_process['total'];
		$widget_arr[0]['Number of Process Flows']['filter'] = 'all';
		

		#Process flow Not Started
		#$pns = "SELECT count(pui.unit_instanceid) as total_process_started from vtiger_processflow_unitprocess_instance pui where pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$pns = "select count(pf.processflowid) as total from vtiger_processflow pf  left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted = 0 and pf.pf_project_id = ? and pf.pf_process_status= ?";
		$pnsresult = $adb->pquery($pns,array($recordId,'Planning'));
		$pnsresult = $adb->FetchByAssoc($pnsresult);
		$widget_arr[0]['Process Flow Not Started']['total'] = $pnsresult['total'];
		$widget_arr[0]['Process Flow Not Started']['filter'] = 'Planning';

		#Process flow in progress
		/* 1 - process started, 4 - waiting for branch process  */
		#$pip = "SELECT count(pui.unit_instanceid) as process_in_progress from vtiger_processflow_unitprocess_instance pui where pui.process_status in (1,4) and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$pip = "select count(pf.processflowid) as total from vtiger_processflow pf  left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted = 0 and pf.pf_project_id = ? and pf.pf_process_status= ?";
		$pipresult = $adb->pquery($pip,array($recordId,'In Progress'));
		$pipresult = $adb->FetchByAssoc($pipresult);
		$widget_arr[0]['Process Flow In Process']['total'] = $pipresult['total'];
		$widget_arr[0]['Process Flow In Process']['filter'] = 'In Progress';

		
		#Process flow  Completed
		/* 2 - completed  */
		#$pc = "SELECT count(pui.unit_instanceid) as process_completed from vtiger_processflow_unitprocess_instance pui where pui.process_status = 2 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$pc = "select count(pf.processflowid) as total from vtiger_processflow pf  left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted = 0 and pf.pf_project_id = ? and pf.pf_process_status= ?";
		$pcresult = $adb->pquery($pc,array($recordId,'Completed'));
		$pclistitems = $adb->FetchByAssoc($pcresult);
		$widget_arr[0]['Process Flow Completed']['total'] = $pclistitems['total'];
		$widget_arr[0]['Process Flow Completed']['filter'] = 'Completed';

		
		#Pending Decision
		$pd = "SELECT count(pui.unit_instanceid) as pending_decision from vtiger_processflow_unitprocess_instance pui LEFT JOIN vtiger_processflow_unitprocess pu ON pui.unitprocessid = pu.unitprocessid where pui.process_status = 1 and pu.blocktype = 2 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$pdresult = $adb->pquery($pd,array($recordId));
		$pdlistitems = $adb->FetchByAssoc($pdresult);
		$widget_arr[1]['Pending Decision']['total'] = $pdlistitems['pending_decision'];

		#Pending Approval
		$pd = "SELECT count(pui.unit_instanceid) as pending_approval from vtiger_processflow_unitprocess_instance pui LEFT JOIN vtiger_processflow_unitprocess pu ON pui.unitprocessid = pu.unitprocessid where pui.process_status = 1 and pu.blocktype = 5 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$pdresult = $adb->pquery($pd,array($recordId));
		$pdlistitems = $adb->FetchByAssoc($pdresult);
		$widget_arr[1]['Pending Approval']['total'] = $pdlistitems['pending_approval'];


		 #Processes Completed
		/* 2 - completed  */
		$pc = "SELECT count(pui.unit_instanceid) as process_completed from vtiger_processflow_unitprocess_instance pui where pui.process_status = 2 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)"; 
		$pcresult = $adb->pquery($pc,array($recordId));
		$pclistitems = $adb->FetchByAssoc($pcresult);
		$widget_arr[1]['Task Completed']['total'] = $pclistitems['process_completed'];


		#Total Time Spent
		$pts = "SELECT pui.start_time, pui.end_time from vtiger_processflow_unitprocess_instance pui where pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$ptsresult = $adb->pquery($pts,array($recordId));$pts=0;
		$pts_arr = array();
		while($ptslistitems = $adb->FetchByAssoc($ptsresult)) {
			$start_time = $ptslistitems['start_time'];
			$end_time = $ptslistitems['end_time'];

			$start  = date_create($start_time);
			$end 	= date_create($end_time); // Current time and date
			$diff  	= date_diff( $start, $end );
			$pts_arr[$pts] = $diff->h;
			$pts++;
		}
		$total_minutes = array_sum($pts_arr);
		$hours = floor($total_minutes / 60);
		$min = $total_minutes - ($hours * 60);
		$widget_arr[1]['Total Time Spent']['total'] = $hours.":".$min;
	 

		return $widget_arr;
		
	}

	
	//added by manasa for signature start
	public function getJsignDetails() {
		global $log;
		$db = PearDatabase::getInstance();
		$imageDetails = array();
		$recordId = $this->getId();
		if ($recordId) {
			$sql = "SELECT vtiger_attachments.*, vtiger_crmentity.setype FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_attachments.attachmentsid
						WHERE vtiger_crmentity.setype = 'Project Attachment' AND vtiger_seattachmentsrel.crmid = ?";

			$result = $db->pquery($sql, array($recordId));
			$count = $db->num_rows($result);

			for($i=0; $i<$count; $i++) {
				$imageId = $db->query_result($result, $i, 'attachmentsid');
				$imagePathList[] = $db->query_result($result, $i, 'path');
				$imageName = $db->query_result($result, $i, 'name');
				$imagesubject = $db->query_result($result, $i, 'subject');
				//decode_html - added to handle UTF-8 characters in file names
				$imageOriginalNamesList[] = decode_html($imageName);

				//urlencode - added to handle special characters like #, %, etc.,
				$imageNamesList[] = '_'.$imageName;
				$imageSubjectList[] = $imagesubject;
				$imageIdsList[]  = $imageId;
			}

			if(is_array($imageOriginalNamesList)) {
				$countOfImages = count($imageOriginalNamesList);
				for($j=0; $j<$countOfImages; $j++) {
					$imageDetails[] = array(
							'id' => $imageIdsList[$j],
							'orgname' => $imageOriginalNamesList[$j],
							'path' => $imagePathList[$j].$imageIdsList[$j],
							'name' => $imageNamesList[$j],
						    'subject' => $imageSubjectList[$j]
					);
				}
			}
		}
		 
		return $imageDetails;
	}
	//added by manasa for signature end
	//added by manasa for signature start
	public function deleteSign($imageId) {
		$db = PearDatabase::getInstance();

		$checkResult = $db->pquery('SELECT crmid FROM vtiger_seattachmentsrel WHERE attachmentsid = ?', array($imageId));
		$crmId = $db->query_result($checkResult, 0, 'crmid');

		if ($this->getId() === $crmId) {
			$db->pquery('DELETE FROM vtiger_attachments WHERE attachmentsid = ?', array($imageId));
			$db->pquery('DELETE FROM vtiger_seattachmentsrel WHERE attachmentsid = ?', array($imageId));
			return true;
		}
		return false;
	}
	//added by manasa for signature end
 }
?>
