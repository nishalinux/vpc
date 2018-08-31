<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Modified and improved by crm-now.de
 *************************************************************************************/
require_once("modules/Mailchimp/providers/MCAPI.class.php");

class Mailchimp_showGroupOverlay_View extends Vtiger_Edit_View {

	public function process(Vtiger_Request $request) {
		$viewer = $this->getViewer ($request);
		$moduleName = $request->getModule();
		$record = $request->get('record');
		$MailChimpAPIKey = Mailchimp_Module_Model::getApikey();
		//lists
		$api = new MCAPI($MailChimpAPIKey);
		$APILists = $api->lists();
		$lists = array();
		if (is_array($APILists)) {
			foreach ($APILists['data'] as $key => $value) {
				$lists[] = array("name"=>$value['name'],"id"=>$value['id']);
			}
		}
		$viewer->assign('MODULE',$moduleName);
		$viewer->assign('APILISTE',$lists);
		$viewer->assign('ID', $record );
		$viewer->view('showGroupOverlay.tpl', $moduleName);
	}
}

?>