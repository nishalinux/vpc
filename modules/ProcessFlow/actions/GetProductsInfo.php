<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
class ProcessFlow_GetProductsInfo_Action extends Vtiger_Action_Controller {
	function checkPermission(){
		return true;
	}
	function process(Vtiger_Request $request) {
		$recordId = $request->get('record');
		$response = new Vtiger_Response();
		$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
		$batchid = $recordModel->get('cf_1652');//Batch ID (RKS)
		$batchname = '';
		if($batchid != ''){
			$batchrows = $adb->num_rows($adb->pquery("SELECT * FROM vtiger_crmentity where deleted=0",array($batchid)));
			if($batchrows == 1){
				$batchinfo = Vtiger_Record_Model::getInstanceById($batchid);
				$batchname=$batchinfo->getName();
			}
		}
		$response->setResult(array(
								$recordId => array(
									'id'=>$recordId, 'name'=>decode_html($recordModel->getName()),
									'quantityInStock' => $recordModel->get('qtyinstock'),'batchid'=>$batchid,
									'batchname'=>decode_html($batchname)
								)));
		
		$response->emit();
	}
}
