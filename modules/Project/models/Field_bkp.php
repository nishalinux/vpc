<?php
class Project_Field_Model extends Vtiger_Field_Model{
	public function isAjaxEditable() {
		$ajaxRestrictedFields = array('4', '72');
		$record = $_REQUEST['record'];
		$recordModel = Vtiger_Record_Model::getInstanceById($record, "Project");
		$projectstatus = $recordModel->get('projectstatus');
		if($projectstatus == 'completed' && $this->get('column') == 'projectstatus'){
			return false;
		}
		if(!$this->isEditable() || in_array($this->get('uitype'), $ajaxRestrictedFields)) {
			return false;
		}
		return true;
	}
}
?>