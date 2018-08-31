<?php
function createContactInQuickbooks($entity){

	global $adb;
			 
	file_put_contents('stptest.txt' , print_r($entity->data,true) ) ;		
	require_once  'quickbooks/config.php';
	require_once 'quickbooks/views/header.tpl.php';	 
	if(isset($Context)){
		
		$vtiger_data = array();
		$vtiger_data = $entity->data;
		$vtiger_data = (array)$vtiger_data;
		$id = $vtiger_data['id'];
		$id = explode('x',$id);
		$id = $id[1];
		$CustomerService = new QuickBooks_IPP_Service_Customer();
		
		//update Qb Custmoer 
		$quickbook_id = $vtiger_data['quickbook_id'];
		if($quickbook_id != ''){
			$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '$quickbook_id' ");
			$Customer = $customers[0];		
		}
		else{
			$Customer = new QuickBooks_IPP_Object_Customer();
		}
		
		// fields maping
		$fmq  = "select qf.qb_field_name, qf.vtiger_field,f.fieldname from quickbooks_fields qf  left join vtiger_field f on f.fieldlabel = qf.vtiger_field where f.tabid = 4 and qf.module='Contacts' ";
		$fmData = $adb->query($fmq);		 
		 while($qb_field_data = $adb->fetch_row($fmData)){			 
			$fields_data[$qb_field_data['qb_field_name']] = $qb_field_data['fieldname'];
		}
		//end
		
		
		$Customer->setTitle($vtiger_data['salutationtype']);
		$Customer->setGivenName($vtiger_data[$fields_data['First Name']]);
		$Customer->setMiddleName($vtiger_data[$fields_data['Last Name']]);
		//$Customer->setFamilyName($vtiger_data['firstname']);
	$Customer->setDisplayName($vtiger_data['salutationtype'] .' '. $vtiger_data[$fields_data['First Name']] . ' '. $vtiger_data[$fields_data['Last Name']]);

		// Terms (e.g. Net 30, etc.)
		//$Customer->setSalesTermRef($id);
		
		$Customer->setActive(true);
		
		//covart company id to Name
		if($vtiger_data['account_id'] != ''){ 
			$cid = $vtiger_data['account_id'];
			$cid =  explode('x',$cid);	 
			$cid = $cid[1];	
			$q = 'SELECT accountname FROM `vtiger_account` where accountid = "'.$cid.'"';
			$records = $adb->query($q);
			$c_name = $adb->fetch_array($records);	
			$Customer->setCompanyName(html_entity_decode($c_name['accountname']));
		}
		// Phone #
		if($vtiger_data[$fields_data['Phone']] != ''){
			$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
			$PrimaryPhone->setFreeFormNumber($vtiger_data[$fields_data['Phone']]);
			$Customer->setPrimaryPhone($PrimaryPhone);
		}
		// Mobile #
		if($vtiger_data[$fields_data['Mobile']] != ''){
			$Mobile = new QuickBooks_IPP_Object_Mobile();
			$Mobile->setFreeFormNumber($vtiger_data[$fields_data['Mobile']]);
			$Customer->setMobile($Mobile);
		}

		// Fax #
		if($vtiger_data[$fields_data['Fax']] != '') { 
			$Fax = new QuickBooks_IPP_Object_Fax();
			$Fax->setFreeFormNumber($vtiger_data[$fields_data['Fax']]);
			$Customer->setFax($Fax);
		}
		// Bill address
		if($vtiger_data[$fields_data['Street']] != '' || $vtiger_data[$fields_data['City']] != '' || $vtiger_data[$fields_data['Country']] != ''  || $vtiger_data[$fields_data['Zip']] != '' ){
			$BillAddr = new QuickBooks_IPP_Object_BillAddr();
			if($vtiger_data[$fields_data['Street']] != ''){ $BillAddr->setLine1($vtiger_data[$fields_data['Street']]); }		
			//$BillAddr->setLine2($vtiger_data['mailingstreet']);
			if($vtiger_data[$fields_data['City']] != ''){ $BillAddr->setCity($vtiger_data[$fields_data['City']] . ', ' . $vtiger_data[$fields_data['State']]); }
			if($vtiger_data[$fields_data['Country']] != '' ) { $BillAddr->setCountry($vtiger_data[$fields_data['Country']]); }
			//$BillAddr->setCountrySubDivisionCode($vtiger_data['mailingcountry']);
			if($vtiger_data[$fields_data['Zip']] != '' ) { $BillAddr->setPostalCode($vtiger_data[$fields_data['Zip']]);}
			$Customer->setBillAddr($BillAddr);
		}

		// Email
		if($vtiger_data[$fields_data['Email']] != ''){ 
			$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
			$PrimaryEmailAddr->setAddress($vtiger_data[$fields_data['Email']]);
			$Customer->setPrimaryEmailAddr($PrimaryEmailAddr);
		}
	 
		if($quickbook_id != ''){
			
			if($CustomerService->update($Context, $realm, $Customer->getId(), $Customer)){
				//print('Our new customer ID is: [' . $resp . '] (name "' . $Customer->getDisplayName() . '")');
			}else{
				//print($CustomerService->lastError($Context));
				//die;
			}
			
		} else	{ 
		
			if ($resp = $CustomerService->add($Context, $realm, $Customer))
			{
				print('Our new customer ID is: [' . $resp . '] (name "' . $Customer->getDisplayName() . '")');
				$vtiger_id = $id;
				$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
				$sq = "UPDATE `vtiger_contactdetails` SET `quickbook_id`= $qb_id  WHERE  contactid = $vtiger_id ";
				$adb->query($sq);
				
			}
			else
			{
				//print($CustomerService->lastError($Context));
				//die;
			}
		}
		require_once 'quickbooks/views/footer.tpl.php';
		//die;
	}
}

?>