<?php 

class ProcessFlow_AjaxProcessFlow_Action extends Vtiger_Action_Controller{
	
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
	}	
	public function process(Vtiger_Request $request) {
		
		global $db;
        $db = PearDatabase::getInstance();
        
        #ini_set('display_errors','on'); version_compare(PHP_VERSION, '5.5.0') <= 0 ? error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);   // DEBUGGING
        #$db->setDebug(true);

		$mode = $request->get('mode');
		$unitprocessid = $request->get('unitprocessid');
		$unitprocess_data = $this->getUnitProcessData($unitprocessid);
		$process_master_id = $request->get('process_master_id');
		$assignedto = $request->get('assignedto');
		 
		$fdata = array();
		$fdata['unitprocessid'] = $unitprocessid; 
		$fd = json_decode($request->get("formdata"),true);
		$fdata['quantity_data'] = $request->get("formdata");
		//json_decode(stripslashes(html_entity_decode($d)), true);
		$fdata['productid'] = $request->get('productid');
		$formdata = json_encode($fdata);
		
		$recordId = $request->get('recordId');
		$userid = $_SESSION['authenticated_user_id'];
		$response = new Vtiger_Response();
		$current_time = date('Y-m-d H:i:s');
		$products = array();
		$is_final_result = array();
	 
	switch ($mode) {  
		case 'updateProcessData':
			$sql = "UPDATE vtiger_processflow_unitprocess_instance SET  ended_by=$userid, process_status =2, unit_instance_data = ?,assignedto='$assignedto' WHERE unitprocessid=$unitprocessid and process_instanceid=$recordId";
			$result = $db->pquery($sql,array($formdata));
			$responseData = array("message"=>"Success.", 'success'=>true);
		break;

		case 'changeAssigneeUser':	 
			
			$assignee_user_id = $request->get('assignee_user_id');
			/* 
			$p = "DELETE FROM vtiger_processflow_assignee WHERE processflowid = ? and unitprocessid =? and assignee_user_id=?";
			$db->pquery($p,array($recordId,$unitprocessid,$assignee_user_id)); 

			$p = "INSERT INTO vtiger_processflow_assignee (processflowid, unitprocessid, assignee_user_id) VALUES (?, ?, ?)";
			$db->pquery($p,array($recordId,$unitprocessid,$assignee_user_id)); 
			$this->sendMailToAssignee($recordId,$unitprocessid,$assignee_user_id);
			*/

			$q = "UPDATE vtiger_processflow_unitprocess SET  assignedto =  ? WHERE  unitprocessid =?";
			$db->pquery($q,array($assignee_user_id,$unitprocessid)); 
			$this->sendMailToAssignee($recordId,$unitprocessid,$assignee_user_id);
			$responseData = array("message"=>"Task Assigned Successfully.", 'success'=>true);
			 	

		break;
		case 'decisionChose':
			 
			$nextunitprocess = $request->get('nextunitprocess');
			$sql = "UPDATE vtiger_processflow_unitprocess_instance SET  end_time = ?, ended_by=$userid, process_status =2, unit_instance_data =? ,assignedto='$assignedto' WHERE unitprocessid=$unitprocessid and process_instanceid=$recordId";
			$result = $db->pquery($sql,array($current_time,$formdata));
			 
			if($result){ 
				#Start next  Process 
				$p = "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, start_time,process_status, unit_instance_data,process_instanceid,process_iteration,started_by) VALUES (?,?,?,?,?,?,?)";
				$result = $db->pquery($p,array($nextunitprocess,$current_time,1,'',$recordId,1,$userid)); 
			} 

			$responseData = array("message"=>"Success.", 'success'=>true);
			 

		break;
		case 'end_unit_process':
			#checking validations
			$formdata_forchecking  = $fdata['quantity_data'];
			//echo '<pre>';print_r($request);
			if(count($formdata_forchecking) >0){

				//print_r($formdata_forchecking);die;

				foreach($formdata_forchecking as $fname_key=>$fvalue_data){
					if (strpos($fvalue_data['name'], 'product_') !== false) {
						$fnames_split_array = explode("_",$fvalue_data['name']);
						$pid = $fnames_split_array[1];
						if($fvalue_data['value'] > 0){
							$products[$pid] = $fvalue_data['value'];
							$p_qty_check_status =  $this->checkProductQty($pid,$fvalue_data['value']);
							if($p_qty_check_status['status'] == false ){ 
								$responseData = array("message"=>$p_qty_check_status['message'], 'success'=>false);
								$response->setResult($responseData);
								$response->emit();
								die;
							}
						}
					}else if($fvalue_data['name'] == 'enter_final_quantity'){
						$is_final_result[$pid] = $fvalue_data['value'];
					}
				}
			}
			#end validation 

			$nextIdResult = $request->get('nextprocess');
			$doc_id = 0;
			#upload files into documents Module 
			if($_FILES){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
				$moduleName = $request->getModule();
				$folderid = $this->getFolderId();
				require_once 'data/CRMEntity.php';
				require_once 'modules/Documents/Documents.php';
				$result= '';
				$filename=$_FILES['upload_documents']['name'];
				$filesize=$_FILES['upload_documents']['size'];
				$filetmp=$_FILES['upload_documents']['tmp_name'];
				$filetype=$_FILES['upload_documents']['type'];
				$attachmentId = $this->saveAttachment($filename,$filetmp,$filetype);
	
				if($attachmentId > 0) { 
					$document = CRMEntity::getInstance('Documents');
					$document = new Documents();
					$document->column_fields['notes_title']      =   preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);;
					$document->column_fields['filename']         = $filename;
					$document->column_fields['filestatus']       = 1;
					$document->column_fields['filelocationtype'] = 'i';
					$document->column_fields['filedownloadcount']= 0;
					$document->column_fields['folderid']         = $folderid;
					$document->column_fields['filesize']		 = $filesize;
					$document->column_fields['filetype']		 = $filetype;
					$document->column_fields['assigned_user_id'] = $currentUserModel->getId();
					$document->parent_id = $recordId;
					$document->save('Documents');
					
					$query = "UPDATE vtiger_notes SET filename = ? ,filesize = ?, filetype = ? , filelocationtype = ? , filedownloadcount = ?,folderid=? WHERE notesid = ?";
					$db->pquery($query,array(decode_html($filename),$filesize,$filetype,'I',0,$folderid,$document->id));
					#Link file attached to document
					$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
					Array($document->id, $attachmentId));
					$act_doc = 'insert into vtiger_senotesrel values(?,?)';
					$res = $db->pquery($act_doc,array($recordId,$document->id));
					$doc_id = $document->id;
				}
			}

			#end process 		
			$sql = "UPDATE vtiger_processflow_unitprocess_instance SET  end_time =?, ended_by=$userid, process_status =2, unit_instance_data = ? ,assignedto='$assignedto' WHERE unitprocessid=$unitprocessid and process_instanceid=$recordId";
			$result = $db->pquery($sql,array($current_time,$formdata));
			
			#for update formdata
			if($doc_id > 0){
				$q = "INSERT INTO vtiger_processflow_documents (documentid, unitprocessid,process_instanceid) VALUES (?,?,?)";
				$res = $db->pquery($q,array($doc_id,$unitprocessid,$recordId));
			}
			 
			if($result){
				#get Next Process id
				/*$q = "SELECT next_process FROM vtiger_processflow_unitprocess where processmasterid = ? and unitprocessid = ?  ";
				$nextIdResult = $db->pquery($q,array($process_master_id,$unitprocessid));
				$nextIdResult = $db->fetch_array($nextIdResult);				 
				$nextIdResult = $nextIdResult['next_process'];*/
				if( $nextIdResult > 0){
				#Start next  Process 
				$p = "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, start_time,process_status, unit_instance_data,process_instanceid,process_iteration,started_by) VALUES (?,?,?,?,?,?,?)";
				$result = $db->pquery($p,array($nextIdResult,$current_time,1,'',$recordId,1,$userid));

				}
			} 
			$responseData = array("message"=>"Success.", 'success'=>true);
			 

		break;

		case 'decision_end_unit_process':

			#end process 	
			$decision = $request->get('decision');
			$postprocess = $request->get('postprocess');
			$postprocess = explode(',',$postprocess);
			$yes_postprocess = $postprocess[0];
			$no_postprocess = $postprocess[1];
		 
			#get Next Process id
			if($decision == 'yes'){
				$nextProcessId = $yes_postprocess;
				$iteration = 1;
			}else if($decision == 'no'){
				$nextProcessId = $no_postprocess;
				#calicate iteration using $nextProcessId				
				$iteration = $this->getIterationNum($nextProcessId,$recordId);
			} 

			$sql = "UPDATE  vtiger_processflow_unitprocess_instance SET ended_by=$userid, end_time =?, process_status =2,unit_instance_data = ? ,assignedto='$assignedto' WHERE unitprocessid=$unitprocessid and process_instanceid=$recordId";
			$result = $db->pquery($sql,array($current_time,$formdata));
			 
			if($result){ 
				#Start next  Process 
				$q = "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, start_time, process_status, unit_instance_data,process_instanceid,process_iteration,started_by) VALUES (?,?,?,?,?,?,?)";
				$result = $db->pquery($q,array($nextProcessId,$current_time,1,'',$recordId,$iteration,$userid)); 
			}
		 

			$responseData = array("message"=>"Success.", 'success'=>true);
			 	 
		break;
		case 'decision_end_unit_process_no': 
			 
			$sql = "UPDATE  vtiger_processflow_unitprocess_instance SET snooze_interval_count = snooze_interval_count + 1, start_time=? WHERE unitprocessid=$unitprocessid and process_instanceid=$recordId";
			$result = $db->pquery($sql,array($current_time)); 

			$responseData = array("message"=>"Success.", 'success'=>true);
			 	 
		break;  

		case 'branch_process': 
			$runningprocess = $request->get('runningprocess');
			$branchids = $request->get('branchids');
			$branchids_array = explode(',',$branchids); 

			#update main process record status to "waiting for branch process"
			$sql = "UPDATE  vtiger_processflow_unitprocess_instance SET ended_by=$userid, end_time =?, process_status = 4,unit_instance_data=? ,assignedto='$assignedto' WHERE unitprocessid=$unitprocessid and process_instanceid=$recordId";
			$result = $db->pquery($sql,array($current_time,$formdata));
			
			#create all branch recards to waiting list
			foreach($branchids_array as $wpid){
				#check its first insert of not 
				$q = "select * from vtiger_processflow_unitprocess_instance where unitprocessid =? and process_instanceid = ?";
				$result = $db->pquery($q,array($wpid,$recordId)); 
				 
				if($db->num_rows($result) == 0){
					$process_status = 4;
					if($wpid == $runningprocess){
						$process_status = 1;
					}
					$q = "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, start_time, process_status, unit_instance_data,process_instanceid,process_iteration,started_by) VALUES (?,?,?,?,?,?,?)";
					$result = $db->pquery($q,array($wpid,$current_time,$process_status,'',$recordId,1,$userid));
				}else{
					if($wpid == $runningprocess){
						$sql = "UPDATE  vtiger_processflow_unitprocess_instance SET ended_by=$userid, end_time =?, process_status = 1,unit_instance_data=? ,assignedto='$assignedto' WHERE unitprocessid=$wpid and process_instanceid=$recordId";
						$result = $db->pquery($sql,array($current_time,$formdata));
					}
				}
			}
			 

			$responseData = array("message"=>"Success.", 'success'=>true);
			 	 
		break; 

		case 'abort_batch': 

			$q = "update vtiger_processflow set pf_termination = 'Aborted', pf_termination_date = ? where processflowid = ?";
			$db->pquery($q,array($current_time,$recordId));

			#update pending task as abrot			 
			$q = "SELECT unitprocessid FROM vtiger_processflow_unitprocess where unitprocessid not in(SELECT unitprocessid FROM vtiger_processflow_unitprocess_instance where process_instanceid =?)";
			$query = $db->pquery($q,array($recordId));
			 
			while($resultrow = $db->fetch_array($query)){
				$q = "INSERT INTO vtiger_processflow_unitprocess_instance (unitprocessid, process_status, unit_instance_data,process_instanceid,process_iteration,started_by,ended_by) VALUES (?,?,?,?,?,?,?)";
				$db->pquery($q,array($resultrow['unitprocessid'],5,'',$recordId,1,$userid,$userid));					 
			} 

			#update if any Process is running or Waiting
			$sql = "UPDATE  vtiger_processflow_unitprocess_instance SET ended_by=$userid, process_status = 5 WHERE process_status in (1,3,4) and process_instanceid=$recordId";
			$db->pquery($sql,array());

			$responseData = array("message"=>"Success.", 'success'=>true);
			
		break; 

		case 'addCommentProcessFlow' :
			$recordId = $request->get("recordId");
			$unitprocessid = $request->get("unitprocessid");
			$userid = $request->get("userid");
			$comment = $request->get("comment");
			$date_time = time();
			$q = "INSERT INTO vtiger_processflow_comments (processid, unitprocessid, userid, date_time, comments) VALUES (?, ?, ?, ?, ?)";
			$db->pquery($q,array($recordId,$unitprocessid,$userid,$date_time,$comment));
			$result = $db->getLastInsertID();
			if($result != 0 && $result > 0)
			{
				$responseData = array("message"=>"Success.", 'success'=>true);
			}else{
				$responseData = array("message"=>"failure.", 'success'=>false);
			}
        break;
        
        

		default:	

		}
		 
		#if product is selected reduce products quantity in inventry.
		 
		if(count($products) > 0){
			foreach($products as $productid => $qty) {
				$this->updateProductHistory($unitprocessid,$recordId,$qty,$productid);
			}
		}
		

		#if process have final result for create product 
		if(($is_final_result) > 0 ){
			foreach($is_final_result as $name => $qty) {
				if($qty > 0 ){
					$this->createProduct($recordId,$unitprocessid,$qty);
				}
			}
		}

		$response->setResult($responseData);
		$response->emit();
	}	
	public function getStrainName($recordId){
		global $db;	$db = PearDatabase::getInstance();
		$result = $db->pquery("SELECT processflowname,strain_name FROM vtiger_processflow where processflowid = ?",array($recordId));
		$result = $db->fetch_array($result);
		if(trim($result['strain_name']) == '')	{
			return str_replace(' ', '_', $result['processflowname']);
		}	
		return $result['strain_name'];
	}

	public function createProduct($recordId,$unitprocessid,$stock)
	{ 
		include_once 'modules/Products/Products.php';
		global $db;	$db = PearDatabase::getInstance();

		$Strainname = $this->getStrainName($recordId);
		#$name = "$Strainname"."-".date("dmY").'-'.$recordId.'-'.'UCS';
		$name = "$Strainname";
		$new_focus = new Products();
		$new_focus->column_fields['productname'] = $name;
		$new_focus->column_fields['unit_price'] = 0;
		$new_focus->column_fields['qty_per_unit'] = 1; 
		$new_focus->column_fields['qtyinstock'] = $stock;
		$new_focus->save('Products');
		$eventrecordid = $new_focus->id;
		
		return $eventrecordid;
 
	}

	public function getUnitProcessData($unitprocessid){
		global $db;
		$db = PearDatabase::getInstance();
		$q = "SELECT * FROM vtiger_processflow_unitprocess where unitprocessid = ?";
		$result = $db->pquery($q,array($unitprocessid));
		return $db->fetch_array($result);
	}
	
	public function updateProductHistory($unitprocessid,$recordId,$products_count,$productid)
	{
		$db = PearDatabase::getInstance();
		if($products_count > 0){
			$q = "INSERT INTO vtiger_processflow_product_history (unitprocessid, recordId, product_quantity, productid) VALUES (?, ?, ?, ?)";
			$db->pquery($q,array($unitprocessid,$recordId,$products_count,$productid));
			
			$q ="INSERT INTO vtiger_inventoryproductrel (id, productid, quantity) VALUES (?,?,?)";
			$db->pquery($q,array($recordId,$productid,$products_count));

			$q ="UPDATE vtiger_products SET  qtyinstock =  qtyinstock - $products_count WHERE  productid =?";
			$db->pquery($q,array($productid));
		}
		return true;
		
	}

	public function getIterationNum($nextProcessId,$recordId){
		global $db;$db = PearDatabase::getInstance();
		$q = "SELECT count(*)+1 as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and unitprocessid = ?";
		$result = $db->pquery($q,array($nextProcessId,$recordId)); 
		$result =  $db->fetch_array($result);
		return $result['total'];
	}

	public function checkAllProcessStatus($recordId){
		global $adb;
		$current_time = date('Y-m-d H:i:s');
		#checking all the process is done 
		$q = "SELECT count(*) as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and process_status in ('',0,1,3,4)";
		$result = $adb->pquery($q,array($recordId));
		$result = $adb->fetch_assoc($result);
		if($result['total'] == 0){
			#make it as completed 
			$q = "update vtiger_processflow set process_flow_end_time = ? where processflowid = ?";
			$adb->pquery($q,array($current_time,$recordId));
		}
		return true;
	}

	public function sendMailToAssignee($recordId,$unitprocessid,$assignee_user_id){
		
		 
		require_once 'modules/Emails/class.phpmailer.php';
		require_once 'modules/Emails/mail.php';
		global $adb,$site_URL;
		//$adb->serDebug(true);
		 
		$username = getUserFullName($assignee_user_id);
		#$username = getUserName($assignee_user_id);
		$userEmail = getUserEmail($assignee_user_id); 
		$ProcessFlowName = getEntityName('ProcessFlow',$recordId);
		 
		
		# get from email 
		$query = "select from_email_field,server_username from vtiger_systems where server_type=?";
		$params = array('email');
		$result = $adb->pquery($query,$params);
		$from = $adb->query_result($result,0,'from_email_field');
		if($from == '') {$from =$adb->query_result($result,0,'server_username'); }

		#mail
		$subject ='Tasks to Review';				 
		$headers = "From:  ". $from ."\r\n";
		$headers .= "Reply-To: ". $from ."\r\n";
		$headers .= "CC: susan@example.com\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
		
		$message = '<html><body>';				 
		$message .= "<p>Dear $username</p>
		<p><a href='".$site_URL."index.php?module=ProcessFlow&view=Edit&record=$recordId'>$ProcessFlowName[$recordId]</a> Task assigned to you. Please check the task.</p>
		<p><b>Thanks </b></p>
		<p>BMLG Team.</p>";
		$message .= "</body></html>";			 		
		
		$mail = new PHPMailer();
		setMailerProperties($mail,$subject, $message, $from, $username, $userEmail);
		$status = MailSend($mail);

		return true;
	}

	public function getFolderId(){
		global $adb;
		$userid = $_SESSION['authenticated_user_id'];
		$q = "SELECT folderid FROM vtiger_attachmentsfolder where foldername = ? ";
		$result = $adb->pquery($q,array('Process Flow'));
		if($adb->num_rows($result) > 0){
			#return folderid
			return $adb->query_result($result,0,'folderid');
		}else{
			#add 'Process Flow' folder and return folderid
			$q = "INSERT INTO vtiger_attachmentsfolder (foldername, description, createdby, sequence) VALUES (?, ?, ?, (select max(a.sequence)+1 from vtiger_attachmentsfolder a ))";
			$adb->pquery($q,array('Process Flow','Process Flow Processes Documents ',$userid));
			$this->getFolderId();
		}
		 
	}

	public function checkProductQty($productid,$product_quantity){
		$db = PearDatabase::getInstance();
		#$db->setDebug(true);
		$q ="SELECT * FROM vtiger_products where productid = ?";
		$result = $db->pquery($q,array($productid));
		$result = $db->fetch_array($result);            
		$qtyinstock = (int)$result['qtyinstock'];
		$pname = $result['productname'];

		if($qtyinstock >= $product_quantity ){
			$responseData = array("message"=>"Task Assigned Successfully.",'status'=>true);
		}else{
			$responseData = array("message"=>"$product_quantity items of <b>$pname</b> is Not Available, please update stock and try again.",'status'=>false);
		} 
		return $responseData;
	}

	public function saveAttachment($fName,$fileTmpName,$fileType) {
		$db = PearDatabase::getInstance();
		$currentUserModel = Users_Record_Model::getCurrentUserModel();

		$uploadPath = decideFilePath();
		$fileName = $fName;

		if(!empty($fileName)) {
			$attachid = $db->getUniqueId('vtiger_crmentity');

			//sanitize the filename
			$binFile = sanitizeUploadFileName($fileName, vglobal('upload_badext'));
			$fileName = ltrim(basename(" ".$binFile));

			$saveAttchment = move_uploaded_file($fileTmpName , $uploadPath.$attachid . "_" . $binFile);
			if($saveAttchment) {
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Process Flow Attachment", $description, $usetime, $usetime, 1, 0)); 
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName, $description, $fileType, $uploadPath));

				return $attachid;
			}
		}
		return false;
	}
	
}
