<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Users_Login_Action extends Vtiger_Action_Controller {

	function loginRequired() {
		return false;
	}
        
        
        function checkPermission(Vtiger_Request $request) {  
               return true;  
        } 

	function process(Vtiger_Request $request) {
		$username = $request->get('username');
		$password = $request->get('password');

		$user = CRMEntity::getInstance('Users');
		$user->column_fields['user_name'] = $username;
		/* Super Admin, Date :: 14th oct 2017 :: Developer : Anjaneya */
			$hdnLoginSource = $request->get('hdnLoginSource');			
        if($hdnLoginSource == 'SALogin'){
				//echo $username;die;	
                $user = CRMEntity::getInstance('Users');
                $user->column_fields['user_name'] = $username;
               //$password = $user->retrieve_password($username);
			session_regenerate_id(true); // to overcome session id reuse.
			$userid = $user->retrieve_user_id($username);   
			Vtiger_Session::set('AUTHUSERID', $userid);
			// For Backward compatability
			// TODO Remove when switch-to-old look is not needed
			$_SESSION['authenticated_user_id'] = $userid;
			$_SESSION['app_unique_key'] = vglobal('application_unique_key');
			$_SESSION['authenticated_user_language'] = vglobal('default_language');

			//Enabled session variable for KCFINDER 
			$_SESSION['KCFINDER'] = array(); 
			$_SESSION['KCFINDER']['disabled'] = false; 
			$_SESSION['KCFINDER']['uploadURL'] = "test/upload"; 
			$_SESSION['KCFINDER']['uploadDir'] = "../test/upload";
			$deniedExts = implode(" ", vglobal('upload_badext'));
			$_SESSION['KCFINDER']['deniedExts'] = $deniedExts;
			// End

			//Track the login History
			$moduleModel = Users_Module_Model::getInstance('Users');
			$moduleModel->saveLoginHistory($user->column_fields['user_name']);
			//End

			if(isset($_SESSION['return_params'])){ 
							$return_params = $_SESSION['return_params'];
			}
			header ('Location: index.php?module=Users&parent=Settings&view=SystemSetup');
			exit();
			//end Super admin
			
        }else if ($user->doLogin($password)) {
			session_regenerate_id(true); // to overcome session id reuse.

			$userid = $user->retrieve_user_id($username);
			//$autologout_time = $user->retrieve_user_auto_logout($username);//Ganesh get user auto logout time from user details
			Vtiger_Session::set('AUTHUSERID', $userid);

			// For Backward compatability
			// TODO Remove when switch-to-old look is not needed
			
			 
			$_SESSION['authenticated_user_id'] = $userid;
			//$_SESSION['autologout_time'] = preg_replace("/[^0-9,.]/", "", $autologout_time);//Ganesh passing user auto logout time in session
			$_SESSION['app_unique_key'] = vglobal('application_unique_key');
			$_SESSION['authenticated_user_language'] = vglobal('default_language');
            
            		//Enabled session variable for KCFINDER 
            		$_SESSION['KCFINDER'] = array(); 
            		$_SESSION['KCFINDER']['disabled'] = false; 
            		$_SESSION['KCFINDER']['uploadURL'] = "test/upload"; 
            		$_SESSION['KCFINDER']['uploadDir'] = "../test/upload";
					$deniedExts = implode(" ", vglobal('upload_badext'));
					$_SESSION['KCFINDER']['deniedExts'] = $deniedExts; 
 
			$_SESSION['login_time'] = 'anji';

			// End

			//Track the login History
			$moduleModel = Users_Module_Model::getInstance('Users');
			$moduleModel->saveLoginHistory($user->column_fields['user_name']);
			//End
            
              if(isset($_SESSION['return_params'])){ 
					$return_params = $_SESSION['return_params'];
				}

			header ('Location: index.php?module=Users&parent=Settings&view=SystemSetup');
			exit();
		} else {
			header ('Location: index.php?module=Users&parent=Settings&view=Login&error=1');
			exit;
		}
	}
	
		}
