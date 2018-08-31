<?php

include_once 'modules/Users/Users.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Retrieve.php'; 

function createNewProjectTask($entity){

	global $adb;
	
	file_put_contents('stptest.txt' , print_r($entity->data,true) ) ;	

	$vtiger_data = $entity->data;
	$vtiger_data = (array)$vtiger_data;
	$id = $vtiger_data['id'];
	$id = explode('x',$id);
	$changeid = $id[1];
	
	$user = new Users();
	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
	
	$old_task_id = $vtiger_data['c_old_task_ref'];	 
	try {
		$wsid = vtws_getWebserviceEntityId('ProjectTask', $old_task_id); // Module_Webservice_ID x CRM_ID
		$ProjectTask = vtws_retrieve($wsid, $current_user);
		 
		unset($ProjectTask['id']);
		unset($ProjectTask['assigned_user_id']);
		
		$ProjectTask['startdate'] = $vtiger_data['c_start_date'];
		$ProjectTask['enddate'] = $vtiger_data['c_end_date'];
		$ProjectTask['pcm_task_budget_dollars'] = $vtiger_data['c_task_budget'];//Task Budget
		$ProjectTask['pcm_hourly_charges'] = $vtiger_data['c_hourly_charges'];//Hourly Charges
		$ProjectTask['pcm_task_budget_hours'] = $vtiger_data['c_task_budget_hours'];//Task Budget Hours	
		$ProjectTask['pcm_active'] = 1;//task active 	
		$ProjectTask['pcm_task_ref_id'] = $old_task_id;//task active 	
		$ProjectTask['assigned_user_id'] = vtws_getWebserviceEntityId("Users", 1);
		//pcm_active disable projectTask 
		$q = 'UPDATE  `vtiger_projecttaskcf` SET  `pcm_active` =  "0" WHERE  `projecttaskid` ='.$old_task_id;
		$adb->query($q);
		//create new Task 
		$ProjectTask_Data = vtws_create('ProjectTask', $ProjectTask, $current_user);
		 
		$id = $ProjectTask_Data['id'];
		$id = explode('x',$id);	 
		$data['projecttaskid'] = $id[1];
		//update new task id into change module 
		$pq = 'UPDATE  `vtiger_changecf` SET  `c_new_task_ref` =  "'.$data['projecttaskid'].'" WHERE  `changeid` ='.$changeid;
		$adb->query($pq);
		
	} catch (WebServiceException $ex) {
		echo $ex->getMessage();
	}	 	
}

?>