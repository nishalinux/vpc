<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class Room_Detail_View extends Vtiger_Detail_View {

        public function showModuleDetailView(Vtiger_Request $request) {
			$recordId = $request->get('record');
			$moduleName = $request->getModule();

			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			//TO DO, fill up from table
			global $adb;
			$pickBlocks = Array();
			$pickListsBlocks = Array();
			$pbResult = $adb->pquery("SELECT DISTINCT picklistfieldname FROM vtiger_pickblocks, vtiger_tab where vtiger_tab.tabid=vtiger_pickblocks.tabid and name= ?", Array($moduleName));
			while ($plrow = $adb->fetch_row($pbResult)){
				$picklistfieldname = $plrow["picklistfieldname"];
				$plbResult = $adb->pquery("SELECT * FROM vtiger_pickblocks, vtiger_tab where vtiger_tab.tabid=vtiger_pickblocks.tabid and name= ? and picklistfieldname=?", Array($moduleName, $picklistfieldname));
				while ($plbrow = $adb->fetch_row($plbResult)){
					$pickListsBlocks[$plbrow["picklistitem"]] = $plbrow["blockid"];
				}
				$pickBlocks[$picklistfieldname] = $pickListsBlocks;
				$pickListsBlocks = Array();
			}
			$pbResult = $adb->pquery("SELECT * from vtiger_dvpanels,vtiger_tab where vtiger_tab.tabid=vtiger_dvpanels.tabid and name= ?", Array($moduleName));
			$panelTabs = Array();
			while ($row = $adb->fetch_row($pbResult)){
				$panelTabs[$row["panellabel"]] = $row["blockids"];
			}
			$viewer = $this->getViewer($request);
			$viewer->assign('IMAGE_DETAILS', $recordModel->getImageDetails());
			$viewer->assign('GALLERY_DETAILS', $recordModel->getGalleryDetails());
			$viewer->assign('PANELTABS', $panelTabs);
			$viewer->assign('PICKBLOCKS', $pickBlocks);
			//die(print_r($recordModel->getImageDetails()));

			return parent::showModuleDetailView($request);
        }


        public function showModuleBasicView(Vtiger_Request $request) {
                return $this->showModuleDetailView($request);
        }


	public function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			'~libraries/jquery/jquery.cycle.min.js',
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
