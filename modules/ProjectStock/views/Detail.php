<?php

class ProjectStock_Detail_View extends Inventory_Detail_View {
	
	/**
	 * Function to get Ajax is enabled or not
	 * @param Vtiger_Record_Model record model
	 * @return <boolean> true/false
	 */
	//function isAjaxEnabled($recordModel) {
		//return false;
	//}
	/*public function process(Vtiger_Request $request){
		global $current_user;
		$isadminuser = is_admin($current_user);
		//$recordModel = Vtiger_Record_Model::getInstanceById($record, "ProjectStock");
		//$projectid = $recordModel->get('projectid');
		//Project Assigned To Owner
		if($projectid != '' && $projectid != null){
			//$projectModel = Vtiger_Record_Model::getInstanceById($projectid, "Project");
			//$projectowner = $projectModel->get('assigned_user_id');
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('IS_ADMIN_USER', $isadminuser);
		$viewer->assign('PROJECTOWNER',$projectowner);
		parent::process();
	}*/

}
