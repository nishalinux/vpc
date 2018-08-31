<?php

/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_EditAjax_View extends Settings_Vtiger_IndexAjax_View{
    
    public function process(Vtiger_Request $request) {
		$db = PearDatabase::getInstance();
        $record = $request->get('record');
        if(!empty($record)) {
            $recordModel = Settings_OS2CheckList_Record_Model::getInstance($record);
        }else {
		   $recordModel = new Settings_OS2CheckList_Record_Model(); 
        }
        // vtlib customization: Ignore disabled modules.
        $query = 'SELECT vtiger_tab.name,vtiger_tab.tablabel as tabname FROM vtiger_tab
                        WHERE isentitytype=1 AND tabid IN(2,6,7,8,4)';
        // END
        $result = $db->pquery($query, array());

        $picklist = array();
        while($row = $db->fetchByAssoc($result)){
            $moduleName  = $row['name'];
			$moduleLabel  = $row['tabname'];
            $picklist[] = [$moduleName,$moduleLabel];
        }
     
        $viewer = $this->getViewer($request);
		$modulename  =  $recordModel->get('modulename');
		
		if($record == ''){
			$category    =  unserialize(base64_decode($recordModel->get('category')));
			$title       =  unserialize(base64_decode($recordModel->get('title')));
			$upload      =  unserialize(base64_decode($recordModel->get('allow_upload')));
			$note        =  unserialize(base64_decode($recordModel->get('allow_note')));
			$description =  unserialize(base64_decode($recordModel->get('description')));
		}else{
			$query = $db->pquery("SELECT * FROM vtiger_checklist_related WHERE checklistid=?",array($record));
			$rows = $db->num_rows($query);
			for($i=0; $i<$rows; $i++){
				$category[$i] = $db->query_result($query, $i, 'category');
				$title[$i] = $db->query_result($query, $i, 'title');
				$description[$i] = $db->query_result($query, $i, 'description');
				$upload[$i] = $db->query_result($query, $i, 'notes');
				$note[$i] = $db->query_result($query, $i, 'comments');
				
			}
		}
		
		$array_cnt   =  count(unserialize(base64_decode($recordModel->get('category'))));
		
        $qualifiedName = $request->getModule(false);
		$viewer->assign('QUALIFIED_MODULE',$qualifiedName);
        $viewer->assign('CATEGORY',$category);
        $viewer->assign('TITLE',$title);
        $viewer->assign('UPLOAD',$upload);
        $viewer->assign('NOTE',$note);
        $viewer->assign('DESCRIPTION',$description);
        $viewer->assign('RECORD_MODEL',$recordModel);
        $viewer->assign('COUNT',$array_cnt);
		$viewer->assign('PICKLIST_MODULES',$picklist);
		$viewer->assign('modulename',$modulename);
        
        $viewer->view('EditAjax.tpl',$qualifiedName);
    }
	
	function getHeaderScripts(Vtiger_Request $request){
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();
		$jsFileNames = array(
			"modules.Settings.$moduleName.resources.OS2CheckList"
		);
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
}