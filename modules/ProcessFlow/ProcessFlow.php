<?php
/*********************************************************************************
 * The contents of this file are subject to the SugarCRM Public License Version 1.1.2
 * ("License"); You may not use this file except in compliance with the
 * License. You may obtain a copy of the License at http://www.sugarcrm.com/SPL
 * Software distributed under the License is distributed on an  "AS IS"  basis,
 * WITHOUT WARRANTY OF ANY KIND, either express or implied. See the License for
 * the specific language governing rights and limitations under the License.
 * The Original Code is:  SugarCRM Open Source
 * The Initial Developer of the Original Code is SugarCRM, Inc.
 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc.;
 * All Rights Reserved.
 * Contributor(s): ______________________________________.
 ********************************************************************************/ 

include_once('config.php');
require_once('include/logging.php');
require_once('include/utils/utils.php');
require_once('user_privileges/default_module_view.php');
require_once('modules/ProcessFlow/PFSaveGridDetails.php'); 
class ProcessFlow extends CRMEntity {
	var $log;
	var $db;
	 
	var $module_name="ProcessFlow";
	var $table_name = "vtiger_processflow";
	var $table_index= 'processflowid';

	var $tab_name = Array('vtiger_crmentity','vtiger_processflow','vtiger_processflowcf');
	var $tab_name_index = Array('vtiger_crmentity'=>'crmid','vtiger_processflow'=>'processflowid','vtiger_processflowcf'=>'processflowid');
	/**
	 * Mandatory table for supporting custom fields.
	 */
	var $customFieldTable = Array('vtiger_processflowcf', 'processflowid');

	var $column_fields = Array();

	var $sortby_fields = Array(
			'processflowname',
			'smownerid'
			);

	var $popup_fields=Array('processflowname');

	// This is the list of vtiger_fields that are in the lists.
	// No fields have been written out by Module DZiner
	var $list_fields = Array(
			'ProcessFlow'=>Array('processflow'=>'processflowname'),
			'Assigned To'=>Array('crmentity','smownerid')
			); 	// Fields selected as INCLUDE FIELDS in Module DZiner will be written out into this array

	var $list_fields_name = Array(
			'ProcessFlow'=>'processflowname',
			'Assigned To'=>'assigned_user_id'
			); 	// Companion Array to $list_fields. Fields selected as INCLUDE FIELDS in Module DZiner will be written out into this array

	var $list_link_field= 'processflowname';

	var $search_fields = Array(
			'ProcessFlow'=>Array('processflow'=>'processflowname')
			); 	// Fields selected as SEARCH FIELDS in Module DZiner will be written out into this array

	var $search_fields_name = Array(
			'ProcessFlow'=>'processflowname'
			); 	// Companion Array to $search_fields. Fields selected as SEARCH FIELDS in Module DZiner will be written out into this array

	var $required_fields =  array();

	// Used when enabling/disabling the mandatory fields for the module.
	// Refers to vtiger_field.fieldname values.
	var $mandatory_fields = Array('assigned_user_id', 'createdtime', 'modifiedtime', 'processflowname');

	//Added these variables which are used as default order by and sortorder in ListView
	var $default_order_by = 'processflowname';
	var $default_sort_order = 'ASC';

	//var $groupTable = Array('vtiger_processflowgrouprelation','processflowid');
	function ProcessFlow() {
		$this->log = LoggerManager::getLogger('processflow');
		$this->db = PearDatabase::getInstance();
		$this->column_fields = getColumnFields('ProcessFlow');
	}

	function save_module($module)
	{
		$file_upload_errors = array( "No errors.", "Larger than upload_max_filesize.", "Larger than form MAX_FILE_SIZE.", "Partial upload.", "No file.", "File is empty.", "No temporary directory.", "Can't write to disk.", "File upload stopped by extension." );
		 

		global $log, $adb;
 
		$tabid=getTabid($module);
		 /*Manasa added Apr 15 2018 :: Gridblocks Save Purpose*/
		if($_REQUEST['action'] != 'ProcessFlowAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW'
					&& $_REQUEST['action'] != 'MassEditSave' && $_REQUEST['action'] != 'ProcessDuplicates'
					&& $_REQUEST['action'] != 'SaveAjax' && $_REQUEST['action'] != 'FROM_WS') {
						
			PFSaveGridDetails($this, 'ProcessFlow');	 

			# for Assignee,raw_materials fields, Anjaneya
			$pf_assignee = $_REQUEST['pf_assignee'];
			
			#$raw_materials = $_REQUEST['raw_materials'];
			$pfid = $this->id;
			if($pf_assignee == null || $pf_assignee == ''){
			}else{
				$adb->pquery("UPDATE vtiger_processflow SET pf_assignee=? WHERE processflowid=?",array($pf_assignee,$pfid));
			}
			#end
		}
		#if Destructed 
		if($_REQUEST['pf_process_status'] == 'Destructed' && ($_REQUEST['action'] != 'ProcessFlowAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW' && $_REQUEST['action'] != 'MassEditSave' && $_REQUEST['action'] != 'ProcessDuplicates' && $_REQUEST['action'] != 'SaveAjax' && $_REQUEST['action'] != 'FROM_WS') )
		{
			$current_time = date('Y-m-d H:i:s');
			$recordId = $this->id;
			$userid = $_SESSION['authenticated_user_id'];
			$q = "update vtiger_processflow set pf_termination = 'Aborted', pf_termination_date = ? where processflowid = ?";
			$adb->pquery($q,array($current_time,$recordId));

			#update pending task as abrot			 
			$q = "SELECT unitprocessid FROM vtiger_processflow_unitprocess where unitprocessid not in(SELECT unitprocessid FROM vtiger_processflow_unitprocess_instance where process_instanceid =?)";
			$query = $adb->pquery($q,array($recordId));
			 
			while($resultrow = $adb->fetch_array($query)){
				$q = "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, process_status, unit_instance_data,process_instanceid,process_iteration,started_by,ended_by) VALUES (?,?,?,?,?,?,?)";
				$adb->pquery($q,array($resultrow['unitprocessid'],5,'',$recordId,1,$userid,$userid));					 
			} 
			#update if any Process is running or Waiting
			$sql = "UPDATE  vtiger_processflow_unitprocess_instance SET ended_by=$userid, process_status = 5 WHERE process_status in (1,3,4) and process_instanceid=$recordId";
			$adb->pquery($sql,array());
		}
		#end Destructed
		#Ended Grid implementation 
		
 
		if ($_REQUEST['ajxaction'] != 'DETAILVIEW')
		{
			// Updating the relations set by UI Type 10 fields
			// get the list of UI Type 10s for this module
			$ui10qry = "select relmodule, module,fieldname from vtiger_fieldmodulerel, vtiger_field where vtiger_fieldmodulerel.fieldid = vtiger_field.fieldid and uitype in (522,10) and module = ?  and vtiger_field.presence !=1";
			//$log->debug("UI10 Query ".print_r($this,true));
			$ui10result = $adb->pquery($ui10qry,Array($module));
			if ($adb->num_rows($ui10result) != 0)
			{
				// Delete rows for current record
				$adb->pquery("DELETE FROM vtiger_crmentityrel WHERE relcrmid = ? AND module=?",Array($this->id,$module));
				while ($relrow = $adb->fetch_array($ui10result))
				{
				//$log->debug("CAME IN REL UPDATE $REQUEST[$relrow['fieldname']],$relrow['relmodule'],$this->id,$module");
				// Insert the row for the current record and relation
				$adb->pquery("insert vtiger_crmentityrel set crmid = ?,  module = ? , relcrmid=?, relmodule = ?",Array($this->column_fields[$relrow['fieldname']],$relrow['relmodule'],$this->id,$module));
				}
			}
			// END Updating the relations set by UI Type 10 fields

			// This section handles the saving of grid block fields
			// We have the block names
			// Presently we handle multiple blocks in the screen
			// get the blocks
			// $gb_result = $adb->query("SHOW COLUMNS FROM `table` LIKE 'fieldname'");
			// $gridexists = ($adb->num_rows($gb_result))?TRUE:FALSE;
			// if ($gridexists) {
			$blockslist = $adb->pquery('SELECT blockid from vtiger_blocks where islist=1 and tabid=?', Array($tabid));
			while ($gridblockinfo = $adb->fetch_array($blockslist)) // FOR EACH GRID BLOCK
			{
				$blockid = $gridblockinfo['blockid'];
				$tablename = 'vtiger_'.strtolower($_REQUEST['module']).'_'.$blockid.'_grid';
				$gt_query="select fieldname from vtiger_field where block=$blockid and tablename = '$tablename' order by sequence;";
				$gt_result=$adb->query($gt_query);
				$fieldscount=$adb->num_rows($gt_result);
				$fieldnames= Array();
				while ($fieldnamesrow=$adb->fetch_array($gt_result)) // FOR EACH FIELD
				{
					$fieldname = $fieldnamesrow['fieldname'];//echo $fieldname.'<br>';
					array_push($fieldnames,$fieldname);
				}
				$fielditer=0;
				//$log->debug("Focus in save_module".print_r($this,true));
				$modulerecordid=$this->id;
				$upd_result=$adb->query("DELETE FROM $tablename WHERE id = ".$modulerecordid);
				for($query_iter=0 ;$query_iter < $_REQUEST[$blockid.'_gridrows']; $query_iter++)
				{
					// executed for each row of grid data.
					// if deleted status is on, there will be no insert
					if ($_REQUEST["deleted_".$blockid."_row_".($query_iter+1)] == 0)
					{
						$qstring="INSERT $tablename SET id = ".$modulerecordid;
						for($field_iter=0;$field_iter < $fieldscount; $field_iter++)
						{
							$gcname = $fieldnames[$field_iter]."_".($query_iter+1);
							// to handle multi select combo value as request array
							// STP 21-12-2012
							//$qstring .= ", ".$fieldnames[$field_iter]." = '".$_REQUEST[$gcname]."'";
							if (is_array($_REQUEST[$gcname])) {
								$field_list = implode(';', $_REQUEST[$gcname]);
							} else {
							$field_list = $_REQUEST[$gcname];
							}
							$fldvalue = $field_list;
							$qstring .= ", ".$fieldnames[$field_iter]." = '".$fldvalue."'";
						}
						$qstring .= "; ";
						$log->debug("Generating query $qstring");
						$upd_result=$adb->query($qstring);
					}
					else
					{
						$log->debug("Did not insert row no ($query_iter+1) found delete flag on");
					}
				}
			}
			//}

			// This section handles the saving of attachments based upon it being a base table value or a custom fields table

			/*foreach($_FILES as $uploadedfield => $uploadedparameters)
			{
				$uploadedfilename=$_FILES[$uploadedfield]['name'];
				$targetname = 'modules/'.$module.'/uploads/'.$_FILES[$uploadedfield]['name'];
				checkFileAccess('modules/'.$module.'/uploads');
				// to update in standard module, to use the table name from vtiger_field
				$tn_query = "select tablename from vtiger_field where fieldname='".$uploadedfield."' and tabid='".$tabid."'";
				$result=$adb->query($tn_query);
				$upd_tablename=$adb->query_result($result,0,'tablename');
				if ($_FILES[$uploadedfield]['error'] == 0 && $upd_tablename != '')
				{
					move_uploaded_file($_FILES[$uploadedfield]['tmp_name'], $targetname);

					$query = 'UPDATE '.$upd_tablename.' set '.$uploadedfield.' = "'.$uploadedfilename.'" WHERE '.$this->table_index.' = '.$this->id.';';
					$result=$adb->query($query);
				}

				if ($_FILES[$uploadedfield]['error'] == 4 && $upd_tablename != '') {
					$hidden_value = $_REQUEST[$uploadedfield.'_hidden'];
					$query = 'UPDATE '.$upd_tablename.' set '.$uploadedfield.' = "'.$hidden_value.'" WHERE '.$this->table_index.' = '.$this->id.';';
					$result=$adb->query($query);
				}

				if ($_FILES[$uploadedfield]['error'] != 0 && $_FILES[$uploadedfield]['error'] != 4)
				{
					$hidden_value = $file_upload_error[$_FILES[$uploadedfield]['error']];
					$query = 'UPDATE '.$upd_tablename.' set '.$uploadedfield.' = "'.$hidden_value.'" WHERE '.$this->table_index.' = '.$this->id.';';
					$result=$adb->query($query);
				}
			}*/
		}
		//$this->insertIntoAttachment($this->id,$_REQUEST['module']);
		$this->insertIntoAttachment($this->id,$module);
	}

function insertIntoAttachment($id,$module) {
	global $log, $adb;
	$log->debug("Entering into insertIntoAttachment($id,$module) method.");
	$log->debug(print_r($_FILES,true));
	$result = Vtiger_Util_Helper::transformUploadedFiles($_FILES, true);
	$log->debug('Transformed\n'.print_r($result,true));
	$file_saved = false;
	$date_var = date("Y-m-d H:i:s");
	global $upload_badext,$current_user,$root_directory;
	$ownerid=$current_user->id;
	/*$recordModel = Vtiger_Record_Model::getInstanceById($id);
	$moduleModel = $recordModel->getModule();*/
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
				$filetmp_name = $_FILES[$filename_fieldname]['tmp_name'];
				$binFile = sanitizeUploadFileName($filename, $upload_badext);
				$filename = ltrim(basename(" ".$binFile)); //allowed filename like UTF-8 characters
				/*$fieldModel = $moduleModel->getField($filename_fieldname);
				$uiType = $fieldModel->get('uitype');*/
				$current_id = $adb->getUniqueID("vtiger_crmentity");
				$upload_file_path = decideFilePath();
				/*
				$upload_status = move_uploaded_file($filetmp_name, $upload_file_path . $current_id . "_" . $binFile);
				$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
				$params1 = array($current_id, $current_user->id, $ownerid, $module . " Attachment","", $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
				$filenamewithpath=$upload_file_path . $current_id . "_" . $binFile;
				*/
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
				if($existing_val!=='') {
					$existing_file=$root_directory.$existing_val;
					if (file_exists($existing_file)) { @unlink($existing_file); }
				}
				$upload_status = move_uploaded_file($filetmp_name, $upload_file_path . $current_id . "_" . $binFile);
				$sql1 = "insert into vtiger_crmentity (crmid,smcreatorid,smownerid,setype,description,createdtime,modifiedtime) values(?, ?, ?, ?, ?, ?, ?)";
				$params1 = array($current_id, $current_user->id, $ownerid, $module . " Attachment","", $adb->formatDate($date_var, true), $adb->formatDate($date_var, true));
				$filenamewithpath=$upload_file_path . $current_id . "_" . $binFile;
				$sql=$adb->pquery("UPDATE $tablename SET $columnname=? WHERE $entityidfield=?",array($filenamewithpath,$this->id));
			}
		}
	}
	//$this->insertIntoAttachment($this->id,$_REQUEST['module']);
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
	* Function to get sort order
	* return string  $sorder    - sortorder string either 'ASC' or 'DESC'
	*/
	function getSortOrder()
	{
		global $log;
                $log->debug("Entering getSortOrder() method ...");
		if(isset($_REQUEST['sorder']))
			$sorder = $this->db->sql_escape_string($_REQUEST['sorder']);
		else
			$sorder = (($_SESSION['PROCESSFLOW_SORT_ORDER'] != '')?($_SESSION['PROCESSFLOW_SORT_ORDER']):($this->default_sort_order));
		$log->debug("Exiting getSortOrder() method ...");
		return $sorder;
	}

	/**
	* Function to get order by
	* return string  $order_by    - fieldname(eg: 'ProcessFlowname')
	*/
	function getOrderBy()
	{
		global $log;
                $log->debug("Entering getOrderBy() method ...");

		$use_default_order_by = '';
		if(PerformancePrefs::getBoolean('LISTVIEW_DEFAULT_SORTING', true)) {
			$use_default_order_by = $this->default_order_by;
		}

		if (isset($_REQUEST['order_by']))
			$order_by = $this->db->sql_escape_string($_REQUEST['order_by']);
		else
			$order_by = (($_SESSION['PROCESSFLOW_ORDER_BY'] != '')?($_SESSION['PROCESSFLOW_ORDER_BY']):($use_default_order_by));
		$log->debug("Exiting getOrderBy method ...");
		return $order_by;
	}

	/** Function to create list query
	* @param reference variable - where condition is passed when the query is executed
	* Returns Query.
	*/
	function create_list_query($order_by, $where)
	{
		global $log,$current_user;
		require('user_privileges/user_privileges_'.$current_user->id.'.php');
	        require('user_privileges/sharing_privileges_'.$current_user->id.'.php');
        	$tab_id = getTabid("ProcessFlow");
		$log->debug("Entering create_list_query(".$order_by.",". $where.") method ...");
		// Determine if the vtiger_account name is present in the where clause.
		$account_required = preg_match("/accounts\.name/", $where);

		if($account_required)
		{
			$query = "SELECT vtiger_processflow.processflowid,  vtiger_processflow.processflowname, vtiger_processflow.dateclosed FROM vtiger_processflow, vtiger_account ";
			$where_auto = "vtiger_crmentity.deleted=0 ";
		}
		else
		{
			$query = 'SELECT vtiger_processflow.processflowid, vtiger_processflow.processflowname, vtiger_crmentity.smcreatorid FROM vtiger_processflow inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_processflow.processflowid LEFT JOIN vtiger_groups on vtiger_groups.groupid = vtiger_crmentity.smownerid left join vtiger_users on vtiger_users.id = vtiger_crmentity.smownerid ';
			$where_auto = ' AND vtiger_crmentity.deleted=0';
		}

		$query .= $this->getNonAdminAccessControlQuery('ProcessFlow',$current_user);
		if($where != "")
			$query .= " where $where ".$where_auto;
		else
			$query .= " where ".$where_auto;
		if($order_by != "")
			$query .= " ORDER BY $order_by";

		$log->debug("Exiting create_list_query method ...");
		return $query;
	}

	/** Function to export the Opportunities records in CSV Format
	* @param reference variable - order by is passed when the query is executed
	* @param reference variable - where condition is passed when the query is executed
	* Returns Export ProcessFlow Query.
	*/
	function create_export_query($where)
	{
		global $log;
		global $current_user;
		$log->debug("Entering create_export_query(". $where.") method ...");

		include("include/utils/ExportUtils.php");

		//To get the Permitted fields query and the permitted fields list
		$sql = getPermittedFieldsQuery("ProcessFlow", "detail_view");
		$fields_list = getFieldsListFromQuery($sql);

		$query = "SELECT $fields_list,case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name
				FROM vtiger_processflow
				inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_processflow.processflowid
				LEFT JOIN vtiger_users ON vtiger_crmentity.smownerid=vtiger_users.id
				LEFT JOIN vtiger_processflowcf on vtiger_processflowcf.processflowid=vtiger_processflow.processflowid
                LEFT JOIN vtiger_groups
        	        ON vtiger_groups.groupid = vtiger_crmentity.smownerid";

		$query .= $this->getNonAdminAccessControlQuery('ProcessFlow',$current_user);
		$where_auto = "  vtiger_crmentity.deleted = 0 ";

                if($where != "")
                   $query .= "  WHERE ($where) AND ".$where_auto;
                else
                   $query .= "  WHERE ".$where_auto;

		$log->debug("Exiting create_export_query method ...");
		return $query;

	}



	/** Returns a list of the associated contacts
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_contacts($id, $cur_tab_id, $rel_tab_id, $actions=false) {
		global $log, $singlepane_view,$currentModule,$current_user;
		$log->debug("Entering get_contacts(".$id.") method ...");
		$this_module = $currentModule;

        $related_module = vtlib_getModuleNameById($rel_tab_id);
		require_once("modules/$related_module/$related_module.php");
		$other = new $related_module();
        vtlib_setup_modulevars($related_module, $other);
		$singular_modname = vtlib_toSingular($related_module);

		$parenttab = getParentTab();

		if($singlepane_view == 'true')
			$returnset = '&return_module='.$this_module.'&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module='.$this_module.'&return_action=CallRelatedList&return_id='.$id;

		$button = '';

		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab$search_string','test','width=640,height=602,resizable=0,scrollbars=0');\" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($related_module) ."'>&nbsp;";
			}
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_ADD_NEW'). " ". getTranslatedString($singular_modname) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
		}

		$query = 'select case when (vtiger_users.user_name not like "") then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
					vtiger_contactdetails.accountid,vtiger_processflow.processflowid, vtiger_processflow.processflowname, vtiger_contactdetails.contactid,
					vtiger_contactdetails.lastname, vtiger_contactdetails.firstname, vtiger_contactdetails.title, vtiger_contactdetails.department,
					vtiger_contactdetails.email, vtiger_contactdetails.phone, vtiger_crmentity.crmid, vtiger_crmentity.smownerid,
					vtiger_crmentity.modifiedtime , vtiger_account.accountname from vtiger_processflow
					inner join vtiger_contprocessflowrel on vtiger_contprocessflowrel.processflowid = vtiger_processflow.processflowid
					inner join vtiger_contactdetails on vtiger_contprocessflowrel.contactid = vtiger_contactdetails.contactid
					inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_contactdetails.contactid
					left join vtiger_account on vtiger_account.accountid = vtiger_contactdetails.accountid
					left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid
					left join vtiger_users on vtiger_crmentity.smownerid=vtiger_users.id
					where vtiger_processflow.processflowid = '.$id.' and vtiger_crmentity.deleted=0';

		$return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;

		$log->debug("Exiting get_contacts method ...");
		return $return_value;
	}

	/** Returns a list of the associated calls
	 * Portions created by SugarCRM are Copyright (C) SugarCRM, Inc..
	 * All Rights Reserved..
	 * Contributor(s): ______________________________________..
	 */
	function get_activities($id, $cur_tab_id, $rel_tab_id, $actions=false) {
		global $log, $singlepane_view,$currentModule,$current_user;
		$log->debug("Entering get_activities(".$id.") method ...");
		$this_module = $currentModule;

        $related_module = vtlib_getModuleNameById($rel_tab_id);
		require_once("modules/$related_module/Activity.php");
		$other = new Activity();
        vtlib_setup_modulevars($related_module, $other);
		$singular_modname = vtlib_toSingular($related_module);

		$parenttab = getParentTab();

		if($singlepane_view == 'true')
			$returnset = '&return_module='.$this_module.'&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module='.$this_module.'&return_action=CallRelatedList&return_id='.$id;

		$button = '';

		$button .= '<input type="hidden" name="activity_mode">';

		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_NEW'). " ". getTranslatedString('LBL_TODO', $related_module) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\";this.form.return_module.value=\"$this_module\";this.form.activity_mode.value=\"Task\";' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString('LBL_TODO', $related_module) ."'>&nbsp;";
				$button .= "<input title='".getTranslatedString('LBL_NEW'). " ". getTranslatedString('LBL_TODO', $related_module) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\";this.form.return_module.value=\"$this_module\";this.form.activity_mode.value=\"Events\";' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString('LBL_EVENT', $related_module) ."'>";
			}
		}

		$query = "SELECT vtiger_activity.activityid as 'tmp_activity_id',vtiger_activity.*,vtiger_seactivityrel.*, vtiger_contactdetails.lastname,vtiger_contactdetails.firstname,
					vtiger_cntactivityrel.*, vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_crmentity.modifiedtime,
					case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
					vtiger_recurringevents.recurringtype from vtiger_activity
					inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid
					inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_activity.activityid
					left join vtiger_cntactivityrel on vtiger_cntactivityrel.activityid = vtiger_activity.activityid
					left join vtiger_contactdetails on vtiger_contactdetails.contactid = vtiger_cntactivityrel.contactid
					inner join vtiger_processflow on vtiger_processflow.processflowid=vtiger_seactivityrel.crmid
					left join vtiger_users on vtiger_users.id=vtiger_crmentity.smownerid
					left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid
					left outer join vtiger_recurringevents on vtiger_recurringevents.activityid=vtiger_activity.activityid
					where vtiger_seactivityrel.crmid=".$id." and vtiger_crmentity.deleted=0
					and ((vtiger_activity.activitytype='Task' and vtiger_activity.status not in ('Completed','Deferred'))
					or (vtiger_activity.activitytype NOT in ('Emails','Task') and  vtiger_activity.eventstatus not in ('','Held'))) ";

		$return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;

		$log->debug("Exiting get_activities method ...");
		return $return_value;
	}

	 /**
	 * Function to get Contact related Products
	 * @param  integer   $id  - contactid
	 * returns related Products record in array format
	 */
	function get_products($id, $cur_tab_id, $rel_tab_id, $actions=false) {
		global $log, $singlepane_view,$currentModule,$current_user;
		$log->debug("Entering get_products(".$id.") method ...");
		$this_module = $currentModule;

        $related_module = vtlib_getModuleNameById($rel_tab_id);
		require_once("modules/$related_module/$related_module.php");
		$other = new $related_module();
        vtlib_setup_modulevars($related_module, $other);
		$singular_modname = vtlib_toSingular($related_module);

		$parenttab = getParentTab();

		if($singlepane_view == 'true')
			$returnset = '&return_module='.$this_module.'&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module='.$this_module.'&return_action=CallRelatedList&return_id='.$id;

		$button = '';

		if($actions) {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab','test','width=640,height=602,resizable=0,scrollbars=0');\" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($related_module) ."'>&nbsp;";
			}
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_ADD_NEW'). " ". getTranslatedString($singular_modname) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
		}

		$query = "SELECT vtiger_products.productid, vtiger_products.productname, vtiger_products.productcode,
				vtiger_products.commissionrate, vtiger_products.qty_per_unit, vtiger_products.unit_price,
				vtiger_crmentity.crmid, vtiger_crmentity.smownerid
			   FROM vtiger_products
			   INNER JOIN vtiger_seproductsrel ON vtiger_products.productid = vtiger_seproductsrel.productid and vtiger_seproductsrel.setype = 'ProcessFlow'
			   INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid
			   INNER JOIN vtiger_processflow ON vtiger_processflow.processflowid = vtiger_seproductsrel.crmid
			   WHERE vtiger_crmentity.deleted = 0 AND vtiger_processflow.processflowid = $id";

		$return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;

		$log->debug("Exiting get_products method ...");
		return $return_value;
	}


	/**
	* Function to get ProcessFlow related Task & Event which have activity type Held, Completed or Deferred.
	* @param  integer   $id
	* returns related Task or Event record in array format
	*/
	function get_history($id)
	{
			global $log;
			$log->debug("Entering get_history(".$id.") method ...");
			$query = "SELECT vtiger_activity.activityid, vtiger_activity.subject, vtiger_activity.status,
		vtiger_activity.eventstatus, vtiger_activity.activitytype,vtiger_activity.date_start,
		vtiger_activity.due_date, vtiger_activity.time_start,vtiger_activity.time_end,
		vtiger_crmentity.modifiedtime, vtiger_crmentity.createdtime,
		vtiger_crmentity.description,case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name
				from vtiger_activity
				inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid
				inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_activity.activityid
				left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid
				left join vtiger_users on vtiger_users.id=vtiger_crmentity.smownerid
				where (vtiger_activity.activitytype != 'Emails')
				and (vtiger_activity.status = 'Completed' or vtiger_activity.status = 'Deferred' or (vtiger_activity.eventstatus = 'Held' and vtiger_activity.eventstatus != ''))
				and vtiger_seactivityrel.crmid=".$id."
                                and vtiger_crmentity.deleted = 0";
		//Don't add order by, because, for security, one more condition will be added with this query in include/RelatedListView.php

		$log->debug("Exiting get_history method ...");
		return getHistory('ProcessFlow',$query,$id);
	}


	  /**
	  * Function to get ProcessFlow related Quotes
	  * @param  integer   $id  - processflowid
	  * returns related Quotes record in array format
	  */
	function get_quotes($id, $cur_tab_id, $rel_tab_id, $actions=false) {
		global $log, $singlepane_view,$currentModule,$current_user;
		$log->debug("Entering get_quotes(".$id.") method ...");
		$this_module = $currentModule;

        $related_module = vtlib_getModuleNameById($rel_tab_id);
		require_once("modules/$related_module/$related_module.php");
		$other = new $related_module();
        vtlib_setup_modulevars($related_module, $other);
		$singular_modname = vtlib_toSingular($related_module);

		$parenttab = getParentTab();

		if($singlepane_view == 'true')
			$returnset = '&return_module='.$this_module.'&return_action=DetailView&return_id='.$id;
		else
			$returnset = '&return_module='.$this_module.'&return_action=CallRelatedList&return_id='.$id;

		$button = '';

		if($actions && getFieldVisibilityPermission($related_module, $current_user->id, 'processflow_id') == '0') {
			if(is_string($actions)) $actions = explode(',', strtoupper($actions));
			if(in_array('SELECT', $actions) && isPermitted($related_module,4, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_SELECT')." ". getTranslatedString($related_module). "' class='crmbutton small edit' type='button' onclick=\"return window.open('index.php?module=$related_module&return_module=$currentModule&action=Popup&popuptype=detailview&select=enable&form=EditView&form_submit=false&recordid=$id&parenttab=$parenttab','test','width=640,height=602,resizable=0,scrollbars=0');\" value='". getTranslatedString('LBL_SELECT'). " " . getTranslatedString($related_module) ."'>&nbsp;";
			}
			if(in_array('ADD', $actions) && isPermitted($related_module,1, '') == 'yes') {
				$button .= "<input title='".getTranslatedString('LBL_ADD_NEW'). " ". getTranslatedString($singular_modname) ."' class='crmbutton small create'" .
					" onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\"' type='submit' name='button'" .
					" value='". getTranslatedString('LBL_ADD_NEW'). " " . getTranslatedString($singular_modname) ."'>&nbsp;";
			}
		}

		$query = "select case when (vtiger_users.user_name not like '') then vtiger_users.user_name else vtiger_groups.groupname end as user_name,
					vtiger_account.accountname, vtiger_crmentity.*, vtiger_quotes.*, vtiger_processflow.processflowname from vtiger_quotes
					inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_quotes.quoteid
					left outer join vtiger_processflow on vtiger_processflow.processflowid=vtiger_quotes.processflowid
					left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid
					left join vtiger_users on vtiger_users.id=vtiger_crmentity.smownerid
					inner join vtiger_account on vtiger_account.accountid=vtiger_quotes.accountid
					where vtiger_crmentity.deleted=0 and vtiger_processflow.processflowid=".$id;

		$return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

		if($return_value == null) $return_value = Array();
		$return_value['CUSTOM_BUTTON'] = $button;

		$log->debug("Exiting get_quotes method ...");
		return $return_value;
	}

	/**
	 * Move the related records of the specified list of id's to the given record.
	 * @param String This module name
	 * @param Array List of Entity Id's from which related records need to be transfered
	 * @param Integer Id of the the Record to which the related records are to be moved
	 */
	function transferRelatedRecords($module, $transferEntityIds, $entityId) {
		global $adb,$log;
		$log->debug("Entering function transferRelatedRecords ($module, $transferEntityIds, $entityId)");

		$rel_table_arr = Array("Activities"=>"vtiger_seactivityrel","Contacts"=>"vtiger_contprocessflowrel","Products"=>"vtiger_seproductsrel",
						"Attachments"=>"vtiger_seattachmentsrel","Quotes"=>"vtiger_quotes","SalesOrder"=>"vtiger_salesorder",
						"Documents"=>"vtiger_senotesrel");

		$tbl_field_arr = Array("vtiger_seactivityrel"=>"activityid","vtiger_contprocessflowrel"=>"contactid","vtiger_seproductsrel"=>"productid",
						"vtiger_seattachmentsrel"=>"attachmentsid","vtiger_quotes"=>"quoteid","vtiger_salesorder"=>"salesorderid",
						"vtiger_senotesrel"=>"notesid");

		$entity_tbl_field_arr = Array("vtiger_seactivityrel"=>"crmid","vtiger_contprocessflowrel"=>"processflowid","vtiger_seproductsrel"=>"crmid",
						"vtiger_seattachmentsrel"=>"crmid","vtiger_quotes"=>"processflowid","vtiger_salesorder"=>"processflowid",
						"vtiger_senotesrel"=>"crmid");

		foreach($transferEntityIds as $transferId) {
			foreach($rel_table_arr as $rel_module=>$rel_table) {
				$id_field = $tbl_field_arr[$rel_table];
				$entity_id_field = $entity_tbl_field_arr[$rel_table];
				// IN clause to avoid duplicate entries
				$sel_result =  $adb->pquery("select $id_field from $rel_table where $entity_id_field=? " .
						" and $id_field not in (select $id_field from $rel_table where $entity_id_field=?)",
						array($transferId,$entityId));
				$res_cnt = $adb->num_rows($sel_result);
				if($res_cnt > 0) {
					for($i=0;$i<$res_cnt;$i++) {
						$id_field_value = $adb->query_result($sel_result,$i,$id_field);
						$adb->pquery("update $rel_table set $entity_id_field=? where $entity_id_field=? and $id_field=?",
							array($entityId,$transferId,$id_field_value));
					}
				}
			}
		}
		$log->debug("Exiting transferRelatedRecords...");
	}

	/*
	 * Function to get the secondary query part of a report
	 * @param - $module primary module name
	 * @param - $secmodule secondary module name
	 * returns the query string formed on fetching the related data for report for secondary module
	 */
	function generateReportsSecQuery($module,$secmodule){
		$query = $this->getRelationQuery($module,$secmodule,"vtiger_processflow","processflowid");
		$query .= " left join vtiger_crmentity as vtiger_crmentityProcessFlow on vtiger_crmentityProcessFlow.crmid=vtiger_processflow.processflowid and vtiger_crmentityProcessFlow.deleted=0
		left join vtiger_processflowcf on vtiger_processflowcf.processflowid = vtiger_processflow.processflowid
		left join vtiger_groups vtiger_groupsProcessFlow on vtiger_groupsProcessFlow.groupid = vtiger_crmentityProcessFlow.smownerid
		left join vtiger_users as vtiger_usersProcessFlow on vtiger_usersProcessFlow.id = vtiger_crmentityProcessFlow.smownerid";
		return $query;
	}

	/*
	 * Function to get the relation tables for related modules
	 * @param - $secmodule secondary module name
	 * returns the array with table names and fieldnames storing relations between module and this module
	 */
	function setRelationTables($secmodule){
		$rel_tables = array (
			"Calendar" => array("vtiger_seactivityrel"=>array("crmid","activityid"),"vtiger_processflow"=>"processflowid"),
			"Products" => array("vtiger_seproductsrel"=>array("crmid","productid"),"vtiger_processflow"=>"processflowid"),
			"Quotes" => array("vtiger_quotes"=>array("processflowid","quoteid"),"vtiger_processflow"=>"processflowid"),
			"SalesOrder" => array("vtiger_salesorder"=>array("processflowid","salesorderid"),"vtiger_processflow"=>"processflowid"),
			"Documents" => array("vtiger_senotesrel"=>array("crmid","notesid"),"vtiger_processflow"=>"processflowid"),
		);
		return $rel_tables[$secmodule];
	}

	// Function to unlink all the dependent entities of the given Entity by Id
	function unlinkDependencies($module, $id) {
		global $log;
		/*//Backup Activity-ProcessFlow Relation
		$act_q = "select activityid from vtiger_seactivityrel where crmid = ?";
		$act_res = $this->db->pquery($act_q, array($id));
		if ($this->db->num_rows($act_res) > 0) {
			for($k=0;$k < $this->db->num_rows($act_res);$k++)
			{
				$act_id = $this->db->query_result($act_res,$k,"activityid");
				$params = array($id, RB_RECORD_DELETED, 'vtiger_seactivityrel', 'crmid', 'activityid', $act_id);
				$this->db->pquery("insert into vtiger_relatedlists_rb values (?,?,?,?,?,?)", $params);
			}
		}
		$sql = 'delete from vtiger_seactivityrel where crmid = ?';
		$this->db->pquery($sql, array($id));*/

		parent::unlinkDependencies($module, $id);
	}

	/**
	 * Get list view query.
	 */
	function getListQuery($module, $where='') {
		$query = "SELECT vtiger_crmentity.*, $this->table_name.*";

		// Select Custom Field Table Columns if present
		if(!empty($this->customFieldTable)) $query .= ", " . $this->customFieldTable[0] . ".* ";

		$query .= " FROM $this->table_name";

		$query .= "	INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = $this->table_name.$this->table_index";

		// Consider custom table join as well.
		if(!empty($this->customFieldTable)) {
			$query .= " INNER JOIN ".$this->customFieldTable[0]." ON ".$this->customFieldTable[0].'.'.$this->customFieldTable[1] .
				      " = $this->table_name.$this->table_index";
		}
		//$query .= " LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_service.handler";
		global $current_user;
		$query .= $this->getNonAdminAccessControlQuery($module,$current_user);
		$query .= "WHERE vtiger_crmentity.deleted = 0 ".$where;
		return $query;
	}

	// Function to unlink an entity with given Id from another entity
	function unlinkRelationship($id, $return_module, $return_id) {
		global $log;
		if(empty($return_module) || empty($return_id)) return;

		if($return_module == 'Accounts') {
			$this->trash($this->module_name, $id);
		}  elseif($return_module == 'Products') {
			$sql = 'DELETE FROM vtiger_seproductsrel WHERE crmid=? AND productid=?';
			$this->db->pquery($sql, array($id, $return_id));
		} elseif($return_module == 'Contacts') {
			$sql = 'DELETE FROM vtiger_contprocessflowrel WHERE processflowid=? AND contactid=?';
			$this->db->pquery($sql, array($id, $return_id));

		} else {
			$sql = 'DELETE FROM vtiger_crmentityrel WHERE (crmid=? AND relmodule=? AND relcrmid=?) OR (relcrmid=? AND module=? AND crmid=?)';
			$params = array($id, $return_module, $return_id, $id, $return_module, $return_id);
			$this->db->pquery($sql, $params);
		}
	}
	function save_related_module($module, $crmid, $with_module, $with_crmids) {
		$adb = PearDatabase::getInstance();
		if(!is_array($with_crmids)) $with_crmids = Array($with_crmids);
		foreach($with_crmids as $with_crmid) {
				parent::save_related_module($module, $crmid, $with_module, $with_crmid);
		}
	}

	function whomToSendMail($module,$insertion_mode,$assigntype)
	{
 	//do not send any mail
	}

	/**
	 * Initialize this instance for importing.
	 */
	function initImport($module) {
		$this->db = PearDatabase::getInstance();
		$this->initImportableFields($module);
	}
}
?>
