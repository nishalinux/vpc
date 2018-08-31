<?php

/**
 * Mail cction bar class
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_MailActionBar_View extends Vtiger_Index_View
{

	public function preProcess(Vtiger_Request $request, $display = true)
	{
		
	}

	public function postProcess(Vtiger_Request $request)
	{
		
	}

	public function process(Vtiger_Request $request)
	{
		global $site_URL,$log;
		$log->debug('MailActionBarssssssssssssssssssssssssssssssssssss');
		$moduleName = $request->getModule();
	echo '<br>'.	$uid = $request->get('uid');
		echo '<br>'.$folder = $request->get('folder');
		echo '<br>'.$rcId = $request->get('rcId');
		echo '<br>';

		$account = OSSMail_Record_Model::getAccountByHash($rcId);
		if (!$account) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
		$rcId = $account['user_id'];
		$mailViewModel = OSSMailView_Record_Model::getCleanInstance('OSSMailView');
		$record = $mailViewModel->checkMailExist($uid, $folder, $rcId);
		print_r($record);
		$log->debug('record='.print_r($record,true));
		echo "-----";
				print_r($account);
				$log->debug('account='.print_r($account,true));
		
		if (!$record && !empty($account['actions'])) {
			$account['actions'] = explode(',', $account['actions']);
			$mailModel = Vtiger_Record_Model::getCleanInstance('OSSMail');
			$mbox = $mailModel->imapConnect($account['username'], $account['password'], $account['mail_host'], $folder);
			$return = OSSMailScanner_Record_Model::executeActions($account, $mailModel->getMail($mbox, $uid), $folder, $params);
			if (isset($return['CreatedEmail'])) {
				$record = $return['CreatedEmail'];
				$log->debug('accountrecord='.$record);
			}
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD', $record);
		if ($record) {
			$reletedRecords = $mailViewModel->getReletedRecords($record);
			$viewer->assign('RELETED_RECORDS', $reletedRecords);
		}
		Vtiger_ModulesHierarchy_Model::getModulesByLevel();
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('URL', $site_URL);
		$viewer->view('MailActionBar.tpl', $moduleName);
	}
}
