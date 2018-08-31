<?php

/**
 * Mail scanner action creating mail
 * @package YetiForce.MailScanner
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
//include('modules/OSSMailView/OSSMailView.php');
require_once('include/fields/RecordNumber.php');
require_once('data/CRMEntity.php');
require_once('modules/OSSMail/actions/executeActions.php');
class OSSMailScanner_CreatedEmail_ScannerAction
{

	public function process(OSSMail_Mail_Model $mail)
	{
		global $log,$current_user;
		$adb = PearDatabase::getInstance();
		//$log->debug("in OSSMailScanner_CreatedEmail_ScannerAction mail=".print_r($mail,true));
		$id = 0;
		$folder = $mail->getFolder();
		$account = $mail->getAccount();
		$type = $mail->getTypeEmail();
		$mailId = $mail->getMailCrmId();
		$exceptionsAll = OSSMailScanner_Record_Model::getConfig('exceptions');

		if ($type == 0) {
			$mailForExceptions = $mail->get('toaddress');
		} else {
			$mailForExceptions = $mail->get('fromaddress');
		}

		if (!empty($exceptionsAll['crating_mails'])) {
			$exceptions = explode(',', $exceptionsAll['crating_mails']);
			foreach ($exceptions as $exception) {
				if (strpos($mailForExceptions, $exception) !== FALSE) {
					return $id;
				}
			}
		}
		if ($mailId === false && !empty($mail->get('message_id'))) {
			//$adb->setDebug(true);
			$toIds =  $mail->get('toaddress');
			$toIds = array_merge($toIds, $mail->get('ccaddress'));
			$toIds = array_merge($toIds, $mail->get('bccaddress'));
			$fromIds = $mail->get('fromaddress');
		    $noqqq= date('Y-m-d h:i:s');
			$current_id = $adb->getUniqueID("vtiger_crmentity");
			$tabId = "OSSMailView";
			$focus1 = CRMEntity::getInstance($tabId);
			
			
			
			$focus1->column_fields['assigned_user_id'] =  $mail->getAccountOwner();					
			$focus1->column_fields['subject'] =  $mail->get('subject');		
			$focus1->column_fields['description'] = $mail->get('body');			
			$focus1->column_fields['to_email'] =  $mail->get('toaddress');				
			$focus1->column_fields['from_email'] =  $mail->get('fromaddress');				
			$focus1->column_fields['reply_to_email'] =  $mail->get('reply_toaddress');		
			$focus1->column_fields['cc_email'] =  $mail->get('ccaddress');
			$focus1->column_fields['bcc_email'] =  $mail->get('bccaddress');
			$focus1->column_fields['content'] =  $mail->get('body');					
			$focus1->column_fields['uid'] =  $mail->get('message_id');					
			$focus1->column_fields['ossmailview_sendtype'] =  $mail->getTypeEmail(true);					
			$focus1->column_fields['mbox'] =  $mail->getFolder();		
			$focus1->column_fields['type'] =  $type;					
			$focus1->column_fields['rc_user'] =  $account['user_id'];					
			$focus1->column_fields['from_id'] = $mail->get('fromaddress');				
			$focus1->column_fields['to_id'] =  $mail->get('toaddress');					
			$focus1->save($tabId);
			$id=$focus1->id;
 
 
			//$log->debug('ossmailview savedddddddddddddddddddddddddddddddddddddddddddddd');
			$mail->setMailCrmId($id);
			OSSMail_Record_Model::_SaveAttachements($id, $mail);
 			$updateQuery = "UPDATE vtiger_crmentity SET createdtime=?,smcreatorid=?,modifiedby=? WHERE crmid=?";
			$updateParams = array($mail->get('udate_formated'), $mail->getAccountOwner(), $mail->getAccountOwner(),$id);
			$adb->pquery($updateQuery, $updateParams);
			$updateQuery2 = "UPDATE vtiger_ossmailview SET date=?,id=? WHERE ossmailviewid=?";
			$updateParams2 = array($mail->get('udate_formated'), $mail->get('id'),$id);
			$adb->pquery($updateQuery2, $updateParams2);

			$owner = $mail->getAccountOwner();
			$folder = $mail->getFolder();
			$to= $mail->get('toaddress');
		//	$to = str_replace(",","','",$to);
			$fromaddress= $mail->get('fromaddress');
			//for send mail relate to contact Ganesh added
			if($folder == 'Sent'){
				//$log->debug("Sent Started");
				$sourceModule = array("Contacts","Leads","Accounts");
				$send_mail = explode(",",$to);
				foreach ($send_mail as $send) { //each emailid start
					$userresult = $adb->pquery("SELECT * FROM vtiger_users WHERE email1= '$send' OR email2 = '$send' OR secondaryemail='$send'");
					$numbruser = $adb->num_rows($userresult);
					if($numbruser <= 0){
					//$log->debug("Mail each start".$send);
				foreach ($sourceModule as $NewModule) { //each module start
					$Colum = array();
					//$log->debug("each module start=".$NewModule);
					$resulttab = $adb->pquery("SELECT tabid FROM vtiger_tab WHERE name = '$NewModule' ");
					$tabid = $adb->query_result($resulttab, 0, "tabid");
					if($tabid != ''){
						$resultColum = $adb->pquery("SELECT columnname FROM vtiger_field WHERE  uitype =13 AND  tabid =$tabid ");
						while($row = $adb->fetch_array($resultColum)){
							$Colum[] = $row['columnname'];
						}
					}
					//$log->debug("tabid=".$tabid);
					//$log->debug("Colum=".print_r($Colum,true));
						//depend on module name table name 
					if($NewModule == "Contacts"){
						$table = "vtiger_contactdetails";
						$condition = "contactid";
					}
					else if($NewModule == "Leads"){
						$table = "vtiger_leaddetails";
						$condition = "leadid";
					}
					else if($NewModule == "Accounts"){
						$table = "vtiger_account";
						$condition = "accountid";
					}

					//for INBOX mail relate to contact Ganesh writen

					if($tabid != '' && $Colum !=''){ //check tab id colum start
						//$log->debug("check tab id colum start");
						$attributeid = array();
						foreach ($Colum as $field) { //each colum start
							//$log->debug("each colum start");
							if($table != "vtiger_account"){
							//	$log->debug("myquery = SELECT ".$condition." FROM ".$table." WHERE ".$field." IN ('".$send."')");
								$result = $adb->pquery("SELECT $condition FROM $table INNER JOIN vtiger_crmentity on ($table.$condition = vtiger_crmentity.crmid and vtiger_crmentity.deleted=0) WHERE $field IN ('$send')");
							}
							else{
								if($field == "email1"){
									$table = "vtiger_accountscf";
									$field = "cf_1669";
								}
								
							//	$log->debug("myquery = SELECT ".$condition." FROM ".$table." WHERE ".$field." IN ('".$send."')");
								$result = $adb->pquery("SELECT $condition FROM $table INNER JOIN vtiger_crmentity on ($table.$condition = vtiger_crmentity.crmid and vtiger_crmentity.deleted=0) WHERE $field IN ('$send')");
							}
							$numbrNewModule = $adb->num_rows($result);
							if($numbrNewModule >0){
								//$attributeid.$NewModule[] = $adb->query_result($result, 0, $condition);
								while($row = $adb->fetch_array($result)){
									//$log->debug($condition." = ".$row[$condition]);
								//	$crmnid = $row[$condition];
								//	$crmresult = $adb->pquery("SELECT deleted FROM vtiger_crmentity WHERE crmid = $crmnid");
								//	$numbrcrm = $adb->num_rows($crmresult);
								//	$rowcrm = $adb->query_result($crmresult, 0, 'deleted');
								//	if($rowcrm == 0){
										$attributeid[]=$row[$condition];
								//	}									
								}
							}
							//$log->debug("numbr_NewModule=".$numbrNewModule);
							//$log->debug("attributeid_NewModule=".print_r($attributeid,true));
						/*	while($row = $adb->fetch_array($result)){
									$attributeid.$NewModule[]=$row[$condition];
								}*/
						} //each colum start
					}//check tab id colum start
					if($NewModule == "Contacts"){
						$Contactsattributeid = $attributeid;
						$Contactscount = count($attributeid);
					}
					else if($NewModule == "Leads"){
						$Leadsattributeid = $attributeid;
						$Leadscount = count($attributeid);
					}
					else if($NewModule == "Accounts"){
						$Accountsattributeid = $attributeid;
						$Accountscount = count($attributeid);
					}

				}//each module end
				//$log->debug("Contactsattributeid=".print_r($Contactsattributeid,true));
				//$log->debug("Leadsattributeid=".print_r($Leadsattributeid,true));
				//$log->debug("Accountsattributeid=".print_r($Accountsattributeid,true));
				//$log->debug("Accountscount=".print_r($Accountscount,true));
				//$log->debug("Contactscount=".print_r($Contactscount,true));
				//$log->debug("Leadscount=".print_r($Leadscount,true));

				//relating the email
				//if email exist in 3 condition relate to contact
				if($Accountscount > 0 && $Contactscount > 0 && $Leadscount > 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}
				//if email exist in Contacts & Leads condition relate to contact
				else if($Accountscount <= 0 && $Contactscount > 0 && $Leadscount > 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}
				//if email exist in Contacts & Accounts condition relate to contact
				else if($Accountscount > 0 && $Contactscount > 0 && $Leadscount <= 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}
				
				//if email exist in Contacts & Accounts condition relate to contact
				else if($Accountscount > 0 && $Contactscount <= 0 && $Leadscount <= 0){
					//foreach($Contactsattributeid as $newcontact){
						//insert new contact
						//$log->debug("New Contact Start");
						require_once 'modules/Contacts/Contacts.php';
						//$log->debug("New Contact include page");
						$Contact = new Contacts();
						$lname = explode("@",$send);
						//$log->debug("Contact Name=".$lname[0]);
						$lname[0] = str_replace("."," ",$lname[0]);
						$lname[0] = str_replace("_"," ",$lname[0]);
						$curruserid = $current_user->curruserid;
						//$log->debug("Current User Id=".$lname[0]);
						$contactresult = $adb->pquery("SELECT a.fieldname FROM  vtiger_field as a inner join vtiger_tab as b on (b.name = 'Contacts' and a.tabid =b.tabid) WHERE  a.typeofdata Like '%~M%'");
						while($rowcontact = $adb->fetch_array($contactresult)){
							$fieldname = $rowcontact['fieldname'];
							if($fieldname == 'firstname' || $fieldname == 'lastname'){
								$Contact->column_fields[$fieldname] = $lname[0];
							}
							elseif($fieldname == 'email'){
								$Contact->column_fields[$fieldname] = $send;
							}
							else{
								$Contact->column_fields[$fieldname] = $curruserid;
							}
							
						}					
						if($Contact->column_fields['email'] == ''){
							$Contact->column_fields['email'] = $receiv;
						}	
						$Contact->save('Contacts');
						//$log->debug("New Contact Saved");
						$contactid=$Contact->id;
						//$log->debug("New Contact Id=".$contactid);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $contactid;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
				//	}
					
				}

				//if email exist in Contacts condition relate to contact
				else if($Accountscount <= 0 && $Contactscount > 0 && $Leadscount <= 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}

				//if email exist in Leads condition relate to Leads
				else if($Accountscount <= 0 && $Contactscount <= 0 && $Leadscount > 0){
					foreach($Leadsattributeid as $newcontact){
						//$log->debug("Relating to Leads".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Leads';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}

				//if email exist in Leads condition relate to Leads
				else if($Accountscount > 0 && $Contactscount <= 0 && $Leadscount > 0){
					foreach($Leadsattributeid as $newcontact){		
						//$log->debug("Relating to Leads".$newcontact);				
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Leads';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}

				//if email exist in Leads condition relate to Leads
				else if($Accountscount <= 0 && $Contactscount <= 0 && $Leadscount <= 0){
					//insert new lead
				
						$currentemail = $current_user->email;
					//$log->debug("New Contact Start");
						require_once 'modules/Leads/Leads.php';
						//$log->debug("New Leads include page");
						$Leads = new Leads();
						$lname = explode("@",$send);
						//$log->debug("Leads Name=".$lname[0]);
						$curruserid = $current_user->curruserid;
						$lname[0] = str_replace("."," ",$lname[0]);
						$lname[0] = str_replace("_"," ",$lname[0]);
						//$log->debug("Leads User Id=".$lname[0]);
						$leadresult = $adb->pquery("SELECT a.fieldname FROM  vtiger_field as a inner join vtiger_tab as b on (b.name = 'Leads' and a.tabid =b.tabid) WHERE  a.typeofdata Like '%~M%'");
					
						while($rowlead = $adb->fetch_array($leadresult)){
							$fieldname = $rowlead['fieldname'];
							if($fieldname == 'firstname' || $fieldname == 'lastname'){
								$Leads->column_fields[$fieldname] = $lname[0];
							}
							elseif($fieldname == 'email'){
								$Leads->column_fields[$fieldname] = $send;
							}
							else{
								$Leads->column_fields[$fieldname] = $curruserid;
							}
							
						}
						if($Leads->column_fields['email'] == ''){
							$Leads->column_fields['email'] = $receiv;
						}					
						$Leads->save('Leads');
						//$log->debug("New Leads Saved");
						$Leadsid=$Leads->id;
						//$log->debug("New Leads Id=".$Leadsid);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Leads';
						$params['newCrmId']= $Leadsid;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				
				}
			} //each emailid end
				

		}


			else if($folder == 'INBOX'){
				
				//$log->debug("INBOX Started");
				$sourceModule = array("Contacts","Leads","Accounts");
				$rec_mail = explode(",",$fromaddress);
				foreach ($rec_mail as $receiv) { //each emailid start
					$userresult = $adb->pquery("SELECT * FROM vtiger_users WHERE email1= '$receiv' OR email2 = '$receiv' OR secondaryemail='$receiv'");
					$numbruser = $adb->num_rows($userresult);
					if($numbruser <= 0){
					//$log->debug("Mail each start".$receiv);
				foreach ($sourceModule as $NewModule) { //each module start
					$Colum = array();
					//$log->debug("each module start=".$NewModule);
					$resulttab = $adb->pquery("SELECT tabid FROM vtiger_tab WHERE name = '$NewModule' ");
					$tabid = $adb->query_result($resulttab, 0, "tabid");
					if($tabid != ''){
						$resultColum = $adb->pquery("SELECT columnname FROM vtiger_field WHERE  uitype =13 AND  tabid =$tabid ");
						while($row = $adb->fetch_array($resultColum)){
							$Colum[] = $row['columnname'];
						}
					}
					//$log->debug("tabid=".$tabid);
					//$log->debug("Colum=".print_r($Colum,true));
						//depend on module name table name 
					if($NewModule == "Contacts"){
						$table = "vtiger_contactdetails";
						$condition = "contactid";
					}
					else if($NewModule == "Leads"){
						$table = "vtiger_leaddetails";
						$condition = "leadid";
					}
					else if($NewModule == "Accounts"){
						$table = "vtiger_account";
						$condition = "accountid";
					}

					//for INBOX mail relate to contact Ganesh writen

					if($tabid != '' && $Colum !=''){ //check tab id colum start
						//$log->debug("check tab id colum start");
						$attributeid = array();
						foreach ($Colum as $field) { //each colum start
							//$log->debug("each colum start");
							//$log->debug("SELECT ".$condition." FROM ".$table." INNER JOIN vtiger_crmentity on (".$table.".".$condition." = vtiger_crmentity.crmid and vtiger_crmentity.deleted=0) WHERE ".$field." IN ('".$receiv."')");
							if($table != "vtiger_account"){
								$result = $adb->pquery("SELECT $condition FROM $table INNER JOIN vtiger_crmentity on ($table.$condition = vtiger_crmentity.crmid and vtiger_crmentity.deleted=0) WHERE $field IN ('$receiv')");
							}
							else{
								if($field == "email1"){
									$table = "vtiger_accountscf";
									$field = "cf_1669";
								}
								
							//	$log->debug("myquery = SELECT ".$condition." FROM ".$table." WHERE ".$field." IN ('".$send."')");
							$result = $adb->pquery("SELECT $condition FROM $table INNER JOIN vtiger_crmentity on ($table.$condition = vtiger_crmentity.crmid and vtiger_crmentity.deleted=0) WHERE $field IN ('$receiv')");
							}
							$numbrNewModule = $adb->num_rows($result);
							if($numbrNewModule >0){
								//$attributeid.$NewModule[] = $adb->query_result($result, 0, $condition);
								while($row = $adb->fetch_array($result)){
									//$log->debug($condition." = ".$row[$condition]);
									$crmnid = $row[$condition];
								//	$crmresult = $adb->pquery("SELECT deleted FROM vtiger_crmentity WHERE crmid = $crmnid");
								//	$numbrcrm = $adb->num_rows($crmresult);
								//	$rowcrm = $adb->query_result($crmresult, 0, 'deleted');
								//	if($rowcrm == 0){
										$attributeid[]=$row[$condition];
								//	}									
								}
							}
							//$log->debug("numbr_NewModule=".$numbrNewModule);
							//$log->debug("attributeid_NewModule=".print_r($attributeid,true));
						
						} //each colum start
					}//check tab id colum start
					if($NewModule == "Contacts"){
						$Contactsattributeid = $attributeid;
						$Contactscount = count($attributeid);
					}
					else if($NewModule == "Leads"){
						$Leadsattributeid = $attributeid;
						$Leadscount = count($attributeid);
					}
					else if($NewModule == "Accounts"){
						$Accountsattributeid = $attributeid;
						$Accountscount = count($attributeid);
					}

				}//each module end
			
				//relating the email
				//if email exist in 3 condition relate to contact
				if($Accountscount > 0 && $Contactscount > 0 && $Leadscount > 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}
				//if email exist in Contacts & Leads condition relate to contact
				else if($Accountscount <= 0 && $Contactscount > 0 && $Leadscount > 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}
				//if email exist in Contacts & Accounts condition relate to contact
				else if($Accountscount > 0 && $Contactscount > 0 && $Leadscount <= 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}
				
				//if email exist in Contacts & Accounts condition relate to contact
				else if($Accountscount > 0 && $Contactscount <= 0 && $Leadscount <= 0){
					//foreach($Contactsattributeid as $newcontact){
						//insert new contact
						
						$contactresult = $adb->pquery("SELECT a.fieldname FROM  vtiger_field as a inner join vtiger_tab as b on (b.name = 'Contacts' and a.tabid =b.tabid) WHERE  a.typeofdata Like '%~M%'");
						
						//$log->debug("New Contact Start");
						require_once 'modules/Contacts/Contacts.php';
						//$log->debug("New Contact include page");
						$Contact = new Contacts();
						$lname = explode("@",$receiv);
						//$log->debug("Contact Name=".$lname[0]);
						$curruserid = $current_user->curruserid;
						$lname[0] = str_replace("."," ",$lname[0]);
						$lname[0] = str_replace("_"," ",$lname[0]);
						while($rowcontact = $adb->fetch_array($contactresult)){
							$fieldname = $rowcontact['fieldname'];
							if($fieldname == 'firstname' || $fieldname == 'lastname'){
								$Contact->column_fields[$fieldname] = $lname[0];
							}
							elseif($fieldname == 'email'){
								$Contact->column_fields[$fieldname] = $receiv;
							}
							else{
								$Contact->column_fields[$fieldname] = $curruserid;
							}
							
						}
						if($Contact->column_fields['email'] == ''){
							$Contact->column_fields['email'] = $receiv;
						}
						$Contact->save('Contacts');
						//$log->debug("New Contact Saved");
						$contactid=$Contact->id;
						//$log->debug("New Contact Id=".$contactid);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $contactid;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
				//	}
					
				}

				//if email exist in Contacts condition relate to contact
				else if($Accountscount <= 0 && $Contactscount > 0 && $Leadscount <= 0){
					foreach($Contactsattributeid as $newcontact){
						//$log->debug("Relating to Contact".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}

				//if email exist in Leads condition relate to Leads
				else if($Accountscount <= 0 && $Contactscount <= 0 && $Leadscount > 0){
					foreach($Leadsattributeid as $newcontact){
						//$log->debug("Relating to Leads".$newcontact);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Leads';
						$params['newCrmId']= $newcontact;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}

				//if email exist in Leads condition relate to Leads
				else if($Accountscount > 0 && $Contactscount <= 0 && $Leadscount > 0){
					foreach($Leadsattributeid as $newcontact){		
						//$log->debug("Relating to Leads".$newcontact);				
						$contactresult = $adb->pquery("SELECT a.fieldname FROM  vtiger_field as a inner join vtiger_tab as b on (b.name = 'Contacts' and a.tabid =b.tabid) WHERE  a.typeofdata Like '%~M%'");
						
						//$log->debug("New Contact Start");
						require_once 'modules/Contacts/Contacts.php';
						//$log->debug("New Contact include page");
						$Contact = new Contacts();
						$lname = explode("@",$receiv);
						//$log->debug("Contact Name=".$lname[0]);
						$curruserid = $current_user->curruserid;
						$lname[0] = str_replace("."," ",$lname[0]);
						$lname[0] = str_replace("_"," ",$lname[0]);
						while($rowcontact = $adb->fetch_array($contactresult)){
							$fieldname = $rowcontact['fieldname'];
							if($fieldname == 'firstname' || $fieldname == 'lastname'){//lastname
								$Contact->column_fields[$fieldname] = $lname[0];
							}
							elseif($fieldname == 'email'){
								$Contact->column_fields[$fieldname] = $receiv;
							}
							else{
								$Contact->column_fields[$fieldname] = $curruserid;
							}
							
						}
						if($Contact->column_fields['email'] == ''){
							$Contact->column_fields['email'] = $receiv;
						}
						$Contact->save('Contacts');
						//$log->debug("New Contact Saved");
						$contactid=$Contact->id;
						//$log->debug("New Contact Id=".$contactid);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Contacts';
						$params['newCrmId']= $contactid;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					}
					
				}

				//if email exist in Leads condition relate to Leads
				else if($Accountscount <= 0 && $Contactscount <= 0 && $Leadscount <= 0){
					//insert new lead
					
						//$log->debug("New Contact Start");
						require_once 'modules/Leads/Leads.php';
						//$log->debug("New Leads include page");
						$Leads = new Leads();
						$lname = explode("@",$receiv);
						//$log->debug("Leads Name=".$lname[0]);
						$curruserid = $current_user->curruserid;
						$lname[0] = str_replace("."," ",$lname[0]);
						$lname[0] = str_replace("_"," ",$lname[0]);
						$leadresult = $adb->pquery("SELECT a.fieldname FROM  vtiger_field as a inner join vtiger_tab as b on (b.name = 'Leads' and a.tabid =b.tabid) WHERE  a.typeofdata Like '%~M%'");			
						while($rowlead = $adb->fetch_array($leadresult)){
							$fieldname = $rowlead['fieldname'];
							//$log->debug("fieldname=".$fieldname);
							if($fieldname == 'firstname' || $firstname == 'lastname'){
								$Leads->column_fields[$fieldname] = $lname[0];
							}
							elseif($fieldname == 'email'){
								$Leads->column_fields[$fieldname] = $receiv;
							}
							else{
								$Leads->column_fields[$fieldname] = $curruserid;
							}
							
						}
						if($Leads->column_fields['email'] == ''){
							$Leads->column_fields['email'] = $receiv;
						}					
						$Leads->save('Leads');
						//$log->debug("New Leads Saved");
						$Leadsid=$Leads->id;
						//$log->debug("New Leads Id=".$Leadsid);
						$mode= 'addRelated';
						$params['mailId']=$id;
						$params['newModule']= 'Leads';
						$params['newCrmId']= $Leadsid;
						$instance = Vtiger_Record_Model::getCleanInstance('OSSMailView');			
						$data = $instance->addRelated($params);
						$instance->get();
					
				
					
				}
			}

			} //each emailid end
				

				//$log->debug("Send End Here");
			}
				
			
			
		


			return $id;
		}
	}
}
?>
