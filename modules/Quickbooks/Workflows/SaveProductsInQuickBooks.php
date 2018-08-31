<?php
// error_reporting(E_ALL);
//ini_set('display_errors', 1);
function createProductsInQuickbooks($entity){
 
	file_put_contents('stptest_p.txt' , print_r($entity,true) ) ; 
	require_once  'quickbooks/config.php';
	require_once 'quickbooks/views/header.tpl.php';	 
	global $adb;
	if(isset($Context)){
		
		$vtiger_data = array();
		$vtiger_data = $entity->data;
		(array)$vtiger_data;	
		
		$id = $vtiger_data['id'];
		$id = explode('x',$id);	 
		$id = $id[1]; 
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
		$fmq  = "select qf.qb_field_name, qf.vtiger_field,f.fieldname from quickbooks_fields qf  left join vtiger_field f on f.fieldlabel = qf.vtiger_field where f.tabid = 14 and qf.module='Products' ";
		$fmData = $adb->query($fmq);		 
		while($qb_field_data = $adb->fetch_row($fmData)){			 
			$fields_data[$qb_field_data['qb_field_name']] = $qb_field_data['fieldname'];
		}
		
		$Item->setName($vtiger_data[$fields_data['Name']]);
		$Item->setFullyQualifiedName($vtiger_data[$fields_data['Name']]);
		$Item->setUnitPrice($vtiger_data[$fields_data['Price']]);
		$Item->setIncomeAccountRef('79');
		$Item->setIncomeAccountRef_name(' Sales of Product Income');
		$Item->setExpenseAccountRef('80');
		$Item->setExpenseAccountRef_name('Cost of Goods Sold');
		$Item->setAssetAccountRef('81');
		$Item->setAssetAccountRef_name('Inventory Asset');
		
		$Item->setDescription($vtiger_data[$fields_data['Description']]);
		$Item->setType('Inventory');
		$Item->setQtyOnHand(round($vtiger_data[$fields_data['Qty in Stock']]));
		$Item->setTrackQtyOnHand(true);
		$Item->setInvStartDate($vtiger_data[$fields_data['Inventory Start Date']]);
		
		if($quickbook_id != ''){
			//Existing product
			if($resp = $ItemService->update($Context, $realm, $Item->getId(), $Item)){
				//print('Our new Item ID is: [' . $resp . ']'); 
			}else{
				print($ItemService->lastError($Context));die;
			}
			
		}else{
			//new product		
			if ($resp = $ItemService->add($Context, $realm, $Item))
			{
				//print('Our new Item ID is: [' . $resp . ']');
				$vtiger_id = $id;
				$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
				$sq = "UPDATE `vtiger_products` SET `quickbook_id`= $qb_id  WHERE  productid = $vtiger_id ";
				$adb->query($sq); 
			}
			else
			{
				print($ItemService->lastError($Context));die;
			}
		}
	
	}
}

?>