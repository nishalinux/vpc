<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_CustomerPortal_PortalType_Action extends Settings_Vtiger_Basic_Action{

	public function process(Vtiger_Request $request) {
		global $adb;
		$adb = PearDatabase::getInstance();
		$portal_type = $request->get('portaltype');
		$response = new Vtiger_Response();

		 $List = array();
		$query = "SELECT vtiger_customerportal_tabs.*,vtiger_customerportal_prefs.prefvalue, vtiger_tab.tablabel FROM vtiger_customerportal_tabs INNER JOIN vtiger_customerportal_prefs ON vtiger_customerportal_prefs.type=vtiger_customerportal_tabs.type AND  vtiger_customerportal_prefs.tabid=vtiger_customerportal_tabs.tabid INNER JOIN vtiger_tab ON vtiger_customerportal_tabs.tabid = vtiger_tab.tabid AND vtiger_tab.presence = 0 WHERE vtiger_customerportal_tabs.type=? AND vtiger_customerportal_prefs.type=? ORDER BY vtiger_customerportal_tabs.sequence";
			
		$result = $adb->pquery($query,array($portal_type,$portal_type)); 
		$norows = $adb->num_rows($result);					
		while( $row = $adb->fetchByAssoc($result)){
			$List[] = $row;
		}	
				   
		$response->setResult($List);
		$response->emit();		
		
	}	
}
