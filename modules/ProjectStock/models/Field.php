<?php
class ProjectStock_Field_Model extends Vtiger_Field_Model{
	public function isAjaxEditable() {
		$ajaxRestrictedFields = array('4', '72');
		if(!$this->isEditable() || in_array($this->get('uitype'), $ajaxRestrictedFields)) {
			return false;
		}
		$record = $_REQUEST['record'];
		$recordModel = Vtiger_Record_Model::getInstanceById($record, "ProjectStock");
		$stockstatus = $recordModel->get('stockstatus');
		if($stockstatus == 'Approved'){
			return false;
		}
		global $current_user,$adb;
		
		$userid = $current_user->id;
		$userstatus = $current_user->is_admin;
		if($userstatus != 'on'){
			$projectid = $recordModel->get('projectid');
			$ownerquery =  $adb->pquery('SELECT smownerid FROM vtiger_crmentity where crmid=?',array($projectid));
			$assignedid = $adb->query_result($ownerquery ,0,'smownerid');
			if($assignedid != $userid){
				return false;
			}
		}
		return true;
	}
}
?>