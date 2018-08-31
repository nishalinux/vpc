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

class OSSMail_index_View extends Vtiger_Index_View
{

	protected $mainUrl = 'modules/OSSMail/roundcube/';

	function __construct()
	{
		parent::__construct();
		$this->mainUrl = OSSMail_Record_Model::GetSite_URL() . $this->mainUrl;
	}

	function initAutologin()
	{
		$config = Settings_Mail_Config_Model::getConfig('autologin');
		if ($config['autologinActive'] == 'true') {
			$account = OSSMail_Autologin_Model::getAutologinUsers();
			if ($account) {
				$rcUser = (isset($_SESSION['AutoLoginUser']) && array_key_exists($_SESSION['AutoLoginUser'], $account)) ? $account[$_SESSION['AutoLoginUser']] : reset($account);

				$key = md5($rcUser['rcuser_id'] . microtime());
				if (strpos($this->mainUrl, '?') !== false) {
					$this->mainUrl .= '&';
				} else {
					$this->mainUrl .= '?';
				}
				$this->mainUrl .= '_autologin=1&_autologinKey=' . $key;
				$db = PearDatabase::getInstance();
				//$db->delete('u_yf_mail_autologin', '`userid` = ?;', [$rcUser['rcuser_id']]);
				$db->pquery('DELETE FROM u_yf_mail_autologin WHERE userid=?', [$rcUser['rcuser_id']]);
				$db->pquery('INSERT INTO u_yf_mail_autologin (`key`,`userid`) VALUES (?,?);', [$key, $rcUser['rcuser_id']]);
				/*$db->insert('u_yf_mail_autologin', [
					'key' => $key,
					'userid' => $rcUser['rcuser_id']
				]);*/
			}
		}
	}
	private function getusername($userid){
		$db = PearDatabase::getInstance();
		
		$result =$db->pquery("SELECT a.username,a.password FROM roundcube_users as a inner join roundcube_users_autologin as b on a.user_id=b.rcuser_id and b.crmuser_id= ? LIMIT 1",[$userid]);
		$username = $db->query_result($result, 0, 'username');
		$password = $db->query_result($result, 0, 'password');
		$cookie_name = "USERNAME";
		$cookie_value =$username;
		$cookie_password = "PASSWORD";
		$password_value =$password;
		if(!isset($_COOKIE['USERNAME']) && !isset($_COOKIE['PASSWORD']) ){
			setcookie($cookie_name, $cookie_value, time() + (60 * 1), "/");
			setcookie($cookie_password, $password_value, time() + (60 * 1), "/");
		}
		else if(isset($_COOKIE['USERNAME']) && !isset($_COOKIE['PASSWORD']) ){
			setcookie($cookie_name, $cookie_value, time() + (60 * 1), "/");
		}
		
	}
	

	public function preProcess(Vtiger_Request $request, $display = true)
	{
		$this->initAutologin();

		parent::preProcess($request, $display);
	}

	public function process(Vtiger_Request $request)
	{
		global $current_user;
		$userid = $current_user->id;
		$usern = $this->getusername($userid);
		
		$moduleName = $request->getModule();
		$viewer = $this->getViewer($request);
		$viewer->assign('URL', $this->mainUrl);
		$viewer->assign('USERNAME', $_COOKIE['USERNAME']);
		$viewer->assign('PASSWORD', $_COOKIE['PASSWORD']);
		$viewer->view('index.tpl', $moduleName);
	}
}
