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
			
			$toIds = "sri@theracanncorp.com";
			$toIds = "sri@theracanncorp.com";
			$log->debug('Line47='.print_r($toIds,true));

			$log->debug('1='.$mail->getAccountOwner().',2='.$mail->get('subject').',3='.$mail->get('toaddress').',4='.$mail->get('fromaddress').',5='.$mail->get('reply_toaddress').',6='.$mail->get('ccaddress').',7='.$mail->get('bccaddress').',8='.$mail->get('from').',9='.$mail->get('body').',10='.$mail->get('clean').',11='.$mail->get('message_id').',12='.$mail->getTypeEmail(true).',13='.$mail->getFolder().',14='.$type.',15='.$account['user_id'].',16='.$fromIds.',17'.$toIds);

			
			$sql2 = "INSERT INTO vtiger_ossmailview(from_email, to_email, subject, content, cc_email, bcc_email,  mbox, uid, reply_to_email, ossmailview_sendtype, attachments_exist, rc_user, type, from_id, to_id, orginal_mail ) values(?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?)";
			$params2 = array($mail->get('fromaddress'), $mail->get('toaddress'), $mail->get('subject'), $mail->get('body'), $mail->get('ccaddress'),$mail->get('bccaddress'),$mail->getFolder(),$mail->get('message_id'),$mail->get('reply_toaddress'),$mail->getTypeEmail(true),0,$account['user_id'],$type,$fromIds,$toIds,$mail->get('clean'));
			$result = $adb->pquery($sql2, $params2);
			$log->debug('Line47='.$sql2222);
			$log->debug('Line1111111147='.print_r($params2,true));

			
			//$id = $record->getId();
			//$id= $mail->get('message_id');
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
