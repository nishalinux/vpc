<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ************************************************************************************/

class ProjectTask_Field_Model extends Vtiger_Field_Model {

	public function isAjaxEditable() {
		$ajaxRestrictedFields = array('4','72','515','514','537','538','545','546','516','540','19','12','175');
		if(!$this->isEditable() || in_array($this->get('uitype'), $ajaxRestrictedFields)) {
			return false;
		}
		return true;
	}
}