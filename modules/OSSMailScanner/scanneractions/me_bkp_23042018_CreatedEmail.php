<?php

/**
 * Mail scanner action creating mail
 * @package YetiForce.MailScanner
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
//include('modules/OSSMailView/OSSMailView.php');
class OSSMailScanner_CreatedEmail_ScannerAction
{

	public function process(OSSMail_Mail_Model $mail)
	{
		global $log;
				$adb = PearDatabase::getInstance();

		$log->debug('CreatedEmaildddddd');
		$id = 0;
		$folder = $mail->getFolder();
		$log->debug('CreatedEmailfolder='.$folder);
		$account = $mail->getAccount();
		$log->debug('CreatedEmailaccount='.print_r($account,true));
		$type = $mail->getTypeEmail();
		$log->debug('CreatedEmailtype='.$type);
		$mailId = $mail->getMailCrmId();
		$log->debug('CreatedEmailmailId='.$mailId);
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
			$log->debug('Line42='.print_r($mail,true));
			//$toIds = $fromIds = [];
			//$fromIds = array_merge($fromIds, $mail->findEmailAdress('fromaddress'));
			$fromIds = "ganeshv@vtigress.com";
			$log->debug('Line45='.print_r($fromIds,true));
			//$fromIds = array_merge($fromIds, $mail->findEmailAdress('reply_toaddress'));
			
			//$toIds = array_merge($toIds, $mail->findEmailAdress('toaddress'));
			//$toIds = array_merge($toIds, $mail->findEmailAdress('ccaddress'));
			//$toIds = array_merge($toIds, $mail->findEmailAdress('bccaddress'));
			$toIds = "sri@theracanncorp.com";
			$toIds = "sri@theracanncorp.com";
			$log->debug('Line47='.print_r($toIds,true));

			$log->debug('1='.$mail->getAccountOwner().',2='.$mail->get('subject').',3='.$mail->get('toaddress').',4='.$mail->get('fromaddress').',5='.$mail->get('reply_toaddress').',6='.$mail->get('ccaddress').',7='.$mail->get('bccaddress').',8='.$mail->get('from').',9='.$mail->get('body').',10='.$mail->get('clean').',11='.$mail->get('message_id').',12='.$mail->getTypeEmail(true).',13='.$mail->getFolder().',14='.$type.',15='.$account['user_id'].',16='.$fromIds.',17'.$toIds);

			
			//"INSERT INTO `vtiger_ossmailview`(  'from_email', 'to_email', 'subject', 'content', 'cc_email', 'bcc_email', 'id', 'mbox', 'uid', 'reply_to_email', 'ossmailview_sendtype', 'attachments_exist', 'rc_user', 'type', 'from_id', 'to_id', 'orginal_mail' VALUES ([value-3],[value-4],[value-5],[value-6],[value-7],[value-8],[value-9],[value-10],[value-11],[value-12],[value-13],[value-14],[value-15],[value-16],[value-17],[value-18],[value-19],[value-20],[value-21],[value-22])"
			/// $sql2222 = "INSERT INTO vtiger_ossmailview(from_email, to_email, subject, content, cc_email, bcc_email,  mbox, uid, reply_to_email, ossmailview_sendtype, attachments_exist, rc_user, type, from_id, to_id, orginal_mail ) values($mail->get('fromaddress'), $mail->get('toaddress'), $mail->get('subject'), $mail->get('body'), $mail->get('ccaddress'),$mail->get('bccaddress'),$mail->getFolder(),$mail->get('message_id'),$mail->get('reply_toaddress'),$mail->getTypeEmail(true),0,$account['user_id'],$type,$fromIds,$toIds,$mail->get('clean'))";
			 $sql2 = "INSERT INTO vtiger_ossmailview(from_email, to_email, subject, content, cc_email, bcc_email,  mbox, uid, reply_to_email, ossmailview_sendtype, attachments_exist, rc_user, type, from_id, to_id, orginal_mail ) values(?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?)";
			$params2 = array($mail->get('fromaddress'), $mail->get('toaddress'), $mail->get('subject'), $mail->get('body'), $mail->get('ccaddress'),$mail->get('bccaddress'),$mail->getFolder(),$mail->get('message_id'),$mail->get('reply_toaddress'),$mail->getTypeEmail(true),0,$account['user_id'],$type,$fromIds,$toIds,$mail->get('clean'));
			$result = $adb->pquery($sql2, $params2);
			$log->debug('Line47='.$sql2222);
			$log->debug('Line1111111147='.print_r($params2,true));

			$bccaddress = "ganeshv@vtigress.com";
			$from = "ganeshv@vtigress.com";
			$clean = "clean";

			$log->debug('1='.$mail->getAccountOwner().',2='.$mail->get('subject').',3='.$mail->get('toaddress').',4='.$mail->get('fromaddress').',5='.$mail->get('reply_toaddress').',6='.$mail->get('ccaddress').',7='.$mail->get('bccaddress').',8='.$mail->get('from').',9='.$mail->get('body').',10='.$mail->get('clean').',11='.$mail->get('message_id').',12='.$mail->getTypeEmail(true).',13='.$mail->getFolder().',14='.$type.',15='.$account['user_id'].',16='.$fromIds.',17'.$toIds);
			//require_once('modules/OSSMailView/OSSMailView.php');
			//$record = new OSSMailView();
			$record = new OSSMailView();
			$log->debug('ResultRecord0',print_r($record,true));
			$record->column_fields['assigned_user_id'] =  $mail->getAccountOwner();
			$log->debug('ResultRecord1',print_r($record,true));
			$record->column_fields['subject'] =  $mail->get('subject');
			$log->debug('ResultRecord2',print_r($record,true));
			$record->column_fields['to_email'] =  $mail->get('toaddress');
			$log->debug('ResultRecord3',print_r($record,true));
			$record->column_fields['from_email'] =  $mail->get('fromaddress');
			$log->debug('ResultRecord4',print_r($record,true));
			$record->column_fields['reply_to_email'] =  $mail->get('reply_toaddress');
			$log->debug('ResultRecord5',print_r($record,true));
			$record->column_fields['cc_email'] =  $mail->get('ccaddress');
			$log->debug('ResultRecord6',print_r($record,true));
			//$record->column_fields['bcc_email'] =  $mail->get('bccaddress');
			$record->column_fields['bcc_email'] =  $bccaddress;
			$log->debug('ResultRecord7',print_r($record,true));
			$log->debug('bcc_email',print_r($record,true));
			$log->debug('ResultRecord8',print_r($record,true));
			//$record->column_fields['fromaddress'] =  $mail->get('from');
			$record->column_fields['fromaddress'] =  $from;
			$log->debug('ResultRecord9',print_r($record,true));
			$record->column_fields['content'] =  $mail->get('body');
			$log->debug('ResultRecord10',print_r($record,true));
			//$record->column_fields['orginal_mail'] =  $mail->get('clean');
			$record->column_fields['orginal_mail'] =  $clean;
			$log->debug('ResultRecord11',print_r($record,true));
			$record->column_fields['uid'] =  $mail->get('message_id');
			$log->debug('ResultRecord12',print_r($record,true));
			$record->column_fields['ossmailview_sendtype'] =  $mail->getTypeEmail(true);
			$log->debug('ResultRecord13',print_r($record,true));
			$record->column_fields['mbox'] =  $mail->getFolder();
			$record->column_fields['type'] =  $type;
			$record->column_fields['rc_user'] =  $account['user_id'];
			$record->column_fields['from_id'] =  $fromIds;
			$record->column_fields['to_id'] =  $toIds;
			//$record->column_fields['from_id'] =  implode(',', array_unique($fromIds));
			//$record->column_fields['to_id'] =  implode(',', array_unique($toIds));
		//	if (count($mail->get('attachments')) > 0) {
		//		$record->column_fields['attachments_exist'] = 1;
		//	}
			$record->column_fields['mode'] =  'new';
			$log->debug('ResultRecord',print_r($record,true));
			//$record->column_fields['id'] =  '';
			$record->save();

			
			$id = $record->getId();
			$log->debug('idffff=',print_r($id,true));
			$mail->setMailCrmId($id);
			OSSMail_Record_Model::_SaveAttachements($id, $mail);
			$db = PearDatabase::getInstance();
			/*$db->update('vtiger_crmentity', [
				'createdtime' => $mail->get('udate_formated'),
				'smcreatorid' => $mail->getAccountOwner(),
				'modifiedby' => $mail->getAccountOwner()
				], 'crmid = ?', [$id]
			);*/
			$updateQuery = "UPDATE vtiger_crmentity SET createdtime=?,smcreatorid=?,modifiedby=? WHERE crmid=?";
			$updateParams = array($mail->get('udate_formated'), $mail->getAccountOwner(), $mail->getAccountOwner(),$id);
			$db->pquery($updateQuery, $updateParams);
			/*$db->update('vtiger_ossmailview', [
				'date' => $mail->get('udate_formated'),
				'id' => $mail->get('id')
				], 'ossmailviewid = ?', [$id]
			);*/
			$updateQuery2 = "UPDATE vtiger_ossmailview SET date=?,id=? WHERE ossmailviewid=?";
			$updateParams2 = array($mail->get('udate_formated'), $mail->get('id'),$id);
			$db->pquery($updateQuery2, $updateParams2);

		}
		$log->debug('CreatedEmailid='.$id);
		return $id;
	}
}
