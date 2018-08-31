<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

function Contacts_sendCustomerPortalLoginDetails($entityData){
	$adb = PearDatabase::getInstance();
	$moduleName = $entityData->getModuleName();
	$wsId = $entityData->getId();
	$parts = explode('x', $wsId);
	$entityId = $parts[1];

	$email = $entityData->get('email');

	if ($entityData->get('portal') == 'on' || $entityData->get('portal') == '1') {
		$sql = "SELECT id, user_name, user_password, isactive FROM vtiger_portalinfo WHERE id=?";
		$result = $adb->pquery($sql, array($entityId));
		$insert = false;
		if($adb->num_rows($result) == 0){
			$insert = true;
		}else{
			$dbusername = $adb->query_result($result,0,'user_name');
			$isactive = $adb->query_result($result,0,'isactive');
			if($email == $dbusername && $isactive == 1 && !$entityData->isNew()){
				$update = false;
			} else if($entityData->get('portal') == 'on' ||  $entityData->get('portal') == '1'){
				$sql = "UPDATE vtiger_portalinfo SET user_name=?, isactive=1 WHERE id=?";
				$adb->pquery($sql, array($email, $entityId));
				$password = $adb->query_result($result,0,'user_password');
				$update = true;
			} else {
				$sql = "UPDATE vtiger_portalinfo SET user_name=?, isactive=? WHERE id=?";
				$adb->pquery($sql, array($email, 0, $entityId));
				$update = false;
			}
		}
		if($insert == true){
			$password = makeRandomPassword();
			$sql = "INSERT INTO vtiger_portalinfo(id,user_name,user_password,type,isactive) VALUES(?,?,?,?,?)";
			$params = array($entityId, $email, $password, 'C', 1);
			$adb->pquery($sql, $params);
		}

		if($insert == true || $update == true) {
			global $current_user,$HELPDESK_SUPPORT_EMAIL_ID, $HELPDESK_SUPPORT_NAME;
			require_once("modules/Emails/mail.php");
			$emailData = Contacts::getPortalEmailContents($entityData,$password,'LoginDetails');
			$subject = $emailData['subject'];
			$contents = $emailData['body'];
			send_mail('Contacts', $entityData->get('email'), $HELPDESK_SUPPORT_NAME, $HELPDESK_SUPPORT_EMAIL_ID, $subject, $contents,'','','','','',true);
		}
	} else {
		$sql = "UPDATE vtiger_portalinfo SET user_name=?,isactive=0 WHERE id=?";
		$adb->pquery($sql, array($email, $entityId));
	}
}

// reset Total 30 Day Orders after each 30 days
function Contacts_resetField(){

    $adb = PearDatabase::getInstance();
    $query="SELECT  c.contactid, cd.support_start_date,cd.support_end_date
                FROM vtiger_contactscf cf INNER JOIN vtiger_contactdetails  c ON c.contactid=cf.contactid
                INNER JOIN vtiger_customerdetails cd ON cd.customerid=cf.contactid
                INNER JOIN vtiger_crmentity cr ON cr.crmid=c.contactid
                WHERE  cr.deleted=0";
    $rs=$adb->pquery($query,array());
    while($row=$adb->fetchByAssoc($rs)){
        $contactid=$row['contactid'];
        $support_start_date=$row['support_start_date'];
         if($support_start_date=='') continue;
        $support_start_date=date_create($support_start_date);

        $currentDate= date_create();
        if($currentDate <$support_start_date) continue;

        $support_end_date=$row['support_end_date'];
        if($support_end_date !=''){
            $support_end_date=date_create($support_end_date);
            if($currentDate > $support_end_date) continue;
       }

        $diff=date_diff($support_start_date,$currentDate, false);
        $days= $diff->format("%R%a");
        if($days==0) continue;
        $number_30days=floor($days/30);
        $sub=$number_30days*30-$days;
         if($sub==0)
        {
            $sql="UPDATE vtiger_contactscf SET  cf_996=? WHERE contactid=?";
            $adb->pquery($sql,array(0,$contactid));
        }
    }

}

?>
