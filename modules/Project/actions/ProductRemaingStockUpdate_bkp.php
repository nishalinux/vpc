<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_ProductRemaingStockUpdate_Action extends Vtiger_BasicAjax_Action {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		global $adb;
		$projectid = $request->get('projectid');
		$productid = $request->get('productid');

		$updateqty = "UPDATE vtiger_projectproductqty_details SET is_checked=? WHERE productid=? and projectid=?";
		$params = array(1,$productid,$projectid);
		$adb->pquery($updateqty,$params);

		//retrieving remainingqty
		$remainingqty = "SELECT allocatedtqty, used_qty FROM vtiger_projectproductqty_details WHERE  productid=? and projectid=?";
		$res = $adb->pquery($remainingqty,array($productid,$projectid));
		$allqty = $adb->query_result($res,0,'allocatedtqty');
		$used_qty = $adb->query_result($res,0,'used_qty');
		$remainingqty = $allqty-$used_qty;

		//ProductStock Update
		$productsqty = $adb->query_result($adb->pquery("select qtyinstock from vtiger_products where productid=?",array($productid)),0,'qtyinstock');
		$stockupdate = $productsqty+$remainingqty;
		$adb->pquery("Update vtiger_products set qtyinstock=? where productid=?",array($stockupdate,$productid));

		//Email Notification

		$response = new Vtiger_Response();
		$response->setResult(array($stockupdate));
		$response->emit();
	}
}
