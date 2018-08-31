<?php

/**
 * OSSMailView Relation mail
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
require_once('modules/Emails/Emails.php');
class OSSMailView_Relation_Model extends Vtiger_Relation_Model
{

	public function addRelation($mailId, $crmid, $date = false)
	{
		global $log;
		$return = false;
		$db = PearDatabase::getInstance();
		$query = 'SELECT * FROM vtiger_ossmailview_relation WHERE ossmailviewid = ? AND crmid = ?';
		$result = $db->pquery($query, [$mailId, $crmid]);
		if ($db->getRowCount($result) == 0) {
			if (!$date) {
				$log->debug('add relation line numberrrrrrrrrrrrrrrrrrrrrrrrrr 21');
				$check = $db->pquery("select from_email,to_email,cc_email,bcc_email,mbox,date,subject,content from vtiger_ossmailview where ossmailviewid=? ", array($mailId));
				$date = $db->query_result($check, 0, 'date');
				$subject = $db->query_result($check, 0, 'subject');
				$content = $db->query_result($check, 0, 'content');
				$from_email = $db->query_result($check, 0, 'from_email');
				$to_email = $db->query_result($check, 0, 'to_email');
				$cc_email = $db->query_result($check, 0, 'cc_email');
				$bcc_email = $db->query_result($check, 0, 'bcc_email');
				$mbox = $db->query_result($check, 0, 'mbox');
				$content = htmlentities($content);
				//$content = html_entity_decode($content);
				$content = preg_replace("#<(.*)/(.*)>#iUs", "", $content);
				$content = html_entity_decode($content);
				$noteQuery = $db->pquery("SELECT notesid FROM vtiger_senotesrel WHERE crmid = $mailId");
				if($db->num_rows($noteQuery) > 0) {
					$content = preg_replace("#<(.*)/(.*)>#iUs", "", $content);
					$content = html_entity_decode($content);
				}
			$focus = new Emails();
			$focus->column_fields['parent_type'] = 'Vtiger';
			$focus->column_fields['activitytype'] = 'Emails';
			$focus->column_fields['parent_id'] = "$crmid@-1|";
			$focus->column_fields['subject'] = $subject;

			$focus->column_fields['description'] = $content;
			$focus->column_fields['assigned_user_id'] = 1;
			$focus->column_fields["date_start"] =  date("Y-m-d",strtotime($date));

			$focus->column_fields["time_start"] =date("H:i:s",strtotime($date));
			$focus->column_fields["email_flag"] = $mbox;

			$from=$from_email;
			$to = $to_email;
			$cc = (!empty($cc_email))? implode(',', $cc_email) : '';
			$bcc= (!empty($bcc_email))? implode(',', $bcc_email) : '';
			$flag=''; // 'SENT'/'SAVED'
			//emails field were restructured and to,bcc and cc field are JSON arrays
			$focus->column_fields['from_email'] = $from;
			$focus->column_fields['saved_toid'] = $to;
			$focus->column_fields['ccmail'] = $cc;
			$focus->column_fields['bccmail'] = $bcc;
			$focus->column_fields['visibility']='all';
			$focus->column_fields['sendnotification']=1;
			$focus->save('Emails');
//vtiger_ossmailview_files
			$activityid = $focus->id;
			//SELECT * FROM vtiger_senotesrel WHERE crmid = 
			$noteQuery = $db->pquery("SELECT notesid FROM vtiger_senotesrel WHERE crmid = $mailId");
			if($db->num_rows($noteQuery) > 0) {
				while($row = $db->fetch_array($noteQuery)){
					$notesid = $row['notesid'];
					//INSERT INTO vtiger_senotesrel(crmid, notesid) VALUES ([value-1],[value-2])
					$noteinsert = $db->pquery("INSERT INTO vtiger_senotesrel(crmid, notesid) VALUES ($activityid,$notesid)");
				}
			}

		//	$this->__SaveAttachements($mailId, 'Emails', $focus);
			/*$new_focus = new Activity();
			$new_focus->column_fields['subject']=$subject;
			$new_focus->column_fields['activitytype']='Emails';
			$new_focus->column_fields['date_start']='2018-04-26';
			$new_focus->column_fields['time_start']=date('H:m:s');
			$new_focus->column_fields['visibility']='all';
			$new_focus->column_fields['sendnotification']=1;
			$new_focus->save('Calendar');
            $activityid = $new_focus->id;*/

			$ossseq = "INSERT INTO vtiger_seactivityrel(crmid, activityid) VALUES (?,?)";
			$ossseqparams = array($crmid,$activityid);
			$db->pquery($ossseq, $ossseqparams);

			      

			}
			
			$params =array($mailId, $crmid,$date);
						//$log->debug('_saveAttachmentFileeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'.$saveasfile);

		//$adb->insert('vtiger_attachments', $params);
		$sql2 = "insert into vtiger_ossmailview_relation(ossmailviewid, crmid, date) values(?, ?, ?)";
			$result = $db->pquery($sql2, $params);


			if ($parentId = Users_Privileges_Model::getParentRecord($crmid)) {
				$query = 'SELECT * FROM vtiger_ossmailview_relation WHERE ossmailviewid = ? AND crmid = ?';
				$result = $db->pquery($query, [$mailId, $parentId]);
				if ($db->getRowCount($result) == 0) {
								$rrparams =array($mailId, $parentId,$date);
						//$log->debug('_saveAttachmentFileeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'.$saveasfile);

		//$adb->insert('vtiger_attachments', $params);
		$rrsql2 = "insert into vtiger_ossmailview_relation(ossmailviewid, crmid, date) values(?, ?, ?)";
			$result = $db->pquery($rrsql2, $rrparams);

					if ($parentId = Users_Privileges_Model::getParentRecord($parentId)) {
						$query = 'SELECT * FROM vtiger_ossmailview_relation WHERE ossmailviewid = ? AND crmid = ?';
						$result = $db->pquery($query, [$mailId, $parentId]);
						if ($db->getRowCount($result) == 0) {
							
						$rrparams2 =array($mailId, $parentId,$date);
						//$log->debug('_saveAttachmentFileeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'.$saveasfile);

		//$adb->insert('vtiger_attachments', $params);
		$rrsql22 = "insert into vtiger_ossmailview_relation(ossmailviewid, crmid, date) values(?, ?, ?)";
			$result = $db->pquery($rrsql22, $rrparams2);

						}
					}
				}
			}
			$return = true;
		}
		return $return;
	}





}
