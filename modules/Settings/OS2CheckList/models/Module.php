<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_Module_Model extends Settings_Vtiger_Module_Model{
    
    const tableName = 'vtiger_checklistdetails';
  
	var $listFields = array('checklistname' => 'CheckList Name', 'modulename' => 'Module Name', 'createdtime' => 'Created Time', 'status' => 'Status');
	var $name = 'OS2CheckList';
    
    public function isPagingSupported() {
        return false;
    }
    
    public function getCreateRecordUrl() {
        return "javascript:Settings_OS2CheckList_Js.triggerAdd(event)";
    }
    
    public function getBaseTable() {
		return self::tableName;
	}
    
    public static function delete($recordId) {
        $db = PearDatabase::getInstance();
        $query = 'UPDATE '.self::tableName.' SET deleted=1 WHERE checklistid=?';
        $params = array($recordId);
        $db->pquery($query, $params);
    }
}