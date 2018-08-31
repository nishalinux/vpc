<?php
function ACMPRAccountFields($entitydata){
	global $adb,$current_user;
	$currentUser = Users_Record_Model::getCurrentUserModel();
	$recordinfo = $entitydata->getData();
	$wsId = $entitydata->getId();
	$parts = explode('x', $wsId);
	$recordid = $parts[1];
	$fields= array();
	
	$fields['legal_name'] = array( //Legal Name
			'trade_name'=>'other_corporation_reg_name', //trade name 
			'ship_street' => 'ship_street_address',//ship street address
			'ship_city' => 'ship_city',//ship city
			'ship_state' => 'ship_province', // ship province
			'ship_code' => 'ship_postal_code', //ship postal code
			'phone' => 'ship_phone_no', //primary phone =>ship phone no 
			'fax' => 'ship_fax_no', //ship fax no
			'primary_email' => 'ship_email', // ship email
			'bill_street' => 'bill_street_address', //Bill street Address
			'bill_city' => 'bill_city', //Bill City
			'bill_state' => 'bill_province', //Bill province
			'bill_code' => 'bill_postal_code'//Bill Postal Code
	);
	$fields['third_party_laboratory_name'] = array(//Labratory name
		'orgfulladdress' => 'address',//address field
		'drugs_licence_number' => 'drugs_licence_number',//License number
	);

	$fullAddressFields = array('ship_pobox','ship_street','ship_city','ship_state','ship_country','ship_code');

	foreach($fields as $key=>$subarr){
		$params = array();
		$listval = array();
		foreach($subarr as $subkey=>$subval){
			if($subkey != 'fulladdress'){
				$params[] = $subval."=?";
				$listval[] = $recordinfo[$subkey];
			}else{
				$params[] = $subval."=?";
				$fulladdr = '';
				foreach($fullAddressFields as $index=>$addfield){
					if($recordinfo[$addfield] != ''){
						if($addfield == 'ship_pobox'){
								$fulladdr .= 'PO Box ';
							}
						$fulladdr .= $recordinfo[$addfield].",";
					}
				}
				$listval[] = rtrim($fulladdr,",");
			}
		}
		$listval[] = $recordid;

		$adb->pquery("UPDATE vtiger_acmpr  SET ".implode(",", $params).  "  WHERE ".$key.'=?' , array($listval));
	}
	//exit;
}