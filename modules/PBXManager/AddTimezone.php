<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

function AddTimezone($entityData){
	//global $log;
	$adb = PearDatabase::getInstance();
	$moduleName = $entityData->getModuleName();
	$entity_id = vtws_getIdComponents($entityData->getId());
 	$entity_id = $entity_id[1];
	$currentUserModel = Users_Record_Model::getCurrentUserModel();
	require_once("modules/PBXManager/PBXManager.php");
	//$currentUserModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
	$timezone = $currentUserModel->get('time_zone');
	
	$pb = "SELECT MAX(pbxmanagerid) AS pbid FROM vtiger_pbxmanager";
    $pbr = $adb->pquery($pb, array());
    $pbid = $adb->query_result($pbr, 0, "pbid");

	$updateTZ = "UPDATE vtiger_pbxmanagercf SET cf_1077 = ? WHERE pbxmanagerid =?";
	$adb->pquery($updateTZ, array($timezone, $pbid));	
}	
?>
