<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Class Settings_LoginPage_Preview_View extends Settings_Vtiger_Index_View {
	
	/*function loginRequired() {
		return false;
	}
	
	function checkPermission(Vtiger_Request $request) {
		return true;
	}*/
	
	public function process1(Vtiger_Request $request) {
	    
		$viewer->view('Preview.tpl', $qualifiedModuleName); 
	}	

	function __construct() {
		parent::__construct();
	}

	public function process(Vtiger_Request $request) {
		global $adb;
		$qualifiedModuleName = $request->getModule(false);
        $viewer = $this->getViewer($request);
		$themename = $request->get('name');
		$loginpage = $request->get('loginpagename');
		if($loginpage == ''){
			$loginpage = 'Login.Custom';
		}
		global $site_URL;
		 
		$record = $request->get('record');
		$old_record = $request->get('old_record');
		$viewer->assign('record',$record); 
		$viewer->assign('old_record',$old_record); 

		switch($themename){
			case $themename:
				$purl = "$site_URL"."index.php?module=LoginPage&parent=Settings&view=Iframepreview&name="."$themename";
				$viewer->assign('PAGE',$themename);
				break;
			default:
				$purl = "$site_URL"."index.php?module=LoginPage&parent=Settings&view=Iframepreview&name="."$loginpage";
				$viewer->assign('PAGE',$loginpage); 
			} 
			

			$viewer->assign('P_URL',$purl); 
			 

		$viewer->view('Preview.tpl', $qualifiedModuleName);
	}
	
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		
		$jsFileNames = array(
			//'modules.Settings.LoginPage.resources.List'			 
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

}