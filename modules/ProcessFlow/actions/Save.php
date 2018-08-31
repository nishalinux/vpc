<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */

class ProcessFlow_Save_Action extends Vtiger_Save_Action {

	public function process(Vtiger_Request $request) {
		$_REQUEST['pf_assignee'] = implode(";",$_REQUEST['pf_assignee']);
		//$pf_assignee = $_REQUEST['pf_assignee'];
		//$request->set('pf_assignee',$pf_assignee);
		
		//echo '<pre>';print_r($request);
		//print_r($_REQUEST);die;	 
		parent::process($request);
	}
}
