<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_EditAjax_Action extends Settings_Vtiger_Basic_Action {
	
	
    public function process(Vtiger_Request $request) {	
		global $adb;
		$adb = PearDatabase::getInstance();
		$adb->setDebug(true);
		
		$checklistname = $request->get('name');
		
		$query = $adb->pquery("SELECT checklistname FROM vtiger_checklistdetails WHERE checklistname=?",array($checklistname));
		$row = $adb->num_rows($query);
		if($row > 0){
			$result = 1;
		}else{
			$result = 0;
		}
            
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
    }
	
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}