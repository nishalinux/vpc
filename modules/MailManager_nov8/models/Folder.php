<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is: vtiger CRM Open source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class MailManager_Folder_Model {

	protected $mName;
	protected $mCount;
	protected $mUnreadCount;
	protected $mMails;
	protected $mPageCurrent;
	protected $mPageStart;
	protected $mPageEnd;
	protected $mPageLimit;

	public function __construct($name='') {
		$this->setName($name);
	}

	public function name($prefix='') {
		$endswith = false;
		if (!empty($prefix)) {
			$endswith = (strrpos($prefix, $this->mName) === strlen($prefix)-strlen($this->mName));
		}
		if ($endswith) {
			return $prefix;
		} else {
			return $prefix.$this->mName;
		}
	}
    
     public function isSentFolder() {
		$mailBoxModel = MailManager_Mailbox_Model::activeInstance();
        $folderName = $mailBoxModel->folder();
		if($this->mName == $folderName) {
			return true;
		}
		return false;
	}

	public function setName($name) {
		$this->mName = $name;
	}

	public function mails() {
		return $this->mMails;
	}

	public function setMails($mails) {
		$this->mMails = $mails;
	}
//manasa added this for mails with special chars avoid purpose
	public function getAttachnoid($uid,$name) {
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$result = $db->pquery("select va.attachmentsid as attachmentsid,vmm.orgname as name from vtiger_mailmanager_mailattachments as vmm left join vtiger_attachments as va  on
		vmm.attachid = va.attachmentsid	where vmm.muid=? and va.name=?",array($uid,$name));
		$count = $db->num_rows($result);
		return $db->query_result($result,$i,'name');
	}
	//manasa ended here

	public function setPaging($start, $end, $limit, $total, $current) {
		$this->mPageStart = intval($start);
		$this->mPageEnd = intval($end);
		$this->mPageLimit = intval($limit);
		$this->mCount = intval($total);
		$this->mPageCurrent = intval($current);
	}

	public function pageStart() {
		return $this->mPageStart;
	}

	public function pageEnd() {
		return $this->mPageEnd;
	}

	public function pageInfo() {
		$offset = 0;
		if($this->mPageCurrent != 0) {	// this is needed as set the start correctly
			$offset = 1;
		}
		$s = max(1, $this->mPageCurrent * $this->mPageLimit + $offset);

		$st = ($s==1)? 0 : $s-1;  // this is needed to set end page correctly

		$e = min($st + $this->mPageLimit, $this->mCount);
		$t = $this->mCount;
		return sprintf("%s - %s ".vtranslate('LBL_OF')." %s", $s, $e, $t);
	}

	public function pageCurrent($offset=0) {
		return $this->mPageCurrent + $offset;
	}

	public function hasNextPage() {
		return ($this->mPageStart > 1);
	}

	public function hasPrevPage() {
		return ($this->mPageStart != $this->mPageEnd) && ($this->mPageEnd < $this->mCount);
	}

	public function count() {
		return $this->mCount;
	}

	public function setCount($count) {
		$this->mCount = $count;
	}

	public function unreadCount() {
		return $this->mUnreadCount;
	}

	public function setUnreadCount($unreadCount) {
		$this->mUnreadCount = $unreadCount;
	}
}

?>