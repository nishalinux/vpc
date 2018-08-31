<?php 

require_once '/quickbooks/QuickBooks.php';

class QbClass {
	
	public function config() { 
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

		// This is the URL to forward the user to after they have connected to IPP/IDS via OAuth
		$quickbooks_success_url =  $vtiger_base_url .'/success.php';

		// This is the menu URL script 
		$quickbooks_menu_url = $vtiger_base_url .'/menu.php';
		
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
		if ($IntuitAnywhere->check($the_username, $the_tenant) and 
			$IntuitAnywhere->test($the_username, $the_tenant))
		{
			// Yes, they are 
			$quickbooks_is_connected = true;

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

			// Load the OAuth information from the database
			$Context = $IPP->context();

			// Get some company info
			$CompanyInfoService = new QuickBooks_IPP_Service_CompanyInfo();
			$quickbooks_CompanyInfo = $CompanyInfoService->get($Context, $realm);
			var_dump($quickbooks_CompanyInfo);
		}
		else
		{
			// No, they are not
			$quickbooks_is_connected = false;
			var_dump($quickbooks_is_connected);
		}
	
	
	}
	
	
	
}