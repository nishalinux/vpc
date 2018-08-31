<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ProjectStock_GetProductDetails_Action extends Vtiger_BasicAjax_Action {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		$projectid = $request->get('record');
		global $adb;
		$query = $adb->pquery("SELECT productnumber,sum(qty) as qty, sum(used_qty) as used_qty FROM vtiger_projectsproduct_details WHERE projectid=? group by productnumber",array($projectid));
		$frows = $adb->num_rows($query);
		if($frows != 0){
			$productnames = array();
			$searchParmams = array();
			for($i=0;$i<$frows;$i++){
				$productname = $adb->query_result($query,$i,'productnumber');
				$qty =  $adb->query_result($query,$i,'qty');
				$usedqty =  $adb->query_result($query,$i,'used_qty');
				$remqty = $qty - $usedqty;	
				$productnames[$productname] =$remqty;// $adb->query_result($query,$i,'qty');
			}
		}


		$response = new Vtiger_Response();
		$response->setResult($productnames);
		$response->emit();
	}
}
