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
class OSSMailScanner_CreatedEmail_ScannerAction
{

	public function process(OSSMail_Mail_Model $mail)
	{
		global $log,$current_user;
		$adb = PearDatabase::getInstance();
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
			$log->debug("After that=".print_r($focus1,true));
			$log->debug('1='.$mail->getAccountOwner().',2='.$mail->get('subject').',3='.$mail->get('toaddress').',4='.$mail->get('fromaddress').',5='.$mail->get('reply_toaddress').',6='.$mail->get('ccaddress').',7='.$mail->get('bccaddress').',8='.$mail->get('from').',9='.$mail->get('body').',10='.$mail->get('clean').',11='.$mail->get('message_id').',12='.$mail->getTypeEmail(true).',13='.$mail->getFolder().',14='.$type.',15='.$account['user_id'].',16='.$fromIds.',17'.$toIds);

			$focus1->column_fields['assigned_user_id'] =  $mail->getAccountOwner();					
			$focus1->column_fields['subject'] =  $mail->get('subject');					
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
 
 
			$log->debug('ossmailview savedddddddddddddddddddddddddddddddddddddddddddddd');
			$mail->setMailCrmId($id);
			OSSMail_Record_Model::_SaveAttachements($id, $mail);
 			$updateQuery = "UPDATE vtiger_crmentity SET createdtime=?,smcreatorid=?,modifiedby=? WHERE crmid=?";
			$updateParams = array($mail->get('udate_formated'), $mail->getAccountOwner(), $mail->getAccountOwner(),$id);
			$adb->pquery($updateQuery, $updateParams);
			$updateQuery2 = "UPDATE vtiger_ossmailview SET date=?,id=? WHERE ossmailviewid=?";
			$updateParams2 = array($mail->get('udate_formated'), $mail->get('id'),$id);
			$adb->pquery($updateQuery2, $updateParams2);

		return $id;
	}
}
}
?>
