<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ACMPR_Save_Action extends Settings_Vtiger_IndexAjax_View {

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		global $adb;
		$adb->pquery("DELETE FROM vtigress_acmpr_settings",array());		
		$tot_no_prod = array();
		foreach ($_REQUEST as $key => $value) {
			if (strpos($key, 'accountname') === 0) {
				$tot_no_prod[] = $key;
			}
		}
		for($i=1; $i<count($tot_no_prod); $i++)
		{
			$xid = split('accountname',$tot_no_prod[$i]);
			$id = $xid[1];
			if($id != 0){
				$accountname = $_REQUEST['accountname'.$id];
				$activities = $_REQUEST['activities'.$id];
				$substance = $_REQUEST['substance'.$id];
				$query ="INSERT INTO vtigress_acmpr_settings(sequence, accountname, activities, substance) values(?,?,?,?)";
				$qparams = array($i,$accountname,$activities,$substance);
				$adb->pquery($query,$qparams);
			}
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