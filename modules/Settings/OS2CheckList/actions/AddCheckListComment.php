<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require_once 'config.inc.php';
class Settings_OS2CheckList_AddCheckListComment_Action extends Settings_Vtiger_Index_Action {
    
    public function process(Vtiger_Request $request) {
		global $adb,$current_user;
		$adb = PearDatabase::getInstance();
				
		$adminTimeZone = $current_user->time_zone;
		$currentTimestamp  = date("Y-m-d H:i:s");
		$userid = $current_user->id;
		$firstname = $current_user->first_name;
		$lastname = $current_user->last_name;
		$name = $firstname.' '.$lastname;
		
		$crmid = $request->get('crmid');
		$checklistid = $request->get('checklistid');
		$comment_content = $request->get('comment');
		$sequence = $request->get('sequence');
		
		$sql = $adb->pquery("INSERT INTO vtiger_checklist_comment(checklistid,sequence,crmid,comment_content,userid,username,time) VALUES(?,?,?,?,?,?,?)",array($checklistid, $sequence, $crmid, $comment_content, $userid, $name ,$currentTimestamp));
		$chk = $adb->pquery("SELECT * FROM vtiger_checklist_comment where checklistid=? AND crmid=?",array($checklistid,$crmid));
		$rowCount = $adb->num_rows($chk);
		if($rowCount > 0){		
			$result = '<li class="commentDetails"><p>'.$comment_content.'</p><p><small> '.$name.' | '.Vtiger_Datetime_UIType::getDateTimeValue($currentTimestamp).'</small></p></li>';
		}
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	
    }
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}
