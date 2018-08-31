<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Settings_OS2LoginHistory_ListAjaxData_Action extends Settings_Vtiger_IndexAjax_View{

	function checkPermission(Vtiger_Request $request) {
		return;
	}

	public function process(Vtiger_Request $request) {
		
		$adb = PearDatabase::getInstance();
		$username = $request->get('user');
		$startdate = $request->get('startdate');
        $start_date = date('Y-m-d',strtotime($startdate));

        $enddate = $request->get('enddate');
        // echo $enddate;
        $end_date = date('Y-m-d',strtotime($enddate));
		if($username != 'All'){
			
			// echo $username;echo $start_date;echo $end_date;die();
			$user_sql = $adb->pquery('SELECT * FROM vtiger_users WHERE last_name = ?',array($username));
			$user_id = $adb->query_result($user_sql,0,'id');
			if($startdate != '' && $enddate != ''){
				if($start_date == $end_date){
					$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $user_id and mb.changedon LIKE '%$start_date%'";
				}
				
				else{
					$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $user_id and mb.changedon between '%$start_date%' and '%$end_date%'"; 
				}
			}
			else if($startdate != '' && $enddate == ''){
				$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $user_id and mb.changedon LIKE '%$start_date%'";
			}
			else if($startdate == '' && $enddate != ''){
				$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $user_id and mb.changedon LIKE '%$end_date%'";
			}else{ 
				$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.whodid = $user_id"; 
			}
		}
		else{
			if($startdate != '' && $enddate != ''){
				if($start_date == $end_date){
					$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.changedon LIKE '%$start_date%'";
				}
				
				else{
					$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where  mb.changedon between '%$start_date%' and '%$end_date%'"; 
				}
			}
			else if($startdate != '' && $enddate == ''){
				$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where  mb.changedon LIKE '%$start_date%'";
			}
			else if($startdate == '' && $enddate != ''){
				$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id where mb.changedon LIKE '%$end_date%'";
			}else{ 
				$sql = "SELECT md.*,mb.* FROM  vtiger_modtracker_detail md left join vtiger_modtracker_basic mb on md.id = mb.id"; 
			}
		}
		
		//echo $sql;
		//exit;
		// echo $sql;die();
		$result = $adb->pquery($sql); 
       

    
	    function filterData(&$str)
	    {
	        $str = preg_replace("/\t/", "\\t", $str);
	        $str = preg_replace("/\r?\n/", "\\n", $str);
	        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
	    }
	   header("Content-type: application/vnd.ms-excel; charset=utf-8"); 
       header("Content-disposition:  attachment; filename=Report_" . date("Y-m-d").".xls");   $flag = false;

        for($i=0;$i<$adb->num_rows($result);$i++){
        	$exportdata = $adb->fetchByAssoc($result,$i);

        	$data =	array($exportdata);
		        foreach($data as $row) {
			        if(!$flag) {
			        	echo implode("\t",array_keys($row)) . "\n";
			            $flag = true;
			           
			        }
			        array_walk($row, 'filterData');
			        echo implode("\t", array_values($row)) . "\n";
			   
			    }
        	
        }
	    
	    exit();

	}

}