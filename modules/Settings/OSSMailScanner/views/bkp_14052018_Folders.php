<?php

/**
 * Mail scanner action creating mail
 * @package YetiForce.View
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class Settings_OSSMailScanner_Folders_View extends Vtiger_BasicModal_View
{

	public function checkPermission(Vtiger_Request $request)
	{
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		if (!$currentUserModel->isAdminUser() || !$request->has('record')) {
			throw new \Exception\NoPermittedForAdmin('LBL_PERMISSION_DENIED');
		}
	}

	public function getSize(Vtiger_Request $request)
	{
		return 'modal-lg';
	}

	public function process(Vtiger_Request $request)
	{
		global $log;
		$log->debug('folders email lllllllllllll');
		/*$moduleName = $request->getModule();
		$qualifiedModuleName = $request->getModule(false);
		$record = $request->get('record');
		$mailModuleActive = Vtiger_Functions::getModuleId('OSSMail');
		$folders = [];
		if ($mailModuleActive) {
			$log->debug('mailModuleActive='.print_r($mailModuleActive,true));
			$mailRecordModel = Vtiger_Record_Model::getCleanInstance('OSSMail');
		$log->debug('mailRecordModelRec='.print_r($record,true));
			$folders = $mailRecordModel->getFolders($record);
			$log->debug('mailRecordModel='.print_r($folders,true));
			$mailScannerRecordModel = Vtiger_Record_Model::getCleanInstance('OSSMailScanner');
			$selectedFolders = [];
			foreach ($mailScannerRecordModel->getFolders($record) as &$folder) {
				$selectedFolders[$folder['type']][] = $folder['folder'];
			}
		}
				$log->debug('folders email='.print_r($folders,true));

echo "folders";
		$this->preProcess($request);
		$viewer = $this->getViewer($request);
		$log->debug('Folder49'.print_r($viewer,true));
		$viewer->assign('RECORD', $record);
		$log->debug('Folder51'.print_r($record,true));
		$viewer->assign('FOLDERS', $folders);
		$log->debug('Folder53'.print_r($folders,true));
		$viewer->assign('SELECTED', $selectedFolders);
		$log->debug('Folder55'.print_r($folders,true));
		$viewer->assign('MODULE_NAME', $moduleName);
		$log->debug('Folder57'.print_r($folders,true));
		$viewer->assign('QUALIFIED_MODULE', $qualifiedModuleName);
		$log->debug('Folder59'.print_r($folders,true));
		$viewer->view('Folders.tpl', $qualifiedModuleName);
		$log->debug('Folder61'.print_r($folders,true));
		$this->postProcess($request);*/
	}
}
