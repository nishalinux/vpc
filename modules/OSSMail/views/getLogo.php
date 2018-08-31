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
class OSSMail_getLogo_View extends Vtiger_Index_View
{


	
	public function process(Vtiger_Request $request)
	{
		global $current_user,$log;
        $adb = PearDatabase::getInstance();
        
        $logo_qry = $adb->pquery("SELECT logoname FROM vtiger_organizationdetails LIMIT 1");
        $logo = $adb->query_result($logo_qry, 0, "logoname");
        $actual_link = (isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]";
        echo $logo_src = "<img src='".$actual_link."/test/logo/".$logo."'>";
              
             
    }
}
 