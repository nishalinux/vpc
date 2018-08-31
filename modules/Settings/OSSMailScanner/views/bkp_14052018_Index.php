<?php

/**
 * @package YetiForce.Views
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_OSSMailScanner_Index_View extends Settings_Vtiger_Index_View
{

	//private $prefixesForModules = ['Project', 'HelpDesk', 'SSalesProcesses', 'Campaigns'];

	public function process(Vtiger_Request $request)
	{
		global $log;
		$log->debug('processssss');
		$mailModuleActive = Vtiger_Functions::getModuleId('OSSMail');

		$mailScannerRecordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');

		$identityList = [];
		if ($mailModuleActive) {
			$accountsList = OSSMail_Record_Model::getAccountsList();
			foreach ($accountsList as $key => $account) {
				$log->debug('user_id='.$account['user_id']);
				$identityList[$account['user_id']] = $mailScannerRecordModel->getIdentities($account['user_id']);
				$folderslist[$account['crm_user_id']] = $mailScannerRecordModel->getAllFolders($account['crm_user_id']);
			}
		}

		$actionsList = $mailScannerRecordModel->getActionsList();
		$userslist = $mailScannerRecordModel->getAllUserList();
		
		$ConfigFolderList = $mailScannerRecordModel->getConfigFolderList();
		$emailSearch = $mailScannerRecordModel->getEmailSearch();
		$emailSearchList = $mailScannerRecordModel->getEmailSearchList();
		$widgetCfg = $mailScannerRecordModel->getConfig(false);
		$supportedModules = Settings_Vtiger_CustomRecordNumberingModule_Model::getSupportedModules();
		$log->debug('supportedModules='.print_r($supportedModules, true));
		foreach ($supportedModules as $supportedModule) {
			//if (in_array($supportedModule->name, $this->prefixesForModules)) {
				$numbering[$supportedModule->name] = $this->getNumber($supportedModule->name);
				$log->debug('processssssnumbering='.print_r($numbering[$supportedModule->name],true));
			//}
		}
		$checkCron = $mailScannerRecordModel->get_cron();
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD_MODEL', $mailScannerRecordModel);
		$viewer->assign('USERS_LIST', $userslist);
		$viewer->assign('FOLDERS', $folderslist);
		$log->debug('Folders52indx='.print_r($folderslist, true));
		$log->debug('userslist='.print_r($userslist, true));
		$log->debug('accountsList='.print_r($accountsList, true));
		$viewer->assign('ACCOUNTS_LIST', $accountsList);
		$viewer->assign('ACTIONS_LIST', $actionsList);
		$viewer->assign('CONFIGFOLDERLIST', $ConfigFolderList);
		$viewer->assign('WIDGET_CFG', $widgetCfg);
		$viewer->assign('EMAILSEARCH', $emailSearch);
		$viewer->assign('EMAILSEARCHLIST', $emailSearchList);
		$viewer->assign('RECORDNUMBERING', $numbering);
		$log->debug('numbering='.print_r($numbering, true));
		$log->debug('identityListidentityList='.print_r($identityList, true));
		$viewer->assign('ERRORNOMODULE', !$mailModuleActive);
		$viewer->assign('MODULENAME', 'OSSMailScanner');
		$log->debug('moduleeeeeeeeeeeeeeeeeeeee'.$moduleName);
		$viewer->assign('IDENTITYLIST', $identityList);
		$viewer->assign('CHECKCRON', $checkCron);
		$log->debug('userName_field='.print_r(vtws_getEntityNameFields('Users'), true));
		$viewer->assign('RRUSERS_ENTITY_INFO', vtws_getEntityNameFields('Users'));
		echo $viewer->view('Index.tpl', $request->getModule(false), true);
	}
	public static function getNumber($tabId)
	{
		global $log;
		$log->debug('getNumber');
		/*if (is_string($tabId)) {
			$tabId = Vtiger_Functions::getModuleId($tabId);
		}*/
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery('SELECT cur_id, prefix,semodule FROM vtiger_modentity_num WHERE semodule = ? ', [$tabId]);
		//$result = $adb->pquery('SELECT cur_id, prefix, postfix FROM vtiger_modentity_num WHERE tabid = ? ', [$tabId]);
		$row = $adb->fetch_array($result);
		$rowCount = $adb->num_rows($result);
		if($rowCount > 0){

		return [
			'prefix' => $row['prefix'],
			'sequenceNumber' => $row['cur_id'],
			'postfix' =>$row['semodule']
		];
		}/*
		else{
			return [
				'prefix' => '0',
				'sequenceNumber' => 0,
				'postfix' =>$tabId
			];
		}*/
		
	}
	
	
}
