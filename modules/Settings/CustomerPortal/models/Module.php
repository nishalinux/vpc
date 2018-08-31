<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_CustomerPortal_Module_Model extends Settings_Vtiger_Module_Model {

	var $name = 'CustomerPortal';

	/**
	 * Function to get Current portal user
	 * @return <Interger> userId
	 */
	public function getCurrentPortalUser() {
		$db = PearDatabase::getInstance();

		$result = $db->pquery("SELECT prefvalue FROM vtiger_customerportal_prefs WHERE prefkey = 'userid' AND tabid = 0", array());
		if ($db->num_rows($result)) {
			return $db->query_result($result, 0, 'prefvalue');
		}
		return false;
	}

	/**
	 * Function to get current default assignee from portal
	 * @return <Integer> userId
	 */
	public function getCurrentDefaultAssignee() {
		$db = PearDatabase::getInstance();

		$result = $db->pquery("SELECT prefvalue FROM vtiger_customerportal_prefs WHERE prefkey = 'defaultassignee' AND tabid = 0", array());
		if ($db->num_rows($result)) {
			return $db->query_result($result, 0, 'prefvalue');
		}
		return false;
	}

	/**
	 * Function to get list of portal modules
	 * @return <Array> list of portal modules <Vtiger_Module_Model>
	 */
	public function getModulesList() {
		if (!$this->portalModules) {
			$db = PearDatabase::getInstance();
				$type = array();
			$sql = $db->query("SELECT * FROM `vtiger_portaltype`");
			$nooftypes = $db->num_rows($sql);
			while($res = $db->fetchByAssoc($sql)){
				$type[] = $res['portaltype'];
			}

			foreach ($type as $portaltype) {
				// (1,2,3,7,9,10,16,18,19,21,22,26,28,34,35,39,40,41,42,47)
				$tabs_qry = "INSERT vtiger_customerportal_tabs (
				tabid, visible, sequence, type)SELECT tabid, 0, tablabel,'$portaltype' FROM vtiger_tab WHERE isentitytype=1 AND tabid IN (4,6,8,13,14,15,20,23,35,36,38,43,44,45,46,70,67)";
				$tabs_qrylist = $db->pquery($tabs_qry,array());

				$def_qry = "INSERT vtiger_customerportal_prefs (
				tabid, prefkey, prefvalue, type)VALUES(0,'defaultassignee',2,'$portaltype')";
				$def_list = $db->pquery($def_qry,array());
				$user_qry = "INSERT vtiger_customerportal_prefs (
				tabid, prefkey, prefvalue, type)VALUES(0,'userid',0,'$portaltype')";
				$user_list = $db->pquery($user_qry,array());
				
				$prefs_qry = "INSERT vtiger_customerportal_prefs (
				tabid, prefkey, prefvalue, type)SELECT tabid, 'showrelatedinfo', 1,'$portaltype' FROM vtiger_tab WHERE isentitytype=1 AND tabid IN (4,6,8,13,14,15,20,23,35,36,38,43,44,45,46,111,67)";
				$prefs_qrylist = $db->pquery($prefs_qry,array());
			}	

			$query = "SELECT vtiger_customerportal_tabs.*,vtiger_customerportal_prefs.prefvalue,vtiger_tab.tablabel FROM vtiger_customerportal_tabs
					INNER JOIN vtiger_customerportal_prefs ON vtiger_customerportal_prefs.type=vtiger_customerportal_tabs.type
					AND  vtiger_customerportal_prefs.tabid=vtiger_customerportal_tabs.tabid
					INNER JOIN vtiger_tab ON vtiger_customerportal_tabs.tabid = vtiger_tab.tabid AND vtiger_tab.presence = 0 WHERE vtiger_customerportal_tabs.type='' AND vtiger_customerportal_prefs.type='' ORDER BY vtiger_customerportal_tabs.sequence";

			$result = $db->pquery($query, array());
			$rows = $db->num_rows($result);

			for($i=0; $i<$rows; $i++) {
				$rowData = $db->query_result_rowdata($result, $i);
				$tabId = $rowData['tabid'];
				$moduleModel = Vtiger_Module_Model::getInstance($tabId);
				foreach ($rowData as $key => $value) {
					$moduleModel->set($key, $value);
				}
				$portalModules[$tabId] = $moduleModel;
			}
			$this->portalModules = $portalModules;
		}
		return $this->portalModules;
	}

	/**
	 * Function to save the details of Portal modules
	 */
	public function save() {
		$db = PearDatabase::getInstance();
		$privileges = $this->get('privileges');
		$defaultAssignee = $this->get('defaultAssignee');
		$portalModulesInfo = $this->get('portalModulesInfo');
		$portaltype = $this->get('portaltype');
		//Update details of view all record option for every module from Customer portal
		if($privileges == 'Administrator'){
			$privileges = 1;
		}
		else{
			$privileges = 0;
		}
			$updateQuery = "UPDATE vtiger_customerportal_prefs SET prefvalue = CASE ";
			foreach ($portalModulesInfo as $tabId => $moduleDetails) {
				$prefValue = $moduleDetails['prefValue'];
				$updateQuery .= " WHEN tabid = $tabId AND type= '$portaltype' THEN $prefValue ";

			}

		$updateQuery .= " WHEN prefkey = ? THEN $privileges ";
		$updateQuery .= " WHEN prefkey = ? THEN $defaultAssignee ";
		$updateQuery .= " ELSE prefvalue END";

		$db->pquery($updateQuery, array('userid', 'defaultassignee'));

		//Update the sequence of every module in Customer portal
		$updateSequenceQuery = "UPDATE vtiger_customerportal_tabs SET visible = CASE ";

		foreach ($portalModulesInfo as $tabId => $moduleDetails) {
			$visible = $moduleDetails['visible'];
			$updateSequenceQuery .= " WHEN tabid = $tabId THEN $visible ";
		}
			$updateSequenceQuery .= " END, sequence = CASE ";
			foreach ($portalModulesInfo as $tabId => $moduleDetails) {
				$sequence = $moduleDetails['sequence'];
				$updateSequenceQuery .= " WHEN tabid = $tabId THEN $sequence ";
			}
			$updateSequenceQuery .= "END WHERE type='$portaltype'";

		$db->pquery($updateSequenceQuery, array());
	}

	
}
