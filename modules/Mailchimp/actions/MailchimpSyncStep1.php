<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * Modified and improved by crm-now.de
 *************************************************************************************/

require_once('modules/Mailchimp/providers/MCAPI.class.php');

class Mailchimp_MailchimpSyncStep1_Action extends Mailchimp_MailChimpStepController_Action{

    function __construct() {
        parent::__construct();
	}
	
	public function process(Vtiger_Request $request) {
		$list_id=$request->get('list_id');
		$group=$request->get('group');
		$groupslist= $request->get('groupslist');
		self::initiateCustomFields($list_id);
		self::initiateMcGroup($list_id,$group);
		self::syncSubscribedWithMailChimp($list_id, $groupslist, $group);
		return;
	}

	
	public function initiateCustomFields($list_id) {
		$apikey = Mailchimp_Module_Model::getApikey();
		$mc_api = new MCAPI($apikey);
		$mc_customfields = array ('Contacts'=>Array('salutation'=>'SALUTATION','account_id'=>'COMPANY'));
		foreach($mc_customfields as $crmmodule=>$field_array){
			foreach($field_array as $crm_field=>$mc_field){
				//start --- create additional list fields in MailChimp if they do not exist
				$fieldfound = false;
				$mcVars = $mc_api->listMergeVars($list_id);
				foreach ($mcVars as $key =>$value_arr) {
					if ($value_arr['tag'] == $mc_field) {
						$fieldfound = true;
					}
				}
				//create key
				if ($fieldfound == false) {
					//add key
					$result = $mc_api->listMergeVarAdd($list_id, $mc_field,$mc_field, array('text'));
					parent::writeLogEventText($mc_field.' '.getTranslatedString('LBL_CREATE_FIELD', 'Mailchimp'));
				}
				else {
					parent::writeLogEventText($mc_field.' '.getTranslatedString('LBL_FIELD_EXISTS', 'Mailchimp'));
				}
				//stop --- create additional list fields
			}
		}
	}
	
	protected function initiateMcGroup($list_id,$group) {
		//start --- create additional CRM group in Mailchimp if it does not exist
		$apikey = Mailchimp_Module_Model::getApikey();
		$mc_api = new MCAPI($apikey);
		$groupinfo = $mc_api->listInterestGroupings($list_id);
		$group_exists = false;
		if (is_array($groupinfo)) {
			foreach ($groupinfo as $arr_key => $arr_value) {
				if ($arr_value['name']==parent::getGroupName()) {
					parent::writeLogEventText($mc_field.' '.getTranslatedString('GROUPS_ADD', 'Mailchimp'));
					$group_exists = true;
					$thisgroup = true;
				}
			}
		}
		if ($group_exists == false) {
			//create new group at Mailchimp
			$mc_api->listInterestGroupingAdd($list_id, parent::getGroupName(), 'checkboxes', array($group));
			if($mc_api->errorCode==""){
				parent::writeLogEventText($mc_field.' '.getTranslatedString('GROUPS_ADD', 'Mailchimp'));
			} 
			else {
				parent::writeLogEventText($mc_field.' '.getTranslatedString('GROUPS_NOT_ADD', 'Mailchimp'),'red','','',20);
				parent::writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$mc_api->errorCode,'red','','',20);
				parent::writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$mc_api->errorMessage,'red','','',20);
			}
		}
		//stop --- create additional CRM group in Mailchimp if it does not exist
	}
	
     public function syncSubscribedWithMailChimp($listid, $groupslist, $group) {
		$db = PearDatabase::getInstance();

		$currentDate = date('Y-m-d H:i:s');
		// check sync date
		parent::writeLogEventText(getTranslatedString('LBL_GET_LAST_SYNCDATE', 'Mailchimp'));
		$lastListSyncDate='';
		$lastGroupSyncDate='';
		$lastListSyncDate = parent::getLastListSyncDate();
		$lastGroupSyncDate = parent::getLastGroupSyncDate();
		if ($lastGroupSyncDate !='') {
			parent::writeLogEventText(getTranslatedString('LBL_LAST_GROUP_SYNC', 'Mailchimp').' '.$lastGroupSyncDate);
			if (!empty($lastListSyncDate)) {
				parent::writeLogEventText(getTranslatedString('LBL_LAST_SYNC_DATE', 'Mailchimp').' '.$lastListSyncDate);
			}
		}
		//we distinguish between full and partial synchronisation
		if (!empty($lastListSyncDate)) {
			/*
			* first we need to check whether entries had been deleted at Mail Chimp since the last sync
			* we do that by comparing the email addresses from entries linked by vtiger_mailchimpsyncdiff with the MailChimp entries
			* Important: all email addresses are compared as "lower string" to avoid duplicates
			*/
			self::getSynchronizedCRMEntries('Contacts');
			self::getSynchronizedCRMEntries('Leads');
			//$this->SynchronizedCRMEntries contains now all synchronized entries [id]=>[emailaddress]
			self::getMailChimpEntries();
			// $this->existingMailChimpEntries contains now all group entries from Mailchimp [email] => [emailaddress]
	
			//now we start to compare SynchronizedCRMEntries and existingMailChimpEntries
			// start --- Step 1.1 
			// what was synchronized but removed from Mailchimp
			if ($this->MCbatchinfoTotal>0) {
				parent::writeLogEventText(getTranslatedString('LBL_CHECK_DATA_MC', 'Mailchimp'));
				// $keysinboth will contain keys which are at Mailchimp as well as vtiger_mailchimpsyncdiff
				$keysinboth = array ();
				//check for entries which had been deleted at Mailchimp since last synchronisation
				foreach ($this->existingMailChimpEntries as $arr_key => $arr_value) {
					//$keys will contain RELID's which are subscribed in both (CRM as well as Mailchimp)
					// note that comparison is based on strtolower
					$findkeys = array_search(strtolower ($arr_value['email']),$this->SynchronizedCRMEntries );
					if ($findkeys !='') {
						//there are identical entries in MailChimp and CRM
						$keysinboth[] = $findkeys;
					}
				}
				if (count($keysinboth)>0)  {
					$keysinboth = array_flip ($keysinboth);
					$keep_entries = array_intersect_key($this->SynchronizedCRMEntries, $keysinboth);
					//get the entries which shall be removed
					$remove_entries = array_diff ($this->SynchronizedCRMEntries, $keep_entries);
					if (count($remove_entries) >0) {
						parent::writeLogEventText(getTranslatedString('LBL_REMOVE_ID', 'Mailchimp'),'','','','20');
						foreach ($remove_entries as $arr_key => $arr_value) {
							//echo email addresses
							parent::writeLogEventText($arr_value,'red','','','30');
						}
						foreach($remove_entries as $entryid=>$emailaddress){
							$RELdel_sql = "DELETE FROM vtiger_crmentityrel WHERE relcrmid = ?  AND crmid = ?";
							$db->pquery($RELdel_sql,array($entryid,$this->recordid));
							$SYNCdel_sql = "DELETE FROM vtiger_mailchimpsyncdiff WHERE relcrmid = ?  AND crmid = ?";
							$db->pquery($SYNCdel_sql,array($entryid,$this->recordid));
						}
					}
					else {
						parent::writeLogEventText(getTranslatedString('LBL_NO_MS_CHANGE', 'Mailchimp'),'','','','20');
					}
				}
			}
			elseif ($this->MCbatchinfoTotal==0) {
				//delete all related entries
				$RELdel_sql = "DELETE s FROM vtiger_crmentityrel AS s 
				INNER JOIN vtiger_mailchimpsyncdiff AS n ON s.crmid = n.crmid 
				WHERE n.crmid = ?";
				$db->pquery($RELdel_sql,array($this->recordid));
				$SYNCdel_sql = "DELETE FROM vtiger_mailchimpsyncdiff WHERE crmid = ?";
				$db->pquery($SYNCdel_sql,array($this->recordid));
			}
			// stop --- Step 1.1 
		}
		// start --- Step 1.2
		// check the contact status at CRM site
		$fulltransfer = false;
		if(empty ($lastListSyncDate) OR $this->mailchimplistempty == true){
			$fulltransfer = true;
			parent::writeLogEventText(getTranslatedString('LBL_GET_ALL', 'Mailchimp'));
			//very first time synchronisation - get all contacts from the CRM related list
			//1st do it for contacts
			$Contactquery = 'SELECT DISTINCT
					vtiger_contactdetails.salutation, 
					vtiger_contactdetails.email, 
					vtiger_crmentityrel.relcrmid, 
					vtiger_contactdetails.firstname, 
					vtiger_contactdetails.lastname, 
					vtiger_account.accountname 
				FROM vtiger_contactdetails 
					INNER JOIN vtiger_contactscf on vtiger_contactscf.contactid = vtiger_contactdetails.contactid
					INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_contactdetails.contactid
					INNER JOIN vtiger_crmentityrel on vtiger_crmentityrel.relcrmid = vtiger_contactdetails.contactid
					LEFT OUTER JOIN vtiger_account 
						ON vtiger_contactdetails.accountid = vtiger_account.accountid
				WHERE vtiger_crmentityrel.crmid = '.$this->recordid.' 
					AND vtiger_crmentityrel.relcrmid = vtiger_contactdetails.contactid
					AND vtiger_contactdetails.contactid = vtiger_crmentity.crmid
					AND vtiger_crmentity.deleted = "0"
				';
			//2nd do it for leads
			$Leadquery = 'SELECT DISTINCT
					vtiger_leaddetails.salutation,
					vtiger_leaddetails.email AS email, 
					vtiger_crmentityrel.relcrmid, 
					vtiger_leaddetails.firstname, 
					vtiger_leaddetails.lastname
					FROM vtiger_leaddetails
					INNER JOIN vtiger_crmentityrel on vtiger_crmentityrel.relcrmid = vtiger_leaddetails.leadid
					INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_leaddetails.leadid
					WHERE vtiger_crmentityrel.crmid = '.$this->recordid.' 
					AND vtiger_crmentityrel.relcrmid = vtiger_leaddetails.leadid
					AND vtiger_leaddetails.leadid = vtiger_crmentity.crmid
					AND vtiger_crmentity.deleted = "0"
				';
		}
		else{
			//are there CRM contact entries which were modified (e.g. email address, name spelling etc.) since the last sync?
			//this query contains all CRM entries which were modified since the last sync
			//1st do it for contacts
			$Contactquery = 'SELECT DISTINCT vtiger_contactdetails.salutation, vtiger_contactdetails.email, vtiger_crmentityrel.relcrmid, vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_account.accountname, vtiger_crmentity.modifiedtime 
				FROM vtiger_contactdetails 
					INNER JOIN vtiger_contactscf on vtiger_contactscf.contactid = vtiger_contactdetails.contactid
					INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_contactdetails.contactid
					INNER JOIN vtiger_crmentityrel on vtiger_crmentityrel.relcrmid = vtiger_contactdetails.contactid
					LEFT OUTER JOIN vtiger_account 
						ON vtiger_contactdetails.accountid = vtiger_account.accountid
				WHERE vtiger_crmentityrel.crmid = '.$this->recordid.' 
					AND vtiger_crmentityrel.relcrmid = vtiger_contactdetails.contactid
					AND vtiger_contactdetails.contactid = vtiger_crmentity.crmid
					AND vtiger_crmentity.deleted = "0"
					AND vtiger_crmentity.modifiedtime BETWEEN "'.$lastListSyncDate.'" AND "'.$currentDate.'"
				';
			//2nd do it for leads
			$Leadquery = 'SELECT DISTINCT 
					vtiger_leaddetails.salutation,vtiger_leaddetails.email AS email, vtiger_crmentityrel.relcrmid, vtiger_leaddetails.firstname, vtiger_leaddetails.lastname, null, vtiger_crmentity.modifiedtime
					FROM vtiger_leaddetails
					INNER JOIN vtiger_crmentityrel on vtiger_crmentityrel.relcrmid = vtiger_leaddetails.leadid
					INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_leaddetails.leadid
					WHERE vtiger_crmentityrel.crmid = '.$this->recordid.' 
					AND vtiger_crmentityrel.relcrmid = vtiger_leaddetails.leadid
					AND vtiger_leaddetails.leadid = vtiger_crmentity.crmid
					AND vtiger_crmentity.deleted = "0"
					AND vtiger_crmentity.modifiedtime BETWEEN "'.$lastListSyncDate.'" AND "'.$currentDate.'"
				';
		}
		
		parent::writeLogEventText(getTranslatedString('LBL_CHECK_DATA', 'Mailchimp'));
		$batch = array();
		$result = $db->query($Contactquery);
		while($donnee = $db->fetch_row($result)) {
			// batch contains all contacts from CRM -- OR -- all contacts which had been modified since last synchronisation at the CRM
			$batch[] = array('RELID'=>$donnee['relcrmid'], 'SALUTATION'=>decode_html($donnee['salutation']) ,'EMAIL'=>$donnee['email'], 'FNAME'=>decode_html($donnee['firstname']), 'LNAME'=>decode_html($donnee['lastname']), 'COMPANY'=>decode_html($donnee['accountname']), 'GROUPINGS' => array(array('name'=>$this->campaignName, 'groups'=>'default')));
		}

		$result = $db->query($Leadquery);
		while($donnee = $db->fetch_row($result)) {
			// batch contains all contacts from CRM -- OR -- all contacts which had been modified since last synchronisation at the CRM
			$batch[] = array('RELID'=>$donnee['relcrmid'], 'SALUTATION'=>decode_html($donnee['salutation']) ,'EMAIL'=>$donnee['email'], 'FNAME'=>decode_html($donnee['firstname']), 'LNAME'=>decode_html($donnee['lastname']), 'COMPANY'=>decode_html($donnee['accountname']), 'GROUPINGS' => array(array('name'=>$this->campaignName, 'groups'=>'default')));
		}
		if ($fulltransfer == false) {
			// get the contact which had been added at the CRM since last synchronisation and add it to the batch
			parent::writeLogEventText(getTranslatedString('LBL_GET_ALL_LAST_SYNC', 'Mailchimp'));
			//1st do it for contacts
			$Contactquery = 'SELECT DISTINCT 
						vtiger_contactdetails.salutation, vtiger_crmentityrel.relcrmid, vtiger_contactdetails.email, vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_account.accountname
						FROM vtiger_contactdetails
						INNER JOIN vtiger_contactscf on vtiger_contactscf.contactid = vtiger_contactdetails.contactid
						INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_contactdetails.contactid
						INNER JOIN vtiger_crmentityrel on vtiger_crmentityrel.relcrmid = vtiger_contactdetails.contactid
						LEFT OUTER JOIN vtiger_account
							ON vtiger_contactdetails.accountid = vtiger_account.accountid
						WHERE vtiger_crmentityrel.crmid = '.$this->recordid.'
							AND vtiger_crmentityrel.relcrmid = vtiger_contactdetails.contactid
							AND vtiger_contactdetails.contactid = vtiger_crmentity.crmid
							AND vtiger_crmentity.deleted = "0"
							AND vtiger_crmentityrel.relcrmid NOT IN
								(SELECT relcrmid FROM vtiger_mailchimpsyncdiff WHERE vtiger_mailchimpsyncdiff.crmid = '.$this->recordid.')
						';
			//2nd do it for leads
			$Leadquery = 'SELECT DISTINCT 
							vtiger_leaddetails.salutation, vtiger_crmentityrel.relcrmid, vtiger_leaddetails.email AS email, vtiger_leaddetails.firstname as firstname, vtiger_leaddetails.lastname as lastname, null
							FROM vtiger_leaddetails
							INNER JOIN vtiger_crmentityrel on vtiger_crmentityrel.relcrmid = vtiger_leaddetails.leadid
							INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_leaddetails.leadid
							WHERE vtiger_crmentityrel.crmid = '.$this->recordid.' 
							AND vtiger_crmentityrel.relcrmid = vtiger_leaddetails.leadid
							AND vtiger_leaddetails.leadid = vtiger_crmentity.crmid
							AND vtiger_crmentity.deleted = "0"
							AND vtiger_crmentityrel.relcrmid NOT IN
								(SELECT relcrmid FROM vtiger_mailchimpsyncdiff WHERE vtiger_mailchimpsyncdiff.crmid = '.$this->recordid.')
						';

			$result2 = $db->query($Contactquery);
			while($donnee = $db->fetch_row($result2)) {
				$batch[] = array('RELID'=>$donnee['relcrmid'], 'SALUTATION'=>decode_html($donnee['salutation']), 'EMAIL'=>$donnee['email'], 'FNAME'=>decode_html($donnee['firstname']), 'LNAME'=>decode_html($donnee['lastname']), 'COMPANY'=>decode_html($donnee['accountname']), 'GROUPINGS' => array(array('name'=>$this->campaignName, 'groups'=>'default')));
			}
			$result2 = $db->query($Leadquery);
			while($donnee = $db->fetch_row($result2)) {
				$batch[] = array('RELID'=>$donnee['relcrmid'], 'SALUTATION'=>decode_html($donnee['salutation']), 'EMAIL'=>$donnee['email'], 'FNAME'=>decode_html($donnee['firstname']), 'LNAME'=>decode_html($donnee['lastname']), 'COMPANY'=>decode_html($donnee['accountname']), 'GROUPINGS' => array(array('name'=>$this->campaignName, 'groups'=>'default')));
			}
		}
$datei = fopen("test/batch.txt","a+");
fwrite($datei, print_r($batch, TRUE));
fclose($datei);
		/* We delete duplicates entries i.e. contacts and leads that have been updated and added since last synchronization */
		if(!empty($batch)){
			$batch = self::uniqueArray($batch);
		}
		/* Now we can transfer changed or new contacts and lead to MailChimp */
		if(sizeof($batch) != 0){
			parent::writeLogEventText(getTranslatedString('LBL_ADD_BATCH', 'Mailchimp'));
			parent::writeLogEventText(getTranslatedString('LBL_REMOVE_DUPLICATES', 'Mailchimp'));
			parent::writeLogEventText(getTranslatedString('LBL_SEND_MAILCHIMP', 'Mailchimp'));
			
			
			foreach ($batch as $key => $value_arr) {
				parent::writeLogEventText($value_arr['FNAME']." ".$value_arr['LNAME']." ".$value_arr['EMAIL'],'green','','','20');
			}
			//yes, send optin emails
			$optin = false;
			// yes, update currently subscribed users
			$up_exist = true;
			// no, add interest, don't replace
			$replace_int = false; 
			$vals = $this->mc_api->listBatchSubscribe($this->list_id,$batch,$optin, $up_exist, $replace_int);
			if ($this->mc_api->errorCode){
				parent::writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
				parent::writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$this->mc_api->errorCode,'red','','','20');
				parent::writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$this->mc_api->errorMessage,'red','','','20');
			} 
			else {
				parent::writeLogEventText(getTranslatedString('LBL_SUCCESS', 'Mailchimp').' '.$vals['add_count'],'','','','20');
				parent::writeLogEventText(getTranslatedString('LBL_ERRORS', 'Mailchimp').' '.$vals['error_count'],'','','','20');
				foreach($vals['errors'] as $val){
					parent::writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
					parent::writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$val['code'],'red','','','20');
					parent::writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$val['message'],'red','','','20');
				}
			}
		}
		// stop --- Step 1.2
	}
	protected function getSynchronizedCRMEntries($module){
		$db = PearDatabase::getInstance();
		//1st do it for contacts
		if ($module=='Contacts') {
		$CRMRelquery = 'SELECT DISTINCT
						vtiger_contactdetails.email, 
						vtiger_mailchimpsyncdiff.relcrmid
					FROM vtiger_mailchimpsyncdiff
						INNER JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_mailchimpsyncdiff.relcrmid
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_contactdetails.contactid
						LEFT OUTER JOIN vtiger_account 
							ON vtiger_contactdetails.accountid = vtiger_account.accountid
					WHERE vtiger_mailchimpsyncdiff.crmid = ? 
						AND vtiger_mailchimpsyncdiff.relcrmid = vtiger_contactdetails.contactid
						AND vtiger_contactdetails.contactid = vtiger_crmentity.crmid
						AND vtiger_crmentity.deleted = "0"
		';
		}
		else {
		//2nd or do it for leads
		$CRMRelquery = 'SELECT DISTINCT
						vtiger_leaddetails.email AS email, 
						vtiger_mailchimpsyncdiff.relcrmid
					FROM vtiger_mailchimpsyncdiff
						INNER JOIN vtiger_leaddetails ON vtiger_leaddetails.leadid = vtiger_mailchimpsyncdiff.relcrmid
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_leaddetails.leadid
					WHERE vtiger_mailchimpsyncdiff.crmid = ? 
						AND vtiger_mailchimpsyncdiff.relcrmid = vtiger_leaddetails.leadid
						AND vtiger_leaddetails.leadid = vtiger_crmentity.crmid
						AND vtiger_crmentity.deleted = "0"
					';
		}
		$Relqueryresult = $db->pquery($CRMRelquery,array($this->recordid));
		$numOfRows = $db->num_rows($Relqueryresult);
		$RelBatch = array();
		for($i=0; $i<$numOfRows; ++$i) {
			$email = $db->query_result($Relqueryresult,$i,'email');
			$relcrmid = $db->query_result($Relqueryresult,$i,'relcrmid');
			//all entries from the last sync
			$this->SynchronizedCRMEntries[$relcrmid]= strtolower ($email);
		}
	}

}

