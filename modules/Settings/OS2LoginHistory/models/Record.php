<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
class Settings_OS2LoginHistory_Record_Model extends Settings_Vtiger_Record_Model {
	
	/**
	 * Function to get the Id
	 * @return <Number> Profile Id
	 */
	public function getId() {
		return $this->get('login_id');
	}


    public function getDetailViewUrl() {
        return '?module=OS2LoginHistory&parent=Settings&view=Detail&record='.$this->getId();
    }

//     public static function getActivityDetails($userid,$login_time,$logout_time,$user_name) {

//     	$adb = PearDatabase::getInstance();
//         $response = new Vtiger_Response();

// 		$qry = "SELECT * from vtiger_users where user_name='$user_name'";
//     	 $res = $adb->pquery($qry);
//          $row = $adb->fetchByAssoc($res);

//         $id = $row['id'];
//         $modulename = $_GET['search_value'];

//       // $query = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id and mb.changedon between '$login_time' and '$logout_time' ";

//                 $upline_List = array();
// 				$pagenum = 1;
// 				$startIndex = self::getStartIndex($pagenum);				
// 				$pageLimit = vglobal('list_max_entries_per_page');
// 				$query = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id and mb.changedon between '$login_time' and '$logout_time' having mb.module = 'Leads'";
// 				echo $query;
// 				// exit();
// 				$query .=" LIMIT $startIndex,".($pageLimit+1);
// 				$result = $adb->pquery($query); 
// 				$norows = $adb->num_rows($result);	
// 				$pagination = self::calculatePageRange($norows,$pagenum);				
// 				while( $row = $adb->fetchByAssoc($result)){
// 					$upline_List[] = $row;
// 				}
// 				$qry = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $id and mb.changedon between '$login_time' and '$logout_time'";
//                 $res = $adb->pquery($qry); 
// 				$totalrows = $adb->num_rows($res);
                
//                 $pagination['pagelimit'] = $pageLimit;
// 				$pagination['totalcount'] = $totalrows;
// 				$pagination['pageCount'] = ceil((int) $pagination['totalcount'] / (int) $pageLimit);
// 				if($pagination['pageCount'] == 0){
// 					$pagination['pageCount'] = 1;
// 				}
// 				if($norows > $pageLimit){
// 					array_pop($upline_List);
// 				}
// 				if($norows > $pageLimit){
// 					$pagination['nextPageExists'] = true;
// 				}else{
// 					$pagination['nextPageExists'] = false;
// 				}
// 				$upline_List['pagination'] = $pagination;	
// 				$response = $upline_List;			
				 	
// 				// $response->setResult(array("result"=>json_encode($upline_List), 'success'=>true));

// // return $response;
// 		// $result = $adb->pquery($query, array());

// 		// print_r($result);
// 		// exit();
// 				return $response;
	
// 	}

// 	//code added for pagination 
 
				
// 	public function getStartIndex($currentPage) {

// 	    $pageLimit = vglobal('list_max_entries_per_page');
// 	    return ($currentPage-1)*$pageLimit;
		
// 	}
	 
// 	public function calculatePageRange($recordList,$currentPage)
// 	{
// 		$rangeInfo = array();
// 	    $recordCount = $recordList;
// 		$paginationarray = array();
// 		$pageLimit = vglobal('list_max_entries_per_page');
// 		if( $recordCount > 0) {
// 			//specifies what sequencce number of last record in prev page
// 			$prevPageLastRecordSequence = (($currentPage-1)*$pageLimit);

// 			$rangeInfo['start'] = $prevPageLastRecordSequence+1;
// 			if($rangeInfo['start'] == 1){
// 				$paginationarray['prevPageExists'] = false;
// 			}else{
// 				$paginationarray['prevPageExists'] = true;
// 			}
// 			//Have less number of records than the page limit
// 			if($recordCount < $pageLimit) {
// 				$paginationarray['nextPageExists']=false;
// 				$rangeInfo['end'] = $prevPageLastRecordSequence+$recordCount;
// 			}else {
// 				$rangeInfo['end'] = $prevPageLastRecordSequence+$pageLimit;
// 			}
// 			$paginationarray['range']=$rangeInfo;
// 		} else {
// 			//Disable previous page only if page is first page and no records exists
// 			if($currentPage == 1) {
// 				$paginationarray['prevPageExists'] = false;
// 			}
// 			$paginationarray['nextPageExists']=false;
			
// 		}
// 		return $paginationarray;
// 	}
   //ended

	/**
	 * Function to get the Profile Name
	 * @return <String>
	 */
	public function getName() {
		return $this->get('user_name');
	}
	
	public function getAccessibleUsers(){
		$adb = PearDatabase::getInstance();
		$usersListArray = array();
		
		$query = 'SELECT user_name, first_name, last_name FROM vtiger_users';
		$result = $adb->pquery($query, array());
		while($row = $adb->fetchByAssoc($result)) {
			$usersListArray[$row['user_name']] = getFullNameFromArray('Users', $row);
		}
		return $usersListArray;
	}
	
	/**
	 * Function to retieve display value for a field
	 * @param <String> $fieldName - field name for which values need to get
	 * @return <String>
	 */
	public function getDisplayValue($fieldName, $recordId = false) {
		if($fieldName == 'login_time' || $fieldName == 'logout_time'){
			if($this->get($fieldName) != '0000-00-00 00:00:00'){
				return Vtiger_Datetime_UIType::getDateTimeValue($this->get($fieldName));
				//return $this->get($fieldName);
			}else{
				return '---';
			}
		} else {
			return $this->get($fieldName);
		}
		
	}
}
