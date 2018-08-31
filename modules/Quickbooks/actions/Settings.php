<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Quickbooks_Settings_Action extends Vtiger_Action_Controller {
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule(); 
	}
	
	public function process(Vtiger_Request $request) {
		
		global $adb;		
		$adb = PearDatabase::getInstance();
		//$adb->setDebug(true);
		$cron_module = $request->get('cron_module');
		$mode = $request->get('mode');
		$status = $request->get('status');
		$response = new Vtiger_Response(); 
		$frequency = 1440;
		 
		switch ($mode) {
			case "get":		
			
					if($cron_module == 'Contacts'){						
						$handler_file = 'cron/modules/Quickbooks/qb_get_cron_contacts.service';
						$name = 'Get Quickbooks Contacts';
					}elseif($cron_module == 'Vendors'){
						$handler_file = 'cron/modules/Quickbooks/qb_get_cron_Vendors.service';
						$name = 'Get Quickbooks Vendors';
					}elseif($cron_module == 'Invoice'){
						$handler_file = 'cron/modules/Quickbooks/qb_get_cron_Invoice.service';
						$name = 'Get Quickbooks Invoice';
					}elseif($cron_module == 'items'){
						$handler_file = 'cron/modules/Quickbooks/qb_get_cron_products.service';
						$name = 'Get Quickbooks products / Services';
					}
					
				break;
			case "set":
				
				if($cron_module == 'Contacts'){						
					$handler_file = 'cron/modules/Quickbooks/qb_set_cron_contacts.service';
					$name = 'Set Quickbooks Contacts';
				}elseif($cron_module == 'Vendors'){
					$handler_file = 'cron/modules/Quickbooks/qb_set_cron_Vendors.service';
					$name = 'Set Quickbooks Vendors';
				}elseif($cron_module == 'Invoice'){
					$handler_file = 'cron/modules/Quickbooks/qb_set_cron_Invoice.service';
					$name = 'Set Quickbooks Invoice';
				}elseif($cron_module == 'services'){
					$handler_file = 'cron/modules/Quickbooks/qb_set_cron_services.service';
					$name = 'Set Quickbooks Services';
				}elseif($cron_module == 'products'){
					$handler_file = 'cron/modules/Quickbooks/qb_set_cron_products.service';
					$name = 'Set Quickbooks Products';
				} 
				break;
				
			 
			
			default:
				//$response->setError($e->getCode(), "Please study the errorcode is ".$e->getCode());
				//$response->emit();
				break;
		} 
			$query = "delete from `vtiger_cron_task` WHERE handler_file = ?";
			$adb->pquery($query,array($handler_file));	
			$result = " Cron Deleted for <b> $mode Quickbooks $cron_module. </b>";
			
			if($status == 'add'){
				$comments = "Recommended frequency for $cron_module is 1440 mins";
				$query = "INSERT INTO vtiger_cron_task (id, name, handler_file, frequency, laststart, lastend, status, module, sequence, description) VALUES ((select max(a.id)+1 from vtiger_cron_task a), ?, ?, ?, NULL, NULL, '1', 'Quickbooks', (select max(b.sequence)+1 from vtiger_cron_task b), ?)";
				$adb->pquery($query,array($name,$handler_file,$frequency,$comments)); 
				$result = " Cron Added  for <b>$mode Quickbooks $cron_module. </b>";
			}  
		
		$responseData = array("message"=>$result, 'success'=>true);
		$response->setResult($responseData);
		$response->emit();
	}
		
}