<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ACMPR_Module_Model extends Settings_Vtiger_Module_Model {

	var $name = 'ACMPR';
	/**
	 * Function to get list of portal modules
	 * @return <Array> list of portal modules <Vtiger_Module_Model>
	 */
	public function getGridInfo() {
			$db = PearDatabase::getInstance();
		
			$data = "SELECT * FROM vtigress_acmpr_settings ORDER BY vtigress_acmpr_settings.sequence ASC";
			$viewname_result = $db->pquery($data, array());
			$griddata=array();
			while($row = $db->fetch_array($viewname_result)){ 
				 $griddata[]= $row;
			}
			return $griddata;
	}
	
	public function getActivitiesInfo(){
		$db = PearDatabase::getInstance();
		$data = "SELECT * FROM vtigress_acmpr_activities_settings";
		$viewname_result = $db->pquery($data, array());
		$griddata=array();
		$subarr = array();
		while($row = $db->fetch_array($viewname_result)){ 
			 $subarr = explode(" |##| " ,$row['substances']);
			 $row['substances'] = $subarr;
			 $row['substancesdisplay'] = implode(",",$subarr);
			 $griddata[]= $row;
		}
		return $griddata;
	}

	/**
	 * Function to save the details of Portal modules
	 */
	public function save() {
		$db = PearDatabase::getInstance();

		
		//$db->pquery($updateSequenceQuery, array());
	}


}
