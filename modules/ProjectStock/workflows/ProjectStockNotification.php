<?php
include_once 'config.inc.php';
include_once 'modules/Users/Users.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Retrieve.php'; 
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';
function ProjectStockNotification($entity){
	
	global $adb,$site_URL;
	
	$user = new Users();
	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
	$wsId = $entity->getId();
	$parts = explode('x', $wsId);
	$recordid = $parts[1];
	//send email to Assigned User_id
	$projectid = $entity->get('projectid');
	$projectid = explode('x',$projectid);
	$projectid = $projectid[1];
	$user = new Users();

	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
	$wsid = vtws_getWebserviceEntityId('Project', $projectid); // Module_Webservice_ID x CRM_ID
	$Projectdetails = vtws_retrieve($wsid, $current_user);
	$project_no = $Projectdetails['project_no'];
	$project_name = $Projectdetails['projectname'];
	
	$q = "SELECT c.smownerid as assigned_user_id FROM vtiger_projectcf pf left join vtiger_crmentity c on pf.projectid = c.crmid where pf.projectid = ? ";	
	$result = $adb->pquery($q,array($projectid));
	$contact_email =$adb->query_result($result,0,'email');
	$contact_firstname =$adb->query_result($result,0,'firstname');
	$contact_lastname =$adb->query_result($result,0,'lastname');
	
	$org_email1 =$adb->query_result($result,0,'email1');
	$org_email2 =$adb->query_result($result,0,'email2');
	$ProjectManagerName = '';
	if($contact_email != ''){
		$ProjectManagerEmail = $contact_email;
		if($org_email1 != ''){ $cc_email = $org_email1; }elseif($org_email2 != ''){ $cc_email = $org_email2; }
		$ProjectManagerName = trim($contact_firstname .' '. $contact_lastname);
	}elseif($org_email1 != ''){
		$ProjectManagerEmail = $org_email1;
	}elseif($org_email2 != ''){
		$ProjectManagerEmail = $org_email2;
	}else{
		$Project_assigned_user_id =$adb->query_result($result,0,'assigned_user_id');
		$ProjectManagerEmail = getUserEmail($Project_assigned_user_id);
		$ProjectManagerName = getUserName($Project_assigned_user_id);
	}
	
	// get from email 
	$query = "select from_email_field,server_username from vtiger_systems where server_type=?";
	$params = array('email');
	$result = $adb->pquery($query,$params);
	$from = $adb->query_result($result,0,'from_email_field');
	if($from == '') {$from =$adb->query_result($result,0,'server_username'); } 	 
	$from_email = getUserEmail($uid);	
 	
	$username = getUserName($uid);
	if($from_email == ''){$from_email = $from;}

	//urls
	 $co_url = $site_URL."index.php?module=ProjectStock&view=Detail&record=".$recordid;
	 $Approve_url = $site_URL."ProjectStock_Owner.php?status=Approve&record=".$recordid;
	 $Reject_url = $site_URL."ProjectStock_Owner.php?status=Reject&record=".$recordid;
	
	//Sending CO Mail to PM
	$subject ="Project Stock addtion for $project_name ";				 
	$headers = "From:  ". $from_email ."\r\n";
	$headers .= "Reply-To: ". $from_email ."\r\n";
	$headers .= "CC: ". $cc_email ."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	//<p><a target='_blank' href='".$Approve_url."' style='font-family:Arial, Helvetica, sans-serif;font-size:12px; font-weight:bolder;text-decoration:none;color: #4242FD;' >Approve</a></p>
	//<p><a href='".$Reject_url."' style='font-family:Arial, Helvetica, sans-serif;font-size:12px; font-weight:bolder;text-decoration:none;color: #4242FD;' >Reject</a></p>

	$message = '<html><body>';				 
	$message .= "<p>Dear $ProjectManagerName</p>
	<p>The Project Stock Created for <b>$project_no</b> - <b>$project_name</b>.  Please review the Project Stock and Approve / Reject.</p>
	<p><a href='".$co_url."' style='font-family:Arial, Helvetica, sans-serif;font-size:12px; font-weight:bolder;text-decoration:none;color: #4242FD;' >View Project Stock for Project</a></p>

	<p><b>Thanks </b></p>
	<p>BMLG Team.</p>";
	$message .= "</body></html>";			 		
	
	$mail = new PHPMailer();
	setMailerProperties($mail,$subject, $message, $from_email, $username, $ProjectManagerEmail);
	$status = MailSend($mail);
}
?>