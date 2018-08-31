<?php
function createVendorsInQuickbooks($entity){

error_reporting(E_ALL);
ini_set('display_errors', 1);

	file_put_contents('stptest_v.txt' , print_r($entity,true) ) ; 
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
		$VendorService = new QuickBooks_IPP_Service_Vendor();
		if($quickbook_id != ''){
			//Existing Vendor
			//Get the existing Vendor 
			$vendors = $VendorService->query($Context, $realm, "SELECT * FROM Vendor WHERE Id = '$quickbook_id' ");
			$Vendor = $vendors[0];
		}else{
			//new Vendor
			$Vendor = new QuickBooks_IPP_Object_Vendor();
		}
		// fields maping
		$fmq  = "select qf.qb_field_name, qf.vtiger_field,f.fieldname from quickbooks_fields qf  left join vtiger_field f on f.fieldlabel = qf.vtiger_field where f.tabid = 18 and qf.module='Vendors' ";
		$fmData = $adb->query($fmq);		 
		 while($qb_field_data = $adb->fetch_row($fmData)){			 
			$fields_data[$qb_field_data['qb_field_name']] = $qb_field_data['fieldname'];
		}
		//end
		
		//$Vendor->setTitle('Mr');
		$Vendor->setGivenName($vtiger_data[$fields_data['Name']]); 
		$Vendor->setDisplayName($vtiger_data[$fields_data['Name']]);
		
		// Email
		if($vtiger_data[$fields_data['Email']] != ''){
			$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
			$PrimaryEmailAddr->setAddress($vtiger_data[$fields_data['Email']]);
			$Vendor->setPrimaryEmailAddr($PrimaryEmailAddr);
		}
		// Phone #
		if($vtiger_data[$fields_data['Phone']] != ''){
			$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
			$PrimaryPhone->setFreeFormNumber($vtiger_data[$fields_data['Phone']]);
			$Vendor->setPrimaryPhone($PrimaryPhone);
		}
		// Mobile #
		if($vtiger_data[$fields_data['Phone']] != ''){
			$Mobile = new QuickBooks_IPP_Object_Mobile();
			$Mobile->setFreeFormNumber($vtiger_data[$fields_data['Phone']]);
			$Vendor->setMobile($Mobile);
		}
		
		
		if($quickbook_id != ''){
			//Existing Vendor
			if($resp = $VendorService->update($Context, $realm, $Vendor->getId(), $Vendor)){
				print('Vendor ID is: [' . $resp . ']'); 
			}else{
				print($VendorService->lastError($Context));die;
			}
			
		}else{

			if ($resp = $VendorService->add($Context, $realm, $Vendor))
			{
				//print('Our new Vendor ID is: [' . $resp . ']');
				global $adb;
				$vtiger_id = $id;
				$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
				$sq = "UPDATE `vtiger_vendor` SET `quickbook_id`= $qb_id  WHERE  vendorid = $vtiger_id ";
				$adb->query($sq); 
			}
			else
			{
				print($VendorService->lastError($Context));
			}
		}
	}
}

?>