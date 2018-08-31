<?php

/**
 * Example integration with an application
 * 
 * The idea behind the action queue is basically just that you want to add an 
 * action/ID pair to the queue whenever something happens in your application 
 * that you need to tell QuickBooks about. 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */
 
// Error reporting for easier debugging
ini_set('display_errors', true);
error_reporting(E_ALL | E_STRICT);
 
// Require the queueuing class
require_once '../QuickBooks.php';
require_once '../../config.inc.php'; 
	global $site_URL,$dbconfig,$qb; 
	print_r($_POST);
	$db_hostname = $dbconfig['db_server'];
	$db_username = $dbconfig['db_username'];
	$db_password = $dbconfig['db_password'];
	$db_name	=	$dbconfig['db_name'];
	$db_type 	= 	$dbconfig['db_type'];

if (isset($_POST['customer']))
{
	// Oooh, here's a new customer, let's do some stuff with them
	
	// Connect to your own MySQL server....
	$link = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$link) 
	{
		die('Could not connect to MySQL: ' . mysql_error());
	}
	
	// ... and use the correct database
	$selected = mysql_select_db($db_name, $link);
	if (!$selected) 
	{
		die ('Could not select database: ' . mysql_error());
	}	
	
	// Insert into our local MySQL database
	mysql_query("INSERT INTO my_customer_table ( name, phone, email ) VALUES ( '" . $_POST['customer']['name'] . "', '" . $_POST['customer']['phone'] . "', '" . $_POST['customer']['email'] . "' ) ");
	$id_value = mysql_insert_id();
	
	// QuickBooks queueing class	
	$dsn = "$db_type://$db_username:$db_password@$db_hostname/$db_name";
	$Queue = new QuickBooks_WebConnector_Queue($dsn);
	
	// Queue it up!
	$Queue->enqueue(QUICKBOOKS_ADD_CUSTOMER, $id_value);
}

