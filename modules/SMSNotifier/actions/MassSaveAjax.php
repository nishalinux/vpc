<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class SMSNotifier_MassSaveAjax_Action extends Vtiger_Mass_Action {
var $recrodID = "";
   var $msgContent = "";
   var $currentModule = "";
   var $recordDetails=array();

	function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		if(!$currentUserPriviligesModel->hasModuleActionPermission($moduleModel->getId(), 'Save')) {
			throw new AppException(vtranslate($moduleName).' '.vtranslate('LBL_NOT_ACCESSIBLE'));
		}
	}

	/**
	 * Function that saves SMS records
	 * @param Vtiger_Request $request
	 */
	public function process(Vtiger_Request $request) {
		global $log;
/*$log->debug('MassSaveAjax');*/
		
		$moduleName = $request->getModule();
		
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$recordIds = $this->getRecordsListFromRequest($request);
		$phoneFieldList = $request->get('sms_recepient');
		$current_module=$request->get('source_module');
		$this->currentModule=$current_module;

		$selected_ids=$request->get('selected_ids');
		$content = $request->get('message');
		$phoneFieldList=explode(",",$phoneFieldList);
		$phoneFieldList=array_values(array_filter(array_unique($phoneFieldList)));
		/*$pieces = explode(",", $message);
		$count_arr = count($pieces);
		for($i=0; $i<$count_arr; $i++){

		}*/
		/*foreach($recordIds as $recordId) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
			$numberSelected = false;
			foreach($phoneFieldList as $fieldname) {
				$fieldValue = $recordModel->get($fieldname);
				if(!empty($fieldValue)) {
					$toNumbers[] = $fieldValue;
					$numberSelected = true;
				}
			}
			if($numberSelected) {
				$recordIds[] = $recordId;
			}
		}*/
		/*$log->debug('current_module='.$current_module);
		$log->debug('selected_ids='.print_r($selected_ids));
		$log->debug('phoneFieldList='.print_r($phoneFieldList));*/
		foreach($selected_ids as $recordId) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
			/*$log->debug('recordId='.$recordId);*/
			$numberSelected = false;
			
			foreach($phoneFieldList as $fieldname) {
				$fieldname = str_replace('$','',$fieldname);
				/*$log->debug('fieldname='.$fieldname);
				$log->debug('recordModel Start');*/
				$fieldValue = $recordModel->get($fieldname);
				/*$log->debug('recordModel');*/
				if(!empty($fieldValue)) {
					$toNumbers[] = $fieldValue;
					/*$log->debug('Contact');*/
					$this->recrodID=$recordId;
					/*$log->debug('recrodID');*/
					$this->msgContent=$content;
					/*$log->debug('msgContent');*/
					$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $current_module);
					/*$log->debug('recordModel');*/
					$this->recordDetails= $recordModel->getData();
					/*$log->debug('recordDetails');*/
					$content=$this->parseVkSmsTemplate($content);
					/*$log->debug('parseVkSmsTemplate');
					$log->debug('Message Start');*/
					SMSNotifier_Record_Model::SendSMS($content, $fieldValue, $currentUserModel->getId(), $recordId, $current_module);
					/*$log->debug('Message End');	*/				
				}
				
			}
			
		}
		/*$response->setResult(true);*/


		$response = new Vtiger_Response();
		$response->setEmitType(Vtiger_Response::$EMIT_JSON);
		$response->setResult(array("save_success"=>true));
		$response->emit();
        /*
		if(!empty($toNumbers)) {
			SMSNotifier_Record_Model::SendSMS($message, $toNumbers, $currentUserModel->getId(), $recordIds, $moduleName);
			$response->setResult(true);
		} else {
			$response->setResult(false);
		}*/
		/*return $response;*/
	}


	function parseVkSmsTemplate($template){
		return preg_replace_callback('/\\$(\w+|\((\w+) : \(([_\w]+)\) (\w+)\))/', array($this,"VkmatchHandler"), $template);
	}
	function VkmatchHandler($match){
		$currentModule=$this->currentModule;
		$recordID=$this->recrodID;
		$data=$this->recordDetails;
		$keyInfx=$match[0];
		$fieldName=$match[1];
		$fieldVal=$data[$fieldName];
		return $fieldVal;
	}
}
