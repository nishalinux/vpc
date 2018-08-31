<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
error_reporting(0);
class Settings_ACMPR_ActivitiesSave_Action extends Settings_Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		global $adb;
		//$adb->setDebug(true);
		for($k=1;$k<8;$k++){
			$substance = implode(" |##| ",$_REQUEST['substances'.$k]);
			$cannabis=  $_REQUEST['cannabis'.$k];
			$purpose =  $_REQUEST['purpose'.$k];
			$id =  $_REQUEST['nameid'.$k];
			$updatearray = array($substance,$cannabis,$purpose,$id);
			$adb->pquery("UPDATE vtigress_acmpr_activities_settings SET substances=?,cannabis=?,purpose=? WHERE id=?",$updatearray);
		}
		$response = new Vtiger_Response();
		$response->setResult(array('SUCCESS'=>'OK'));
		$response->emit();
	}
	
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.ACMPR"
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}