<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
require_once 'modules/ACMPR/RetrieveGridDetails.php';
Class ACMPR_Edit_View extends Vtiger_Edit_View {
	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
        $recordModel = $this->record;
        if(!$recordModel){
            if (!empty($recordId)) {
                $recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
            } else {
                $recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
				$moduleModel = $recordModel->getModule();
            }
        }

		global $adb;
		$viewer = $this->getViewer($request);
		//$viewer->assign('IMAGE_DETAILS', $recordModel->getImageDetails());
		$viewer->assign('GALLERY_DETAILS', $recordModel->getGalleryEditDetails());
	
		if (!empty($recordId)) {
			$grid1 = RetrieveGridDetails($recordId,'vtigress_acmpr_griddetails');
			$viewer->assign('ACCOUNT_DETAILS', $grid1);
			
			$grid2 = RetrieveARPICDetails($recordId,'vtigress_arpic_griddetails');
			$viewer->assign('ARPIC_DETAILS', $grid2);
			
			$grid3 = RetrievePersonGridDetails($recordId,'vtigress_person_griddetails');
			$viewer->assign('Person_Details', $grid3);
			
		}else{
			$viewer->assign('ACCOUNT_DETAILS',getGridInfo());
			//For prepopulate 5a section
			$fieldList = $moduleModel->getFields();
			$requestFieldList = getActivitySubtancesInfo();
		
			foreach($requestFieldList as $fieldName=>$fieldValue) {
				$fieldModel = $fieldList[$fieldName];
				if($fieldModel->isEditable()) {
					$recordModel->set($fieldName, $fieldValue);
				}
			}
			$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_EDIT);
			$viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
			$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());
			//Ended here
		}
		
		parent::process($request);
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
				'libraries.jquery.multiplefileupload.jquery_MultiFile',
				"libraries.jquery.ckeditor.ckeditor",
				"libraries.jquery.ckeditor.adapters.jquery",
				'modules.Vtiger.resources.CkEditor',
				'libraries.vtDZinerSupport',
				'modules.ACMPR.resources.CustomValidations',
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}