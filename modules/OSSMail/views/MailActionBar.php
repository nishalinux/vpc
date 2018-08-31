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
		$moduleName = $request->getModule();
		$uid = $request->get('uid');
		$folder = $request->get('folder');
		$rcId = $request->get('rcId');
		
		$log->debug('MailActionBarssssssssssssssssssssssssssssssssssss'.$rcId);
		$log->debug('MailActionBarssssssssssssssssssssssssssssssssssss'.$folder);
		$log->debug('MailActionBarssssssssssssssssssssssssssssssssssss'.$uid);

		$account = OSSMail_Record_Model::getAccountByHash($rcId);
		if (!$account) {
			throw new \Exception\NoPermitted('LBL_PERMISSION_DENIED');
		}
		$rcId = $account['user_id'];
		$mailViewModel = OSSMailView_Record_Model::getCleanInstance('OSSMailView');
		$record = $mailViewModel->checkMailExist($uid, $folder, $rcId);
	$log->debug('rddssecord='.print_r($record,true));
			$log->debug('account='.print_r($account,true));
		
		if (!$record && !empty($account['actions'])) {
			$log->debug('inside iffffffffffffffffffffffffffff');
			$account['actions'] = explode(',', $account['actions']);
			$mailModel = Vtiger_Record_Model::getCleanInstance('OSSMail');
			$mbox = $mailModel->imapConnect($account['username'], $account['password'], $account['mail_host'], $folder,false);
			$log->debug(print_r($mbox,true));
			$return = OSSMailScanner_Record_Model::executeActions($account, $mailModel->getMail($mbox, $uid), $folder, $params);
						$log->debug(print_r($return,true));

			if (isset($return['CreatedEmail'])) {
				$record = $return['CreatedEmail'];
			$log->debug('accountrecord='.$record);
			}
		}
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD', $record);
		if ($record) {
			$log->debug('line number 54  ');
			$reletedRecords = $mailViewModel->getReletedRecords($record);
				$log->debug('record='.print_r($reletedRecords,true));

			$viewer->assign('RELETED_RECORDS', $reletedRecords);
		}
		Vtiger_ModulesHierarchy_Model::getModulesByLevel();
		$log->debug('mailactionbarrrrrrrrrrrrrrrrrr'.$moduleName);
		$log->debug('mailactionbarrrrrrrrrrrrrrrrrr'.$site_URL);
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('URL', $site_URL);
		$viewer->view('MailActionBar.tpl', $moduleName);
	}
}
