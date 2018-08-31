<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/
class ProjectTask extends CRMEntity {
    var $db, $log; // Used in class functions of CRMEntity

    var $table_name = 'vtiger_projecttask';
    var $table_index= 'projecttaskid';
    var $column_fields = Array();

    /** Indicator if this is a custom module or standard module */
    var $IsCustomModule = true;

    /**
     * Mandatory table for supporting custom fields.
     */
    var $customFieldTable = Array('vtiger_projecttaskcf', 'projecttaskid');

    /**
     * Mandatory for Saving, Include tables related to this module.
     */
    var $tab_name = Array('vtiger_crmentity', 'vtiger_projecttask', 'vtiger_projecttaskcf');

    /**
     * Mandatory for Saving, Include tablename and tablekey columnname here.
     */
    var $tab_name_index = Array(
        'vtiger_crmentity' => 'crmid',
        'vtiger_projecttask'   => 'projecttaskid',
        'vtiger_projecttaskcf' => 'projecttaskid');

    /**
     * Mandatory for Listing (Related listview)
     */
    var $list_fields = Array (
        /* Format: Field Label => Array(tablename, columnname) */
        // tablename should not have prefix 'vtiger_'
        'Project Task Name'=> Array('projecttask', 'projecttaskname'),
        'Start Date'=> Array('projecttask', 'startdate'),
        'End Date'=> Array('projecttask', 'enddate'),
        'Type'=>Array('projecttask','projecttasktype'),
        'Progress'=>Array('projecttask','projecttaskprogress'),
        'Assigned To' => Array('crmentity','smownerid')

    );
    var $list_fields_name = Array(
        /* Format: Field Label => fieldname */
        'Project Task Name'=> 'projecttaskname',
        'Start Date'=>'startdate',
        'End Date'=> 'enddate',
        'Type'=>'projecttasktype',
        'Progress'=>'projecttaskprogress',
        'Assigned To' => 'assigned_user_id'
    );

    // Make the field link to detail view from list view (Fieldname)
    var $list_link_field = 'projecttaskname';

    // For Popup listview and UI type support
    var $search_fields = Array(
        /* Format: Field Label => Array(tablename, columnname) */
        // tablename should not have prefix 'vtiger_'
        'Project Task Name'=> Array('projecttask', 'projecttaskname'),
        'Start Date'=> Array('projecttask', 'startdate'),
        'Type'=>Array('projecttask','projecttasktype'),
        'Assigned To' => Array('crmentity','smownerid')
    );
    var $search_fields_name = Array(
        /* Format: Field Label => fieldname */
        'Project Task Name'=> 'projecttaskname',
        'Start Date'=>'startdate',
        'Type'=>'projecttasktype',
        'Assigned To' => 'assigned_user_id'
    );

    // For Popup window record selection
    var $popup_fields = Array('projecttaskname');

    // Placeholder for sort fields - All the fields will be initialized for Sorting through initSortFields
    var $sortby_fields = Array();

    // For Alphabetical search
    var $def_basicsearch_col = 'projecttaskname';

    // Column value to use on detail view record text display
    var $def_detailview_recname = 'projecttaskname';

    // Required Information for enabling Import feature
    var $required_fields = Array('projecttaskname'=>1);

    // Callback function list during Importing
    var $special_functions = Array('set_import_assigned_user');

    var $default_order_by = 'projecttaskname';
    var $default_sort_order='ASC';
    // Used when enabling/disabling the mandatory fields for the module.
    // Refers to vtiger_field.fieldname values.
    var $mandatory_fields = Array('createdtime', 'modifiedtime', 'projecttaskname', 'projectid', 'assigned_user_id');

    function __construct() {
        global $log, $currentModule;
        $this->column_fields = getColumnFields(get_class($this));
        $this->db = PearDatabase::getInstance();
        $this->log = $log;
    }
/*
   function save_module($module) {
		global $log, $adb;
		 
		$log->debug("Entering into save_module($module) method.");
		$tabid=getTabid($module);
	  $this->insertIntoAttachment($this->id,$module);
	 
    } */
	function save_module($module) {
		global $log,$adb;
		//$this->insertIntoAttachment($this->id,$module);//Added by sl for custom image field
		//Multpli assigned to users
		$usersgridinfo = array();
		foreach ($_REQUEST as $key => $value) {
			if (strpos($key, 'task_userid') === 0) {
				$usersgridinfo[$key] = $value;
			}
		}
		if(count($usersgridinfo) != 0){
			$delsql = "DELETE FROM vtiger_usersprojecttasksrel WHERE projecttaskid=?";
			$adb->pquery($delsql,array($this->id));
		}
		$projecttaskid = $this->id;
		$seq = 0;
		
		foreach($usersgridinfo as $key => $value){
			$gu_info = array();
			if($value != 0){
				$seq = $seq+1;
				
				$gu_info[] = $projecttaskid;
				$gu_info[] = $seq;
				$gu_info[] = $_REQUEST['task_userid'.$value];
				
				$gu_info[] = $_REQUEST['task_allocatedhours'.$value];
				$gu_info[] = $_REQUEST['task_workedhours'.$value];
				$gu_info[] = $_REQUEST['taskstatus'.$value];
				
				if($_REQUEST['task_startdate'.$value] != ''){
					$gu_info[] = date('Y-m-d',strtotime($_REQUEST['task_startdate'.$value]));
				}else{
					$gu_info[] = null;
				}
				if($_REQUEST['task_enddate'.$value] != ''){
					$gu_info[] = date('Y-m-d',strtotime($_REQUEST['task_enddate'.$value]));
				}else{
					$gu_info[] = null;
				}
				
				$gu_info[] = $_REQUEST['notification'.$value];
				//print_r($gu_info);
				$adb->pquery("INSERT INTO vtiger_usersprojecttasksrel(projecttaskid, seq, userid, allocated_hours, worked_hours, status, start_date, end_date,notification) VALUES (". generateQuestionMarks($gu_info) .")",$gu_info);
			}
			$gu_info = '';
		}
		
		$pcm_assignee = $_REQUEST['pcm_assignee'];
		$adb->pquery("UPDATE vtiger_projecttaskcf SET pcm_assignee=? WHERE projecttaskid=?",array($pcm_assignee,$projecttaskid));
	
    }
	
	function insertIntoAttachment($id,$module) {
		
	global $log, $adb;
	//$adb->setDebug(true);
	$log->debug("Entering into insertIntoAttachment($id,$module) method.");
	$log->debug(print_r($_FILES,true));
	$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
	$log->debug('Transformed\n'.print_r($result,true));
//	print_r($result);
	$file_saved = false;
	$date_var = date("Y-m-d H:i:s");
	global $upload_badext,$current_user,$root_directory;
	$ownerid=$current_user->id;
	foreach($_FILES as $fileindex => $files) {
		if($files['name'] != '' && $files['size'] > 0){
			$filename_fieldname=$fileindex;
			if (is_array($files['name'])) {
				foreach($result[$filename_fieldname] as $subfileindex => $subfiles) {
					if($subfiles['name'] != '' && $subfiles['size'] > 0) {
						if($_REQUEST[$subfileindex.'_hidden'] != '')
							$subfiles['original_name'] = vtlib_purify($_REQUEST[$subfileindex.'_hidden']);
						else
							$subfiles['original_name'] = stripslashes($subfiles['name']);
							$subfiles['original_name'] = str_replace('"','',$subfiles['original_name']);
						$file_saved = $this->uploadAndSaveFile($id,$module,$subfiles, $filename_fieldname);
					}
				}
				//Remove the deleted vtiger_attachments from db - Products
				if($_REQUEST['del_file_list'] != '') {
					$del_file_list = explode("###",trim($_REQUEST['del_file_list'],"###"));
					foreach($del_file_list as $del_file_name) {
						$attach_res = $adb->pquery("select vtiger_attachments.attachmentsid from vtiger_attachments inner join vtiger_seattachmentsrel on vtiger_attachments.attachmentsid=vtiger_seattachmentsrel.attachmentsid where crmid=? and name=?", array($id,$del_file_name));
						$attachments_id = $adb->query_result($attach_res,0,'attachmentsid');
						$del_res1 = $adb->pquery("delete from vtiger_attachments where attachmentsid=?", array($attachments_id));
						$del_res2 = $adb->pquery("delete from vtiger_seattachmentsrel where attachmentsid=?", array($attachments_id));
					}
				}
			} else {
				$filename = $_FILES[$filename_fieldname]['name'];
				$filename = from_html(preg_replace('/\s+/', '_', $filename));
				$filetype = $_FILES[$filename_fieldname]['type'];
				$filesize = $_FILES[$filename_fieldname]['size'];
				$fileerror = $_FILES[$filename_fieldname]['error'];
				$filetmp_name = $_FILES[$filename_fieldname]['tmp_name'];
				$binFile = sanitizeUploadFileName($filename, $upload_badext);
				$filename = ltrim(basename(" ".$binFile)); //allowed filename like UTF-8 characters
				/*$fieldModel = $moduleModel->getField($filename_fieldname);
				$uiType = $fieldModel->get('uitype');*/
				//$current_id = $adb->getUniqueID("vtiger_crmentity");
				$upload_file_path = decideFilePath();
				$tabid = getTabid($module);
				$sql=$adb->pquery("SELECT tablename,columnname FROM vtiger_field WHERE tabid=? AND fieldname=?",array($tabid,$filename_fieldname));
				if($adb->num_rows($sql)>0) {
					$resultinfo = $adb->fetch_array($sql);
					$tablename=$resultinfo["tablename"];
					$columnname=$resultinfo["columnname"];
				}
				$sql=$adb->pquery("SELECT entityidfield FROM vtiger_entityname WHERE modulename=?",array($module));
				if($adb->num_rows($sql)>0) {
					$resultinfo = $adb->fetch_array($sql);
					$entityidfield=$resultinfo["entityidfield"];
				}
				$sql_chk= $adb->pquery("SELECT $columnname FROM $tablename WHERE $entityidfield=?",array($this->id));
				$resultinfo_chk = $adb->fetch_array($sql_chk);
				$existing_val=$resultinfo_chk[$columnname];
				if($existing_val!=='' && $fileerror == 0) {
					$existing_file=$root_directory.$existing_val;
					//if (file_exists($existing_file)) { @unlink($existing_file); }
				}
				$current_id = $this->id."_".$columnname;
				$upload_status = move_uploaded_file($filetmp_name, $upload_file_path . $current_id . "_" . $binFile);
				if($fileerror == 0){
					$filenamewithpath=$upload_file_path . $current_id . "_" . $binFile;
					$sql=$adb->pquery("UPDATE $tablename SET $columnname=? WHERE $entityidfield=?",array($filenamewithpath,$this->id));
				}
			}
		}
	}
	//exit;
	$log->debug("Exiting from insertIntoAttachment($id,$module) method.");
}

	/**
	 *      This function is used to upload the attachment in the server and save that attachment information in db.
	 *      @param int $id  - entity id to which the file to be uploaded
	 *      @param string $module  - the current module name
	 *      @param array $file_details  - array which contains the file information(name, type, size, tmp_name and error)
	 *      return void
	 */
	function uploadAndSaveFile($id, $module, $file_details, $fieldname) {
		global $log;
		$log->debug("Entering into uploadAndSaveFile($id,$module,$file_details) method.");
		global $adb, $current_user;
		global $upload_badext;
		$date_var = date("Y-m-d H:i:s");
		//to get the owner id
		$ownerid = $this->column_fields['assigned_user_id'];
		if (!isset($ownerid) || $ownerid == '')
			$ownerid = $current_user->id;
		if (isset($file_details['original_name']) && $file_details['original_name'] != null) {
			$file_name = $file_details['original_name'];
		} else {
			$file_name = $file_details['name'];
		}
		$binFile = sanitizeUploadFileName($file_name, $upload_badext);
		$current_id = $adb->getUniqueID("vtiger_crmentity");
		$filename = ltrim(basename(" " . $binFile)); //allowed filename like UTF-8 characters
		$filetype = $file_details['type'];
		$filesize = $file_details['size'];
		$filetmp_name = $file_details['tmp_name'];
		//get the file path inwhich folder we want to upload the file
		$upload_file_path = decideFilePath();
		//upload the file in server
		$upload_status = move_uploaded_file($filetmp_name, $upload_file_path . $current_id . "_" . $binFile);
		$save_file = 'true';
		//only images are allowed for these modules
		if ($module == 'Contacts' || $module == 'Products') {
			$save_file = validateImageFile($file_details);
		}
		if ($save_file == 'true' && $upload_status == 'true') {
			//This is only to update the attached filename in the vtiger_notes vtiger_table for the Notes module
			if ($module == 'Contacts' || $module == 'Products') {
				$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
				$params1 = array($current_id, $current_user->id, $ownerid, $module . " Image", $this->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
			} else {
				$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
				$params1 = array($current_id, $current_user->id, $ownerid, $module . " Attachment", $this->column_fields['description'], $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
			}
			$adb->pquery($sql1, $params1);
			$sql2 = "insert into vtiger_attachments(attachmentsid, name, description, type, path, subject) values(?, ?, ?, ?, ?, ?)";
			$params2 = array($current_id, $filename, $this->column_fields['description'], $filetype, $upload_file_path, $fieldname);
			$result = $adb->pquery($sql2, $params2);
			if ($_REQUEST['mode'] == 'edit') {
				if ($id != '' && vtlib_purify($_REQUEST['fileid']) != '') {
					$delquery = 'delete from vtiger_seattachmentsrel where crmid = ? and attachmentsid = ?';
					$delparams = array($id, vtlib_purify($_REQUEST['fileid']));
					$adb->pquery($delquery, $delparams);
				}
			}
			$sql3 = 'insert into vtiger_seattachmentsrel values(?,?)';
			$adb->pquery($sql3, array($id, $current_id));
			return true;
		} else {
			$log->debug("Skip the save attachment process.");
			return false;
		}
	}


    /**
     * Return query to use based on given modulename, fieldname
     * Useful to handle specific case handling for Popup
     */
    function getQueryByModuleField($module, $fieldname, $srcrecord) {
        // $srcrecord could be empty
    }

    /**
     * Get list view query (send more WHERE clause condition if required)
     */
    function getListQuery($module, $where='') {
		$query = "SELECT vtiger_crmentity.*, $this->table_name.*";

		// Keep track of tables joined to avoid duplicates
		$joinedTables = array();

		// Select Custom Field Table Columns if present
		if(!empty($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";

		$query .= " FROM $this->table_name";

		$query .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";

		$joinedTables[] = $this->table_name;
		$joinedTables[] = 'vtiger_crmentity';

		// Consider custom table join as well.
		if(!empty($this->customFieldTable)) {
			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index";
			$joinedTables[] = $this->customFieldTable[0];
		}
		$query .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid";
		$query .= " LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";

		$joinedTables[] = 'vtiger_users';
		$joinedTables[] = 'vtiger_groups';

		$linkedModulesQuery = $this->db->pquery("SELECT distinct fieldname, columnname, relmodule FROM vtiger_field" .
				" INNER JOIN vtiger_fieldmodulerel ON vtiger_fieldmodulerel.fieldid = vtiger_field.fieldid" .
				" WHERE uitype='10' AND vtiger_fieldmodulerel.module=?", array($module));
		$linkedFieldsCount = $this->db->num_rows($linkedModulesQuery);

		for($i=0; $i<$linkedFieldsCount; $i++) {
			$related_module = $this->db->query_result($linkedModulesQuery, $i, 'relmodule');
			$fieldname = $this->db->query_result($linkedModulesQuery, $i, 'fieldname');
			$columnname = $this->db->query_result($linkedModulesQuery, $i, 'columnname');

			$other =  CRMEntity::getInstance($related_module);
			vtlib_setup_modulevars($related_module, $other);

			if(!in_array($other->table_name, $joinedTables)) {
				$query .= " LEFT JOIN $other->table_name ON $other->table_name.$other->table_index = $this->table_name.$columnname";
				$joinedTables[] = $other->table_name;
			}
		}

		global $current_user;
		$query .= $this->getNonAdminAccessControlQuery($module,$current_user);
		$query .= "	WHERE vtiger_crmentity.deleted = 0 ".$usewhere;
		return $query;
    }

    /**
     * Apply security restriction (sharing privilege) query part for List view.
     */
    function getListViewSecurityParameter($module) {
        global $current_user;
        require('user_privileges/user_privileges_'.$current_user->id.'.php');
        require('user_privileges/sharing_privileges_'.$current_user->id.'.php');

        $sec_query = '';
        $tabid = getTabid($module);

        if($is_admin==false && $profileGlobalPermission[1] == 1 && $profileGlobalPermission[2] == 1
            && $defaultOrgSharingPermission[$tabid] == 3) {

                $sec_query .= " AND (vtiger_crmentity.smownerid in($current_user->id) OR vtiger_crmentity.smownerid IN
                    (
                        SELECT vtiger_user2role.userid FROM vtiger_user2role
                        INNER JOIN vtiger_users ON vtiger_users.id=vtiger_user2role.userid
                        INNER JOIN vtiger_role ON vtiger_role.roleid=vtiger_user2role.roleid
                        WHERE vtiger_role.parentrole LIKE '".$current_user_parent_role_seq."::%'
                    )
                    OR vtiger_crmentity.smownerid IN
                    (
                        SELECT shareduserid FROM vtiger_tmp_read_user_sharing_per
                        WHERE userid=".$current_user->id." AND tabid=".$tabid."
                    )
                    OR
                        (";

                    // Build the query based on the group association of current user.
                    if(sizeof($current_user_groups) > 0) {
                        $sec_query .= " vtiger_groups.groupid IN (". implode(",", $current_user_groups) .") OR ";
                    }
                    $sec_query .= " vtiger_groups.groupid IN
                        (
                            SELECT vtiger_tmp_read_group_sharing_per.sharedgroupid
                            FROM vtiger_tmp_read_group_sharing_per
                            WHERE userid=".$current_user->id." and tabid=".$tabid."
                        )";
                $sec_query .= ")
                )";
        }
        return $sec_query;
    }

    /**
     * Create query to export the records.
     */
    function create_export_query($where)
    {
		global $current_user;

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery('ProjectTask', "detail_view");

		$fields_list = getFieldsListFromQuery($sql);

		$query = "SELECT $fields_list, vtiger_users.user_name AS user_name
					FROM vtiger_crmentity INNER JOIN $this->table_name ON vtiger_crmentity.crmid=$this->table_name.$this->table_index";

		if(!empty($this->customFieldTable)) {
			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index";
		}

		$query .= " LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";
		$query .= " LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid = vtiger_users.id and vtiger_users.status='Active'";

		$linkedModulesQuery = $this->db->pquery("SELECT distinct fieldname, columnname, relmodule FROM vtiger_field" .
				" INNER JOIN vtiger_fieldmodulerel ON vtiger_fieldmodulerel.fieldid = vtiger_field.fieldid" .
				" WHERE uitype='10' AND vtiger_fieldmodulerel.module=?", array($thismodule));
		$linkedFieldsCount = $this->db->num_rows($linkedModulesQuery);

		for($i=0; $i<$linkedFieldsCount; $i++) {
			$related_module = $this->db->query_result($linkedModulesQuery, $i, 'relmodule');
			$fieldname = $this->db->query_result($linkedModulesQuery, $i, 'fieldname');
			$columnname = $this->db->query_result($linkedModulesQuery, $i, 'columnname');

			$other = CRMEntity::getInstance($related_module);
			vtlib_setup_modulevars($related_module, $other);

			$query .= " LEFT JOIN $other->table_name ON $other->table_name.$other->table_index = $this->table_name.$columnname";
		}

		$query .= $this->getNonAdminAccessControlQuery($thismodule,$current_user);
		$where_auto = " vtiger_crmentity.deleted=0";

		if($where != '') $query .= " WHERE ($where) AND $where_auto";
		else $query .= " WHERE $where_auto";

		return $query;
    }

    /**
     * Transform the value while exporting
     */
    function transform_export_value($key, $value) {
        return parent::transform_export_value($key, $value);
    }

    /**
     * Function which will give the basic query to find duplicates
     */
    function getDuplicatesQuery($module,$table_cols,$field_values,$ui_type_arr,$select_cols='') {
		$select_clause = "SELECT ". $this->table_name .".".$this->table_index ." AS recordid, vtiger_users_last_import.deleted,".$table_cols;

		// Select Custom Field Table Columns if present
		if(isset($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";

		$from_clause = " FROM $this->table_name";

		$from_clause .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";

		// Consider custom table join as well.
		if(isset($this->customFieldTable)) {
			$from_clause .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index";
		}
		$from_clause .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid
						LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid";

		$where_clause = "	WHERE vtiger_crmentity.deleted = 0";
		$where_clause .= $this->getListViewSecurityParameter($module);

		if (isset($select_cols) && trim($select_cols) != '') {
			$sub_query = "SELECT $select_cols FROM  $this->table_name AS t " .
				" INNER JOIN vtiger_crmentity AS crm ON crm.crmid = t.".$this->table_index;
			// Consider custom table join as well.
			if(isset($this->customFieldTable)) {
				$sub_query .= " LEFT JOIN ".$this->customFieldTable[0]." tcf ON tcf.".$this->customFieldTable[1]." = t.$this->table_index";
			}
			$sub_query .= " WHERE crm.deleted=0 GROUP BY $select_cols HAVING COUNT(*)>1";
		} else {
			$sub_query = "SELECT $table_cols $from_clause $where_clause GROUP BY $table_cols HAVING COUNT(*)>1";
		}


		$query = $select_clause . $from_clause .
					" LEFT JOIN vtiger_users_last_import ON vtiger_users_last_import.bean_id=" . $this->table_name .".".$this->table_index .
					" INNER JOIN (" . $sub_query . ") AS temp ON ".get_on_clause($field_values,$ui_type_arr,$module) .
					$where_clause .
					" ORDER BY $table_cols,". $this->table_name .".".$this->table_index ." ASC";

		return $query;
	}

    /**
     * Invoked when special actions are performed on the module.
     * @param String Module name
     * @param String Event Type (module.postinstall, module.disabled, module.enabled, module.preuninstall)
     */
    function vtlib_handler($modulename, $event_type) {
		global $adb;
        if($event_type == 'module.postinstall') {
			$projectTaskResult = $adb->pquery('SELECT tabid FROM vtiger_tab WHERE name=?', array('ProjectTask'));
			$projecttaskTabid = $adb->query_result($projectTaskResult, 0, 'tabid');

			// Mark the module as Standard module
			$adb->pquery('UPDATE vtiger_tab SET customized=0 WHERE name=?', array($modulename));

			if(getTabid('CustomerPortal')) {
				$checkAlreadyExists = $adb->pquery('SELECT 1 FROM vtiger_customerportal_tabs WHERE tabid=?', array($projecttaskTabid));
				if($checkAlreadyExists && $adb->num_rows($checkAlreadyExists) < 1) {
					$maxSequenceQuery = $adb->query("SELECT max(sequence) as maxsequence FROM vtiger_customerportal_tabs");
					$maxSequence = $adb->query_result($maxSequenceQuery, 0, 'maxsequence');
					$nextSequence = $maxSequence+1;
					$adb->query("INSERT INTO vtiger_customerportal_tabs(tabid,visible,sequence) VALUES ($projecttaskTabid,1,$nextSequence)");
					$adb->query("INSERT INTO vtiger_customerportal_prefs(tabid,prefkey,prefvalue) VALUES ($projecttaskTabid,'showrelatedinfo',1)");
				}
			}

			$modcommentsModuleInstance = Vtiger_Module::getInstance('ModComments');
			if($modcommentsModuleInstance && file_exists('modules/ModComments/ModComments.php')) {
				include_once 'modules/ModComments/ModComments.php';
				if(class_exists('ModComments')) ModComments::addWidgetTo(array('ProjectTask'));
			}

			$result = $adb->pquery("SELECT 1 FROM vtiger_modentity_num WHERE semodule = ? AND active = 1", array($modulename));
			if (!($adb->num_rows($result))) {
				//Initialize module sequence for the module
				$adb->pquery("INSERT INTO vtiger_modentity_num values(?,?,?,?,?,?)", array($adb->getUniqueId("vtiger_modentity_num"), $modulename, 'PT', 1, 1, 1));
			}
        } else if($event_type == 'module.disabled') {
            // TODO Handle actions when this module is disabled.
        } else if($event_type == 'module.enabled') {
            // TODO Handle actions when this module is enabled.
        } else if($event_type == 'module.preuninstall') {
            // TODO Handle actions when this module is about to be deleted.
        } else if($event_type == 'module.preupdate') {
            // TODO Handle actions before this module is updated.
        } else if($event_type == 'module.postupdate') {

			$modcommentsModuleInstance = Vtiger_Module::getInstance('ModComments');
			if($modcommentsModuleInstance && file_exists('modules/ModComments/ModComments.php')) {
				include_once 'modules/ModComments/ModComments.php';
				if(class_exists('ModComments')) ModComments::addWidgetTo(array('ProjectTask'));
			}

			$result = $adb->pquery("SELECT 1 FROM vtiger_modentity_num WHERE semodule = ? AND active = 1", array($modulename));
			if (!($adb->num_rows($result))) {
				//Initialize module sequence for the module
				$adb->pquery("INSERT INTO vtiger_modentity_num values(?,?,?,?,?,?)", array($adb->getUniqueId("vtiger_modentity_num"), $modulename, 'PT', 1, 1, 1));
			}
        }
    }

	/**
	 * Function to check the module active and user action permissions before showing as link in other modules
	 * like in more actions of detail view(Projects).
	 */
	static function isLinkPermitted($linkData) {
		$moduleName = "ProjectTask";
		if(vtlib_isModuleActive($moduleName) && isPermitted($moduleName, 'EditView') == 'yes') {
			return true;
		}
		return false;
	}

    /**
     * Handle saving related module information.
     * NOTE: This function has been added to CRMEntity (base class).
     * You can override the behavior by re-defining it here.
     */
    // function save_related_module($module, $crmid, $with_module, $with_crmid) { }

    /**
     * Handle deleting related module information.
     * NOTE: This function has been added to CRMEntity (base class).
     * You can override the behavior by re-defining it here.
     */
    //function delete_related_module($module, $crmid, $with_module, $with_crmid) { }

    /**
     * Handle getting related list information.
     * NOTE: This function has been added to CRMEntity (base class).
     * You can override the behavior by re-defining it here.
     */
    //function get_related_list($id, $cur_tab_id, $rel_tab_id, $actions=false) { }

    /**
     * Handle getting dependents list information.
     * NOTE: This function has been added to CRMEntity (base class).
     * You can override the behavior by re-defining it here.
     */
    //function get_dependents_list($id, $cur_tab_id, $rel_tab_id, $actions=false) { }
}
?>
