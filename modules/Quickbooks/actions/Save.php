<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
//include_once('config.inc.php');
require_once  'quickbooks/QuickBooks.php';
class Quickbooks_Save_Action extends Vtiger_Basic_Action {
	 
	
	public function process(Vtiger_Request $request) {
		print_r($request);die;
		global $adb;
		$adb = PearDatabase::getInstance();
		$mode = $request->get('mode');
		$response = new Vtiger_Response();
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();   		

		// Your application token (Intuit will give you this when you register an Intuit Anywhere app)
		$token = '6699823ab627ab4688b8919b1b11648d1c81';
		$oauth_consumer_key = 'qyprdJzmN1e4dFdonHlYrGt0l28R9u';
		$oauth_consumer_secret = 'gHJNXXbTL9MNdGivJseCGHHlTJEH4wlGhgKRAk44';
		$vtiger_base_url = 'http://182.73.224.152:7090/quickbooks_vtiger/quickbooks';
		
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
		// $dsn = 'pgsql://username:password@hostname/database';
		// $dsn = 'mysql://username:password@hostname/database';
		$dsn = 'mysqli://root:otsi@2016@localhost:3306/quickbook_api';
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
		if ($IntuitAnywhere->check($the_username, $the_tenant) and $IntuitAnywhere->test($the_username, $the_tenant))
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
			$quickbooks_is_connected = false; 
		}  
		
		switch ($mode) {
			case "create_contact":
				$this->create_contact();		
				break; 			
			default: 				 
		}
	} 
	
	public function create_contact(Vtiger_Request $request){
		print_r($request);
		die;
		
		$CustomerService = new QuickBooks_IPP_Service_Customer();
		$Customer = new QuickBooks_IPP_Object_Customer();
		$Customer->setTitle('Ms');
		$Customer->setGivenName('Shannon');
		$Customer->setMiddleName('B');
		$Customer->setFamilyName('Palmer');
		$Customer->setDisplayName('Shannon B Palmer ' . mt_rand(0, 1000));

		// Terms (e.g. Net 30, etc.)
		$Customer->setSalesTermRef(4);

		// Phone #
		$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
		$PrimaryPhone->setFreeFormNumber('860-532-0089');
		$Customer->setPrimaryPhone($PrimaryPhone);

		// Mobile #
		$Mobile = new QuickBooks_IPP_Object_Mobile();
		$Mobile->setFreeFormNumber('860-532-0089');
		$Customer->setMobile($Mobile);

		// Fax #
		$Fax = new QuickBooks_IPP_Object_Fax();
		$Fax->setFreeFormNumber('860-532-0089');
		$Customer->setFax($Fax);

		// Bill address
		$BillAddr = new QuickBooks_IPP_Object_BillAddr();
		$BillAddr->setLine1('72 E Blue Grass Road');
		$BillAddr->setLine2('Suite D');
		$BillAddr->setCity('Mt Pleasant');
		$BillAddr->setCountrySubDivisionCode('MI');
		$BillAddr->setPostalCode('48858');
		$Customer->setBillAddr($BillAddr);

		// Email
		$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
		$PrimaryEmailAddr->setAddress('support@consolibyte.com');
		$Customer->setPrimaryEmailAddr($PrimaryEmailAddr);

		if ($resp = $CustomerService->add($Context, $realm, $Customer))
		{
			print('Our new customer ID is: [' . $resp . '] (name "' . $Customer->getDisplayName() . '")');
		}
		else
		{
			print($CustomerService->lastError($Context));
		}
		
	}
	
}