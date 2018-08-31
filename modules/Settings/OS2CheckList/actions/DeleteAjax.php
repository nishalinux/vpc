<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_DeleteAjax_Action extends Settings_Vtiger_Basic_Action {
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('deleteDocuments');
	}
    
    public function process(Vtiger_Request $request) {	
		global $adb;
		$adb = PearDatabase::getInstance();
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
		
        $response = new Vtiger_Response();
        try{
            $record = $request->get('record');
           
            Settings_OS2CheckList_Module_Model::delete($record);
			$adb->pquery("DELETE FROM vtiger_checklist_related WHERE checklistid=?",array($record));
            $response->setResult(array('success'=>'true'));
        }catch(Exception $e){
           $response->setError($e->getCode(), $e->getMessage());
        }
        $response->emit();
    }
	
	function deleteDocuments(Vtiger_Request $request){
		global $adb;
		$adb = PearDatabase::getInstance();
		
		$checklistid = $request->get('src_record');
		$noteid = $request->get('related_record_list');
		
		$adb->pquery("DELETE FROM vtiger_relmodule_checklist WHERE noteid=?",array($noteid));
		$query = $adb->pquery("SELECT * FROM vtiger_relmodule_checklist WHERE noteid=?",array($noteid));
		$row = $adb->num_rows($query);
		if($row == 0){
			$result = 1;
		}
            
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
    
    public function validateRequest(Vtiger_Request $request) { 
        $request->validateWriteAccess(); 
    }
}