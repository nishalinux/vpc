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
		$productids = array();
		global $adb, $current_user;	
		$produts = "SELECT crmid, module, relcrmid, relmodule FROM vtiger_crmentityrel WHERE crmid=? and relmodule=?";
		$res = $adb->pquery($produts,array($record,'Products'));
		$rows = $adb->num_rows($res);
		for($i=0;$i<$rows;$i++){
			$productids[] = $adb->query_result($res,$i,'relcrmid');
		}
		//To Check quantity of each product
		$qtyquery = "SELECT productid,qtyinstock FROM vtiger_products WHERE productid in (" . generateQuestionMarks($productids) . ")";
		$result = $adb->pquery($qtyquery,$productids);
		$rows = $adb->num_rows($result);
		for($i=0;$i<$rows;$i++){
			$quantity[$adb->query_result($result,$i,'productid')] = $adb->query_result($result,$i,'qtyinstock');
		}
		//Requried Quantity to create
		$act = "SELECT productid, allocatedtqty FROM vtiger_projectproductqty_details WHERE productid in (" . generateQuestionMarks($productids) . ")";
		$reqres = $adb->pquery($act,$productids);
		$rows = $adb->num_rows($reqres);
		for($i=0;$i<$rows;$i++){
			$Reququantity[$adb->query_result($reqres,$i,'productid')] = $adb->query_result($reqres,$i,'allocatedtqty');
		}
		//print_r($quantity);
		//print_r($Reququantity);
		foreach($Reququantity as $k=>$v){
			if($v >= $quantity[$k] && $v != ''){
				$status = true;
			}
		}
		$response = new Vtiger_Response();
		$response->setResult($status);
		$response->emit();
	}

}
