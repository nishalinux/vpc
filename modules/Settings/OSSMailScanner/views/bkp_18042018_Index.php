<?php

/**
 * @package YetiForce.Views
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 */
class Settings_OSSMailScanner_Index_View extends Settings_Vtiger_Index_View
{

	private $prefixesForModules = ['Project', 'HelpDesk', 'SSalesProcesses', 'Campaigns'];

	public function process(Vtiger_Request $request)
	{
		$mailModuleActive = Vtiger_Functions::getModuleId('OSSMail');

		$mailScannerRecordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');

		$identityList = [];
		if ($mailModuleActive) {
			$accountsList = OSSMail_Record_Model::getAccountsList();
			foreach ($accountsList as $key => $account) {
				$identityList[$account['user_id']] = $mailScannerRecordModel->getIdentities($account['user_id']);
			}
		}

		$actionsList = $mailScannerRecordModel->getActionsList();

		$ConfigFolderList = $mailScannerRecordModel->getConfigFolderList();
		$emailSearch = $mailScannerRecordModel->getEmailSearch();
		$emailSearchList = $mailScannerRecordModel->getEmailSearchList();
		$widgetCfg = $mailScannerRecordModel->getConfig(false);
		$supportedModules = Settings_Vtiger_CustomRecordNumberingModule_Model::getSupportedModules();
	//	foreach ($supportedModules as $supportedModule) {
	//		if (in_array($supportedModule->name, $this->prefixesForModules)) {
	//			$numbering[$supportedModule->name] = $this->getNumber($supportedModule->name);
	//		}
	//	}
		$checkCron = $mailScannerRecordModel->get_cron();
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD_MODEL', $mailScannerRecordModel);
		$viewer->assign('ACCOUNTS_LIST', $accountsList);
		$viewer->assign('ACTIONS_LIST', $actionsList);
		$viewer->assign('CONFIGFOLDERLIST', $ConfigFolderList);
		$viewer->assign('WIDGET_CFG', $widgetCfg);
		$viewer->assign('EMAILSEARCH', $emailSearch);
		$viewer->assign('EMAILSEARCHLIST', $emailSearchList);
		$viewer->assign('RECORDNUMBERING', $numbering);
		$viewer->assign('ERRORNOMODULE', !$mailModuleActive);
		$viewer->assign('MODULENAME', $moduleName);
		$viewer->assign('IDENTITYLIST', $identityList);
		$viewer->assign('CHECKCRON', $checkCron);
		$viewer->assign('RRUSERS_ENTITY_INFO', vtws_getEntityNameFields('Users'));
		echo $viewer->view('Index.tpl', $request->getModule(false), true);
	}
	public static function getNumber($tabId)
	{
		if (is_string($tabId)) {
			$tabId = Vtiger_Functions::getModuleId($tabId);
		}
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery('SELECT cur_id, prefix, postfix FROM vtiger_modentity_num WHERE tabid = ? ', [$tabId]);
		$row = $adb->fetch_array($result);
		$rowCount = $adb->num_rows($result);
		if($rowCount > 0){

		return [
			'prefix' => $row['prefix'],
			'sequenceNumber' => $row['cur_id'],
			'postfix' => $row['postfix'],
			'number' => self::parse($row['prefix'] . $row['cur_id'] . $row['postfix'])
		];
		}
		
	}
	
	
}
