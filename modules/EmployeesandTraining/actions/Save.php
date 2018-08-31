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
		global $adb,$current_user;
		//$module = $request->getModule();
		$module = 'Users';
		$cf_2164 = $request->get('cf_2164');
		if($cf_2164 == "Pass"){
			$user = $current_user;
			require_once 'include/Webservices/Create.php';
			include_once 'include/Webservices/Update.php';
			$new_focus = array();
			$modulename = "Users";
			$new_focus['first_name'] = $request->get('cf_2179');
			$new_focus['last_name'] = $request->get('cf_2180');
			$new_focus['user_name'] = $request->get('cf_2177');
			$userName = $request->get('cf_2177');
			$new_focus['email1'] = $request->get('cf_2178');
			$new_focus['is_admin'] =  $request->get('cf_2183');
			$new_focus['user_password'] =  $request->get('cf_2181');
			$new_focus['confirm_password'] =  $request->get('cf_2182');
			$new_focus['roleid'] = $request->get('cf_2184');
			//Auto Logout Time update
			$new_focus['autologout_time'] = '60 mins';
			
			$query = "SELECT id FROM vtiger_users WHERE user_name=?";
			$result =$adb->pquery($query, array($userName));
			$nums = $adb->num_rows($result);
			if($nums > 0){
				$id = $adb->query_result($result, 0, "id");
				$existingid = vtws_getWebserviceEntityId('Users',$id);
				$new_focus['id'] = $existingid;
				$record = vtws_update($new_focus, $user);
			}
			else{
				$record = vtws_create($modulename, $new_focus, $user);
			}
		}
		parent::process($request);
		//}
		//$record = vtws_create($modulename, $parameters, $user);
		
	}
}
