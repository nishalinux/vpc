<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ProjectTask_Save_Action extends Vtiger_Save_Action {


	public function process(Vtiger_Request $request) {
		
		//$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true); //Added by sl for custom image field:start
		//$_FILES = $result['cf_769']; //Added by sl for custom image field:start
		$_REQUEST['pcm_assignee']= implode(";",$_REQUEST['pcm_assignee']);
		parent::process($request);
	}	 
}
