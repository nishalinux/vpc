<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';
class Users_Save_Action extends Vtiger_Save_Action {
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$recordModel = Vtiger_Record_Model::getInstanceById($record, $moduleName);
		$currentUserModel = Users_Record_Model::getCurrentUserModel();

		// Check for operation access.
		$allowed = Users_Privileges_Model::isPermitted($moduleName, 'Save', $record);
		
		if ($allowed) {
			// Deny access if not administrator or account-owner or self
			if(!$currentUserModel->isAdminUser()) {
				if (empty($record)) {
					$allowed = false;
				} else if ($currentUserModel->get('id') != $recordModel->getId()) {
					$allowed = false;
				}
			}
		}

		if(!$allowed) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	/**
	 * Function to get the record model based on the request parameters
	 * @param Vtiger_Request $request
	 * @return Vtiger_Record_Model or Module specific Record Model instance
	 */
	protected function getRecordModelFromRequest(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
                $currentUserModel = Users_Record_Model::getCurrentUserModel();
		if(!empty($recordId)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			$modelData = $recordModel->getData();
			$recordModel->set('id', $recordId);
			$sharedType = $request->get('sharedtype');
			if(!empty($sharedType))
				$recordModel->set('calendarsharedtype', $request->get('sharedtype'));
			$recordModel->set('mode', 'edit');
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			$modelData = $recordModel->getData();
			$recordModel->set('mode', '');
		}

		foreach ($modelData as $fieldName => $value) {
			$requestFieldExists = $request->has($fieldName);
			if(!$requestFieldExists){
				continue;
			}
			$fieldValue = $request->get($fieldName, null);

			if ($fieldName === 'is_admin') {
                            if (!$currentUserModel->isAdminUser() && (!$fieldValue)) {
				$fieldValue = 'off';
                            } else if ($currentUserModel->isAdminUser() && ($fieldValue || $fieldValue === 'on')) {
                                $fieldValue = 'on';
                                $recordModel->set('is_owner', 1);
                            } else {
                                $fieldValue = 'off';
                                $recordModel->set('is_owner', 0);
                            }
                        }
			if($fieldValue !== null) {
				if(!is_array($fieldValue)) {
					$fieldValue = trim($fieldValue);
				}
				$recordModel->set($fieldName, $fieldValue);
			}
		}
		$homePageComponents = $recordModel->getHomePageComponents();
		$selectedHomePageComponents = $request->get('homepage_components', array());
		foreach ($homePageComponents as $key => $value) {
			if(in_array($key, $selectedHomePageComponents)) {
				$request->setGlobal($key, $key);
			} else {
				$request->setGlobal($key, '');
			}
		}

		// Tag cloud save
		$tagCloud = $request->get('tagcloudview');
		if($tagCloud == "on") {
			$recordModel->set('tagcloud', 0);
		} else {
			$recordModel->set('tagcloud', 1);
		}
		return $recordModel;
	}

	public function process(Vtiger_Request $request) {
		$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
		$_FILES = $result['imagename'];
		$recordModel = $this->saveRecord($request);
		
		if($request->get("record") == "")
		{

			global $HELPDESK_SUPPORT_EMAIL_ID, $site_URL, $adb;
			$email = $recordModel->get("email1");
			$username = $recordModel->get("user_name");
			$first_name = $recordModel->get("first_name");
			$last_name = $recordModel->get("last_name");
			$time = time();
			$options = array(
				'handler_path' => 'modules/Users/handlers/CreatePassword.php',
				'handler_class' => 'Users_CreatePassword_Handler',
				'handler_function' => 'createPassword',
				'handler_data' => array(
					'username' => $username,
					'email' => $email,
					'time' => $time,
					'hash' => md5($username . $time)
				)
			);
			$trackURL = Vtiger_ShortURL_Helper::generateURL($options);
			//echo $trackURL;exit;
			$content = 'Dear '.$last_name.' '.$first_name.',<br><br> 
						Your CRM Account has Created Please set password to use By clicking Below Link .<br> 
						<br><br> Link: ' . $trackURL . '<br><br>
						Regards,<br> 
						CRM Team.<br>' ;
			$mail = new PHPMailer();
			$query = "select from_email_field,server_username from vtiger_systems where server_type=?";
			$params = array('email');
			$result = $adb->pquery($query,$params);
			$from = $adb->query_result($result,0,'from_email_field');
			if($from == '') {$from =$adb->query_result($result,0,'server_username'); }
			$subject='Request : Create Password - vtigercrm';
			
			setMailerProperties($mail,$subject, $content, $from, $username, $email);
			$status = MailSend($mail);

			if ($status === 1)
          		header('Location:  index.php?modules=Users&view=Login&status=1');
			else
				header('Location:  index.php?modules=Users&view=Login&statusError=1');
		}
		
		if ($request->get('relationOperation')) {
			$parentRecordModel = Vtiger_Record_Model::getInstanceById($request->get('sourceRecord'), $request->get('sourceModule'));
			$loadUrl = $parentRecordModel->getDetailViewUrl();
		} else if ($request->get('isPreference')) {
			$loadUrl =  $recordModel->getPreferenceDetailViewUrl();
		} else {
			$loadUrl = $recordModel->getDetailViewUrl();
		}

		header("Location: $loadUrl");
	}
}
