<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ACMPR_Measurement_UIType extends Vtiger_Base_UIType {
	public function getTemplateName() {
		return 'uitypes/Measurement.tpl';
	}
	public function getDisplayValue($value) {
		$FIELD_NAME = $this->get('field_name');
		return $value." ".ACMPR_Field_Model::getMeasurement($FIELD_NAME);	
	}
}