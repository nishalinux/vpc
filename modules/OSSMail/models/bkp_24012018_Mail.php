<?php

/**
 * Mail Scanner bind email action 
 * @package YetiForce.models
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_Mail_Model extends Vtiger_Base_Model
{

	protected $mailAccount = [];
	protected $mailFolder = '';
	protected $accountOwner = false;
	protected $mailCrmId = false;
	protected $actionResult = [];

	public function setAccount($account)
	{
		$this->mailAccount = $account;
	}

	public function setFolder($folder)
	{
		$this->mailFolder = $folder;
	}

	public function addActionResult($type, $result)
	{
		global $log;
		$log->debug('addActionResult='.$result);
		$this->actionResult[$type] = $result;
	}

	public function getAccount()
	{
		return $this->mailAccount;
	}

	public function getFolder()
	{
		return $this->mailFolder;
	}

	public function getActionResult($action = false)
	{
		if ($action) {
			return $this->actionResult[$action];
		}
		return $this->actionResult;
	}

	public function getTypeEmail($returnText = false)
	{
		$account = $this->getAccount();
		$fromEmailUser = $this->findEmailUser($this->get('fromaddress'));
		$toEmailUser = $this->findEmailUser($this->get('toaddress'));
		$ccEmailUser = $this->findEmailUser($this->get('ccaddress'));
		$bccEmailUser = $this->findEmailUser($this->get('bccaddress'));
		$notFound = $toEmailUser['notFound'] + $ccEmailUser['notFound'] + $bccEmailUser['notFound'];
		$identities = OSSMailScanner_Record_Model::getIdentities($account['user_id']);
		$type = false;
		foreach ($identities as $identitie) {
			if ($identitie['email'] == $this->get('fromaddress')) {
				$type = true;
			}
		}
		if ($fromEmailUser['notFound'] == 0 && $notFound == 0) {
			$key = 2;
			$name = 'Internal';
		} elseif ($type) {
			$key = 0;
			$name = 'Sent';
		} else {
			$key = 1;
			$name = 'Received';
		}
		if ($returnText) {
			return $name;
		} else {
			return $key;
		}
	}

	public static function findEmailUser($emails)
	{
		$db = PearDatabase::getInstance();
		$return = [];
		$notFound = 0;
		if (!empty($emails)) {
			foreach (explode(',', $emails) as $email) {
				$result = $db->pquery('SELECT id FROM vtiger_users WHERE email1 = ? limit 1', [$email]);
				if ($db->getRowCount($result) > 0) {
					$return[] = $db->query_result($result, 0, 'id');
				} else {
					$notFound++;
				}
			}
		}
		return ['users' => $return, 'notFound' => $notFound];
	}

	public function getAccountOwner()
	{
		if ($this->accountOwner) {
			return $this->accountOwner;
		}
		$db = PearDatabase::getInstance();
		$account = $this->getAccount();
		$result = $db->pquery('SELECT crm_user_id FROM roundcube_users where user_id = ?', [$account['user_id']]);
		if ($db->getRowCount($result) > 0) {
		//$this->accountOwner = $db->getSingleValue($result);
		$this->accountOwner = $db->query_result($result, 0, 'crm_user_id');

		}
		return $this->accountOwner;
	}

	public function getMailCrmId()
	{
		if ($this->mailCrmId != false) {
			return $this->mailCrmId;
		}
		$db = PearDatabase::getInstance();
		$result = $db->pquery('SELECT ossmailviewid FROM vtiger_ossmailview where uid = ? AND rc_user = ? ', [$this->get('message_id'), $this->getAccountOwner()]);
		if ($db->getRowCount($result) > 0) {
			$this->mailCrmId = $db->getSingleValue($result);
		}
		return $this->mailCrmId;
	}

	public function setMailCrmId($id)
	{
		$this->mailCrmId = $id;
	}

	public function getEmail($name)
	{
		$header = $this->get('header');
		$text = $header->$name;
		$return = '';
		if (is_array($text)) {
			foreach ($text as $row) {
				if ($return != '') {
					$return.= ',';
				}
				$return.= $row->mailbox . '@' . $row->host;
			}
		}
		return $return;
	}

	public function findEmailAdress($field, $searchModule = false, $returnArray = true)
	{
		global $log;
		$log->debug('findEmailAdressssss');
		$log->debug('findEmailAdrefield='.print_r($field,true));
		$log->debug('findEmailAdrereturnArray='.print_r($returnArray,true));
		$db = PearDatabase::getInstance();
		$return = [];
		$emails = $this->get($field);
		$log->debug('findEmailAdreemails='.print_r($emails,true));
		$emailSearchList = OSSMailScanner_Record_Model::getEmailSearchList();
		$log->debug('findEmailAdreemailSearchList='.print_r($emailSearchList,true));
		if (empty($emails)) {
			return [];
			$log->debug('line167='.$emails);
		} elseif (strpos($emails, ',')) {
			$log->debug('line169='.print_r($emails,true));
			$emailsArray = explode(',', $emails);
		} else {
			$emailsArray[0] = $emails;
			$log->debug('line173='.print_r($emails,true));
		}
		if (!empty($emailSearchList)) {
			foreach ($emailSearchList as $field) {
				$enableFind = true;
				$row = explode('=', $field);
				$module = $row[2];
				if ($searchModule) {
					if ($searchModule != $module) {
						$enableFind = false;
					}
				}

				if ($enableFind) {
					require_once("modules/$module/$module.php");
					$instance = new $module();
					$table_index = $instance->table_index;
					foreach ($emailsArray as $email) {
						if (empty($email)) {
							continue;
						}
						$name = 'MSFindEmail_' . $module . '_' . $row[1];
						$cache = Vtiger_Cache::get($name, $email);
						if ($cache !== false) {
							if ($cache != 0) {
								$return = array_merge($return, $cache);
							}
						} else {
							$ids = [];
							$result = $db->pquery("SELECT $table_index FROM " . $row[0] . ' INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = ' . $row[0] . ".$table_index WHERE vtiger_crmentity.deleted = 0 AND " . $row[1] . ' = ? ', [$email]);
							while (($crmid = $db->getSingleValue($result)) !== false) {
								$ids[] = $crmid;
							}
							$return = array_merge($return, $ids);
							if (empty($ids)) {
								$ids = 0;
							}
							Vtiger_Cache::set($name, $email, $ids);
						}
					}
				}
			}
		}
		$log->debug('line216='.print_r($returnArray,true));
		if (!$returnArray) {
			return implode(',', $return);
			$log->debug('line219='.print_r($return,true));
		}
		$log->debug('line221='.print_r($return,true));
		return $return;
	}
}
