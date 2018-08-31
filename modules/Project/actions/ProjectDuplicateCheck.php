<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_ProjectDuplicateCheck_Action extends Vtiger_SaveAjax_Action {
	public function process(Vtiger_Request $request){
		$module = $request->getModule();
		$record = $request->get('record');
		$modulemodel = Project_Module_Model::getInstance("Project");
		$status = $modulemodel->checkProductsQtyStatus($record);
		$response = new Vtiger_Response();
		$response->setResult($status);
		$response->emit();
	}

}
