<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class PointSale_Detail_View extends Vtiger_Detail_View {

        public function showModuleDetailView(Vtiger_Request $request) {
			$recordId = $request->get('record');
			$moduleName = $request->getModule();

			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			//TO DO, fill up from table
			global $adb;
			/*$pickBlocks = Array();
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
			}*/
			$viewer = $this->getViewer($request);
			//$viewer->assign('IMAGE_DETAILS', $recordModel->getImageDetails());
			//$viewer->assign('GALLERY_DETAILS', $recordModel->getGalleryDetails());
			//$viewer->assign('PANELTABS', $panelTabs);
			//$viewer->assign('PICKBLOCKS', $pickBlocks);
			//die(print_r($recordModel->getImageDetails()));

			return parent::showModuleDetailView($request);
        }
	function showModuleSummaryView($request) {
		global $adb;
		//$adb->setDebug(true);
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		if(!$this->record){
			$this->record = Vtiger_DetailView_Model::getInstance($moduleName, $recordId);
		}
		$recordModel = $this->record->getRecord();
		$recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_SUMMARY);

        $moduleModel = $recordModel->getModule();
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD', $recordModel);
        $viewer->assign('BLOCK_LIST', $moduleModel->getBlocks());
		$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());

		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('IS_AJAX_ENABLED', $this->isAjaxEnabled($recordModel));
		$viewer->assign('SUMMARY_RECORD_STRUCTURE', $recordStrucure->getStructure());
		$viewer->assign('RELATED_ACTIVITIES', $this->getActivities($request));
		
		$get_pos_details = $adb->pquery("SELECT * FROM vtiger_posdetails WHERE posid=?",array($recordId));
		$pos_detail=array();
		$j=0;
		$totalwithtax = 0.00;
		while($pos_result = $adb->fetch_array($get_pos_details))
		{
			$pos_detail[$j]['selected_qty'] = $pos_result['selected_qty'];
			$pos_detail[$j]['price'] = $pos_result['price'];
			$pos_detail[$j]['taxpercent'] = $pos_result['taxpercent'];
			
			$price = $pos_detail[$j]['price'];
			$qty = $pos_detail[$j]['selected_qty'];
			$tax = $pos_detail[$j]['taxpercent'];
			$amount = $price * $qty;
			$totalwithouttax = $totalwithouttax + $amount;
			
			$sql1 = $adb->pquery("SELECT * FROM vtiger_products WHERE productid=?",array($pos_result['productid']));
			$pos_detail[$j]['productname'] = $adb->query_result($sql1, 0, 'productname');
			$j++;
		}
		
		$query2 = $adb->pquery("SELECT SUM(selected_qty) as total_qty FROM vtiger_posdetails WHERE posid=?",array($recordId));
		$total_qty = $adb->query_result($query2,0,'total_qty');
		
		$pos_amount = array();
		$query1 = $adb->pquery("SELECT total_amt, paid_amt, return_amt FROM vtiger_pointsale WHERE pointsaleid=?",array($recordId));
			$pos_amount['total_amount'] = $adb->query_result($query1,0,'total_amt');
			$pos_amount['paid_amount'] = $adb->query_result($query1,0,'paid_amt');
			$pos_amount['return_amount'] = $adb->query_result($query1,0,'return_amt');
			
		$viewer->assign('POS_DETAIL', $pos_detail);
		$viewer->assign('pos_amount', $pos_amount);
		$viewer->assign('total_qty', $total_qty);
		
		$query3 = $adb->pquery("SELECT * FROM vtiger_pos_settings",array());
		$row3 = $adb->num_rows($query3);
		if($row3 > 0){
			$tax = $adb->query_result($query3,0,'tax');
		} 
		
		$viewer->assign('TAX',$tax);
		$viewer->assign('totalwithouttax', $totalwithouttax);
		return $viewer->view('ModuleSummaryView.tpl', $moduleName, true);
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
