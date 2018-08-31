<?php
Class ProjectStock_Edit_View extends Inventory_Edit_View {
	public function checkPermission(Vtiger_Request $request) {
		$record = $request->get('record');
		$dup = $request->get('isDuplicate');
		if($dup == 'true'){
			return '';
		}else if($record != ''){
			/*global $current_user;
			$isadminuser = is_admin($current_user);
			$recordModel = Vtiger_Record_Model::getInstanceById($record, "ProjectStock");
			$projectid = $recordModel->get('projectid');
			//Project Assigned To Owner
			if($projectid != '' && $projectid != null){
				$projectModel = Vtiger_Record_Model::getInstanceById($projectid, "Project");
				$projectowner = $projectModel->get('assigned_user_id');
			}
			if($projectowner == $current_user->id || $isadminuser == 1){
				return '';
			}else{
				throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $request->getModule()));
			}			
		}else{
			return '';*/
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $request->getModule()));
		}
	}

	public function process(Vtiger_Request $request) {
		global $current_user;
		$isadminuser = is_admin($current_user);
		$viewer = $this->getViewer($request);
		$viewer->assign('IS_ADMIN_USER', $isadminuser);
		$record = $request->get('record');
		if($record != ''){
			$recordModel = $this->record?$this->record:Vtiger_Record_Model::getInstanceById($record, "ProjectStock");
			$projectid = $recordModel->get('projectid');
			
			//Project Assigned To Owner
			if($projectid != '' && $projectid != null){
				$projectModel = Vtiger_Record_Model::getInstanceById($projectid, "Project");
				$projectowner = $projectModel->get('assigned_user_id');
				$viewer->assign('PROJECTOWNER',$projectowner);
			}
			
			
		}
		parent::process($request);
	}
}