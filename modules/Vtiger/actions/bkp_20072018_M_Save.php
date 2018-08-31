<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Vtiger_Save_Action extends Vtiger_Action_Controller {

	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$record = $request->get('record');

		if(!Users_Privileges_Model::isPermitted($moduleName, 'Save', $record)) {
			throw new AppException('LBL_PERMISSION_DENIED');
		}
	}

	public function process(Vtiger_Request $request) {
		$recordModel = $this->saveRecord($request);
		if($request->get('relationOperation')) {
			$parentModuleName = $request->get('sourceModule');
			$parentRecordId = $request->get('sourceRecord');
			$parentRecordModel = Vtiger_Record_Model::getInstanceById($parentRecordId, $parentModuleName);
			//TODO : Url should load the related list instead of detail view of record
			if($parentModuleName == "OSSMailView"){
				$loadUrl = "?module=OSSMail&view=index";
			}
			else{
				$loadUrl = $parentRecordModel->getDetailViewUrl();
			}
			
		} else if ($request->get('returnToList')) {
			$loadUrl = $recordModel->getModule()->getListViewUrl();
		} else {
			$loadUrl = $recordModel->getDetailViewUrl();
		}
		header("Location: $loadUrl");
	}

	/**
	 * Function to save record
	 * @param <Vtiger_Request> $request - values of the record
	 * @return <RecordModel> - record Model of saved record
	 */
	public function saveRecord($request) {
		/* --------- Anjaneya Document Module Update Title From Project Task ---------- */
			if($request->get('sourceModule') == 'ProjectTask' && $request->get('module') == 'Documents'){
				$ProjectTask_id = $request->get('sourceRecord');
				$query = 'SELECT projecttaskname FROM `vtiger_projecttask`  where projecttaskid = ?';
				$db = PearDatabase::getInstance();
				$doc_data = $db->pquery($query, array($ProjectTask_id));
				$taskname = $db->query_result($doc_data, 0, 'projecttaskname');
				$doc_type = $request->get('vt_document_type');
				$date = date("Y-m-d h:i:s");
				$docname = $doc_type.'_'.$taskname.'_'.$date;				 
				/*
				$noteId = $recordModel->getId();				 
				$uQuery = 'update vtiger_notes set title= ? where notesid = ?';
				$db->pquery($uQuery, array($docname,$noteId));		
				*/
				$request->set('notes_title',$docname);
				
			}
			/* --------- End Anjaneya Document Module Update Title From Project Task ---------- */
		
		
		
		global $log;
		$db = PearDatabase::getInstance();
		$recordModel = $this->getRecordModelFromRequest($request);
		$recordModel->save();
		if($request->get('relationOperation')) {
			$parentModuleName = $request->get('sourceModule');
			$parentModuleModel = Vtiger_Module_Model::getInstance($parentModuleName);
			$parentRecordId = $request->get('sourceRecord');
			$relatedModule = $recordModel->getModule();
			$relatedRecordId = $recordModel->getId();
			if($parentModuleName == "OSSMailView"){
				OSSMailView_Relation_Model::addRelation($parentRecordId, $relatedRecordId);
			}
			else{
				$relationModel = Vtiger_Relation_Model::getInstance($parentModuleModel, $relatedModule);
				$relationModel->addRelation($parentRecordId, $relatedRecordId);
			}
			
			//echo "</br>".$parentRecordId."</br>".$relatedRecordId;
			//exit;
			
		}
		$log->debug('imageeeeeeeeeeeeeeeeeeeeee$recordModel->getId()eeeeeeeeeeeeeeeeeeeeeeee');
		$log->debug($recordModel->getId());
		$log->debug(print_R($request,TRUE));
				$log->debug('imageeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeessssssssssse');
//added by sl for barcode :start
			if($request->get('module')=='Products' && $request->get('barcode')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
				$data =$request->get('base64') ;
				$uploadPath = decideFilePath();
				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$fileName=$request->get('barcode').'_'.$recordModel->getId();
				$productid=$recordModel->getId();

				$attachid = $db->getUniqueId('vtiger_crmentity');
	
	//$filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png'
				$fileTmpName='modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png';
				$fileType='.png';
											$log->debug($fileTmpName);
																		$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee82eeeeeeeeeeeeeeeeeee');

											$log->debug($uploadPath);
																		$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee86eeeeeeeeeeeeeeeeeee');

											$log->debug($uploadPath.$attachid . "_" . $fileName.'.png');

				//$saveAttchment = move_uploaded_file($fileTmpName , $uploadPath.$attachid . "_" . $fileName.'.png');
							//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee93eeeeeeeeeeeeeeeeeee');
							//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee100eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Products Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Products Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE vtiger_productcf SET cf_971 = ?  WHERE 	productid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($productid, $attachmentId));
			

			}
			//added by sl for barcode :end
			//added by sl for signature :start
			if($request->get('module')=='Invoice' && $request->get('jbase64')!='' && $request->get('module')=='EmployeesandTraining'){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
							$log->debug('savesignatureeeeeeeeeeeeeeeeeeeeeeee132eeeeeeeeeeeeeeeeeee');

				$data =$request->get('jbase64') ;
											$log->debug($data);

				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId();$log->debug($fileName);
				$invoiceid=$recordModel->getId();$log->debug($invoiceid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee153eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Invoice Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Invoice Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE  vtiger_invoicecf SET cf_976 = ?  WHERE 	invoiceid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($invoiceid, $attachmentId));
			
			}
			//added by sl for signature :start
			if($request->get('module')=='EmployeesandTraining' && $request->get('jbase64')!='' ){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
							$log->debug('savesignatureeeeeeeeeeeeeeeeeeeeeeee132eeeeeeeeeeeeeeeeeee');

				$data =$request->get('jbase64') ;
											$log->debug($data);

				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId();$log->debug($fileName);
				$invoiceid=$recordModel->getId();$log->debug($invoiceid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee153eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "EmployeesandTraining Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "EmployeesandTraining Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE  vtiger_employeesandtrainingcf SET cf_2175 = ?  WHERE 	employeesandtrainingid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($invoiceid, $attachmentId));
			
			}
			
			//added by jayant for signature :start--------------------------------------------------------------------------------------Purchaseorder-------------------------------------------------------------------------------------------
			if($request->get('module')=='PurchaseOrder' && $request->get('jbase64')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
							$log->debug('savesignatureeeeeeeeeeeeeeeeeeeeeeee180eeeeeeeeeeeeeeeeeee');

				$data =$request->get('jbase64') ;
											$log->debug($data);

				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId();$log->debug($fileName);
				$purchaseorderid=$recordModel->getId();$log->debug($purchaseorderid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeee205eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "PurchaseOrder Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "PurchaseOrder Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE  vtiger_purchaseordercf SET cf_974 = ?  WHERE 	purchaseorderid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($purchaseorderid, $attachmentId));
			
			}

	//added by jayant for signature :start-------------------------------------------------------------------Project --------------------------------------------------------------------------------------------------------------
			if($request->get('module')=='Project' && $request->get('jbase64')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
							$log->debug('savesignatureeeeeeeeeeeeeeeeeeeeeeee237eeeeeeeeeeeeeeeeeee');

				$data =$request->get('jbase64') ;
											$log->debug($data);

				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId();$log->debug($fileName);
				$projectid=$recordModel->getId();$log->debug($projectid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee256eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE  vtiger_projectcf SET cf_976 = ?  WHERE 	projectid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($projectid, $attachmentId));
			
	}
		//added by jayant for signature :start-------------------------------------------------------------------HelpDesk --------------------------------------------------------------------------------------------------------------
			if($request->get('module')=='HelpDesk' && $request->get('jbase64')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
							$log->debug('savesignatureeeeeeeeeeeeeeeeeeeeeeee286eeeeeeeeeeeeeeeeeee');

				$data =$request->get('jbase64') ;
											$log->debug($data);

				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId();$log->debug($fileName);
				$ticketid=$recordModel->getId();$log->debug($ticketid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee308eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Signature Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Signature Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE  vtiger_ticketcf SET cf_980 = ?  WHERE 	ticketid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($ticketid, $attachmentId));
			
	}
	
	//added by jayant for signature :start-------------------------------------------------------------------Contacts --------------------------------------------------------------------------------------------------------------
			if($request->get('module')=='Contacts' && $request->get('jbase64')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
							$log->debug('savesignatureeeeeeeeeeeeeeeeeeeeeeee338eeeeeeeeeeeeeeeeeee');

				$data =$request->get('jbase64') ;
											$log->debug($data);

				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId();$log->debug($fileName);
				$contactid=$recordModel->getId();$log->debug($contactid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee360eeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Contacts Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Contacts Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;
				}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE  vtiger_contactscf SET cf_978 = ?  WHERE 	contactid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($contactid, $attachmentId));
			
	}
        if($request->get('signDeleted')) {
            $imageIds = $request->get('imageid');
            foreach($imageIds as $imageId) {
                $status = $recordModel->deleteSign($imageId);
            }
        }
			//added by Jayant for signature :end---------------------------------Contacts----------------------------------------------------------------------------

        if($request->get('imgDeleted')) {
            $imageIds = $request->get('imageid');
            foreach($imageIds as $imageId) {
                $status = $recordModel->deleteImage($imageId);
            }
        }
		//added by sl for barcode :start

		if($request->get('barcodeDeleted')) {
            $imageIds = $request->get('imageid');
            foreach($imageIds as $imageId) {
                $status = $recordModel->deleteBarcode($imageId);
            }
        }
		//added by sl for barcode :end

		return $recordModel;
	}

	/**
	 * Function to get the record model based on the request parameters
	 * @param Vtiger_Request $request
	 * @return Vtiger_Record_Model or Module specific Record Model instance
	 */
	protected function getRecordModelFromRequest(Vtiger_Request $request) {

		$moduleName = $request->getModule();
		$recordId = $request->get('record');

		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		if(!empty($recordId)) {
			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			$modelData = $recordModel->getData();
			$recordModel->set('id', $recordId);
			$recordModel->set('mode', 'edit');
		} else {
			$recordModel = Vtiger_Record_Model::getCleanInstance($moduleName);
			$modelData = $recordModel->getData();
			$recordModel->set('mode', '');
		}
        if($moduleName=='Contacts') {
            global $adb;
            $query="SELECT   cf.cf_769 as return_grams,  cf.cf_767 as total_ordered, cf.cf_996 as total_30day_orders
                FROM vtiger_contactscf cf INNER JOIN vtiger_contactdetails  c ON c.contactid=cf.contactid
                INNER JOIN vtiger_crmentity cr ON cr.crmid=c.contactid
                WHERE  cr.deleted=0 and c.contactid=?";
            $rs=$adb->pquery($query,array($recordId));
            $db_return_grams=$adb->query_result($rs,0,'return_grams');
            if($db_return_grams=='') $db_return_grams=0;
            $db_total_ordered=$adb->query_result($rs,0,'total_ordered');
            if($db_total_ordered=='') $db_total_ordered=0;
            $db_total_30day = $adb->query_result($rs,0,'total_30day_orders');
            if($db_total_30day=='') $db_total_30day =0;
        }
        $new_return_grams=0;
		$fieldModelList = $moduleModel->getFields();
		foreach ($fieldModelList as $fieldName => $fieldModel) {
			$fieldValue = $request->get($fieldName, null);
			$fieldDataType = $fieldModel->getFieldDataType();
			if($fieldDataType == 'time'){
				$fieldValue = Vtiger_Time_UIType::getTimeValueWithSeconds($fieldValue);
			}
			if($fieldValue !== null) {
				if(!is_array($fieldValue)) {
					$fieldValue = trim($fieldValue);
				}
                if($moduleName=='Contacts' && $fieldName=='cf_769') {
                    $new_return_grams=$fieldValue;
                }
				$recordModel->set($fieldName, $fieldValue);
			}
		}
        //
       if($moduleName=='Contacts') {
          if($new_return_grams>=0) {
              $new_total_ordered=$db_total_ordered + $db_return_grams - $new_return_grams;
              $recordModel->set('cf_767', $new_total_ordered);
              $new_total_30day=$db_total_30day + $db_return_grams - $new_return_grams;
              $recordModel->set('cf_996', $new_total_30day);
          }
        }
		return $recordModel;
	}
        
        public function validateRequest(Vtiger_Request $request) { 
            return $request->validateWriteAccess(); 
		} 
		public function decideFilePath() 
		{
			return $this->initStorageFileDirectory();
		}
		public function initStorageFileDirectory() {
			$filepath = 'storage/';
	
			$year  = date('Y');
			$month = date('F');
			$day   = date('j');
			$week  = '';
	
			if (!is_dir($filepath . $year)) {
				//create new folder
				mkdir($filepath . $year);
			}
	
			if (!is_dir($filepath . $year . "/" . $month)) {
				//create new folder
				mkdir($filepath . "$year/$month");
			}
	
			if ($day > 0 && $day <= 7)
				$week = 'week1';
			elseif ($day > 7 && $day <= 14)
				$week = 'week2';
			elseif ($day > 14 && $day <= 21)
				$week = 'week3';
			elseif ($day > 21 && $day <= 28)
				$week = 'week4';
			else
				$week = 'week5';
	
			if (!is_dir($filepath . $year . "/" . $month . "/" . $week)) {
				//create new folder
				mkdir($filepath . "$year/$month/$week");
			}
	
			$filepath = $filepath . $year . "/" . $month . "/" . $week . "/";
	
			return $filepath;
		}
}
