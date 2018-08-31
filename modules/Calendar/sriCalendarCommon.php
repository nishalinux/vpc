<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/

/**
 * To get the lists of vtiger_users id who shared their calendar with specified user
 * @param $sharedid -- The shared user id :: Type integer
 * @returns $shared_ids -- a comma seperated vtiger_users id  :: Type string
 */
function getSharedCalendarId($sharedid)
{
	global $adb;
	$query = "SELECT * from vtiger_sharedcalendar where sharedid=?";
	$result = $adb->pquery($query, array($sharedid));
	if($adb->num_rows($result)!=0)
	{
		for($j=0;$j<$adb->num_rows($result);$j++)
			$userid[] = $adb->query_result($result,$j,'userid');
		$shared_ids = implode (",",$userid);
	}
	return $shared_ids;
}

/**
 * To get hour,minute and format
 * @param $starttime -- The date&time :: Type string
 * @param $endtime -- The date&time :: Type string
 * @param $format -- The format :: Type string
 * @returns $timearr :: Type Array
*/
function getaddEventPopupTime($starttime,$endtime,$format)
{
	$timearr = Array();
	list($sthr,$stmin) = explode(":",$starttime);
	list($edhr,$edmin)  = explode(":",$endtime);
	if($format == 'am/pm' || $format == '12')
	{
		$hr = $sthr+0;
		$timearr['startfmt'] = ($hr >= 12) ? "pm" : "am";
		if($hr == 0) $hr = 12;
		$timearr['starthour'] = twoDigit(($hr>12)?($hr-12):$hr);
		$timearr['startmin']  = $stmin;

		$edhr = $edhr+0;
		$timearr['endfmt'] = ($edhr >= 12) ? "pm" : "am";
		if($edhr == 0) $edhr = 12;
		$timearr['endhour'] = twoDigit(($edhr>12)?($edhr-12):$edhr);
		$timearr['endmin']    = $edmin;
		return $timearr;
	}
	if($format == '24')
	{
		$timearr['starthour'] = twoDigit($sthr);
		$timearr['startmin']  = $stmin;
		$timearr['startfmt']  = '';
		$timearr['endhour']   = twoDigit($edhr);
		$timearr['endmin']    = $edmin;
		$timearr['endfmt']    = '';
		return $timearr;
	}
}

/**
 * Function to get the vtiger_activity details for mail body
 * @param   string   $description       - activity description
 * @param   string   $from              - to differenciate from notification to invitation.
 * return   string   $list              - HTML in string format
 */
function getActivityDetails($description,$user_id,$from='')
{
	global $log,$current_user,$current_language;
	global $adb;
	require_once 'include/utils/utils.php';
	$mod_strings = return_module_language($current_language, 'Calendar');
	$log->debug("Entering getActivityDetails(".$description.") method ...");
	$updated = $mod_strings['LBL_UPDATED'];
	$created = $mod_strings['LBL_CREATED'];
    $reply = (($description['mode'] == 'edit')?"$updated":"$created");
	if($description['activity_mode'] == "Events")
	{
		$end_date_lable=$mod_strings['LBL_EDATE_TIME'];
	}
	else
	{
		$end_date_lable=$mod_strings['LBL_DUE_DATE'];
	}
	$arrayInvitess =$description['assign_type'];
	$finalInvitess='';
	if(sizeof($arrayInvitess)>0){
	for($i=0; $i<sizeof($arrayInvitess); $i++) {
           
            $finalInvitess.=getUserFullName( $arrayInvitess[$i]).',';
        }
	}
	$name = getUserFullName($user_id);

		$sign = nl2br($adb->query_result($adb->pquery("select signature from vtiger_users where id=?", array($current_user->id)),0,"signature"));
	// Show the start date and end date in the users date format and in his time zone
	$inviteeUser = CRMEntity::getInstance('Users');
	$inviteeUser->retrieveCurrentUserInfoFromFile($user_id);
	$startDate = new DateTimeField($description['st_date_time']);
	$endDate = new DateTimeField($description['end_date_time']);
//echo "<pre>";print_r($description);exit(0);
	if($from == "invite")
		$msg = getTranslatedString($mod_strings['LBL_ACTIVITY_INVITATION']);
	else
		$msg = getTranslatedString($mod_strings['LBL_ACTIVITY_NOTIFICATION']);
	$msg='';
	$reply='';
	$current_username = getUserFullName($current_user->id);
	$status = getTranslatedString($description['status'],'Calendar');
	$list = '<br><br>'.$msg.''.$reply.'<br> '.$mod_strings['LBL_DETAILS_STRING'].' :<br>';
	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_SUBJECT"].' : '.$description['subject'];
	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_SDATE_TIME"].' : '.$startDate->getDisplayDateTimeValue($inviteeUser) .' '.getTranslatedString($inviteeUser->time_zone, 'Users');
	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$end_date_lable.' : '.$endDate->getDisplayDateTimeValue($inviteeUser).' '.getTranslatedString($inviteeUser->time_zone, 'Users');
	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_STATUS"].' : '.$status;
	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_PRIORITY"].' : '.getTranslatedString($description['taskpriority']);
	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_RELATED_TO"].' : '.getTranslatedString($description['relatedto']);
	
        	$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_CONTACT_LIST"].' : '.$finalInvitess;
	
		$list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_LOCATION"].' : '.$description['location'];

        $list .= '<br>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$mod_strings["LBL_APP_DESCRIPTION"].' : '.$description['description'];
        $list .= '<br><br>'.$mod_strings["LBL_REGARDS_STRING"].' ,';
       if($sign!='')
		$list .= '<br><br>'.$sign.'.';
		else
		$list .= '<br><br>'.$current_username.'.';

        $log->debug("Exiting getActivityDetails method ...");
		return $list;
}

function twoDigit( $no ){
	if($no < 10 && strlen(trim($no)) < 2) return "0".$no;
	else return "".$no;
}

function sendInvitation($inviteesid,$mode,$subject,$desc)
{
	global $current_user,$mod_strings, $adb;
	require_once("modules/Emails/mail.php");
	$invites=$mod_strings['INVITATION'];
	$invitees_array = explode(';',$inviteesid);
	$subject = $invites.' : '.$subject;
	$record = $focus->id;
	foreach($invitees_array as $inviteeid)
	{
		if($inviteeid != '')
		{
			$description=getActivityDetails($desc,$inviteeid,"invite");
			$name = getUserFullName($inviteeid);
			$list = 'Dear '.$name.',';
			$description = $list.$description;
			$to_email = getUserEmailId('id',$inviteeid);
			//modified by murali to trigger mail to related contact 
			send_mail('Calendar',$to_email,$current_user->user_name,'',$subject,$description);
		}
		$description = '';
	}
}
function sendInvitationContacts($recordid,$mode,$subject,$desc)
{
	global $current_user,$mod_strings, $adb;
	//$adb->setDebug(true);
	$ccquery = "SELECT email,concat(firstname, ' ',lastname) as name
FROM vtiger_contactdetails, vtiger_crmentity, vtiger_activity, vtiger_cntactivityrel
WHERE vtiger_crmentity.crmid = vtiger_contactdetails.contactid
AND vtiger_contactdetails.contactid = vtiger_cntactivityrel.contactid
AND vtiger_activity.activityid = vtiger_cntactivityrel.activityid
AND vtiger_crmentity.deleted =0
AND vtiger_cntactivityrel.activityid =?";
	$ccresult = $adb->pquery($ccquery, array($recordid));
	$ccrows = $adb->num_rows($ccresult);
	$contactslist = array();
	for($i=0; $i<$ccrows; $i++)
	{
		$contactslist[0][$i] = $adb->query_result($ccresult,$i,"email");
		$contactslist[1][$i] = $adb->query_result($ccresult, $i, "name");
	}
	//murali--end
	require_once("modules/Emails/mail.php");
	$invites=$mod_strings['INVITATION'];
	$subject = $invites.' : '.$subject;
	$record = $focus->id;
	$currentuserid = $current_user->id;	
	for($i=0;$i<count($contactslist[0]);$i++){
		$contactid = $contactslist[0][$i];
		$contactname = $contactslist[1][$i];
		if(!empty($contactid)){
			$description=getActivityDetails($desc,$currentuserid," ");
			$list = 'Dear '.$contactname.',';
			$description = $list.$description;
			send_mail('Calendar',$contactid,$current_user->user_name,'',$subject,$description);
			//array_shift($em);
		}
		$description = '';
	}

}

// User Select Customization
/**
 * Function returns the id of the User selected by current user in the picklist of the ListView or Calendar view of Current User
 * return String -  Id of the user that the current user has selected
 */
function calendarview_getSelectedUserId() {
	global $current_user, $default_charset;
	$only_for_user = htmlspecialchars(strip_tags(vtlib_purifyForSql($_REQUEST['onlyforuser'])),ENT_QUOTES,$default_charset);
	if($only_for_user == '') $only_for_user = $current_user->id;
	return $only_for_user;
}

function calendarview_getSelectedUserFilterQuerySuffix() {
	global $current_user, $adb;
	$only_for_user = calendarview_getSelectedUserId();
	$qcondition = '';
	if(!empty($only_for_user)) {
		if($only_for_user != 'ALL') {
			// For logged in user include the group records also.
			if($only_for_user == $current_user->id) {
				$user_group_ids = fetchUserGroupids($current_user->id);
				// User does not belong to any group? Let us reset to non-existent group
				if(!empty($user_group_ids)) $user_group_ids .= ',';
				else $user_group_ids = '';
				$user_group_ids .= $current_user->id;
				$qcondition = " AND vtiger_crmentity.smownerid IN (" . $user_group_ids .")";
			} else {
				$qcondition = " AND vtiger_crmentity.smownerid = "  . $adb->sql_escape_string($only_for_user);
			}
		}
	}
	return $qcondition;
}

?>
