<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_Vtiger_Phylos_Model extends Settings_Vtiger_Module_Model{

    const tableName = 'vtiger_phylosinfo';
	var $email ='';
	var $password = '';
	var $ubi = '';
	var $name = 'Phylos';
    public function getId() {
        return $this->get('id');
    }
	/**
	 * Function to get the instance of Settings module model
	 * @return Settings_Vtiger_Module_Model instance
	 */
	public static function getInstance($name='Settings:Phylos') {
		$modelClassName = 'Settings_Vtiger_Phylos_Model';// Vtiger_Loader::getComponentClassName('Model', 'Module', $name);
		return new $modelClassName();
	}
	/* public function isBiotrackLoginCheckDV() {
        $data = array(
			'API' => '4.0',
			'training' => '1',
			'action' => 'login');
		$biotrackdetails = $this->getInstanceBiotrackDetails();
		
		$data['password'] = $biotrackdetails['password'];
		$data['license_number'] = $biotrackdetails['ubi'];
		$data['username'] = $biotrackdetails['email'];
		$data_string = json_encode($data);
		$result = file_get_contents(
		'https://hicsts.hawaii.gov/serverjson.asp', null, stream_context_create(
		array(
			'http' => array(
					'method' => 'POST',
					'header' => 'Content-Type: text/JSON' . "\r\n"
					. 'Content-Length: ' . strlen($data_string) . "\r\n",
					'content' => $data_string
				),
		)));
		$json = json_decode($result, true);
		return $json;
    }
*/
    public function isPhylosLogin() {
		$opts = array(
		  'https'=>array(
			'method'=>"GET",
			'header'=>"Accept-language: en\r\n" .
					  "Cookie: foo=bar\r\n"
		  )
		);
		$context = stream_context_create($opts);
		$physolurl = 'https://testing.phylosbioscience.com/partner/api/v1/heartbeat?api_key='.$this->get('api_key');
		$result = file_get_contents($physolurl, null, $context);
		$phylosres = json_decode($result);
		if($phylosres->message == 'Looking good!'){
			return '1';
		}else{
			$message = 'Please Check API KEY';
			return array($message);
		}
		
    }

    public function save() {
        $db = PearDatabase::getInstance();
		$biores = $this->isPhylosLogin();
		if($biores != '1'){
			return $biores;
		}
        $id = $this->getId();
        $params = array();
        array_push($params, $this->get('email'),$this->get('api_key'));
        if(empty($id)) {
            $id = $db->getUniqueID(self::tableName);
            //To keep id in the beginning
            array_unshift($params, $id);
            $query = 'INSERT INTO '.self::tableName.' VALUES(?,?,?)';
        }else{
            $query = 'UPDATE '.self::tableName.' SET email = ?, api_key= ? WHERE id = ?';
            $params[] = $id;
        }
        $db->pquery($query,$params);
        return true;
    }

    public static function getInstancePhylosDetails() {
        $db = PearDatabase::getInstance();
        $query = 'SELECT * FROM '.self::tableName;
        $params = array();
        $result = $db->pquery($query,$params);
        $rowData = '';
        if($db->num_rows($result) > 0 ){
            $rowData = $db->query_result_rowdata($result,0);
		}
        return $rowData;
    }

}