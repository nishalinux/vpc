<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
error_reporting(0);
class Settings_ProcessFlow_ProcessFlowSaveAjax_Action extends Settings_Vtiger_Basic_Action {

	public function process(Vtiger_Request $request) {
		$response = new Vtiger_Response();
		$qualifiedModuleName = $request->getModule(false);
		$moduleModel = Settings_ProcessFlow_ProcessFlow_Model::getInstance();

		//$moduleModel->set('email', $request->get('email'));
		 
		$status = $moduleModel->save();

		if ($status === true) {
			$response->setResult(array($status));
		} else {
			$response->setError(vtranslate($status, $qualifiedModuleName));
		}
		
		$response->emit();
	}
        
        public function validateRequest(Vtiger_Request $request) { 
            $request->validateWriteAccess(); 
        }
}