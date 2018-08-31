<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ACMPR_Radio_UIType extends Vtiger_Base_UIType {

	/**
	 * Function to get the Template name for the current UI Type object
	 * @return <String> - Template Name
	 */
	public function getTemplateName() {
		return 'uitypes/Radio.tpl';
	}
	
	
	public function getDisplayValue($value) {
		if($value == 1 || $value == '1' || strtolower($value) == 'on') {
			return 'Attached';
		}else if(($value == 0 || $value == '0') && $value != ''){
			return 'To Followed';
		}else{
			return '';
		}
		
	}
    public function getActualVal($value) {
		return $value;
		
	}
	 public function getListSearchTemplateName() {
        return 'uitypes/RadioFieldSearchView.tpl';
    }
    
    
}