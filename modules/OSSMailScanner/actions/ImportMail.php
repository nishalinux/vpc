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

class OSSMailScanner_ImportMail_Action extends Vtiger_Action_Controller
{

	public function checkPermission(Vtiger_Request $request)
	{
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if (!$currentUserModel->isAdminUser()) {
			throw new \Exception\NoPermittedForAdmin('LBL_PERMISSION_DENIED');
		}
	}

	function process(Vtiger_Request $request)
	{
		$params = $request->get('params');
		$scannerModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
		$mailScanMail = $scannerModel->manualScanMail($params);
		if ($mailScanMail['CreatedEmail']) {
			$return = $mailScanMail['CreatedEmail'];
		}
		$response = new Vtiger_Response();
		$response->setResult($return);
		$response->emit();
	}
}
