<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_IndexAjax_View extends Vtiger_IndexAjax_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('showCheckList');
		$this->exposeMethod('showCheckListLeads');
		$this->exposeMethod('showCheckListPotentials');
		$this->exposeMethod('showCheckListDocuments');
		$this->exposeMethod('showCheckListContacts');
	}
	
	function showCheckList(Vtiger_Request $request){
		$db = PearDatabase::getInstance();//$db->setDebug(true);
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule(false);
		$recordid = $_REQUEST['record'];
		
		$query = $db->pquery("SELECT * FROM vtiger_checklistdetails WHERE modulename='Accounts' and deleted=0",array());
		$count = $db->num_rows($query);
		$list = array();
		for($i=0; $i<$count; $i++) {
			$row = $db->query_result_rowdata($query, $i);
			$list[$i][0] = $row['checklistname'];
			$list[$i][1] = $row['checklistid'];
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CHKLIST', $list);
		$viewer->assign('RECORD', $recordid);
		echo $viewer->view('showWidgetActivies.tpl', $moduleName);
	}
	
	function showCheckListLeads(Vtiger_Request $request){
		$db = PearDatabase::getInstance();//$db->setDebug(true);
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule(false);
		$recordid = $_REQUEST['record'];
		
		$query = $db->pquery("SELECT * FROM vtiger_checklistdetails WHERE modulename='Leads' and deleted=0",array());
		$count = $db->num_rows($query);
		$list = array();
		for($i=0; $i<$count; $i++) {
			$row = $db->query_result_rowdata($query, $i);
			$list[$i][0] = $row['checklistname'];
			$list[$i][1] = $row['checklistid'];
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CHKLIST', $list);
		$viewer->assign('RECORD', $recordid);
		echo $viewer->view('showWidgetActivies.tpl', $moduleName);
	}
	
	function showCheckListPotentials(Vtiger_Request $request){
		$db = PearDatabase::getInstance();//$db->setDebug(true);
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule(false);
		$recordid = $_REQUEST['record'];
		
		$query = $db->pquery("SELECT * FROM vtiger_checklistdetails WHERE modulename='Potentials' and deleted=0",array());
		$count = $db->num_rows($query);
		$list = array();
		for($i=0; $i<$count; $i++) {
			$row = $db->query_result_rowdata($query, $i);
			$list[$i][0] = $row['checklistname'];
			$list[$i][1] = $row['checklistid'];
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CHKLIST', $list);
		$viewer->assign('RECORD', $recordid);
		echo $viewer->view('showWidgetActivies.tpl', $moduleName);
	}
	
	function showCheckListDocuments(Vtiger_Request $request){
		$db = PearDatabase::getInstance();//$db->setDebug(true);
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule(false);
		$recordid = $_REQUEST['record'];
		
		$query = $db->pquery("SELECT * FROM vtiger_checklistdetails WHERE modulename='Documents' and deleted=0",array());
		$count = $db->num_rows($query);
		$list = array();
		for($i=0; $i<$count; $i++) {
			$row = $db->query_result_rowdata($query, $i);
			$list[$i][0] = $row['checklistname'];
			$list[$i][1] = $row['checklistid'];
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CHKLIST', $list);
		$viewer->assign('RECORD', $recordid);
		echo $viewer->view('showWidgetActivies.tpl', $moduleName);
	}

	function showCheckListContacts(Vtiger_Request $request){
		$db = PearDatabase::getInstance();//$db->setDebug(true);
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule(false);
		$recordid = $_REQUEST['record'];
		
		$query = $db->pquery("SELECT * FROM vtiger_checklistdetails WHERE modulename='Contacts' and deleted=0",array());
		$count = $db->num_rows($query);
		$list = array();
		for($i=0; $i<$count; $i++) {
			$row = $db->query_result_rowdata($query, $i);
			$list[$i][0] = $row['checklistname'];
			$list[$i][1] = $row['checklistid'];
		}
		
		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('CHKLIST', $list);
		$viewer->assign('RECORD', $recordid);
		echo $viewer->view('showWidgetActivies.tpl', $moduleName);
	}
	
	
}