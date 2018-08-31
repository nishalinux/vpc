<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_Save_Action extends Vtiger_Save_Action {

	public function process(Vtiger_Request $request) {
		global $log;
		$recordModel = $this->saveRecord($request);
		$log->debug($request->get('relationOperation'));
		/* Manasa :: Date :04-12-2017, Products and Products Qty Duplicate purpose */
		$isDuplicate = $request->get('duplicatestatus');
		if($isDuplicate){
			$LastId = $request->get('oldrecord');
			$newId = $recordModel->get('id');
			$this->DuplicateProucts($LastId,$newId);			
		} //end
		if($request->get('relationOperation')) {
			$parentModuleName = $request->get('sourceModule');
			$parentRecordId = $request->get('sourceRecord');
			$parentRecordModel = Vtiger_Record_Model::getInstanceById($parentRecordId, $parentModuleName);
			//TODO : Url should load the related list instead of detail view of record
			$loadUrl = $parentRecordModel->getDetailViewUrl();
		} else if ($request->get('returnToList')) {
			$loadUrl = $recordModel->getModule()->getListViewUrl();
		} else {
			$loadUrl = $recordModel->getDetailViewUrl();
		}
		$log->debug($loadUrl);

		header("Location: $loadUrl");
	}

	/**
	 * Function to save record
	 * @param <Vtiger_Request> $request - values of the record
	 * @return <RecordModel> - record Model of saved record
	 */
	public function saveRecord($request) {
		global $log;
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$recordModel = $this->getRecordModelFromRequest($request);
		$recordModel->save();
		if($request->get('relationOperation')) {
			$parentModuleName = $request->get('sourceModule');
			$parentModuleModel = Vtiger_Module_Model::getInstance($parentModuleName);
			$parentRecordId = $request->get('sourceRecord');
			$relatedModule = $recordModel->getModule();
			$relatedRecordId = $recordModel->getId();

			$relationModel = Vtiger_Relation_Model::getInstance($parentModuleModel, $relatedModule);
			$relationModel->addRelation($parentRecordId, $relatedRecordId);
		}
		
			//added by sl for signature :start
			if($request->get('cf_962')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
				 $data =$request->get('cf_962') ;
				 $uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				
				 $data = base64_decode($data);
				 
				$userId = $recordModel->get('assigned_user_id');
				$fileName=$userId.'_'.$recordModel->getId().'cf_962';
				$projectid=$recordModel->getId();$log->debug($invoiceid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0));
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?,subject=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath,'cf_962'));
				$attachmentId=$attachid;
				}

		
			// Link file attached to document
			$query = "UPDATE vtiger_productcf SET cf_962 = ?  WHERE 	projectid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($projectid, $attachmentId));
			
			}
			if($request->get('cf_1018')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
				$data =$request->get('cf_1018') ;
				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');$log->debug($userId);
				$fileName=$userId.'_'.$recordModel->getId().'cf_1018';$log->debug($fileName);
				$projectid=$recordModel->getId();$log->debug($projectid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
								//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee153eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?,subject=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath,'cf_1018'));
				$attachmentId=$attachid;
				}

		
			// Link file attached to document
			$query = "UPDATE vtiger_productcf SET cf_1018 = ?  WHERE 	projectid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($projectid, $attachmentId));
			
			}
			if($request->get('cf_1022')!=''){
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
				$data =$request->get('cf_1022') ;
				$uploadPath = decideFilePath();		$log->debug($uploadPath);

				list($type, $data) = explode(';', $data);
				list(, $data)      = explode(',', $data);
				$data = base64_decode($data);
				$userId = $recordModel->get('assigned_user_id');
				$fileName=$userId.'_'.$recordModel->getId().'cf_1022';
				$projectid=$recordModel->getId();$log->debug($projectid);

				$attachid = $db->getUniqueId('vtiger_crmentity');
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee153eeeeeeeeeeeeeeeeeee');
							$log->debug('INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES ($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0)');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Project Attachment", $description, $usetime, $usetime, 1, 0));

				 ;
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?,subject=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath,'cf_1022'));
				$attachmentId=$attachid;
				}

		
			// Link file attached to document
			$query = "UPDATE vtiger_productcf SET cf_1022 = ?  WHERE 	projectid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($projectid, $attachmentId));
			
			}
			
        if($request->get('signDeleted')) {
            $imageIds = $request->get('imageid');
            foreach($imageIds as $imageId) {
                $status = $recordModel->deleteSign($imageId);
            }
        }

		return $recordModel;
	}
	//Manasa Added :: 4-12-2017 Products Duplicate Purpose
	public function DuplicateProucts($old_project_id,$new_project_id){
		global $adb, $current_user;
		$produts = "SELECT crmid, module, relcrmid, relmodule FROM vtiger_crmentityrel WHERE crmid=? and relmodule=?";
		$res = $adb->pquery($produts,array($old_project_id,'Products'));
		$rows = $adb->num_rows($res);
		for($i=0;$i<$rows;$i++){
			$relcrmid = $adb->query_result($res,$i,'relcrmid');
			$params = array($new_project_id,'Project',$relcrmid,'Products');
			$adb->pquery("INSERT INTO vtiger_crmentityrel(crmid, module, relcrmid, relmodule) VALUES (?,?,?,?)",$params);
		}
		//To insert respective qty in qty table
		$modulemodel = Project_Module_Model::getInstance("Project");
		$status = $modulemodel->checkProductsQtyStatus($old_project_id);
		//$adb->setDebug(true);
		if($status != true){
			$sql2 = $adb->pquery("SELECT * FROM vtiger_projectproductqty_details WHERE projectid=?",array($old_project_id));
			$frows = $adb->num_rows($sql2);
				if($frows != 0){
					for($i=0;$i<$frows;$i++){
						$productid = $adb->query_result($sql2,$i,'productid');
						$recordModel = Vtiger_Record_Model::getInstanceById($productid, 'Products');
						$prodet = $recordModel->getData();
						$details = array();
						$details[] = $productid;
						$details[] = $new_project_id;
						$details[] = $prodet['product_no'];
						$details[] = $prodet['productname'];
						$details[] = $prodet['qtyinstock'];
						$allocatedqty =  $adb->query_result($sql2,$i,'allocatedtqty');
						$details[] = $allocatedqty;
						$details[] = $adb->query_result($sql2,$i,'is_edit');
						$usedqty = $adb->query_result($sql2,$i,'used_qty');
						$details[] = $usedqty;
						$details[] = $adb->query_result($sql2,$i,'is_checked');
						$adb->pquery("INSERT INTO vtiger_projectproductqty_details(productid, projectid, productnumber, productname, productqty,allocatedtqty,is_edit,used_qty,is_checked) VALUES (?,?,?,?,?,?,?,?,?)",$details);	
						
						//Update product stock
						$productsqty = $adb->query_result($adb->pquery("select qtyinstock from vtiger_products where productid=?",array($productid)),0,'qtyinstock');
						$remaingingqty = $allocatedqty-$usedqty;
						$stockupdate = $productsqty-$allocatedqty+$remaingingqty;
						$adb->pquery("Update vtiger_products set qtyinstock=? where productid=?",array($stockupdate,$productid));
				}
			}
		}
		//exit;
	}
}
