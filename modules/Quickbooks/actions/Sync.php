<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
require_once 'include/Webservices/Create.php';
require_once 'include/Webservices/Retrieve.php';
class Quickbooks_Sync_Action extends Vtiger_Action_Controller {
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule(); 
	}
	
	public function process(Vtiger_Request $request) {
		
		global $adb;		
		$adb = PearDatabase::getInstance();
		//$adb->setDebug(true);
		$sync_module = $request->get('sync_module');
        $type = $request->get('type'); 
		$response = new Vtiger_Response();	 
		switch ($type) {
			case "get":
                if($sync_module == 'Contacts'){						
                    $insert_count = $this->getContacts();
                    if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>"$insert_count Contacts Saved.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
                }elseif($sync_module == 'Vendors'){
                    $insert_count = $this->getVendors();
                    if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>"$insert_count Vendors Saved.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
                }elseif($sync_module == 'Invoice'){
					$insert_count = $this->getInvoice();
					if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>"$insert_count Invoice Saved.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
                }elseif($sync_module == 'Products-Services'){

                    $insert_count = $this->getProductsServices(); 
                    if($insert_count['products'] > 0){
                        $this->insetHistory('Products',$type,$insert_count['products']);
                    }
                    if($insert_count['services'] > 0){
                        $this->insetHistory('Services',$type,$insert_count['services']);
					}
					$total = $insert_count['products'] +  $insert_count['services'];
                    $responseData = array("message"=>"$total Products/Services Saved.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
                }
					
				break;
			case "post":				
				if($sync_module == 'Contacts'){	                 
                    $insert_count = $this->postContacts();
                    if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>$insert_count.' '.$sync_module." Synced.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
				}elseif($sync_module == 'Vendors'){					
					$insert_count = $this->postVendors();
                    if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>$insert_count.' '.$sync_module." Synced.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
				}elseif($sync_module == 'Invoice'){
					$insert_count = $this->postInvoice();
					if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>"$insert_count Invoice Synced.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
				}elseif($sync_module == 'Services'){                    
                    $insert_count = $this->postServices();
                    if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>$insert_count.' '.$sync_module." Synced.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
				}elseif($sync_module == 'Products'){
                    $insert_count = $this->postProducts();
                    if($insert_count > 0){
                        $this->insetHistory($sync_module,$type,$insert_count);
                    }
                    $responseData = array("message"=>$insert_count.' '.$sync_module." Synced.", 'success'=>true);
                    $response->setResult($responseData);
                    $response->emit();
				} 
				break; 
			
			default:
				$response->setError($e->getCode(), "Please study the errorcode is ".$e->getCode());
				$response->emit();
				break;
		} 
         
    }

    #insert sync history 
    function insetHistory($sync_module,$type,$insert_count){
        global $adb;
        $q = "INSERT INTO quickbooks_sync_history (module, type, records, date) VALUES (?, ?, ?, ?)";
        $adb->pquery($q,array($sync_module,$type,$insert_count,date('Y-m-d H:i:s')));
    }

    #Get Contacts from Quickbooks and save to Vtiger
    function getContacts(){
        global $adb, $current_user;
        require_once 'quickbooks/config.php';       
        //require_once 'quickbooks/views/header.tpl.php';	
        // $user = new Users();
        // $current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());     
        $CustomerService = new QuickBooks_IPP_Service_Customer();       
        $customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer MAXRESULTS 100");
        $insert_count = 0;      
        foreach ($customers as $Customer)
        {        
            $BillAddr = new QuickBooks_IPP_Object($Customer);	 
            $b = $Customer->getBillAddr(); 
            $ShipAddr = $Customer->getShipAddr(); 
            $email = $Customer->getPrimaryEmailAddr();
            $PrimaryPhone = $Customer->getPrimaryPhone();
            $Mobile = $Customer->getMobile();
            $Fax = $Customer->getFax();
            $qb_id = QuickBooks_IPP_IDS::usableIDType($Customer->getId());
            $company_name = $Customer->getCompanyName();
            $WebAddr = $Customer->getWebAddr();
            
            $Company_data = array();
            
            $data = array(
                'assigned_user_id' => vtws_getWebserviceEntityId("Users", 1),                
                'firstname' => $Customer->getGivenName(),
                'lastname' => $Customer->getMiddleName() .' '. $Customer->getFamilyName(), 	 
                'quickbook_id' => $qb_id                
            ); 
            
            if($b != null){ 	
                $data['mailingcity'] = $b->getCity();
                $data['mailingstreet'] = $b->getLine1();
                $data['mailingcountry'] = $b->getCountry();
                $data['mailingstate'] = $b->getCountrySubDivisionCode();
                $data['mailingzip'] = $b->getPostalCode();
                
                $Company_data['bill_city'] = $b->getCity();
                $Company_data['bill_code'] =  $b->getPostalCode();
                $Company_data['bill_country'] =  $b->getCountry();
                $Company_data['bill_state'] =  $b->getCountrySubDivisionCode();
                $Company_data['bill_street'] =  $b->getLine1();				
            }
            
            if($ShipAddr != null){ 	 

                $Company_data['ship_city'] = $ShipAddr->getCity();
                $Company_data['ship_code'] =  $ShipAddr->getPostalCode();
                $Company_data['ship_country'] =  $ShipAddr->getCountry();
                $Company_data['ship_state'] = $ShipAddr->getCountrySubDivisionCode();
                $Company_data['ship_street'] =  $ShipAddr->getLine1();
            }            
            
            if($email != null){
                $data['email'] = $email->getAddress();
                $Company_data['email1'] = $email->getAddress();
            }
            
            if($PrimaryPhone != null){
                $data['phone'] = $PrimaryPhone->getFreeFormNumber();
                $Company_data['phone'] =  $PrimaryPhone->getFreeFormNumber();
            } 
            
            if($Mobile != null){
                $data['mobile'] = $Mobile->getFreeFormNumber();
                $Company_data['otherphone'] = $Mobile->getFreeFormNumber();
            }
            
            if($Fax != null){
                $data['fax'] = $Fax->getFreeFormNumber();
                $Company_data['fax'] = $Fax->getFreeFormNumber();
            }
            
            if($WebAddr != null){
                #$data['website'] = $WebAddr->getURI();
                $Company_data['website'] = $WebAddr->getURI();
            }
            
            if($Customer->getNotes()){
                $data['Notes'] = $Customer->getNotes();
                $Company_data['Notes'] = $Customer->getNotes();
            }
            
           #check company name 
            if(!empty(trim($company_name)))
            {	 
                $q = 'SELECT accountid FROM vtiger_account where quickbook_id = "'.$qb_id.'"';
                $records = $adb->query($q);
                $com_count = $adb->num_rows($records); 
                if($com_count == 0){
                   #insert company name to Organization name                     
                    $Company_data['assigned_user_id'] = vtws_getWebserviceEntityId("Users", 1);
                    $Company_data['accountname'] = $company_name;
                    $Company_data['quickbook_id'] =  $qb_id;				
                    $account_Data = vtws_create('Accounts', $Company_data, $current_user);
                    $id = $account_Data['id'];
                    $id = explode('x',$id);	 
                    $data['accountid'] = $id[1];		
                }else{
                    $c_id = $adb->fetch_array($records); 
                    $data['accountid'] = $c_id['accountid'];
                }			
            }
           
            
            #check record present or not 	
            $q = "SELECT * FROM vtiger_contactdetails where quickbook_id = ?";
            $records = $adb->pquery($q,array($qb_id));
            $com_count = $adb->num_rows($records); 
            if($com_count == 0) {
                #insert
                $ps = vtws_create('Contacts', $data, $current_user);
                $insert_count++;
            }else{
                #update
                
            } 
        }
        return $insert_count;
    }

    #sent Contacts from vtiger to Quickbooks
    function postContacts(){

        //$user = new Users();
        //$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
		global $adb, $current_user;
		$query = "SELECT vc.contactid FROM vtiger_contactdetails vc left join vtiger_crmentity vcm on vc.contactid = vcm.crmid where vcm.deleted = 0 and vc.quickbook_id ='' ";
		$records = $adb->query($query);
		$contact_ids_data = $adb->num_rows($records);
		if($contact_ids_data > 0){
			$qb_create = $qb_update = 0;
			while($resultrow = $adb->fetch_array($records)) {
				$contactid = $resultrow['contactid']; 
				$wsid = vtws_getWebserviceEntityId('Contacts', $contactid); // Module_Webservice_ID x CRM_ID
				$vtiger_data = vtws_retrieve($wsid, $current_user);				 
				include  'quickbooks/config.php';
				#include 'quickbooks/views/header.tpl.php';	 
				if(isset($Context)){ 					
					$id = $vtiger_data['id'];
					$id = explode('x',$id);
					$id = $id[1];
                    $CustomerService = new QuickBooks_IPP_Service_Customer();
                    					 
					#update Qb Custmoer 
					$quickbook_id = $vtiger_data['quickbook_id'];
					if($quickbook_id != ''){
						$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '$quickbook_id' ");
						$Customer = $customers[0];		
					}
					else{
						$Customer = new QuickBooks_IPP_Object_Customer();
					}
					$Customer->setTitle($vtiger_data['salutationtype']);
					$Customer->setGivenName($vtiger_data['firstname']);
					$Customer->setMiddleName($vtiger_data['lastname']);
					//$Customer->setFamilyName($vtiger_data['firstname']);
					$Customer->setDisplayName($vtiger_data['salutationtype'] .' '. $vtiger_data['firstname'] . ' '. $vtiger_data['lastname']);

					// Terms (e.g. Net 30, etc.)
					//$Customer->setSalesTermRef($id);
					
					$Customer->setActive(true);
					
					#covart company id to Name
					if($vtiger_data['account_id'] != ''){ 
						$cid = $vtiger_data['account_id'];
						$cid =  explode('x',$cid);	 
						$cid = $cid[1];	
						$q = 'SELECT accountname FROM vtiger_account where accountid = "'.$cid.'"';
						$records = $adb->query($q);
						$c_name = $adb->fetch_array($records);	
						$Customer->setCompanyName(html_entity_decode($c_name['accountname']));
					}
					#Phone 
					if($vtiger_data['phone'] != ''){
						$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
						$PrimaryPhone->setFreeFormNumber($vtiger_data['phone']);
						$Customer->setPrimaryPhone($PrimaryPhone);
					}
					#Mobile 
					if($vtiger_data['mobile'] != ''){
						$Mobile = new QuickBooks_IPP_Object_Mobile();
						$Mobile->setFreeFormNumber($vtiger_data['mobile']);
						$Customer->setMobile($Mobile);
					}

					# Fax 
					if($vtiger_data['fax'] != '') { 
						$Fax = new QuickBooks_IPP_Object_Fax();
						$Fax->setFreeFormNumber($vtiger_data['fax']);
						$Customer->setFax($Fax);
					}
					# Bill address
					if($vtiger_data['mailingstreet'] != '' || $vtiger_data['mailingcity'] != '' || $vtiger_data['mailingcountry'] != ''  || $vtiger_data['mailingzip'] != '' ){
						$BillAddr = new QuickBooks_IPP_Object_BillAddr();
						if($vtiger_data['mailingstreet'] != ''){ $BillAddr->setLine1($vtiger_data['mailingstreet']); }		
						//$BillAddr->setLine2($vtiger_data['mailingstreet']);
						if($vtiger_data['mailingcity'] != ''){ $BillAddr->setCity($vtiger_data['mailingcity'] . ', ' . $vtiger_data['mailingstate']); }
						if($vtiger_data['mailingcountry'] != '' ) { $BillAddr->setCountry($vtiger_data['mailingcountry']); }
						//$BillAddr->setCountrySubDivisionCode($vtiger_data['mailingcountry']);
						if($vtiger_data['mailingzip'] != '' ) { $BillAddr->setPostalCode($vtiger_data['mailingzip']);}
						$Customer->setBillAddr($BillAddr);
					}

					# Email
					if($vtiger_data['email'] != ''){ 
						$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
						$PrimaryEmailAddr->setAddress($vtiger_data['email']);
						$Customer->setPrimaryEmailAddr($PrimaryEmailAddr);
					}
					if($quickbook_id != ''){						
						if($CustomerService->update($Context, $realm, $Customer->getId(), $Customer)){
                            $qb_update++;
						}						
					} else	{ 					
						if ($resp = $CustomerService->add($Context, $realm, $Customer))
						{
							$vtiger_id = $id;
							$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
							$sq = "UPDATE vtiger_contactdetails SET quickbook_id= $qb_id  WHERE  contactid = $vtiger_id ";
							$adb->query($sq);
							$qb_create++;							
						} 
					}
					#require_once 'quickbooks/views/footer.tpl.php';					 
				} 
			}
            return $qb_create;
		}else{ 
            return 0;
		}
    }

    #get Products / Service 
    function getProductsServices(){ 

		global $adb, $current_user;
		#$adb->setDebug(true);
        $qb_products = $qb_servies = 0;    
        include_once  'quickbooks/config.php';     
        $ItemService = new QuickBooks_IPP_Service_Term();        
        //$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Metadata.LastUpdatedTime > '2013-01-01T14:50:22-08:00' ORDER BY Metadata.LastUpdatedTime ");
        $items = $ItemService->query($Context, $realm, "SELECT * FROM Item ORDER BY Metadata.LastUpdatedTime");        
        foreach ($items as $Item)
        {
            $qb_id = QuickBooks_IPP_IDS::usableIDType($Item->getId());            
            $type =  $Item->getType();
            $data = array();	
            $data['quickbook_id'] = $qb_id;
            $data['unit_price'] =  $Item->getUnitPrice();
            $data['discontinued'] =  1;
            $data['assigned_user_id'] =  vtws_getWebserviceEntityId("Users", 1); 
            
            $pq = 'SELECT * FROM vtiger_products where quickbook_id =  "'.$qb_id.'"';
            $precords = $adb->query($pq);
            $com_count_products = $adb->num_rows($precords);
            
            $sq = 'SELECT * FROM vtiger_service where quickbook_id =  "'.$qb_id.'"';
            $srecords = $adb->query($sq);
            $com_count_services = $adb->num_rows($srecords); 
            
            if($com_count_products == 0 && $com_count_services == 0) {
                #insert	
                if($type == 'Service'){		
                    $data['servicename'] = $Item->getName();
                    $ps = vtws_create('Services', $data, $current_user);
                    $qb_servies++;
                }else{ 
                    $data['productname'] = $Item->getName();	
                    if($Item->getQtyOnHand()){ 
                        $data['qtyinstock'] =  $Item->getQtyOnHand();
                        $data['sales_start_date'] =  $Item->getInvStartDate();
                        $data['start_date'] =  $Item->getInvStartDate();                        
                    }
					$ps = vtws_create('Products', $data, $current_user);
					$qb_products++;
                }                        
            }else{
                #update
            }
        }
        return array('products'=>$qb_products,'services'=>$qb_servies);
    }


    function postProducts(){         
        global $adb, $current_user;       
		$query = "SELECT vp.productid FROM vtiger_products vp left join vtiger_crmentity vcm on vp.productid = vcm.crmid where vcm.deleted = 0 and vp.quickbook_id ='' ";
		$records = $adb->query($query); 
		$products_ids_data = $adb->num_rows($records);
		if($products_ids_data > 0){ 
			$qb_create = $qb_update = 0;
			while($resultrow = $adb->fetch_array($records)) { 
				$productid = $resultrow['productid']; 
				$wsid = vtws_getWebserviceEntityId('Products', $productid); // Module_Webservice_ID x CRM_ID
				$vtiger_data = vtws_retrieve($wsid, $current_user);
				
				require_once  'quickbooks/config.php';
				//require_once 'quickbooks/views/header.tpl.php';	 
			 
				if(isset($Context)){
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
						#new product
						$Item = new QuickBooks_IPP_Object_Item();
					}

					$Item->setName($vtiger_data['productname']);
					$Item->setFullyQualifiedName($vtiger_data['productname']);
					$Item->setUnitPrice($vtiger_data['unit_price']);
					$Item->setIncomeAccountRef('79');
					$Item->setIncomeAccountRef_name(' Sales of Product Income');
					$Item->setExpenseAccountRef('80');
					$Item->setExpenseAccountRef_name('Cost of Goods Sold');
					$Item->setAssetAccountRef('81');
					$Item->setAssetAccountRef_name('Inventory Asset');
					
					$Item->setDescription($vtiger_data['description']);
					$Item->setType('Inventory');
					$Item->setQtyOnHand(round($vtiger_data['qtyinstock']));
					$Item->setTrackQtyOnHand(true);
					$Item->setInvStartDate($vtiger_data['sales_start_date']);
					
					if($quickbook_id != ''){
						#Existing product
						if($resp = $ItemService->update($Context, $realm, $Item->getId(), $Item)){
							$qb_update++;
						}						
					}else{
						#new product		
						if ($resp = $ItemService->add($Context, $realm, $Item))
						{
							$vtiger_id = $id;
							$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
							$sq = "UPDATE vtiger_products SET quickbook_id= $qb_id  WHERE  productid = $vtiger_id ";
							$adb->query($sq);
							$qb_create++;							
						}
						 
					}
				
				}
			}
           // echo  $qb_create. ' Products Synced to Quickbooks.';
            return $qb_create;
			 
		}else{
			return 0;
		}
    }

    function postServices(){
        
		global $adb, $current_user;
		$query = "SELECT vs.serviceid FROM vtiger_service vs left join vtiger_crmentity vcm on vs.serviceid = vcm.crmid where vcm.deleted = 0 and vs.quickbook_id ='' ";
		$records = $adb->query($query); 
		$products_ids_data = $adb->num_rows($records);
		if($products_ids_data > 0){
			
			$qb_create = $qb_update = 0;
			while($resultrow = $adb->fetch_array($records)) { 
				$serviceid = $resultrow['serviceid']; 
				$wsid = vtws_getWebserviceEntityId('Services', $serviceid); // Module_Webservice_ID x CRM_ID
				$vtiger_data = vtws_retrieve($wsid, $current_user);
				
				require_once  'quickbooks/config.php';
				#require_once 'quickbooks/views/header.tpl.php';	 
				if(isset($Context)){ 
				
					$id = $vtiger_data['id'];
					$id = explode('x',$id);	 
					$id = $id[1]; 
					
					#check create/update
					$quickbook_id = $vtiger_data['quickbook_id'];
					$ItemService = new QuickBooks_IPP_Service_Item();
					if($quickbook_id != ''){
						//Existing product
						//Get the existing product 
						$items = $ItemService->query($Context, $realm, "SELECT * FROM Item WHERE Id = '$quickbook_id' ");
						$Item = $items[0];
					}else{
						#new product
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
						#Existing product
						if($resp = $ItemService->update($Context, $realm, $Item->getId(), $Item)){ 
							$qb_update++;
						}
						
					}else{
						#new product		
						if ($resp = $ItemService->add($Context, $realm, $Item))
						{
							$vtiger_id = $id;
							$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
							$sq = "UPDATE vtiger_service SET quickbook_id= $qb_id  WHERE  serviceid = $vtiger_id ";
							$adb->query($sq); $qb_create++;		
						} 
					}
				}
				 
			}
			return  $qb_create;
			 
		}else{
			return 0;
		}
		
    }

    function getVendors(){	
		global $adb, $current_user;
		require_once  'quickbooks/config.php';
		$VendorService = new QuickBooks_IPP_Service_Vendor();		
		$vendors = $VendorService->query($Context, $realm, "SELECT * FROM Vendor");
		$qb_venders = 0;
		foreach ($vendors as $Vendor)
		{
			$qb_id = QuickBooks_IPP_IDS::usableIDType($Vendor->getId());
			$data = array();	
			$data['quickbook_id'] = $qb_id;
			$data['assigned_user_id'] =  vtws_getWebserviceEntityId("Users", 1);
			$data['vendorname'] = $Vendor->getDisplayName();

			$email = $Vendor->getPrimaryEmailAddr();
			$website = $Vendor->getWebAddr();
			$PrimaryPhone = $Vendor->getPrimaryPhone();
			$Mobile = $Vendor->getMobile();
			$Fax = $Vendor->getFax();	
			$b = $Vendor->getBillAddr(); 
			
			if($PrimaryPhone != null){
				$data['phone'] = $PrimaryPhone->getFreeFormNumber();
			}	
			if($email != null){
				$data['email'] = $email->getAddress();
			}
			if($website != null){
				$data['website'] = $website->getURI();
			}	
			
			if($Mobile != null){
				$data['mobile'] = $Mobile->getFreeFormNumber();
			}	
			if($Fax != null){
				$data['fax'] = $Fax->getFreeFormNumber();
			}
			if($b != null){ 	
				$data['city'] = $b->getCity();
				$data['street'] = $b->getLine1();
				$data['country'] = $b->getCountry();
				$data['state'] = $b->getCountrySubDivisionCode();
				//$data['mailingpobox'] = QuickBooks_IPP_IDS::usableIDType($b->getId());
				$data['postalcode'] = $b->getPostalCode();
			} 
			
			#check record present or not 	
			$q = 'SELECT * FROM vtiger_vendor where quickbook_id =  "'.$qb_id.'"'; 
			$records = $adb->query($q);
			$com_count = $adb->num_rows($records); 
			if($com_count == 0) {
				#insert
				$ps = vtws_create('Vendors', $data, $current_user);
				$qb_venders++;
			}else{
				#update		 
			}
		}
		return $qb_venders;
    }
    
    function postVendors(){
         
		global $adb, $current_user;
		$query = "SELECT vv.vendorid FROM vtiger_vendor vv left join vtiger_crmentity vcm on vv.vendorid = vcm.crmid where vcm.deleted = 0 and vv.quickbook_id ='' ";
		$records = $adb->query($query);
		$vendors_ids_data = $adb->num_rows($records);
		if($vendors_ids_data > 0){
			$qb_create = $qb_update = 0;
			while($resultrow = $adb->fetch_array($records)) {
				$vendorid = $resultrow['vendorid']; 
				$wsid = vtws_getWebserviceEntityId('Vendors', $vendorid); // Module_Webservice_ID x CRM_ID
				$vtiger_data = vtws_retrieve($wsid, $current_user);
			
				require_once  'quickbooks/config.php';				 
				if(isset($Context)){ 
					$id = $vtiger_data['id'];
					$id = explode('x',$id);	 
					$id = $id[1];

					$quickbook_id = $vtiger_data['quickbook_id'];
					$VendorService = new QuickBooks_IPP_Service_Vendor();
					if($quickbook_id != ''){
						#Existing Vendor
						#Get the existing Vendor 
						$vendors = $VendorService->query($Context, $realm, "SELECT * FROM Vendor WHERE Id = '$quickbook_id' ");
						$Vendor = $vendors[0];
					}else{
						#new Vendor
						$Vendor = new QuickBooks_IPP_Object_Vendor();
					}
					
					#$Vendor->setTitle('Mr');
					$Vendor->setGivenName($vtiger_data['vendorname']); 
					$Vendor->setDisplayName($vtiger_data['vendorname']);
					
					# Email
					if($vtiger_data['email'] != ''){
						$PrimaryEmailAddr = new QuickBooks_IPP_Object_PrimaryEmailAddr();
						$PrimaryEmailAddr->setAddress($vtiger_data['email']);
						$Vendor->setPrimaryEmailAddr($PrimaryEmailAddr);
					}
					# Phone #
					if($vtiger_data['phone'] != ''){
						$PrimaryPhone = new QuickBooks_IPP_Object_PrimaryPhone();
						$PrimaryPhone->setFreeFormNumber($vtiger_data['phone']);
						$Vendor->setPrimaryPhone($PrimaryPhone);
					}
					# Mobile #
					if($vtiger_data['phone'] != ''){
						$Mobile = new QuickBooks_IPP_Object_Mobile();
						$Mobile->setFreeFormNumber($vtiger_data['phone']);
						$Vendor->setMobile($Mobile);
					} 
					
					if($quickbook_id != ''){
						#Existing Vendor
						if($resp = $VendorService->update($Context, $realm, $Vendor->getId(), $Vendor)){
							$qb_update++;
						} 
						
					}else{

						if ($resp = $VendorService->add($Context, $realm, $Vendor))
						{
							global $adb;
							$vtiger_id = $id;
							$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
							$sq = "UPDATE vtiger_vendor SET quickbook_id= $qb_id  WHERE  vendorid = $vtiger_id ";
							$adb->query($sq); 
							$qb_create++;
						}
						 
					}
				}
			} 
			return $qb_create;
			 
		}else{
			return 0;
		}
	}
	
	function getInvoice(){
		global $adb, $current_user;	
		require_once  'quickbooks/config.php';
		#$adb->setDebug(true);	
		$InvoiceService = new QuickBooks_IPP_Service_Invoice();		
		$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice");
		#$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice WHERE DocNumber = '1002' ");
		$count_inserted = 0;
		foreach ($invoices as $Invoice)
		{
			$qb_id = QuickBooks_IPP_IDS::usableIDType($Invoice->getId());			
			$data = array();	
			$data['quickbook_id'] = $qb_id;
			$data['assigned_user_id'] =  vtws_getWebserviceEntityId("Users", 1);			
			$qb_contactid = QuickBooks_IPP_IDS::usableIDType($Invoice->getCustomerRef());

			#contact details avilable or not 		
			$q = 'SELECT * FROM vtiger_contactdetails vcd left join vtiger_contactaddress vca on vcd.contactid = vca.contactaddressid where vcd.quickbook_id =  "'.$qb_contactid.'"'; 
			$records = $adb->query($q);
			$com_count = $adb->num_rows($records); 
			if($com_count == 0) { 
				#insert Contact 
					$CustomerService = new QuickBooks_IPP_Service_Customer();	
					$customers = $CustomerService->query($Context, $realm, "SELECT * FROM Customer WHERE Id = '$qb_contactid' ");
					$Customer = $customers[0]; 
					$BillAddr = $Customer->getBillAddr(); 
					$ShipAddr = $Customer->getShipAddr(); 
					$email = $Customer->getPrimaryEmailAddr();
					$PrimaryPhone = $Customer->getPrimaryPhone();
					$Mobile = $Customer->getMobile();
					$Fax = $Customer->getFax();
					$c_qb_id = QuickBooks_IPP_IDS::usableIDType($Customer->getId());
					$company_name = $Customer->getCompanyName();
					$WebAddr = $Customer->getWebAddr();
					
					$Company_data = array();				
					$contact_data = array(
						'assigned_user_id' => vtws_getWebserviceEntityId("Users", 1),
						'firstname' => $Customer->getGivenName(),
						'lastname' => $Customer->getMiddleName() .' '. $Customer->getFamilyName(), 	 
						'quickbook_id' => $c_qb_id
					);
					
					if($BillAddr != null){ 	
						$contact_data['mailingcity'] = $BillAddr->getCity();
						$contact_data['mailingstreet'] = $BillAddr->getLine1();
						$contact_data['mailingcountry'] = $BillAddr->getCountry();
						$contact_data['mailingstate'] = $BillAddr->getCountrySubDivisionCode();
						$contact_data['mailingzip'] = $BillAddr->getPostalCode();
						
						$data['bill_city'] = $Company_data['bill_city'] = $BillAddr->getCity();
						$data['bill_code'] = $Company_data['bill_code'] =  $BillAddr->getPostalCode();
						$data['bill_country'] = $Company_data['bill_country'] =  $BillAddr->getCountry();
						$data['bill_state'] = $Company_data['bill_state'] =  $BillAddr->getCountrySubDivisionCode();
						$data['bill_street'] = $Company_data['bill_street'] =  $BillAddr->getLine1();			
						if(empty($BillAddr->getLine1())){ $Company_data['bill_street'] = 'line1';}
					} 
					if($ShipAddr != null){
						$data['ship_city'] = $Company_data['ship_city'] = $ShipAddr->getCity();
						$data['ship_code'] = $Company_data['ship_code'] =  $ShipAddr->getPostalCode();
						$data['ship_country'] = $Company_data['ship_country'] =  $ShipAddr->getCountry();
						$data['ship_state'] = $Company_data['ship_state'] = $ShipAddr->getCountrySubDivisionCode();
						$data['ship_street'] = $Company_data['ship_street'] =  $ShipAddr->getLine1();
						if(empty($ShipAddr->getLine1())){ $Company_data['ship_street'] = 'line1';}
					}

					if($email != null){
						$contact_data['email'] = $email->getAddress();
						$Company_data['email1'] = $email->getAddress();
					}
					
					if($PrimaryPhone != null){
						$contact_data['phone'] = $PrimaryPhone->getFreeFormNumber();
						$Company_data['phone'] =  $PrimaryPhone->getFreeFormNumber();
					} 
					 
					if($Mobile != null){
						$contact_data['mobile'] = $Mobile->getFreeFormNumber();
						$Company_data['otherphone'] = $Mobile->getFreeFormNumber();
					}
					
					if($Fax != null){
						$contact_data['fax'] = $Fax->getFreeFormNumber();
						$Company_data['fax'] = $Fax->getFreeFormNumber();
					}
					
					if($WebAddr != null){
						#$contact_data['website'] = $WebAddr->getURI();
						$Company_data['website'] = $WebAddr->getURI();
					}
					
					if($Customer->getNotes()){
						$contact_data['Notes'] = $Customer->getNotes();
						$Company_data['Notes'] = $Customer->getNotes();
					}
					
					#check company name 
					if(!empty(trim($company_name)))
					{	 
						$q = 'SELECT accountid FROM vtiger_account where quickbook_id = "'.$c_qb_id.'"';
						$records = $adb->query($q);
						$com_count = $adb->num_rows($records); 
						if($com_count == 0){
							#insert company name to Organization name							 
							$Company_data['assigned_user_id'] = vtws_getWebserviceEntityId("Users", 1);
							$Company_data['accountname'] = $company_name;
							$Company_data['quickbook_id'] =  $c_qb_id;				
							$account_Data = vtws_create('Accounts', $Company_data, $current_user);
							$id = $account_Data['id'];
							$id = explode('x',$id);	 
							$contact_data['accountid'] = $id[1];	
							$vtiger_accountid = $id[1];			
						}else{
							$c_id = $adb->fetch_array($records); 
							$contact_data['accountid'] = $c_id['accountid'];
							$vtiger_accountid = $c_id['accountid'];
						}			
					}
					$vtiger_data = vtws_create('Contacts', $contact_data, $current_user);
					
					$id = $vtiger_data['id'];
					$id = explode('x',$id);	 
					$vtiger_contactid = $id[1]; 
			}else{ 
				$vtiger_contactid = $adb->query_result($records,0,'contactid');
				#add contact address here 
				$data['ship_city'] = $data['bill_city'] =   $adb->query_result($records,0,'mailingcity');
				$data['ship_code'] = $data['bill_code'] = $adb->query_result($records,0,'mailingzip');
				$data['ship_country'] = $data['bill_country'] = $adb->query_result($records,0,'mailingcountry');
				$data['ship_state'] = $data['bill_state'] = $adb->query_result($records,0,'mailingstate');
				$data['ship_street'] = $data['bill_street'] = $adb->query_result($records,0,'mailingstreet');
				#mailingpobox				
				$aq = 'SELECT accountid FROM vtiger_account where quickbook_id =  "'.$qb_contactid.'"'; 
				$arecords = $adb->query($aq);
				$vtiger_accountid = $adb->query_result($arecords,0,'accountid');
			}
			
			$data['contactid'] = vtws_getWebserviceEntityId("Contacts",  $vtiger_contactid);		
			# end Contact
			
			$data['subject'] = $Invoice->getDocNumber();
			$data['invoicedate'] = $Invoice->getTxnDate();			
			$data['duedate'] = $Invoice->getDueDate();	 
			$data['taxtype'] = 'group';	
			$data['invoice_no'] = $Invoice->getDocNumber();
			
			$data['account_id'] = vtws_getWebserviceEntityId("Accounts",  $vtiger_accountid);
			
			
			#{-usd} need to change id
			$currency_id = strtoupper(QuickBooks_IPP_IDS::usableIDType($Invoice->getCurrencyRef()));
			$cq = "SELECT id,conversion_rate FROM vtiger_currency_info where currency_code='".$currency_id."'";
			 
			$cqd = $adb->query($cq);
			$cqd_count = $adb->num_rows($cqd);
			if($cqd_count == 1){
				$cid = $adb->fetch_array($cqd);
				 
				$data['currency_id'] = vtws_getWebserviceEntityId("Currency",  $cid['id']);
				$data['conversion_rate'] = $cid['conversion_rate'];
			}else{
				$data['currency_id'] = vtws_getWebserviceEntityId("Currency",  1);
				$data['conversion_rate'] = 1;
			} 
			
			$data['subtotal'] = $Invoice->getTotalAmt();	
			$data['total'] = $Invoice->getBalance();

			#TAX
			$TxnTaxDetail = $Invoice->getTxnTaxDetail();
			$TaxPercent  = 0;
			if($TxnTaxDetail != NULL){
				$TotalTax = $TxnTaxDetail->getTotalTax();
				$TaxLineDetail = $TxnTaxDetail->getTaxLineDetail();
				if($TaxLineDetail != NULL){
					$TaxPercent  = $TaxLineDetail->getTaxPercent();
				}
			}
			$data['s_h_percent'] = $TotalTax;

			#line 
			$Lines = $Invoice->getLine(); 
			//echo '<pre>';print_r($Lines); echo '</pre>';		
			$pre_tax_total = 0;
			if(is_array($Lines) && count($Lines) == 2){
				$Line = $Lines[0];//show mutltiple records, get 1st one 
				#single Item
				$lien_amount = $Line->getAmount();
				$lien_DetailType = $Line->getDetailType();
				$lienSalesItemLineDetail = $Line->getSalesItemLineDetail();
				if($lienSalesItemLineDetail != NULl){
					$ItemRef = QuickBooks_IPP_IDS::usableIDType($lienSalesItemLineDetail->getItemRef());//{-id}			
					$ItemRef_name = $lienSalesItemLineDetail->getItemRef_name();
					$UnitPrice = $lienSalesItemLineDetail->getUnitPrice();
					$Qty = $lienSalesItemLineDetail->getQty();
				} 
				$product_id = $this->getProductId($ItemRef);				
				$data['productid'] = $data['LineItems'][$z]['productid'] = vtws_getWebserviceEntityId("Products",  $product_id);
				$data['LineItems'][$z]['quantity'] = $Qty;
				$data['LineItems'][$z]['listprice'] = $UnitPrice;
				#$data['LineItems'][$z]['tax3'] = $TaxPercent;
				$pre_tax_total = $UnitPrice;

			}elseif(is_array($Lines) && count($Lines) > 2){
				array_pop($Lines);$z = 0;
				#multiple items 
				foreach($Lines as $Line){
					$lien_amount = $Line->getAmount();
					$lien_DetailType = $Line->getDetailType();
					$lienSalesItemLineDetail = $Line->getSalesItemLineDetail();
					if($lienSalesItemLineDetail != NULl){
						$ItemRef = QuickBooks_IPP_IDS::usableIDType($lienSalesItemLineDetail->getItemRef());//{-id}			
						$ItemRef_name = $lienSalesItemLineDetail->getItemRef_name();
						$UnitPrice = $lienSalesItemLineDetail->getUnitPrice();
						$Qty = $lienSalesItemLineDetail->getQty();
					} 
					$product_id = $this->getProductId($ItemRef);				
					$data['productid'] = $data['LineItems'][$z]['productid'] = vtws_getWebserviceEntityId("Products",  $product_id);
					$data['LineItems'][$z]['quantity'] = $Qty;
					$data['LineItems'][$z]['listprice'] = $UnitPrice;
					#$data['LineItems'][$z]['tax3'] = $TaxPercent;
					$pre_tax_total = $pre_tax_total + $UnitPrice;
					$z++;
				}
			} 

			
			# add all line item unitprice			 
			$data['pre_tax_total'] = $pre_tax_total;			
			$data['balance'] = $Invoice->getBalance();		 
			
			$BillAddr = $Invoice->getBillAddr();
			if($ShipAddr != NULL){ 					
				$data['bill_city'] = $BillAddr->getCity();
				$data['bill_code'] = $BillAddr->getPostalCode();
				$data['bill_country'] = $BillAddr->getCountry();
				$data['bill_state'] = $BillAddr->getCountrySubDivisionCode();
				$data['bill_street'] = $BillAddr->getLine1();
				#$data['bill_pobox'] = $BillAddr->get();
			}
			
			$ShipAddr = $Invoice->getShipAddr(); 		 
			if($ShipAddr != NULL){ 
				$data['ship_city'] = $ShipAddr->getCity();
				$data['ship_code'] = $ShipAddr->getPostalCode();
				$data['ship_country'] = $ShipAddr->getCountry();
				$data['ship_state'] = $ShipAddr->getCountrySubDivisionCode();
				$data['ship_street'] = $ShipAddr->getLine1();
				//$data['ship_pobox'] = $ShipAddr->get();
				# status table vtiger_invoicestatus
			}
			
			//$q = 'SELECT * FROM vtiger_invoice where quickbook_id =  "'.$qb_id.'"';
			$q = 'SELECT vc.invoiceid FROM vtiger_invoice vc left join vtiger_crmentity vcm on vc.invoiceid = vcm.crmid where vcm.deleted = 0 and vc.quickbook_id = "'.$qb_id.'"';
			$records = $adb->query($q);
			$com_count = $adb->num_rows($records); 
			if($com_count == 0) {
				#insert
				$qi = vtws_create('Invoice', $data, $current_user);
				$count_inserted++;
			}else{
				#update
			} 
		}
		return $count_inserted;
	}

	function postInvoice()
	{ 
		global $adb, $current_user;		 
		$query = "SELECT vc.invoiceid FROM vtiger_invoice vc left join vtiger_crmentity vcm on vc.invoiceid = vcm.crmid where vcm.deleted = 0 and vc.quickbook_id ='' ";
		$records = $adb->query($query);
		$num_rows = $adb->num_rows($records);	
		if($num_rows > 0){ 	 
			while($resultrow = $adb->fetch_array($records)) { 
				
				$invoiceid = $resultrow['invoiceid']; 
				$wsid = vtws_getWebserviceEntityId('Invoice', $invoiceid); // Module_Webservice_ID x CRM_ID
				 
				$vtiger_data = vtws_retrieve($wsid, $current_user);
				 
				require_once  'quickbooks/config.php';				 
				 
				if(isset($Context)){ 
					 
					$id = $vtiger_data['id'];
					$id = explode('x',$id);	 
					$id = $id[1];  
					
					#check create/update
					$quickbook_id = $vtiger_data['quickbook_id'];
					$InvoiceService = new QuickBooks_IPP_Service_Invoice();
					if($quickbook_id != '')
					{
						#Existing invoice
						#Get the existing invoice 
						$invoices = $InvoiceService->query($Context, $realm, "SELECT * FROM Invoice  WHERE Id = '$quickbook_id' ");
						$Invoice = $invoices[0];
					}else{
						#new invoice
						$Invoice = new QuickBooks_IPP_Object_Invoice();
					}					

					$Invoice->setDocNumber($vtiger_data['invoice_no']);
					$Invoice->setTxnDate($vtiger_data['invoicedate']);
					
					if(empty($vtiger_data['contact_id'])){
						$account_id = $vtiger_data['account_id'];
						$account_id = explode('x',$account_id);	 
						$account_id = $account_id[1];
						 
						$adata = $adb->query("SELECT quickbook_id FROM vtiger_account where accountid = '$account_id'");
						$adata = $adb->fetch_array($adata);		 
						$Invoice->setCustomerRef($adata['quickbook_id']);
						
					}else{
						$cid = $vtiger_data['contact_id'];
						$cid = explode('x',$cid);	 
						$cid = $cid[1];
						 
						$cdata = $adb->query("SELECT quickbook_id FROM vtiger_contactdetails where contactid = '$cid'");
						$cdata = $adb->fetch_array($cdata);		 
						$Invoice->setCustomerRef($cdata['quickbook_id']);
					}
					 
					
					foreach($vtiger_data['LineItems'] as $key => $item)
					{
						$Line = new QuickBooks_IPP_Object_Line();
						$SalesItemLineDetail = new QuickBooks_IPP_Object_SalesItemLineDetail();		
						$item_id = $item['productid'];
						$item_id = explode('x',$item_id);	 
						$item_id = $item_id[1]; 
						#get type of item (product/services)
						$sq = "SELECT setype FROM vtiger_crmentity where crmid=$item_id";
						$item_type = $adb->query($sq);
						$item_type = $adb->fetch_array($item_type);			 
						$setype = $item_type['setype'];
							if($setype == 'Services'){
								$q = "SELECT servicename as itemname,quickbook_id FROM vtiger_service where serviceid = $item_id";
							}else{
								$q = "SELECT productname as itemname,quickbook_id FROM vtiger_products where productid = $item_id";
							}
						$itemdata = $adb->query($q);
						$itemdata = $adb->fetch_array($itemdata);	
						
						$SalesItemLineDetail->setItemRef($itemdata['quickbook_id']);
						$SalesItemLineDetail->setItemRef_name($itemdata['itemname']);
						$SalesItemLineDetail->setUnitPrice($item['listprice']);
						$SalesItemLineDetail->setQty($item['quantity']);
						
						$Line->addSalesItemLineDetail($SalesItemLineDetail);
						$tax = $item['tax1'] +  $item['tax2'] +  $item['tax3'];
						#$Line->setAmount($item['listprice'] * $item['quantity'] * ($tax/100));
						$Line->setAmount($item['listprice'] * $item['quantity'] );
						$Line->setDescription($item['description']);
						$Line->setDetailType('SalesItemLineDetail');
						$Invoice->addLine($Line);
					}				
				 
					#$Invoice->setTax(270);
					#$Invoice->setCustomerRef($id);					
					if($quickbook_id != ''){
						#update
						if($resp = $InvoiceService->update($Context, $realm, $Invoice->getId(), $Invoice)){
							$qb_update++;
						} 
						
					}else{						
						#create
						if ($resp = $InvoiceService->add($Context, $realm, $Invoice))
						{
							$vtiger_id = $id;
							$qb_id = QuickBooks_IPP_IDS::usableIDType($resp);
							$sq = "UPDATE vtiger_invoice SET quickbook_id= $qb_id  WHERE  invoiceid = $vtiger_id ";
							$adb->query($sq); 
							$qb_create++;	
						}						
					}	 
				}				
				
			}	
			return  $qb_create;
		}else{
			return 0;
		}
	}

	#get product/service id 
	function getProductId($ItemRef){
		global $adb, $current_user;
		$pq = 'SELECT productid FROM vtiger_products where quickbook_id =  "'.$ItemRef.'"';
		$precords = $adb->query($pq);
		$com_count_products = $adb->num_rows($precords);
		if($com_count_products > 0 ){
			$id = $adb->fetch_array($precords);
			return $id['productid'];
		}else{
			$sq = 'SELECT serviceid FROM vtiger_service where quickbook_id =  "'.$ItemRef.'"';
			$srecords = $adb->query($sq);
			$com_count_services = $adb->num_rows($srecords); 
			if($com_count_services > 0){
				$id = $adb->fetch_array($srecords);
				return $id['serviceid'];
			}else{				
				$a = $this->getProductsServices();
				$this->getProductId($ItemRef);
			}
			
		}
		 
	 }

}