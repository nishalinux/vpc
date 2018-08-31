<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/
vimport('~~/libraries/barcode/Barcode39.php');

class Vtiger_MassBarcodeGeneration_Action extends Vtiger_Mass_Action {

	function checkPermission(Vtiger_Request $request) {
		echo "sri";
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

		$currentUserPriviligesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
 	}

	function preProcess(Vtiger_Request $request) {
		return true;
	}

	function postProcess(Vtiger_Request $request) {
		return true;
	}

	public function process(Vtiger_Request $request) {
		global $log;
		$db = PearDatabase::getInstance();
	//	$recordModel = Vtiger_Record_Model::getInstanceById($ids[1], $sourceModule);
		$log->debug('process 34');

		$moduleName = $request->getModule();
				$moduleModel = Vtiger_Module_Model::getInstance($moduleName);

				$log->debug($moduleName);
				$log->debug($request->get('selected_ids') );
				$log->debug($request->get('mode'));

		//
				if($request->get('selected_ids') == 'all' && $request->get('mode') == 'FindDuplicates') {
            $recordIds = Vtiger_FindDuplicate_Model::getMassDeleteRecords($request);
        } else {
            $recordIds = $this->getRecordsListFromRequest($request);
        }
				$log->debug(print_r($recordIds,true));
 					foreach($recordIds as $recordId) {
 				$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleModel);

								$log->debug('for loop 49');

 				$log->debug(print_r($recordModel,true));

			 	$uploadPath = decideFilePath();				$log->debug($uploadPath);

			  	$fileName=$recordModel->get('cf_1297').'_'.$recordModel->getId();$log->debug($fileName);
			 	$attachid = $db->getUniqueId('vtiger_crmentity');$log->debug($attachid);
				$currentUserModel = Users_Record_Model::getCurrentUserModel();
				$productid=$recordModel->getId();
				//added by sl for barcode :end
				$bc = new Barcode39("SriLakshmi"); 

				// display new barcode 
				// set text size 
 
				// save barcode GIF file 
			 	$bc->draw($uploadPath.$attachid . "_" . $fileName.'.png');			
				//(file_put_contents($uploadPath.$attachid . "_" . $fileName.'.png',$data)!== false){
				$description = $fileName;
				$date_var = $db->formatDate(date('YmdHis'), true);
				$usetime = $db->formatDate($date_var, true);
				$log->debug('process 72');

				$db->pquery("INSERT INTO vtiger_crmentity(crmid, smcreatorid, smownerid,
				modifiedby, setype, description, createdtime, modifiedtime, presence, deleted)
				VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)",
						Array($attachid, $currentUserModel->getId(), $currentUserModel->getId(), $currentUserModel->getId(), "Products Attachment", $description, $usetime, $usetime, 1, 0));
				$log->debug('process 78');
				 
				$db->pquery("INSERT INTO vtiger_attachments SET attachmentsid=?, name=?, description=?, type=?, path=?",
						Array($attachid, $fileName.'.png', $description, 'image/png', $uploadPath));
				$attachmentId=$attachid;				$log->debug('process 82');

				//}

			//	file_put_contents('modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png', $data);

			//$attachmentId = $this->saveBarcode($filename,'modules/Products/uploads/'.$request->get('barcode').'_'.$recordModel->getId().'.png','png');


			$query = "UPDATE vtiger_productcf SET cf_958 = ?  WHERE 	productid = ?";
			$db->pquery($query,array($fileName.'.png',$recordModel->getId()));
			// Link file attached to document
			$db->pquery("INSERT INTO vtiger_seattachmentsrel(crmid, attachmentsid) VALUES(?,?)",
			Array($productid, $attachmentId));
			
			
			}
			//added by sl for barcode :end
		$cvId = $request->get('viewname');
		$response = new Vtiger_Response();
		$response->setResult(array('viewname'=>$cvId, 'module'=>'Products'));
		$response->emit();
	}
}
