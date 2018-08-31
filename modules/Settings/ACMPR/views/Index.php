<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ACMPR_Index_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		$viewer->assign('GRID_INFO', $moduleModel->getGridInfo());
		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		$viewer->assign('ACTIVIES_INFO', $moduleModel->getActivitiesInfo());
		$viewer->view('Index.tpl', $qualifiedModuleName);
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