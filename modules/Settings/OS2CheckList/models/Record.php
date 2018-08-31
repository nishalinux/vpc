<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_Record_Model extends Settings_Vtiger_Record_Model{
    
    public function getId() {
        return $this->get('checklistid');
    }
    
    public function getName() {
        return $this->get('checklistname');
    }
    
	public function getDeleteStatus() {
        if($this->has('deleted')) {
            return $this->get('deleted');
        }
        //by default non deleted
        return 0;
    }
	
	public function getRecordLinks() {

        $editLink = array(
            'linkurl' => "javascript:Settings_OS2CheckList_Js.triggerEdit(event, '".$this->getId()."')",
            'linklabel' => 'LBL_EDIT',
            'linkicon' => 'icon-pencil'
        );
        $editLinkInstance = Vtiger_Link_Model::getInstanceFromValues($editLink);
        
        $deleteLink = array(
            'linkurl' => "javascript:Settings_OS2CheckList_Js.triggerDelete(event,'".$this->getId()."')",
            'linklabel' => 'LBL_DELETE',
            'linkicon' => 'icon-trash'
        );
        $deleteLinkInstance = Vtiger_Link_Model::getInstanceFromValues($deleteLink);
        return array($editLinkInstance,$deleteLinkInstance);
    }
	
	public function save() {
        $db = PearDatabase::getInstance();
		$db->setDebug(true);
        //$id = $this->getId();
        $tableName = 'vtiger_checklistdetails';
		
		$record 	  = $this->get('checklistid');
		$category     = base64_encode(serialize($this->get('category')));
		$count        = ($this->get('count')+ 1);
		//$category     = json_encode($this->get('category'),JSON_FORCE_OBJECT);
		$title        = base64_encode(serialize($this->get('title')));
		$allow_upload = base64_encode(serialize($this->get('allow_upload')));
		$allow_note   = base64_encode(serialize($this->get('allow_note')));
		$description  = base64_encode(serialize($this->get('description')));
		
		$createdtime  = Date('Y-m-d H:i:s');
		
		$category_se     = $this->get('category');
		$title_se        = $this->get('title');
		$allow_upload_se = $this->get('allow_upload');
		$allow_note_se   = $this->get('allow_note');
		$description_se  = $this->get('description');
			
        if(!empty($record)) {
            $query = "UPDATE $tableName SET checklistname=?, modulename=?, category=?, title=?, allow_upload=?, allow_note=?, description=? WHERE checklistid=?" ;
            $params = array($this->get('checklistname'), $this->get('modulename'), $category, $title, $allow_upload, $allow_note, $description, $record );
			$db->pquery($query,$params);
			$db->pquery("DELETE FROM vtiger_checklist_related WHERE checklistid=?",array($record));
			
			for($j=0;$j<count($category_se);$j++){	
				
				$db->pquery("INSERT INTO vtiger_checklist_related VALUES(?,?,?,?,?,?,?)",array($record,$j,$category_se[$j],$title_se[$j],$description_se[$j],$allow_upload_se[$j], $allow_note_se[$j]));
				
			}
	
        }else {   
			$id = $db->getUniqueID($tableName);
            $query = 'INSERT INTO '. $tableName .' VALUES(?,?,?,?,?,?,?,?,?,?,?,?)';
            $params = array($id, $this->get('checklistname'), $this->get('modulename'), $category, $title, $allow_upload, $allow_note, $description, $createdtime, 'Active', $count, 0);
			$db->pquery($query,$params);
			
			for($j=0;$j<count($category_se);$j++){	

				$q2 = $db->pquery("SELECT * FROM vtiger_checklist_related WHERE checklistid=? AND sequence=?",array($id, $j));
				if($db->num_rows($q2) == 0){
					$db->pquery("INSERT INTO vtiger_checklist_related VALUES(?,?,?,?,?,?,?)",array($id,$j,$category_se[$j],$title_se[$j],$description_se[$j],$allow_upload_se[$j], $allow_note_se[$j]));
				}
			}		
        }
		
        $db->pquery($query,$params);
        return $id;
    }

    public static function getInstance($id) {
        $db = PearDatabase::getInstance();
        if(Vtiger_Utils::isNumber($id)){
            $query = 'SELECT * FROM ' . Settings_OS2CheckList_Module_Model::tableName . ' WHERE checklistid=?';
        }/*else{
            $query = 'SELECT * FROM ' . Settings_CheckList_Module_Model::tableName . ' WHERE checklistname=?';
        }*/
        
        $params = array($id);
        $result = $db->pquery($query,$params);
        if($db->num_rows($result) > 0) {
            $instance = new self();
            $row = $db->query_result_rowdata($result,0);
            $instance->setData($row);
        }
        return $instance;
    }
    
	public static function getAll() {
        $db = PearDatabase::getInstance();
        
        $query = 'SELECT * FROM '.Settings_OS2CheckList_Module_Model::tableName.' WHERE deleted=0 "';
        $params = array();
 
        $result = $db->pquery($query, $params);
        $num_rows = $db->num_rows($result);
        $instanceList = array();
        
        for($i=0; $i<$num_rows; $i++) {
            $row = $db->query_result_rowdata($result,$i);
            $instanceList[$row['checklistid']] = new Settings_OS2CheckList_Record_Model($row); 
        }
        return $instanceList;
    }
	
	public function getDisplayValue($fieldName, $recordId = false) {
		if($fieldName == 'createdtime'){
			if($this->get($fieldName) != '0000-00-00 00:00:00'){
				return Vtiger_Datetime_UIType::getDateTimeValue($this->get($fieldName));
			}else{
				return '---';
			}
		} else {
			return $this->get($fieldName);
		}
		
	}
   
    
}