<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
 vimport ('~modules/MailManager/models/Message.php');
include_once 'config.php';
require_once 'include/utils/utils.php';
include_once 'include/Webservices/Query.php';
require_once 'includes/runtime/Cache.php';
include_once 'include/Webservices/DescribeObject.php';
require_once 'modules/Vtiger/helpers/Util.php';
include_once 'modules/Settings/MailConverter/handlers/MailScannerAction.php';
include_once 'modules/Settings/MailConverter/handlers/MailAttachmentMIME.php';
class Emails_Record_Model extends Vtiger_Record_Model {

	/**
	 * Function to get the Detail View url for the record
	 * @return <String> - Record Detail View Url
	 */
	public function getDetailViewUrl() {
		list($parentId, $status) = explode('@', reset(array_filter(explode('|', $this->get('parent_id')))));
		return 'Javascript:Vtiger_Index_Js.showEmailPreview("'.$this->getId().'","'.$parentId.'")';
	}

	/**
	 * Function to save an Email
	 */
	public function save() {
            //Opensource fix for MailManager data mail attachment
		if($this->get('email_flag')!="MailManager"){ 
                    $this->set('date_start', date('Y-m-d')); 
                    $this->set('time_start', date('H:i')); 
                }
		$this->set('activitytype', 'Emails');

		//$currentUserModel = Users_Record_Model::getCurrentUserModel();
		//$this->set('assigned_user_id', $currentUserModel->getId());
		$this->getModule()->saveRecord($this);
		$documentIds = $this->get('documentids');
		if (!empty ($documentIds)) {
            $this->deleteDocumentLink();
			$this->saveDocumentDetails();
		}
	}

	/**
	 * Function sends mail
	 */
	public function send() {
		global $log;
		//global $db;
		$db = PearDatabase::getInstance();//added by murali
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$rootDirectory =  vglobal('root_directory');

		$mailer = Emails_Mailer_Model::getInstance();
		$mailer->IsHTML(true);

		$fromEmail = $this->getFromEmailAddress();
		$replyTo = $currentUserModel->get('email1');
		$userName = $currentUserModel->getName();

		// To eliminate the empty value of an array
		$toEmailInfo = array_filter($this->get('toemailinfo'));
        $toMailNamesList = array_filter($this->get('toMailNamesList'));
        foreach($toMailNamesList as $id => $emailData){
            foreach($emailData as $key => $email){
                if($toEmailInfo[$id]){
                    array_push($toEmailInfo[$id], $email['value']);
                }
            }
        }
        $emailsInfo = array();
		foreach ($toEmailInfo as $id => $emails) {
            foreach($emails as $key => $value){
                array_push($emailsInfo, $value);
            }
		}

        $toFieldData = array_diff(explode(',', $this->get('saved_toid')), $emailsInfo);
		$toEmailsData = array();
		$i = 1;
		foreach ($toFieldData as $value) {
			$toEmailInfo['to'.$i++] = array($value);
		}
		$attachments = $this->getAttachmentDetails();
		$status = false;

		// Merge Users module merge tags based on current user.
		$mergedDescription = getMergedDescription($this->get('description'), $currentUserModel->getId(), 'Users');
                $mergedSubject = getMergedDescription($this->get('subject'),$currentUserModel->getId(), 'Users');
                
		foreach($toEmailInfo as $id => $emails) {
			$mailer->reinitialize();
			$mailer->ConfigSenderInfo($fromEmail, $userName, $replyTo);
			$old_mod_strings = vglobal('mod_strings');
			$description = $this->get('description');
                        $subject = $this->get('subject');
			$parentModule = $this->getEntityType($id);
			if ($parentModule) {
			$currentLanguage = Vtiger_Language_Handler::getLanguage();
			$moduleLanguageStrings = Vtiger_Language_Handler::getModuleStringsFromFile($currentLanguage,$parentModule);
			vglobal('mod_strings', $moduleLanguageStrings['languageStrings']);

			if ($parentModule != 'Users') {
				// Apply merge for non-Users module merge tags.
				$description = getMergedDescription($mergedDescription, $id, $parentModule);
                                $subject = getMergedDescription($mergedSubject, $id, $parentModule);
			} else {
				// Re-merge the description for user tags based on actual user.
					$description = getMergedDescription($description, $id, 'Users');
                                        $subject = getMergedDescription($mergedSubject, $id, 'Users');
					vglobal('mod_strings', $old_mod_strings);
				}
			}

			if (strpos($description, '$logo$')) {
				$description = str_replace('$logo$',"<img src='cid:logo' />", $description);
				$logo = true;
			}
			$log->debug("OOOOOOO");
			$log->debug(print_r($emails, true));
			foreach($emails as $email) {
				$mailer->Body = '';
				if ($parentModule) {
					$mailer->Body = $this->getTrackImageDetails($id, $this->isEmailTrackEnabled());
				}
				$mailer->Body .= $description;
				//$mailer->Signature = str_replace(array('\r\n', '\n'),'<br>',$currentUserModel->get('signature'));
				$mailer->Signature = str_replace(array("\r\n","\r","\n","\\r","\\n","\\r\\n"),'<br>',$currentUserModel->get('signature'));//added by sl for newline issues in signature
				if($mailer->Signature != '') {
					$mailer->Body.= '<br><br>'.decode_html($mailer->Signature);
				}
				$mailer->Subject = $subject;
				$log->debug("MMMMM");
				$log->debug($email);
				$mailer->AddAddress($email);
				//Murali--Start
				$curr_usr_id = $currentUserModel->id;//added by murali
				$date_var = date("Y-m-d H:i:s");//added by murali
				
				$lquery = $db->pquery("select * from vtiger_leaddetails, vtiger_crmentity where (email = '{$email}' or secondaryemail = '{$email}') and vtiger_crmentity.crmid=vtiger_leaddetails.leadid and vtiger_crmentity.deleted=0", array());
				$lnrows = $db->num_rows($lquery);
				$log->debug("NNNN");
				$log->debug($lnrows);
				$cquery = $db->pquery("select * from vtiger_contactdetails, vtiger_crmentity where (email = '{$email}' or secondaryemail = '{$email}') and vtiger_crmentity.crmid=vtiger_contactdetails.contactid and vtiger_crmentity.deleted=0", array());
				$cnrows = $db->num_rows($cquery);
				$log->debug("PPPP");
				$log->debug($cnrows);
				$aquery = $db->pquery("select * from vtiger_account, vtiger_crmentity where (email1 like '{$email}' or email2 like '{$email}') and vtiger_crmentity.crmid=vtiger_account.accountid and vtiger_crmentity.deleted=0", array());
				//$aquery = $db->pquery("select * from vtiger_accountscf, vtiger_crmentity where (cf_1669 = '{$email}') and vtiger_crmentity.crmid=vtiger_accountscf.accountid and vtiger_crmentity.deleted=0", array());
				$anrows = $db->num_rows($aquery);
				$log->debug($anrows);
				$activeq = $db->pquery("SELECT id  FROM `vtiger_users` WHERE (email1 = '{$email}' or email2= '{$email}' or secondaryemail= '{$email}') and status='Active'", array());
				$activerow = $db->num_rows($activeq);
				$inactiveq = $db->pquery("SELECT id  FROM `vtiger_users` WHERE (email1 = '{$email}' or email2= '{$email}' or secondaryemail= '{$email}') and status='Inactive'", array());
				$inactiverow = $db->num_rows($inactiveq);
				
				
				
				if($inactiverow == 0 || $inactiverow >0){
					
				}
				$mailmanrows = array("Leadrows"=>$nrows,"Contactrows"=>$cnrows,"accountrows"=>$anrows,'Emails'=>'Record');
				$log->debug($mailmanrows);
				if($activerow == 0){	
					if($lnrows >= 0 && $cnrows >= 0 && !$anrows){
						$log->debug("Man Loop1");
						$lcrmid = $db->pquery("SELECT * FROM `vtiger_crmentity` ORDER BY crmid DESC LIMIT 1", array());
						$lastcrmid = $db->query_result($lcrmid, 0, "crmid");
						
						$query_1 = $db->pquery("SELECT * FROM vtiger_contactdetails, vtiger_crmentity WHERE (email = '{$email}' OR secondaryemail = '{$email}') AND vtiger_crmentity.crmid = vtiger_contactdetails.contactid AND vtiger_crmentity.deleted=0", array());
						$q1rows = $db->num_rows($query_1);
							for($j=0; $j<=$q1rows; $j++){
								$contactid = $db->query_result($query_1,$j,'contactid');
								
								$query_2 = $db->pquery("INSERT INTO vtiger_seactivityrel (crmid, activityid) values (?,?)", array($contactid,$lastcrmid));
							}
							
					//if emailid is related to Leads and Accounts, create Contact and Attach to Contacts
					}elseif($lnrows >= 0 && !$cnrows && $anrows >= 0){
						$log->debug("Man Loop2");
						require_once 'modules/Contacts/Contacts.php';
						$Contact = new Contacts();
						$lname = explode("@",$email);
						$Contact->column_fields['lastname'] = $lname[0];
						$Contact->column_fields['email'] = $email;
						$Contact->column_fields['description'] = "This is created by custom code";
						$Contact->save('Contacts');
						
						$dl = $db->pquery("SELECT msubject AS ms, mbody AS mb, mfrom AS mf FROM vtiger_mailmanager_mailrecord where mdate =(select max(mdate) from vtiger_mailmanager_mailrecord)", array());
						$sub = $db->query_result($dl, 0, "ms");
						$bdy = $db->query_result($dl, 0, "mb");
						$mfrom = $db->query_result($dl, 0, "mf");
						
						$cqury = "SELECT MAX(contactid) AS cid FROM vtiger_contactdetails where email='".$email."'";
						$contactid = $db->pquery($cqury, array());
						$cid = $db->query_result($contactid, 0, "cid");
						
						//$sbjct = html_entity_decode($sub);					
						$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$subject."'";
						$emid = $db->pquery($cqury, array());
						$email_id = $db->query_result($emid, 0, "emid");
						
						$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
						$params4 = array($email_id,html_entity_decode($sub),' ','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
						$ACT = $db->pquery($insertAct, $params4);
						
						$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
						$params5 = array($cid,$email_id);
						$SEACT = $db->pquery($insertSEAct, $params5);
							
					//if emailid is related to Contacts and Accounts Attach to Contacts		
					}elseif(!$lnrows && $cnrows >= 0 && $anrows >= 0){
						$lcrmid = $db->pquery("SELECT * FROM `vtiger_crmentity` ORDER BY crmid DESC LIMIT 1", array());
						$log->debug("Man Loop3");
						$lastcrmid = $db->query_result($lcrmid, 0, "crmid");
						$log->debug($lastcrmid);
						$query_5 = $db->pquery("SELECT * FROM vtiger_contactdetails, vtiger_crmentity WHERE (email = '{$email}' OR secondaryemail = '{$email}') AND vtiger_crmentity.crmid=vtiger_contactdetails.contactid AND vtiger_crmentity.deleted=0", array());
						$q5rows = $db->num_rows($query_5);
							for($j=0; $j<=$q5rows; $j++){
								$contactid = $db->query_result($query_5,$j,'contactid');
								$log->debug("LINE 269");
								$log->debug($contactid);
								$query_66 = $db->pquery("INSERT INTO vtiger_seactivityrel (crmid, activityid) values (?,?)", array($contactid,$lastcrmid));
								$log->debug("LINE 272");
								$log->debug($query_66);
							}
							
					//if emailid is related only to Leads Attach to Leads				
					}elseif($lnrows >= 0 && !$cnrows && !$anrows){
						$log->debug("Man Loop only to Leads Attach to Leads");
						$lcrmid = $db->pquery("SELECT * FROM `vtiger_crmentity` ORDER BY crmid DESC LIMIT 1", array());
						$lastcrmid = $db->query_result($lcrmid, 0, "crmid");
						
						$query = $db->pquery("SELECT * FROM vtiger_leaddetails, vtiger_crmentity WHERE (email = '{$email}' OR secondaryemail = '{$email}') AND vtiger_crmentity.crmid=vtiger_leaddetails.leadid AND vtiger_crmentity.deleted=0", array());
						$q3rows = $db->num_rows($query);
							for($j=0; $j<=$q3rows; $j++){
								$leadid = $db->query_result($query,$j,'leadid');
								
								$query_7 = $db->pquery("INSERT INTO vtiger_seactivityrel (crmid, activityid) values (?,?)", array($leadid,$lastcrmid));
							}
							
					//if emailid is related only to Contacts Attach to Contacts			
					}elseif(!$lnrows && $cnrows >= 0 && !$anrows){
						$lcrmid = $db->pquery("SELECT * FROM `vtiger_crmentity` ORDER BY crmid DESC LIMIT 1", array());
						$lastcrmid = $db->query_result($lcrmid, 0, "crmid");
						
						$query = $db->pquery("SELECT * FROM vtiger_contactdetails, vtiger_crmentity WHERE (email = '{$email}' OR secondaryemail = '{$email}') AND vtiger_crmentity.crmid=vtiger_contactdetails.contactid AND vtiger_crmentity.deleted=0", array());
						$q5rows = $db->num_rows($query);
							for($j=0; $j<=$q5rows; $j++){
								$contactid = $db->query_result($query,$j,'contactid');
								
								$query_8 = $db->pquery("INSERT INTO vtiger_seactivityrel (crmid, activityid) values (?,?)", array($contactid,$lastcrmid));
							}
							
					//if emailid is related only to Accounts, cretae Contact Attach to Contacts 
					}elseif(!$lnrows && !$cnrows && $anrows >= 0){
						require_once 'modules/Contacts/Contacts.php';
						$Contact = new Contacts();
						$lname = explode("@",$email);
						$Contact->column_fields['lastname'] = $lname[0];
						$Contact->column_fields['email'] = $email;
						$Contact->column_fields['description'] = "This is created by custom code";
						$Contact->save('Contacts');
						
						$cqury = "SELECT MAX(contactid) AS cid FROM vtiger_contactdetails where email='".$email."'";
						$contactid = $db->pquery($cqury, array());
						$cid = $db->query_result($contactid, 0, "cid");
						
						//$sbjct = html_entity_decode($sub);					
						$cqury = "SELECT MAX(crmid) AS emid FROM vtiger_crmentity where label='".$subject."'";
						$emid = $db->pquery($cqury, array());
						$email_id = $db->query_result($emid, 0, "emid");
						
						$insertAct = "insert into vtiger_activity (activityid,subject,semodule,activitytype,date_start,due_date,time_start,time_end,sendnotification,duration_hours, duration_minutes,status,eventstatus,priority,location,notime,visibility,recurringtype,invoiceid,duration_seconds) values (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
						$params4 = array($email_id,html_entity_decode($sub),' ','Emails',date("Y-m-d"),NULL,date("h:i"),NULL,0,NULL,NULL,NULL,NULL,NULL,NULL,0,'all',NULL,NULL,NULL);
						$ACT = $db->pquery($insertAct, $params4);
						
						$insertSEAct = "insert into vtiger_seactivityrel (crmid, activityid) values (?,?)";
						$params5 = array($cid,$email_id);
						$SEACT = $db->pquery($insertSEAct, $params5);
					}
					//Added by Yogita--Ends	
				}
				
					

				//Adding attachments to mail
				if(is_array($attachments)) {
					foreach($attachments as $attachment) {
						$fileNameWithPath = $rootDirectory.$attachment['path'].$attachment['fileid']."_".$attachment['attachment'];
						if(is_file($fileNameWithPath)) {
							$mailer->AddAttachment($fileNameWithPath, $attachment['attachment']);
						}
					}
				}
				if ($logo) {
					//While sending email template and which has '$logo$' then it should replace with company logo
					$mailer->AddEmbeddedImage(dirname(__FILE__).'/../../../layouts/vlayout/skins/images/logo_mail.jpg', 'logo', 'logo.jpg', 'base64', 'image/jpg');
				}

				$ccs = array_filter(explode(',',$this->get('ccmail')));
				$bccs = array_filter(explode(',',$this->get('bccmail')));

				if(!empty($ccs)) {
					foreach($ccs as $cc) $mailer->AddCC($cc);
				}
				if(!empty($bccs)) {
					foreach($bccs as $bcc) $mailer->AddBCC($bcc);
				}
			}
			$status = $mailer->Send(true);
			if(!$status) {
				$status = $mailer->getError();
			} else {
                $mailString=$mailer->getMailString();
                $mailBoxModel = MailManager_Mailbox_Model::activeInstance();
                $folderName = $mailBoxModel->folder();
                if(!empty($folderName) && !empty($mailString)) {
                    $connector = MailManager_Connector_Connector::connectorWithModel($mailBoxModel, '');
                    imap_append($connector->mBox, $connector->mBoxUrl.$folderName, $mailString, "\\Seen");
                }
            }
		}
		return $status;
	}

	/**
	 * Returns the From Email address that will be used for the sent mails
	 * @return <String> - from email address
	 */
	function getFromEmailAddress() {
		$db = PearDatabase::getInstance();
		$currentUserModel = Users_Record_Model::getCurrentUserModel();

		$fromEmail = false;
		$result = $db->pquery('SELECT from_email_field FROM vtiger_systems WHERE server_type=?', array('email'));
		if ($db->num_rows($result)) {
			$fromEmail = decode_html($db->query_result($result, 0, 'from_email_field'));
		}
		if (empty($fromEmail)) $fromEmail = $currentUserModel->get('email1');
		return $fromEmail;
	}

	/**
	 * Function returns the attachment details for a email
	 * @return <Array> List of attachments
	 */
	function getAttachmentDetails() {
		$db = PearDatabase::getInstance();

		$attachmentRes = $db->pquery("SELECT * FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_attachments.attachmentsid = vtiger_seattachmentsrel.attachmentsid
						WHERE vtiger_seattachmentsrel.crmid = ?", array($this->getId()));
		$numOfRows = $db->num_rows($attachmentRes);
        $attachmentsList = array();
		if($numOfRows) {
			for($i=0; $i<$numOfRows; $i++) {
				$attachmentsList[$i]['fileid'] = $db->query_result($attachmentRes, $i, 'attachmentsid');
				$attachmentsList[$i]['attachment'] = decode_html($db->query_result($attachmentRes, $i, 'name'));
                $path = $db->query_result($attachmentRes, $i, 'path');
				$attachmentsList[$i]['path'] = $path;
                $attachmentsList[$i]['size'] = filesize($path.$attachmentsList[$i]['fileid'].'_'.$attachmentsList[$i]['attachment']);
                $attachmentsList[$i]['type'] = $db->query_result($attachmentRes, $i, 'type');
			}
		}

		$documentsList = $this->getRelatedDocuments();

        //Attachments are getting duplicated when forwarding a mail in Mail Manager.
		if($documentsList) {
			foreach ($documentsList as $document) {
				$flag = false;
				foreach ($attachmentsList as $attachment) {
					if($attachment['fileid'] == $document['fileid']) {
						$flag = true;
						break;
					}
				}
				if(!$flag) $attachmentsList[] = $document;
			}
		}

		return $attachmentsList;
	}
function getVTAttachmentDetails() {
		$db = PearDatabase::getInstance();

		$attachmentRes = $db->pquery("SELECT * FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_attachments.attachmentsid = vtiger_seattachmentsrel.attachmentsid
						WHERE vtiger_seattachmentsrel.crmid = ?", array($this->getId()));
		$numOfRows = $db->num_rows($attachmentRes);
        $attachmentsList = array();
		if($numOfRows) {
			for($i=0; $i<$numOfRows; $i++) {
				$attachmentsList[$i]['fileid'] = $db->query_result($attachmentRes, $i, 'attachmentsid');
				$attachmentsList[$i]['attachment'] = addslashes($db->query_result($attachmentRes, $i, 'name'));
                $path = $db->query_result($attachmentRes, $i, 'path');
				$attachmentsList[$i]['path'] = $path;
                $attachmentsList[$i]['size'] = filesize($path.$attachmentsList[$i]['fileid'].'_'.$attachmentsList[$i]['attachment']);
                $attachmentsList[$i]['type'] = $db->query_result($attachmentRes, $i, 'type');
			}
		}

		$documentsList = $this->getRelatedDocuments();

        //Attachments are getting duplicated when forwarding a mail in Mail Manager.
		if($documentsList) {
			foreach ($documentsList as $document) {
				$flag = false;
				foreach ($attachmentsList as $attachment) {
					if($attachment['fileid'] == $document['fileid']) {
						$flag = true;
						break;
					}
				}
				if(!$flag) $attachmentsList[] = $document;
			}
		}

		return $attachmentsList;
	}

	/**
	 * Function returns the document details for a email
	 * @return <Array> List of Documents
	 */
	public function getRelatedDocuments() {
		$db = PearDatabase::getInstance();

		$documentRes = $db->pquery("SELECT * FROM vtiger_senotesrel
						INNER JOIN vtiger_crmentity ON vtiger_senotesrel.notesid = vtiger_crmentity.crmid AND vtiger_senotesrel.crmid = ?
						INNER JOIN vtiger_notes ON vtiger_notes.notesid = vtiger_senotesrel.notesid
						INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.crmid = vtiger_notes.notesid
						INNER JOIN vtiger_attachments ON vtiger_attachments.attachmentsid = vtiger_seattachmentsrel.attachmentsid
						WHERE vtiger_crmentity.deleted = 0", array($this->getId()));
		$numOfRows = $db->num_rows($documentRes);

		if($numOfRows) {
			for($i=0; $i<$numOfRows; $i++) {
				$documentsList[$i]['name'] = $db->query_result($documentRes, $i, 'filename');
				$filesize = $db->query_result($documentRes, $i, 'filesize');
				$documentsList[$i]['size'] = $this->getFormattedFileSize($filesize);
				$documentsList[$i]['docid'] = $db->query_result($documentRes, $i, 'notesid');
				$documentsList[$i]['path'] = $db->query_result($documentRes, $i, 'path');
				$documentsList[$i]['fileid'] = $db->query_result($documentRes, $i, 'attachmentsid');
				$documentsList[$i]['attachment'] = decode_html($db->query_result($documentRes, $i, 'name'));
                $documentsList[$i]['type'] = $db->query_result($documentRes, $i, 'type');
			}
		}
		return $documentsList;
	}

	/**
	 * Function to get File size
	 * @param <Integer> $filesize
	 * @return <String> filesize
	 */
	public function getFormattedFileSize($filesize) {
		if($filesize < 1024) {
			$filesize = sprintf("%0.2f",round($filesize, 2)).'B';
		} else if($filesize > 1024 && $filesize < 1048576) {
			$filesize = sprintf("%0.2f",round($filesize/1024, 2)).'KB';
		} else if($filesize > 1048576) {
			$filesize = sprintf("%0.2f",round($filesize/(1024*1024), 2)).'MB';
		}
		return $filesize;
	}

	/**
	 * Function to save details of document and email
	 */
	public function saveDocumentDetails() {
		$db = PearDatabase::getInstance();
		$record = $this->getId();

		$documentIds = array_unique($this->get('documentids'));

		$count = count($documentIds);
		for ($i=0; $i<$count; $i++) {
			$db->pquery("INSERT INTO vtiger_senotesrel(crmid, notesid) VALUES(?, ?)", array($record, $documentIds[$i]));
		}
	}

    /**
     * Function which will remove all the exising document links with email
     * @param <Array> $idList - array of ids
     */
    public function deleteDocumentLink($idList = array()){
        $db = PearDatabase::getInstance();
        $query =  'DELETE FROM vtiger_senotesrel where crmid=?';
        $params = array($this->getId());
        if(count($idList) > 0) {
            $query .= 'AND notesid IN ('.generateQuestionMarks($idList).')';
            $params = array_merge($params,$idList);
        }
        $db->pquery($query,$params);
    }

    /**
     * Function which will delete the existing attachments for the emails
     * @param <Array> $emailAttachmentDetails - array of value which will be having fileid key as attachement id which need to be deleted
     */
    public function deleteAttachment($emailAttachmentDetails = array()) {
        $db = PearDatabase::getInstance();

        if(count($emailAttachmentDetails) <= 0) {
            return;
        }
        $attachmentIdList = array();
        foreach($emailAttachmentDetails as $index => $attachInfo){
            $attachmentIdList[] = $attachInfo['fileid'];
        }

        $db->pquery('UPDATE vtiger_crmentity SET deleted=0 WHERE crmid IN('.generateQuestionMarks($attachmentIdList).')',$attachmentIdList);
        $db->pquery('DELETE FROM vtiger_attachments WHERE attachmentsid IN('.generateQuestionMarks($attachmentIdList).')',$attachmentIdList);
        $db->pquery('DELETE FROM vtiger_seattachmentsrel WHERE crmid=? and attachmentsid IN('.generateQuestionMarks($attachmentIdList).')',
                array_merge(array($this->getId()),$attachmentIdList));

    }

	/**
	 * Function to check the total size of files is morethan max upload size or not
	 * @param <Array> $documentIds
	 * @return <Boolean> true/false
	 */
	public function checkUploadSize($documentIds = false) {
		global $log;
		$log->debug('uploadsize in record emails model line 497');
		$log->debug(count($documentIds));
		$totalFileSize = 0;
		if (!empty ($_FILES)) {
			foreach ($_FILES as $fileDetails) {
				$log->debug('checkuploadsize line 503');
				$log->debug((int) $fileDetails['size']);
				$totalFileSize = $totalFileSize + (int) $fileDetails['size'];
			}
		}
		if (!empty ($documentIds)) {
   	$log->debug('checkuploadsize line 509');

			$count = count($documentIds);
			for ($i=0; $i<$count; $i++) {
		$log->debug('checkuploadsize line 513');

				$documentRecordModel = Vtiger_Record_Model::getInstanceById($documentIds[$i], 'Documents');
				$totalFileSize = $totalFileSize + (int) $documentRecordModel->get('filesize');
								$log->debug('checkuploadsize line 517');
				$log->debug((int) $documentRecordModel->get('filesize'));

			}
		}
		$log->debug('########################uploadsize in record emails model line 512');
		$log->debug($totalFileSize);
		$log->debug(vglobal('upload_maxsize'));
		if ($totalFileSize > vglobal('upload_maxsize')) {
			return false;
		}
		return true;
	}

	/**
	 * Function to get Track image details
	 * @param <Integer> $crmId
	 * @param <boolean> $emailTrack true/false
	 * @return <String>
	 */
	public function getTrackImageDetails($crmId, $emailTrack = true) {
		$siteURL = vglobal('site_URL');
		$applicationKey = vglobal('application_unique_key');
		$emailId = $this->getId();

		$trackURL = "$siteURL/modules/Emails/actions/TrackAccess.php?record=$emailId&parentId=$crmId&applicationKey=$applicationKey";
		$imageDetails = "<img src='$trackURL' alt='' width='0' height='0' style='display: none;'>";
		return $imageDetails;
	}


	/**
	 * Function check email track enabled or not
	 * @return <boolean> true/false
	 */
	public function isEmailTrackEnabled() {
		//In future this track will be coming from client side/User preferences
		return true;
	}

	/**
	 * Function to update Email track details
	 * @param <String> $parentId
	 */
	public function updateTrackDetails($parentId) {
		$db = PearDatabase::getInstance();
		$recordId = $this->getId();

		$db->pquery("INSERT INTO vtiger_email_access(crmid, mailid, accessdate, accesstime) VALUES(?, ?, ?, ?)", array($parentId, $recordId, date('Y-m-d'), date('Y-m-d H:i:s')));

		$result = $db->pquery("SELECT 1 FROM vtiger_email_track WHERE crmid = ? AND mailid = ?", array($parentId, $recordId));
		if ($db->num_rows($result)>0) {
			$db->pquery("UPDATE vtiger_email_track SET access_count = access_count+1 WHERE crmid = ? AND mailid = ?", array($parentId, $recordId));
		} else {
			$db->pquery("INSERT INTO vtiger_email_track(crmid, mailid, access_count) values(?, ?, ?)", array($parentId, $recordId, 1));
		}
	}

	/**
	 * Function to set Access count value by default as 0
	 */
	public function setAccessCountValue() {
		$record = $this->getId();
		$moduleName = $this->getModuleName();

		$focus = new $moduleName();
		$focus->setEmailAccessCountValue($record);
	}

	/**
	 * Function to get Access count value
	 * @param <String> $parentId
	 * @return <String>
	 */
	public function getAccessCountValue($parentId) {
		$db = PearDatabase::getInstance();

		$result = $db->pquery("SELECT access_count FROM vtiger_email_track WHERE crmid = ? AND mailid = ?", array($parentId, $this->getId()));
		return $db->query_result($result, 0, 'access_count');
	}

	/**
	 * Function checks if the mail is sent or not
	 * @return <Boolean>
	 */
	public function isSentMail(){
		if(!array_key_exists('email_flag', $this->getData())){
			$db = PearDatabase::getInstance();
			$query = 'SELECT email_flag FROM vtiger_emaildetails WHERE emailid=?';
			$result = $db->pquery($query,array($this->getId()));
			if($db->num_rows($result)>0) {
				$this->set('email_flag',$db->query_result($result,0,'email_flag'));
			} else {
				//If not row exits then make it as false
				return false;
			}
		}
		if($this->get('email_flag') == "SENT"){
			return true;
		}
		return false;
	}

        //Opensource fix for data updation for mail attached from mailmanager
        public function isFromMailManager(){ 
            if(!array_key_exists('email_flag', $this->getData())){ 
                    $db = PearDatabase::getInstance(); 
                    $query = 'SELECT email_flag FROM vtiger_emaildetails WHERE emailid=?'; 
                    $result = $db->pquery($query,array($this->getId())); 
                    if($db->num_rows($result)>0) { 
                            $this->set('email_flag',$db->query_result($result,0,'email_flag')); 
                    } else { 
                            //If not row exits then make it as false 
                            return false; 
                    } 
            } 
            if($this->get('email_flag') == "MailManager"){ 
                    return true; 
            } 
            return false; 
        } 
	function getEntityType($id) {
		$db = PearDatabase::getInstance();
		$moduleModel = $this->getModule();
		$emailRelatedModules = $moduleModel->getEmailRelatedModules();
		$relatedModule = '';
		if (!empty($id)) {
			$sql = "SELECT setype FROM vtiger_crmentity WHERE crmid=?";
			$result = $db->pquery($sql, array($id));
			$relatedModule = $db->query_result($result, 0, "setype");

			if(!in_array($relatedModule, $emailRelatedModules)){
				$sql = 'SELECT id FROM vtiger_users WHERE id=?';
				$result = $db->pquery($sql, array($id));
				if($db->num_rows($result) > 0){
					$relatedModule = 'Users';
				}
			}
		}
		return $relatedModule;
	}
/** Attachments display  in Related List View Purpose added this
	 * Function returns the attachment details for a email
	 * @return <Array> List of attachments
	 */
	function getEmailRelatedAttachmentDetails($id) {
		$db = PearDatabase::getInstance();

		$attachmentRes = $db->pquery("SELECT * FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_attachments.attachmentsid = vtiger_seattachmentsrel.attachmentsid
						WHERE vtiger_seattachmentsrel.crmid = ?", array($id));
		$numOfRows = $db->num_rows($attachmentRes);
        $attachmentsList = array();
		if($numOfRows) {
			for($i=0; $i<$numOfRows; $i++) {
				$attachmentsList[$i]['fileid'] = $db->query_result($attachmentRes, $i, 'attachmentsid');
				$attachmentsList[$i]['attachment'] = decode_html($db->query_result($attachmentRes, $i, 'name'));
                $path = $db->query_result($attachmentRes, $i, 'path');
				$attachmentsList[$i]['path'] = $path;
                $attachmentsList[$i]['size'] = filesize($path.$attachmentsList[$i]['fileid'].'_'.$attachmentsList[$i]['attachment']);
                $attachmentsList[$i]['type'] = $db->query_result($attachmentRes, $i, 'type');
			}
		}

		$documentsList = $this->getEmailRelatedDocuments($id);

        //Attachments are getting duplicated when forwarding a mail in Mail Manager.
		if($documentsList) {
			foreach ($documentsList as $document) {
				$flag = false;
				foreach ($attachmentsList as $attachment) {
					if($attachment['fileid'] == $document['fileid']) {
						$flag = true;
						break;
					}
				}
				if(!$flag) $attachmentsList[] = $document;
			}
		}

		return $attachmentsList;
	}
		/**
	 * Function returns the document details for a email
	 * @return <Array> List of Documents
	 */
	public function getEmailRelatedDocuments($id) {
		$db = PearDatabase::getInstance();

		$documentRes = $db->pquery("SELECT * FROM vtiger_senotesrel
						INNER JOIN vtiger_crmentity ON vtiger_senotesrel.notesid = vtiger_crmentity.crmid AND vtiger_senotesrel.crmid = ?
						INNER JOIN vtiger_notes ON vtiger_notes.notesid = vtiger_senotesrel.notesid
						INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.crmid = vtiger_notes.notesid
						INNER JOIN vtiger_attachments ON vtiger_attachments.attachmentsid = vtiger_seattachmentsrel.attachmentsid
						WHERE vtiger_crmentity.deleted = 0", array($id));
		$numOfRows = $db->num_rows($documentRes);

		if($numOfRows) {
			for($i=0; $i<$numOfRows; $i++) {
				$documentsList[$i]['name'] = $db->query_result($documentRes, $i, 'filename');
				$filesize = $db->query_result($documentRes, $i, 'filesize');
				$documentsList[$i]['size'] = $this->getFormattedFileSize($filesize);
				$documentsList[$i]['docid'] = $db->query_result($documentRes, $i, 'notesid');
				$documentsList[$i]['path'] = $db->query_result($documentRes, $i, 'path');
				$documentsList[$i]['fileid'] = $db->query_result($documentRes, $i, 'attachmentsid');
				$documentsList[$i]['attachment'] = $db->query_result($documentRes, $i, 'name');
                $documentsList[$i]['type'] = $db->query_result($documentRes, $i, 'type');
			}
		}
		return $documentsList;
	}

}
