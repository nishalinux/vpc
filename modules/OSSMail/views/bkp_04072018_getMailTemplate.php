<?php
/* +***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 * *********************************************************************************************************************************** */
//ini_set('error_reporting', E_ERROR);
class OSSMail_getMailTemplate_View extends Vtiger_Index_View
{


	
	public function process(Vtiger_Request $request)
	{
		global $current_user,$log;
		
        $useremail = $request->get('useremail');
        $mailtempid = $request->get('mailtempid');
        $selectedcontact = $request->get('selectedcontact');
        $tomail = $request->get('tomail');
        $log->debug("useremail=".$useremail.", mailtempid=".$mailtempid.", selectedcontact=".$selectedcontact);
     //  $recordid = $selectedcontact;
        $recordid_arr = explode(",",$selectedcontact);	
        $mat_ch = 0;
        $adb = PearDatabase::getInstance();
        
            
        $result = $adb->pquery("SELECT signature FROM roundcube_identities INNER JOIN roundcube_users on roundcube_users.user_id = roundcube_identities.user_id WHERE roundcube_users.username = ?", array($useremail));
            
        $numbrNewModule = $adb->num_rows($result);
        if($numbrNewModule >0){								
            $signature = $adb->query_result($result, 0, "signature");
        }
        $result_template = $adb->pquery("SELECT body FROM vtiger_emailtemplates WHERE templateid = ?", array($mailtempid));
        $numbrtemplate = $adb->num_rows($result_template);
       // $log->debug("numbrtemplate=".$numbrtemplate);
        if($numbrtemplate >0){								
            $description = $adb->query_result($result_template, 0, "body");
        }
        $logo_qry = $adb->pquery("SELECT logoname FROM vtiger_organizationdetails LIMIT 1");
        $logo = $adb->query_result($logo_qry, 0, "logoname");
        $numbrtemplate = $adb->num_rows($result_template);
        $description = preg_replace("/\\$\\$/","$ $",$description);
		$this->rawDescription = $description;
		$this->processedDescription = $description;
        $result = preg_match_all("/\\$(?:[a-zA-Z0-9]+)-(?:[a-zA-Z0-9]+)(?:_[a-zA-Z0-9]+)?(?::[a-zA-Z0-9]+)?(?:_[a-zA-Z0-9]+)?\\$/", $this->rawDescription, $matches);
        if($result != 0){
            $templateVariablePair = $matches[0];
            $tempfields = Array();
            for ($i = 0; $i < count($templateVariablePair); $i++) {
                $templateVariablePair[$i] = str_replace('$', '', $templateVariablePair[$i]);
                list($module, $columnName) = explode('-', $templateVariablePair[$i]);
                list($parentColumn, $childColumn) = explode(':', $columnName);
                $tempfields[$module][] = $parentColumn;
                $parentcolumns[$parentColumn][] = $childColumn;
                $actualmodule[$module] = false;
            }
            foreach ($recordid_arr as $value) {
               $recordid = $value;
            if($mat_ch == 0){
                for($i=0;$i<count($tempfields['contacts']);$i++){
                    $moduleModel = Vtiger_Module_Model::getInstance("Contacts");
                    $fieldname = $tempfields['contacts'][$i];
                    $fieldModel = Vtiger_Field_Model::getInstance($fieldname , $moduleModel);
                    $actualfieldvalmod = Vtiger_Record_Model::getInstanceById($recordid, $moduleModel);
                    $actualfieldval  = $actualfieldvalmod->get($fieldname);
                    $condition1 = $actualfieldvalmod->get("email");
                    $condition2 = $actualfieldvalmod->get("secondaryemail");
                    //$log->debug("actualfieldval=".$actualfieldval);
                    if($actualfieldval != ''){
                        if($condition1 == $tomail || $condition2 == $tomail){
                            $description = str_replace('$contacts-'.$fieldname.'$',$actualfieldval,$description);
                            $mat_ch = 1;
                        }
                    }
                }
            }
            
            if($mat_ch == 0){
                for($i=0;$i<count($tempfields['leads']);$i++){
                    $moduleModel = Vtiger_Module_Model::getInstance("Leads");
                    $fieldname = $tempfields['leads'][$i];
                    $fieldModel = Vtiger_Field_Model::getInstance($fieldname , $moduleModel);
                    $actualfieldvalmod = Vtiger_Record_Model::getInstanceById($recordid, $moduleModel);
                    $actualfieldval  = $actualfieldvalmod->get($fieldname);
                    $condition1 = $actualfieldvalmod->get("email");
                    $condition2 = $actualfieldvalmod->get("secondaryemail");
                    //$log->debug("actualfieldval=".$actualfieldval);
                    if($actualfieldval != ''){
                        if($condition1 == $tomail || $condition2 == $tomail){
                            $description = str_replace('$leads-'.$fieldname.'$',$actualfieldval,$description);
                            $mat_ch = 2;
                        }
                    }
                }
            }
            
            if($mat_ch == 0){
                for($i=0;$i<count($tempfields['accounts']);$i++){
                    $moduleModel = Vtiger_Module_Model::getInstance("Accounts");
                    $fieldname = $tempfields['accounts'][$i];
                    $fieldModel = Vtiger_Field_Model::getInstance($fieldname , $moduleModel);
                    $actualfieldvalmod = Vtiger_Record_Model::getInstanceById($recordid, $moduleModel);
                    $actualfieldval  = $actualfieldvalmod->get($fieldname);
                    $condition1 = $actualfieldvalmod->get("cf_1669");
                    //$log->debug("actualfieldval=".$actualfieldval);
                    if($actualfieldval != ''){
                        if($condition1 == $tomail){
                            $description = str_replace('$accounts-'.$fieldname.'$',$actualfieldval,$description);
                            $mat_ch = 3;
                        }
                    }
                }
            }
            if($mat_ch != 0){
                echo $description.'<div id="_rc_sig">--<br>'.$signature.'</div>';
                break;
            }
        }
        if($mat_ch == 0){
            echo $description.'<div id="_rc_sig">--<br>'.$signature.'</div>';
            break;
        }
    }
    }
}
 