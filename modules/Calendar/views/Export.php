<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Calendar_Export_View extends Vtiger_Export_View {

	public function preprocess(Vtiger_Request $request) {
	}

	public function process(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$viewId = $request->get('viewname');
		$viewer = $this->getViewer($request);
	
		if($viewId == '' ){
			$viewer->assign('MODULE', $moduleName);
			$viewer->assign('ACTION', 'ExportData');
		
			$viewer->view('Export1.tpl', $moduleName);
		}else{
			//$viewId = $request->get('viewname');
			$selectedIds = $request->get('selected_ids');
			$excludedIds = $request->get('excluded_ids');

			$page = $request->get('page');

			$viewer->assign('SELECTED_IDS', $selectedIds);
			$viewer->assign('EXCLUDED_IDS', $excludedIds);
			$viewer->assign('VIEWID', $viewId);
			$viewer->assign('PAGE', $page);
			$viewer->assign('SOURCE_MODULE', 'Events');
			$viewer->assign('MODULE','Export');
			
			$searchKey = $request->get('search_key');
			$searchValue = $request->get('search_value');
			$operator = $request->get('operator');
			if(!empty($operator)) {
				$viewer->assign('OPERATOR',$operator);
				$viewer->assign('ALPHABET_VALUE',$searchValue);
				$viewer->assign('SEARCH_KEY',$searchKey);
			}
			$viewer->assign('SEARCH_PARAMS', $request->get('search_params'));
			$viewer->view('Export.tpl', $moduleName);
		}
		
	}

	public function postprocess(Vtiger_Request $request) {
	}
}