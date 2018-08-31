<?php

include_once 'modules/Users/Users.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Retrieve.php'; 
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';

function updateStartTimeAddFirstProcess($entity){

	global $adb; 
	$vtiger_data = $entity->data;   
	$vtiger_data = (array)$vtiger_data;
	$id = $vtiger_data['id'];
	$id = explode('x',$id);
	$id = $id[1];
	$CreatedTime = $vtiger_data['CreatedTime'];
	$processmasterid = $vtiger_data['processmasterid'];
	$assigned_user_id = explode('x',$vtiger_data['assigned_user_id']);
	$userid = $assigned_user_id[1];

	#update Start field
	$q = "update vtiger_processflow set process_flow_start_time = ? where  processflowid = ? ";
	$adb->pquery($q,array($CreatedTime,$id));
	
	#get unitprocess
	 

	//echo "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, start_time,process_status, process_instanceid,process_iteration,started_by) SELECT unitprocessid, '$CreatedTime' as start_time, 1 as process_status, $id as process_instanceid, 1 as process_iteration, $userid as started_by FROM `vtiger_processflow_unitprocess` where blocktype =7"; 
		 
	# insert new process Record 
	 
	$adb->pquery("INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, start_time,process_status, process_instanceid,process_iteration,started_by) SELECT unitprocessid, '$CreatedTime' as start_time, 1 as process_status, $id as process_instanceid, 1 as process_iteration, $userid as started_by FROM `vtiger_processflow_unitprocess` where blocktype =7 and processmasterid=$processmasterid",array()); 
}

?>