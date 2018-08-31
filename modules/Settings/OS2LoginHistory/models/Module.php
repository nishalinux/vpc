<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/*
 * Settings Module Model Class
 */
class Settings_OS2LoginHistory_Module_Model extends Settings_Vtiger_Module_Model {

	var $baseTable = 'vtiger_loginhistory';
	var $baseIndex = 'login_id';
	var $listFields = Array(
			'user_name'=> 'LBL_USER_NAME',
			'user_ip'=> 'LBL_USER_IP_ADDRESS', 
			'login_time' => 'LBL_LOGIN_TIME',
		    'logout_time' => 'LBL_LOGGED_OUT_TIME', 
			'status' => 'LBL_STATUS'
		);

	var $name = 'OS2LoginHistory';
	/**
	 * Function to get the url for default view of the module
	 * @return <string> - url
	 */
	public function getDefaultUrl() {
		return 'index.php?module=OS2LoginHistory&parent=Settings&view=List';
	}

	/**
     * Funxtion to identify if the module supports quick search or not
     */
    public function isQuickSearchEnabled() {
        return true;
    }

    //added by jyothi for login++
		public static function getPicklistSupportedModules() {
		$adb = PearDatabase::getInstance();

		$query = 'SELECT distinct vtiger_tab.tablabel, vtiger_tab.name as tabname
                  FROM vtiger_tab
                        inner join vtiger_field on vtiger_tab.tabid=vtiger_field.tabid
                  WHERE uitype IN (15,33,16) and vtiger_field.tabid NOT IN (29,10)  and vtiger_tab.presence != 1 and vtiger_field.presence in (0,2)
                  ORDER BY vtiger_tab.tabid ASC';
		// END

		$result = $adb->pquery($query, array());


		while($row = $adb->fetch_array($result)) {
			$modules[$row['tablabel']] = $row['tabname'];
		}
		ksort($modules);
		
        $modulesModelsList = array();
        foreach($modules as $moduleLabel => $moduleName) {
            $instance = new Vtiger_Module_Model();
            $instance->name = $moduleName;
            $instance->label = $moduleLabel;
            $modulesModelsList[] = $instance;
        }


        return $modulesModelsList;
    }

    //ended here
}
