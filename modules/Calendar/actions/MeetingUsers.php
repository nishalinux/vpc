<?php
class Calendar_MeetingUsers_action extends Vtiger_BasicAjax_Action {
	
public function process(Vtiger_Request $request){
			global $adb;
			$assigneduser = $request->get('assignedtouser');
			$invlist = $request->get('inviteeusers');//.";".$request->get('assignedtouser');
			$selectedusers = explode(";",$invlist);
			
			$startTime = Vtiger_Time_UIType::getTimeValueWithSeconds($request->get('time_start'));
			$startDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('date_start')." ".$startTime);
			list($startDate, $startTime) = explode(' ', $startDateTime);

			$endTime = $request->get('time_end');
			$endDate = Vtiger_Date_UIType::getDBInsertedValue($request->get('due_date'));

			$endTime = Vtiger_Time_UIType::getTimeValueWithSeconds($endTime);
			$endDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('due_date')." ".$endTime);
			list($endDate, $endTime) = explode(' ', $endDateTime);

			$record = $request->get('record');
			$invitees = array();
			//$adb->setDebug(true);
			//$query = "SELECT vtiger_activity.activityid as actid,smownerid FROM  vtiger_activity INNER join vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_activity.activityid WHERE vtiger_crmentity.crmid = vtiger_activity.activityid and deleted=0 AND ((DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') BETWEEN '".$startDateTime."' 	AND '".$endDateTime."' ) OR ( DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') BETWEEN '".$startDateTime."' AND '".$endDateTime."' ) OR ( ('".$startDateTime."' BETWEEN DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND DATE_FORMAT(concat(due_date,' ',time_end),'%Y-%m-%d %H:%i') ) AND ('".$endDateTime."' BETWEEN DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i')) )";
				//Modified on Aug 25 2018
		$query = "SELECT vtiger_activity.activityid as actid FROM  vtiger_activity INNER join vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_activity.activityid WHERE vtiger_crmentity.crmid = vtiger_activity.activityid and deleted=0 AND ( (DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') > '".$startDateTime."' 	AND  DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') < '".$endDateTime."' ) OR ( DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') > '".$startDateTime."' AND  DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') < '".$endDateTime."' ) OR ( ('".$startDateTime."' > DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND '".$startDateTime."' < DATE_FORMAT(concat(due_date,' ',time_end),'%Y-%m-%d %H:%i') ) AND ('".$endDateTime."' > DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND '".$endDateTime."' < DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i')) ) )";

		if(!empty($record)){
			$query = $query." ) and vtiger_activity.activityid not in ('".$record."')";
		}else{
			$query = $query." )";
		}
		$query1 = $adb->pquery($query,array());
			
			$rows = $adb->num_rows($query1);
			$users = array();
			$activities = array();
			for($k=0;$k<$rows;$k++){
				    $activities[] = $adb->query_result($query1,$k,'actid');
					$users[] = $adb->query_result($query1,$k,'smownerid');	
			}
			//There is chance of between two times so

			//Ended here
			if(count($activities) != 0){
				$usersquery = $adb->pquery("SELECT inviteeid FROM vtiger_activity left join vtiger_invitees on vtiger_invitees.activityid = vtiger_activity.activityid where vtiger_activity.activityid in (" . generateQuestionMarks($activities) . ")",$activities);
				$urows = $adb->num_rows($usersquery);
				for($kl=0;$kl<$urows;$kl++){
						$users[] = $adb->query_result($usersquery,$kl,'inviteeid');	
				}
			}
			$invitee = $adb->pquery("SELECT id,concat(first_name,' ',last_name) as name , time_zone from vtiger_users where id in (" . generateQuestionMarks($selectedusers) . ")",$selectedusers);
			
			$prorows = $adb->num_rows($invitee);
			if($prorows != 0){
				
				for($i=0;$i<$prorows;$i++){
					$userid = $adb->query_result($invitee,$i,'id');
					$invitees[$userid]['name'] = $adb->query_result($invitee,$i,'name');
					$invitees[$userid]['time_zone'] = $adb->query_result($invitee,$i,'time_zone')."(".vtranslate($adb->query_result($invitee,$i,'time_zone'),'Users').")";
					if(in_array($userid,$users)){
						$invitees[$userid]['possible'] = "No";
					}else{
						$invitees[$userid]['possible'] = "Yes";
					}
				}
			}
		$response = new Vtiger_Response();
		$response->setResult($invitees);
		$response->emit();
	}
}
?>