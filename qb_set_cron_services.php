<?php

ini_set("display_errors", "1");
error_reporting(E_ALL);

require_once 'config.inc.php';
require_once  'modules/Emails/mail.php';
require_once  'include/utils/utils.php';
require_once  'includes/runtime/BaseModel.php';
require_once  'includes/runtime/Globals.php';
require_once  'includes/Loader.php';
require_once  'includes/http/Request.php';
require_once 'modules/Vtiger/models/Record.php';
require_once 'modules/Users/models/Record.php';
require_once 'includes/runtime/LanguageHandler.php';
require_once 'include/Webservices/Create.php'; 
require_once 'include/Webservices/Retrieve.php';
require_once 'modules/Users/Users.php';
try {
        $user = new Users(); 
        $current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
		global $adb, $current_user;
		$query = "SELECT vs.serviceid FROM vtiger_servicecf vs left join vtiger_crmentity vcm on vs.serviceid = vcm.crmid where vcm.deleted = 0 and vs.quickbook_id ='' ";
		$records = $adb->query($query); 
		$products_ids_data = $adb->num_rows($records);
		if($products_ids_data > 0){
			
			$qb_create = $qb_update = 0;
			while($resultrow = $adb->fetch_array($records)) { 
				$serviceid = $resultrow['serviceid']; 
				$wsid = vtws_getWebserviceEntityId('Services', $serviceid); // Module_Webservice_ID x CRM_ID
				$vtiger_data = vtws_retrieve($wsid, $current_user);
				
				require_once  'quickbooks/config.php';
				require_once 'quickbooks/views/header.tpl.php';	 
				if(isset($Context)){ 
				
					$id = $vtiger_data['id'];
					$id = explode('x',$id);	 
					$id = $id[1]; 
					
					//check create/update
					$quickbook_id = $vtiger_data['quickbook_id'];
					$ItemService = new QuickBooks_IPP_Service_Item();
					if($quickbook_id != ''){
						//Existing product
						//Get the existing product 
						$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Id = '$quickbook_id' ");
						$Item = $items[0];
					}else{
						//new product
						$Item = new QuickBooks_IPP_Object_Item();
					}

					$Item->setName($vtiger_data['servicename']);
					$Item->setFullyQualifiedName($vtiger_data['servicename']);

					$Item->setUnitPrice($vtiger_data['unit_price']);
					$Item->setIncomeAccountRef('79');
					$Item->setIncomeAccountRef_name('Service');
					$Item->setExpenseAccountRef('80');
					$Item->setExpenseAccountRef_name('Service');
					$Item->setAssetAccountRef('81');
					$Item->setAssetAccountRef_name('Service Asset');
					
					$Item->setDescription($vtiger_data['description']);
					$Item->setType('Service');
					//$Item->setQtyOnHand(round($vtiger_data['qtyinstock']));
					//$Item->setTrackQtyOnHand(true);
					$Item->setInvStartDate($vtiger_data['sales_start_date']);
					
					if($quickbook_id != ''){
						//Existing product
						if($resp = $ItemService->update($Context, $realm, $Item->getId(), $Item)){
							//print('Our new Item ID is: [' . $resp . ']'); 
							$qb_update++;
						}else{
							//print($ItemService->lastError($Context));die;
						}
						
					}else{
						//new product		
						if ($resp = $ItemService->add($Context, $realm, $Item))
						{
							//print('Our new Item ID is: [' . $resp . ']');
							$vtiger_id = $id;
							$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
							$sq = "UPDATE `vtiger_servicecf` SET `quickbook_id`= $qb_id  WHERE  serviceid = $vtiger_id ";
							$adb->query($sq); $qb_create++;		
						}
						else
						{
							//print($ItemService->lastError($Context));die;
						}
					}
				}
				 
			}
			echo  $qb_create. ' Services Synced to Quickbooks.';
			 
		}else{
			echo '0 Services synced.'; 
		}
		
	
} catch (WebServiceException $ex) {
	//echo $ex->getMessage();
}
//error_reporting( E_ERROR  | E_PARSE); 
 



?>