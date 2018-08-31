<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once('config.inc.php');
class ProjectTask_AjaxTree_Action extends Vtiger_Action_Controller{
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
	}	
	public function process(Vtiger_Request $request) {
		
		global $adb;
		$adb = PearDatabase::getInstance();
		$mode = $request->get('mode');
		$response = new Vtiger_Response();
		
		switch ($mode) {
			case "DownloadAttachment":	
				try{
					 

				} catch(Exception $e) {
					 
				}
			break; 
			case "getJsTreeForProjectTask":
				try{
					
					$projectid = $request->get('projectid');
					$selectId = $request->get('selectId');
					$query = "SELECT DISTINCT vtiger_crmentity.crmid,vtiger_projecttask.projecttasknumber,vtiger_projecttask.projecttaskname, vtiger_projecttask.projecttasktype, vtiger_crmentity.smownerid, vtiger_projecttask.projecttaskprogress, vtiger_projecttask.startdate, vtiger_projecttask.enddate,vtiger_projecttaskcf.* FROM vtiger_projecttask INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projecttask.projecttaskid INNER JOIN vtiger_project ON vtiger_project.projectid = vtiger_projecttask.projectid LEFT JOIN vtiger_projecttaskcf ON vtiger_projecttaskcf.projecttaskid = vtiger_projecttask.projecttaskid LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_projecttaskcf.pcm_active = 1 AND  vtiger_project.projectid = $projectid ";
			
			
					$task_records  = $adb->query($query); 
					
					$array_Tasks = array();
					
					 
					$key =0;
						
					while($task_record = $adb->fetch_array($task_records)) {
					
						$crmid = $task_record['crmid'];					 
						$tools = '';						
						$array_Tasks[$key]['id'] = $crmid;
						$array_Tasks[$key]['text'] = $task_record['projecttaskname'];
						$array_Tasks[$key]['parent'] = ($task_record['pcm_parent_task_id'] == '' ) ? '#' : $task_record['pcm_parent_task_id'];
						$array_Tasks[$key]['type'] = 'default';
						if($selectId != '' && $crmid == $selectId){
							$array_Tasks[$key]['state'] =  array('opened'=>true,'selected'=>true);
						} 
						$array_Tasks[$key]['data']['type'] = $task_record['projecttasktype'];
						$array_Tasks[$key]['data']['user'] = getUserFullName($task_record['smownerid']);
						$array_Tasks[$key]['data']['Budget'] = number_format($task_record['pcm_task_budget_dollars'], 2, '.', ',');
						$array_Tasks[$key]['data']['Task_Hours'] = $task_record['cf_842'];
						$array_Tasks[$key]['data']['Progress_in_Hours'] = $task_record['pcm_progress_hours'];
						$array_Tasks[$key]['data']['Progress_Allotted_Dollars'] = $task_record['pcm_progress_dollars'];
						$array_Tasks[$key]['data']['startdate'] = $task_record['startdate'];
						$array_Tasks[$key]['data']['enddate'] = $task_record['enddate'];
						$delay = 'false';				
						if($curdate > $mydate)
						{
							$delay = 'True';
						}
						$array_Tasks[$key]['data']['delay'] = $delay;
						$array_Tasks[$key]['data']['tools'] = $tools; 
						$key++;
					}
							
					echo  json_encode($array_Tasks);exit;
					
					 
				}catch(Exception $e) {
					 
				}
				 	
				break; 
				
			default:				 
		}
	}	
	
}
		