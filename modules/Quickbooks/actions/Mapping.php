<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
include_once('config.inc.php');
class Quickbooks_Mapping_Action extends Vtiger_Action_Controller{
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
	}	
	public function process(Vtiger_Request $request) {
		
		global $adb;
		$adb = PearDatabase::getInstance();
		$mode = $request->get('mode');
		$response = new Vtiger_Response();
		
		switch ($mode) {
			case "updateQbModuleFieldsMapping":
				try{
					$m = $request->get('hdnModule');
					$ContactData = $request->get($m);
					foreach($ContactData as $field => $value){
						if($value != ''){
							$adb->pquery("UPDATE quickbooks_fields SET vtiger_field=?, flag = 1 WHERE qb_field_name=? and module=?;", array($value, $field,$m));
						}
					}
					$responseData = array("message" => $m." and Quickbook Fields Mapping Updated.", "success"=>true);
					$response->setResult($responseData);
				}catch(Exception $e) {
					$response->setError($e->getCode(), "Please study the errorcode is ".$e->getCode());
				}
				$response->emit();				
				break;		 
				
			default:
				$response->setError($e->getCode(), "Please study the errorcode is ".$e->getCode());
				$response->emit();
		}
	}	
	
}
		