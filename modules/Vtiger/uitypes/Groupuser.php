<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
require_once('modules/Vtiger/uitypes/Owner.php');
class Vtiger_Groupuser_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/Groupuser.tpl';
	}

	public function getDisplayValue($value) {
		//echo ($value);
       // if(is_array($value)){
            $value = explode(';', $value);
       // }
	//	return str_ireplace(' |##| ', ', ', $value);
	//print_r($value);
	for($i=0;$i<count($value);$i++){
		//echo $value[$i];
 	$names[]=Vtiger_Owner_UIType::getDisplayValue($value[$i]);
	}
	return $names;
	}
    
    public function getDBInsertValue($value) {
		if(is_array($value)){
            //$value = implode(' |##| ', $value);
            $value = implode(';', $value);
        }
        return $value;
	}
	public function getDetailViewTemplateName() {
		return 'uitypes/GroupuserDetailView.tpl';
	}
    
	/**
	 * Function to know owner is either User or Group
	 * @param <Integer> userId/GroupId
	 * @return <String> User/Group
	 */
	public static function getOwnerType($id) {
		$db = PearDatabase::getInstance();

		$result = $db->pquery('SELECT 1 FROM vtiger_users WHERE id = ?', array($id));
		if ($db->num_rows($result) > 0) {
			return 'User';
		}
		return 'Group';
	}
}