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

class Mailchimp_MailchimpSyncStep2_Action extends Mailchimp_MailChimpStepController_Action{

    function __construct() {
        parent::__construct();
	}
	
	public function process(Vtiger_Request $request) {
		self::syncUnsubscribedWithMailChimp();
		return;
	}
	
	/**
	* Function to delete from MailChimp contacts and accounts that have been deleted from the Mail Campaign at the CRM since the last synchronization
	*/
	/**
	* syncUnsubscribedWithMailChimp: Step 2
	* Function to delete from MailChimp contacts and leads that had been deleted at the CRM since the last synchronization 
	*/
	function syncUnsubscribedWithMailChimp(){
		$db = PearDatabase::getInstance();
		// get CRM entries that have been deleted since the last synchronization
		// we do that by comparing the content of vtiger_syncdiff with the content of vtiger_crmentityrel
		// everything which is in vtiger_syncdiff but not in vtiger_crmentityrel was removed since last syncronization
		$this->writeLogEventText(getTranslatedString('LBL_GET_REMOVE_MEMBER_LAST_SYNC', 'Mailchimp'));
		
		//1st do it for contacts
		$Contactquery = 'SELECT DISTINCT 
						vtiger_contactdetails.contactid, vtiger_contactdetails.email, vtiger_contactdetails.firstname, vtiger_contactdetails.lastname, vtiger_account.accountname 
						FROM vtiger_contactdetails
						INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_contactdetails.contactid
						INNER JOIN vtiger_mailchimpsyncdiff on vtiger_mailchimpsyncdiff.relcrmid = vtiger_contactdetails.contactid
						LEFT OUTER JOIN vtiger_account
							ON vtiger_contactdetails.contactid = vtiger_account.accountid
						WHERE vtiger_mailchimpsyncdiff.crmid  = '.$this->recordid.'
						AND vtiger_mailchimpsyncdiff.relcrmid = vtiger_contactdetails.contactid
						AND vtiger_mailchimpsyncdiff.relcrmid NOT IN (SELECT relcrmid FROM vtiger_crmentityrel WHERE vtiger_crmentityrel.crmid  = '.$this->recordid.' )
						';
		//2nd do it for leads
		$Leadquery = 'SELECT DISTINCT 
							vtiger_leaddetails.leadid, vtiger_leaddetails.email AS email, vtiger_leaddetails.firstname = null, vtiger_leaddetails.lastname = null, null
							FROM  vtiger_leaddetails
							INNER JOIN vtiger_crmentity on vtiger_crmentity.crmid = vtiger_leaddetails.leadid
							INNER JOIN vtiger_mailchimpsyncdiff on vtiger_mailchimpsyncdiff.relcrmid = vtiger_leaddetails.leadid
							WHERE vtiger_mailchimpsyncdiff.crmid = '.$this->recordid.'
								AND vtiger_mailchimpsyncdiff.relcrmid = vtiger_leaddetails.leadid
								AND vtiger_mailchimpsyncdiff.relcrmid NOT IN
									(SELECT relcrmid FROM vtiger_crmentityrel WHERE vtiger_crmentityrel.crmid = '.$this->recordid.' )
						';
		
		$result = $db->pquery($Contactquery,array());
		//We only get emails because it is a primary id for MailChimp, all we need to delete members from the MailChimp List
		while($donnee = $db->fetch_row($result)) {
			$emails_to_delete[] = $donnee['email'];
		}

		$result = $db->query($Leadquery);
		//We only get emails because it is a primary id for MailChimp, this is all we need to delete members from the MailChimp List
		while($donnee = $db->fetch_row($result)) {
			$emails_to_delete[] = $donnee['email'];
		}
		
		if(sizeof($emails_to_delete) != 0){
			// yes, we want members to be deleted, not unsubscribed
			$delete = true; 
			// no, don't send a goodbye email
			$bye = false; 
			// no, don't notify
			$notify = false; 
			
			$this->writeLogEventText(getTranslatedString('LBL_REMOVE_FROM_MAILCHIMP', 'Mailchimp'),'','','','20');
			foreach ($emails_to_delete as $arrkey => $emailaddress) {
				$this->writeLogEventText($emailaddress,'red','','','30');
			}
			//unsubscribe deleted contacts at Mailchimp
			$vals = $this->mc_api->listBatchUnsubscribe($this->list_id, $emails_to_delete, $delete, $bye, $notify);

			if ($this->mc_api->errorCode){
				$this->writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
				$this->writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$this->mc_api->errorCode,'','','','20');
				$this->writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$this->mc_api->errorMessage,'','','','20');
			} 
			else {
				$this->writeLogEventText(getTranslatedString('LBL_SUCCESS', 'Mailchimp').' '.$vals['success_count'],'','','','30');
				$this->writeLogEventText(getTranslatedString('LBL_ERRORS', 'Mailchimp').' '.$vals['error_count'],'','','','30');
				foreach($vals['errors'] as $val){
					$this->writeLogEventText("<br/>\t*".$val['email']. " failed",'red');
					$this->writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$val['code']);
					$this->writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$val['message']);
				}
			}
		}
		else {
			$this->writeLogEventText(getTranslatedString('LBL_CRM_NONE_DELETED', 'Mailchimp'),'','','','20');
		}
		return;

	}

}