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
			$loadUrl = $parentRecordModel->getDetailViewUrl();
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

			$relationModel = Vtiger_Relation_Model::getInstance($parentModuleModel, $relatedModule);
			$relationModel->addRelation($parentRecordId, $relatedRecordId);
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
																		$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee130eeeeeeeeeeeeeeeeeee');

											$log->debug($uploadPath);
																		$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee131eeeeeeeeeeeeeeeeeee');

											$log->debug($uploadPath.$attachid . "_" . $fileName.'.png');

				//$saveAttchment = move_uploaded_file($fileTmpName , $uploadPath.$attachid . "_" . $fileName.'.png');
							//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee132eeeeeeeeeeeeeeeeeee');
							//$log->debug($saveAttchment);
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee133eeeeeeeeeeeeeeeeeee');
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


			$query = "UPDATE vtiger_productcf SET cf_973 = ?  WHERE 	productid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($productid, $attachmentId));
			

			}
			//added by sl for barcode :end
			//added by sl for signature :start
			if($request->get('module')=='Invoice' && $request->get('jbase64')!=''){
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
							$log->debug('saveBarcodeeeeeeeeeeeeeeeeeeeeeeee133eeeeeeeeeeeeeeeeeee');
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

        if($request->get('signDeleted')) {
            $imageIds = $request->get('imageid');
            foreach($imageIds as $imageId) {
                $status = $recordModel->deleteSign($imageId);
            }
        }
			//added by sl for signature :end

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
				$recordModel->set($fieldName, $fieldValue);
			}
		}
		return $recordModel;
	}
        
        public function validateRequest(Vtiger_Request $request) { 
            return $request->validateWriteAccess(); 
        } 
}
