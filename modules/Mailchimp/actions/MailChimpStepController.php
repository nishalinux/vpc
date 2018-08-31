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

require_once('include/database/PearDatabase.php');
require_once('modules/Mailchimp/providers/MCAPI.class.php');
require_once('modules/Mailchimp/providers/webhooks.class.php');
require_once('modules/Mailchimp/actions/MailchimpSyncStep1.php');
require_once('modules/Mailchimp/actions/MailchimpSyncStep2.php');
require_once('modules/Mailchimp/actions/MailchimpSyncStep3.php');
require_once('modules/Mailchimp/actions/MailchimpSyncStep4.php');

require_once('modules/Contacts/Contacts.php');
require_once('modules/Leads/Leads.php');

class Mailchimp_MailChimpStepController_Action extends Vtiger_Action_Controller{
	public $log_text = array();

    public function __construct() {
	}
	
	public function initiateParam($request) {
			$this->apikey= Mailchimp_Module_Model::getApikey();
			$this->subscribertype= Mailchimp_Module_Model::getSubscriberType();
			$this->recordid=$request->get('record');
			$this->list_id=$request->get('list_id');
			$this->action=$request->get('action');
			$this->todo=$request->get('function');
			$this->groupslist=$request->get('groupslist');
			$this->group=$request->get('group');
			$this->campaignName = $this->getGroupName();
			$this->SynchronizedCRMEntries = array();
			$this->existingMailChimpEntries = array();
			$this->MCbatchinfoTotal = 0;
		}
	protected function initiateApi() {
			$this->mc_api = new MCAPI($this->apikey);
			$this->webhooks = new Webhooks($this->mc_api);
		}
		
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());

		if(!$permission) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}
 
	public function process(Vtiger_Request $request) {
		try {
			global $adb;
			$result = array();
			$response = new Vtiger_Response();
			$existkey = self::checkApiKey();
			if ($existkey == false) {
				$response->setResult(json_encode('FAILURE'));
				$response->emit();
				return;
			};
			self::initiateParam($request);
			self::initiateApi();
			$module_nameurl = $request->get('module_nameurl');
			$module_name = strtolower($module_nameurl);
			if($this->todo=='MailchimpSyncStep1') {
				$this->writeLogEventText('<p></p>');
				$this->writeLogEventText(getTranslatedString('LBL_WORK_CRM', 'Mailchimp'),'','1','B');
				$this->writeLogEventText('');
				$this->writeLogEventText(getTranslatedString('LBL_CAMPAIGN', 'Mailchimp').' <b>'.$this->campaignName.'</b>');
				Mailchimp_MailchimpSyncStep1_Action::process($request);
				$response->setResult(json_encode($this->log_text));
				$response->emit();
				return;
			}
			if($this->todo == 'MailchimpSyncStep2') {
				Mailchimp_MailchimpSyncStep2_Action::process($request);
				$response->setResult(json_encode($this->log_text));
				$response->emit();
				return;
			}

			if($this->todo == 'MailchimpSyncStep3') {
				//self::getMailchimpListMembers('updated');
				Mailchimp_MailchimpSyncStep3_Action::process($request);
				$response->setResult(json_encode($this->log_text));
				$response->emit();
				return;
			}

			if($this->todo == 'MailchimpSyncStep4') {
				//self::setLastGroupSyncDate();
				Mailchimp_MailchimpSyncStep4_Action::process($request);
				$response->setResult(json_encode($this->log_text));
				$response->emit();
				return;
			}

		} 
		catch (Exception $ex) {
			echo $ex->getMessage();
			$response->setResult( $ex->getMessage());
			$response->emit();
		}

   }
 	protected function checkApiKey() {
		$apikey = Mailchimp_Module_Model::getApikey();
		if (trim($apikey =='')){
			return false;
		}
		else {
			$this->apikey= Mailchimp_Module_Model::getApikey();
			return true;
		}
	}
  
	protected function writeLogEventText($logstring,$color='',$size='',$bold='',$margin='') {
		$style ='';
		if (!empty($color)) {
			$style = 'color:'.$color.';';
		}
		if (!empty($size)) {
			$style .= 'font-size:'.$size.'rem;';
		}
		else {
			$style .= 'font-size:0.8rem;';
		}
		if (!empty($bold)) {
			$style .= 'font-weight:bold;';
		}
		if (!empty($margin)) {
			$style .= 'margin:'.$margin.'px; margin-top:0; margin-bottom:0;';
		}
		else {
			$style .= 'margin:0px; margin-top:1; margin-bottom:1;';
		}
		$logtext =  array (
		  'text' => $logstring,
		  'style' => $style
		);
		array_push($this->log_text, $logtext);
	}
   
	/**
	* Get the Mail Campaign name because it is used to match the Mail Campaign to the MailChimp list 
	*/
	protected function getGroupName(){
		$db = PearDatabase::getInstance();
		$result = $db->pquery("select mailchimpname from vtiger_mailchimp where vtiger_mailchimp.mailchimpid = ?", array($this->recordid));
		$donnee = $db->fetch_row($result);
		return $donnee['mailchimpname'];
	}
	protected function getLastGroupSyncDate(){
		$db = PearDatabase::getInstance();
		$query = 'SELECT * FROM vtiger_mailchimp WHERE vtiger_mailchimp.mailchimpid = ?';
		$result = $db->pquery($query,array($this->recordid));
		while($donnee = $db->fetch_row($result)) {
			return $donnee['lastsynchronization'];
		}
	}
	protected function getLastListSyncDate(){
		$db = PearDatabase::getInstance();
		$query = 'SELECT lastsyncdate FROM vtiger_mailchimp_settings WHERE listid= ?';
		$result = $db->pquery($query,array($this->list_id));
		while($donnee = $db->fetch_row($result)) {
			return $donnee['lastsyncdate'];
		}
	}
	public function getNumberOfMailchimpEntries($list_id){
		$MCbatchinfo = $this->mc_api->listMembers($list_id, $status='subscribed', $since=NULL, $start=0, $limit=1 );
		if ($this->mc_api->errorCode){
			$this->writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
			$this->writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$this->mc_api->errorCode,'','','','20');
			$this->writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$this->mc_api->errorMessage,'','','','20');
			return 'ERROR';
		}
		else {
			return	$MCbatchinfo['total'];
		}
	}
	/**
	* Remove duplicates from a multidimensional array
	*/
	public function uniqueArray($sync_array) {
		$rslt_array = array();
		$known_email = array();
		foreach ($sync_array as $entry) {
			$email = $entry["EMAIL"];
			$bool = in_array($email, $known_email);
			if(!$bool){
				$rslt_array[] = $entry;
				$known_email[] = $entry["EMAIL"];
			}
		}
		return $rslt_array;
	}
	

	protected function getMailChimpEntries(){
		global $adb;
		// get all entries from Mailchimp
		// there is a limit for large data sets, the number of results to return - defaults to 100, upper limit set at 15000 - therefore we have to loop through the data
		// first get the total (limit 1)
		$MCtotal = self::getNumberOfMailchimpEntries($this->list_id);
		if ($MCtotal != 'ERROR'){
			$actualMCdata = array ();
			if ($MCtotal > 0) {
				$this->MCbatchinfoTotal = $MCtotal;
				//check whether we must loop
				if ($MCtotal > 100) {
					//calculate number of pages to loop
					$numlooppages = ceil($MCtotal / 100);
					for($k=0;$k < $numlooppages;$k++) {
						$MCbatchinfoLoop = $this->mc_api->listMembers($this->list_id, $status='subscribed', $since=NULL, $start=$k , $limit=100);
						if ($this->mc_api->errorCode){
							$this->writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
							$this->writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$this->mc_api->errorCode,'','','','20');
							$this->writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$this->mc_api->errorMessage,'','','','20');
						}
						else {
							$actualMCdata =array_merge($actualMCdata, $MCbatchinfoLoop['data']);
						}
					}

				}
				else {
					// get data without loop limit
					$MCbatchinfo = $this->mc_api->listMembers($this->list_id, $status='subscribed', $since=NULL, $start=0);
					if ($this->mc_api->errorCode){
						$this->writeLogEventText(getTranslatedString('LBL_BATCH_FAILED', 'Mailchimp'),'red');
						$this->writeLogEventText(getTranslatedString('LBL_ERROR_CODE', 'Mailchimp').' '.$this->mc_api->errorCode,'','','','20');
						$this->writeLogEventText(getTranslatedString('LBL_ERROR_MSG', 'Mailchimp').' '.$this->mc_api->errorMessage,'','','','20');
					}
					else {
						$actualMCdata = $MCbatchinfo['data'];
					}
				}
			}
			$this->existingMailChimpEntries = $actualMCdata;
		}
	}
	
}

?>