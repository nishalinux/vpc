<?php

/**
 *
 * @package YetiForce.views
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_compose_View extends OSSMail_index_View
{

	public function preProcess(Vtiger_Request $request, $display = true)
	{
		$this->initAutologin();
	}

	public function process(Vtiger_Request $request)
	{
		global $log;
		//$log->debug('composessssss');
		//$log->debug('composerequest='.print_r($request,true));
		$currentUser = Users_Record_Model::getCurrentUserModel();
		$this->mainUrl .= '&_task=mail&_action=compose&_extwin=1';
		$params = OSSMail_Module_Model::getComposeParam($request);
		$key = md5(count($params) . microtime());

		$db = PearDatabase::getInstance();
		/*$db->delete('u_yf_mail_compose_data', '`userid` = ?;', [$currentUser->getId()]); DELETE FROM*/
		$db->pquery('DELETE FROM u_yf_mail_compose_data WHERE userid=?', [$currentUser->getId()]);
		$db->pquery('INSERT INTO u_yf_mail_compose_data (`key`,`userid`,`data`) VALUES (?,?,?);', [$key, $currentUser->getId(),json_encode($params)]);
		/*$db->insert('u_yf_mail_compose_data', [
			'key' => $key,
			'userid' => $currentUser->getId(),
			'data' => json_encode($params),
		]);*/
		$this->mainUrl .= '&_composeKey=' . $key;
		header('Location: ' . $this->mainUrl);
	}

	public function postProcess(Vtiger_Request $request)
	{
		
	}
}
