<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_ProductQtyUpdate_Action extends Vtiger_BasicAjax_Action {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		global $adb;
		$projectid = $request->get('projectid');
		$productid = $request->get('productid');
		$qty =  $request->get('qty');
		$updateqty = "UPDATE vtiger_projectproductqty_details SET allocatedtqty=?,is_edit=? WHERE productid=? and projectid=?";
		$params = array($qty,1,$productid,$projectid);
		$adb->pquery($updateqty,$params);
		$productsqty = $adb->query_result($adb->pquery("select qtyinstock from vtiger_products where productid=?",array($productid)),0,'qtyinstock');
		$stockupdate = $productsqty-$qty;
		$adb->pquery("Update vtiger_products set qtyinstock=? where productid=?",array($stockupdate,$productid));
		$response = new Vtiger_Response();
		$response->setResult(array($stockupdate));
		$response->emit();
	}
}
