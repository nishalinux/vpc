<?php
/*+********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *******************************************************************************/

class OS2LoginHistory {

 	/**
	* Invoked when special actions are performed on the module.
	* @param String Module name
	* @param String Event Type
	*/
    /**
     * Delete a file or recursively delete a directory
     *
     * @param string $str Path to file or directory
     */

	 var $log;

     function __construct() {
		$this->copiedFiles = Array();
		$this->failedCopies = Array();
		$this->ignoredFiles = Array();
		$this->failedDirectories = Array();
		$this->savedFiles = Array();
		//echo php_uname();
		//echo PHP_OS;
		if (isset($_SERVER['COMSPEC']) || isset($SERVER['WINDIR']))
			$hostOSType='Windows';
		else
			$hostOSType='Linux';
		$this->log = LoggerManager::getLogger('account');
		//echo "<hr><table><tr valign=\"absmiddle\"><td><img width=100px src='modules/vtDZiner/images/vtigress.png' />&nbsp;<span style='font-size:18px;font-weight:bold;'>presents vtDZiner 5.5.8</span> </td> </tr> </table><br><br>";
	}

	function recursiveDelete($str){
		if(is_file($str)){
			return @unlink($str);
		}
		elseif(is_dir($str)){
			$scan = glob(rtrim($str,'/').'/*');
			foreach($scan as $index=>$path){
				$this->recursiveDelete($path);
			}
			return @rmdir($str);
		}
	}

    function vtFileCopy( $source ) {
		if (is_file($source))
		{
			$data = file_get_contents($source);
			$targetfile = "modules/OS2LoginHistory/yourcopies/".substr( $source , 2 );
			$targetpaths = explode (DIRECTORY_SEPARATOR, $targetfile);
			$targetfile = $targetpaths[count($targetpaths)-1];
			unset($targetpaths[count($targetpaths)-1]);
			$targetpath = implode(DIRECTORY_SEPARATOR, $targetpaths);
			//print('<pre>');print_r($targetpaths);print('</pre>');
			//echo "<br>Targetfile is $targetfile, path is $targetpath<br>";
			if (!is_dir($targetpath))
			{
				if (mkdir($targetpath, 0777, true)){
					file_put_contents("modules/OS2LoginHistory/yourcopies/".substr( $source , 2 ), $data);
					//echo "$source saved in modules/OS2LoginHistory/yourcopies<br>";
					$this->savedFiles[] = "$source saved in modules/OS2LoginHistory/yourcopies";
				}
				else {
					//echo "<br>Could not create $targetpath<br>";
					$this->failedDirectories[] = "Could not create $targetpath";
				}
			}
			else {
				file_put_contents("modules/OS2LoginHistory/yourcopies/".substr( $source , 2 ), $data);
				//echo "Saved current copy of $source in modules/Counters/yourcopies<br>";
				$this->savedFiles[] = "$source saved in modules/OS2LoginHistory/yourcopies";
			}
		} else {
			//echo "&nbsp;&nbsp;&nbsp;"."<font color=red>Ignored file $source</font><br>";
			//TODO To check why the ignored file is needed
			//$this->ignoredFiles[] = "Ignored file for archiving $source";
		}
	}

    function copy_r( $path, $dest ) {
        if( is_dir($path) ) {
            @mkdir( $dest );
            $objects = scandir($path);
            if( sizeof($objects) > 0 ) {
                foreach( $objects as $file ) {
                    if( $file == "." || $file == ".." )
                        continue;
                    // go on
                    if( is_dir( $path.DIRECTORY_SEPARATOR.$file ) ) {
                        $this->copy_r( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
                    }
                    else {
						// TODO Must save existing script copies for rollback
						$this->vtFileCopy($dest.DIRECTORY_SEPARATOR.$file);
                        $crslt = copy( $path.DIRECTORY_SEPARATOR.$file, $dest.DIRECTORY_SEPARATOR.$file );
						if ($crslt) {
							//echo "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file."<br>";
							$this->copiedFiles[] = "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
						}
						else {
							$this->failedCopies[] = "Could not copy ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
						}
                    }
                }
            }
            return true;
        }
        elseif( is_file($path) ) {
			$crslt = copy($path, $dest);
			if ($crslt)
			{
				//echo "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file."<br>";
				$this->copiedFiles[] = "Copied ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
			}
			else {
				//echo "<font color=red>Could not copy ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file."</font><br>";
				$this->failedCopies[] = "Could not copy ".$path.DIRECTORY_SEPARATOR.$file." to ".$dest.DIRECTORY_SEPARATOR.$file;
			}
            return $crslt;
        }
        else {
            return false;
        }
    }

 	function vtlib_handler($moduleName, $eventType)
	{
		require_once('include/utils/utils.php');
		require_once('include/utils/VtlibUtils.php');
		require_once('vtlib/Vtiger/Module.php');
		global $adb;

		if($eventType == 'module.postinstall')
		{

			$fieldid = $adb->getUniqueID('vtiger_settings_field');
			$blockid = getSettingsBlockId('LBL_MODULE_MANAGER');

			$seq_res = $adb->query("SELECT max(sequence) AS max_seq FROM vtiger_settings_field WHERE blockid = 1");
			$seq = 1;
			if ($adb->num_rows($seq_res) > 0) {
				$cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
				if ($cur_seq != null)	$seq = $cur_seq + 1;
			}

			$adb->pquery('INSERT INTO vtiger_settings_field(fieldid, blockid, name, iconpath, description, linkto, sequence,active, pinned)
				VALUES (?,?,?,?,?,?,?,?,?)', array($fieldid, 2, 'OS2LoginHistory', 'portal_icon.png', 'OS2LoginHistory of all modules..', 'index.php?module=OS2LoginHistory&parent=Settings&view=List', $seq, 0, 1));

			// Mark the module as Custom module
			 $adb->pquery('UPDATE vtiger_tab SET customized=1 WHERE name=?', array($moduleName));

		}

 		if($eventType == 'module.preupdate') {

		}

 		if($eventType == 'module.postupdate') {

		}
		$this->copy_r("modules/OS2LoginHistory/vtiger6", ".");
		$this->recursiveDelete("modules/OS2LoginHistory/vtiger6");
	}
}
?>
