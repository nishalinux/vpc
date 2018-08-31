<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_ProcessFlow_ProcessFlow_Model extends Settings_Vtiger_Module_Model{

    
	var $email ='';
	var $password = '';
	var $ubi = '';
	var $name = 'ProcessFlow';
    public function getId() {
        return $this->get('id');
    }
	/**
	 * Function to get the instance of Settings module model
	 * @return Settings_Vtiger_Module_Model instance
	 */
	public static function getInstance($name='Settings:ProcessFlow') {
		$modelClassName = 'Settings_ProcessFlow_ProcessFlow_Model'; 
		return new $modelClassName();
	}
	 
     

    public function save() {
        $db = PearDatabase::getInstance();
		 
         
        //$db->pquery($query,$params);
        return true;
    }

    public static function getInstancePhylosDetails() {
        $db = PearDatabase::getInstance();
        $query = 'SELECT * FROM vtiger_processmanager_list';
        $params = array();
        $result = $db->pquery($query,$params);
        $rowData = '';
        if($db->num_rows($result) > 0 ){
            $rowData = $db->query_result_rowdata($result,0);
		}
        return $rowData;
    }

}