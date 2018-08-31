<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_LoginPage_NewTheme_View extends Settings_Vtiger_Index_View {

	function __construct() {
		parent::__construct();
	}

	public function process(Vtiger_Request $request) {
		global $adb;
		$viewer = $this->getViewer($request);
		
		$record	=	$request->get('record');
		if($record > 0){
			$viewer->assign('DATA',$this->getThemeData($record));
		}
		$viewer->assign('record',$record);
		#$rows	=	$request->get('x');
		#$columns	=	$request->get('y');

		#TheraCann
		$rows = 1;
		$columns = 2;
		#end
		$viewer->assign('ROWS',$rows);
		$viewer->assign('COLUMNS',$columns);
		$viewer->view('VtigressNewThemeCreate.tpl', $request->getModule(false));
	}
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		
		$jsFileNames = array(
			'modules.Settings.LoginPage.resources.List'			 
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	function getThemeData($record){
		global $adb;
		$q = "select * from vtigress_themes where id=?";
		$result = $adb->pquery($q,array($record));
		$result = $adb->fetchByAssoc($result);
		$data = json_decode(stripslashes(html_entity_decode($result['data'])), true);
		$result['data'] = $data;
		//echo '<pre>';print_r($result);
		return $result;
	}
}
