<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

function createInvoiceInQuickbooks($entity){

	echo '<pre>';
	file_put_contents('stptest_I.txt' , print_r($entity->data,true) ) ; 
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
		
		//check create/update
		$quickbook_id = $vtiger_data['quickbook_id'];
		$InvoiceService = new QuickBooks_IPP_Service_Invoice();
		if($quickbook_id != ''){
			//Existing invoice
			//Get the existing invoice 
			$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice  WHERE Id = '$quickbook_id' ");
			$Invoice = $invoices[0];
		}else{
			//new invoice
			$Invoice = new QuickBooks_IPP_Object_Invoice();
		} 
		
		// fields maping
		$fmq  = "select qf.qb_field_name, qf.vtiger_field,f.fieldname from quickbooks_fields qf  left join vtiger_field f on f.fieldlabel = qf.vtiger_field where f.tabid = 23 and qf.module='Invoice' ";
		$fmData = $adb->query($fmq);		 
		 while($qb_field_data = $adb->fetch_row($fmData)){			 
			$fields_data[$qb_field_data['qb_field_name']] = $qb_field_data['fieldname'];
		}
		//end
		
		
		$Invoice->setDocNumber($vtiger_data[$fields_data['Invoice No']]);
		$Invoice->setTxnDate($vtiger_data[$fields_data['Invoice Date']]);
		
		if(empty($vtiger_data[$fields_data['Customer Name']])){
			$account_id = $vtiger_data['account_id'];
			$account_id = explode('x',$account_id);	 
			$account_id = $account_id[1];
			 
			$adata = $adb->query("SELECT quickbook_customer_id FROM `vtiger_account` where accountid = '$account_id'");
			$adata = $adb->fetch_array($adata);		 
			$Invoice->setCustomerRef($adata['quickbook_customer_id']);
			
		}else{
			$cid = $vtiger_data[$fields_data['Customer Name']];
			$cid = explode('x',$cid);	 
			$cid = $cid[1];
			 
			$cdata = $adb->query("SELECT quickbook_id FROM `vtiger_contactdetails` where contactid = '$cid'");
			$cdata = $adb->fetch_array($cdata);		 
			$Invoice->setCustomerRef($cdata['quickbook_id']);
		}
		 
		
		$totalTaxPrice = 0;
		$TxnTaxDetail = new QuickBooks_IPP_Object_TxnTaxDetail();
		foreach($vtiger_data['LineItems'] as $key => $item)
		{
			$Line = new QuickBooks_IPP_Object_Line();
			$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();		
			$item_id = $item['productid'];
			$item_id = explode('x',$item_id);	 
			$item_id = $item_id[1]; 
			//get type of item (product/services)
			$sq = "SELECT setype FROM `vtiger_crmentity` where crmid=$item_id";
			$item_type = $adb->query($sq);
			$item_type = $adb->fetch_array($item_type);			 
			$setype = $item_type['setype'];
				if($setype == 'Services'){
					$q = "SELECT servicename as itemname,quickbook_id FROM `vtiger_service` where serviceid = $item_id";
				}else{
					$q = "SELECT productname as itemname,quickbook_id FROM `vtiger_products` where productid = $item_id";
				}
			$itemdata = $adb->query($q);
			$itemdata = $adb->fetch_array($itemdata);	
			
			$SalesItemLineDetail->setItemRef($itemdata['quickbook_id']);
			$SalesItemLineDetail->setItemRef_name($itemdata['itemname']);
			$SalesItemLineDetail->setUnitPrice($item['listprice']);
			$SalesItemLineDetail->setQty($item['quantity']);
			
			$Line->addSalesItemLineDetail($SalesItemLineDetail);
			//$tax = $item['tax1'] +  $item['tax2'] +  $item['tax3'];
			$tax = $taxPrice = 0;
			for($i=1;$i<13;$i++){
				if(isset($item['tax'.$i])){
					$tax += $item['tax'.$i];
				}
			}
			
			//$Line->setAmount($item['listprice'] * $item['quantity'] * ($tax/100));
			
			$taxPrice = ($item['listprice'] * $item['quantity'] * $tax)/100;
			 $totalTaxPrice += $taxPrice;
			 
			$Line->setAmount($item['listprice'] * $item['quantity'] );
			$Line->setDescription($item['description']);
			$Line->setDetailType('SalesItemLineDetail');
			$Invoice->addLine($Line);
			
			$TaxLine = new QuickBooks_IPP_Object_TaxLine();
			$TaxLine->setAmount($taxPrice);
			  
			$TaxLineDetail = new QuickBooks_IPP_Object_TaxLineDetail();
			$TaxLineDetail->setNetAmountTaxable($item['listprice'] * $item['quantity']);
			$TaxLineDetail->setTaxPercent($tax);
			$TaxLine->setTaxLineDetail($TaxLineDetail);
			$TxnTaxDetail->addTotalTax($TaxLine);
		} 
		
		$TxnTaxDetail->setTotalTax($totalTaxPrice); 
		
		$Invoice->setTxnTaxDetail($TaxLineDetail);

		
		if($quickbook_id != ''){
			//update
			if($resp = $InvoiceService->update($Context, $realm, $Invoice->getId(), $Invoice)){
				print('Our new Item ID is: [' . $resp . ']'); 
			}else{
				print($InvoiceService->lastError($Context));die;
			} 
			
		}else{
			
			//create
			if ($resp = $InvoiceService->add($Context, $realm, $Invoice))
			{
				print('Our new Invoice ID is: [' . $resp . ']');
				$vtiger_id = $id;
				$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
				$sq = "UPDATE `vtiger_invoice ` SET `quickbook_id`= $qb_id  WHERE  invoiceid = $vtiger_id ";
				$adb->query($sq); 
			}
			else
			{
				print($InvoiceService->lastError());die;
			}
			
		}	 
	}	
}

?>