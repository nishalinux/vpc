<meta content="text/html;charset=utf-8" http-equiv="Content-Type">
<meta content="utf-8" http-equiv="encoding">
<?php
require_once('modules/Emails/mail.php');
require_once 'include/fields/DateTimeField.php';
require_once 'data/CRMEntity.php';

DailyActivityMail();
function DailyActivityMail(){
	global $adb;
	global $HELPDESK_SUPPORT_EMAIL_ID;//main@benchmarklabs.com
	$today = Date('Y-m-d');
	//echo $today."/==/";
	//echo $HELPDESK_SUPPORT_EMAIL_ID;
	$userquery = "select id, user_name, email1, time_zone from vtiger_users where status='Active'";
	$userresult = $adb->pquery($userquery);
	$rows_user = $adb->num_rows($userresult);
	
	if($rows_user>0){
			 for($i=0; $i<$rows_user; $i++){
				 $id = $adb->query_result($userresult, $i, "id");
				 $user_name = $adb->query_result($userresult, $i, "user_name");
				 $user_email = $adb->query_result($userresult, $i, "email1");
				 $timezone = $adb->query_result($userresult, $i, "time_zone");
				 $c_query = "select vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.eventstatus, vtiger_activity.time_start, vtiger_activity.time_end, vtiger_activity.activitytype,vtiger_activity.location, vtiger_crmentity.description from vtiger_activity,vtiger_crmentity
				  where 
				  vtiger_activity.activityid=vtiger_crmentity.crmid and
				  setype='Calendar' and 
				  deleted=0 and 
				  date_start=? and 
				  smownerid=?";
				 $c_result = $adb->pquery($c_query, array($today, $id));
				 $c_rows = $adb->num_rows($c_result);
				 
				 if($c_rows>0){
					 $table = "Dear ".$user_name.", <br><br>Scheduled activities for the date ".$today."<br><br>";
					 $table .= "<table width='100%' border='2' cellspacing='0' cellpadding='0' bordercolor='#3366cc' style='border-radius:4px;'>";
					 $table .= "<th style='background-color: #fd9a00;'>Subject</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Status</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Type Of Activtiy</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Related to</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Start Time</th>";
					 $table .= "<th style='background-color: #fd9a00;'>End Time</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Location</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Description</th>";
					 $table .= "<th style='background-color: #fd9a00;'>Invitees</th>";
					 for($j=0; $j<$c_rows; $j++){
						 $actid = $adb->query_result($c_result, $j, "activityid");
						 $sub = $adb->query_result($c_result, $j, "subject");
						 $Stat = $adb->query_result($c_result, $j, "eventstatus");
						 $TOA = $adb->query_result($c_result, $j, "activitytype");
						 $StDt = $adb->query_result($c_result, $j, "time_start");
						 $DuDt = $adb->query_result($c_result, $j, "time_end");
						 $loc = $adb->query_result($c_result, $j, "location");
						 $desc = $adb->query_result($c_result, $j, "description");
						 
						 //Date Format--start
						//$userModel = Users_Privileges_Model::getCurrentUserModel();
						//echo $StDt."----".$DuDt;echo"<br>";
						// if($userModel->get('hour_format') == '12'){
						//$inviteeUser = CRMEntity::getInstance('Users');
						//$inviteeUser->retrieveCurrentUserInfoFromFile($id);
						//$St_Dt = new DateTimeField($StDt);
						//$Du_Dt = new DateTimeField($DuDt);
						//$SD = getTranslatedString($inviteeUser->time_zone, 'Users');
						//$ED = getTranslatedString($inviteeUser->time_zone, 'Users');
						//$startDate->getDisplayDateTimeValue($inviteeUser);
								//$StDt = DateTimeField::convertToUserFormat($StDt, $id);
								//$DuDt = DateTimeField::convertToUserFormat($DuDt, $id);
							//}
						//echo $StDt."++++".$DuDt;exit();
						//Date Format--end
						 
						$table .= "<tr style='background-color: #e6f2ff;'>";
						$table .= "<td align='center'>$sub</td>";
						$table .= "<td align='center'>$Stat</td>";
						$table .= "<td align='center'>$TOA</td>";
						
						//related to--start
						$cq = "select * from vtiger_cntactivityrel where vtiger_cntactivityrel.activityid=?";
						$cq_res = $adb->pquery($cq, array($actid));
						$cq_rows = $adb->num_rows($cq_res);
						
						if($cq_rows>0){
						for($p=0; $p<$c_rows; $p++){
						 $p_query = "select vtiger_contactdetails.firstname, vtiger_contactdetails.lastname from vtiger_contactdetails, vtiger_cntactivityrel where vtiger_contactdetails.contactid=vtiger_cntactivityrel.contactid and vtiger_cntactivityrel.activityid=?";
						 $p_result = $adb->pquery($p_query, array($actid));
						 $p_rows = $adb->num_rows($p_result);
						 $p_strng = '';
							for($t=0; $t<$p_rows; $t++){
							$fname = $adb->query_result($p_result, $t, "firstname");
							$lname = $adb->query_result($p_result, $t, "lastname");
							//array_push($usr_strng, $uname);
							$p_strng .= $fname.' '.$lname."<br>";
							
								}
							 $p_list = rtrim($p_strng,'\n');
							
						} 
						 $table .= "<td align='center'>$p_list</td>";
						}else{
						 $table .= "<td align='center'></td>";
						 }
						
						//related to--end 
						
						
						//$table .= "<td align='center'>$relatedto</td>";
						$table .= "<td align='center'>$StDt</td>";
						$table .= "<td align='center'>$DuDt</td>";
						$table .= "<td align='center'>$loc</td>";
						$table .= "<td align='center'>$desc</td>";
						//Invitees addition--start
						$iq = "select * from vtiger_invitees where vtiger_invitees.activityid=?";
						$iq_res = $adb->pquery($iq, array($actid));
						$iq_rows = $adb->num_rows($iq_res);
						
						if($iq_res>0){
						for($k=0; $k<$c_rows; $k++){
						 $i_query = "select vtiger_users.user_name from vtiger_users, vtiger_invitees where vtiger_users.id=vtiger_invitees.inviteeid and vtiger_invitees.activityid=?";
						 $i_result = $adb->pquery($i_query, array($actid));
						 $i_rows = $adb->num_rows($i_result);
						 $usr_strng = '';
							for($x=0; $x<$i_rows; $x++){
							$uname = $adb->query_result($i_result, $x, "user_name");
							//array_push($usr_strng, $uname);
							$usr_strng .= $uname." <br>";
							
								}
							 $usr_list = rtrim($usr_strng,'\n');
							
						} 
						$table .= "<td align='center'>$usr_list</td>";
						}else{
						$table .= "<td align='center'></td>";
						}
						////Invitees addition--end
					
						$table .= "</tr>";
						 
						 }
					$table .="</table>";
					$table .= "<br/><br/> Best Regards,<br/>Theracann Team.<br>";
					echo $table;
					send_mail('',$user_email,'',$HELPDESK_SUPPORT_EMAIL_ID,'Your activities for the day',$table,'','','','','',true);
					 }
			}
		}
}	
?>
