<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class PCMReports_IndexAjax_Action extends Vtiger_SaveAjax_Action {

   function __construct() {
	   parent::__construct();
	}
	
	public function process(Vtiger_Request $request) {
		
		global $adb;
		$adb = PearDatabase::getInstance();
		$mode = $request->get('mode');
		$response = new Vtiger_Response();
		
		switch ($mode) {
			case "getProjectsList":
				$id = $request->get('projectid');
				$query = "SELECT pt.projecttaskid,pt.projecttaskname,pt.projecttask_no FROM vtiger_projecttask pt left join vtiger_crmentity c on c.crmid = pt.projecttaskid where pt.projectid = $id and deleted = 0";
				$result = $adb->pquery($query,array());
				
				if ($adb->num_rows($result) > 0) {  
				
					 $tasks = '<option value="">All</option>';
					while($data = $adb->fetch_array($result))
					{	 
						$tasks .= "<option value='".$data['projecttaskid']."'>".$data['projecttask_no'].'-'.$data['projecttaskname']."</option>";
					}
				}else{
					$tasks = '<option value="">All</option>';
				} 				
					$responseData = array("message"=>$tasks, 'success'=>true);
					$response->setResult($responseData);
					$response->emit();
				break;
			case "getAssigneeFromTaskId":
				$id = $request->get('projecttaskid');
				$query = "SELECT upt.userid, CONCAT(u.first_name,' ',u.last_name) as name  FROM vtiger_usersprojecttasksrel upt left join vtiger_users u on u.id = upt.userid where upt.projecttaskid = $id";
				$result = $adb->pquery($query,array());
				
				if ($adb->num_rows($result) > 0) {  
				
					 $tasks = '<option value="">All</option>';
					while($data = $adb->fetch_array($result))
					{	 
						$tasks .= "<option value='".$data['userid']."'>".$data['name']."</option>";
					}
				}else{
					$tasks = '<option value="">All</option>';
				} 				
					$responseData = array("message"=>$tasks, 'success'=>true);
					$response->setResult($responseData);
					$response->emit();
				break;
			case "getAssigneeFromProjectId":
				$id = $request->get('projectid'); $where = '';
				if($id != ''){ $where = "pt.projectid = $id and ";} 
				$query = " SELECT distinct upt.userid, CONCAT(u.first_name,' ',u.last_name) as name  FROM vtiger_usersprojecttasksrel upt left join vtiger_users u on u.id = upt.userid where upt.projecttaskid in ( SELECT pt.projecttaskid FROM vtiger_projecttask pt left join vtiger_crmentity c on c.crmid = pt.projecttaskid where $where deleted = 0) ";
				$result = $adb->pquery($query,array());
				
				if ($adb->num_rows($result) > 0) {   
					$tasks = '<option value="">All</option>';
					while($data = $adb->fetch_array($result))
					{	 
						$tasks .= "<option value='".$data['userid']."'>".$data['name']."</option>";
					}
				}else{
					$tasks = '<option value="">All</option>';
				} 				
					$responseData = array("message"=>$tasks, 'success'=>true);
					$response->setResult($responseData);
					$response->emit();
				break;
			 
			default:
				$response->setError($e->getCode(), "Please study the errorcode is ".$e->getCode());
				$response->emit();
		}
	}
	
}
?>
