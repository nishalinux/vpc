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
require_once('data/Tracker.php');
class OSSMail_Sendroundcube_View extends Vtiger_Index_View
{
	public function process(Vtiger_Request $request)
	{
		global $log;
		$recordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
		$user_name = '';
		if (PHP_SAPI == 'cgi-fcgi') {
			$user_name = Users_Record_Model::getCurrentUserModel()->user_name;
		}
		$user_name = Users_Record_Model::getCurrentUserModel()->user_name;
		$log->debug("user_name".$user_name);
		$log->debug("user_name".print_r($recordModel,true));
		$recordModel->executeCron(PHP_SAPI . ' - ' . $user_name);
    }

}
