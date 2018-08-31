<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ************************************************************************************/
class PCMReports_Module_Model extends Vtiger_Module_Model {

	public function process(Vtiger_Request $request) {
		$mode = $request->get('mode');
		$projectid = $request->get('projectid');
		switch ($mode) {
			case "getProjectsWorkStatus":
				$this->getProjectsWorkStatus();
				break;
		case "getProjectsDetails":
				$this->getProjectsDetails();
				break;
 			default:
				$this->getDefaultViewName();
		}
	} 

	public function getDefaultViewName() {
		return $this->getPCMReportsViewName();
	}
	public function getPCMReportsViewName() {
		return 'DashBoard';
	}
	public function droptables()
	{
		global $adb;
		$db = PearDatabase::getInstance();
		$query = "DROP TABLE IF EXISTS temp_lead_handling;";
	}

	 
	
	function convertDaysFromHr($time)
	{	$result = '00:00:00';
		if(!empty($time)){
			
			$a = explode(':',$time);
			if($a[0] >= 24)
			{
				$days = $a[0]/24;
				$days = explode('.',$days);
				$hr = $a[0]%24;
				 
				$final = $days[0]. 'd' .':' .$hr. 'h' .':' . $a[1]. 'm';
				return $final;
			}else{
				return '00:'.$a[0].':'.$a[1];
			}
			
			return $result;
		}
		return $result;
		
	}
	public function getProjectsWorkStatus(){
		global $adb;
		$db = PearDatabase::getInstance();
		$data=$_REQUEST;
		 
		$projectid = $data['project'];
		$assignee = $data['assignee'];
		 
		$where = ($projectid == '')?'': " AND p.projectid = '$projectid' ";
		
		// where   upt.userid = '".$currentUser->getId()."'"
		$query = "SELECT p.projectid,p.projectname,p.startdate,p.targetenddate,count(pt.projectid) as task, sum(ptc.pcm_task_budget_dollars) as TaskBudget,sum(ptc.pcm_allotted_dollars) as AllottedDollars,sum(ptc.cf_842) as TaskHours,sum(pt.projecttaskhours) as WorkedHours FROM vtiger_project p left join vtiger_crmentity c on c.crmid = p.projectid left join vtiger_projecttask pt on p.projectid = pt.projectid left join vtiger_projecttaskcf ptc on pt.projecttaskid = ptc.projecttaskid where  c.deleted = 0  $where  and ptc.pcm_active = 1 group by pt.projectid ";
		
		$sql = $adb->pquery($query,array());
		$data=array();
		while($result = $adb->fetch_array($sql))
		{
			$data[]=$result;
		}
		return $data;
	}
	public function getProjectsDetails(){ 		
		global $adb;
		$db = PearDatabase::getInstance();
		$data=$_REQUEST;
		//Array (   [project] => 3 [assignee] => 7 [from_date] => 07-07-2017 [to_date] => 14-07-2017 [submit] => submit )
		//print_r($data);
	 
		$projectid = $data['projectid'];		
		//$where = ($projectid == '')?'': " AND p.projectid = '$projectid' ";
		
		// where   upt.userid = '".$currentUser->getId()."'"
		$query = "SELECT p.projectname,pt.projecttaskname, CONCAT(u.first_name,' ',u.last_name) as username,upt.allocated_hours,upt.worked_hours,upt.start_date,upt.end_date,upt.status FROM vtiger_usersprojecttasksrel upt left join vtiger_projecttask pt on upt.projecttaskid = pt.projecttaskid left join vtiger_project p on p.projectid = pt.projectid left join vtiger_users u on u.id = upt.userid where    p.projectid = $projectid ";
		 
		/*
		$branchid = $data['branch'];
		$from = $data['from_date'];
		if($from != ''){ $from = date("Y-m-d", strtotime($from));}
		$to = $data['to_date'];
		if($to != ''){ $to = date("Y-m-d", strtotime($to)); }

		$date_query="";
		if($from != ''){ $date_query .= " and DATE(c.modifiedtime) >= '".$from."' "; }
		if($to != ''){ $date_query .= " and DATE(c.modifiedtime) <= '".$to."' "; }

		 

		$date_query="";
		if($from != ''){ $date_query .= " and DATE(c.modifiedtime) >= '".$from."' "; }
		if($to != ''){ $date_query .= " and DATE(c.modifiedtime) <= '".$to."' "; }
 

	 */
		$sql = $adb->pquery($query,array());
		$data=array();
		while($result = $adb->fetch_array($sql))
		{
			$data[]=$result;
		}
		return $data;
	} 
	
	public function displayDatesAsString($date1,$date2)
	{
		$result = ' For All Dates';
		$d1 = $d2 = '';
		if($date1 != ''){ 	$d1 = date("d-m-Y", strtotime($date1) ); 	}
		if($date2 != ''){ 	$d2 = date("d-m-Y", strtotime($date2) ); 	}		
		if($d1 != '' && $d2 != ''){
			$result = " Between $d1 and $d2 ";
		}else if($d1 != ''){
			$result = " $d1  to Till";
		}else if($d2 != ''){
			$result = " Till $d2";
		}
		return $result;
	}
	function getProjects(){
			global $adb;
		$sql = $adb->query("SELECT projectid,projectname  FROM  vtiger_project p left join vtiger_crmentity c on p.projectid = c.crmid where c.deleted = 0");
		$data=array();
		while($result = $adb->fetch_array($sql))
		{
			$projectid=$result["projectid"];
			$projectname=$result["projectname"];
			$data[$projectid]=$projectname;
		}
		return $data;
	}
	
}
