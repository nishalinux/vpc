<?php

/**
 * Mail scanner action creating mail
 * @package YetiForce.MailScanner
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMailScanner_CreatedEmail_ScannerAction
{

	public function process(OSSMail_Mail_Model $mail)
	{
		global $log;
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
			$toIds = $fromIds = [];
			$fromIds = array_merge($fromIds, $mail->findEmailAdress('fromaddress'));
			$log->debug('Line45='.print_r($fromIds,true));
			$fromIds = array_merge($fromIds, $mail->findEmailAdress('reply_toaddress'));
			$log->debug('Line47='.print_r($fromIds,true));
			$toIds = array_merge($toIds, $mail->findEmailAdress('toaddress'));
			$toIds = array_merge($toIds, $mail->findEmailAdress('ccaddress'));
			$toIds = array_merge($toIds, $mail->findEmailAdress('bccaddress'));

			$record = Vtiger_Record_Model::getCleanInstance('OSSMailView');
			$log->debug('Line53',print_r($record,true));
			$record->set('assigned_user_id', $mail->getAccountOwner());
			$log->debug('Line55',print_r($record,true));
			$record->set('subject', $mail->get('subject'));
			$log->debug('Line57',print_r($record,true));
			$record->set('to_email', $mail->get('toaddress'));
			$log->debug('Line59',print_r($record,true));
			$record->set('from_email', $mail->get('fromaddress'));
			$log->debug('Line61',print_r($record,true));
			$record->set('reply_to_email', $mail->get('reply_toaddress'));
			$record->set('cc_email', $mail->get('ccaddress'));
			$record->set('bcc_email', $mail->get('bccaddress'));
			$record->set('fromaddress', $mail->get('from'));
			$record->set('content', $mail->get('body'));
			$record->set('orginal_mail', $mail->get('clean'));
			$record->set('uid', $mail->get('message_id'));
			$record->set('ossmailview_sendtype', $mail->getTypeEmail(true));
			$record->set('mbox', $mail->getFolder());
			$record->set('type', $type);
			$record->set('rc_user', $account['user_id']);
			$record->set('from_id', implode(',', array_unique($fromIds)));
			$record->set('to_id', implode(',', array_unique($toIds)));
			if (count($mail->get('attachments')) > 0) {
				$record->set('attachments_exist', 1);
			}
			$record->set('mode', 'new');
			$record->set('id', '');
			$record->save();
			$log->debug('assigned_user_id',print_r($record,true));
			$id = $record->getId();

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
