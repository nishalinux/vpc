<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ProjectStock_BasicAjax_Action extends Vtiger_BasicAjax_Action {

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		$searchValue = $request->get('search_value');
		$searchModule = $request->get('search_module');

		$parentRecordId = $request->get('parent_id');
		$parentModuleName = $request->get('parent_module');
		$relatedModule = $request->get('module');
		if($searchModule == 'Products' && $relatedModule == 'ProjectStock'){
			$result = array();
			$projectid = $request->get('projectid');
			$staff = $this->getProjectStockProjects($searchValue,$projectid);
			for($i=0;$i<count($staff[0]);$i++){
				$name = $staff[0][$i];
				$fval = $staff[1][$i];
				$result[] = array('label'=>$name, 'value'=>$name, 'id'=>$fval);
			}
		}else if($searchModule == 'Project' && $relatedModule == 'ProjectStock'){
			$result = array();
			$projectid = $request->get('projectid');
			$staff = $this->getInProgressProjects($searchValue);
			for($i=0;$i<count($staff[0]);$i++){
				$name = $staff[0][$i];
				$fval = $staff[1][$i];
				$result[] = array('label'=>$name, 'value'=>$name, 'id'=>$fval);
			}
		}
		else{
			$searchModuleModel = Vtiger_Module_Model::getInstance($searchModule);
			$records = $searchModuleModel->searchRecord($searchValue, $parentRecordId, $parentModuleName, $relatedModule);

			$result = array();
			if(is_array($records)){
				foreach($records as $moduleName=>$recordModels) {
					foreach($recordModels as $recordModel) {
						$result[] = array('label'=>decode_html($recordModel->getName()), 'value'=>decode_html($recordModel->getName()), 'id'=>$recordModel->getId());
					}
				}
			}
		}

		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
	public function getProjectStockProjects($searchTerm,$projectid){
		global $adb;
		//$adb->setDebug(true);
		$pnames = $adb->pquery("select * from vtiger_projectsproduct_details where projectid=?",array($projectid));
		$proid = array();
		for($k =0 ; $k<$adb->num_rows($pnames);$k++){
			$proid[] =  $adb->query_result($pnames,$k,'productnumber');
		}
		$sql = $adb->pquery("SELECT * FROM vtiger_products,vtiger_crmentity where vtiger_crmentity.crmid = vtiger_products.productid  and deleted=0 and productname like '%$searchTerm%' and product_no in (" . generateQuestionMarks($proid) . ") ",array($proid));
		$rows=$adb->num_rows($sql);
		$staff =array();
		for($i=0;$i<$rows;$i++){
			$staffname = $adb->query_result($sql,$i,'productname');
			$fieldstaffid = $adb->query_result($sql,$i,'productid');
			$staff[0][] = $staffname;
			$staff[1][] = $fieldstaffid;
		}
		return $staff;
	}
	
	public function getInProgressProjects($searchTerm){
		global $adb;
		//$adb->setDebug(true);
		$sql = $adb->pquery("SELECT * FROM vtiger_project,vtiger_crmentity where vtiger_crmentity.crmid = vtiger_project.projectid  and deleted=0 and project_no like '%$searchTerm%' and projectstatus not in ('completed') ",array());
		$rows=$adb->num_rows($sql);
		$staff =array();
		for($i=0;$i<$rows;$i++){
			$staffname = $adb->query_result($sql,$i,'project_no');
			$fieldstaffid = $adb->query_result($sql,$i,'projectid');
			$staff[0][] = $staffname;
			$staff[1][] = $fieldstaffid;
		}
		return $staff;
	}
	
}
