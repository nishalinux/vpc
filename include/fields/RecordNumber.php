<?php namespace includes\fields;

/**
 * Record number class
 * @package YetiForce.Include
 * @license licenses/License.html
 * @author Tomasz Kur <t.kur@yetiforce.com>
 */
class RecordNumber
{

	/**
	 * Function that checks if a module has serial number configuration.
	 * @param int $tabId
	 * @return boolean
	 */
	public static function isModuleSequenceConfigured($tabId)
	{
		$db = \PearDatabase::getInstance();
		if (!is_numeric($tabId)) {
			//$tabId = Vtiger_Functions::getModuleId($tabId);
			$tabId = Vtiger_Functions::getModuleNameById($tabId);
		}
		$result = $db->pquery('SELECT 1 FROM vtiger_modentity_num WHERE semodule = ?', [$tabId]);
		if ($result && $db->num_rows($result) > 0) {
			return true;
		}
		return false;
	}

	/**
	 * Function to set number sequence of recoords for module
	 * @param mixed $tabId
	 * @param string $prefix
	 * @param int $no
	 * @param string $postfix
	 * @return boolean
	 */
	public static function setNumber($tabId, $prefix = '', $no = '', $postfix = '')
	{
		if ($no != '') {
			$db = \PearDatabase::getInstance();
			if (is_numeric($tabId)) {
				//$tabId = Vtiger_Functions::getModuleId($tabId);
				$tabId = Vtiger_Functions::getModuleNameById($tabId);
			}
			$query = 'SELECT cur_id FROM vtiger_modentity_num WHERE semodule = ?';
			$check = $db->pquery($query, [$tabId]);
			$numRows = $db->getRowCount($check);
			if ($numRows == 0) {
				/*$db->insert('vtiger_modentity_num', [
					'tabid' => $tabId,
					'prefix' => $prefix,
					'postfix' => $postfix,
					'start_id' => $no,
					'cur_id' => $no,
				]);*/
				$db->pquery('INSERT INTO vtiger_modentity_num (`semodule`,`prefix`,`postfix`,`start_id`,`cur_id`) VALUES (?,?,?,?,?);', [$tabId, $prefix,$postfix,$no,$no]);
				return true;
			} else {
				if ($no < $db->getSingleValue($check)) {
					return false;
				} else {
					//$db->update('vtiger_modentity_num', ['cur_id' => $no, 'prefix' => $prefix, 'postfix' => $postfix], 'tabid = ?', [$tabId]);
					$db->pquery('UPDATE vtiger_modentity_num SET cur_id=?,prefix=?,postfix=? WHERE semodule=?;', [$no, $prefix,$postfix,$tabId]);
					return true;
				}
			}
		}
	}

	/**
	 * Function that gets the next sequence number of a record
	 * @param int $moduleId Number id for module
	 * @return string
	 */
	public static function incrementNumber($moduleId)
	{
		$db = \PearDatabase::getInstance();
		if (is_numeric($moduleId)) {
			//$tabId = Vtiger_Functions::getModuleId($tabId);
			$moduleId = Vtiger_Functions::getModuleNameById($moduleId);
		}
		//when we save new invoice we will increment the invoice id and write
		$result = $db->pquery('SELECT cur_id, prefix, postfix FROM vtiger_modentity_num WHERE semodule = ?', [$moduleId]);
		$row = $db->getRow($result);

		$prefix = $row['prefix'];
		$postfix = $row['postfix'];
		$curid = $row['cur_id'];
		$fullPrefix = self::parse($prefix . $curid . $postfix);
		$strip = strlen($curid) - strlen($curid + 1);
		if ($strip < 0) {
			$strip = 0;
		}
		$temp = str_repeat('0', $strip);
		$reqNo = $temp . ($curid + 1);
		//$db->update('vtiger_modentity_num', ['cur_id' => $reqNo], 'cur_id = ? AND tabid = ?', [$curid, $moduleId]);
		$db->pquery('UPDATE vtiger_modentity_num SET cur_id=? WHERE cur_id = ? AND semodule=?;', [$reqNo, $curid,$moduleId]);
		return decode_html($fullPrefix);
	}

	/**
	 * Converts record numbering variables to values
	 * @param string $content
	 * @return string
	 */
	public static function parse($content)
	{
		$content = str_replace('{{YYYY}}', date('Y'), $content);
		$content = str_replace('{{YY}}', date('y'), $content);
		$content = str_replace('{{MM}}', date('m'), $content);
		$content = str_replace('{{M}}', date('n'), $content);
		$content = str_replace('{{DD}}', date('d'), $content);
		$content = str_replace('{{D}}', date('j'), $content);
		return $content;
	}

	public static function updateNumber($curId, $tabId)
	{
		$db = \PearDatabase::getInstance();
		$tabId = Vtiger_Functions::getModuleNameById($tabId);
		//$db->update('vtiger_modentity_num', ['cur_id' => $curId], 'tabid = ?', [$tabId]);
		$db->pquery('UPDATE vtiger_modentity_num SET cur_id=? WHERE semodule=?;', [$curId, $tabId]);
	}

	public static function getNumber($tabId)
	{
		if (is_numeric($tabId)) {
			//$tabId = Vtiger_Functions::getModuleId($tabId);
			$tabId = Vtiger_Functions::getModuleNameById($tabId);
		}
		$adb = \PearDatabase::getInstance();
		$result = $adb->pquery('SELECT cur_id, prefix, postfix FROM vtiger_modentity_num WHERE semodule = ? ', [$tabId]);
		$row = $adb->getRow($result);
		return [
			'prefix' => $row['prefix'],
			'sequenceNumber' => $row['cur_id'],
			'postfix' => $row['postfix'],
			'number' => self::parse($row['prefix'] . $row['cur_id'] . $row['postfix'])
		];
	}
}
