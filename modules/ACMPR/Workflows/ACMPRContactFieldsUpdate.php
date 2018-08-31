<?php
function ACMPRContactFields($entitydata){
	global $adb,$current_user;
//	$adb->setDebug(true);
	$currentUser = Users_Record_Model::getCurrentUserModel();
	$recordinfo = $entitydata->getData();
	$wsId = $entitydata->getId();
	$parts = explode('x', $wsId);
	$recordid = $parts[1];
	$fields= array();
	
	//appilcant section2
	$fields['applicant'] = array(
		'title'=>'title',// title 
		'gender'=>'gender',//gender
		'birthday'=>'date_of_birth',//DOB
		'mailingstreet'=>'street_address',//StreetAddress
		'mailingcity'=>'city',//City
		'mailingstate'=>'province',//province
		'mailingzip'=>'postalcode',//PostalCode
		'email'=>'email',//PrimaryEmail
		'fax' => 'fax_no',//fax no
		'mobile' => 'telephone_no',
	);
		
	//Section3ProposedPersonnel
	$fields['senior_applicant'] = array(
		'lastname'=>'surname',//lastnameneedtocopySurname
		'firstname'=>'given_name',//firstnameneedtocopy
		'gender'=>'senior_gender',//Gender
		'birthday'=>'senior_dob',//DOB
		'mobile'=>'senior_telephone_no',//Phone
		'email'=>'senior_email',//Email
		'other_title' => 'other_title',//other title
		'fax' =>'senior_fax_no',//Senior Fax no
		'fulladdress'=>'senior_address',//Needtocontactfulladdress
	);
	
	//RPICApplicant
	$fields['rpic_applicant'] = array(
		'lastname'=>'rpic_surname',//lastname
		'firstname'=>'rpic_givenname',//firstname
		'gender'=>'rpic_gender',//gender
		'birthday'=>'rpic_dob',//dob
		'worked_hours_days'=>'rpic_work_hours_days',//workedhoursanddays
		'other_title'=>'rpic_other_title',//othertitle
	);
	
	//Section7OwnershipofProperty
	$fields['sameRPIC'] = array(//cf_1813
		'lastname'=>'spic_surname',//Lastname
		'firstname'=>'spic_givename',//Firstname
		'other_title'=>'spic_other_title',//OtherTitle
			//'sigimage'=>'spic_signature',//SPICseniorsignature
	);

	//Section9Notice
	//PoliceForceSeniorOfficial
	$fields['police_force_senior_official'] = array(
		'fulladdress'=>'police_force_address',//Fulladdress
			'title'=>'police_force_title',
			'account_id' => 'police_force_local_authority',
	);
		
	//FireAuthorityAddress
	$fields['fire_authority_senior_official']=array(
		'fulladdress'=>'fire_authority_address',//Fulladdress
		'title'=>'fire_authority_title',
		'account_id' => 'fire_local_authority',
	);
		
	$fields['local_gov_senior_official'] = array(
		'fulladdress'=>'local_gov_address',//Fulladdress
		'title'=>'local_government_title',
		'account_id' => 'local_gov_authority',
	);

	$fields['proposed_qap'] = array(
		//Section10QAP
		'lastname'=>'qap_surname',//QAPlastname
		'firstname'=>'qap_givenname',//Firstname
		'gender'=>'qap_gender',//Gender
		'birthday'=>'qap_dob',//DOb
		'worked_hours_days'=>'qap_worked_hours_days',//workedhoursanddays
	);
	
	//Section 13 joint ownerDocument
	$fields['joint_owner1'] = array('fulladdress'=>'joint_owner1_address');
	$fields['joint_owner2'] = array('fulladdress'=>'joint_owner2_address');
		
	$fullAddressFields = array('mailingpobox','mailingstreet','mailingcity','mailingstate','mailingzip',
	'mailingcountry');
	//$adb->setDebug(true);
	foreach($fields as $key=>$subarr){
		$params = array();
		$listval = array();
		foreach($subarr as $subkey=>$subval){
			if($subkey != 'fulladdress'){
				if($subkey == 'account_id'){
					$params[] = $subval."=?";
					$orgid = explode("x",$recordinfo[$subkey]);
					$listval[] = $adb->query_result($adb->pquery("SELECT accountname FROM vtiger_account WHERE accountid=?",array($orgid[1])),0,'accountname');
				}else{
					$params[] = $subval."=?";
					$listval[] = $recordinfo[$subkey];
				}
			}else{
				$params[] = $subval."=?";
				$fulladdr = '';
				foreach($fullAddressFields as $index=>$addfield){
					if($recordinfo[$addfield] != ''){
						if($addfield == 'mailingpobox'){
								$fulladdr .= 'PO Box ';
							}
						$fulladdr .= $recordinfo[$addfield].",";
					}
				}
				$listval[] = rtrim($fulladdr,",");
			}
		}
		$listval[] = $recordid;
		
		if($key == 'sameRPIC'){
			$key = 'cf_1813';
			
			$adb->pquery("UPDATE vtiger_acmpr  SET ".implode(",", $params).  "  WHERE ".$key.'=? and cf_1916 = ?'  , array('','','',$recordid,'1'));
			$listval[] = 0;
			$adb->pquery("UPDATE vtiger_acmpr  SET ".implode(",", $params).  "  WHERE ".$key.'=? and cf_1916 = ?'  , $listval);
		}else{
			$adb->pquery("UPDATE vtiger_acmpr  SET ".implode(",", $params).  "  WHERE ".$key.'=?' , $listval);
		}
		
		
	}
	//ARPIC Grid Details Update
	$ARPIC = array(
        'lastname'=> 'givenname', //lastname
        'firstname'=> 'surname', //firstname
        'gender'=> 'gender', //gender
        'birthday'=> 'dateofbirth', //dob
        'worked_hours_days'=> 'whdays', //workedhoursanddays
        'title'=> 'ranking', //title
        'other_title'=> 'othertitle', //othertitle
    );
	$arpicparams = array();
	$arpicval = array();
	foreach($ARPIC as $k => $v){
		$arpicparams[] = $v.'=?'; 
		$arpicval[] =$_REQUEST[$k]; 
	}
	$arpicval[] = $recordid;
	$adb->pquery("UPDATE vtigress_arpic_griddetails  SET ".implode(",", $arpicparams).  "  WHERE contactid=? "  , $arpicval);
	
	//Persons Grid Details Update
	$person = array(
        'lastname'=> 'givenname', //lastname
        'firstname'=> 'surname', //firstname
        'gender'=> 'gender', //gender
    );
	$personparams = array();
	$personval = array();
	foreach($person as $k => $v){
		$personparams[] = $v.'=?'; 
		$personval[] =$_REQUEST[$k]; 
	}
	$personval[] = $recordid;
	$adb->pquery("UPDATE vtigress_person_griddetails  SET ".implode(",", $personparams).  "  WHERE contactid=? "  , $personval);
	
}
?>