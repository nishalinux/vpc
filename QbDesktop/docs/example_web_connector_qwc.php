<?php

/**
 * Example of generating QuickBooks *.QWC files 
 * 
 * @author Keith Palmer <keith@consolibyte.com>
 * 
 * @package QuickBooks
 * @subpackage Documentation
 */

// Error reporting... 
 

/**
 * Require the utilities class
 */
require_once '../QuickBooks.php';
require_once '../../config.inc.php'; 
global $site_URL,$dbconfig,$qb; 

$name = 'Vtiger CRM QuickBooks Integration'; // A name for your server (make it whatever you want)
$descrip = 'QuickBooks SOAP Server';		 // A description of your server 
 
$appurl = $site_URL.'QbDesktop/QuickBooks/SOAP/Server.php';		// This *must* be httpS:// (path to your QuickBooks SOAP server)
$appsupport = $site_URL.'QbDesktop/index.php'; 		// This *must* be httpS:// and the domain name must match the domain name above  
$pass = $qb['pass'];
$username = $qb['user'];		// This is the username you stored in the 'quickbooks_user' table by using QuickBooks_Utilities::createUser()

$fileid  = '57F3B9B6-86F1-4FCC-B1FF-966DE1813D20';		// Just make this up, but make sure it keeps that format
$ownerid = '57F312B6-86F1-4FCC-B1FF-166DE1817D20';		// Just make this up, but make sure it keeps that format

$qbtype = QUICKBOOKS_TYPE_QBFS;	// You can leave this as-is unless you're using QuickBooks POS QBFS

$readonly = false; // No, we want to write data to QuickBooks

$run_every_n_seconds = 60; // Run every 600 seconds (10 minutes)

// Generate the XML file
$QWC = new QuickBooks_WebConnector_QWC($name, $descrip, $appurl, $appsupport, $username, $fileid, $ownerid, $qbtype, $readonly, $run_every_n_seconds);
$xml = $QWC->generate();

// Send as a file download
header('Content-type: text/xml');
header('Content-Disposition: attachment; filename="quickbooks.qwc"'); 
print($xml);
exit;
