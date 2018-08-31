<?php
/*+********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *******************************************************************************/

class OS2CheckList {

 	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
    /**
     * Delete a file or recursively delete a directory
     *
     * @param string $str Path to file or directory
     */

	 var $log;

     function __construct() {
		$this->copiedFiles = Array();
		$this->failedCopies = Array();
		$this->ignoredFiles = Array();
		$this->failedDirectories = Array();
		$this->savedFiles = Array();
		$this->log = LoggerManager::getLogger('account');
	}

 	function vtlib_handler($moduleName, $eventType)
	{
		require_once('include/utils/utils.php');
		require_once('include/utils/VtlibUtils.php');
		require_once('vtlib/Vtiger/Module.php');
		global $adb;

		if($eventType == 'module.postinstall')
		{
			#Write js file in file 
			#check if not Write js file in file 
			$file = 'layouts/vlayout/modules/Vtiger/Header.tpl';
			$searchfor = 'CkEditor';   
			header('Content-Type: text/plain'); 
			$contents = file_get_contents($file); 
			$pattern = preg_quote($searchfor, '/'); 
			$pattern = "/^.*$pattern.*$/m"; 
			if(preg_match_all($pattern, $contents, $matches)){  
			#no need to add (already exists )  
			}else{
			$old_c = file_get_contents($file, FILE_USE_INCLUDE_PATH); 
			$new_content = '
			<!------------------------------- OS2CheckList -------------------->
			<script type="text/javascript" src="libraries/jquery/ckeditor/ckeditor.js"></script>
			<script type="text/javascript" src="libraries/jquery/ckeditor/adapters/jquery.js"></script>';   
			file_put_contents("layouts/vlayout/modules/Vtiger/Header.tpl",$old_c.' '.$new_content);
			}
			
			$tabid = getTabid($moduleName);
			$fieldid = $adb->getUniqueID('vtiger_settings_field');
			$blockid = getSettingsBlockId('LBL_MODULE_MANAGER');
			
			$count = $adb->pquery("SELECT * FROM vtiger_settings_field WHERE name =?", array('OS2 Check List Item'));
			if ($adb->num_rows($count) == 0) {
				$fieldid = $adb->getUniqueID('vtiger_settings_field');
				$blockid = getSettingsBlockId('LBL_MODULE_MANAGER');
				
				$seq_res = $adb->query("SELECT max(sequence)+1 AS max_seq FROM vtiger_settings_field WHERE blockid = 1");
				$seq = 1;
				if ($adb->num_rows($seq_res) > 0) {
					$cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
					if ($cur_seq != null)	$seq = $cur_seq + 1;
				}
				$adb->pquery('INSERT INTO vtiger_settings_field(fieldid, blockid, name, iconpath, description, linkto, sequence,active, pinned)
					VALUES (?,?,?,?,?,?,?,?,?)', array($fieldid, 4, 'OS2 Check List Item', 'portal_icon.png', 'CheckList Items', 'index.php?module=OS2CheckList&parent=Settings&view=List', $seq, 0, 1));
					
				$adb->pquery("UPDATE vtiger_settings_field_seq SET id=?",array($fieldid));
			}
			
			$link_count = $adb->query("SELECT MAX(linkid) AS max_linkid FROM vtiger_links");
			$maxlinkid = $adb->query_result($link_count, 0, 'max_linkid');

			$maxlinkid++;
			$adb->pquery('INSERT INTO vtiger_links(linkid, tabid, linktype, linklabel, linkurl, linkicon, sequence, handler_path, handler_class, handler)
			VALUES (?,?,?,?,?,?,?,?,?,?)', array($maxlinkid, 0, 'HEADERSCRIPT', 'ClController', 'layouts/vlayout/modules/Settings/OS2CheckList/resources/ClController.js', '', '', '', '',''));	
			
			$maxlinkid++;
			$adb->pquery('INSERT INTO vtiger_links(linkid, tabid, linktype, linklabel, linkurl, linkicon, sequence, handler_path, handler_class, handler)
			VALUES (?,?,?,?,?,?,?,?,?,?)', array($maxlinkid, 7, 'DETAILVIEWSIDEBARWIDGET', 'OS2CheckList', 'module=OS2CheckList&parent=Settings&view=IndexAjax&mode=showCheckListLeads', '', '', '', '',''));	

			$maxlinkid++;
			$adb->pquery('INSERT INTO vtiger_links(linkid, tabid, linktype, linklabel, linkurl, linkicon, sequence, handler_path, handler_class, handler)
			VALUES (?,?,?,?,?,?,?,?,?,?)', array($maxlinkid, 6, 'DETAILVIEWSIDEBARWIDGET', 'OS2CheckList', 'module=OS2CheckList&parent=Settings&view=IndexAjax&mode=showCheckList', '', '', '', '',''));

			$maxlinkid++;
			$adb->pquery('INSERT INTO vtiger_links(linkid, tabid, linktype, linklabel, linkurl, linkicon, sequence, handler_path, handler_class, handler)
			VALUES (?,?,?,?,?,?,?,?,?,?)', array($maxlinkid, 2, 'DETAILVIEWSIDEBARWIDGET', 'OS2CheckList', 'module=OS2CheckList&parent=Settings&view=IndexAjax&mode=showCheckListPotentials', '', '', '', '',''));

			$maxlinkid++;
			$adb->pquery('INSERT INTO vtiger_links(linkid, tabid, linktype, linklabel, linkurl, linkicon, sequence, handler_path, handler_class, handler)
			VALUES (?,?,?,?,?,?,?,?,?,?)', array($maxlinkid, 8, 'DETAILVIEWSIDEBARWIDGET', 'OS2CheckList', 'module=OS2CheckList&parent=Settings&view=IndexAjax&mode=showCheckListDocuments', '', '', '', '',''));
		
			$adb->pquery("UPDATE vtiger_links_seq SET id=?",array($maxlinkid));			
		
			$adb->pquery('CREATE TABLE IF NOT EXISTS vtiger_checklistdetails (
				  checklistid int(11) NOT NULL AUTO_INCREMENT,
				  checklistname varchar(120) NOT NULL,
				  modulename varchar(120) NOT NULL,
				  category varchar(120) NULL,
				  title varchar(120) NULL,
				  allow_upload varchar(100) NOT NULL,
				  allow_note varchar(11)  NOT NULL,
				  description text NULL,
				  createdtime datetime  NOT NULL,
				  status varchar(10) NOT NULL,
				  sequence int(10) NOT NULL,
				  deleted tinyint(10) NOT NULL,
				  PRIMARY KEY (checklistid)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;',array());
				
			$adb->pquery('CREATE TABLE IF NOT EXISTS vtiger_checklist_comment (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  checklistid int(10) NOT NULL,
				  sequence int(10) NOT NULL,
				  crmid int(10) NOT NULL,
				  comment_content text NOT NULL,
				  userid int(10) NOT NULL,
				  username varchar(100) NOT NULL,
				  time datetime NOT NULL,
				  PRIMARY KEY (id)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;',array());
				
			$adb->pquery('CREATE TABLE IF NOT EXISTS vtiger_checklist_related (
				  checklistid int(11) NOT NULL ,
				  sequence int(10) NOT NULL,
				  category varchar(250) NOT NULL,
				  title varchar(250) NOT NULL,
				  description text NOT NULL,
				  notes varchar(250) NOT NULL,
				  comments varchar(500) NOT NULL
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;',array());
			
			$adb->pquery('CREATE TABLE IF NOT EXISTS vtiger_relmodule_checklist (
				  id int(11) NOT NULL AUTO_INCREMENT,
				  checklistid int(100) NOT NULL,
				  sequence int(100) NOT NULL,
				  noteid int(100) NOT NULL,
				  accountid int(100) NOT NULL,
				  PRIMARY KEY (id)
				) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;',array());			
				// Mark the module as Custom module
				 $adb->pquery('UPDATE vtiger_tab SET customized=1 WHERE name=?', array($moduleName));
		}

 		if($eventType == 'module.preupdate') {

		}

 		if($eventType == 'module.postupdate') {

		}

	}
}
?>
