<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Quickbooks_List_View extends Vtiger_Index_View {
	
	function __construct() {
		parent::__construct();
		global $adb;
		$adb->setDebug(true);
		$this->exposeMethod('showFieldLayout');
	} 
	
	function process (Vtiger_Request $request) {
		
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();   
		$this->config($request);	 
		$viewer->assign('CONTACT_FIELDS_LIST_ARRAY',$this->getModuleFieldsNames(4));		
		$viewer->assign('CONTACT_LIST_VIEW',$this->getQbModulesListView('Contacts'));
		
		$viewer->assign('VENDORS_FIELDS_LIST_ARRAY',$this->getModuleFieldsNames(18));	
		$viewer->assign('VENDORS_LIST_VIEW',$this->getQbModulesListView('Vendors'));
		
		$viewer->assign('PRODUCTS_FIELDS_LIST_ARRAY',$this->getModuleFieldsNames(14));	
		$viewer->assign('PRODUCTS_LIST_VIEW',$this->getQbModulesListView('Products'));
		
		$viewer->assign('SERVICES_FIELDS_LIST_ARRAY',$this->getModuleFieldsNames(31));	
		$viewer->assign('SERVICES_LIST_VIEW',$this->getQbModulesListView('Services')); 
		 
		$viewer->assign('INVOICE_FIELDS_LIST_ARRAY',$this->getModuleFieldsNames(23));	
		$viewer->assign('INVOICE_LIST_VIEW',$this->getQbModulesListView('Invoice'));
		
		$viewer->assign('CRONDATA',$this->getCronData());
		
		$viewer->view('ListView.tpl', $moduleName);
		
		//$moduleModel = Vtiger_Module_Model::getInstance($moduleName); 
	} 
	
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	public function getHeaderScripts(Vtiger_Request $request) { 
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
			'modules.Quickbooks.resources.Settings'
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
	
	public function config(Vtiger_Request $request){
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();   
		
		//error_reporting(E_ALL);
		//ini_set('display_errors', 1);

		// Require the library code
		require_once  'quickbooks/QuickBooks.php';
		require_once  'config.inc.php';
		global $site_URL,$dbconfig;
					
		$db_hostname = $dbconfig['db_hostname'];
		$db_username = $dbconfig['db_username'];
		$db_password = $dbconfig['db_password'];
		$db_name	=	$dbconfig['db_name'];
		$db_type 	= 	$dbconfig['db_type']; 
		
		// Your application token (Intuit will give you this when you register an Intuit Anywhere app)
		$token = '6699823ab627ab4688b8919b1b11648d1c81';
		$oauth_consumer_key = 'qyprdJzmN1e4dFdonHlYrGt0l28R9u';
		$oauth_consumer_secret = 'gHJNXXbTL9MNdGivJseCGHHlTJEH4wlGhgKRAk44';
		$vtiger_base_url = $site_URL.'quickbooks';
		
		// If you're using DEVELOPMENT TOKENS, you MUST USE SANDBOX MODE!!!  If you're in PRODUCTION, then DO NOT use sandbox.
		$sandbox = true;     // When you're using development tokens
		//$sandbox = false;    // When you're using production tokens
		
		// This is the URL of your OAuth auth handler page
		$quickbooks_oauth_url = $vtiger_base_url .'/oauth.php';
		$viewer->assign('quickbooks_oauth_url', $quickbooks_oauth_url);
		
		// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
		$quickbooks_success_url =  $vtiger_base_url .'/success.php';
		//$viewer->assign('quickbooks_success_url', $quickbooks_success_url);
		
		// This is the menu URL script 
		$quickbooks_menu_url = $vtiger_base_url .'/menu.php';
		$viewer->assign('quickbooks_menu_url', $quickbooks_menu_url);
		
		// This is a database connection string that will be used to store the OAuth credentials 
		// $dsn = 'mysql://username:password@hostname/database';
		//$dsn = 'mysqli://root:otsi@2016@localhost:3306/quickbook_api';
		$dsn = "$db_type://$db_username:$db_password@$db_hostname/$db_name";
		// You should set this to an encryption key specific to your app
		$encryption_key = 'bcde1234';

		// Do not change this unless you really know what you're doing!!!  99% of apps will not require a change to this.
		$the_username = 'DO_NOT_CHANGE_ME';

		// The tenant that user is accessing within your own app
		$the_tenant = 12345;
		
		// Initialize the database tables for storing OAuth information
		if (!QuickBooks_Utilities::initialized($dsn))
		{
			// Initialize creates the neccessary database schema for queueing up requests and logging
			QuickBooks_Utilities::initialize($dsn);
		}
		
		/*Instantiate our Intuit Anywhere auth handler 		 
			The parameters passed to the constructor are:
			$dsn :: 				
			$oauth_consumer_key	:: Intuit will give this to you when you create a new Intuit Anywhere 		        	 application at AppCenter.Intuit.com
			$oauth_consumer_secret :: Intuit will give this to you too
			$this_url :: This is the full URL (e.g. http://path/to/this/file.php) of THIS SCRIPT
			$that_url :: After the user authenticates, they will be forwarded to this URL
		*/
		
		$IntuitAnywhere = new QuickBooks_IPP_IntuitAnywhere($dsn, $encryption_key, $oauth_consumer_key, $oauth_consumer_secret, $quickbooks_oauth_url, $quickbooks_success_url);

		// Are they connected to QuickBooks right now? 
		if ($IntuitAnywhere->check($the_username, $the_tenant) and 
			$IntuitAnywhere->test($the_username, $the_tenant))
		{
			// Yes, they are 
			$quickbooks_is_connected = true;
			$viewer->assign('quickbooks_is_connected', $quickbooks_is_connected);
			// Set up the IPP instance
			$IPP = new QuickBooks_IPP($dsn);

			// Get our OAuth credentials from the database
			$creds = $IntuitAnywhere->load($the_username, $the_tenant);

			// Tell the framework to load some data from the OAuth store
			$IPP->authMode(
				QuickBooks_IPP::AUTHMODE_OAUTH, 
				$the_username, 
				$creds);

			if ($sandbox)
			{
				// Turn on sandbox mode/URLs 
				$IPP->sandbox(true);
			}

			// This is our current realm
			$realm = $creds['qb_realm'];
			$viewer->assign('realm', $realm);
			
			// Load the OAuth information from the database
			$Context = $IPP->context();			
			$viewer->assign('Context', $Context);
			
			// Get some company info
			$CompanyInfoService = new QuickBooks_IPP_Service_CompanyInfo();
			$quickbooks_CompanyInfo = $CompanyInfoService->get($Context, $realm);
			$viewer->assign('quickbooks_CompanyInfo', $quickbooks_CompanyInfo);
		}
		else
		{
			// No, they are not
			$quickbooks_is_connected = false;
			 
			$viewer->assign('quickbooks_is_connected', $quickbooks_is_connected);
		}
}

	public function showFieldLayout(Vtiger_Request $request) {	 
	
		$response = new Vtiger_Response();
		$response->setResult(array('success' => true ));
		$response->emit();
	}
	
	function getModuleFieldsNames($id) {
		
		$fieldName = array();
		global $adb;
		
		$adb = PearDatabase::getInstance();
		$query = "SELECT fieldlabel from vtiger_field where tabid =$id";
		
		$result = $adb->pquery($query);       	
		while( $row = $adb->fetch_row($result)){
			$fieldName[] = $row['fieldlabel'];
		}
		//print_r($fieldName);
		return $fieldName;
		
	}
	 
	
	public function getQbModulesListView($module){
		global $adb ;
		
		$query = $adb->pquery("SELECT qb_field_name,vtiger_field FROM `quickbooks_fields` where module = ?",array($module));
		$numRows = $adb->num_rows($query);
		$qBfield = array();
		while( $row = $adb->fetch_row($query)){
			$qBfield[] = $row;
		}
		return $qBfield;
	}
	
	public function getCronData(){
		global $adb ;
		$query = "SELECT name,status FROM vtiger_cron_task where module = ? ";
		$query = $adb->pquery($query,array('Quickbooks'));
		while( $row = $adb->fetch_row($query)){
			$qBfield[$row['name']] = $row['status'];
		}
		return $qBfield;		
	}
}