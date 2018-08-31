<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_ProductUsedQtyUpdate_Action extends Vtiger_BasicAjax_Action {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		global $adb;
		$projectid = $request->get('projectid');
		$productid = $request->get('productid');
		$qty =  $request->get('qty');
		$updateqty = "UPDATE vtiger_projectproductqty_details SET used_qty=? WHERE productid=? and projectid=?";
		$params = array($qty,$productid,$projectid);
		$adb->pquery($updateqty,$params);
		$response = new Vtiger_Response();
		$response->setResult(array($qty));
		$response->emit();
	}
}
