<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * *********************************************************************************************************************************** */

class Settings_Mail_SaveAjax_Action extends Settings_Vtiger_IndexAjax_View
{

	function __construct()
	{
		parent::__construct();
		$this->exposeMethod('updateUsers');
		$this->exposeMethod('updateConfig');
		$this->exposeMethod('updateSignature');
	}

	public function updateUsers(Vtiger_Request $request)
	{
		$id = $request->get('id');
		$user = $request->get('user');
		Settings_Mail_Autologin_Model::updateUsersAutologin($id, $user);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => vtranslate('LBL_SAVED_CHANGES', $request->getModule(false))
		));
		$response->emit();
	}

	public function updateConfig(Vtiger_Request $request)
	{
		$name = $request->get('name');
		$val = $request->get('val');
		$type = $request->get('type');
		Settings_Mail_Config_Model::updateConfig($name, $val, $type);
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => vtranslate('LBL_SAVED_CHANGES', $request->getModule(false))
		));
		$response->emit();
	}

	public function updateSignature(Vtiger_Request $request)
	{
		$val = $request->get('val');
		Settings_Mail_Config_Model::updateConfig('signature', $val, 'signature');
		$response = new Vtiger_Response();
		$response->setResult(array(
			'success' => true,
			'message' => vtranslate('LBL_SAVED_SIGNATURE', $request->getModule(false))
		));
		$response->emit();
	}
}
