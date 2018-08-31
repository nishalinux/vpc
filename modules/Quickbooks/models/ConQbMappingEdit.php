<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Quickbooks_ConQbMappingEdit_View extends Vtiger_Index_View {
	
	public function process(Vtiger_Request $request) {
		$moduleName = 'Quickbooks';
		
		$viewer = $this->getViewer($request);
		$viewer->assign('CONFIELDNAME',$fieldName);
		
		$viewer->view('ContactMapping.tpl', $moduleName);
	}
	
	public function getFieldsName {
		$db = PearDatabase::getInstance();
		
		$query = "SELECT field_label from vtiger_field where tabid = 4";
		$result = $db->query($query);
		$numRows = $db->num_rows($result);
		
		$fieldName = array();
		for ($i=0; $i<$numOfRows; $i++) {
				$fieldName[] = $db->query_result($result, $i, 'field_label');
		}
		return $fieldName;
	}
	
	
}
