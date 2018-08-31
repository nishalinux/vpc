<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ACMPR_ActivitiesEdit_View extends Settings_Vtiger_Index_View {

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$viewer = $this->getViewer($request);
		$moduleModel = Settings_Vtiger_Module_Model::getInstance($qualifiedModuleName);
		$viewer->assign('ACTIVIES_INFO', $moduleModel->getActivitiesInfo());
		$viewer->view('ActivitiesEdit.tpl', $qualifiedModuleName);
	}
}