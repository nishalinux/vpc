<?php

/**
 * Integration Plugin yetiforce and roundcube
 * @package YetiForce.rcubePlugin
 * @license licenses/License.html
 * @author Mariusz Krzaczkowski <m.krzaczkowski@yetiforce.com>
 */
class yetiforce extends rcube_plugin
{

	private $rc;

	public function init()
	{
		$this->rc = rcmail::get_instance();
		$this->add_hook('login_after', [$this, 'loginAfter']);
		$this->add_hook('startup', [$this, 'startup']);
		$this->add_hook('authenticate', [$this, 'authenticate']);

		if ($this->rc->task == 'mail') {
			$this->register_action('plugin.yetiforce.addFilesToMail', [$this, 'addFilesToMail']);
			$this->rc->output->set_env('site_URL', $this->rc->config->get('site_URL'));

			if ($this->rc->action == 'compose') {
				$this->add_texts('localization/', false);
				$this->include_script('compose.js');

				$this->add_hook('message_compose_body', [$this, 'messageComposeBody']);
				$this->add_hook('message_compose', [$this, 'messageComposeHead']);
				$this->add_hook('render_page', [$this, 'loadSignature']);

				$id = rcube_utils::get_input_value('_id', rcube_utils::INPUT_GPC);
				if ($id && isset($_SESSION['compose_data_' . $id]['param']['module'])) {
					$this->rc->output->set_env('crmModule', $_SESSION['compose_data_' . $id]['param']['module']);
				}
				if ($id && isset($_SESSION['compose_data_' . $id]['param']['record'])) {
					$this->rc->output->set_env('crmRecord', $_SESSION['compose_data_' . $id]['param']['record']);
				}
				if ($id && isset($_SESSION['compose_data_' . $id]['param']['view'])) {
					$this->rc->output->set_env('crmView', $_SESSION['compose_data_' . $id]['param']['view']);
				}
			}
			if ($this->rc->action == 'preview' || $this->rc->action == 'show') {
				$this->include_script('preview.js');
				$this->include_stylesheet($this->rc->config->get('site_URL') . 'libraries/bootstrap3/css/glyphicon.css');
				//$this->include_stylesheet($this->rc->config->get('site_URL') . 'layouts/basic/skins/icons/userIcons.css');
				$this->include_stylesheet($this->rc->config->get('site_URL') . 'libraries/bootstrap3/icons/userIcons.css');
				$this->include_stylesheet('preview.css');
				$this->add_hook('message_load', [$this, 'messageLoad']);
			}
		}
	}

	public function startup($args)
	{
		if (empty($_SESSION['user_id']) && !empty($_GET['_autologin'])) {
			$args['action'] = 'login';
		}
		return $args;
	}

	public function authenticate($args)
	{
		if (empty($_GET['_autologin'])) {
			return $args;
		}
		$key = rcube_utils::get_input_value('_autologinKey', rcube_utils::INPUT_GPC);
		$db = $this->rc->get_dbh();
		$sqlResult = $db->query('SELECT roundcube_users.* FROM u_yf_mail_autologin INNER JOIN roundcube_users ON roundcube_users.user_id = u_yf_mail_autologin.userid WHERE roundcube_users.password <> \'\' AND u_yf_mail_autologin.`key` = ?;', $key);
		$row = $db->fetch_assoc($sqlResult);

		if (!empty($row) && !empty($_GET['_autologin'])) {
			$host = false;
			foreach ($this->rc->config->get('default_host') as $key => $value) {
				if (strpos($key, $row['mail_host']) !== false) {
					$host = $key;
				}
			}
			if ($host) {
				$args['user'] = $row['username'];
				$args['pass'] = $row['password'];
				$args['host'] = $host;
				$args['cookiecheck'] = false;
				$args['valid'] = true;
			}
			$sqlResult = $db->query('DELETE FROM `u_yf_mail_autologin` WHERE `userid` = ?;', $row['user_id']);
		}
		return $args;
	}

	public function loginAfter($args)
	{
		//	Password saving
		$this->rc = rcmail::get_instance();
		$pass = rcube_utils::get_input_value('_pass', rcube_utils::INPUT_POST);
		if (!empty($pass)) {
			$sql = "UPDATE " . $this->rc->db->table_name('users') . " SET password = ? WHERE user_id = ?";
			call_user_func_array(array($this->rc->db, 'query'), array_merge(array($sql), array($pass, $this->rc->get_user_id())));
			$this->rc->db->affected_rows();
		}
		if ($_GET['_autologin'] && !empty($_REQUEST['_composeKey'])) {
			$args['_action'] = 'compose';
			$args['_task'] = 'mail';
			$args['_composeKey'] = rcube_utils::get_input_value('_composeKey', rcube_utils::INPUT_GET);
		}
		return $args;
	}

	public function messageLoad($args)
	{
		if (!isset($args['object'])) {
			return;
		}
		$this->rc->output->set_env('subject', $args['object']->headers->subject);
		$from = $args['object']->headers->from;
		$from = explode('<', rtrim($from, '>'), 2);
		$fromName = '';
		if (count($from) > 1) {
			$fromName = $from[0];
			$fromMail = $from[1];
		} else {
			$fromMail = $from[0];
		}
		$this->rc->output->set_env('fromName', $fromName);
		$this->rc->output->set_env('fromMail', $fromMail);
	}

	public function messageComposeHead($args)
	{
		$this->rc = rcmail::get_instance();
		$db = $this->rc->get_dbh();
		global $COMPOSE_ID;

		$compose = &$_SESSION['compose_data_' . $COMPOSE_ID];
		$composeKey = rcube_utils::get_input_value('_composeKey', rcube_utils::INPUT_GET);
		$result = $db->query('SELECT * FROM `u_yf_mail_compose_data` WHERE `key` = ?', $composeKey);
		$params = $db->fetch_assoc($result);
		$db->query('DELETE FROM `u_yf_mail_compose_data` WHERE `key` = ?;', $composeKey);
		if (!empty($params)) {
			$params = json_decode($params['data'], true);

			foreach ($params as $key => &$value) {
				$compose['param'][$key] = $value;
			}
			if ((isset($params['crmmodule']) && $params['crmmodule'] == 'Documents') || (isset($params['filePath']) && $params['filePath'])) {
				$userid = $this->rc->user->ID;
				list($usec, $sec) = explode(' ', microtime());
				$dId = preg_replace('/[^0-9]/', '', $userid . $sec . $usec);
				foreach (self::getAttachment($params['crmrecord'], $params['filePath']) as $index => $attachment) {
					$attachment['group'] = $COMPOSE_ID;
					$attachment['id'] = $dId . $index;
					$args['attachments'][$attachment['id']] = $attachment;
				}
			}
			if (!isset($params['mailId'])) {
				return $args;
			}
			$mailId = $params['mailId'];
			$result = $db->query('SELECT content,reply_to_email,date,from_email,to_email,cc_email,subject FROM vtiger_ossmailview WHERE ossmailviewid = ?;', $mailId);
			$row = $db->fetch_assoc($result);
			$compose['param']['type'] = $params['type'];
			$compose['param']['mailData'] = $row;
			switch ($params['type']) {
				case 'replyAll':
					$cc = $row['to_email'];
					$cc .= ',' . $row['cc_email'];
					$cc = str_replace($row['from_email'] . ',', '', $cc);
					$cc = trim($cc, ',');
				case 'reply':
					$to = $row['reply_to_email'];
					if (preg_match('/^re:/i', $row['subject']))
						$subject = $row['subject'];
					else
						$subject = 'Re: ' . $row['subject'];
					$subject = preg_replace('/\s*\([wW]as:[^\)]+\)\s*$/', '', $subject);
					break;
				case 'forward':
					if (preg_match('/^fwd:/i', $row['subject']))
						$subject = $row['subject'];
					else
						$subject = 'Fwd: ' . $row['subject'];
					break;
			}
			if (!empty($params['subject'])) {
				$subject .= ' [' . $params['subject'] . ']';
			}
			$args['param']['to'] = $to;
			$args['param']['cc'] = $cc;
			$args['param']['subject'] = $subject;
		}
		return $args;
	}

	public function messageComposeBody($args)
	{
		$this->rc = rcmail::get_instance();

		$id = rcube_utils::get_input_value('_id', rcube_utils::INPUT_GPC);
		$row = $_SESSION['compose_data_' . $id]['param']['mailData'];
		$type = $_SESSION['compose_data_' . $id]['param']['type'];
		if (!$row) {
			return;
		}
		$bodyIsHtml = $args['html'];
		$date = $row['date'];
		$from = $row['from_email'];
		$to = $row['to_email'];
		$body = $row['content'];
		$subject = $row['subject'];
		$replyto = $row['reply_to_email'];

		$prefix = $suffix = '';
		if ($type == 'forward') {
			if (!$bodyIsHtml) {
				$prefix = "\n\n\n-------- " . $this->rc->gettext('originalmessage') . " --------\n";
				$prefix .= $this->rc->gettext('subject') . ': ' . $subject . "\n";
				$prefix .= $this->rc->gettext('date') . ': ' . $date . "\n";
				$prefix .= $this->rc->gettext('from') . ': ' . $from . "\n";
				$prefix .= $this->rc->gettext('to') . ': ' . $to . "\n";
				if ($cc = $row['cc_email']) {
					$prefix .= $this->rc->gettext('cc') . ': ' . $cc . "\n";
				}
				if ($replyto != $from) {
					$prefix .= $this->rc->gettext('replyto') . ': ' . $replyto . "\n";
				}
				$prefix .= "\n";
				global $LINE_LENGTH;
				$txt = new rcube_html2text($body, false, true, $LINE_LENGTH);
				$body = $txt->get_text();
				$body = preg_replace('/\r?\n/', "\n", $body);
				$body = trim($body, "\n");
			} else {
				$prefix = sprintf(
					"<p>-------- " . $this->rc->gettext('originalmessage') . " --------</p>" .
					"<table border=\"0\" cellpadding=\"0\" cellspacing=\"0\"><tbody>" .
					"<tr><th align=\"right\" nowrap=\"nowrap\" valign=\"baseline\">%s: </th><td>%s</td></tr>" .
					"<tr><th align=\"right\" nowrap=\"nowrap\" valign=\"baseline\">%s: </th><td>%s</td></tr>" .
					"<tr><th align=\"right\" nowrap=\"nowrap\" valign=\"baseline\">%s: </th><td>%s</td></tr>" .
					"<tr><th align=\"right\" nowrap=\"nowrap\" valign=\"baseline\">%s: </th><td>%s</td></tr>", $this->rc->gettext('subject'), rcube::Q($subject), $this->rc->gettext('date'), rcube::Q($date), $this->rc->gettext('from'), rcube::Q($from, 'replace'), $this->rc->gettext('to'), rcube::Q($to, 'replace'));
				if ($cc = $row['cc_email'])
					$prefix .= sprintf("<tr><th align=\"right\" nowrap=\"nowrap\" valign=\"baseline\">%s: </th><td>%s</td></tr>", $this->rc->gettext('cc'), rcube::Q($cc, 'replace'));
				if ($replyto != $from)
					$prefix .= sprintf("<tr><th align=\"right\" nowrap=\"nowrap\" valign=\"baseline\">%s: </th><td>%s</td></tr>", $this->rc->gettext('replyto'), rcube::Q($replyto, 'replace'));
				$prefix .= "</tbody></table><br>";
			}
			$body = $prefix . $body;
		}else {
			$prefix = $this->rc->gettext(array(
				'name' => 'mailreplyintro',
				'vars' => array(
					'date' => $this->rc->format_date($date, $this->rc->config->get('date_long')),
					'sender' => $from,
				)
			));
			if (!$bodyIsHtml) {
				global $LINE_LENGTH;
				$txt = new rcube_html2text($body, false, true, $LINE_LENGTH);
				$body = $txt->get_text();
				$body = preg_replace('/\r?\n/', "\n", $body);
				$body = trim($body, "\n");
				$body = rcmailWrapAndQuote($body, $LINE_LENGTH);
				$prefix .= "\n";
				$body = $prefix . $body . $suffix;
			} else {
				$prefix = '<p>' . rcube::Q($prefix) . "</p>\n";
				$body = $prefix . '<blockquote>' . $body . '</blockquote>' . $suffix;
			}
		}
		$args['body'] = $body;
		return $args;
	}

	//	Loading signature
	public function loadSignature($response)
	{
		global $OUTPUT;
		if ($this->checkAddSignature()) {
			return;
		}
		$gS = $this->getGlobalSignature();
		if ($gS['html'] == '') {
			return;
		}
		$a_signatures = array();
		foreach ($OUTPUT->get_env('signatures') as $identity_id => $signature) {
			$a_signatures[$identity_id]['text'] = $signature['text'] . PHP_EOL . $gS['text'];
			$a_signatures[$identity_id]['html'] = $signature['html'] . '<div class="pre global">' . $gS['html'] . '</div>';
		}
		$OUTPUT->set_env('signatures', $a_signatures);
	}

	public function getGlobalSignature()
	{
		global $RCMAIL;
		$db = $RCMAIL->get_dbh();
		$result = [];
		$sql_result = $db->query("SELECT * FROM yetiforce_mail_config WHERE `type` = 'signature' AND `name` = 'signature';");

		while ($sql_arr = $db->fetch_assoc($sql_result)) {
			$result['html'] = $sql_arr['value'];
			$result['text'] = $sql_arr['value'];
		}
		return $result;
	}

	public function checkAddSignature()
	{
		global $RCMAIL;
		$db = $RCMAIL->get_dbh();
		$result = [];
		$sql_result = $db->query("SELECT * FROM yetiforce_mail_config WHERE `type` = 'signature' AND `name` = 'addSignature';");

		while ($sql_arr = $db->fetch_assoc($sql_result)) {
			return $sql_arr['value'] == 'false' ? true : false;
		}
		return true;
	}

	//	Adding attachments
	public function addFilesToMail()
	{
		$COMPOSE_ID = rcube_utils::get_input_value('_id', rcube_utils::INPUT_GPC);
		$uploadid = rcube_utils::get_input_value('_uploadid', rcube_utils::INPUT_GPC);
		$ids = $_REQUEST['ids'];
	
		$COMPOSE = null;

		if ($COMPOSE_ID && $_SESSION['compose_data_' . $COMPOSE_ID]) {
			$SESSION_KEY = 'compose_data_' . $COMPOSE_ID;
			$COMPOSE = & $_SESSION[$SESSION_KEY];
		}
		if (!$COMPOSE) {
			die("Invalid session var!");
		}
		$this->rc = rcmail::get_instance();
		$index = 0;

		$attachments = self::getFiles($ids);
		foreach ($attachments as $attachment) {
			$index++;
			$attachment['group'] = $COMPOSE_ID;
			$userid = rcmail::get_instance()->user->ID;
			list($usec, $sec) = explode(' ', microtime());
			$id = preg_replace('/[^0-9]/', '', $userid . $sec . $usec) . $index;
			$attachment['id'] = $id;

			$_SESSION['plugins']['filesystem_attachments'][$COMPOSE_ID][$id] = $attachment['path'];
			$this->rc->session->append($SESSION_KEY . '.attachments', $id, $attachment);
			if (($icon = $COMPOSE['deleteicon']) && is_file($icon)) {
				$button = html::img(array(
						'src' => $icon,
						'alt' => $this->rc->gettext('delete')
				));
			} else if ($COMPOSE['textbuttons']) {
				$button = rcube::Q($this->rc->gettext('delete'));
			} else {
				$button = '';
			}

			/*$content = html::a(array(
					'href' => "#delete",
					'onclick' => sprintf("return %s.command('remove-attachment','rcmfile%s', this)", rcmail_output::JS_OBJECT_NAME, $id),
					'title' => $this->rc->gettext('delete'),
					'class' => 'delete',
					'aria-label' => $this->rc->gettext('delete') . ' ' . $attachment['name'],
					), $button
			);

			$content .= rcube::Q($attachment['name']);
			$htmlAttachments .= 'window.rcmail.add2attachment_list("rcmfile' . $id . '",{html:"<a href=\"#delete\" onclick=\"return rcmail.command(\'remove-attachment\',\'rcmfile' . $id . '\', this)\" title=\"' . $this->rc->gettext('delete') . '\" class=\"delete\" aria-label=\"' . $this->rc->gettext('delete') . ' ' . $attachment['name'] . '\"><\/a>' . $attachment['name'] . '",name:"' . $attachment['name'] . '",mimetype:"' . $attachment['mimetype'] . '",classname:"' . rcube_utils::file2class($attachment['mimetype'], $attachment['name']) . '",complete:true},"' . $uploadid . '");' . PHP_EOL;*/
			$link_content = sprintf('%s <span class="attachment-size"> (%s)</span>',
				rcube::Q($attachment['name']), $this->rc->show_bytes($attachment['size']));
		
			$content_link = html::a(array(
				'href'    => "#load",
				'class'   => 'filename',
				'onclick' => sprintf("return %s.command('load-attachment','rcmfile%s', this, event)", rcmail_output::JS_OBJECT_NAME, $id),
			), $link_content);
		
			$delete_link = html::a(array(
				'href'    => "#delete",
				'onclick' => sprintf("return %s.command('remove-attachment','rcmfile%s', this, event)", rcmail_output::JS_OBJECT_NAME, $id),
				'title'   => $this->rc->gettext('delete'),
				'class'   => 'delete',
				'aria-label' => $this->rc->gettext('delete') . ' ' . $attachment['name'],
			), $button);
		
			$content = $COMPOSE['icon_pos'] == 'left' ? $delete_link.$content_link : $content_link.$delete_link;
			$htmlAttachments .= 'parent.rcmail.add2attachment_list("rcmfile'.$id.'",{"html":"\u003Ca href=\"#load\" class=\"filename\" onclick=\"return rcmail.command(\'load-attachment\',\'rcmfile'.$id.'\', this, event)\"\u003E'.$attachment['name'].' \u003Cspan class=\"attachment-size\"\u003E '.$this->rc->show_bytes($attachment['size']).'\u003C\/span\u003E\u003C\/a\u003E\u003Ca href=\"#delete\" onclick=\"return rcmail.command(\'remove-attachment\',\'rcmfile'.$id.'\', this, event)\" title=\"Delete\" class=\"delete\" aria-label=\"Delete '.$attachment['name'].'\"\u003E\u003C\/a\u003E","name":"'.$attachment['name'].'","mimetype":"'.$attachment['mimetype'].'","classname":"'.rcube_utils::file2class($attachment['mimetype'], $attachment['name']).'","complete":true},"'.$uploadid.'");' . PHP_EOL;
		}
		$response = '<!DOCTYPE html>
<html lang="en">
<head><title></title><meta http-equiv="content-type" content="text/html; charset=UTF-8" />
<script type="text/javascript">
if (window && parent.rcmail) {
	parent.rcmail.iframe_loaded("");
	' . $htmlAttachments . '
	parent.rcmail.auto_save_start(false);
}
</script>
</head>
<body>
</body>
</html>';
		echo $response;
		exit;
	}

	public function getFiles($ids)
	{
		$files = [];
		$files = array_merge($files, self::getAttachment($ids));
		return $files;
	}

	public function getAttachment($ids, $files)
	{
		
		$attachments = [];
		if (empty($ids) && empty($files)) {
			return $attachments;
		}
		if (is_array($ids)) {
			$ids = implode(',', $ids);
		}
		$this->rc = rcmail::get_instance();
		$db = $this->rc->get_dbh();
		$userid = $this->rc->user->ID;
		$index = 0;
		if ($ids) {
			$sql_result = $db->query("SELECT vtiger_attachments.* FROM vtiger_attachments INNER JOIN vtiger_seattachmentsrel ON vtiger_seattachmentsrel.attachmentsid=vtiger_attachments.attachmentsid WHERE vtiger_seattachmentsrel.crmid IN ($ids);");
			$num_row =  $db->num_rows($sql_result);
			if($num_row > 0){
				while ($row = $db->fetch_assoc($sql_result)) {
					$orgFile = $this->rc->config->get('root_directory') . $row['path'] . $row['attachmentsid'] . '_' . $row['name'];
					list($usec, $sec) = explode(' ', microtime());
					$filepath = $this->rc->config->get('root_directory') . 'modules/OSSMail/roundcube/temp/' . $sec . $userid . $row['attachmentsid'] . $index . '.tmp';
					if (file_exists($orgFile)) {
						copy($orgFile, $filepath);
						$attachment = [
							'path' => $filepath,
							'size' => filesize($filepath),
							'name' => $row['name'],
							'mimetype' => rcube_mime::file_content_type($filepath, $row['name'], $row['type']),
						];
						$attachments[] = $attachment;
					}
					$index++;
				}
			}
			else{
				$sql_result = $db->query("SELECT * FROM vtiger_attachments WHERE attachmentsid IN ($ids);");
				$num_row =  $db->num_rows($sql_result);
				if($num_row > 0){
					while ($row = $db->fetch_assoc($sql_result)) {
						$orgFile = $this->rc->config->get('root_directory') . $row['path'] .  $row['name'];
						list($usec, $sec) = explode(' ', microtime());
						$filepath = $this->rc->config->get('root_directory') . 'modules/OSSMail/roundcube/temp/' . $sec . $userid . $row['attachmentsid'] . $index . '.tmp';
						if (file_exists($orgFile)) {
							copy($orgFile, $filepath);
							$attachment = [
								'path' => $filepath,
								'size' => filesize($filepath),
								'name' => $row['name'],
								'mimetype' => rcube_mime::file_content_type($filepath, $row['name'], $row['type']),
							];
							$attachments[] = $attachment;
						}
						$index++;
					}
				}
			}
			
		}
		if ($files) {
			$orgFile = $this->rc->config->get('root_directory') . $files;
			list($usec, $sec) = explode(' ', microtime());
			$filepath = $this->rc->config->get('root_directory') . 'modules/OSSMail/roundcube/temp/' . $sec . $userid . $index . '.tmp';
			if (file_exists($orgFile)) {
				copy($orgFile, $filepath);
				$attachment = [
					'path' => $filepath,
					'size' => filesize($filepath),
					'name' => basename($orgFile),
					'mimetype' => rcube_mime::file_content_type($filepath, basename($orgFile)),
				];
				$attachments[] = $attachment;
			}
			$index++;
		}
		return $attachments;
	}

	public function rcmailWrapAndQuote($text, $length = 72)
	{
		// Rebuild the message body with a maximum of $max chars, while keeping quoted message.
		$max = max(75, $length + 8);
		$lines = preg_split('/\r?\n/', trim($text));
		$out = '';
		foreach ($lines as $line) {
			// don't wrap already quoted lines
			if ($line[0] == '>') {
				$line = '>' . rtrim($line);
			} else if (mb_strlen($line) > $max) {
				$newline = '';

				foreach (explode("\n", rcube_mime::wordwrap($line, $length - 2)) as $l) {
					if (strlen($l))
						$newline .= '> ' . $l . "\n";
					else
						$newline .= ">\n";
				}

				$line = rtrim($newline);
			} else {
				$line = '> ' . $line;
			}
			// Append the line
			$out .= $line . "\n";
		}
		return rtrim($out, "\n");
	}
}
