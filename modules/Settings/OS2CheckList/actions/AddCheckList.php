<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_AddCheckList_Action extends Settings_Vtiger_Index_Action {
    
    public function process(Vtiger_Request $request) {
		global $adb;
		$adb = PearDatabase::getInstance();
		$id = $request->get('record');
		
		
		$response = new Vtiger_Response();
		$response->setResult(array("result"=>"$id", 'success'=>true));
		$response->emit();
	
    }
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}
