<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
require __DIR__ . '/Twilio/autoload.php';
use Twilio\Rest\Client;
class SMSNotifier_Twilio_Provider implements SMSNotifier_ISMSProvider_Model {

	private $userName;
	private $password;
	private $parameters = array();
   

	//const SERVICE_URI = 'http://localhost:9898';
	const SERVICE_URI = 'http://localhost:9898';
	private static $REQUIRED_PARAMETERS = array('from_number');

	/**
	 * Function to get provider name
	 * @return <String> provider name
	 */
	public function getName() {
		return 'Twilio';
	}

	/**
	 * Function to get required parameters other than (userName, password)
	 * @return <array> required parameters list
	 */
	public function getRequiredParams() {
        global $log;
        $log->debug('getRequiredParams');
		return self::$REQUIRED_PARAMETERS;
	}

	/**
	 * Function to get service URL to use for a given type
	 * @param <String> $type like SEND, PING, QUERY
	 */
	public function getServiceURL($type = false) {
         global $log;
        $log->debug('getServiceURL');
		if($type) {
			switch(strtoupper($type)) {
				case self::SERVICE_AUTH: return  self::SERVICE_URI . '/http/auth';
				case self::SERVICE_SEND: return  self::SERVICE_URI . '/http/sendmsg';
				case self::SERVICE_QUERY: return self::SERVICE_URI . '/http/querymsg';
			}
		}
		return false;
	}

	/**
	 * Function to set authentication parameters
	 * @param <String> $userName
	 * @param <String> $password
	 */
	public function setAuthParameters($userName, $password) {
        global $log;
        $log->debug('setAuthParameters');
		$this->userName = $userName;
		$this->password = $password;
	}

	/**
	 * Function to set non-auth parameter.
	 * @param <String> $key
	 * @param <String> $value
	 */
	public function setParameter($key, $value) {
        global $log;
        $log->debug('setParameter');
		$this->parameters[$key] = $value;
	}

	/**
	 * Function to get parameter value
	 * @param <String> $key
	 * @param <String> $defaultValue
	 * @return <String> value/$default value
	 */
	public function getParameter($key, $defaultValue = false) {
        global $log;
        $log->debug('getParameter');
		if(isset($this->parameters[$key])) {
			return $this->parameters[$key];
		}
		return $defaultValue;
	}

	/**
	 * Function to prepare parameters
	 * @return <Array> parameters
	 */
	protected function prepareParameters() {
        global $log;
        $log->debug('prepareParameters');
		$params = array('user' => $this->userName, 'pwd' => $this->password);
		foreach (self::$REQUIRED_PARAMETERS as $key) {
			$params[$key] = $this->getParameter($key);
		}
		return $params;
	}

	/**
	 * Function to handle SMS Send operation
	 * @param <String> $message
	 * @param <Mixed> $toNumbers One or Array of numbers
	 */
	public function send($message, $toNumbers) {
        global $log;
        $log->debug('sendfunct');
		if(!is_array($toNumbers)) {
			$toNumbers = array($toNumbers);
		}

		$params = $this->prepareParameters();
		$params['text'] = $message;
		$from_number = $params['from_number'];
		$sid = $params['user'];
        $log->debug('username='.$sid);
		$token = $params['pwd'];
		
		$phoneFieldList=array_values(array_filter(array_unique($toNumbers)));
		
		$httpClient = new Twilio\Rest\Client($sid, $token);
		foreach($phoneFieldList as $fieldname) {
			if(!empty($fieldname)) {
				$toNumbers_now[] = $fieldname;
				$httpClient->messages->create(
					// Where to send a text message (your cell phone?)
				       $fieldname,
					array(
					    'from' => $from_number,
					    'body' => $message
					)
				);
			}
		}


	
       /* for($i=0; $i<$count_arr; $i++){
            
            $httpClient->messages->create(
                // Where to send a text message (your cell phone?)
               array($toNumbers[$i]),
                array(
                    'from' => $from_number,
                    'body' => $message
                )
            );
        }*/
        
        $result['status'] = $toNumbers_now;
        return $results;
  
	}

	/**
	 * Function to get query for status using messgae id
	 * @param <Number> $messageId
	 */
	public function query($messageId) {
        global $log;
        $log->debug('queryfunct');
		$params = $this->prepareParameters();
		$params['apimsgid'] = $messageId;

		$serviceURL = $this->getServiceURL(self::SERVICE_QUERY);
		$httpClient = new Vtiger_Net_Client($serviceURL);
		$response = $httpClient->doPost($params);
		$response = trim($response);

		$result = array( 'error' => false, 'needlookup' => 1 );

		if(preg_match("/ERR: (.*)/", $response, $matches)) {
			$result['error'] = true;
			$result['needlookup'] = 0;
			$result['statusmessage'] = $matches[0];
		} else if(preg_match("/ID: ([^ ]+) Status: ([^ ]+)/", $response, $matches)) {
			$result['id'] = trim($matches[1]);
			$status = trim($matches[2]);

			// Capture the status code as message by default.
			$result['statusmessage'] = "CODE: $status";
			if($status === '1') {
				$result['status'] = self::MSG_STATUS_PROCESSING;
			} else if($status === '2') {
				$result['status'] = self::MSG_STATUS_DISPATCHED;
				$result['needlookup'] = 0;
			}
		}
		return $result;
	}
}
?>
