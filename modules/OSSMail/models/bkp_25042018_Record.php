<?php

/**
 *
 * @package YetiForce.models
 * @license licenses/License.html
 * @author Radosław Skrzypczak <r.skrzypczak@yetiforce.com>
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class OSSMail_Record_Model extends Vtiger_Record_Model
{

	static function getAccountsList($user = false, $onlyMy = false, $password = false)
	{
		global $log;
		//$log->debug('getAccountsListsssssssssss');
		$db = PearDatabase::getInstance();
		$currentUserModel = Users_Record_Model::getCurrentUserModel();
		$param = $users = [];
		$sql = 'SELECT * FROM roundcube_users';
		$where = false;
		if ($password) {
			$where .= " AND password <> ''";
		}
		if ($user) {
			$where .= ' AND user_id = ?';
			$param[] = $user;
		}
		if ($onlyMy) {
			$where .= ' AND crm_user_id = ?';
			$param[] = $currentUserModel->getId();
		}
		if ($where) {
			$sql .= sprintf(' WHERE %s ', substr($where, 4));
		}
		$result = $db->pquery($sql, $param);
		if ($db->getRowCount($result) == 0) {
			return [];
		} else {
			while ($row = $db->fetch_array($result)) {
				$row['actions'] = explode(',', $row['actions']);
				$users[] = $row;
			}
			//$log->debug('getAccountsListresult='.print_r($users,true));
			return $users;
		}
	}

	function ComposeEmail($params, $ModuleName)
	{
		header('Location: ' . self::GetSite_URL() . 'index.php?module=OSSMail&view=compose');
	}

	public static function load_roundcube_config()
	{
		global $no_include_config;
		$no_include_config = true;
		include 'modules/OSSMail/roundcube/config/defaults.inc.php';
		include 'modules/OSSMail/roundcube/config/config.inc.php';
		return $config;
	}

	public static function imapConnect($user, $password, $host = false, $folder = 'INBOX', $dieOnError = true)
	{
		$log = vglobal('log');
		//$log->debug("Entering OSSMail_Record_Model::imapConnect($user , $password , $folder) method ...");
		$rcConfig = self::load_roundcube_config();
		if (!$host) {
			$host = key($rcConfig['default_host']);
		}
		$parseHost = parse_url($host);
		$validatecert = '';
		if ($parseHost['host']) {
			$host = $parseHost['host'];
			$sslMode = (isset($a_host['scheme']) && in_array($parseHost['scheme'], ['ssl', 'imaps', 'tls'])) ? $parseHost['scheme'] : null;
			if (!empty($parseHost['port'])) {
				$port = $parseHost['port'];
			} else if ($sslMode && $sslMode != 'tls' && (!$rcConfig['default_port'] || $rcConfig['default_port'] == 143)) {
				$port = 993;
			}
		} else {
			if ($rcConfig['default_port'] == 993) {
				$sslMode = 'ssl';
			} else {
				$sslMode = 'tls';
			}
		}
		if (empty($port)) {
			$port = $rcConfig['default_port'];
		}
		if (!$rcConfig['validate_cert']) {
			$validatecert = '/novalidate-cert';
		}
		if ($rcConfig['imap_open_add_connection_type']) {
			$sslMode = '/' . $sslMode;
		} else {
			$sslMode = '';
		}

		imap_timeout(IMAP_OPENTIMEOUT, 5);
		//$log->debug("imap_open({" . $host . ":" . $port . "/imap" . $sslMode . $validatecert . "}$folder, $user , $password) method ...");
		if ($dieOnError) {
			$mbox = @imap_open("{" . $host . ":" . $port . "/imap" . $sslMode . $validatecert . "}$folder", $user, $password) OR
				die(self::imapThrowError(imap_last_error()));
		} else {
			$mbox = @imap_open("{" . $host . ":" . $port . "/imap" . $sslMode . $validatecert . "}$folder", $user, $password);
		}
		//$log->debug("Exit OSSMail_Record_Model::imapConnect() method ...");
		return $mbox;
	}

	public static function imapThrowError($error)
	{
		$log = vglobal('log');
		//$log->error("Error OSSMail_Record_Model::imapConnect(): " . $error);
		Vtiger_Functions::throwNewException(vtranslate('IMAP_ERROR', 'OSSMailScanner') . ': ' . $error);
	}

	public static function updateMailBoxmsgInfo($users)
	{
		$log = vglobal('log');
		//$log->debug(__CLASS__ . ':' . __FUNCTION__ . ' - Start');
		$adb = PearDatabase::getInstance();
		if (count($users) == 0) {
			return FALSE;
		}
		$sUsers = implode(',', $users);
		$result = $adb->pquery("SELECT count(*) AS num FROM yetiforce_mail_quantities WHERE userid IN (?) AND status = 1;", [$sUsers]);
		if ($adb->query_result_raw($result, 0, 'num') > 0) {
			return FALSE;
		}
		$adb->update('yetiforce_mail_quantities', ['status' => 1], 'userid IN (?)', [$sUsers]);
		foreach ($users as $user) {
			$account = self::get_account_detail($user);
			if ($account !== FALSE) {
				$result = $adb->pquery("SELECT count(*) AS num FROM yetiforce_mail_quantities WHERE userid = ?;", [$user]);
				$mbox = self::imapConnect($account['username'], $account['password'], $account['mail_host'], 'INBOX', FALSE);
				if ($mbox) {
					$info = imap_mailboxmsginfo($mbox);
					if ($adb->query_result_raw($result, 0, 'num') > 0) {
						$adb->pquery('UPDATE yetiforce_mail_quantities SET `num` = ?,`status` = ? WHERE `userid` = ?;', [$info->Unread, 0, $user]);
					} else {
						$adb->pquery('INSERT INTO yetiforce_mail_quantities (`num`,`userid`) VALUES (?,?);', [$info->Unread, $user]);
					}
				}
			}
		}
		//$log->debug(__CLASS__ . ':' . __FUNCTION__ . ' - End');
		return TRUE;
	}

	public static function getMailBoxmsgInfo($users)
	{
		$log = vglobal('log');
		//$log->debug(__CLASS__ . ':' . __FUNCTION__ . ' - Start');
		$adb = PearDatabase::getInstance();
		$query = sprintf('SELECT * FROM yetiforce_mail_quantities WHERE userid IN (%s);', implode(',', $users));
		$result = $adb->query($query);
		$account = [];
		for ($i = 0; $i < $adb->num_rows($result); $i++) {
			$account[$adb->query_result_raw($result, $i, 'userid')] = $adb->query_result_raw($result, $i, 'num');
		}
		//$log->debug(__CLASS__ . ':' . __FUNCTION__ . ' - End');
		return $account;
	}

	public static function getMail($mbox, $id, $msgno = false)
	{
		$return = [];
		if (!$msgno) {
			$msgno = imap_msgno($mbox, $id);
		}
		if (!$id) {
			$id = imap_uid($mbox, $msgno);
		}
		if (!$msgno) {
			return false;
		}
		$header = imap_header($mbox, $msgno);
		$structure = self::_get_body_attach($mbox, $id, $msgno);

		$mail = new OSSMail_Mail_Model();
		$mail->set('header', $header);
		$mail->set('id', $id);
		$mail->set('Msgno', $header->Msgno);
		$mail->set('message_id', $header->message_id);
		$mail->set('toaddress', $mail->getEmail('to'));
		$mail->set('fromaddress', $mail->getEmail('from'));
		$mail->set('reply_toaddress', $mail->getEmail('reply_to'));
		$mail->set('ccaddress', $mail->getEmail('cc'));
		$mail->set('bccaddress', $mail->getEmail('bcc'));
		$mail->set('senderaddress', $mail->getEmail('sender'));
		$mail->set('subject', self::_decode_text($header->subject));
		$mail->set('MailDate', $header->MailDate);
		$mail->set('date', $header->date);
		$mail->set('udate', $header->udate);
		$mail->set('udate_formated', date("Y-m-d H:i:s", $header->udate));
		$mail->set('Recent', $header->Recent);
		$mail->set('Unseen', $header->Unseen);
		$mail->set('Flagged', $header->Flagged);
		$mail->set('Answered', $header->Answered);
		$mail->set('Deleted', $header->Deleted);
		$mail->set('Draft', $header->Draft);
		$mail->set('Size', $header->Size);
		$mail->set('body', $structure['body']);
		$mail->set('attachments', $structure['attachment']);

		$clean = '';
		$msgs = imap_fetch_overview($mbox, $msgno);
		foreach ($msgs as $msg) {
			$clean .= imap_fetchheader($mbox, $msg->msgno);
		}
		$mail->set('clean', $cleans);
		return $mail;
	}

	public static function get_account_detail($userid)
	{
		$adb = PearDatabase::getInstance();
		$result = $adb->pquery("SELECT * FROM roundcube_users where user_id = ?", array($userid));
		$Num = $adb->num_rows($result);
		if ($Num > 0) {
			return $adb->raw_query_result_rowdata($result, 0);
		} else {
			return false;
		}
	}

	public static function _decode_text($text)
	{
		$data = imap_mime_header_decode($text);
		$charset = ($data[0]->charset == 'default') ? 'ASCII' : $data[0]->charset;
		return iconv($charset, 'UTF-8', $data[0]->text);
	}

	public static function get_full_name($text)
	{
		$return = '';
		foreach ($text as $row) {
			if ($return != '') {
				$return.= ',';
			}
			if ($row->personal == '') {
				$return.= $row->mailbox . '@' . $row->host;
			} else {
				$return.= self::_decode_text($row->personal) . ' - ' . $row->mailbox . '@' . $row->host;
			}
		}
		return $return;
	}

	public static function _get_body_attach($mbox, $id, $msgno)
	{
		$struct = imap_fetchstructure($mbox, $id, FT_UID);
		$parts = $struct->parts;
		$i = 0;
		$mail = array('id' => $id);
		if (empty($struct->parts)) {
			$mail = self::initMailPart($mbox, $mail, $struct, 0);
		} else {
			foreach ($struct->parts as $partNum => $partStructure) {
				$mail = self::initMailPart($mbox, $mail, $partStructure, $partNum + 1);
			}
		}
		$ret = array();
		$ret['body'] = $mail['textHtml'] ? $mail['textHtml'] : $mail['textPlain'];
		$ret['attachment'] = $mail["attachments"];
		return $ret;
	}

	protected static function initMailPart($mbox, $mail, $partStructure, $partNum)
	{
		$data = $partNum ? imap_fetchbody($mbox, $mail['id'], $partNum, FT_UID | FT_PEEK) : imap_body($mbox, $mail['id'], FT_UID | FT_PEEK);
		if ($partStructure->encoding == 1) {
			$data = imap_utf8($data);
		} elseif ($partStructure->encoding == 2) {
			$data = imap_binary($data);
		} elseif ($partStructure->encoding == 3) {
			$data = imap_base64($data);
		} elseif ($partStructure->encoding == 4) {
			$data = imap_qprint($data);
		}
		$params = array();
		if (!empty($partStructure->parameters)) {
			foreach ($partStructure->parameters as $param) {
				$params[strtolower($param->attribute)] = $param->value;
			}
		}
		if (!empty($partStructure->dparameters)) {
			foreach ($partStructure->dparameters as $param) {
				$paramName = strtolower(preg_match('~^(.*?)\*~', $param->attribute, $matches) ? $matches[1] : $param->attribute);
				if (isset($params[$paramName])) {
					$params[$paramName] .= $param->value;
				} else {
					$params[$paramName] = $param->value;
				}
			}
		}
		if (!empty($params['charset'])) {
			$data = iconv(strtoupper($params['charset']), 'utf-8', $data);
		}
		$attachmentId = $partStructure->ifid ? trim($partStructure->id, " <>") : (isset($params['filename']) || isset($params['name']) ? mt_rand() . mt_rand() : null);
		if ($attachmentId) {
			if (empty($params['filename']) && empty($params['name'])) {
				$fileName = $attachmentId . '.' . strtolower($partStructure->subtype);
			} else {
				$fileName = !empty($params['filename']) ? $params['filename'] : $params['name'];
				$fileName = self::decodeMimeStr($fileName);
				$fileName = self::decodeRFC2231($fileName);
			}
			$mail['attachments'][$attachmentId]['filename'] = $fileName;
			$mail['attachments'][$attachmentId]['attachment'] = $data;
		} elseif ($partStructure->type == 0 && $data) {
			if (base64_decode($data, true)) {
				$data = base64_decode($data);
			}
			if (strtolower($partStructure->subtype) == 'plain') {
				$mail['textPlain'] .= $data;
			} else {
				$mail['textHtml'] .= $data;
			}
		} elseif ($partStructure->type == 2 && $data) {
			$mail['textPlain'] .= trim($data);
		}
		if (!empty($partStructure->parts)) {
			foreach ($partStructure->parts as $subPartNum => $subPartStructure) {
				if ($partStructure->type == 2 && $partStructure->subtype == 'RFC822') {
					$mail = self::initMailPart($mbox, $mail, $subPartStructure, $partNum);
				} else {
					$mail = self::initMailPart($mbox, $mail, $subPartStructure, $partNum . '.' . ($subPartNum + 1));
				}
			}
		}
		return $mail;
	}

	function decodeMimeStr($string, $charset = 'utf-8')
	{
		$newString = '';
		$elements = imap_mime_header_decode($string);
		for ($i = 0; $i < count($elements); $i++) {
			if ($elements[$i]->charset == 'default') {
				$elements[$i]->charset = 'iso-8859-1';
			}
			$newString .= iconv(strtoupper($elements[$i]->charset), $charset, $elements[$i]->text);
		}
		return $newString;
	}

	function isUrlEncoded($string)
	{
		$string = str_replace('%20', '+', $string);
		$decoded = urldecode($string);
		return $decoded != $string && urlencode($decoded) == $string;
	}

	protected function decodeRFC2231($string, $charset = 'utf-8')
	{
		if (preg_match("/^(.*?)'.*?'(.*?)$/", $string, $matches)) {
			$encoding = $matches[1];
			$data = $matches[2];
			if (self::isUrlEncoded($data)) {
				$string = iconv(strtoupper($encoding), $charset, urldecode($data));
			}
		}
		return $string;
	}

	function _SaveAttachements($relID, $mail)
	{
		global $log;
		$log->debug('Save ataachemntssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssssss');
		$log->debug(print_r($mail,true));
		$adb = PearDatabase::getInstance();
		$attachments = $mail->get('attachments');
		$userid = $mail->getAccountOwner();
		$usetime = $mail->get('udate_formated');
		$setype = 'OSSMailView Attachment';

		$IDs = [];
		if ($attachments) {
			foreach ($attachments as $attachment) {
				$filename = $attachment['filename'];
				$filecontent = $attachment['attachment'];
				$attachid = $adb->getUniqueId('vtiger_crmentity');
				$description = $filename;
				$params = array(
					'crmid' => $attachid,
					'smcreatorid' => $userid,
					'smownerid' => $userid,
					'modifiedby' => $userid,
					'setype' => $setype,
					'description' => $description,
					
					'createdtime' => $usetime,
					'modifiedtime' => $usetime,
					'presence'=>1,
						'deleted'=>0,
						'label'=>$filename

				);
				$sql12 ="INSERT INTO vtiger_crmentity( crmid,smcreatorid, smownerid, modifiedby, setype, description, createdtime, modifiedtime,   presence, deleted, label) VALUES (?,?,?,?,?,?,?,?,?,?,?)";
 			//$log->debug(print_R($params12,true));
			$adb->pquery($sql12, $params);
		$log->debug('inside documents create');
				//$adb->insert('vtiger_crmentity', $params);
				$issaved = self::_SaveAttachmentFile($attachid, $filename, $filecontent);
						$log->debug('inside documents create aftet attach');

				if ($issaved) {
											$log->debug('inside documents create aftet attach inside 4111');

							require_once 'data/CRMEntity.php';
							$document = CRMEntity::getInstance('Documents');

					$document = new Documents();
			$document->column_fields['notes_title']      = $filename;
			$document->column_fields['filename']         = $filename;
			$document->column_fields['filestatus']       = 1;
			$document->column_fields['filelocationtype'] = 'I';
			$document->column_fields['folderid']         = 1;
			$document->column_fields['assigned_user_id'] = $userid;
			$document->save('Documents');
											$log->debug('inside documents create aftet attach inside 423'.$document->id);


					$seqsql="insert into vtiger_seattachmentsrel(crmid,attachmentsid) values (?,?)";
					$sqprm = array($document->id,$attachid);
								$adb->pquery($seqsql, $sqprm);

					$upprms = array($usetime,$userid,$userid,$document->id);
					
					$updateqry="update vtiger_crmentity set createdtime=?,smcreatorid=?,modifiedby=? where crmid = ?";
													$adb->pquery($updateqry, $upprms);

					if ($relID && $relID != 0 && $relID != '') {
						$dirname = Vtiger_Functions::initStorageFileDirectory('OSSMailView');
						$url_to_image = $dirname . $attachid . '_' . $filename;
						$ossfiles="insert into vtiger_ossmailview_files(ossmailviewid,documentsid,attachmentsid) values (?,?,?)";
					$ossfilesprms = array($relID,$document->id,$attachid);
								$adb->pquery($ossfiles, $ossfilesprms);

						$result = $adb->pquery('SELECT content FROM vtiger_ossmailview where ossmailviewid = ?', array($relID));
					//	$content = $adb->getSingleValue($result);
						$content = $adb->query_result($result, 0, "content");
						preg_match_all('/src="cid:(.*)"/Uims', $content, $matches);
						if (count($matches)) {
							$search = array();
							$replace = array();
							foreach ($matches[1] as $match) {
								if (strpos($filename, $match) !== false || strpos($match, $filename) !== false) {
									$search[] = "src=\"cid:$match\"";
									$replace[] = "src=\"$url_to_image\"";
								}
							}
							$content = str_replace($search, $replace, $content);
						}
						
						$viewprms = array($content,$relID);
					
					$viewupdateqry="update vtiger_ossmailview set content=? where ossmailviewid = ?";
													$adb->pquery($viewupdateqry, $viewprms);

					}
				}
			}
		}
		return $IDs;
	}

	function _SaveAttachmentFile($attachid, $filename, $filecontent)
	{
		require_once 'modules/OSSMail/MailAttachmentMIME.php';
		global $log;
		$log->debug('_saveAttachmentFileeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee');
		$adb = PearDatabase::getInstance();
		$dirname = Vtiger_Functions::initStorageFileDirectory('OSSMailView');
		if (!is_dir($dirname))
			mkdir($dirname);
		$filename = str_replace(' ', '-', $filename);
		$filename = str_replace(':', '-', $filename);
		$filename = str_replace('/', '-', $filename);
		$saveasfile = "$dirname$attachid" . "_$filename";
				$log->debug('_saveAttachmentFileeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'.$saveasfile);

		if (!file_exists($saveasfile)) {
			$fh = fopen($saveasfile, 'wb');
			fwrite($fh, $filecontent);
			fclose($fh);
		}
		$mimetype = MailAttachmentMIME::detect($saveasfile);
		$params =array( $attachid,$filename,$description,$mimetype,$dirname);
						$log->debug('_saveAttachmentFileeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeeee'.$saveasfile);

		//$adb->insert('vtiger_attachments', $params);
		$sql2 = "insert into vtiger_attachments(attachmentsid, name, description, type, path) values(?, ?, ?, ?, ?)";
			$result = $adb->pquery($sql2, $params);

		return true;
	}

	public static function getFolders($user)
	{
		global $log;
		//$log->debug('get foldersssssssssssssssssssssssssssssssss');
		$account = self::getAccountsList($user);
		//$log->debug('getfolders483='.print_r($account,true));
		$account = reset($account);
		$folders = false;
		$mbox = self::imapConnect($account['username'], $account['password'], $account['mail_host'], 'INBOX', false);
		if ($mbox) {
			$folders = [];
			$ref = '{' . $account['mail_host'] . '}';
			$list = imap_list($mbox, $ref, '*');
			foreach ($list as $mailboxname) {
				$name = str_replace($ref, '', $mailboxname);
				$folders[$name] = self::convertCharacterEncoding($name, 'UTF-8', 'UTF7-IMAP');
			}
		}
		//$log->debug('getfolders496='.print_r($folders,true));
		return $folders;
	}




	function convertCharacterEncoding($value, $toCharset, $fromCharset)
	{
		if (function_exists('mb_convert_encoding')) {
			$value = mb_convert_encoding($value, $toCharset, $fromCharset);
		} else {
			$value = iconv($toCharset, $fromCharset, $value);
		}
		return $value;
	}

	public static function getViewableData()
	{
		global $no_include_config;
		$no_include_config = true;
		$return = array();
		include 'modules/OSSMail/roundcube/config/config.inc.php';
		foreach ($config as $key => $value) {
			if ($key == 'skin_logo') {
				$return[$key] = $value['*'];
			} else {
				$return[$key] = $value;
			}
		}
		return $return;
	}

	public static function setConfigData($param, $dbupdate = true)
	{
		$fileName = 'modules/OSSMail/roundcube/config/config.inc.php';
		$fileContent = file_get_contents($fileName);
		$Fields = self::getEditableFields();

		foreach ($param as $fieldName => $fieldValue) {
			$type = $Fields[$fieldName]['fieldType'];
			$pattern = '/(\$config\[\'' . $fieldName . '\'\])[\s]+=([^;]+);/';
			if ($type == 'checkbox' || $type == 'int') {
				$patternString = "\$config['%s'] = %s;";
			} elseif ($type == 'multipicklist') {
				if (!is_array($fieldValue)) {
					$fieldValue = [$fieldValue];
				}
				$saveValue = '[';
				foreach ($fieldValue as $value) {
					$saveValue .= "'$value' => '$value',";
				}
				$saveValue .= ']';
				$fieldValue = $saveValue;
				$patternString = "\$config['%s'] = %s;";
			} elseif ($fieldName == 'skin_logo') {
				$patternString = "\$config['%s'] = array(\"*\" => \"%s\");";
			} else {
				$patternString = "\$config['%s'] = '%s';";
			}
			$replacement = sprintf($patternString, $fieldName, $fieldValue);
			$fileContent = preg_replace($pattern, $replacement, $fileContent);
		}
		$filePointer = fopen($fileName, 'w');
		fwrite($filePointer, $fileContent);
		fclose($filePointer);
		if ($dbupdate) {
			$adb = PearDatabase::getInstance();
			$adb->pquery("update roundcube_users set language=?", array($param['language']));
		}
		return vtranslate('JS_save_config_info', 'OSSMailScanner');
	}

	function getEditableFields()
	{
		return array(
			'product_name' => array('label' => 'LBL_RC_product_name', 'fieldType' => 'text', 'required' => 1),
			'validate_cert' => array('label' => 'LBL_RC_validate_cert', 'fieldType' => 'checkbox', 'required' => 0),
			'imap_open_add_connection_type' => array('label' => 'LBL_RC_imap_open_add_connection_type', 'fieldType' => 'checkbox', 'required' => 0),
			'default_host' => array('label' => 'LBL_RC_default_host', 'fieldType' => 'multipicklist', 'required' => 1),
			'default_port' => array('label' => 'LBL_RC_default_port', 'fieldType' => 'int', 'required' => 1),
			'smtp_server' => array('label' => 'LBL_RC_smtp_server', 'fieldType' => 'text', 'required' => 1),
			'smtp_user' => array('label' => 'LBL_RC_smtp_user', 'fieldType' => 'text', 'required' => 1),
			'smtp_pass' => array('label' => 'LBL_RC_smtp_pass', 'fieldType' => 'text', 'required' => 1),
			'smtp_port' => array('label' => 'LBL_RC_smtp_port', 'fieldType' => 'int', 'required' => 1),
			'language' => array('label' => 'LBL_RC_language', 'fieldType' => 'picklist', 'required' => 1, 'value' => array('ar_SA', 'az_AZ', 'be_BE', 'bg_BG', 'bn_BD', 'bs_BA', 'ca_ES', 'cs_CZ', 'cy_GB', 'da_DK', 'de_CH', 'de_DE', 'el_GR', 'en_CA', 'en_GB', 'en_US', 'es_419', 'es_AR', 'es_ES', 'et_EE', 'eu_ES', 'fa_AF', 'fa_IR', 'fi_FI', 'fr_FR', 'fy_NL', 'ga_IE', 'gl_ES', 'he_IL', 'hi_IN', 'hr_HR', 'hu_HU', 'hy_AM', 'id_ID', 'is_IS', 'it_IT', 'ja_JP', 'ka_GE', 'km_KH', 'ko_KR', 'lb_LU', 'lt_LT', 'lv_LV', 'mk_MK', 'ml_IN', 'mr_IN', 'ms_MY', 'nb_NO', 'ne_NP', 'nl_BE', 'nl_NL', 'nn_NO', 'pl_PL', 'pt_BR', 'pt_PT', 'ro_RO', 'ru_RU', 'si_LK', 'sk_SK', 'sl_SI', 'sq_AL', 'sr_CS', 'sv_SE', 'ta_IN', 'th_TH', 'tr_TR', 'uk_UA', 'ur_PK', 'vi_VN', 'zh_CN', 'zh_TW')),
			'username_domain' => array('label' => 'LBL_RC_username_domain', 'fieldType' => 'text', 'required' => 0),
			'skin_logo' => array('label' => 'LBL_RC_skin_logo', 'fieldType' => 'text', 'required' => 1),
			'ip_check' => array('label' => 'LBL_RC_ip_check', 'fieldType' => 'checkbox', 'required' => 0),
			'enable_spellcheck' => array('label' => 'LBL_RC_enable_spellcheck', 'fieldType' => 'checkbox', 'required' => 0),
			'identities_level' => array('label' => 'LBL_RC_identities_level', 'fieldType' => 'picklist', 'required' => 1, 'value' => array(0, 1, 2, 3, 4)),
			'session_lifetime' => array('label' => 'LBL_RC_session_lifetime', 'fieldType' => 'int', 'required' => 1),
		);
	}

	function GetSite_URL()
	{
		global $site_URL;
		//$site_URL = AppConfig::main('site_URL');
		if (substr($site_URL, -1) != '/') {
			$site_URL = $site_URL . '/';
		}
		return $site_URL;
	}

	static function getMailsFromIMAP($user = false)
	{
		$account = self::getAccountsList($user, true);
		$mails = [];
		$mailLimit = 5;
		if ($account) {
			$imap = self::imapConnect($account[0]['username'], $account[0]['password'], $account[0]['mail_host']);
			$numMessages = imap_num_msg($imap);
			if ($numMessages < $mailLimit) {
				$mailLimit = $numMessages;
			}
			for ($i = $numMessages; $i > ($numMessages - $mailLimit); $i--) {
				$header = imap_headerinfo($imap, $i);
				$mail = self::getMail($imap, false, $i);
				$mails[] = $mail;
			}
			imap_close($imap);
		}
		return $mails;
	}

	public static function getAccountByHash($hash)
	{
		$db = PearDatabase::getInstance();
		echo $hash;
		$query = sprintf('SELECT * FROM roundcube_users WHERE preferences LIKE \'%s\' limit 1', "%:\"$hash\";%");
		$result = $db->query($query);
		if ($db->getRowCount($result) > 0) {
			return $db->fetchByAssoc($result);
		} else {
			return false;
		}
	}
}
