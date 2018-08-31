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

class Mailchimp_MailchimpSyncStep3_Action extends Mailchimp_MailChimpStepController_Action{

    function __construct() {
        parent::__construct();
	}
	
	public function process(Vtiger_Request $request) {
		self::getMailchimpListMembers('updated');
		return;
	}
	/**
	* getMailchimpListMembers: Step 3
	* Step 3.1 export list from MailChimp and get all contacts 
	* Step 3.2 extract the 'default' from this list and look up whether these contacts are already part of the CRM list 
	* Step 3.3 add contacts and leads that have been added to Mailchimp and which have a contact entry already in the CRM (set related list)
	* Step 3.4 create and add contacts and leads that have been added to Mailchimp and which do not have a contact entry in the CRM 
	* Step 3.5 list unsubscribed contacts 
	*/

	function getMailchimpListMembers($status, $dump = null){
		global $adb;
		$lastListSyncDate = self::getLastListSyncDate();
		
		if($lastListSyncDate=="") {
			//very first time synchronisation
			$lastListSyncDate="2000-01-01 00:00:00";
		}
		$adb = PearDatabase::getInstance();
		//self::getMailChimpEntries();

		//TODO: cache this for the second run
		$this->writeLogEventText('<p></p>');
		$this->writeLogEventText(getTranslatedString('LBL_WORK_MAILCHIMP', 'Mailchimp'),'','1','B');
		//start --- Step 3.1
		$urlprefix = explode("-", $this->apikey);;
		$urlprefix = $urlprefix[1];
		$url = 'http://'.$urlprefix.'.api.mailchimp.com/export/1.0/list?apikey='.$this->apikey.'&id='.$this->list_id;
		$this->writeLogEventText(getTranslatedString('LBL_MAILCHIMP_EXPORT_API', 'Mailchimp').' '.$url);
		
		$dump = ($dump) ? $dump : explode("\n", file_get_contents($url));
		$dumpcache = $dump;
		//stop --- Step 3.1
		
		//start --- Step 3.2
		//$keys are the list headlines form MailChimp
		$keys = json_decode(array_shift($dump));
		// we don't want to extra information at the end
		$key_count = count($keys) - 13; 
		//customer may rename list headers at Mailchimp, we have to use the Tag information for further reference
		$listinfos = $this->mc_api->listMergeVars($this->list_id);
		foreach ($listinfos  as $listkey => $list_array) {
			$keytags [$list_array['name']] = $list_array['tag'];
		}
			
		//get existing groups from MailChimp
		$listInterestGroupings = $this->mc_api->listInterestGroupings($this->list_id);
		
		$this->writeLogEventText(getTranslatedString('LBL_EXTRACING_ONLY_MEMBERS', 'Mailchimp'));
		
		// loop through every row in dump from Mailchimp
		foreach ($dump as $dumprow) { 
			$item = json_decode($dumprow);
			$buffer = array();
			$include_flag = false;
			// loop through each field in row and look up contacts which had been added in MC
			for ($i=0; $i<$key_count; $i++) { 
				$buffer[$keytags[$keys[$i]]] = $item[$i];
				//loop through groups
				foreach ($listInterestGroupings as $grouparray) {
					//if 'default' is set at MailChimp for a new contact entry, the new entry gets synchronized with CRM
					if ($grouparray['name'] == $this->campaignName){ 
						if ($item[$i] == "default") {
							$include_flag = true;
						}
					}
				}
			}
			$l_name = explode('@',$buffer['Email Address']);
			if ($include_flag==true) {
				// $data contains all contacts that had been added to Mailchimp since last group (!) synchronization date
				$data[] = array('SALUTATION'=>$buffer['SALUTATION'], 'EMAIL'=>$buffer['EMAIL'], 'FNAME'=>$buffer['FNAME'], 'LNAME'=>$buffer['LNAME']?$buffer['LNAME']:$l_name[0], 'COMPANY'=>$buffer['COMPANY']);
			}
		}
	
		//stop --- Step 3.2
		$this->writeLogEventText(getTranslatedString('LBL_RETURNED_MEMBER', 'Mailchimp').' '.count($data),'','','B','');

		//start --- Step 3.3 and Step 4.4 in addContacts
		if($status == 'updated'){
			if(sizeof($data)!=0){
				$this->existingMailChimpEntries = $data;
				self::addContacts();
			}
		}
		//stop --- Step 3.3 and Step 4.4
		
		//start --- Step 3.5
		//get unsubscribed
		$this->writeLogEventText(getTranslatedString('LBL_CHECK_UNSUBSCRIBED', 'Mailchimp'));
		$filters=array ();
		$filters['id'] =  $this->list_id;
		$campaigns = $this->mc_api->campaigns($filters);
		$campaignID = $campaigns['data'][0]['id'];
		$unsubscribed = $this->mc_api->campaignUnsubscribes($campaignID);

		if ($this->mc_api->errorCode){
		    if ($this->mc_api->errorCode == 301) {
				//list was never used for a mailing from Mailchimp
				$this->writeLogEventText(getTranslatedString('LBL_NO_UNSUBSCRIBED', 'Mailchimp'),'','','','20');
			}
			else {
				$this->writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
				$this->writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$this->mc_api->errorCode,'','','','20');
				$this->writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$this->mc_api->errorMessage,'','','','20');
			}
		}
		else {
			if ($unsubscribed['total'] == 0 ){
				$this->writeLogEventText(getTranslatedString('LBL_NO_UNSUBSCRIBED', 'Mailchimp'),'','','','20');
			}
			else {
				$this->writeLogEventText(getTranslatedString('LBL_LIST_UNSUBSCRIBED', 'Mailchimp'));
				foreach ($unsubscribed['data'] as $unsub_key => $unsub_value) {
					$reason = $unsub_value['reason_text'];
					if (trim($reason) =='') {
						$reasonshow = getTranslatedString('LBL_NO_REASON_UNSUBSCRIBED', 'Mailchimp');
					}
					else {
						$reasonshow = $reason;
					}
					$this->writeLogEventText($unsub_value['email']."  (".getTranslatedString('LBL_REASON_UNSUBSCRIBED', 'Mailchimp')." ".$reasonshow);
				}
			}


		}
		//stop --- Step 3.5
	}

	protected function addContacts(){
		$db = PearDatabase::getInstance();
		$emails_in_CRM = array();
		$emails_in_Mailchimp = array();
		
		$this->writeLogEventText(getTranslatedString('LBL_START_ADD_CONTACTS', 'Mailchimp'));
		$tabid = getTabid('Contacts');
			$sql1 = "select fieldname,columnname from vtiger_field where tabid=? and vtiger_field.presence in (0,2)";
			$params1 = array($tabid);
		$result1 = $db->pquery($sql1, $params1);
		// get the contact fields
		for($i=0;$i < $db->num_rows($result1);$i++) {
			$field_list_Contacts[] = $db->query_result($result1,$i,'fieldname');
		}
		$tabid = getTabid('Leads');
			$sql1 = "select fieldname,columnname from vtiger_field where tabid=? and vtiger_field.presence in (0,2)";
			$params1 = array($tabid);
		$result1 = $db->pquery($sql1, $params1);
		// get the leads fields
		for($i=0;$i < $db->num_rows($result1);$i++) {
			$field_list_Leads[] = $db->query_result($result1,$i,'fieldname');
		}

		// Step1: Check whether for each email address in Mailchimp a CRM entry exists
		foreach($this->existingMailChimpEntries as $member){
			$string_email .= '"'.$member['EMAIL'].'",';
			$emails_in_Mailchimp[] = strtolower($member['EMAIL']);
		}
		$string_email = rtrim($string_email, ",");
		
		$this->writeLogEventText(getTranslatedString('LBL_CHECK_EMAIL_EXIST', 'Mailchimp'),'','','','20');

		$query = 'SELECT vtiger_crmentity.setype as type, vtiger_crmentity.crmid as id, vtiger_contactdetails.email as cemail, vtiger_leaddetails.email as lemail
					FROM vtiger_crmentity 
					left JOIN vtiger_contactdetails on vtiger_crmentity.crmid = vtiger_contactdetails.contactid
					left JOIN vtiger_leaddetails on vtiger_crmentity.crmid = vtiger_leaddetails.leadid
					WHERE vtiger_crmentity.deleted = "0"
					AND (vtiger_contactdetails.email IN ('.$string_email.') OR vtiger_leaddetails.email  IN ('.$string_email.'))';
		$result = $db->pquery($query,array());
		if (!$result) {
			return false;
		}
		// make a list of contacts or leads email addresses to add
		$subcribe_to_mailcampaign = array();
		while($donnee = $db->fetch_row($result)){
			//get contact related email addresses
			if (!empty($donnee['cemail'])) {
				$emails_in_CRM[] = strtolower($donnee['cemail']);
			}
			//get lead related email addresses
			elseif (!empty($donnee['lemail'])) {
				$emails_in_CRM[] = strtolower($donnee['lemail']);
			}
			$emails_in_CRM = array_unique($emails_in_CRM);
			// If the email is in the CRM database, but is not subscribed to the Mail Campaign, we need to add the matching contact/lead to the Mailchimp Group at the CRM
			if(!empty($donnee['cemail'])){
				$subcribe_to_mailcampaign[] = array('type' => $donnee['type'], 'id' => $donnee['id'], 'email' => $donnee['cemail']);
			}
			if(!empty($donnee['lemail'])){
				$subcribe_to_mailcampaign[] = array('type' => $donnee['type'], 'id' => $donnee['id'], 'email' => $donnee['lemail']);
			}
		}

		// We add the leads/contact to the Mailchimp Group at the CRM by setting the the related list, if relation does not exist already
		if(!empty($subcribe_to_mailcampaign)){
			$counter = 0;
			$LogWriter = false;
			$num_of_entries = count($subcribe_to_mailcampaign);
			$this->writeLogEventText(getTranslatedString('LBL_LATE_ADD_RELATION', 'Mailchimp'),'','','','20');
			foreach($subcribe_to_mailcampaign as $members){
				// first make sure that an entity with this email address does already exist on this list (in case two or more entities share the same email address)
				$verify_query = "SELECT vtiger_crmentityrel.crmid FROM vtiger_crmentityrel
							LEFT JOIN vtiger_contactdetails ON vtiger_contactdetails.contactid = vtiger_crmentityrel.relcrmid
							LEFT JOIN vtiger_leaddetails ON vtiger_leaddetails.leadid = vtiger_crmentityrel.relcrmid
							inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_crmentityrel.relcrmid
							WHERE vtiger_crmentityrel.crmid = ? AND vtiger_crmentityrel.module = 'Mailchimp' and vtiger_crmentity.deleted = 0 
							AND (vtiger_contactdetails.email = ? OR vtiger_leaddetails.email = ?) group by crmid";
				$entityExistsResult = $db->pquery($verify_query, array($this->recordid,$members['email'],$members['email']));
				$entityData ='';
				while($donnee = $db->fetch_row($entityExistsResult)) {
					$entityData = $donnee['crmid'];
				}
				if ($entityData) { 
					$counter = $counter +1;
					continue;
				}
				$query2 = "INSERT INTO vtiger_crmentityrel VALUES ('".$this->recordid."',  'Mailchimp',  '".$members['id']."',  '".$members['type']."')";
				$db->query($query2);
				if ($LogWriter == false) {
					$this->writeLogEventText(getTranslatedString('LBL_MS_ADD', 'Mailchimp'),'','','','20');
					$LogWriter = true;
				}
				$this->writeLogEventText($members['email'],'green','','','30');
			}
			if ($counter == $num_of_entries) {
				$this->writeLogEventText(getTranslatedString('LBL_NO_MS_ADD', 'Mailchimp'),'','','','30');
			}
		}
		else {
			$this->writeLogEventText(getTranslatedString('LBL_NO_MS_ADD', 'Mailchimp'),'','','','20');
		}
		
		// Step 2: now we check whether contacts or leads must get created at the CRM
		$emails_to_add = array_diff($emails_in_Mailchimp, $emails_in_CRM);
		if(!empty($emails_to_add)){	
			/* We create a contact or lead (based on subscriber type) for each email that is not in the database, and we add this contact or lead to the Mail Campaign*/
			$query_string = '';
			$this->writeLogEventText(getTranslatedString('LBL_CHECK_EMAIL_LIST_AND_ADD', 'Mailchimp'),'','','','20');
			foreach($this->existingMailChimpEntries as $batchmember){
				if(in_array($batchmember['EMAIL'], $emails_to_add)){
					$first_name = decode_html($batchmember['FNAME']);
					$last_name = (is_array($batchmember['LNAME'])) ? implode(' ', decode_html($batchmember['LNAME'])) : decode_html($batchmember['LNAME']);
					$email_address = $batchmember['EMAIL'];
					$company = decode_html($batchmember['COMPANY']);
					$salutationtype = decode_html($batchmember['SALUTATION']);

					$this->writeLogEventText($first_name." ".$last_name." ".$email_address,'green','','','30');

					// If the email is related to a company, either we create an account for this contact, or we assign the existing account to the new contact, using the account's id
					if($company != ''){
						$account_id = self::retrieve_account_id($company, $user_id);
					}
					// add to data base
					// todo: check user permission to decide whether subscriber should be added as contact or lead
					if ($this->subscribertype == 'contact') { 
						$contact = new Contacts();
						$contact->column_fields['salutationtype']=in_array('salutationtype',$field_list_Contacts) ? $salutationtype : "";
						$contact->column_fields['firstname']=in_array('firstname',$field_list_Contacts) ? $first_name : "";
						$contact->column_fields['lastname']=in_array('lastname',$field_list_Contacts) ? $last_name : "";	
						$contact->column_fields['email']=in_array('email',$field_list_Contacts) ? $email_address : "";
						$contact->column_fields['account_id']=in_array('account_id',$field_list_Contacts) ? $account_id : "";
						$contact->column_fields['assigned_user_id']=in_array('assigned_user_id',$field_list_Contacts) ? $user_id : "";
						$contact->save("Contacts");
						$id = $contact->id;
					}
					else {
						$lead = new Leads();
						$lead->column_fields['firstname']=in_array('firstname',$field_list_Leads) ? $first_name : "";
						$lead->column_fields['lastname']=in_array('lastname',$field_list_Leads) ? $last_name : "";	
						$lead->column_fields['email']=in_array('email',$field_list_Leads) ? $email_address : "";
						$lead->column_fields['company']=in_array('company',$field_list_Leads) ? $company : "";
						$lead->column_fields['assigned_user_id']=in_array('assigned_user_id',$field_list_Leads) ? $user_id : "";
						$lead->save("Leads");
						$id = $lead->id;
					}
					
					// make sure that the new entry isn't already in the relation table
					$tempsql = "SELECT relcrmid FROM vtiger_crmentityrel WHERE crmid = ? AND relcrmid = ?";
					$tempresult = $db->pquery($tempsql,array($this->recordid,$id));
					$relation_exists = false;
					if ($tempresult) {
						while($mailcheck = $db->fetch_row($tempresult)){
							$relation_exists = $mailcheck;
						}
					}

					if (!$relation_exists) {
						//make a new related list entry
						if ($this->subscribertype == 'contact') {
							$rel_query = "INSERT INTO vtiger_crmentityrel VALUES (?,'Mailchimp',?,'Contacts')";
						}
						else {
							$rel_query = "INSERT INTO vtiger_crmentityrel VALUES (?,'Mailchimp',?,'Leads')";
						}
						$db->pquery($rel_query,array($this->recordid,$id));
					}
				}
			}
		}		
	}
	
	function retrieve_account_id($account_name,$user_id) {
		if(empty($account_name)) {
			return null;
		}
		$db = PearDatabase::getInstance();
		$query = "select vtiger_account.accountname accountname,vtiger_account.accountid accountid from vtiger_account inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_account.accountid where vtiger_crmentity.deleted=0 and vtiger_account.accountname=?";
		$result=  $db->pquery($query, array($account_name));

		$rows_count =  $db->getRowCount($result);
		if($rows_count==0) {
			require_once('modules/Accounts/Accounts.php');
			$account = new Accounts();
			$account->column_fields[accountname] = $account_name;
			$account->column_fields[assigned_user_id]=$user_id;
			$account->save("Accounts");
			return $account->id;
		}
		else if ($rows_count==1) {
			$row = $db->fetchByAssoc($result, 0);
			return $row["accountid"];
		}
		else {
			$row = $db->fetchByAssoc($result, 0);
			return $row["accountid"];
		}

	}
	
	

}