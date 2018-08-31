<?php

include_once 'modules/Users/Users.php';
include_once 'include/Webservices/Create.php';
include_once 'include/Webservices/Revise.php'; 
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';

function phylosChemotypeSubmission($entity){

	global $adb;
	//$adb->setDebug(true);
	//file_put_contents('phylosChemotypeSubmission.txt' , print_r($entity->data,true) ) ;	
	 
	$vtiger_data = $entity->data;
	//echo '<pre>';print_r($vtiger_data);
	
	$vtiger_data = (array)$vtiger_data;
	$id = $vtiger_data['id'];
	$id = explode('x',$id);
	$said = $id[1]; 
	 
	#current User Details
	$user = new Users();
	$current_user = $user->retrieveCurrentUserInfoFromFile(Users::getActiveAdminId());
	
	#crmdata
	$kit_id = $vtiger_data['genotype_kit_id'];
	$CreatedTime = $vtiger_data['CreatedTime'];
	$thc_percent = $vtiger_data['thc_percentage'];
	$cbd_percent = $vtiger_data['cbd_percentage'];
	$batch_identifier = $vtiger_data['sampleanalysis_no'];
	$testing_facility = $vtiger_data['sampleanalysis_no'];
	
	#get Access key	
	$livekey = 'pb_ixUVElJwP1qPXQosUrVpGVTNfeLpvxb8';
	$Sandboxkey = 'pb_test_xWW2uDUQdrmaFSOVUfkeQXP2XlN';
	$api_key = $Sandboxkey;
	$api_base_url = "https://testing.phylosbioscience.com/partner/api/v1/";
	$opts = array(
			  'https'=>array(
				'method'=>"GET",
				'header'=>"Accept-language: en\r\n" .
				"Cookie: foo=bar\r\n"
			  )
			);
	$context = stream_context_create($opts);	 
	$url = $api_base_url ."linked-accounts?api_key=".$api_key ;
	$result = file_get_contents($url, null, $context); 
	$linklist = json_decode($result); 
	//$accesskey = $linklist->data->id_123456789;
	$accesskey = $linklist->data->USERID;	
	
	#kit-chemotype 	
	$postdata = http_build_query(
		array(
			'api_key' => $api_key, 
			'phylos_user_token' => $accesskey,
			'kit_id' => $kit_id,
			'test_date' => $CreatedTime,
			'testing_facility' => $testing_facility,
			'batch_identifier' => $batch_identifier,
			'thc_percent' => $thc_percent,
			'cbd_percent' => $cbd_percent
		)
	);

	$opts = array('http' =>
		array(
			'method'  => 'POST',
			'header'  => 'Content-type: application/x-www-form-urlencoded',
			'content' => $postdata
		)
	);
	
	$context  = stream_context_create($opts);
	$url = $api_base_url ."kit-chemotype";
	$result = file_get_contents($url, false, $context);
	$linklist = json_decode($result);   
	
	//stdClass Object ( [message] => Chemotype data for Kit G-AAAAA has been received. Thank you. [env] => sandbox [data] => stdClass Object ( [confirmation] => CSABCDEF ) )
	
	 $confirmation = $linklist->data->confirmation;
	
	try {
        
		$adb->pquery("update vtiger_sampleanalysiscf set confirmation_id = ? where sampleanalysisid = ?",array($confirmation,$said));
		
		//$wsid = vtws_getWebserviceEntityId('SampleAnalysis', $said); // Module_Webservice_ID x CRM_ID
		//$data = array('confirmation_id' => $confirmation, 'id' => $wsid);
		//$a = vtws_revise($data, $current_user);		 
		//print_r($linklist); 
		//exit;
		
	} catch (WebServiceException $ex) {
		echo $ex->getMessage();
	}
	 
}

?>