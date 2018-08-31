<?php
/*+********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *******************************************************************************/

class Phylos {

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
			$targetfile = "modules/vtDZiner/yourcopies/".substr( $source , 2 );
			$targetpaths = explode (DIRECTORY_SEPARATOR, $targetfile);
			$targetfile = $targetpaths[count($targetpaths)-1];
			unset($targetpaths[count($targetpaths)-1]);
			$targetpath = implode(DIRECTORY_SEPARATOR, $targetpaths);
			//print('<pre>');print_r($targetpaths);print('</pre>');
			//echo "<br>Targetfile is $targetfile, path is $targetpath<br>";
			if (!is_dir($targetpath))
			{
				if (mkdir($targetpath, 0777, true)){
					file_put_contents("modules/vtDZiner/yourcopies/".substr( $source , 2 ), $data);
					//echo "$source saved in modules/vtDZiner/yourcopies<br>";
					$this->savedFiles[] = "$source saved in modules/vtDZiner/yourcopies";
				}
				else {
					//echo "<br>Could not create $targetpath<br>";
					$this->failedDirectories[] = "Could not create $targetpath";
				}
			}
			else {
				file_put_contents("modules/vtDZiner/yourcopies/".substr( $source , 2 ), $data);
				//echo "Saved current copy of $source in modules/vtDZiner/yourcopies<br>";
				$this->savedFiles[] = "$source saved in modules/vtDZiner/yourcopies";
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
		require_once('vtlib/Vtiger/Block.php');	
		require_once('vtlib/Vtiger/Field.php');	
		global $adb;
		if($eventType == 'module.preinstall'){
			$module = vtiger_module::getinstance('SampleAnalysis');		
			if(!$module){
				$result = array('success'=>false,'importModuleName' =>'SampleAnalysis is not a Module.');
				$response = new Vtiger_Response();
				$response->setEmitType(Vtiger_Response::$EMIT_JSON);
				$response->setResult($result);
				$response->emit();
				die;
			}
		}
		if($eventType == 'module.postinstall')
		{
			$module = vtiger_module::getinstance('SampleAnalysis');		
			if($module){ 
				$tabid = getTabid('SampleAnalysis');			
				$fieldid = $adb->getUniqueID('vtiger_settings_field');
				$blockid = getSettingsBlockId('LBL_MODULE_MANAGER');
				$seq_res = $adb->query("SELECT max(sequence) AS max_seq FROM vtiger_settings_field WHERE blockid =4");
				$seq = 1;
				if ($adb->num_rows($seq_res) > 0) {
					$cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
					if ($cur_seq != null)	$seq = $cur_seq + 1;
				}
				$entryExists = $adb->num_rows($adb->query("SELECT name FROM vtiger_settings_field where name = 'Phylos Details'"));
				if ( $entryExists == 0){
				$adb->pquery('INSERT INTO vtiger_settings_field(fieldid, blockid, name, iconpath, description, linkto, sequence,active, pinned)
					VALUES (?,?,?,?,?,?,?,?,?)', array($fieldid, 4, 'Phylos Details', 'portal_icon.png', 'To Configure Phylos API and Testing', 'index.php?module=Phylos&parent=Settings&view=PhylosDetail', $seq, 0, 1));
				}

				#insert table vtiger_phylosinfo
				$adb->query("CREATE TABLE IF NOT EXISTS vtiger_phylosinfo (
							id int(19) NOT NULL AUTO_INCREMENT,
							email varchar(150) DEFAULT NULL,
							api_key varchar(250) DEFAULT NULL,
							PRIMARY KEY (id)
							) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ");

				#insert table vtiger_phylosinfo
				$adb->query("CREATE TABLE IF NOT EXISTS vtiger_phylos_kit_list (
								id int(11) NOT NULL AUTO_INCREMENT,
								kitid varchar(255) NOT NULL,
								PRIMARY KEY (id)
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ");

				#workflow
				require 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
				$emm = new VTEntityMethodManager($adb);   
				$methodNames = $emm->methodsForModule("SampleAnalysis");
				if (! in_array('Phylos Chemotype Submission', $methodNames)){
					$emm->addEntityMethod("SampleAnalysis", "Phylos Chemotype Submission", "modules/SampleAnalysis/Workflows/phylosChemotypeSubmission.php", "phylosChemotypeSubmission");
				}
   
				#Blocks			 
				$blocks = vtiger_block::getAllForModule(vtiger_module::getinstance('SampleAnalysis'));		
				$new_block_labels = array('Sample Analysis Results','Phylos Bioscience Genetic Info');
				$old_block_labels = array();
				$old_block_ids = array();
				#getting all Blocks
				foreach ($blocks as $k=>$v) {					
					$old_block_labels[$k] = $v->label;
					$old_block_ids[$v->label] = $v->id;				
				}
				#adding Blocks if not exist 
				foreach($new_block_labels as $new_lbl){
					if(!in_array($new_lbl,$old_block_labels)){
						$myblock = new vtiger_block();
						$myblock->label = $new_lbl;
						$module->addblock($myblock); 
					}
				}
				#after inserting new blocks get ids again
				$blocks = vtiger_block::getAllForModule(vtiger_module::getinstance('SampleAnalysis'));
				$old_block_labels = array();
				#getting all Blocks
				foreach ($blocks as $k=>$v) {					
					$old_block_labels[$k] = $v->label;
					$old_block_ids[$v->label] = $v->id;				
				}
			
				#fields
				$fields = Vtiger_Field::getAllForModule(vtiger_module::getinstance('SampleAnalysis'));
				$old_fields = array();
				#new fields
				$new_fields = array( 
					array(
						'block_label'=>'Sample Analysis Results',
						'name'=>'thc_percentage',
						'label'=>'THC Percentage',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'thc_percentage',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Sample Analysis Results']
					),
					array(
						'block_label'=>'Sample Analysis Results',
						'name'=>'cbd_percentage',
						'label'=>'CBD Percentage',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'cbd_percentage',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Sample Analysis Results']
					),
					array(
						'block_label'=>'Phylos Bioscience Genetic Info',
						'name'=>'genotype_kit_id',
						'label'=>'Genotype Kit ID',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'genotype_kit_id',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Phylos Bioscience Genetic Info']
					),
					array(
						'block_label'=>'Phylos Bioscience Genetic Info',
						'name'=>'confirmation_id',
						'label'=>'Confirmation Id',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'confirmation_id',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Phylos Bioscience Genetic Info']
					)
				);
				#getting all fields into array
				foreach ($fields as $k=>$v) {	 
					$old_fields[] = $v->column;
				}
				#adding fields if not exist

				foreach($new_fields as $k=>$newfields_data){  
					 
					if(!in_array($newfields_data['column'],$old_fields)){
						
						/*$myblock = new vtiger_block();
						$myblock->label = $newfields_data['block_label'];

						$field1 = new vtiger_field();  
						$field1->name = $newfields_data['name']; 
						$field1->label= $newfields_data['label']; 
						$field1->table = $newfields_data['table']; 
						$field1->column = $newfields_data['column']; 
						$field1->columntype = $newfields_data['columntype']; 
						$field1->uitype = $newfields_data['uitype']; 
						$field1->typeofdata = $newfields_data['typeofdata']; 
						$field1->helpinfo = $newfields_data['helpinfo']; 
						$field1->block = $newfields_data['block'];  
						$myblock->addfield($field1);
						*/
					/*	INSERT INTO `vtiger_field` (`tabid`, `fieldid`, `columnname`, `tablename`, `generatedtype`, `uitype`, `fieldname`, `fieldlabel`, `readonly`, `presence`, `defaultvalue`, `maximumlength`, `sequence`, `block`, `displaytype`, `typeofdata`, `quickcreate`, `quickcreatesequence`, `info_type`, `masseditable`, `helpinfo`, `summaryfield`) VALUES
						(56, 1678, 'cf_1677', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1677', 'THC Percentage', 1, 2, '', 100, 7, 124, 1, 'V~O~LE~250', 1, NULL, 'BAS', 1, '', 0),
						(56, 1680, 'cf_1679', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1679', 'CBD Percentage', 1, 2, '', 100, 8, 124, 1, 'V~O~LE~250', 1, NULL, 'BAS', 1, '', 0),
						(56, 1682, 'cf_1681', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1681', 'Genotype Kit ID', 1, 2, '', 100, 1, 179, 1, 'V~O~LE~250', 1, NULL, 'BAS', 1, '', 0),
						(56, 1684, 'cf_1683', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1683', 'Confirmation Id', 1, 2, '', 100, 2, 179, 1, 'V~O~LE~250', 1, NULL, 'BAS', 2, '', 0); */

						$q = "INSERT INTO `vtiger_field` (`tabid`, `fieldid`, `columnname`, `tablename`, `generatedtype`, `uitype`, `fieldname`, `fieldlabel`, `readonly`, `presence`, `defaultvalue`, `maximumlength`, `sequence`, `block`, `displaytype`, `typeofdata`, `quickcreate`, `info_type`, `masseditable`, `helpinfo`, `summaryfield`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
						
						$fieldid = $adb->getUniqueID('vtiger_field');
						$seq_res = $adb->pquery("SELECT MAX(sequence) AS max_seq FROM vtiger_field WHERE tabid=? AND block=?",array($tabid,$newfields_data['block']));
						$sequence = 1;
						if ($adb->num_rows($seq_res) > 0) {
							$cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
							if ($cur_seq != null)	$sequence = $cur_seq + 1;
						}					 
 
						$data = array($tabid,$fieldid, $newfields_data['column'],$newfields_data['table'],2,$newfields_data['uitype'],$newfields_data['name'],$newfields_data['label'],1,2,'',100,$sequence,$newfields_data['block'],1,$newfields_data['typeofdata'],1,'BAS',1,$newfields_data['helpinfo'],0);
						$adb->pquery($q,$data);
						

						#alter query of module table
						$q = "ALTER TABLE  ".$newfields_data['table']." ADD  ".$newfields_data['column']." ".$newfields_data['columntype']." NULL AFTER sampleanalysisid ";
						$adb->query($q);
					} 

				} 

			}#end if module
			 
		}

 		if($eventType == 'module.preupdate') {

		}

 		if($eventType == 'module.postupdate') {
			$module = vtiger_module::getinstance('SampleAnalysis');		
			if($module){ 
				$tabid = getTabid('SampleAnalysis');			
				$fieldid = $adb->getUniqueID('vtiger_settings_field');
				$blockid = getSettingsBlockId('LBL_MODULE_MANAGER');
				$seq_res = $adb->query("SELECT max(sequence) AS max_seq FROM vtiger_settings_field WHERE blockid =4");
				$seq = 1;
				if ($adb->num_rows($seq_res) > 0) {
					$cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
					if ($cur_seq != null)	$seq = $cur_seq + 1;
				}
				$entryExists = $adb->num_rows($adb->query("SELECT name FROM vtiger_settings_field where name = 'Phylos Details'"));
				if ( $entryExists == 0){
				$adb->pquery('INSERT INTO vtiger_settings_field(fieldid, blockid, name, iconpath, description, linkto, sequence,active, pinned)
					VALUES (?,?,?,?,?,?,?,?,?)', array($fieldid, 4, 'Phylos Details', 'portal_icon.png', 'To Configure Phylos API and Testing', 'index.php?module=Phylos&parent=Settings&view=PhylosDetail', $seq, 0, 1));
				}

				#insert table vtiger_phylosinfo
				$adb->query("CREATE TABLE IF NOT EXISTS vtiger_phylosinfo (
							id int(19) NOT NULL AUTO_INCREMENT,
							email varchar(150) DEFAULT NULL,
							api_key varchar(250) DEFAULT NULL,
							PRIMARY KEY (id)
							) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ");

				#insert table vtiger_phylosinfo
				$adb->query("CREATE TABLE IF NOT EXISTS vtiger_phylos_kit_list (
								id int(11) NOT NULL AUTO_INCREMENT,
								kitid varchar(255) NOT NULL,
								PRIMARY KEY (id)
								) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ");

				#workflow
				require 'modules/com_vtiger_workflow/VTEntityMethodManager.inc';
				$emm = new VTEntityMethodManager($adb);   
				$methodNames = $emm->methodsForModule("SampleAnalysis");
				if (! in_array('Phylos Chemotype Submission', $methodNames)){
					$emm->addEntityMethod("SampleAnalysis", "Phylos Chemotype Submission", "modules/SampleAnalysis/Workflows/phylosChemotypeSubmission.php", "phylosChemotypeSubmission");
				}
   
				#Blocks			 
				$blocks = vtiger_block::getAllForModule(vtiger_module::getinstance('SampleAnalysis'));		
				$new_block_labels = array('Sample Analysis Results','Phylos Bioscience Genetic Info');
				$old_block_labels = array();
				$old_block_ids = array();
				#getting all Blocks
				foreach ($blocks as $k=>$v) {					
					$old_block_labels[$k] = $v->label;
					$old_block_ids[$v->label] = $v->id;				
				}
				#adding Blocks if not exist 
				foreach($new_block_labels as $new_lbl){
					if(!in_array($new_lbl,$old_block_labels)){
						$myblock = new vtiger_block();
						$myblock->label = $new_lbl;
						$module->addblock($myblock); 
					}
				}
				#after inserting new blocks get ids again
				$blocks = vtiger_block::getAllForModule(vtiger_module::getinstance('SampleAnalysis'));
				$old_block_labels = array();
				#getting all Blocks
				foreach ($blocks as $k=>$v) {					
					$old_block_labels[$k] = $v->label;
					$old_block_ids[$v->label] = $v->id;				
				}	
			
				#fields
				$fields = Vtiger_Field::getAllForModule(vtiger_module::getinstance('SampleAnalysis'));
				$old_fields = array();
				#new fields
				$new_fields = array( 
					array(
						'block_label'=>'Sample Analysis Results',
						'name'=>'thc_percentage',
						'label'=>'THC Percentage',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'thc_percentage',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Sample Analysis Results']
					),
					array(
						'block_label'=>'Sample Analysis Results',
						'name'=>'cbd_percentage',
						'label'=>'CBD Percentage',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'cbd_percentage',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Sample Analysis Results']
					),
					array(
						'block_label'=>'Phylos Bioscience Genetic Info',
						'name'=>'genotype_kit_id',
						'label'=>'Genotype Kit ID',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'genotype_kit_id',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Phylos Bioscience Genetic Info']
					),
					array(
						'block_label'=>'Phylos Bioscience Genetic Info',
						'name'=>'confirmation_id',
						'label'=>'Confirmation Id',
						'table'=>'vtiger_sampleanalysiscf',
						'column'=>'confirmation_id',
						'columntype'=>'varchar(100)',
						'uitype'=>'1',
						'typeofdata'=>'V~O~LE~250',
						'helpinfo'=>'',
						'block'=>$old_block_ids['Phylos Bioscience Genetic Info']
					)
				);
				#getting all fields into array
				foreach ($fields as $k=>$v) {	 
					$old_fields[] = $v->column;
				}
				#adding fields if not exist

				foreach($new_fields as $k=>$newfields_data){  
					 
					if(!in_array($newfields_data['column'],$old_fields)){
						
						/*$myblock = new vtiger_block();
						$myblock->label = $newfields_data['block_label'];

						$field1 = new vtiger_field();  
						$field1->name = $newfields_data['name']; 
						$field1->label= $newfields_data['label']; 
						$field1->table = $newfields_data['table']; 
						$field1->column = $newfields_data['column']; 
						$field1->columntype = $newfields_data['columntype']; 
						$field1->uitype = $newfields_data['uitype']; 
						$field1->typeofdata = $newfields_data['typeofdata']; 
						$field1->helpinfo = $newfields_data['helpinfo']; 
						$field1->block = $newfields_data['block'];  
						$myblock->addfield($field1);
						*/
					/*	INSERT INTO `vtiger_field` (`tabid`, `fieldid`, `columnname`, `tablename`, `generatedtype`, `uitype`, `fieldname`, `fieldlabel`, `readonly`, `presence`, `defaultvalue`, `maximumlength`, `sequence`, `block`, `displaytype`, `typeofdata`, `quickcreate`, `quickcreatesequence`, `info_type`, `masseditable`, `helpinfo`, `summaryfield`) VALUES
						(56, 1678, 'cf_1677', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1677', 'THC Percentage', 1, 2, '', 100, 7, 124, 1, 'V~O~LE~250', 1, NULL, 'BAS', 1, '', 0),
						(56, 1680, 'cf_1679', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1679', 'CBD Percentage', 1, 2, '', 100, 8, 124, 1, 'V~O~LE~250', 1, NULL, 'BAS', 1, '', 0),
						(56, 1682, 'cf_1681', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1681', 'Genotype Kit ID', 1, 2, '', 100, 1, 179, 1, 'V~O~LE~250', 1, NULL, 'BAS', 1, '', 0),
						(56, 1684, 'cf_1683', 'vtiger_sampleanalysiscf', 2, '1', 'cf_1683', 'Confirmation Id', 1, 2, '', 100, 2, 179, 1, 'V~O~LE~250', 1, NULL, 'BAS', 2, '', 0); */

						$q = "INSERT INTO `vtiger_field` (`tabid`, `fieldid`, `columnname`, `tablename`, `generatedtype`, `uitype`, `fieldname`, `fieldlabel`, `readonly`, `presence`, `defaultvalue`, `maximumlength`, `sequence`, `block`, `displaytype`, `typeofdata`, `quickcreate`, `info_type`, `masseditable`, `helpinfo`, `summaryfield`) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)"; 
						
						$fieldid = $adb->getUniqueID('vtiger_field');
						$seq_res = $adb->pquery("SELECT MAX(sequence) AS max_seq FROM vtiger_field WHERE tabid=? AND block=?",array($tabid,$newfields_data['block']));
						$sequence = 1;
						if ($adb->num_rows($seq_res) > 0) {
							$cur_seq = $adb->query_result($seq_res, 0, 'max_seq');
							if ($cur_seq != null)	$sequence = $cur_seq + 1;
						}					 
 
						$data = array($tabid,$fieldid, $newfields_data['column'],$newfields_data['table'],2,$newfields_data['uitype'],$newfields_data['name'],$newfields_data['label'],1,2,'',100,$sequence,$newfields_data['block'],1,$newfields_data['typeofdata'],1,'BAS',1,$newfields_data['helpinfo'],0);
						$adb->pquery($q,$data);
						

						#alter query of module table
						$q = "ALTER TABLE  ".$newfields_data['table']." ADD  ".$newfields_data['column']." ".$newfields_data['columntype']." NULL AFTER sampleanalysisid ";
						$adb->query($q);
					} 

				} 

			}#end if module
		}

		$this->copy_r("modules/Phylos/system", ".");
		$this->recursiveDelete("modules/Phylos/system");
	}
}
?>
