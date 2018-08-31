<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Userlist_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/Userlist.tpl';
	}
	/**
	 * Function to get the Display Value, for the current field type with given DB Insert Value
	 * @param <Object> $value
	 * @return <Object>
	 */
	/*public function getDisplayValue($value) {
		if (self::getOwnerType($value) === 'User') {
			$userModel = Users_Record_Model::getCleanInstance('Users');
			$userModel->set('id', $value);
			$detailViewUrl = $userModel->getDetailViewUrl();
            $currentUser = Users_Record_Model::getCurrentUserModel();
            if(!$currentUser->isAdminUser()){
                return getOwnerName($value);
            }
		} else {
          
		}
		return "<a href=" .$detailViewUrl. ">" .getOwnerName($value). "</a>";
	}*/

	/**
	 * Function to get Display value for RelatedList
	 * @param <String> $value
	 * @return <String>
	 */
	//public function getRelatedListDisplayValue($value) {
		//returngetOwnerName($value);
	//}

	/**
	 * Function to know owner is either User or Group
	 * @param <Integer> userId/GroupId
	 * @return <String> User/Group
	 */
public function getDisplayValue($value) {
	global $adb;
	if($value != ''){
		$usquery = 'select concat(first_name," ",last_name) as last_name from vtiger_users where user_name = "'.$value.'"';
		$result = $adb->query($usquery);
		$r= $adb->fetch_array($result);
		$prjusername = $r["last_name"];
		return $prjusername;
	}else{
		return '';
	}
		
	}
   
}
