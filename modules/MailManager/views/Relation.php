<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
vimport ('~modules/MailManager/models/Message.php');
include_once 'config.php';
require_once 'include/utils/utils.php';
include_once 'include/Webservices/Query.php';
require_once 'include/Webservices/QueryRelated.php';
require_once 'includes/runtime/Cache.php';
include_once 'include/Webservices/DescribeObject.php';
require_once 'modules/Vtiger/helpers/Util.php';
include_once 'modules/Settings/MailConverter/handlers/MailScannerAction.php';
include_once 'modules/Settings/MailConverter/handlers/MailAttachmentMIME.php';
include_once 'modules/MailManager/MailManager.php';

class MailManager_Relation_View extends MailManager_Abstract_View {

	/**
	 * Used to check the MailBox connection
	 * @var Boolean
	 */
	protected $skipConnection = false;

	/** To avoid working with mailbox */
	protected function getMailboxModel() {
		if ($this->skipConnection) return false;
		return parent::getMailboxModel();
	}

	/**
	 * List of modules used to match the Email address
	 * @var Array
	 */
	static $MODULES = array ( 'Contacts', 'Accounts', 'Leads', 'HelpDesk');

	/**
	 * Process the request to perform relationship operations
	 * @global Users Instance $currentUserModel
	 * @global PearDataBase Instance $adb
	 * @global String $currentModule
	 * @param Vtiger_Request $request
	 * @return boolean
	 */
	public function process(Vtiger_Request $request) {
		global $log;
		global $adb;
		
 		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$curr_usr_id = $currentUserModel->id;//added by murali
		$response = new MailManager_Response(true);
		$viewer = $this->getViewer($request);
		$date_var = date("Y-m-d H:i:s");//added by murali


		
		if ('find' == $this->getOperationArg($request)) {
			$this->skipConnection = true; // No need to connect to mailbox here, improves performance

			// Check if the message is already linked.
			$linkedto = MailManager_Relate_Action::associatedLink($request->get('_msguid'));
$log->debug("LINE 67");
$log->debug($linkedto);
			// If the message was not linked, lookup for matching records, using FROM address unless it is in the sent folder
      $folder=$request->get('_folder');
$log->debug("LINE 71");
$log->debug($folder);	  
      if ($folder=="Sent"){
        $contacts=$request->get('_msendto');
$log->debug("LINE 75");
$log->debug($contacts);
      }else{
			  $contacts=$request->get('_mfrom');
$log->debug("LINE 79");
$log->debug($contacts);
			}
			if (empty($linkedto)) {
$log->debug("LINE 84");
$log->debug($linkedto);
				$results = array();
				$modules = array();
				$allowedModules = $this->getCurrentUserMailManagerAllowedModules();
				foreach (self::$MODULES as $MODULE) {
					if(!in_array($MODULE, $allowedModules)) continue;

					$from = $request->get('_mfrom');
					if(empty($from)) continue;
					$results[$MODULE] = $this->lookupModuleRecordsWithEmail($MODULE, $from);
					//Custom code for Related records :Start
					$q1 = $adb->pquery("select * from vtiger_leaddetails, vtiger_crmentity where (email = '{$from}' or secondaryemail = '{$from}') and vtiger_crmentity.crmid=vtiger_leaddetails.leadid and vtiger_crmentity.deleted=0", array());
					$nrows = $adb->num_rows($q1);
$log->debug("LEADS 87");
$log->debug($nrows);
 					
					$cquery = $adb->pquery("select * from vtiger_contactdetails, vtiger_crmentity where (email = '{$from}' or secondaryemail = '{$from}') and vtiger_crmentity.crmid=vtiger_contactdetails.contactid and vtiger_crmentity.deleted=0", array());
					$cnrows = $adb->num_rows($cquery);
$log->debug("CONTACTS 92");
$log->debug($cnrows); 					
 					$aquery = $adb->pquery("select * from vtiger_account, vtiger_crmentity where (email1 like '{$email}' or email2 like '{$email}') and vtiger_crmentity.crmid=vtiger_account.accountid and vtiger_crmentity.deleted=0", array());
					$anrows = $adb->num_rows($aquery);
$log->debug("ACCOUNTS 96");
$log->debug($anrows);					
					$userquery = $adb->pquery("SELECT id  FROM `vtiger_users` WHERE (email1 = '{$from}' or email2= '{$from}' or secondaryemail= '{$from}') and status='Active'", array());
					$userrows = $adb->num_rows($userquery);
					
					$inactiveq = $adb->pquery("SELECT id  FROM `vtiger_users` WHERE (email1 = '{$from}' or email2= '{$from}' or secondaryemail= '{$from}') and status='Inactive'", array());
					$inactiverow = $adb->num_rows($inactiveq);
					
 				if($inactiverow == 0 || $inactiverow > 0){
					
				}
				$log->debug("USER ROWS");
				$log->debug($userrows);
				$mailmanrows = array("Leadrows"=>$nrows,"Contactrows"=>$cnrows,"accountrows"=>$anrows);
				$log->debug($mailmanrows);
				if($userrows == 0){		
					if($nrows >= 0 && $cnrows >= 0 && !$anrows){// 122 line commented
					$log->debug("CONDITION contact and lead");	 
 					$lcrmid = $adb->pquery("SELECT MAX(crmid) AS cid FROM vtiger_crmentity", array());
					$lastcrmid = $adb->query_result($lcrmid, 0, "cid");
 					$lastcrmid++;					
 					$fmailid = '["'.$from.'"]';
					$dl = $adb->pquery("SELECT msubject AS ms, mbody AS mb, mto AS mt from vtiger_mailmanager_mailrecord where  mdate =(select max(mdate) from vtiger_mailmanager_mailrecord where mfrom = '{$fmailid}')", array());
					$sub = $adb->query_result($dl, 0, "ms");
					$bdy = $adb->query_result($dl, 0, "mb");
					$mto = $adb->query_result($dl, 0, "mt");
 					
					$insertCRM = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,viewedtime, status, version, presence, deleted, label) values(?,?,?,?,?,?,?,?,?
					,?,?,?,?,?)";
					$params1 = array($lastcrmid,$curr_usr_id,$curr_usr_id,$curr_usr_id,'Emails',html_entity_decode($bdy),$date_var,$date_var,null,null,0,1,0,html_entity_decode($sub));
					$IC = $adb->pquery($insertCRM, $params1);
					$conid = $results['Contacts'][0]['id'];
 					
					$updatecrmseqquery = "UPDATE vtiger_crmentity_seq SET id=?";
					$updtCS = $adb->pquery($updatecrmseqquery, array($lastcrmid));
										
					$sbjct = html_entity_decode($sub);					
					$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$sbjct."'";
					$emid = $adb->pquery($cqury, array());
					$email_id = $adb->query_result($emid, 0, "emid");
 					
					$insertEmail = "insert into vtiger_emaildetails (emailid, from_email, to_email, cc_email, bcc_email, assigned_user_email, idlists, email_flag) values (?,?,?,?,?,?,?,?)";
					$params2 = array($email_id,$from,html_entity_decode($mto),'[""]','[""]',' ',$conid.'@-1|','MailManager');
					$IE = $adb->pquery($insertEmail, $params2);
 					
					$insertMailrel = "insert into vtiger_mailmanager_mailrel (mailuid,crmid,emailid) values (?,?,?)";
					$params3 = array(html_entity_decode($request->get('_msguid')),$conid,$email_id);
					$MREL = $adb->pquery($insertMailrel, $params3);
 					
					$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$params4 = array($email_id,html_entity_decode($sub),'Contacts','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
					$ACT = $adb->pquery($insertAct, $params4);
 					
					$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
					$params5 = array($conid,$email_id);
					$SEACT = $adb->pquery($insertSEAct, $params5);
 					break;
			
					}elseif($nrows >= 0 && !$cnrows && $anrows >= 0){
$log->debug("CONDITION accounts and leads");

 					require_once 'modules/Contacts/Contacts.php';
					$contact = new Contacts();
					$lname = explode("@",$from);
					$contact->column_fields['lastname'] = $lname[0];
					$contact->column_fields['email'] = $from;
					$contact->column_fields['description'] = "This is created by custom code";
					$contact->save('Contacts');
					
					$lcrmid = $adb->pquery("SELECT MAX(crmid) AS cid FROM vtiger_crmentity", array());
					$lastcrmid = $adb->query_result($lcrmid, 0, "cid");
					$lastcrmid++;					
					
					$dl = $adb->pquery("SELECT msubject AS ms, mbody AS mb, mto AS mt from vtiger_mailmanager_mailrecord where mdate =(select max(mdate) from vtiger_mailmanager_mailrecord)", array());
					$sub = $adb->query_result($dl, 0, "ms");
					$bdy = $adb->query_result($dl, 0, "mb");
					$mto = $adb->query_result($dl, 0, "mt");
					
					$insertCRM = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,viewedtime, status, version, presence, deleted, label) values(?,?,?,?,?,?,?,?,?
					,?,?,?,?,?)";
					$params1 = array($lastcrmid,$curr_usr_id,$curr_usr_id,$curr_usr_id,'Emails',html_entity_decode($bdy),$date_var,$date_var,null,null,0,1,0,html_entity_decode($sub));
					$IC = $adb->pquery($insertCRM, $params1);
					
					$updatecrmseqquery = "UPDATE vtiger_crmentity_seq SET id=?";
					$updtCS = $adb->pquery($updatecrmseqquery, array($lastcrmid));
					
					$cqury = "SELECT MAX(contactid) AS cid FROM vtiger_contactdetails where email='".$from."'";
					$contactid = $adb->pquery($cqury, array());
					$cid = $adb->query_result($contactid, 0, "cid");
					
					$sbjct = html_entity_decode($sub);					
					$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$sbjct."'";
					$emid = $adb->pquery($cqury, array());
					$email_id = $adb->query_result($emid, 0, "emid");
					
					$insertEmail = "insert into vtiger_emaildetails (emailid, from_email, to_email, cc_email, bcc_email, assigned_user_email, idlists, email_flag) values (?,?,?,?,?,?,?,?)";
					$params2 = array($email_id,$from,html_entity_decode($mto),'[""]','[""]',' ',$cid.'@-1|','MailManager');
					$IE = $adb->pquery($insertEmail, $params2);
					
					$insertMailrel = "insert into vtiger_mailmanager_mailrel (mailuid,crmid,emailid) values (?,?,?)";
					$params3 = array(html_entity_decode($request->get('_msguid')),$cid,$email_id);
					$MREL = $adb->pquery($insertMailrel, $params3);				
					
					$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$params4 = array($email_id,html_entity_decode($sub),'Contacts','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
					$ACT = $adb->pquery($insertAct, $params4);
					
					$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
					$params5 = array($cid,$email_id);
					$SEACT = $adb->pquery($insertSEAct, $params5);
					break;
				
					
					}elseif(!$nrows  && $cnrows >= 0 && $anrows >= 0 ){
$log->debug("CONDITION accounts and contacts");

 					$lcrmid = $adb->pquery("SELECT MAX(crmid) AS cid FROM vtiger_crmentity", array());
					$lastcrmid = $adb->query_result($lcrmid, 0, "cid");
 					$lastcrmid++;					
 					$fmailid = '["'.$from.'"]';
					$dl = $adb->pquery("SELECT msubject AS ms, mbody AS mb, mto AS mt from vtiger_mailmanager_mailrecord where  mdate =(select max(mdate) from vtiger_mailmanager_mailrecord where mfrom = '{$fmailid}')", array());
					$sub = $adb->query_result($dl, 0, "ms");
					$bdy = $adb->query_result($dl, 0, "mb");
					$mto = $adb->query_result($dl, 0, "mt");
 					
					$insertCRM = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,viewedtime, status, version, presence, deleted, label) values(?,?,?,?,?,?,?,?,?
					,?,?,?,?,?)";
					$params1 = array($lastcrmid,$curr_usr_id,$curr_usr_id,$curr_usr_id,'Emails',html_entity_decode($bdy),$date_var,$date_var,null,null,0,1,0,html_entity_decode($sub));
					$IC = $adb->pquery($insertCRM, $params1);
					$contid = $results['Contacts'][0]['id'];
 					
					$updatecrmseqquery = "UPDATE vtiger_crmentity_seq SET id=?";
					$updtCS = $adb->pquery($updatecrmseqquery, array($lastcrmid));
										
					$sbjct = html_entity_decode($sub);					
					$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$sbjct."'";
					$emid = $adb->pquery($cqury, array());
					$email_id = $adb->query_result($emid, 0, "emid");
 					
					$insertEmail = "insert into vtiger_emaildetails (emailid, from_email, to_email, cc_email, bcc_email, assigned_user_email, idlists, email_flag) values (?,?,?,?,?,?,?,?)";
					$params2 = array($email_id,$from,html_entity_decode($mto),'[""]','[""]',' ',$contid.'@-1|','MailManager');
					$IE = $adb->pquery($insertEmail, $params2);
 					
					$insertMailrel = "insert into vtiger_mailmanager_mailrel (mailuid,crmid,emailid) values (?,?,?)";
					$params3 = array(html_entity_decode($request->get('_msguid')),$aocid,$email_id);
					$MREL = $adb->pquery($insertMailrel, $params3);
 					
					$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$params4 = array($email_id,html_entity_decode($sub),'Contacts','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
					$ACT = $adb->pquery($insertAct, $params4);
 					
					$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
					$params5 = array($contid,$email_id);
					$SEACT = $adb->pquery($insertSEAct, $params5);
 					break;
					//if mail is related only to existing lead	
					
					
					}elseif($nrows >= 0 && !$cnrows && !$anrows){
$log->debug("CONDITION existing lead");
 					$lcrmid = $adb->pquery("SELECT MAX(crmid) AS cid FROM vtiger_crmentity", array());
					$lastcrmid = $adb->query_result($lcrmid, 0, "cid");

 					$lastcrmid++;	
					
 					$fmailid = '["'.$from.'"]';
					$dl = $adb->pquery("SELECT msubject AS ms, mbody AS mb, mto AS mt from vtiger_mailmanager_mailrecord where  mdate =(select max(mdate) from vtiger_mailmanager_mailrecord where mfrom = '{$fmailid}')", array());
					$sub = $adb->query_result($dl, 0, "ms");
					$bdy = $adb->query_result($dl, 0, "mb");
					$mto = $adb->query_result($dl, 0, "mt");
 					
					$check_exist = $adb->pquery("SELECT * FROM vtiger_crmentity WHERE setype =? AND label =? AND description=?",array('Emails',html_entity_decode($sub),html_entity_decode($bdy)));
					$check_exist_row = $adb->num_rows($check_exist);
					if($check_exist_row == 0){
						$insertCRM = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,viewedtime, status, version, presence, deleted, label) values(?,?,?,?,?,?,?,?,?
					,?,?,?,?,?)";
					$params1 = array($lastcrmid,$curr_usr_id,$curr_usr_id,$curr_usr_id,'Emails',html_entity_decode($bdy),$date_var,$date_var,null,null,0,1,0,html_entity_decode($sub));
					$IC = $adb->pquery($insertCRM, $params1);
					
					$query = $adb->pquery("SELECT * FROM vtiger_leaddetails, vtiger_crmentity WHERE (email = '{$from}' OR secondaryemail = '{$from}') AND vtiger_crmentity.crmid=vtiger_leaddetails.leadid AND vtiger_crmentity.deleted=0", array());
					
						$q3rows = $adb->num_rows($query);

						for($j=0; $j<$q3rows; $j++){
							
							$leadid = $adb->query_result($query,$j,'leadid');
							
							$updatecrmseqquery = "UPDATE vtiger_crmentity_seq SET id=?";
							$updtCS = $adb->pquery($updatecrmseqquery, array($lastcrmid));
												
							$sbjct = html_entity_decode($sub);					
							$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$sbjct."'";
							$emid = $adb->pquery($cqury, array());
							$email_id = $adb->query_result($emid, 0, "emid");
							
							$insertEmail = "insert into vtiger_emaildetails (emailid, from_email, to_email, cc_email, bcc_email, assigned_user_email, idlists, email_flag) values (?,?,?,?,?,?,?,?)";
							$params2 = array($email_id,$from,html_entity_decode($mto),'[""]','[""]',' ',$leadid.'@-1|','MailManager');
							$IE = $adb->pquery($insertEmail, $params2);
						
							$insertMailrel = "insert into vtiger_mailmanager_mailrel (mailuid,crmid,emailid) values (?,?,?)";
							$params3 = array(html_entity_decode($request->get('_msguid')),$leadid,$email_id);
							$MREL = $adb->pquery($insertMailrel, $params3);
							
							$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$params4 = array($email_id,html_entity_decode($sub),'Leads','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
							$ACT = $adb->pquery($insertAct, $params4);
							
							$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
							$params5 = array($leadid,$email_id);
							$SEACT = $adb->pquery($insertSEAct, $params5);

							break;	
						}
					}
					
 					
					//if mail is related only to contact	
					
					//}elseif(sizeof($results['Leads']) == 0 && sizeof($results['Contacts']) > 0 && sizeof($results['Accounts']) == 0 ){
					//}elseif(is_null($results['Leads']) == '' && is_null($results['Contacts']) > 0 && is_null($results['Accounts']) == '' ){
					}elseif(!$nrows && $cnrows > 0 && !$anrows ){
$log->debug("CONDITION existing contact");						
 					$lcrmid = $adb->pquery("SELECT MAX(crmid) AS cid FROM vtiger_crmentity", array());
					$lastcrmid = $adb->query_result($lcrmid, 0, "cid");
 					$lastcrmid++;					
 					$fmailid = '["'.$from.'"]';
					$dl = $adb->pquery("SELECT msubject AS ms, mbody AS mb, mto AS mt from vtiger_mailmanager_mailrecord where  mdate =(select max(mdate) from vtiger_mailmanager_mailrecord where mfrom = '{$fmailid}')", array());
					$sub = $adb->query_result($dl, 0, "ms");
					$bdy = $adb->query_result($dl, 0, "mb");
					$mto = $adb->query_result($dl, 0, "mt");
 					
					$insertCRM = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,viewedtime, status, version, presence, deleted, label) values(?,?,?,?,?,?,?,?,?
					,?,?,?,?,?)";
					$params1 = array($lastcrmid,$curr_usr_id,$curr_usr_id,$curr_usr_id,'Emails',html_entity_decode($bdy),$date_var,$date_var,null,null,0,1,0,html_entity_decode($sub));
					$IC = $adb->pquery($insertCRM, $params1);
					
					$query_1 = $adb->pquery("SELECT * FROM vtiger_contactdetails, vtiger_crmentity WHERE (email = '{$from}' OR secondaryemail = '{$from}') AND vtiger_crmentity.crmid = vtiger_contactdetails.contactid AND vtiger_crmentity.deleted=0", array());
						$q1rows = $adb->num_rows($query_1);
						for($j=0; $j<=$q1rows; $j++){
							$contactid = $adb->query_result($query_1,$j,'contactid');
							
							$updatecrmseqquery = "UPDATE vtiger_crmentity_seq SET id=?";
							$updtCS = $adb->pquery($updatecrmseqquery, array($lastcrmid));
												
							$sbjct = html_entity_decode($sub);					
							$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$sbjct."'";
							$emid = $adb->pquery($cqury, array());
							$email_id = $adb->query_result($emid, 0, "emid");
							
							$insertEmail = "insert into vtiger_emaildetails (emailid, from_email, to_email, cc_email, bcc_email, assigned_user_email, idlists, email_flag) values (?,?,?,?,?,?,?,?)";
							$params2 = array($email_id,$from,html_entity_decode($mto),'[""]','[""]',' ',$contactid.'@-1|','MailManager');
							$IE = $adb->pquery($insertEmail, $params2);
							
							$insertMailrel = "insert into vtiger_mailmanager_mailrel (mailuid,crmid,emailid) values (?,?,?)";
							$params3 = array(html_entity_decode($request->get('_msguid')),$contactid,$email_id);
							$MREL = $adb->pquery($insertMailrel, $params3);
							
							$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
							$params4 = array($email_id,html_entity_decode($sub),'Contacts','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
							$ACT = $adb->pquery($insertAct, $params4);
							
							$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
							$params5 = array($contactid,$email_id);
							$SEACT = $adb->pquery($insertSEAct, $params5);
							break;
						}
					//$ctid = $results['Contacts'][0]['id'];
 					
					
					//if mail is related only to account	
					
					//}elseif(sizeof($results['Leads']) == 0 && sizeof($results['Contacts']) == 0 && sizeof($results['Accounts']) > 0 ){
					//}elseif(is_null($results['Leads']) == '' && is_null($results['Contacts']) == '' && is_null($results['Accounts']) > 0 ){
					}elseif(!$nrows && !$cnrows && $anrows > 0 ){
$log->debug("CONDITION existing account");	
				
					require_once 'modules/Contacts/Contacts.php';
					$Contact = new Contacts();
					$lname = explode("@",$from);
					$Contact->column_fields['lastname'] = $lname[0];
					$Contact->column_fields['email'] = $from;
					$Contact->column_fields['description'] = "This is created by custom code";
					$Contact->save('Contacts');
					
					$lcrmid = $adb->pquery("SELECT MAX(crmid) AS cid FROM vtiger_crmentity", array());
					$lastcrmid = $adb->query_result($lcrmid, 0, "cid");
					$lastcrmid++;					
					
					$dl = $adb->pquery("SELECT msubject AS ms, mbody AS mb, mto AS mt from vtiger_mailmanager_mailrecord where mdate =(select max(mdate) from vtiger_mailmanager_mailrecord)", array());
					$sub = $adb->query_result($dl, 0, "ms");
					$bdy = $adb->query_result($dl, 0, "mb");
					$mto = $adb->query_result($dl, 0, "mt");
					
					$insertCRM = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,viewedtime, status, version, presence, deleted, label) values(?,?,?,?,?,?,?,?,?
					,?,?,?,?,?)";
					$params1 = array($lastcrmid,$curr_usr_id,$curr_usr_id,$curr_usr_id,'Emails',html_entity_decode($bdy),$date_var,$date_var,null,null,0,1,0,html_entity_decode($sub));
					$IC = $adb->pquery($insertCRM, $params1);
					
					$updatecrmseqquery = "UPDATE vtiger_crmentity_seq SET id=?";
					$updtCS = $adb->pquery($updatecrmseqquery, array($lastcrmid));
					
					$cqury = "SELECT MAX(contactid) AS cid FROM vtiger_contactdetails where email='".$from."'";
					$contactid = $adb->pquery($cqury, array());
					$cid = $adb->query_result($contactid, 0, "cid");
					
					$sbjct = html_entity_decode($sub);					
					$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$sbjct."'";
					$emid = $adb->pquery($cqury, array());
					$email_id = $adb->query_result($emid, 0, "emid");
					
					$insertEmail = "insert into vtiger_emaildetails (emailid, from_email, to_email, cc_email, bcc_email, assigned_user_email, idlists, email_flag) values (?,?,?,?,?,?,?,?)";
					$params2 = array($email_id,$from,html_entity_decode($mto),'[""]','[""]',' ',$cid.'@-1|','MailManager');
					$IE = $adb->pquery($insertEmail, $params2);
					
					$insertMailrel = "insert into vtiger_mailmanager_mailrel (mailuid,crmid,emailid) values (?,?,?)";
					$params3 = array(html_entity_decode($request->get('_msguid')),$cid,$email_id);
					$MREL = $adb->pquery($insertMailrel, $params3);				
					
					$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
					$params4 = array($email_id,html_entity_decode($sub),'Contacts','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
					$ACT = $adb->pquery($insertAct, $params4);
					
					$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
					$params5 = array($cid,$email_id);
					$SEACT = $adb->pquery($insertSEAct, $params5);
					break;
					
					}
				}
						
					//$markread = $connector->markMailRead($request->get('_msgno'));//to mark mail as read

					//Custom code for Related records :Stop
					$describe = $this->ws_describe($MODULE);
					$modules[$MODULE] = array('label' => $describe['label'], 'name' => textlength_check($describe['name']), 'id' => $describe['idPrefix'] );

					// If look is found in a module, skip rest. - for performance
					if (!empty($results[$MODULE])) break;
				}
				$viewer->assign('LOOKUPS', $results);
				$viewer->assign('MODULES', $modules);
			} else {
				$viewer->assign('LINKEDTO', $linkedto);
			}

			$viewer->assign('LINK_TO_AVAILABLE_ACTIONS', $this->linkToAvailableActions());
			$viewer->assign('ALLOWED_MODULES', $allowedModules);
			$viewer->assign('MSGNO', $request->get('_msgno'));
			$viewer->assign('FOLDER', $request->get('_folder'));

			$response->setResult( array( 'ui' => $viewer->view( 'Relationship.tpl', 'MailManager', true ) ) );

		} else if ('link' == $this->getOperationArg($request)) {

			$linkto = $request->get('_mlinkto');
			$foldername = $request->get('_folder');
			$connector = $this->getConnector($foldername);

			// This is to handle larger uploads
			$memory_limit = MailManager_Config_Model::get('MEMORY_LIMIT');
			ini_set('memory_limit', $memory_limit);

			$mail = $connector->openMail($request->get('_msgno'), $foldername);
			$mail->attachments(); // Initialize attachments

			$linkedto = MailManager_Relate_Action::associate($mail, $linkto);

			$viewer->assign('LINK_TO_AVAILABLE_ACTIONS', $this->linkToAvailableActions());
			$viewer->assign('ALLOWED_MODULES', $this->getCurrentUserMailManagerAllowedModules());
			$viewer->assign('LINKEDTO', $linkedto);
			$viewer->assign('MSGNO', $request->get('_msgno'));
			$viewer->assign('FOLDER', $foldername);
			$response->setResult( array( 'ui' => $viewer->view( 'Relationship.tpl', 'MailManager', true ) ) );

		} else if ('create_wizard' == $this->getOperationArg($request)) {
			$moduleName = $request->get('_mlinktotype');
			if(!vtlib_isModuleActive($moduleName) && $moduleName != 'Events') {
				$response->setResult(array('error'=>vtranslate('LBL_OPERATION_NOT_PERMITTED', $moduleName)));
				return $response;
			}
			if($moduleName == 'Events' && !vtlib_isModuleActive('Calendar')) {
				$response->setResult(array('error'=>vtranslate('LBL_OPERATION_NOT_PERMITTED', $moduleName)));
				return $response;
			}
			$parent =  $request->get('_mlinkto');
			$foldername = $request->get('_folder');

			$connector = $this->getConnector($foldername);
			$mail = $connector->openMail($request->get('_msgno'), $foldername);
			$folder = $connector->folderInstance($foldername);
			$isSentFolder = $folder->isSentFolder();
			$formData = $this->processFormData($mail, $isSentFolder);
			foreach ($formData as $key => $value) {
				$request->set($key, $value);
			}

			$linkedto = MailManager_Relate_Action::getSalesEntityInfo($parent);
			switch ($moduleName) {
				case 'HelpDesk' :   $from = $mail->from();
									if ($parent) {
										if($linkedto['module'] == 'Contacts') {
											$referenceFieldName = 'contact_id';
										} elseif ($linkedto['module'] == 'Accounts') {
											$referenceFieldName = 'parent_id';
										}
										$request->set($referenceFieldName, $this->setParentForHelpDesk($parent, $from));
									}
									break;
				case 'Events'	:
				case 'Calendar' :   if ($parent) {
										if($linkedto['module'] == 'Contacts') {
											$referenceFieldName = 'contact_id';
										} elseif ($linkedto['module'] == 'Accounts') {
											$referenceFieldName = 'parent_id';
										}
										$request->set($referenceFieldName, $parent);
									}
									break;
			}

			$request->set('module', $moduleName);

			// Delegate QuickCreate FormUI to the target view controller of module.
			$quickCreateviewClassName = $moduleName . '_QuickCreateAjax_View';
			if (!class_exists($quickCreateviewClassName)) {
				$quickCreateviewClassName = 'Vtiger_QuickCreateAjax_View';
			}
			$quickCreateViewController = new $quickCreateviewClassName();
			$quickCreateViewController->process($request);

			// UI already sent
			$response = false;

		} else if ('create' == $this->getOperationArg($request)) {
			$linkModule = $request->get('_mlinktotype');

			if(!vtlib_isModuleActive($linkModule)) {
				$response->setResult(array('ui'=>'', 'error'=>vtranslate('LBL_OPERATION_NOT_PERMITTED', $moduleName)));
				return $response;
			}

			$parent =  $request->get('_mlinkto');
			$foldername = $request->get('_folder');

			if(!empty($foldername)) {
				// This is to handle larger uploads
				$memory_limit = MailManager_Config_Model::get('MEMORY_LIMIT');
				ini_set('memory_limit', $memory_limit);

				$connector = $this->getConnector($foldername);
				$mail = $connector->openMail($request->get('_msgno'), $foldername);
				$attachments = $mail->attachments(); // Initialize attachments
			}

			$linkedto = MailManager_Relate_Action::getSalesEntityInfo($parent);
			$recordModel = Vtiger_Record_Model::getCleanInstance($linkModule);

			$fields = $recordModel->getModule()->getFields();
			foreach ($fields as $fieldName => $fieldModel) {
				if ($request->has($fieldName)) {
					$fieldValue = $request->get($fieldName);
					$fieldDataType = $fieldModel->getFieldDataType();
					if($fieldDataType == 'time') {
						$fieldValue = Vtiger_Time_UIType::getTimeValueWithSeconds($fieldValue);
					}
					$recordModel->set($fieldName, $fieldValue);
				}
			}

			// Newly added field for source of created record
			if($linkModule != "ModComments"){
				$recordModel->set('source','Mail Manager');
			}

			switch ($linkModule) {
				case 'Calendar' :   $activityType = $recordModel->get('activitytype');
									if (!$activityType) {
										$activityType = 'Task';
									}
									$recordModel->set('activitytype', $activityType);

									//Start Date and Time values
									$startTime = Vtiger_Time_UIType::getTimeValueWithSeconds($request->get('time_start'));
									$startDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('date_start')." ".$startTime);
									list($startDate, $startTime) = explode(' ', $startDateTime);

									$recordModel->set('date_start', $startDate);
									$recordModel->set('time_start', $startTime);

									//End Date and Time values
									$endDate = Vtiger_Date_UIType::getDBInsertedValue($request->get('due_date'));
									if ($activityType != 'Task') {
										$endTime = Vtiger_Time_UIType::getTimeValueWithSeconds($request->get('time_end'));
										$endDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('due_date')." ".$endTime);
										list($endDate, $endTime) = explode(' ', $endDateTime);
									} else {
										$endTime = '';
									}
									$recordModel->set('time_end', $endTime);
									$recordModel->set('due_date', $endDate);

									if($parent) {
										if($linkedto['module'] == 'Contacts') {
											$recordModel->set('contact_id', $parent);
										} else {
											$recordModel->set('parent_id', $parent);
										}
									}
									$recordModel->set('visibility', 'Public');
									break;

				case 'HelpDesk' :   $from = $mail->from();
									if ($parent) {
										if($linkedto['module'] == 'Contacts') {
											$referenceFieldName = 'contact_id';
										} elseif ($linkedto['module'] == 'Accounts') {
											$referenceFieldName = 'parent_id';
										}
									}
									if(!$request->has($referenceFieldName)) {
										$recordModel->set($referenceFieldName, $this->setParentForHelpDesk($parent, $from));
									}
									break;

				case 'ModComments': $recordModel->set('assigned_user_id', $currentUserModel->getId());
									$recordModel->set('commentcontent', $request->getRaw('commentcontent'));
									$recordModel->set('userid', $currentUserModel->getId());
									$recordModel->set('creator', $currentUserModel->getId());
									$recordModel->set('related_to', $parent);
									break;
			}

			try {
				$recordModel->save();

				// This condition is added so that emails are not created for Tickets and Todo without Parent,
				// as there is no way to relate them
				if(empty($parent) && $linkModule != 'HelpDesk' && $linkModule != 'Calendar') {
					$linkedto = MailManager_Relate_Action::associate($mail, $recordModel->getId());
				}

				if ($linkModule === 'Calendar') {
					// Handled to save follow up event
					$followupMode = $request->get('followup');

					//Start Date and Time values
					$startTime = Vtiger_Time_UIType::getTimeValueWithSeconds($request->get('followup_time_start'));
					$startDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('followup_date_start') . " " . $startTime);
					list($startDate, $startTime) = explode(' ', $startDateTime);

					$subject = $request->get('subject');
					if($followupMode == 'on' && $startTime != '' && $startDate != '') {
						$recordModel->set('eventstatus', 'Planned');
						$recordModel->set('subject', '[Followup] '.$subject);
						$recordModel->set('date_start', $startDate);
						$recordModel->set('time_start', $startTime);

						$currentUser = Users_Record_Model::getCurrentUserModel();
						$activityType = $recordModel->get('activitytype');
						if($activityType == 'Call') {
							$minutes = $currentUser->get('callduration');
						} else {
							$minutes = $currentUser->get('othereventduration');
						}
						$dueDateTime = date('Y-m-d H:i:s', strtotime("$startDateTime+$minutes minutes"));
						list($startDate, $startTime) = explode(' ', $dueDateTime);

						$recordModel->set('due_date', $startDate);
						$recordModel->set('time_end', $startTime);
						$recordModel->set('recurringtype', '');
						$recordModel->set('mode', 'create');
						$recordModel->save();
					}
				}

				// add attachments to the tickets as Documents
				if($linkModule == 'HelpDesk' && !empty($attachments)) {
					$relationController = new MailManager_Relate_Action();
					$relationController->__SaveAttachements($mail, $linkModule, $recordModel);
				}

				$viewer->assign('MSGNO', $request->get('_msgno'));
				$viewer->assign('LINKEDTO', $linkedto);
				$viewer->assign('ALLOWED_MODULES', $this->getCurrentUserMailManagerAllowedModules());
				$viewer->assign('LINK_TO_AVAILABLE_ACTIONS', $this->linkToAvailableActions());
				$viewer->assign('FOLDER', $foldername);

				$response->setResult( array( 'ui' => $viewer->view( 'Relationship.tpl', 'MailManager', true ) ) );
			} catch(Exception $e) {
				$response->setResult( array( 'ui' => '', 'error' => $e ));
			}

		} else if ('savedraft' == $this->getOperationArg($request)) {
			$connector = $this->getConnector('__vt_drafts');
			$draftResponse = $connector->saveDraft($request);
			$response->setResult($draftResponse);
		} else if ('saveattachment' == $this->getOperationArg($request)) {
			$connector = $this->getConnector('__vt_drafts');
			$uploadResponse = $connector->saveAttachment($request);
			$response->setResult($uploadResponse);
		} else if ('commentwidget' == $this->getOperationArg($request)) {
			$viewer->assign('LINKMODULE', $request->get('_mlinktotype'));
			$viewer->assign('PARENT', $request->get('_mlinkto'));
			$viewer->assign('MSGNO', $request->get('_msgno'));
			$viewer->assign('FOLDER', $request->get('_folder'));
			$viewer->assign('MODULE', $request->getModule());
			$viewer->view( 'MailManagerCommentWidget.tpl', 'MailManager' );
			$response = false;
		}
		return $response;
	}

	/**
	 * Returns the Parent for Tickets module
	 * @global Users Instance $currentUserModel
	 * @param Integer $parent - crmid of Parent
	 * @param Email Address $from - Email Address of the received mail
	 * @return Integer - Parent(crmid)
	 */
	public function setParentForHelpDesk($parent, $from) {
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if(empty($parent)) {
			if(!empty($from)) {
				$parentInfo = MailManager::lookupMailInVtiger($from[0], $currentUserModel);
				if(!empty($parentInfo[0]['record'])) {
					$parentId = vtws_getIdComponents($parentInfo[0]['record']);
					return $parentId[1];
				}
			}
		} else {
			return $parent;
		}
	}


	/**
	 * Function used to set the record fields with the information from mail.
	 * @param Array $qcreate_array
	 * @param MailManager_Message_Model $mail
	 * @return Array
	 */
	public function processFormData($mail, $isSentFolder = false) {
		$subject = $mail->subject();
		$email = $mail->from();
		if($isSentFolder) {
			$email = $mail->to();
			if(!empty($email)) $mail_address = implode(',', $email);
		} else {
			if(!empty($email)) $mail_address = implode(',', $email);
		}

		if(!empty($mail_address)) $name = explode('@', $mail_address);
		if(!empty($name[1])) $companyName = explode('.', $name[1]);

		$defaultFieldValueMap =  array( 'lastname'	=>	$name[0],
				'email'			=> $email[0],
				'email1'		=> $email[0],
				'accountname'	=> $companyName[0],
				'company'		=> $companyName[0],
				'ticket_title'	=> $subject,
				'potentialname' => $subject,
				'subject'		=> $subject,
				'title'			=> $subject,
		);
		return $defaultFieldValueMap;
	}

	/**
	 * Returns the available List of accessible modules for Mail Manager
	 * @return Array
	 */
	public function getCurrentUserMailManagerAllowedModules() {
		$moduleListForCreateRecordFromMail = array('Contacts', 'Accounts', 'Leads', 'HelpDesk', 'Calendar');

		foreach($moduleListForCreateRecordFromMail as $module) {
			if(MailManager::checkModuleWriteAccessForCurrentUser($module)) {
				$mailManagerAllowedModules[] = $module;
			}
		}
		return $mailManagerAllowedModules;
	}

	/**
	 * Returns the list of accessible modules on which Actions(Relationship) can be taken.
	 * @return string
	 */
	public function linkToAvailableActions() {
		$moduleListForLinkTo = array('Calendar','HelpDesk','ModComments','Emails');

		foreach($moduleListForLinkTo as $module) {
			if(MailManager::checkModuleWriteAccessForCurrentUser($module)) {
				$mailManagerAllowedModules[] = $module;
			}
		}
		return $mailManagerAllowedModules;
	}

	/**
	 * Helper function to scan for relations
	 */
	protected $wsDescribeCache = array();
	public function ws_describe($module) {
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if (!isset($this->wsDescribeCache[$module])) {
			$this->wsDescribeCache[$module] = vtws_describe( $module, $currentUserModel);
		}
		return $this->wsDescribeCache[$module];
	}

	/**
	 * Funtion used to build Web services query
	 * @param String $module - Name of the module
	 * @param String $text - Search String
	 * @param String $type - Tyoe of fields Phone, Email etc
	 * @return String
	 */
	public function buildSearchQuery($module, $text, $type) {
		global $log;
 		$describe = $this->ws_describe($module);	
 
		// to check whether fields are accessible to current_user or not
		$labelFields = explode(',',$describe['labelFields']);

		//overwrite labelfields with field names instead of column names
		$currentUserModel = vglobal('current_user');
		$handler = vtws_getModuleHandlerFromName($module, $currentUserModel);
		$meta = $handler->getMeta();
		$fieldColumnMapping = $meta->getFieldColumnMapping();
		$columnFieldMapping = array_flip($fieldColumnMapping);
		foreach ($labelFields as $i => $columnname) {
			$labelFields[$i] = $columnFieldMapping[$columnname];
		}

		foreach($labelFields as $fieldName){
			foreach($describe['fields'] as $describefield){
				if($describefield['name'] == $fieldName){
					$searchFields[] = $fieldName;
					break;
				}
			}
		}

		$whereClause = '';
		foreach($describe['fields'] as $field) {
			if (strcasecmp($type, $field['type']['name']) === 0) {
				$whereClause .= sprintf( " %s LIKE '%%%s%%' OR", $field['name'], $text );
			}
		}
		return sprintf( "SELECT %s FROM %s WHERE %s;", implode(',',$searchFields), $module, rtrim($whereClause, 'OR') );
	}

	/**
	 * Returns the List of Matching records with the Email Address
	 * @global Users Instance $currentUserModel
	 * @param String $module
	 * @param Email Address $email
	 * @return Array
	 */
	public function lookupModuleRecordsWithEmail($module, $email) {
		global $log;
 		$currentUserModel = vglobal('current_user');
		$query = $this->buildSearchQuery($module, $email, 'EMAIL');
		$qresults = vtws_query( $query, $currentUserModel );
		$describe = $this->ws_describe($module);
		$labelFields = explode(',', $describe['labelFields']);

		$results = array();
		foreach($qresults as $qresult) {
			$labelValues = array();
			foreach($labelFields as $fieldname) {
				if(isset($qresult[$fieldname])) $labelValues[] = $qresult[$fieldname];
			}
			$ids = vtws_getIdComponents($qresult['id']);
			$results[] = array( 'wsid' => $qresult['id'], 'id' => $ids[1], 'label' => implode(' ', $labelValues));
		}
		return $results;
	}

	/**
	 * Function to lookup rel records(which supports emails only) of records
	 * @param <string> $wsId
	 * @return <array> $results
	 */
	public function lookupRelModuleRecords($wsId) {
		$currentUser = vglobal('current_user');
		$results = array();
		/* Harcoded to fecth only project records. In future we should treat 
		 * below $relModules array as modules which support emails and related to 
		 * parent module.
		 */
		$relModules = array('Project');
		$db = PearDatabase::getInstance();
		$wsObject = VtigerWebserviceObject::fromId($db, $wsId);
		$entityName = $wsObject->getEntityName();

		foreach ($relModules as $relModule) {
			$relation = Vtiger_Relation_Model::getInstanceByModuleName($entityName, $relModule);
			if(!$relation) {
				continue;
			}
			$relDescribe = $this->ws_describe($relModule);
			$labelFields = explode(',', $relDescribe['labelFields']);
			$relHandler = vtws_getModuleHandlerFromName($relModule, $currentUser);
			$relMeta = $relHandler->getMeta();
			//overwrite labelfields with field names instead of column names
			$fieldColumnMapping = $relMeta->getFieldColumnMapping();
			$columnFieldMapping = array_flip($fieldColumnMapping);

			foreach ($labelFields as $i => $columnname) {
				$labelFields[$i] = $columnFieldMapping[$columnname];
			}

			$sql = sprintf("SELECT %s FROM %s",  implode(',', $labelFields),$relModule);
			$relQResults = vtws_query_related($sql, $wsId, $relation->get('label'), $currentUser);

			foreach($relQResults as $qresult) {
				$labelValues = array();
				foreach($labelFields as $fieldname) {
					if(isset($qresult[$fieldname])) $labelValues[] = $qresult[$fieldname];
				}
				$ids = vtws_getIdComponents($qresult['id']);
				$results[] = array( 'wsid' => $qresult['id'], 'id' => $ids[1], 'label' => implode(' ', $labelValues),'parent' => $wsId);
			}
		}
		return $results;
	}

	public function validateRequest(Vtiger_Request $request) {
		return $request->validateWriteAccess();
	}
}
?>