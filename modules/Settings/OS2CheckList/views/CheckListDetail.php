<?php
/*+**********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.1
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ************************************************************************************/

class Settings_OS2CheckList_CheckListDetail_View extends Vtiger_IndexAjax_View {

	
	public function process(Vtiger_Request $request){
		global $adb,$current_user;
		$loggedinUser = $current_user->id;
		
		$adb = PearDatabase::getInstance();
		$viewer = $this->getViewer($request);
		$qualifiedName = $request->getModule(false);
		$checklistid = $request->get('checklistid');
		$recordId = $request->get('source_record'); //acountid
		
		$query = $adb->pquery("SELECT * FROM vtiger_checklistdetails WHERE checklistid=? ",array($checklistid));
		$checklistname = $adb->query_result($query,0,'checklistname');
		$category = unserialize(base64_decode($adb->query_result($query,0,'category')));
		$title = unserialize(base64_decode($adb->query_result($query,0,'title')));
		$description = unserialize(base64_decode($adb->query_result($query,0,'description')));
		$count = count($category);
		
		$Array = array();
		$q2 = $adb->pquery("SELECT category, title, description, notes, comments, sequence FROM vtiger_checklist_related WHERE checklistid=? ORDER BY sequence ASC",array($checklistid));
		$rows = $adb->num_rows($q2);
		for($k=0;$k<$rows;$k++){
			$cat = $adb->query_result($q2,$k,'category');
			$Array[$k]['cat'] =$cat;
			
			$imp_title =  $adb->query_result($q2,$k,'title');
			//$tit = explode("||",$imp_title);
			$Array[$k]['tit'] = $imp_title;
			
			$desc = html_entity_decode($adb->query_result($q2,$k,'description'));
			$Array[$k]['desc'] = $desc;//explode("||",$desc);
			
			$notes = $adb->query_result($q2,$k,'notes');
			$Array[$k]['notes'] = $notes;//explode("||",$notes);
			
			$comments = $adb->query_result($q2,$k,'comments');
			$Array[$k]['comments'] = $comments;//explode("||",$comments);
		}
			
		for($j=0;$j<$count;$j++){
		
			$query1 = $adb->pquery("SELECT * FROM vtiger_relmodule_checklist WHERE checklistid=? AND accountid=? and sequence= ?", array($checklistid,$recordId, $j));
			$rows = $adb->num_rows($query1);
			if($rows > 0){
				for($i=0;$i<$rows;$i++){
					$noteid = $adb->query_result($query1, $i, 'noteid');
					$query2 = $adb->pquery("SELECT notesid, title FROM vtiger_notes WHERE notesid=?",array($noteid));
					while($result = $adb->fetchByAssoc($query2)){
						$List[$j][]= $result;
					}	
				}
			}
			$query3 = $adb->pquery("SELECT * FROM vtiger_checklist_comment WHERE checklistid=? AND crmid=? and sequence= ?",array($checklistid,$recordId,$j));
				$rows3 = $adb->num_rows($query3);
				for($i=0;$i<$rows3;$i++){
					$Comment[$j][$i]['comment_content'] = $adb->query_result($query3, $i, 'comment_content');
					$Comment[$j][$i]['username'] = $adb->query_result($query3, $i, 'username');
					$datetime = $adb->query_result($query3, $i, 'time');
					$Comment[$j][$i]['time'] = Vtiger_Datetime_UIType::getDateTimeValue($datetime);
				}		
		}
		
		$viewer->assign('checklistname', $checklistname);
		$viewer->assign('checklistid', $checklistid);
		$viewer->assign('recordId', $recordId);
		$viewer->assign('LIST', $List);
		$viewer->assign('COMMENT', $Comment);
		$viewer->assign('Array', $Array);
		
		echo $viewer->view('CheckListDetail.tpl', $qualifiedName, true);
		 
	}

	
}