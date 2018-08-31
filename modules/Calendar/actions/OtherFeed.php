<?php
class Calendar_OtherFeed_Action extends Calendar_Feed_Action {
	public function process(Vtiger_Request $request) {
		try {
			$result = array();

			$start = $request->get('start');
			$end   = $request->get('end');
			$type = $request->get('type');
			$userid = $request->get('userid');
			$color = $request->get('color');
			$textColor = $request->get('textColor');
			
			switch ($type) {
				case 'Events': $this->pullCurrentUserEvents($start, $end, $result,$userid,$color,$textColor); break;
				//case 'Calendar': $this->pullTasks($start, $end, $result,$color,$textColor); break;
				case 'MultipleEvents' : $this->pullMultipleCurrentUserEvents($start,$end, $result,$request->get('mapping'));break;
				
			}
			echo json_encode($result);
		} catch (Exception $ex) {
			echo $ex->getMessage();
		}
	}
public function pullCurrentUserEvents($start, $end, &$result, $userid = false,$color = null,$textColor = 'white') {
		$dbStartDateOject = DateTimeField::convertToDBTimeZone($start);
		$dbStartDateTime = $dbStartDateOject->format('Y-m-d H:i:s');
		$dbStartDateTimeComponents = explode(' ', $dbStartDateTime);
		$dbStartDate = $dbStartDateTimeComponents[0];
		
		$dbEndDateObject = DateTimeField::convertToDBTimeZone($end);
		$dbEndDateTime = $dbEndDateObject->format('Y-m-d H:i:s');
		
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$moduleModel = Vtiger_Module_Model::getInstance('Events');
		if($userid){
			$focus = new Users();
			$focus->id = $userid;
			$focus->retrieve_entity_info($userid, 'Users');
			$user = Users_Record_Model::getInstanceFromUserObject($focus);
			$userName = $user->getName();
			$queryGenerator = new QueryGenerator($moduleModel->get('name'), $user);
		}else{
			$queryGenerator = new QueryGenerator($moduleModel->get('name'), $currentUser);
		}

		$queryGenerator->setFields(array('subject', 'eventstatus', 'visibility','date_start','time_start','due_date','time_end','assigned_user_id','id','activitytype'));
		$query = $queryGenerator->getQuery();


		$query.= " AND vtiger_activity.activitytype NOT IN ('Emails','Task') AND vtiger_invitees.inviteeid=".$currentUser->getId()."  and ";
        $hideCompleted = $currentUser->get('hidecompletedevents');
        if($hideCompleted)
            $query.= "vtiger_activity.eventstatus != 'HELD' AND ";
		$query.= " ((concat(date_start, '', time_start)  >= '$dbStartDateTime' AND concat(due_date, '', time_end) < '$dbEndDateTime') OR ( due_date >= '$dbStartDate'))";
		
        $params = array();
		if(empty($userid)){
            $eventUserId  = $currentUser->getId();
        }else{
            $eventUserId = $userid;
        }
        $params = array_merge(array($eventUserId), $this->getGroupsIdsForUsers($eventUserId));
		$query .= " AND vtiger_crmentity.smownerid IN (".  generateQuestionMarks($params).")";

		$inviteesquery = " LEFT JOIN vtiger_invitees on vtiger_invitees.activityid = vtiger_activity.activityid ";
		$fquery = explode("WHERE",$query);

		$query = $fquery[0].$inviteesquery." WHERE ".$fquery[1];

		$queryResult = $db->pquery($query, $params);

		while($record = $db->fetchByAssoc($queryResult)){
			$item = array();
			$crmid = $record['activityid'];
			$visibility = $record['visibility'];
            $activitytype = $record['activitytype'];
            $status = $record['eventstatus'];
			$item['id'] = $crmid;
			$item['inviteeid'] = $eventUserId;
			$item['visibility'] = $visibility;
			$item['activitytype'] = $activitytype;
            $item['status'] = $status;
			if(!$currentUser->isAdminUser() && $visibility == 'Private' && $userid && $userid != $currentUser->getId()) {
				$item['title'] = decode_html($userName).' - '.decode_html(vtranslate('Busy','Events')).'*';
				$item['url']   = '';
			} else {
				$item['title'] = decode_html($record['subject']) . ' - (' . decode_html(vtranslate($record['eventstatus'],'Calendar')) . ')';
				$item['url']   = sprintf('index.php?module=Calendar&view=Detail&record=%s', $crmid);
			}

			$dateTimeFieldInstance = new DateTimeField($record['date_start'] . ' ' . $record['time_start']);
			$userDateTimeString = $dateTimeFieldInstance->getFullcalenderDateTimevalue($currentUser);
			$dateTimeComponents = explode(' ',$userDateTimeString);
			$dateComponent = $dateTimeComponents[0];
			//Conveting the date format in to Y-m-d . since full calendar expects in the same format
			$dataBaseDateFormatedString = DateTimeField::__convertToDBFormat($dateComponent, $currentUser->get('date_format'));
			$item['start'] = $dataBaseDateFormatedString.' '. $dateTimeComponents[1];

			$dateTimeFieldInstance = new DateTimeField($record['due_date'] . ' ' . $record['time_end']);
			$userDateTimeString = $dateTimeFieldInstance->getFullcalenderDateTimevalue($currentUser);
			$dateTimeComponents = explode(' ',$userDateTimeString);
			$dateComponent = $dateTimeComponents[0];
			//Conveting the date format in to Y-m-d . since full calendar expects in the same format
			$dataBaseDateFormatedString = DateTimeField::__convertToDBFormat($dateComponent, $currentUser->get('date_format'));
			$item['end']   =  $dataBaseDateFormatedString.' '. $dateTimeComponents[1];


			$item['className'] = $cssClass;
			$item['allDay'] = false;
			$item['color'] = $color;
			$item['textColor'] = $textColor;
            $item['module'] = $moduleModel->getName();
			$result[] = $item;
			}
		}
		public function pullMultipleCurrentUserEvents($start, $end, &$result, $data) {

		foreach ($data as $id=>$backgroundColorAndTextColor) {
			$userEvents = array();
			$colorComponents = explode(',',$backgroundColorAndTextColor);
			$this->pullCurrentUserEvents($start, $end, $userEvents ,$id, $colorComponents[0], $colorComponents[1]);
			$result[$id] = $userEvents;
		}
	}

}
?>