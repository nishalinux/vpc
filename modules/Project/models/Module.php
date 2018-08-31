<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ************************************************************************************/

class Project_Module_Model extends Vtiger_Module_Model {

	public function getSideBarLinks($linkParams) {
		$linkTypes = array('SIDEBARLINK', 'SIDEBARWIDGET');
		$links = parent::getSideBarLinks($linkParams);

		$quickLinks = array(
			array(
				'linktype' => 'SIDEBARLINK',
				'linklabel' => 'LBL_TASKS_LIST',
				'linkurl' => $this->getTasksListUrl(),
				'linkicon' => '',
			),
            array(
				'linktype' => 'SIDEBARLINK',
				'linklabel' => 'LBL_MILESTONES_LIST',
				'linkurl' => $this->getMilestonesListUrl(),
				'linkicon' => '',
			),
		);
		foreach($quickLinks as $quickLink) {
			$links['SIDEBARLINK'][] = Vtiger_Link_Model::getInstanceFromValues($quickLink);
		}

		return $links;
	}

	public function getTasksListUrl() {
		$taskModel = Vtiger_Module_Model::getInstance('ProjectTask');
		return $taskModel->getListViewUrl();
	}
    public function getMilestonesListUrl() {
		$milestoneModel = Vtiger_Module_Model::getInstance('ProjectMilestone');
		return $milestoneModel->getListViewUrl();
	}
	/**manasa added on may 27 2016
	 * Function to get relation query for particular module with function name
	 * @param <record> $recordId
	 * @param <String> $functionName
	 * @param Vtiger_Module_Model $relatedModule
	 * @return <String>
	 */
	public function getRelationQuery($recordId, $functionName, $relatedModule) {
		if ($functionName === 'get_activities') {
			$userNameSql = getSqlForNameInDisplayFormat(array('first_name' => 'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');
			$query = "SELECT CASE WHEN (vtiger_users.user_name not like '') THEN $userNameSql ELSE vtiger_groups.groupname END AS user_name,
						vtiger_cntactivityrel.contactid, vtiger_seactivityrel.crmid AS parent_id,
						vtiger_crmentity.*, vtiger_activity.activitytype, vtiger_activity.subject, vtiger_activity.date_start, vtiger_activity.time_start,
						vtiger_activity.recurringtype, vtiger_activity.due_date, vtiger_activity.time_end, vtiger_activity.visibility,
						CASE WHEN (vtiger_activity.activitytype = 'Task') THEN (vtiger_activity.status) ELSE (vtiger_activity.eventstatus) END AS status
						FROM vtiger_activity
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_activity.activityid
						INNER JOIN vtiger_cntactivityrel ON vtiger_cntactivityrel.activityid = vtiger_activity.activityid
						LEFT JOIN vtiger_seactivityrel ON vtiger_seactivityrel.activityid = vtiger_activity.activityid
						LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
						LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid
							WHERE vtiger_cntactivityrel.contactid = ".$recordId." AND vtiger_crmentity.deleted = 0
								AND vtiger_activity.activitytype <> 'Emails'";

			$relatedModuleName = $relatedModule->getName();
			$query .= $this->getSpecificRelationQuery($relatedModuleName);
			$nonAdminQuery = $this->getNonAdminAccessControlQueryForRelation($relatedModuleName);
			if ($nonAdminQuery) {
				$query = appendFromClauseToQuery($query, $nonAdminQuery);
			}
		} else {
			$query = parent::getRelationQuery($recordId, $functionName, $relatedModule);
		}
		if($_REQUEST['relatedModule'] == 'Sample'){
			$x = explode("FROM", $query);
			if (strpos($x[1], 'vtiger_samplecf') !== false) {
			   
			}else{
				$z= substr($x[1], 15);
				$query = $x[0]." From vtiger_sample INNER JOIN vtiger_samplecf ON vtiger_sample.sampleid = vtiger_samplecf.sampleid ".$z;
			}
		}
		return $query;
	}
	
	public function getProjectsList(){
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$db = PearDatabase::getInstance(); 
		$query = "SELECT  distinct  p.projectid,  p.projectname FROM vtiger_usersprojecttasksrel upt left join vtiger_projecttask pt on upt.projecttaskid = pt.projecttaskid  left join vtiger_project p on p.projectid = pt.projectid where upt.userid= ".$currentUser->getId(). " order by p.projectid";

		$result = $db->pquery($query, array());
		$project = array();
		for($i=0; $i<$db->num_rows($result); $i++) {	
			$project[$db->query_result($result, $i, 'projectid')] = $db->query_result($result, $i, 'projectname');
		}
		return $project;
	}
	
	/**
	 * Function returns Leads grouped by Industry
	 * @param type $data
	 * @return <Array>
	 */
	public function getProjectsTaskProgress($pagingModel,$pid) {
	 	
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$db = PearDatabase::getInstance(); 
		$where = ($pid == '')?'': " AND p.projectid = '$pid' ";
		$query = "SELECT upt.userid,upt.allocated_hours,upt.worked_hours,upt.start_date,upt.end_date,upt.status,pt.projecttaskname,p.projectname FROM vtiger_usersprojecttasksrel upt left join vtiger_projecttask pt on upt.projecttaskid = pt.projecttaskid left join vtiger_project p on p.projectid = pt.projectid where   upt.userid = '".$currentUser->getId()."' $where   LIMIT ".$pagingModel->getStartIndex().", ".$pagingModel->getPageLimit()."";

		$result = $db->pquery($query, array());

		$models = array();
		for($i=0; $i<$db->num_rows($result); $i++) {			 
			 
			//$models[$i][0] = getUserFullName($db->query_result($result, $i, 'userid'));
			$models[$i][0] = $db->query_result($result, $i, 'projectname');
			$models[$i][1] = $db->query_result($result, $i, 'projecttaskname');
			$models[$i][2] = $db->query_result($result, $i, 'allocated_hours');
			$models[$i][3] = $db->query_result($result, $i, 'worked_hours');			
			$models[$i][4] = round(($db->query_result($result, $i, 'worked_hours') / $db->query_result($result, $i, 'allocated_hours') ) * 100 ) . '%';
			$models[$i][5] = $db->query_result($result, $i, 'start_date');
			$models[$i][6] = ($db->query_result($result, $i, 'end_date') == '1970-01-01')?'':$db->query_result($result, $i, 'end_date'); 
			$models[$i][7] = $db->query_result($result, $i, 'status');
		}
		return $models;
	}
	 /**
	 * Function returns Top Project task Header
	 * 
	 */
    
    function getProjectsTaskProgressHeaderHeader() {
        
         $headerArray = array();
         /*$fieldsToDisplay=  array("projectname","project_no","startdate","targetenddate"); 
         $moduleModel = Vtiger_Module_Model::getInstance('Project');
          foreach ($fieldsToDisplay as $value) {
                     $fieldInstance = Vtiger_Field_Model::getInstance($value,$moduleModel); 
                          if($fieldInstance->isViewable()){
                                $headerArray = array_merge($headerArray,array($value =>$fieldInstance->label));
                               }
           } */
		   $headerArray = array_merge($headerArray,array(
		   'projectname'=>'Project Name',
		   'projecttaskname'=>'Task Name',
		   'allocated_hours'=>'Allotted Hours',
		   'worked_hours'=>'Worked Hours',
		   'progress'=>'Progress',
		   'start_date'=>'Start Date',
		   'end_date'=>'End Date',
		   'status'=>'Status'
		   ));
        return $headerArray;
    }
	public function getProjectsProgress($pagingModel) {
	 	
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$db = PearDatabase::getInstance();
   
        $moduleModel = Vtiger_Module_Model::getInstance('Potentials');
        $fieldsToDisplay=  array("amount","related_to");
         
       // $query = "SELECT p.projectid,p.projectname,p.project_no,p.startdate,p.targetenddate,count(pt.projectid) as tasks FROM vtiger_project p left join vtiger_projecttask pt on p.projectid = pt.projectid left join vtiger_projecttaskcf ptc on ptc.projecttaskid = pt.projecttaskid  where ptc.pcm_active = 1 group by pt.projectid LIMIT ".$pagingModel->getStartIndex().", ".$pagingModel->getPageLimit()."";
	   
        $query = "SELECT p.projectname,pt.projecttaskname,upt.allocated_hours,upt.worked_hours,upt.start_date,upt.end_date FROM vtiger_usersprojecttasksrel upt left join vtiger_projecttask pt on upt.projecttaskid = pt.projecttaskid left join vtiger_project p on p.projectid = pt.projectid  where upt.userid = ".$currentUser->getId()." LIMIT ".$pagingModel->getStartIndex().", ".$pagingModel->getPageLimit()."";
      
     	$result = $db->pquery($query, array());

		$models = array();
		for($i=0; $i<$db->num_rows($result); $i++) {			 
			 
			$models[$i][0] = $db->query_result($result, $i, 'projectname');
			$models[$i][1] = $db->query_result($result, $i, 'projecttaskname');
			$models[$i][2] = $db->query_result($result, $i, 'allocated_hours');
			$models[$i][3] = $db->query_result($result, $i, 'worked_hours');
			$models[$i][4] = round(($db->query_result($result, $i, 'worked_hours') / $db->query_result($result, $i, 'allocated_hours') ) * 100 ) . '%';
			$models[$i][5] = $db->query_result($result, $i, 'start_date'); 
			$models[$i][6] = ($db->query_result($result, $i, 'end_date') == '1970-01-01')?'':$db->query_result($result, $i, 'end_date'); 
		}
		return $models;
	}
	 /**
	 * Function returns Top Project Header
	 * 
	 */
    
    function getProjectsProgressHeaderHeader() {
        
		return array('projectname'=>'Project','projecttaskname'=>'Project Task','allocated_hours'=>'Allocated Hours','worked_hours'=>'Worked Hours', 'progress'=>'Progress','start_date'=>'Start Date','end_date'=>'End Date');
    }
	//** Products Qty Check Before Save :: Manasa Dec 18th 2017
	public function checkProductsQtyStatus($record){
		$productids = array();
		$status = '';
		global $adb, $current_user;	
		$produts = "SELECT crmid, module, relcrmid, relmodule FROM vtiger_crmentityrel WHERE crmid=? and relmodule=?";
		$res = $adb->pquery($produts,array($record,'Products'));
		$rows = $adb->num_rows($res);
		for($i=0;$i<$rows;$i++){
			$productids[] = $adb->query_result($res,$i,'relcrmid');
		}
		//To Check quantity of each product
		$qtyquery = "SELECT productid,qtyinstock FROM vtiger_products WHERE productid in (" . generateQuestionMarks($productids) . ")";
		$result = $adb->pquery($qtyquery,$productids);
		$rows = $adb->num_rows($result);
		for($i=0;$i<$rows;$i++){
			$quantity[$adb->query_result($result,$i,'productid')] = $adb->query_result($result,$i,'qtyinstock');
		}
		//Requried Quantity to create
		$act = "SELECT productid, allocatedtqty FROM vtiger_projectproductqty_details WHERE productid in (" . generateQuestionMarks($productids) . ")";
		$reqres = $adb->pquery($act,$productids);
		$rows = $adb->num_rows($reqres);
		for($i=0;$i<$rows;$i++){
			$Reququantity[$adb->query_result($reqres,$i,'productid')] = $adb->query_result($reqres,$i,'allocatedtqty');
		}
		foreach($Reququantity as $k=>$v){
			if($v >= $quantity[$k] && $v != ''){
				$status = true;
			}
		}
		return $status;
	}
	//Ended here
}