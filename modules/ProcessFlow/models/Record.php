<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class ProcessFlow_Record_Model extends Vtiger_Record_Model {

	/**
	 * Function to get Image Details
	 * @return <array> Image Details List
	 */
	public function getImageDetails($fieldname) {
		$db = PearDatabase::getInstance();
		$imageDetails = array();
		$recordId = $this->getId();

		if ($recordId) {
			$sql = "SELECT vtiger_attachments.*, vtiger_crmentity.setype FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_attachments.attachmentsid
						WHERE vtiger_crmentity.setype = 'ProcessFlow Attachment' AND vtiger_seattachmentsrel.crmid = ? and subject=?";

			$result = $db->pquery($sql, array($recordId,$fieldname));
			$count = $db->num_rows($result);

			for($i=0; $i<$count; $i++) {
				$imageIdsList[] = $db->query_result($result, $i, 'attachmentsid');
				$imagePathList[] = $db->query_result($result, $i, 'path');
				$imageName = $db->query_result($result, $i, 'name');

				//decode_html - added to handle UTF-8 characters in file names
				$imageOriginalNamesList[] = decode_html($imageName);

				//urlencode - added to handle special characters like #, %, etc.,
				$imageNamesList[] = $imageName;
			}

			if(is_array($imageOriginalNamesList)) {
				$countOfImages = count($imageOriginalNamesList);
				for($j=0; $j<$countOfImages; $j++) {
					$imageDetails[] = array(
							'id' => $imageIdsList[$j],
							'orgname' => $imageOriginalNamesList[$j],
							'path' => $imagePathList[$j].$imageIdsList[$j],
							'name' => $imageNamesList[$j]
					);
				}
			}
		}
		return $imageDetails;
	}

	/*get process flow comments id*/

	public function getProcessFlowComments($pid,$recordId)
	{
		global $adb;
		$q = "SELECT vpc.*, vu.user_name, vu.id, va.name as imagename, va.path as imagepath, va.attachmentsid  FROM vtiger_processflow_comments as vpc LEFT JOIN vtiger_users as vu ON vpc.userid = vu.id LEFT JOIN vtiger_salesmanattachmentsrel as vsa ON vu.id = vsa.smid LEFT JOIN vtiger_attachments as va ON va.attachmentsid = vsa.attachmentsid where vpc.processid = ? and vpc.unitprocessid = ? ORDER BY vpc.comment_id  DESC ";
		$queryrun = $adb->pquery($q,array($recordId,$pid));
		$commentsdata = array();
		$i=0;
		while($result = $adb->fetch_array($queryrun)) {
			$commentsdata[$i] = $result;
			$i++;
		}
		return $commentsdata;
	}

	/**
	 * Function to get Gallery Details
	 * @return <array> Gallery Details List
	 */
	public function getGalleryDetails($fieldname) {
		$db = PearDatabase::getInstance();
		$galleryDetails = array();
		$recordId = $this->getId();

		if ($recordId) {
			$sql = "SELECT vtiger_attachments.*, vtiger_crmentity.setype FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_attachments.attachmentsid
						WHERE vtiger_crmentity.setype = 'ProcessFlow Attachment' AND vtiger_seattachmentsrel.crmid = ?  and subject=? ORDER BY subject";

			$result = $db->pquery($sql, array($recordId,$fieldname));
			$count = $db->num_rows($result);

			for($i=0; $i<$count; $i++) {
				$galleryIdsList[] = $db->query_result($result, $i, 'attachmentsid');
				$galleryPathList[] = $db->query_result($result, $i, 'path');
				$galleryName = $db->query_result($result, $i, 'name');
				$galleryField = $db->query_result($result, $i, 'subject');

				//decode_html - added to handle UTF-8 characters in file names
				$galleryOriginalNamesList[] = decode_html($galleryName);

				//urlencode - added to handle special characters like #, %, etc.,
				$galleryNamesList[] = $galleryName;
				$galleryFieldsList[] = $galleryField;
			}

			if(is_array($galleryOriginalNamesList)) {
				$countOfGallerys = count($galleryOriginalNamesList);
				for($j=0; $j<$countOfGallerys; $j++) {
					$galleryDetails[] = array(
							'fieldid' => $galleryFieldsList[$j],
							'id' => $galleryIdsList[$j],
							'orgname' => $galleryOriginalNamesList[$j],
							'path' => $galleryPathList[$j].$galleryIdsList[$j],
							'name' => $galleryNamesList[$j]
					);
				}
			}
		}
		//die(print_r($galleryDetails));
		return $galleryDetails;
	}
public function getGalleryEditDetails() {
		$db = PearDatabase::getInstance();
		//$db->setDebug(true);
		$galleryDetails = array();
		$recordId = $this->getId();
		if ($recordId) {
			$sql = "SELECT vtiger_attachments.*, vtiger_crmentity.setype FROM vtiger_attachments
						INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.attachmentsid = vtiger_attachments.attachmentsid
						INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_attachments.attachmentsid
						WHERE vtiger_crmentity.setype = 'ProcessFlow Attachment' AND vtiger_seattachmentsrel.crmid = ? ORDER BY subject";

			$result = $db->pquery($sql, array($recordId));
			$count = $db->num_rows($result);

			for($i=0; $i<$count; $i++) {
				$galleryIdsList[] = $db->query_result($result, $i, 'attachmentsid');
				$galleryPathList[] = $db->query_result($result, $i, 'path');
				$galleryName = $db->query_result($result, $i, 'name');
				$galleryField = $db->query_result($result, $i, 'subject');

				//decode_html - added to handle UTF-8 characters in file names
				$galleryOriginalNamesList[] = decode_html($galleryName);

				//urlencode - added to handle special characters like #, %, etc.,
				$galleryNamesList[] = $galleryName;
				$galleryFieldsList[] = $galleryField;
			}

			if(is_array($galleryOriginalNamesList)) {
				$countOfGallerys = count($galleryOriginalNamesList);
				for($j=0; $j<$countOfGallerys; $j++) {
					$galleryDetails[] = array(
							'fieldid' => $galleryFieldsList[$j],
							'id' => $galleryIdsList[$j],
							'orgname' => $galleryOriginalNamesList[$j],
							'path' => $galleryPathList[$j].$galleryIdsList[$j],
							'name' => $galleryNamesList[$j],
							'subject' => $galleryFieldsList[$j]
					);
				}
			}
		}
		return $galleryDetails;
	}

	function get($key) {
		$value = parent::get($key);
		$fieldModel = Vtiger_Field_Model::getInstance($key, Vtiger_Module_Model::getInstance($this->getModuleName()));
		$ui='';
		if(!empty($fieldModel))
		$ui=$fieldModel->get('uitype');
		if ($ui==19 || $ui == 540) return decode_html($value);
		return $value;
	}

	public function getHoursMints($total_mints,$format = '%02d:%02d'){
		 
		if ($total_mints < 1) {
			return;
		}
		$hours = floor($total_mints / 60);
		$minutes = ($total_mints % 60);
		return sprintf($format, $hours, $minutes);
	}

	public function getEndTime($start_time,$mints){
		 
		return	date('Y-m-d H:i:s', strtotime("+$mints minutes", strtotime($start_time)));
		 
	}

	public function getProcessStatus($pid,$recordId) { 
		global $adb; 
		//$adb->setDebug(true);
		$q = "SELECT process_status FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and unitprocessid = ? ";
		$result = $adb->pquery($q,array($recordId,$pid));
		$result = $adb->fetch_array($result);
		return $result['process_status'];

	}
	public function getDecisionStatus($pid,$recordId) { 
		global $adb;
		$q = "SELECT count(process_iteration) as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and unitprocessid =(SELECT u.unitprocessid FROM vtiger_processflow_unitprocess u where u.next_process = ?)";
		$result = $adb->pquery($q,array($recordId,$pid));
		$result = $adb->fetch_array($result);
		if($result['total'] == 8) { return true;}else{ return false;}
		 
	}
	public function updateProcessStatus($pid,$recordId) { 
		global $adb;
		$q = "update  vtiger_processflow_unitprocess_instance set process_status=2 where process_instanceid = ? and unitprocessid = ? ";
		$result = $adb->pquery($q,array($recordId,$pid));
		//$result = $adb->fetch_array($result);
		if($result) { return true;}else{ return false;} 
	}
	public function getFullName($uid) { 
		if($uid != ''){ return getUserFullName($uid);}
	}

	public function getCustomFormInfo($masterid, $unitprocessid, $recordId)
	{
		global $adb;
		$mcdata = "SELECT pu.*, pui.* FROM vtiger_processflow_unitprocess pu LEFT JOIN vtiger_processflow_unitprocess_instance pui ON pu.unitprocessid = pui.unitprocessid WHERE pu.processmasterid=? AND pui.process_instanceid=? AND pu.unitprocessid=? order by pu.sequence";
		$mcviewname_result = $adb->pquery($mcdata, array($masterid, $recordId, $unitprocessid));
		$processlist = array();
		$i=0;
		$mcrow = $adb->FetchByAssoc($mcviewname_result);
		$customform = $mcrow['customform'];
		$unit_instance_data = $mcrow['unit_instance_data'];
		$customform = json_decode(stripslashes(html_entity_decode($customform)), true);
		$unit_instance_data = json_decode(stripslashes(html_entity_decode($unit_instance_data)), true);
		foreach($unit_instance_data['quantity_data'] as $k=>$v){ 
			$unit_instance_data['quantity_data_final'][$v['name']] = $v['value'];
		}

		//echo "<pre>"; print_r($customform); echo "</pre>";
		//echo "<pre>"; print_r($unit_instance_data); echo "</pre>";
		$array=array();
		$i = 0;
		foreach ($customform as $key => $item) {
			foreach ($item as $subkey => $data) {
				$name = $data['html']['name'];
				$caption = $data['html']['caption'];
				$type = $data['html']['type'];
				$value = $unit_instance_data['quantity_data_final'][$name];
				
				$array[$i] = array(
					'name' => $name, 
					"caption" => $caption,
					"value" => $value,
					'type' => $type
				);
			$i++;	
			}
		}

		return $array;

	}

	

}
