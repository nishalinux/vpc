<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
class Settings_OS2LoginHistory_loginHistoryAjax_Action extends Settings_Vtiger_Basic_Action {
	  

	public function process(Vtiger_Request $request) {
		//echo "<pre>";print_r($request);die;
		global $adb;
		$adb = PearDatabase::getInstance();
		$recordId = $request->get('recordid');
		$response = new Vtiger_Response();
		$qry1 = "SELECT login_id,login_time,logout_time,user_name FROM vtiger_loginhistory where login_id = '$recordId'";
		//echo $qry1;die;
        $result = $adb->pquery($qry1);
        $row = $adb->fetchByAssoc($result);

		$userid = $row['login_id'];
		$login_time = $row['login_time'];
		$logout_time = $row['logout_time'];
		$user_name = $row['user_name'];

		$widget_issues_List = array();
		$pagenum =  $request->get('pagenumber');
		$startIndex = $this->getStartIndex($pagenum);				
		$pageLimit = vglobal('list_max_entries_per_page');	
		$qry = "SELECT * from vtiger_users where user_name='$user_name'";
		
		$res = $adb->pquery($qry);
		$row1 = $adb->fetchByAssoc($res);

		$id = $row1['id'];
		if($request->get('submodule') && $request->get('submodule')!='')
		{
			$submodule	=	$request->get('submodule');
			$where	=	"and mb.module='$submodule'";
		}
		else
		{
			$where='';
		}
		if($request->get('search_username') && $request->get('search_username')!='')
		{
			$search_username	=	$request->get('search_username');
		$usernameqry = "SELECT id from vtiger_users where user_name LIKE'%$search_username%'";
		$usernameres = $adb->pquery($usernameqry);
		$usernamerow = $adb->fetchByAssoc($usernameres);
			
        $usernameid = $usernamerow['id'];
		$where	=	"and mb.whodid='$usernameid'";
		}
		if($request->get('search_modulename') && $request->get('search_modulename')!='')
		{
			$search_modulename	=	$request->get('search_modulename');
			$where	=	"and mb.module LIKE '%$search_modulename%'";
		}
		if($request->get('search_fieldname') && $request->get('search_fieldname')!='')
		{
			$search_fieldname	=	$request->get('search_fieldname');
			$where	=	"and md.fieldname LIKE '%$search_fieldname%'";
		}
		if($request->get('search_prevalue') && $request->get('search_prevalue')!='')
		{
			$search_prevalue	=	$request->get('search_prevalue');
			$where	=	"and md.prevalue LIKE '%$search_prevalue%'";
		}
		if($request->get('search_postvalue') && $request->get('search_postvalue')!='')
		{
			$search_postvalue	=	$request->get('search_postvalue');
			$where	=	"and md.postvalue LIKE '%$search_postvalue%'";
		}
		if($request->get('search_changedon') && $request->get('search_changedon')!='')
		{
			$search_changedon	=	$request->get('search_changedon');
			$where	=	"and mb.changedon LIKE '%$search_changedon%'";
		}
		
			$query = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id $where and mb.changedon between '$login_time' and '$logout_time'";
			$query .=" LIMIT $startIndex,".($pageLimit+1);
			
			$result1 = $adb->pquery($query); 
			$norows = $adb->num_rows($result1);	
			$pagination = $this->calculatePageRange($norows,$pagenum);				
			while($row = $adb->fetchByAssoc($result1)){
				if($row['fieldname']=='assigned_user_id')
		{
			
			$id1	=	$row['prevalue'];
			$id2	=	$row['postvalue'];
			$row['prevalue']= getUserFullName($id1);
			$row['postvalue']= getUserFullName($id2);
		}
		if($row['fieldname']=='modifiedby')
		{
			
			$id3	=	$row['prevalue'];
			$id4	=	$row['postvalue'];
			$row['prevalue']= getUserFullName($id3);
			$row['postvalue']= getUserFullName($id4);
		}
		$userdid	=	$row['whodid'];
		$row['whodid']	=	getUserFullName($userdid);
				$widget_issues_List[] = $row;
			}

			$qry2 = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id $where and mb.changedon between '$login_time' and '$logout_time'";
			$res2 = $adb->pquery($qry2); 
			$totalrows = $adb->num_rows($res2);

			$pagination['totalcount'] = $totalrows;
			$pagination['pageCount'] = ceil((int) $pagination['totalcount'] / (int) $pageLimit);
			if($pagination['pageCount'] == 0){
				$pagination['pageCount'] = 1;
			}
			if($norows > $pageLimit){
				array_pop($widget_issues_List);
			}
			if($norows > $pageLimit){
				$pagination['nextPageExists'] = true;
			}else{
				$pagination['nextPageExists'] = false;
			}
			$widget_issues_List['pagination'] = $pagination;		
				   
		$response->setResult(array("result"=>json_encode($widget_issues_List), 'success'=>true));


		$response->emit();		
		
	}
	public function getStartIndex($currentPage) {
	    $pageLimit = vglobal('list_max_entries_per_page');
		return ($currentPage-1)*$pageLimit;
	}
	
	public function calculatePageRange($recordList,$currentPage) {
		$rangeInfo = array();
	    $recordCount = $recordList;
		$paginationarray = array();
		$pageLimit = vglobal('list_max_entries_per_page'); 
		if( $recordCount > 0) {
			//specifies what sequencce number of last record in prev page
			$prevPageLastRecordSequence = (($currentPage-1)*$pageLimit);

			$rangeInfo['start'] = $prevPageLastRecordSequence+1;
			if($rangeInfo['start'] == 1){
				$paginationarray['prevPageExists'] = false;
			}else{
				$paginationarray['prevPageExists'] = true;
			}
			//Have less number of records than the page limit
			if($recordCount < $pageLimit) {
				$paginationarray['nextPageExists']=false;
				$rangeInfo['end'] = $prevPageLastRecordSequence+$recordCount;
			}else {
				$rangeInfo['end'] = $prevPageLastRecordSequence+$pageLimit;
			}
			$paginationarray['range']=$rangeInfo;
		} else {
			//Disable previous page only if page is first page and no records exists
			if($currentPage == 1) {
				$paginationarray['prevPageExists'] = false;
			}
			$paginationarray['nextPageExists']=false;
			
		}
		return $paginationarray;
	}
   
}
