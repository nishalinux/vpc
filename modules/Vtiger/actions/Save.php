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
		//echo '<pre>';print_r($request);echo '</pre>';die;

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
	
				#$filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png'
				$fileTmpName='modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png';
				$fileType='.png';
											 

				//$saveAttchment = move_uploaded_file($fileTmpName , $uploadPath.$attachid . "_" . $fileName.'.png');
							//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

							 
				if(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
							 
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
		if( !empty($request->get('imagedata')) ){

			$currentUserModel = Users_Record_Model::getCurrentUserModel();	
			foreach($request->get('imagedata') as $fieldname => $imagedata ){
				if(!empty(trim($imagedata))){
					$data = $imagedata; 				
					$uploadPath = $this->decideFilePath();	
					 
					list($type, $data) = explode(';', $data);
					list(, $data)      = explode(',', $data);
					$data = base64_decode($data);
					 
					
					$userId = $recordModel->get('assigned_user_id');
					
					$fileName=$userId.'_'.$recordModel->getId();
					 

					$relatedRecordId = $recordModel->getId();
					 

					$attachid = $db->getUniqueId('vtiger_crmentity');
					 
								
					if(file_put_contents($uploadPath.$attachid . "_" . $fieldname.'_'.$fileName.'.png',$data)!== false)
					{
						$description = $fileName;
						$date_var = $db->formatDate(date('YmdHis'), true);
						$usetime = $db->formatDate($date_var, true);
						$user_id = $currentUserModel->getId();
						
						$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
						modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
						VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
								array($attachid, $userId, $userId, $userId, "eSignature Attachment", $description, $usetime, $usetime, 1, 0));  
						 $file_name = $fieldname.'_'.$fileName.'.png';
						  
								
						$insert = "INSERT INTO vtiger_attachments (attachmentsid, name, description, type, path) VALUES ($attachid, '".$file_name."' ,'".$description."' ,'image/png', '".$uploadPath."')"; 
						 
						$db->pquery($insert,array());	
						$attachmentId=$attachid;
					}
				 
					// we need tabid 
					//SELECT tabid FROM `vtiger_tab` where name = ''
					$tabid_data = $db->pquery("SELECT tabid FROM `vtiger_tab` where name = ?",array($request->get('module'))); 
					$tabid = $db->fetch_array($tabid_data);
					
				 
					
					//SELECT tablename,columnname FROM `vtiger_field` where uitype = '979' and tabid = 6
					$table_data = $db->pquery("SELECT tablename FROM `vtiger_field` where uitype = '979' and tabid = ? and columnname = ?",array($tabid['tabid'],$fieldname));	
					
					$tabledata = $db->fetch_array($table_data);
					
					//getting firstcoloum of cf any table
					 //SELECT entityidfield  FROM `vtiger_entityname`  where tabid = 6 and modulename = 'Accounts'
					
					$entityidfield = $db->pquery("SELECT entityidfield  FROM `vtiger_entityname`  where tabid = ? and modulename = ? ",array($tabid['tabid'],$request->get('module')));	
					$entityidfield = $db->fetch_array($entityidfield);
					$eid = $entityidfield['entityidfield'];
				 
					$query = "UPDATE ". $tabledata['tablename'] ." SET ".$fieldname." = ?  WHERE 	".$eid ." = ?";
					 
					//$db->pquery($query,array($fieldname.'_'.$fileName.'.png',$recordModel->getId()));
					
					$db->pquery($query,array($uploadPath.$attachid.'_'.$fieldname.'_'.$fileName.'.png',$recordModel->getId()));

					// Link file attached to document
					$attachmentrel = "INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES($relatedRecordId,$attachmentId)";
					$db->pquery($attachmentrel,array()); 
				}
			}
			#end of Jsign
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
