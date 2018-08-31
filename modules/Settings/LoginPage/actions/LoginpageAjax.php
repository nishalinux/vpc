<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_LoginPage_LoginpageAjax_Action extends Settings_Vtiger_Basic_Action {
	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');//Ex: LoginBox,ContentSlider..
		global $adb;
		#$adb->setDebug(true);
		switch ($mode) {
			 
			case 'save':
				$q = "update vtigress_themes set draft=0 where id=?";
				$result = $adb->pquery($q,array($request->get('record')));
				$old_record = $request->get('old_record');
				if($old_record > 0){
					$q = "DELETE FROM vtigress_themes WHERE id=?";
					$result = $adb->pquery($q,array($old_record));
				}
				break;
			default:
				$result = array();
			}
			header('Location:index.php?module=LoginPage&parent=Settings&view=List');
			exit;
		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult($result);
		$response->emit();
	}
}
