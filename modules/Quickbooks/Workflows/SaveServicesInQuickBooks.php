<?php
//error_reporting(E_ALL);
//ini_set('display_errors', 1);
function createServicesInQuickbooks($entity){
	//echo '<pre>';
	file_put_contents('stptest_s.txt' , print_r($entity,true) ) ; 
	require_once  'quickbooks/config.php';
	require_once 'quickbooks/views/header.tpl.php';	 
	if(isset($Context)){
	
		global $adb;
		$vtiger_data = array();
		$vtiger_data = $entity->data;
		(array)$vtiger_data;	
		
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

		
		// fields maping
		$fmq  = "select qf.qb_field_name, qf.vtiger_field,f.fieldname from quickbooks_fields qf  left join vtiger_field f on f.fieldlabel = qf.vtiger_field where f.tabid = 31 and qf.module='Services' ";
		$fmData = $adb->query($fmq);		 
		 while($qb_field_data = $adb->fetch_row($fmData)){			 
			$fields_data[$qb_field_data['qb_field_name']] = $qb_field_data['fieldname'];
		}
		//end
		
		$Item->setName($vtiger_data[$fields_data['Name']]);
		$Item->setFullyQualifiedName($vtiger_data[$fields_data['Name']]);

		$Item->setUnitPrice($vtiger_data[$fields_data['Price']]);
		$Item->setIncomeAccountRef('79');
		$Item->setIncomeAccountRef_name('Service');
		$Item->setExpenseAccountRef('80');
		$Item->setExpenseAccountRef_name('Service');
		$Item->setAssetAccountRef('81');
		$Item->setAssetAccountRef_name('Service Asset');
		
		$Item->setDescription($vtiger_data[$fields_data['Description']]);
		$Item->setType('Service');
		//$Item->setQtyOnHand(round($vtiger_data['qtyinstock']));
		//$Item->setTrackQtyOnHand(true);
		$Item->setInvStartDate($vtiger_data[$fields_data['Inventory Start Date']]);
		
		if($quickbook_id != ''){
			//Existing product
			if($resp = $ItemService->update($Context, $realm, $Item->getId(), $Item)){
				//print('Our new Item ID is: [' . $resp . ']'); 
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
				$sq = "UPDATE `vtiger_service` SET `quickbook_id`= $qb_id  WHERE  serviceid = $vtiger_id ";
				$adb->query($sq); 
			}
			else
			{
				//print($ItemService->lastError($Context));die;
			}
		}
	}
	
}

?>