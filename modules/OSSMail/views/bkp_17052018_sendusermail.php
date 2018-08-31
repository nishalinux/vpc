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
class OSSMail_sendusermail_View extends Vtiger_Index_View
{


	
	public function process(Vtiger_Request $request)
	{
		global $current_user,$log;
		
        $uid = $request->get('id');
        //echo $uid;
        //exit;
        $NewModule = $request->get('source');
        if($NewModule == "Contacts"){
            $table = "vtiger_contactdetails";
            $condition1 = "email";
            $condition2 = "secondaryemail";
            $field = 'contactid';
        }
        else if($NewModule == "Leads"){
            $table = "vtiger_leaddetails";
            $condition1 = "email";
            $condition2 = "secondaryemail";
            $field = 'leadid';
        }
        else if($NewModule == "Accounts"){
            $table = "vtiger_account";
            $condition1 = "email1";
            $condition2 = "email2";
            $field = 'accountid';
        }
        $adb = PearDatabase::getInstance();
       // $adb->setDebug(true);
		$result = $adb->pquery("SELECT $condition1,$condition2 FROM $table WHERE $field IN ($uid)");
        $numbrNewModule = $adb->num_rows($result);
        if($numbrNewModule >0){								
            while($row = $adb->fetch_array($result)){	
                if($row[$condition1] != '' && $row[$condition1] != NULL){
                    $attributeid[]=$row[$condition1];
                }	
                if($row[$condition2] != '' && $row[$condition2] != NULL){
                    $attributeid[]=$row[$condition2];
                }							
                   
            }
        }
        $emailids = implode(",",$attributeid);
       // echo $emailids.','. $numbrNewModule;
       echo $emailids;
       // return $emailids;
	}
}
