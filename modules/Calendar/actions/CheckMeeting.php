<?php 
class Calendar_CheckMeeting_action extends Vtiger_BasicAjax_Action {
public function process(Vtiger_Request $request){
			global $adb;
			//$adb->setDebug(true);
			$selectedusers = explode(";",$request->get('inviteeusers'));
			$startTime = Vtiger_Time_UIType::getTimeValueWithSeconds($request->get('time_start'));
			$startDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('date_start')." ".$startTime);
			list($startDate, $startTime) = explode(' ', $startDateTime);

			$endTime = $request->get('time_end');
			$endDate = Vtiger_Date_UIType::getDBInsertedValue($request->get('due_date'));

			$endTime = Vtiger_Time_UIType::getTimeValueWithSeconds($endTime);
			$endDateTime = Vtiger_Datetime_UIType::getDBDateTimeValue($request->get('due_date')." ".$endTime);
			list($endDate, $endTime) = explode(' ', $endDateTime);

			$record = $request->get('record');
			$assignedtouser = $request->get('assignedtouser');
			global $adb;
			//$adb->setDebug(true);
			//$query = "SELECT vtiger_activity.activityid as actid FROM  vtiger_activity INNER join vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_activity.activityid WHERE vtiger_crmentity.crmid = vtiger_activity.activityid and deleted=0 AND ( (DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') BETWEEN '".$startDateTime."' 	AND '".$endDateTime."' ) OR ( DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') BETWEEN '".$startDateTime."' AND '".$endDateTime."' ) OR ( ('".$startDateTime."' BETWEEN DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND DATE_FORMAT(concat(due_date,' ',time_end),'%Y-%m-%d %H:%i') ) AND ('".$endDateTime."' BETWEEN DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i')) ) )";
				//Modified on Aug 25 2018
		$query = "SELECT vtiger_activity.activityid as actid FROM  vtiger_activity INNER join vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_activity.activityid WHERE vtiger_crmentity.crmid = vtiger_activity.activityid and deleted=0 AND ( (DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') > '".$startDateTime."' 	AND  DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') < '".$endDateTime."' ) OR ( DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') > '".$startDateTime."' AND  DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') < '".$endDateTime."' ) OR ( ('".$startDateTime."' > DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND '".$startDateTime."' < DATE_FORMAT(concat(due_date,' ',time_end),'%Y-%m-%d %H:%i') ) AND ('".$endDateTime."' > DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND '".$endDateTime."' < DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i')) ) )";

			$firstquery = $query." and smownerid=? ";
		if(!empty($record)){
			$firstquery = $firstquery."   and vtiger_activity.activityid not in ('".$record."')";
		}else{
			$firstquery = $firstquery;
		}
		$query1 = $adb->pquery($firstquery,array($assignedtouser));
		$rows = $adb->num_rows($query1);
		//To check in invitees.......
		$secondquery =  $query;
		if(!empty($record)){
		$secondquery = $query."  and vtiger_activity.activityid not in ('".$record."')";
		}
		$query2 = $adb->pquery($secondquery,array());
		$actrows = $adb->num_rows($query2);
		$users = array();
		$activities = array();
		for($k=0;$k<$actrows;$k++){
				$activities[] = $adb->query_result($query2,$k,'actid');
				
		}
		//$activities[] = $assignedtouser;
		if(count($activities) != 0 && $rows == 0){
			$usersquery = $adb->pquery("SELECT inviteeid FROM vtiger_activity left join vtiger_invitees on vtiger_invitees.activityid = vtiger_activity.activityid where vtiger_activity.activityid in (" . generateQuestionMarks($activities) . ") and inviteeid='".$assignedtouser."'",$activities);
			$urows = $adb->num_rows($usersquery);
			if($urows != ''){
				$rows = $urows;
			}
		}
		$response = new Vtiger_Response();
		$response->setResult($rows);
		$response->emit();
	}
public function CheckMeetingusers($request){
	global $adb;
			//$adb->setDebug(true);
			$selectedusers = explode(";",$request->get('inviteeusers'));
			$startDate =  $request->get('date_start');
			$startTime=$request->get('time_start');
			$startDateTime = $startDate.' '.$startTime;

			$endTime = $request->get('time_end');
			$endDate = $request->get('due_date');
			$endDateTime = $endDate.' '.$endTime;

			$record = $request->get('record');
			$assignedtouser = $request->get('assignedtouser');
			global $adb;
			//$adb->setDebug(true);
			$query = "SELECT vtiger_activity.activityid as actid FROM  vtiger_activity INNER join vtiger_crmentity ON vtiger_crmentity.crmid=vtiger_activity.activityid WHERE vtiger_crmentity.crmid = vtiger_activity.activityid and deleted=0 AND ( (DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') BETWEEN '".$startDateTime."' 	AND '".$endDateTime."' ) OR ( DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i') BETWEEN '".$startDateTime."' AND '".$endDateTime."' ) OR ( ('".$startDateTime."' BETWEEN DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND DATE_FORMAT(concat(due_date,' ',time_end),'%Y-%m-%d %H:%i') ) AND ('".$endDateTime."' BETWEEN DATE_FORMAT(concat(date_start,' ',time_start),'%Y-%m-%d %H:%i') AND DATE_FORMAT(concat(due_date,' ',time_end) ,'%Y-%m-%d %H:%i')) ) )";
			$firstquery = $query." and smownerid=? ";
		if(!empty($record)){
			$firstquery = $firstquery."   and vtiger_activity.activityid not in ('".$record."')";
		}else{
			$firstquery = $firstquery;
		}
		$query1 = $adb->pquery($firstquery,array($assignedtouser));
		$rows = $adb->num_rows($query1);
		//To check in invitees.......
		$secondquery =  $query;
		if(!empty($record)){
		$secondquery = $query."  and vtiger_activity.activityid not in ('".$record."')";
		}
		$query2 = $adb->pquery($secondquery,array());
		$actrows = $adb->num_rows($query2);
		$users = array();
		$activities = array();
		for($k=0;$k<$actrows;$k++){
				$activities[] = $adb->query_result($query2,$k,'actid');
				
		}
		//$activities[] = $assignedtouser;
		if(count($activities) != 0 && $rows == 0){
			$usersquery = $adb->pquery("SELECT inviteeid FROM vtiger_activity left join vtiger_invitees on vtiger_invitees.activityid = vtiger_activity.activityid where vtiger_activity.activityid in (" . generateQuestionMarks($activities) . ") and inviteeid='".$assignedtouser."'",$activities);
			$urows = $adb->num_rows($usersquery);
			if($urows != ''){
				$rows = $urows;
			}
		}
		return $rows;
}
}
?>