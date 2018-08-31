<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */



class Calendar_ImportEvent_View extends Vtiger_Import_View {

	function __construct() {
		parent::__construct();
		$this->exposeMethod('import');
		$this->exposeMethod('importResult');

	}

	public function preprocess(Vtiger_Request $request) {
		$mode = $request->getMode();
		if (!empty ($mode)) {
			parent::preProcess($request);
		}
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if(!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
		echo $this->import($request);
	}

	public function postprocess(Vtiger_Request $request) {
		$mode = $request->getMode();
		if (!empty ($mode)) {
			parent::postProcess($request);
		}
	}

	/**
	 * Function to show import UI in Calendar Module
	 * @param Vtiger_Request $request
	 */
	public function import(Vtiger_Request $request) {
//print_r($request);
		$moduleName = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE', $moduleName);

		$viewer->view('ImportEvent.tpl', $moduleName);
	}

	public function importResult(Vtiger_Request $request) {
		global $adb;
		$adb = PearDatabase::getInstance();
		$moduleName = $request->getModule();
		
		$current_user = Users_Record_Model::getCurrentUserModel();
		$filename =$_FILES["importevent_file"]["name"];
		$tmp_name = $_FILES["importevent_file"]["tmp_name"];
		$target='storage/'.basename($_FILES['importevent_file']['name']);
        move_uploaded_file($tmp_name, $target);
		//echo "HI";
		$fp = fopen($target, "r");
		
		 while( ($line = fgetcsv($fp)) !== false) {
			$data[] = $line;
		}

		$headers = $data[0];

		$query = $adb->query("CREATE TABLE IF NOT EXISTS  temp_import_event (
					  `id` int(11) NOT NULL AUTO_INCREMENT,
					  `activity_id` int(100) NOT NULL ,
					  `description` text DEFAULT NULL,
					  `sendnotification` varchar(3) NOT NULL DEFAULT 0,
					  `contactname` varchar(250) DEFAULT NULL,
					  `relatedTo` varchar(250) DEFAULT NULL,
					  `invoiceid` varchar(100) DEFAULT NULL,
					  `duration_seconds` varchar(100) DEFAULT NULL,
					  `subject` varchar(100) NOT NULL,
					  `assignedto` varchar(500) DEFAULT NULL,
					  `startdate` date DEFAULT NULL,
					  `starttime` varchar(25) DEFAULT NULL,
					  `enddate` date DEFAULT NULL,
					  `endtime` varchar(25) DEFAULT NULL,
					  `duration` varchar(200) DEFAULT NULL,
					  `durationmin` varchar(200) DEFAULT NULL,
					  `eventstatus` varchar(200) NOT NULL,
					  `send_notifi` int(3) NOT NULL DEFAULT 0,
					  `activity_type` varchar(200) NOT NULL,
					  `location` varchar(50) DEFAULT NULL,
					  `createdtime` datetime DEFAULT NULL,
					  `modifiedtime` datetime DEFAULT NULL,
					  `priority` varchar(200) DEFAULT NULL,
					  `notime` varchar(3) NOT NULL DEFAULT 0,
					  `visibility` varchar(50) DEFAULT NULL ,
					  `modifiedby` varchar(100) DEFAULT NULL,
					  `repeat_event` varchar(200) DEFAULT NULL,
					  `invitee` varchar(500) DEFAULT NULL,
					  PRIMARY KEY (`id`)
					) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1;",array());
		
		$no_row = count($data);
		$no_inner = count($data[0]);
		if($no_row >=2){
			for($i =1; $i<=($no_row-1); $i++){
				//print_r($data[$i]);		
				$description = 		$data[$i][0];
				$send_email =       $data[$i][1];
				$contact_name =     $data[$i][2];
				$relatedto =        $data[$i][3];
				$invoiceid = 		$data[$i][4];
				$duration_seconds = $data[$i][5];
				//$old_activityid =   $data[$i][6];
				
				$subject = 			$data[$i][6];
				$assignedto = 		$data[$i][7];
				
				$date_start =       $data[$i][8];
				$time_start =       $data[$i][9];
				$due_date =         $data[$i][10];
				$time_end =         $data[$i][11];
				$duration_hours =   $data[$i][12];
				$duration_minutes = $data[$i][13];
				$status =      		$data[$i][14];
				
				$sendnotification = $data[$i][15];
				
				$activitytype =     $data[$i][16];
				$location =         $data[$i][17];
				
				$createdtime =      $data[$i][18];
				$modifiedtime =     $data[$i][19];
				
				$priority =         $data[$i][20];
				$notime = 			$data[$i][21];
				$visibility =       $data[$i][22];
				
				$modifiedby =       $data[$i][23];
				
				$recurringtype =    $data[$i][24];
				$invitee =          $data[$i][25];
				$activityid =  		$data[$i][26];
				
				$date_array = explode("-",$date_start); // split the array
				$var_day = $date_array[0]; //day seqment
				$var_month = $date_array[1]; //month segment
				$var_year = $date_array[2]; //year segment
				$date_start = $var_year.'-'.$var_month.'-'.$var_day;
				
				$date_array1 = explode("-",$due_date); // split the array
				$var_day1 = $date_array1[0]; //day seqment
				$var_month1 = $date_array1[1]; //month segment
				$var_year1= $date_array1[2]; //year segment
				$due_date = $var_year1.'-'.$var_month1.'-'.$var_day1;
				
				$created_array = explode(" ",$createdtime); 
				$created_date = $created_array[0];
				$created_date_arr = explode("-",$created_date);
				$created_day = $created_date_arr[0];
				$created_mon = $created_date_arr[1];
				$created_year = $created_date_arr[2];
				$createdtime = $created_year.'-'.$created_mon.'-'.$created_day.' '.$created_array[1];
				
				$modified_array = explode(" ",$modifiedtime); 
				$modified_date = $modified_array[0];
				$modified_date_arr = explode("-",$modified_date);
				$modified_day = $modified_date_arr[0];
				$modified_mon = $modified_date_arr[1];
				$modified_year = $modified_date_arr[2];
				$modifiedtime = $modified_year.'-'.$modified_mon.'-'.$modified_day.' '.$modified_array[1];
	
				$date_start = date('Y-m-d', strtotime($date_start));
				$due_date = date('Y-m-d', strtotime($due_date));
				$createdtime = date('Y-m-d H:i:s', strtotime($createdtime));
				$modifiedtime = date('Y-m-d H:i:s', strtotime($modifiedtime));
					
				$aa = $adb->pquery("INSERT INTO temp_import_event (activity_id, description, sendnotification, contactname, relatedTo, invoiceid, duration_seconds, subject,assignedto, startdate,  starttime, enddate, endtime, duration, durationmin, eventstatus, send_notifi, activity_type, location, createdtime, modifiedtime, priority, notime, visibility, modifiedby, repeat_event, invitee) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)",array($activityid, $description, $send_email, $contact_name, $relatedto, $invoiceid, $duration_seconds, $subject, $assignedto, $date_start, $time_start, $due_date, $time_end, $duration_hours, $duration_minutes, $status, $sendnotification, $activitytype, $location, $createdtime, $modifiedtime, $priority, $notime, $visibility, $modifiedby, $recurringtype, $invitee ));
					
				if($activitytype == 'Task'){
					$importedTasks = ($no_row -1);
					$adb->pquery("UPDATE vtiger_activity SET subject=?, activitytype=?, date_start=?, due_date=?, time_start=?, sendnotification=?, duration_hours=?, duration_minutes=?, status=?, priority=?, location=?, notime=?, visibility=? WHERE activityid=?",array($subject, $activitytype, $date_start, $due_date, $time_start, $sendnotification, $duration_hours, $duration_minutes, $status, $priority, $location, $notime, $visibility, $activityid));
					
				}else{
					$importedEvents = ($no_row -1);
					$adb->pquery("UPDATE vtiger_activity SET subject=?, activitytype=?, date_start=?, due_date=?, time_start=?, time_end=?, sendnotification=?, duration_hours=?, duration_minutes=?, eventstatus=?, priority=?, location=?, notime=?, visibility=?, recurringtype=? WHERE activityid=?",array($subject, $activitytype, $date_start, $due_date, $time_start, $time_end, $sendnotification, $duration_hours, $duration_minutes, $status, $priority, $location, $notime, $visibility, $recurringtype, $activityid));
				}
				
					$adb->pquery("UPDATE vtiger_crmentity SET description=? WHERE crmid=?",array($description,$activityid));
				
			}		
		}
		$viewer = $this->getViewer($request);
		if($importedEvents == ''){
			$importedEvents = 0;
		}
		if($importedTasks == ''){
			$importedTasks = 0;
		}
		$viewer->assign('SUCCESS_EVENTS', $importedEvents);
		$viewer->assign('SUCCESS_TASKS', $importedTasks);
		$viewer->view('ImportEventResult.tpl', $moduleName);
	}

}
