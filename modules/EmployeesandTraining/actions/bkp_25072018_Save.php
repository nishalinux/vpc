<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class EmployeesandTraining_Save_Action extends Vtiger_Save_Action {

	public function process(Vtiger_Request $request) {
		global $adb;
		//$adb->setDebug(true);
		/*echo $request->get('cf_2177');
		echo "<br/>";
		print_r($request);*/
		
		
	/*	
require_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Update.php';
$new_focus = array();
$modulename = "Users";
$new_focus['first_name'] = $request->get('cf_21790.');;
$new_focus['last_name'] = $request->get('cf_2180');
$new_focus['user_name'] = $request->get('cf_2177');
$new_focus['email1'] = $request->get('cf_2178');
$new_focus['is_admin'] =  $request->get('cf_2183');
$new_focus['user_password'] =  $request->get('cf_2181');
//$new_focus['roleid'] = vtws_getWebserviceEntityId('Roles','H10');
$new_focus['roleid'] = 'H10';

if($adb->num_rows($res) != 0){
	$alumnisurveyid = $record;
	$existingid = vtws_getWebserviceEntityId('Users',$alumnisurveyid);
	$parameters['id'] = $existingid;
	$record = vtws_update($parameters, $user);
}else{
	$record = vtws_create($modulename, $parameters, $user);
}
exit;*/
		parent::process($request);
	}
}
