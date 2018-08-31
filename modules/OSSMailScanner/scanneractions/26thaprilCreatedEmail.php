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
		global $log,$current_user;
				$adb = PearDatabase::getInstance();

		//$log->debug('CreatedEmaildddddd');
		$id = 0;
		$folder = $mail->getFolder();
		//$log->debug('CreatedEmailfolder='.$folder);
		$account = $mail->getAccount();
		//$log->debug('CreatedEmailaccount='.print_r($account,true));
		$type = $mail->getTypeEmail();
		//$log->debug('CreatedEmailtype='.$type);
		$mailId = $mail->getMailCrmId();
		//$log->debug('CreatedEmailmailId='.$mailId);
		$exceptionsAll = OSSMailScanner_Record_Model::getConfig('exceptions');

		if ($type == 0) {
					//$log->debug('CreatedEmailmailId 31');

			$mailForExceptions = $mail->get('toaddress');
		} else {
								//$log->debug('CreatedEmailmailId 35');

			$mailForExceptions = $mail->get('fromaddress');
		}

		if (!empty($exceptionsAll['crating_mails'])) {
			//$log->debug('CreatedEmailmailId 41');
			$exceptions = explode(',', $exceptionsAll['crating_mails']);
			foreach ($exceptions as $exception) {
				//$log->debug('CreatedEmailmailId 44');
				if (strpos($mailForExceptions, $exception) !== FALSE) {
					//$log->debug('CreatedEmailmailId 46');
					return $id;
				}
			}
		}
		//$log->debug('CreatedEmailmailId 51');
		if ($mailId === false && !empty($mail->get('message_id'))) {
			//$log->debug('Line42='.print_r($mail,true));
			$toIds='sri@theracanncorp.com';
			$fromIds='devteam@theracanncorp.com';
		    $noqqq= date('Y-m-d h:i:s');
			$current_id = $adb->getUniqueID("vtiger_crmentity");
			//$log->debug('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'.$current_id);

			$sql12 ="INSERT INTO vtiger_crmentity( crmid,smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime,   presence, deleted, label) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
			$params12 =array($current_id,$current_user->id,$current_user->id,$current_user->id,'Emails',$mail->get('subject'),$noqqq,$noqqq,0,1,$mail->get('subject'));
			//$log->debug($sql12);
			////$log->debug(print_R($params12,true));
			$adb->pquery($sql12, $params12);
		
			//$log->debug('1='.$mail->getAccountOwner().',2='.$mail->get('subject').',3='.$mail->get('toaddress').',4='.$mail->get('fromaddress').',5='.$mail->get('reply_toaddress').',6='.$mail->get('ccaddress').',7='.$mail->get('bccaddress').',8='.$mail->get('from').',9='.$mail->get('body').',10='.$mail->get('clean').',11='.$mail->get('message_id').',12='.$mail->getTypeEmail(true).',13='.$mail->getFolder().',14='.$type.',15='.$account['user_id'].',16='.$fromIds.',17'.$toIds);

			$sql2 = "INSERT INTO vtiger_ossmailview(from_email, to_email, subject, content, cc_email, bcc_email,  mbox, uid, reply_to_email, ossmailview_sendtype, attachments_exist, rc_user, type, from_id, to_id, orginal_mail ,date) values(?, ?, ?, ?, ?,?,?,?,?,?,?,?,?,?,?,?,?)";
			$params2 = array($mail->get('fromaddress'), $mail->get('toaddress'), $mail->get('subject'), $mail->get('body'), $mail->get('ccaddress'),$mail->get('bccaddress'),$mail->getFolder(),$mail->get('message_id'),$mail->get('reply_toaddress'),$mail->getTypeEmail(true),0,$account['user_id'],$type,$fromIds,$toIds,$mail->get('clean'),$noqqq);
			$result = $adb->pquery($sql2, $params2);
 			//$log->debug('Line1111111147='.print_r($params2,true));
            $crmid = $adb->getLastInsertID();
			//$log->debug('XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX'.$crmid);
			if($crmid>0){
							$mail->setMailCrmId($crmid);
			OSSMail_Record_Model::_SaveAttachements($crmid, $mail);
			
            $cid = $adb->getLastInsertID();
			//$log->debug('last inserte id '.$cid	);
			if($current_id>0){
			$seq = "UPDATE `vtiger_crmentity_seq` SET `id`=? WHERE 1";
			$seqparams = array($current_id);
			$adb->pquery($seq, $seqparams);
			
			}
			if($crmid>0){
			$updateQuery = "UPDATE vtiger_crmentity SET createdtime=?,smcreatorid=?,modifiedby=? WHERE crmid=?";
			$updateParams = array($mail->get('udate_formated'), $mail->getAccountOwner(), $mail->getAccountOwner(),$current_id);
			$adb->pquery($updateQuery, $updateParams);
			
			$updateQuery2 = "UPDATE vtiger_ossmailview SET date=?,id=? WHERE ossmailviewid=?";
			$updateParams2 = array($mail->get('udate_formated'), $mail->get('id'),$crmid);
			$adb->pquery($updateQuery2, $updateParams2);
			}
			}
		}
		//$log->debug('CreatedEmailid='.$crmid);
		return $crmid;
	}
}
?>
