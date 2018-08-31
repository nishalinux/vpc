<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_SaveAjax_Action extends Settings_Vtiger_Basic_Action {
    
    public function process(Vtiger_Request $request) {
        //global $adb;
		//$adb = PearDatabase::getInstance();
		//$adb->setDebug(true);
		
		$record = $request->get('checklistid');
        if(empty($record)) {
			//get instance from currency name, Aleady deleted and adding again same currency case 
            $recordModel = Settings_OS2CheckList_Record_Model::getInstance($record);
            if(empty($recordModel)) {
				$recordModel = new Settings_OS2CheckList_Record_Model();
			}
		} else {
            $recordModel = Settings_OS2CheckList_Record_Model::getInstance($record);
        }
        
        $fieldList = array('checklistname','modulename','category','title','allow_upload','allow_note','description');
        
        foreach ($fieldList as $fieldName) {
            if($request->has($fieldName)) {
                $recordModel->set($fieldName,$request->get($fieldName));
            }
        }
		//To make sure we are saving record as non deleted. This is useful if we are adding deleted currency
		$recordModel->set('deleted',0);
        $response = new Vtiger_Response();
		try{
            $id = $recordModel->save();
			$responseData = array("message"=>"$id", 'success'=>true);			
            $response->setResult($responseData);
			header("Location: index.php?parent=Settings&module=OS2CheckList&view=List&block=4&fieldid=33");
        }catch (Exception $e) {
            $response->setError($e->getCode(), $e->getMessage());
        }
        $response->emit();
        
    }
    
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    } 
	
	function getHeaderScripts(Vtiger_Request $request){
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.OS2CheckList"
		);
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}