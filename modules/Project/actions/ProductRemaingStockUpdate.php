<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
include_once 'modules/Users/Users.php';
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';
class Project_ProductRemaingStockUpdate_Action extends Vtiger_BasicAjax_Action {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		global $adb,$site_URL;
		$projectid = $request->get('projectid');
		$productid = $request->get('productid');

		$updateqty = "UPDATE vtiger_projectproductqty_details SET is_checked=? WHERE productid=? and projectid=?";
		$params = array(1,$productid,$projectid);
		$adb->pquery($updateqty,$params);

		//retrieving remainingqty
		$remainingqty = "SELECT allocatedtqty, used_qty FROM vtiger_projectproductqty_details WHERE  productid=? and projectid=?";
		$res = $adb->pquery($remainingqty,array($productid,$projectid));
		$allqty = $adb->query_result($res,0,'allocatedtqty');
		$used_qty = $adb->query_result($res,0,'used_qty');
		$remainingqty = $allqty-$used_qty;

		//ProductStock Update
		$productsqty = $adb->query_result($adb->pquery("select qtyinstock from vtiger_products where productid=?",array($productid)),0,'qtyinstock');
		$stockupdate = $productsqty+$remainingqty;
		$adb->pquery("Update vtiger_products set qtyinstock=? where productid=?",array($stockupdate,$productid));

		//Email Notification
		//Email Notification code started from here
		$recordModel = Vtiger_Record_Model::getInstanceById($productid, 'Products');
		$oldproduct = $recordModel->getData();
		$q = "SELECT c.smownerid as assigned_user_id FROM vtiger_projectcf pf left join vtiger_crmentity c on pf.projectid = c.crmid where pf.projectid = ? ";	
		$result = $adb->pquery($q,array($projectid));
		$contact_email =$adb->query_result($result,0,'email');
		$contact_firstname =$adb->query_result($result,0,'firstname');
		$contact_lastname =$adb->query_result($result,0,'lastname');
		
		$org_email1 =$adb->query_result($result,0,'email1');
		$org_email2 =$adb->query_result($result,0,'email2');
		$ProjectManagerName = '';
		if($contact_email != ''){
			$ProjectManagerEmail = $contact_email;
			if($org_email1 != ''){ $cc_email = $org_email1; }elseif($org_email2 != ''){ $cc_email = $org_email2; }
			$ProjectManagerName = trim($contact_firstname .' '. $contact_lastname);
		}elseif($org_email1 != ''){
			$ProjectManagerEmail = $org_email1;
		}elseif($org_email2 != ''){
			$ProjectManagerEmail = $org_email2;
		}else{
			$Project_assigned_user_id =$adb->query_result($result,0,'assigned_user_id');
			$ProjectManagerEmail = getUserEmail($Project_assigned_user_id);
			$ProjectManagerName = getUserName($Project_assigned_user_id);
		}
	
	// get from email 
	$query = "select from_email_field,server_username from vtiger_systems where server_type=?";
	$params = array('email');
	$result = $adb->pquery($query,$params);
	$from = $adb->query_result($result,0,'from_email_field');
	if($from == '') {$from =$adb->query_result($result,0,'server_username'); } 	 
	$from_email = getUserEmail($uid);	
 	
	$username = getUserName($uid);
	if($from_email == ''){$from_email = $from;}
	//urls
	 $co_url = $site_URL."index.php?module=Project&view=Detail&record=".$projectid;

	//Sending CO Mail to PM
	$subject ="Remaining Project Stock of $project_name is added to Products";				 
	$headers = "From:  ". $from_email ."\r\n";
	$headers .= "Reply-To: ". $from_email ."\r\n";
	$headers .= "CC: ". $cc_email ."\r\n";
	$headers .= "MIME-Version: 1.0\r\n";
	$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
	$message = '<html><body>';				 
	$message .= "<p>Dear $ProjectManagerName</p>
	<p>The Project Remaining Stock  <b>$project_no</b> - <b>$project_name</b>.  Please review notification of the Project Stock.</p>
	<p><a href='".$co_url."' style='font-family:Arial, Helvetica, sans-serif;font-size:12px; font-weight:bolder;text-decoration:none;color: #4242FD;' >View Project</a>.</p>
	<p>Product Name : ".$oldproduct['productname']."</p>
	<p>Product Qty Updated : ".$remainingqty."</p>
	<p><b>Thanks </b></p>
	<p>BMLG Team.</p>";
	$message .= "</body></html>";	
	//print_r(array($mail,$subject, $message, $from_email, $username, $ProjectManagerEmail));
	$mail = new PHPMailer();
	setMailerProperties($mail,$subject, $message, $from_email, $username, $ProjectManagerEmail);
	$status = MailSend($mail);

	//Ended 

		$response = new Vtiger_Response();
		$response->setResult(array($stockupdate));
		$response->emit();
	}
}
