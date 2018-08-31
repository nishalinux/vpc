<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2LoginHistory_List_View extends Settings_Vtiger_List_View {
	
	function preProcess(Vtiger_Request $request, $display=true) {
		$adb = PearDatabase::getInstance();
		$viewer = $this->getViewer($request);
		$loginHistoryRecordModel = new  Settings_OS2LoginHistory_Record_Model();
		$usersList = $loginHistoryRecordModel->getAccessibleUsers();
		$status = "Signed in";
		$query = "SELECT count(login_id) as count FROM vtiger_loginhistory WHERE status=?";
		$val = array($status);
		$res = $adb->pquery($query,$val);		
		$totallogin = $adb->query_result($res, 0, 'count');
		
		//$totallogin = 10;
		$viewer->assign('USERSLIST',$usersList);
		$viewer->assign('TOTAL_LOGIN',$totallogin);
        $viewer->assign('SELECTED_USER',$request->get('user_name'));
		parent::preProcess($request, false);
	}
	public function process(Vtiger_Request $request) {
		$viewer = $this->getViewer($request);
		$this->initializeListViewContents($request, $viewer);
		$viewer->view('ListViewContents.tpl', $request->getModule(false));
	}

	/*
	 * Function to initialize the required data in smarty to display the List View Contents
	 */
	public function initializeListViewContents(Vtiger_Request $request, Vtiger_Viewer $viewer) {
		$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$pageNumber = $request->get('page');
		$orderBy = $request->get('orderby');
		$sortOrder = $request->get('sortorder');
		$sourceModule = $request->get('sourceModule');
		$forModule = $request->get('formodule');
		
		$searchKey = $request->get('search_key');
		$searchValue = $request->get('search_value');
		
		if($sortOrder == "ASC"){
			$nextSortOrder = "DESC";
			$sortImage = "icon-chevron-down";
		}else{
			$nextSortOrder = "ASC";
			$sortImage = "icon-chevron-up";
		}
		if(empty($pageNumber)) {
			$pageNumber = 1;
		}

		$listViewModel = Settings_Vtiger_ListView_Model::getInstance($qualifiedModuleName);

		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $pageNumber);
		$pagingModel->set('prevPageExists', 1);
		$pagingModel->set('nextPageExists', 1);

		if(!empty($searchKey) && !empty($searchValue)) {
			$listViewModel->set('search_key', $searchKey);
			$listViewModel->set('search_value', $searchValue);
		}
		
		if(!empty($orderBy)) {
			$listViewModel->set('orderby', $orderBy);
			$listViewModel->set('sortorder',$sortOrder);
		}
		if(!empty($sourceModule)) {
			$listViewModel->set('sourceModule', $sourceModule);
		}
		if(!empty($forModule)) {
			$listViewModel->set('formodule', $forModule);
		}
		
		if(($request->get('search_user'))&&($request->get('search_user')!='')) {
			$searchUser	=	$request->get('search_user');
			$listViewModel->set('search_user', $searchUser);
			$viewer->assign('SEARCH_USER', $searchUser);
		}
		if(($request->get('userip'))&&($request->get('userip')!='')) {
			$userip	=	$request->get('userip');
			$listViewModel->set('userip', $userip);
			$viewer->assign('USER_IP', $userip);
		}
		if(($request->get('signintime'))&&($request->get('signintime')!='')) {
			$signintime	=	$request->get('signintime');
			$signintime_ser = date('Y-m-d',strtotime($signintime));
			$listViewModel->set('signintime', $signintime_ser);
			$viewer->assign('SIGNIN_TIME', $signintime);
		}
		if(($request->get('signouttime'))&&($request->get('signouttime')!='')) {
			$signouttime	=	$request->get('signouttime');
			$signouttime_ser = date('Y-m-d',strtotime($signouttime));
			$listViewModel->set('signouttime', $signouttime_ser);
			$viewer->assign('SIGNOUT_TIME', $signouttime);
		}
		if(($request->get('status'))&&($request->get('status')!='')) {
			$loginstatus	=	$request->get('status');
			$listViewModel->set('status', $loginstatus);
			$viewer->assign('STATUS', $loginstatus);
			
		}
		
		if(!$this->listViewHeaders){
			$this->listViewHeaders = $listViewModel->getListViewHeaders();
		}
		if(!$this->listViewEntries){
			$this->listViewEntries = $listViewModel->getListViewEntries($pagingModel);
		}
		$noOfEntries = count($this->listViewEntries);
		if(!$this->listViewLinks){
			$this->listViewLinks = $listViewModel->getListViewLinks();
		}
		$viewer->assign('LISTVIEW_LINKS', $this->listViewLinks);


		$viewer->assign('MODULE', $moduleName);
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$viewer->assign('MODULE_MODEL', $listViewModel->getModule());

		$viewer->assign('PAGING_MODEL', $pagingModel);
		$viewer->assign('PAGE_NUMBER',$pageNumber);

		$viewer->assign('ORDER_BY',$orderBy);
		$viewer->assign('SORT_ORDER',$sortOrder);
		$viewer->assign('NEXT_SORT_ORDER',$nextSortOrder);
		$viewer->assign('SORT_IMAGE',$sortImage);
		$viewer->assign('COLUMN_NAME',$orderBy);
	if($request->get('search_user')&&($request->get('search_user')!=''))
	{
		$search_value	=	$request->get('search_user');
		$viewer->assign('SEARCH_VALUE',$search_value);
	}
		

		$viewer->assign('LISTVIEW_ENTRIES_COUNT',$noOfEntries);
		$viewer->assign('LISTVIEW_HEADERS', $this->listViewHeaders);
		$viewer->assign('LISTVIEW_ENTRIES', $this->listViewEntries);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());

		if (PerformancePrefs::getBoolean('LISTVIEW_COMPUTE_PAGE_COUNT', false)) {
			if(!$this->listViewCount){
				$this->listViewCount = $listViewModel->getListViewCount();
			}
			$totalCount = $this->listViewCount;
			$pageLimit = $pagingModel->getPageLimit();
			$pageCount = ceil((int) $totalCount / (int) $pageLimit);

			if($pageCount == 0){
				$pageCount = 1;
			}
			$viewer->assign('PAGE_COUNT', $pageCount);
			$viewer->assign('LISTVIEW_COUNT', $totalCount);
		}
	}

	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			'modules.Vtiger.resources.List',
			'modules.Settings.Vtiger.resources.List',
			"modules.Settings.$moduleName.resources.List",
			"modules.Settings.Vtiger.resources.$moduleName",
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}
