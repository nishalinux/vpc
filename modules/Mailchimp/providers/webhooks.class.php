<?php

global $adb;
//require_once('vtlib/Utils/Utils.php');


/*
 * Webhooks
 * 
 * Manages Mailchimp Webhooks and dispatches POST requests sent by Mailchimp Lists
 * 
 */
class Webhooks {
    
    public $api;
    
    // api dependency injection
    public function __construct($api) {  
        
        if(get_class($api) == 'MCAPI'){
            $this->api = $api;
        } else {
            Throw New Exception('Valid Mailchimp API not passed');
        }
    }  
    
    public function requestLog($stringData){

        $myFile = "../../modules/Mailchimp/log.txt";
        $fh = fopen($myFile, 'a') or die("can't open file");
        fwrite($fh,date("Y-m-d H:i:s").' '.$stringData . PHP_EOL);
        fclose($fh);
        return true;
    }
    
    public function dispatch($postData){
    	
    	global $adb;
    	$query = "INSERT INTO vtiger_mailchimp_webhook_logs (data) VALUES ('".addslashes($postData)."')";
        //$result = $adb->query($query);
    	
        switch ($postData['type']){
            case 'subscribe':
                $this->_subscribe($postData);
            break;
            
            case 'unsubscribe':
                $this->_unsubscribe($postData);
            break;
            
            case 'campaign':
                $this->_updateRelatedEmails($postData);
                
            case 'profile':
                $this->_updateNames($postData);
            
            default:
                
            break; 
        }
    }
    
    public function updateWebhook($vtigerCampaignId, $MailChimpListId){
        
        $webhookUrl = $this->getWebhookUrl();
        
        if($this->api->listWebhookAdd($MailChimpListId, $webhookUrl)){
            return true;
        } else {     
            return false;
        }
    }
        
    private function getWebhookURL(){
        global $site_URL;
        return $site_URL.'/modules/Mailchimp/Webhooks.php';
    }
    
    private function getVtigerCampaignName($id){
        global $adb;
        $sql = "SELECT mailchimpname FROM vtiger_mailchimp WHERE mailchimpid = $id";
        $result = $adb->pquery($sql, Array());
        return $result->fields['mailchimpname'];
    }
    
    
    protected function getVtigerCampaignId($list_id){
        
        global $adb;
        $lists = $this->api->lists(array('list_id'=>$list_id));
        
        
        
        $list = $lists['data'][0];
        $list_name = $list['name'];
       
        
        $sql = "SELECT mailchimpid FROM vtiger_mailchimp WHERE mailchimpname = '$list_name'";
        $result = $adb->pquery($sql, Array());
        return $result->fields['mailchimpid'];
    }
    
    protected function _updateRelatedEmails($info){
        
        $data = $info['data'];
        
        $list_id = $data['list_id'];
        $subject = $data['subject'];
        $status = $data['status'];
        $campaign_id = $data['id'];
     
        $vtigerCampaignId = $this->getVtigerCampaignId($list_id);
     
        $emailContent = $this->api->campaignContent($campaign_id);
       
        $campaignMembers = $this->api->campaignMembers($campaign_id);
        
        $campaignMembersData = $campaignMembers['data'];
        
        foreach($campaignMembersData as $member){
            $this->attachEmailContent($member, $subject, $emailContent);
        }
    }
   
    protected function attachEmailContent($member,$subject,$emailContent,$status = NULL){
    	
        global $adb;
        
        $htmlContent = addslashes($emailContent['html']);
        $email = $member['email'];
        $status = $member['status'];
        
        $ubject = addslashes($subject);
        
        //$sql = "SELECT contactid FROM vtiger_contactdetails WHERE email = '$email'";
        
        // get entity id
    	$sql = "SELECT contactid as id FROM vtiger_contactdetails WHERE email = '$email'
				UNION SELECT leadid as id FROM vtiger_leaddetails WHERE email = '$email'
				UNION SELECT accountid as id FROM vtiger_account WHERE email1 = '$email'";
    	
    	//echo preg_replace("/\t/", "", $query);
        
        $result = $adb->query($sql);
        
        $contact_id = $result->fields['id'];
        
        $current_id = $adb->getUniqueID("vtiger_crmentity");
        
        $adb->startTransaction();
        
        $sql = "INSERT INTO vtiger_crmentity 
               (crmid,smcreatorid,smownerid,modifiedby,setype,description,createdtime,modifiedtime,version,presence,deleted)
                VALUES($current_id,1,1,0,'Emails','$htmlContent',NOW(),NOW(),0,1,0)";
        
        $adb->pquery($sql, Array());
        
        $sql = "INSERT INTO vtiger_activity
               (activityid,subject,semodule,activitytype,date_start,due_date,sendnotification,notime,visibility)
               VALUES($current_id,'$subject','Contacts','Emails',NOW(),NULL,0,0,'all')";
        
        $adb->pquery($sql, Array());
        
        $sql = "INSERT INTO vtiger_seactivityrel (crmid, activityid) VALUES ($contact_id, $current_id)";
        
        $adb->pquery($sql, Array());
        
        $adb->completeTransaction();
        
    }
    
    protected function _subscribe($data){
 
    }
    
    protected function _unsubscribe($data){
    	
    	global $adb;
    	
    	//$sql = "SELECT contactid FROM vtiger_contactdetails WHERE email = '{$data['data']['email']}'";
    	
    	// get entity ids
    	$sql = "SELECT contactid as id FROM vtiger_contactdetails WHERE email = '{$data['data']['email']}'
				  UNION SELECT leadid as id FROM vtiger_leaddetails WHERE email = '{$data['data']['email']}'
				  UNION SELECT accountid as id FROM vtiger_account WHERE email1 = '{$data['data']['email']}'";
    	
    	$query = "INSERT INTO vtiger_mailchimp_webhook_logs (data) VALUES ('".addslashes($sql)."')";
	    //$adb->query($query);
        
        $result = $adb->query($sql);
        
        //$contact_id = $result->fields['id'];
        
        while($donnee = $adb->fetch_row($result)) {
        	
        	ob_start();
        	print_r($donnee);
        	$buffer = addslashes(ob_get_flush());
        
	        // now that we are only synchronising with one list, if a user unsubscribes, we remove them from ALL VT MC campaigns
	        
	        $sql = "DELETE FROM vtiger_crmentityrel WHERE module LIKE '%ailchimp' AND relcrmid = ".$donnee['id'];
	        $adb->query($sql);
	        
	        $query = "INSERT INTO vtiger_mailchimp_webhook_logs (data) VALUES ('".addslashes($sql)."')";
	        //$adb->query($query);
	        
	        $sql = "DELETE FROM vtiger_mailchimpsyncdiff WHERE module LIKE '%ailchimp' AND relcrmid = ".$donnee['id'];
	        $adb->query($sql);
	        
	        $query = "INSERT INTO vtiger_mailchimp_webhook_logs (data) VALUES ('".addslashes($sql)."')";
	        //$adb->query($query);
	        
        }
        
    }
    
    function _updateNames($data) {
    	
    	global $adb;
        
        ob_start();
        
        print_r($data);
        
    	$firstname = $data['data']['merges']['FNAME'];
    	$lastname = $data['data']['merges']['LNAME'];
    	$email = $data['data']['merges']['EMAIL'];
    	
    	$groups = $data['data']['merges']['GROUPINGS'];
    	
    	
    	// First update the names ...
    	
    	$sql = "UPDATE vtiger_contactdetails SET firstname = '$firstname', lastname = '$lastname' WHERE email = '$email'";
    	$result = $adb->query($sql);
    	$sql = "UPDATE vtiger_leaddetails SET firstname = '$firstname', lastname = '$lastname' WHERE email = '$email'";
    	$result = $adb->query($sql);
    	$sql = "UPDATE vtiger_account SET accountname = '$firstname' WHERE email1 = '$email'";
    	$result = $adb->query($sql);
    	
    	
    	$include_groupIds = $remove_groupIds = array();
    	
    	// get groups ids
    	foreach ($groups as $grp) {
    		$sql = "SELECT mailchimpid FROM vtiger_mailchimp WHERE mailchimpname = '{$grp['name']}'";
    		$result = $adb->query($sql);
    		
        	if ($result && strlen($result->fields['mailchimpid']) > 0) {
        		if ($grp['groups'] == 'default') $include_groupIds[] = $result->fields['mailchimpid'];
        		else $remove_groupIds[] = $result->fields['mailchimpid'];
        	}
    	}
    	
    	ini_set("display_errors", 1);
    	
    	echo "groups subscriber is in: \n";
    	print_r($include_groupIds);
    	echo "groups subscriber is NOT in: \n";
    	print_r($remove_groupIds);
    	
    	// get entity id
    	$query = "SELECT contactid as id FROM vtiger_contactdetails WHERE email = '$email'
				  UNION SELECT leadid as id FROM vtiger_leaddetails WHERE email = '$email'
				  UNION SELECT accountid as id FROM vtiger_account WHERE email1 = '$email'";
    	
    	echo preg_replace("/\t/", "", $query);
		
		$returned = $adb->query($query);
		
		if ($returned) {
			while($row = $adb->fetch_row($returned)) {
				$entityId= $row['id'];
			}
		}
		
		
		//echo $entityId."\n";
		
		// remove from groups
        $sql = "DELETE FROM vtiger_crmentityrel WHERE relcrmid = $entityId";
        $result = $adb->query($sql);
        
        echo $sql."\n";
        
        // re-add groups
        foreach ($include_groupIds as $grp) {
        	$sql = "INSERT INTO vtiger_crmentityrel (crmid, module, relcrmid) VALUES ($grp, 'mailchimp', $entityId)";
        	echo $sql."\n";
        	$result = $adb->query($sql);
        }
        
    	// re-remove groups
        foreach ($remove_groupIds as $grp) {
        	$sql = "DELETE FROM vtiger_crmentityrel WHERE crmid = $grp AND relcrmid = $entityId";
        	echo $sql."\n";
        	$result = $adb->query($sql);
        }
        
        
        $buffer = addslashes(ob_get_flush());
        
        $sql = "INSERT INTO vtiger_mailchimp_webhook_logs (data) VALUES ('$buffer')";
        //$result = $adb->query($sql);
        
        // Below is the start of a more convoluted and more robust method of updating groups . . .
        
        
        // This comes into effect if a user adds / removes an entity on vTiger but doesn't perform a sychronization
        // meanwhile the subscriber updates their profile on Mailchimp, in which case the user's preferences will overwrite the changes that have yet to be synched
        // is this a bug or a policy?
        
        // if a group exists in the Mailchimp merges, that does not exist in the syncdiff table add user to this group
        // if a group does NOT exist in the mailchimp merges, but DOES exist in the syncdiff table, remove from this VT MC campaign
        // if a group exists in the vtiger_crmentityrel table but does NOT exist in the syncdiff table, add user to this group
        // if a group exists in the syncdiff table but does NOT exist in the vtiger_crmentityrel table, remove from this group
           
    }
  
}


?>

