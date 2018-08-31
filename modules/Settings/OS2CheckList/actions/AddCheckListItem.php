<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_AddCheckListItem_Action extends Settings_Vtiger_Index_Action {
    
    public function process(Vtiger_Request $request) {
		global $adb;
		$adb = PearDatabase::getInstance();
		//print_r($request);
		$result = 1;
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	
    }
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}