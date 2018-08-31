<?php

class PickingSlip_Detail_View extends Inventory_Detail_View {
	
	/**
	 * Function to get Ajax is enabled or not
	 * @param Vtiger_Record_Model record model
	 * @return <boolean> true/false
	 */
	function isAjaxEnabled($recordModel) {
		return false;
	}

}
