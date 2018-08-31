<?php

include_once 'modules/Users/Users.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Retrieve.php'; 
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';

function workStatusToManager($entity){

	global $adb;
	file_put_contents('ProjectTask.txt' , print_r($entity->data,true) ) ;	
	 
	$vtiger_data = $entity->data;
	$vtiger_data = (array)$vtiger_data;
	$id = $vtiger_data['id'];
	$id = explode('x',$id);
	
	
	$ProjectTaskId = $id[1];
	$priority_low = array('low','normal');
	$projecttaskpriority = $vtiger_data['projecttaskpriority'];//low
	$projecttaskname = $vtiger_data['projecttaskname'];
	$projecttask_no = $vtiger_data['projecttask_no'];
	$projecttaskstatus = $vtiger_data['projecttaskstatus'];
	
	//get Project name
	$pId = explode('x',$vtiger_data['projectid']); //1X1 
	$projectName = getEntityName('Project',$pId[1]);
	$projectName = $projectName[$pId[1]];
	
	//get PM Name,email
	$assigned_user_id = $vtiger_data['assigned_user_id'];//1X1
	$pm = explode('x',$assigned_user_id);
	$ProjectManager = getUserFullName($pm[1]);
	$username = getUserName($pm[1]);
	$ProjectManagerEmail = getUserEmail($pm[1]); 
	
	//current User Details
	$user = new Users();
	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
	
	// get from email 
	$query = "select from_email_field,server_username from vtiger_systems where server_type=?";
	$params = array('email');
	$result = $adb->pquery($query,$params);
	$from = $adb->query_result($result,0,'from_email_field');
	if($from == '') {$from =$adb->query_result($result,0,'server_username'); }
	 
	// query for getting assigned users  list 
	$pq = "SELECT * FROM `vtiger_usersprojecttasksrel` where projecttaskid  = ? ";
	$assigned_users_data = $adb->pquery($pq, array($ProjectTaskId)); 	
	while($userdata = $adb->fetch_array($assigned_users_data)){ 		
		print_r($userdata);	
		 
		$userid = $userdata['userid'];
		$allocated_hours = $userdata['allocated_hours'];
		$worked_hours = $userdata['worked_hours'];
		$status = $userdata['status'];
		$seq = $userdata['seq'];
		$start_date = $userdata['start_date'];
		$end_date = $userdata['end_date'];
		$notification = $userdata['notification'];
		
		if(in_array($projecttaskpriority, $priority_low))
		{
			//Alerts for low/normal priority tasks will be taken from the allotted and worked hours fields.  Once the worked hour’s field is equal to the allotted hours field, then an alert will be auto-generated in an email to the project manager,
			if($allocated_hours <= $worked_hours){ 				 
				
				$subject ='Tasks to Review';
				 
				$headers = "From:  ". $from ."\r\n";
				$headers .= "Reply-To: ". $from ."\r\n";
				$headers .= "CC: susan@example.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				$message = '<html><body>';				 
				$message .= "<p>Dear $ProjectManagerName</p>
				<p>The worked hours for <b>$projecttask_no</b> for <b>$projectName</b> has reached the maximum allotted amount.  Please review the task and sign off on its completion.</p>
				<p><b>Thanks </b></p>
				<p>BMLG Team.</p>";
				$message .= "</body></html>";			 		
				
				$mail = new PHPMailer();
				setMailerProperties($mail,$subject, $message, $from, $username, $ProjectManagerEmail);
				$status = MailSend($mail);
			}		
			
		}elseif($projecttaskpriority == 'high') {
			
			
			//High priority task alerts will be generated based on the worked hours field for each assignee (currently labelled as trainee).  Every time the worked hours reach a 20% increase, an alert will be created on the project manager’s home screen, and within an email.  For example, if 10 hours have been allotted to a task, every 2 worked hours will generate an alert as above.  
			
			//calcicate Work Progress 
			$work_progress =  round(($worked_hours/$allocated_hours)*100);
			$nextNotification = $notification + 20;
			//echo $notification;echo '<br>';
			//echo $work_progress;echo '<br>';
			//echo $nextNotification;echo '<br>';
			if(( $notification == 0 and $work_progress >= 20 ) || ($work_progress >= $nextNotification) ){ 
				 
				$subject ='Tasks to Review';			 
				$headers = "From:  ". $from ."\r\n";
				$headers .= "Reply-To: ". $from ."\r\n";
				$headers .= "CC: susan@example.com\r\n";
				$headers .= "MIME-Version: 1.0\r\n";
				$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
				
				$message = '<html><body>';				 
				$message .= "<p>Dear $ProjectManagerName</p>
				<p>This task has reached a Milestone percentage, please review to ensure that the task remains on track for completion on $end_date.</p>
				<p><b>Thanks </b></p>
				<p>BMLG Team.</p>";
				$message .= "</body></html>";			 		
				
				$mail = new PHPMailer();
				setMailerProperties($mail,$subject, $message, $from, $username, $ProjectManagerEmail);
				$status = MailSend($mail);
				if($status){
					$notification = floor($work_progress / 20);
					 $notification = $notification * 20;
					$q = 'update vtiger_usersprojecttasksrel set notification = ? where projecttaskid =? and seq =?';
					$adb->pquery($q,array($notification,$ProjectTaskId,$seq));
				}
			} 
			
		}
			
	}
}

?>