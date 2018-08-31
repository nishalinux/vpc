<?php

/**
 * OSSMailView Relation mail
 * @package YetiForce.Model
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
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
				$check = $db->pquery("select date,subject from vtiger_ossmailview where ossmailviewid=? ", array($mailId));
			$date = $db->query_result($check, 0, 'date');
			$subject = $db->query_result($check, 0, 'subject');
			$new_focus = new Activity();
			$new_focus->column_fields['subject']=$subject;
			$new_focus->column_fields['activitytype']='Emails';
			$new_focus->column_fields['date_start']='2018-04-26';
			$new_focus->column_fields['time_start']=date('H:m:s');
			$new_focus->column_fields['visibility']='all';
			$new_focus->column_fields['sendnotification']=1;
			$new_focus->save('Calendar');
            $activityid = $new_focus->id;

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
