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

class Mailchimp_MailchimpSyncStep4_Action extends Mailchimp_MailChimpStepController_Action{

    function __construct() {
        parent::__construct();
	}
	
	public function process(Vtiger_Request $request) {
		self::setLastGroupSyncDate();
		self::updateInternalRecords();
		return;
	}
			
	/**
	* Set the last synchronization date 
	*/
	function setLastGroupSyncDate(){
		$db = PearDatabase::getInstance();
		$currentDateTime = date('Y-m-d H:i:s');
		$datequery = 'UPDATE vtiger_mailchimp SET vtiger_mailchimp.lastsynchronization = ?	WHERE vtiger_mailchimp.mailchimpid = ?';	
		$db->pquery($datequery, array($currentDateTime,$this->recordid ));
		$this->writeLogEventText(getTranslatedString('LBL_UPDATE_TIME_GROUP', 'Mailchimp'));

	}
	/**
	* Update the diff_table and the group sync date of the Mail Campaign at the end of the synchronization
	*/
	function updateInternalRecords(){

		$db = PearDatabase::getInstance();
		//delete all records for this Mailchimp group
		$del_query = 'DELETE FROM vtiger_mailchimpsyncdiff WHERE crmid= ?';
		$db->pquery($del_query,array($this->recordid));
		//add new entries
		$ins_query = 'INSERT INTO vtiger_mailchimpsyncdiff SELECT * FROM vtiger_crmentityrel WHERE vtiger_crmentityrel.crmid = ? and module= ?';
		$db->pquery($ins_query,array($this->recordid,'Mailchimp'));
	
		$currentDate = date('Y-m-d H:i:s');
		//create a settings entry for this list to hold the synchronization date
		$settingsresult = $db->query("SELECT * FROM vtiger_mailchimp_settings where listid ='".$this->list_id."'");
		$numOfRows = $db->num_rows($settingsresult);
		if ($numOfRows == 0) {
			//create a new group entry
			$settingsid = $db->getUniqueID('vtiger_mailchimp_settings');
			$db->query("insert into vtiger_mailchimp_settings values('".$settingsid."','".$this->apikey."','".$this->list_id."','".$this->subscribertype."','".$currentDate."')");
		}
		elseif ($numOfRows == 1) {
			//list ID was set
			$db->query("UPDATE vtiger_mailchimp_settings SET lastsyncdate = '".$currentDate."' where listid = '".$this->list_id."'");
		}
		else {
			//necessary for update of older crm-now module versions
			//delete existing entries
			$db->query("DELETE FROM vtiger_mailchimp_settings  WHERE listid = '".$this->list_id."'");
			//create a new group entry
			$settingsid = $db->getUniqueID('vtiger_mailchimp_settings');
			$db->query("insert into vtiger_mailchimp_settings values('".$settingsid."','".$this->apikey."','".$this->list_id."','".$this->subscribertype."','".$currentDate."')");
		}
		$this->writeLogEventText(getTranslatedString('LBL_UPDATE_DIFF', 'Mailchimp'),'','','B');
	
	}

}