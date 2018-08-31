<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
class Settings_OS2LoginHistory_ListView_Model extends Settings_Vtiger_ListView_Model {

	/**
	 * Funtion to get the Login history basic query
	 * @return type
	 */
    public function getBasicListQuery() {
		global $adb,$current_user;
		//$adb->setDebug(true);
        $module = $this->getModule();
		$userNameSql = getSqlForNameInDisplayFormat(array('first_name'=>'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');
		
		$query = "SELECT login_id, vtiger_loginhistory.user_name, user_ip, logout_time, login_time, vtiger_loginhistory.status FROM $module->baseTable 
				INNER JOIN vtiger_users ON vtiger_users.user_name = $module->baseTable.user_name";
		
		$search_key = $this->get('search_key');
		$value = $this->get('search_value');
		
		$search_user = $this->get('search_user');
		$userip = $this->get('userip');
		$signintime = $this->get('signintime');
		$signouttime = $this->get('signouttime');
// echo $signin;echo $signout;
		//added by jyothi
		     //$signintime_ser = date('Y-m-d',strtotime($signintime));
		     //$signintime_ser = Vtiger_Datetime_UIType::getDateTimeValue($signintime);
		    //$signouttime_ser = date('Y-m-d',strtotime($signouttime));
		    //$signouttime_ser = Vtiger_Datetime_UIType::getDateTimeValue($signouttime);
		//ended here
		$status = $this->get('status');
		if(!empty($search_key) && !empty($value)) {
			$query .= " WHERE $module->baseTable.$search_key = '$value'";
		}
		
		if(!empty($search_user)) {
			//$searchquery	="SELECT vtiger_users.user_name FROM vtiger_users WHERE vtiger_users.first_name LIKE '%$search_user%' OR vtiger_users.last_name LIKE '%$search_user%'";
			$searchquery	="SELECT vtiger_users.user_name FROM vtiger_users WHERE vtiger_users.user_name LIKE '%$search_user%'";
			$searchResult = $adb->pquery($searchquery, array());
			 $searchRow = $adb->fetchByAssoc($searchResult);
			 $search_user = $searchRow['user_name'];
			$query .= " WHERE $module->baseTable.user_name LIKE '%$search_user%'";
		}
		if(!empty($userip)) {
			$query .= " AND $module->baseTable.user_ip LIKE '%$userip%'";
		}
		if(!empty($signintime)) {
			//error_reporting(-1);
			$startTime = "00:00:00";
			$startTime1 = "23:59:00";
			$signint_start = Vtiger_Datetime_UIType::getDBDateTimeValue($signintime." ".$startTime);
			$signint_end = Vtiger_Datetime_UIType::getDBDateTimeValue($signintime." ".$startTime1);
			$signintime_ser_start = date('Y-m-d H:i:s',strtotime($signint_start));
			$signintime_ser_end = date('Y-m-d H:i:s',strtotime($signint_end));
			$query .= " AND $module->baseTable.login_time BETWEEN '$signintime_ser_start' AND  '$signintime_ser_end'";
		}
		if(!empty($signouttime)) {
			$startTime = "00:00:00";
			$startTime1 = "23:59:00";
			$signoutt_start = Vtiger_Datetime_UIType::getDBDateTimeValue($signouttime." ".$startTime);
			$signoutt_end = Vtiger_Datetime_UIType::getDBDateTimeValue($signouttime." ".$startTime1);
			$signouttime_ser_start = date('Y-m-d H:i:s',strtotime($signoutt_start));
			$signouttime_ser_end = date('Y-m-d H:i:s',strtotime($signoutt_end));
			$signouttime_ser = date('Y-m-d',strtotime($signoutt));
			$query .= " AND $module->baseTable.logout_time BETWEEN '$signouttime_ser_start' AND  '$signouttime_ser_end'";
		}
		if(!empty($status)) {
			$query .= " AND $module->baseTable.status LIKE '%$status%'";
		}
		// echo $query;die;
		//Fix for http://trac.vtiger.com/cgi-bin/trac.cgi/ticket/7996
        $query .= " ORDER BY login_time DESC"; 
		return $query; 
    }

	public function getListViewLinks() {
		return array();
	}


	
	/** 
	 * Function which will get the list view count  
	 * @return - number of records 
	 */

	public function getListViewCount() {
		global $log;
		global $adb;
		//$adb->setDebug(true);
		$db = PearDatabase::getInstance();

		$module = $this->getModule();
		$listQuery = "SELECT count(*) AS count FROM $module->baseTable INNER JOIN vtiger_users ON vtiger_users.user_name = $module->baseTable.user_name";

		$search_key = $this->get('search_key');
		$value = $this->get('search_value');
		
		$search_user = $this->get('search_user');
		
		$userip = $this->get('userip');
		$signintime = $this->get('signintime');
		$signouttime = $this->get('signouttime');

		//added by jyothi
		        //$signintime_ser = date('Y-m-d',strtotime($signintime));
		        
		    //$signouttime_ser = date('Y-m-d',strtotime($signouttime));
		   // $signouttime_ser = Vtiger_Datetime_UIType::getDateTimeValue($signouttime);
		//ended here

		$status = $this->get('status');
		if(!empty($search_user)) {
			//$searchquery2	=	"SELECT vtiger_users.user_name FROM vtiger_users WHERE vtiger_users.last_name LIKE '%$search_user%'";
			$searchquery2	=	"SELECT vtiger_users.user_name FROM vtiger_users WHERE vtiger_users.user_name LIKE '%$search_user%'";
			$searchResult2 = $adb->pquery($searchquery2, array());
			 $searchRow2 = $adb->fetchByAssoc($searchResult2);
			 $search_user = $searchRow2['user_name'];
			$listQuery .= " WHERE $module->baseTable.user_name LIKE '%$search_user%'";
		}
		if(!empty($userip)) {
			$listQuery .= " AND $module->baseTable.user_ip LIKE '%$userip%'";
		}
		if(!empty($signintime)) {
			$signint = Vtiger_Datetime_UIType::getDateTimeValue($signintime);
			$signintime_ser = date('Y-m-d',strtotime($signint));
			$listQuery .= " AND $module->baseTable.login_time LIKE '%$signintime_ser%'";
		}
		if(!empty($signouttime)) {
			$listQuery .= " AND $module->baseTable.logout_time LIKE '%$signouttime_ser%'";
		}
		if(!empty($status)) {			
		    $signoutt = Vtiger_Datetime_UIType::getDateTimeValue($signouttime);
			$signouttime_ser = date('Y-m-d',strtotime($signoutt));
			$listQuery .= " AND $module->baseTable.status LIKE '%$status%'";
		}
		if(!empty($search_key) && !empty($value)) {
			$listQuery .= " AND $module->baseTable.$search_key = '$value'";
		}
		$listResult = $db->pquery($listQuery, array());
		return $db->query_result($listResult, 0, 'count');
	}

}
