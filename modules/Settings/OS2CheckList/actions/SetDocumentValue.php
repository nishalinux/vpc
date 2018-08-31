<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_SetDocumentValue_Action extends Settings_Vtiger_Index_Action {
    
    public function process(Vtiger_Request $request) {
		global $adb;
		$adb->setDebug(true);
		$adb = PearDatabase::getInstance();
		
		$noteid = $request->get('record');
		$checklistid = $request->get('source_record');
		$accountid = $request->get('accountid');
		$sequence = $request->get('sequence');
		
		$sql = $adb->pquery("INSERT INTO vtiger_relmodule_checklist(checklistid,sequence,noteid,accountid) VALUES(?,?,?,?)",array($checklistid, $sequence, $noteid, $accountid));
		
		
		$chk = $adb->pquery("SELECT * FROM vtiger_relmodule_checklist where checklistid=? AND accountid=?",array($checklistid,$accountid));
		$rowCount = $adb->num_rows($chk);
		if($rowCount >= 1){
			$result = 1;
		}
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	
    }
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}
