<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_OS2LoginHistory_Detail_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {
    //echo "<pre>";print_r($request);die;
        $adb = PearDatabase::getInstance();
        $response = new Vtiger_Response();

        $recordId = $request->get('record');

        $moduleName = $request->getModule();
        $qualifiedModuleName = $request->getModule(false);
      $moduleModelList = Settings_OS2LoginHistory_Module_Model::getPicklistSupportedModules(); 

      $viewer = $this->getViewer($request);
      $viewer->assign('RECORD_ID',  $recordId);       
      $viewer->assign('ISSUES_LIST', $this->getIssuesList(1,$recordId,$request));
      $viewer->assign('UPLINE_LIST', $this->getUplineList($recordId));
      
    if($request->get('search_username'))
    {
      $search_username  = $request->get('search_username');
      $viewer->assign('SEARCH_USERNAME', $search_username);
    }
    if($request->get('search_modulename'))
    {
      $search_modulename  = $request->get('search_modulename');
      $viewer->assign('SEARCH_MODULENAME', $search_modulename);
    }
    if($request->get('search_fieldname'))
    {
      $search_fieldname = $request->get('search_fieldname');
      $viewer->assign('SEARCH_FIELDNAME', $search_fieldname);
    }
    if($request->get('search_prevalue'))
    {
      $search_prevalue  = $request->get('search_prevalue');
      $viewer->assign('SEARCH_PRE_VALUE', $search_prevalue);
    }
    if($request->get('search_postvalue'))
    {
      $search_postvalue = $request->get('search_postvalue');
      $viewer->assign('SEARCH_POST_VALUE', $search_postvalue);
    }
    if($request->get('search_changedon'))
    {
      $changedon = $request->get('search_changedon');
     $search_changedon = date('Y-m-d',strtotime($changedon));
      $viewer->assign('SEARCH_CHANGEDON', $search_changedon);
    }  
  
        $viewer->assign('MODULE', $moduleName);
        $viewer->assign('SELECTED_MODULE_NAME', $request->get('submodule'));
        $viewer->assign('RECORD_ID', $recordId);
        //$viewer->assign('RECORD_MODEL',$recordModel);
        $viewer->assign('PICKLIST_MODULES_LIST',$moduleModelList);
        $viewer->view('DetailView.tpl', $qualifiedModuleName);


    }

    public  function getIssuesList($page,$recordId,$request){
    global $adb;
    global $log;
    //$adb->setDebug(true);
    $issues_List = array();
    $adb = PearDatabase::getInstance();
    $pageLimit = vglobal('list_max_entries_per_page');     
    $pageNumber = 1;
    $startIndex = 0;    

    $qry1 = "SELECT login_id,login_time,logout_time,user_name FROM vtiger_loginhistory where login_id = '$recordId'";
        $result = $adb->pquery($qry1);
        $row = $adb->fetchByAssoc($result);

         $userid = $row['login_id'];
         $signint_end = $row['login_time'];
         $logout_time = $row['logout_time'];
         $user_name = $row['user_name'];
		 $login_time = Vtiger_Datetime_UIType::getDBDateTimeValue($signint_end);

  $qry = "SELECT * from vtiger_users where user_name='$user_name'";
             $res = $adb->pquery($qry);
               $row = $adb->fetchByAssoc($res);

              $id = $row['id'];
if($request->get('submodule') && $request->get('submodule')!='')
    {
    $submodule  = $request->get('submodule');
    $where  = "and mb.module='$submodule'";
  }
  else
  {
    $where='';
  }
  if($request->get('search_username'))
    {
    $search_username  = $request->get('search_username');
    $usernameqry = "SELECT id from vtiger_users where user_name LIKE'%$search_username%'";
    $usernameres = $adb->pquery($usernameqry);
    $usernamerow = $adb->fetchByAssoc($usernameres);
      
        $usernameid = $usernamerow['id'];
    $where  = "and mb.whodid='$usernameid'";
  }
  if($request->get('search_modulename'))
    {
    $search_modulename  = $request->get('search_modulename');
    $where  = "and mb.module LIKE '%$search_modulename%'";
  }
  if($request->get('search_fieldname'))
    {
    $search_fieldname = $request->get('search_fieldname');
    $where  = "and md.fieldname LIKE '%$search_fieldname%'";
  }
  if($request->get('search_prevalue'))
    {
    $search_prevalue  = $request->get('search_prevalue');
    $where  = "and md.prevalue LIKE '%$search_prevalue%'";
  }
  if($request->get('search_postvalue'))
    {
    $search_postvalue = $request->get('search_postvalue');
    $where  = "and md.postvalue LIKE '%$search_postvalue%'";
  }
  if($request->get('search_changedon'))
    {
    $changedon = $request->get('search_changedon');
    $search_changedon = date('Y-m-d',strtotime($changedon));
    $where  = "and mb.changedon LIKE '%$search_changedon%'";
  }
  $query = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id $where and mb.changedon between '$login_time' and '$logout_time'";
    $query .= " LIMIT $startIndex,".($pageLimit+1);   
        $resultData = $adb->pquery($query);   
    $norows = $adb->num_rows($resultData);      
    $pagination  = $this->calculatePageRange($norows);  
    if($norows > $pageLimit){
      $pagination['nextPageExists'] =true;
    }else{
      $pagination['nextPageExists']= false;
    }   
    while( $row = $adb->fetchByAssoc($resultData))
    {
    if(($row['fieldname']=='assigned_user_id')||($row['prevalue']=='null'))
    {
      
      $id1  = $row['prevalue'];
      $id2  = $row['postvalue'];
      $row['prevalue']= getUserFullName($id1);
      $row['postvalue']= getUserFullName($id2);
    }
    if($row['fieldname']=='modifiedby')
    {
      
      $id3  = $row['prevalue'];
      $id4  = $row['postvalue'];
      $row['prevalue']= getUserFullName($id3);
      $row['postvalue']= getUserFullName($id4);
    }

    //added by jyothi for login++
      $changedOn = $row['changedon'];
      $row['changedon'] = $this->getDateformatValue($changedOn);
     //ended here  

    $userdid  = $row['whodid'];
    $row['whodid']  = getUserFullName($userdid);
      $issues_List[] = $row;
      
    }
    if($norows > $pageLimit){
      array_pop($issues_List);
    }
   
   $qry2 = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md 
      left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id $where and mb.changedon between '$login_time' and '$logout_time'";

                $res = $adb->pquery($qry2); 
        $totalrows = $adb->num_rows($res);
        $pagination['totalcount'] = $totalrows;

    $pagination['pageCount'] = ceil((int) $pagination['totalcount'] / (int) $pageLimit);
    if($pagination['pageCount'] == 0){
      $pagination['pageCount'] = 1;
    }
    $issues_List['pagination'] = $pagination;
    return $issues_List;
  }
  
  
 public function getUplineList($recordId)
  {
    global $adb;
    $uplineList = array();
    $adb = PearDatabase::getInstance();
    $pageLimit = vglobal('list_max_entries_per_page');
    $pageNumber = 1;
    $startIndex = 0;  
  
    $qry1 = "SELECT login_id,login_time,logout_time,user_name FROM vtiger_loginhistory where login_id = '$recordId'";
        $result = $adb->pquery($qry1);
        $row = $adb->fetchByAssoc($result);

         $userid = $row['login_id'];
         $signint_end = $row['login_time'];
         $logout_time = $row['logout_time'];
         $user_name = $row['user_name'];
		 $login_time = Vtiger_Datetime_UIType::getDBDateTimeValue($signint_end);

  $qry = "SELECT * from vtiger_users where user_name='$user_name'";
             $res = $adb->pquery($qry);
               $row = $adb->fetchByAssoc($res);

              $id = $row['id'];

  $query = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id and mb.changedon between '$login_time' and '$logout_time'  ";

    $query .= " LIMIT $startIndex,".($pageLimit+1);
	
    $result = $adb->pquery($query);    
    $norows = $adb->num_rows($result);    
    $pagination  = $this->calculatePageRange($norows);  
    if($norows > $pageLimit){
      $pagination['nextPageExists'] =true;
    }else{
      $pagination['nextPageExists']= false;
    } 
    while( $row = $adb->fetchByAssoc($result)){

    if(($row['fieldname']=='assigned_user_id')||($row['prevalue']=='null'))
    {
      
      $id = $row['prevalue'];
      $id2  = $row['postvalue'];
      $row['prevalue']= getUserFullName($id);
      $row['postvalue']= getUserFullName($id2);
    }
    if($row['fieldname']=='modifiedby')
    {
      
      $id3  = $row['prevalue'];
      $id4  = $row['postvalue'];
      $row['prevalue']= getUserFullName($id3);
      $row['postvalue']= getUserFullName($id4);
    }

    //added by jyothi for login++
      $changedOn = $row['changedon'];
      $row['changedon'] = $this->getDateformatValue($changedOn);
     //ended here   

    $userdid  = $row['whodid'];
    $row['whodid']  = getUserFullName($userdid);
      $uplineList[] = $row;
    } 
    if($norows > $pageLimit){
      array_pop($uplineList);
    }
  $qry2 = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id and mb.changedon between '$login_time' and '$logout_time'";
 
                $res = $adb->pquery($qry2); 
        $totalrows = $adb->num_rows($res);

        $pagination['totalcount'] = $totalrows;
    $pagination['pageCount'] = ceil((int) $pagination['totalcount'] / (int) $pageLimit);
    if($pagination['pageCount'] == 0){
      $pagination['pageCount'] = 1;
    }
    $uplineList['pagination'] = $pagination;
	 
    return $uplineList;
  }
 

 //added by jyothi for login++
     public function getDateformatValue($changedOn) {
      if($changedOn != '0000-00-00 00:00:00'){
        $datetime =  Vtiger_Datetime_UIType::getDateTimeValue($changedOn);
        return $datetime;
      }else{
        $datetime = '---';
        return $datetime;
      }
    } 

  //ended here


  /**
   * calculates page range
   * @param <type> $recordList - list of records which is show in current page
   * @return Vtiger_Paging_Model  -
   */
  public function calculatePageRange($recordList) {
    $rangeInfo = array();
    $recordCount = $recordList;
    $paginationarray = array();
    $pageLimit = vglobal('list_max_entries_per_page'); 
    if( $recordCount > 0) {
      //specifies what sequencce number of last record in prev page
      $currentPage = 1;
      $prevPageLastRecordSequence = (($currentPage-1)*$pageLimit);

      $rangeInfo['start'] = $prevPageLastRecordSequence+1;
      if($rangeInfo['start'] == 1){
        $paginationarray['prevPageExists'] = false;
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

 function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            "modules.Settings.$moduleName.resources.Detail",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }

}
