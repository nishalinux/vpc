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
class OSSMail_GetSignature_View extends Vtiger_Index_View
{


	
	public function process(Vtiger_Request $request)
	{
		global $current_user,$log;
		
        $useremail = $request->get('useremail');
			
        $adb = PearDatabase::getInstance();
        $result = $adb->pquery("SELECT signature FROM roundcube_identities INNER JOIN roundcube_users on roundcube_users.user_id = roundcube_identities.user_id WHERE roundcube_users.username = ?", array($useremail));
            
        $numbrNewModule = $adb->num_rows($result);
        if($numbrNewModule >0){								
            $signature = $adb->query_result($result, 0, "signature");
        }
        
        echo $signature;
    }
}
