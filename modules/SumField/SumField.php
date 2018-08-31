<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */

require_once('data/CRMEntity.php');
require_once('data/Tracker.php');
require_once 'vtlib/Vtiger/Module.php';
require_once('modules/com_vtiger_workflow/include.inc');

class SumField extends CRMEntity {
    /**
     * Invoked when special actions are performed on the module.
     * @param String Module name
     * @param String Event Type (module.postinstall, module.disabled, module.enabled, module.preuninstall)
     */
    function vtlib_handler($modulename, $event_type) {
        global $adb;
        if($event_type == 'module.postinstall') {
            self::checkEnable();
            self::addSettings();
            self::installWorkflow();
            self::resetValid();
        } else if($event_type == 'module.disabled') {
            // TODO Handle actions when this module is disabled.
            self::removeSettings();
            self::removeWorkflows();
        } else if($event_type == 'module.enabled') {
            // TODO Handle actions when this module is enabled.
            self::addSettings();
            self::installWorkflow();
        } else if($event_type == 'module.preuninstall') {
            // TODO Handle actions when this module is about to be deleted.
            self::removeSettings();
            self::removeWorkflows();
            self::removeValid();
        } else if($event_type == 'module.preupdate') {
            // TODO Handle actions before this module is updated.
        } else if($event_type == 'module.postupdate') {
            self::removeSettings();
            self::removeWorkflows();
            self::checkEnable();
            self::addSettings();
            self::installWorkflow();
            self::resetValid();
        }
    }

    static function resetValid() {
        global $adb;
        $adb->pquery("DELETE FROM `vte_modules` WHERE module=?;",array('SumField'));
        $adb->pquery("INSERT INTO `vte_modules` (`module`, `valid`) VALUES (?, ?);",array('SumField','0'));
    }
    static function removeValid() {
        global $adb;
        $adb->pquery("DELETE FROM `vte_modules` WHERE module=?;",array('SumField'));
    }
    static function checkEnable() {
        global $adb;
        $rs=$adb->pquery("SELECT `enable` FROM `sumfield_settings`;",array());
        if($adb->num_rows($rs)==0) {
            $adb->pquery("INSERT INTO `sumfield_settings` (`enable`) VALUES ('0');",array());
        }
    }


    static function addSettings() {
        global $adb;

        $max_id=$adb->getUniqueID('vtiger_settings_field');
        $adb->pquery("INSERT INTO `vtiger_settings_field` (`fieldid`, `blockid`, `name`, `description`, `linkto`, `sequence`) VALUES (?, ?, ?, ?, ?, ?)",array($max_id, '4', 'SumField', 'Settings area for Sum Field', 'index.php?module=SumField&parent=Settings&view=Settings', $max_id));
    }

    static function removeSettings() {
        global $adb;
        $adb->pquery("DELETE FROM vtiger_settings_field WHERE `name` = ?",array('SumField'));
    }

    static function installWorkflow() {
        global $adb;
        $name='SumFieldTask';
        $dest1 = "modules/com_vtiger_workflow/tasks/".$name.".inc";
        $source1 = "modules/SumField/workflow/".$name.".inc";

     /*   if (file_exists($dest1)) {
            $file_exist1 = true;
        } else {
            if(copy($source1, $dest1)) {
                $file_exist1 = true;
            }
        }*/

        if(copy($source1, $dest1)) {
            $file_exist1 = true;
        }

        $dest2 = "layouts/vlayout/modules/Settings/Workflows/Tasks/".$name.".tpl";
        $source2 = "layouts/vlayout/modules/SumField/taskforms/".$name.".tpl";

     /*   if (file_exists($dest2)) {
            $file_exist2 = true;
        } else {
            if(copy($source2, $dest2)) {
                $file_exist2 = true;
            }
        }*/
        if(copy($source2, $dest2)) {
            $file_exist2 = true;
        }

        if ($file_exist1 && $file_exist2) {
            $sql1 = "SELECT * FROM com_vtiger_workflow_tasktypes WHERE tasktypename = ?";
            $result1 = $adb->pquery($sql1,array($name));

            if ($adb->num_rows($result1) == 0) {
                // Add workflow task
                $taskType = array("name"=>"SumFieldTask", "label"=>"Sum Field Task", "classname"=>"SumFieldTask", "classpath"=>"modules/SumField/workflow/SumFieldTask.inc", "templatepath"=>"modules/SumField/taskforms/SumFieldTask.tpl", "modules"=>array('include' => array(), 'exclude'=>array()), "sourcemodule"=>'SumField');
                VTTaskType::registerTaskType($taskType);
            }
        }
    }

    static function removeWorkflows() {
        global $adb;
        $sql1 = "DELETE FROM com_vtiger_workflow_tasktypes WHERE sourcemodule = ?";
        $adb->pquery($sql1, array('SumField'));

        $sql2 = "DELETE FROM com_vtiger_workflowtasks WHERE task LIKE ?";
        $adb->pquery($sql2,array('%:"SumFieldTask":%'));

        @shell_exec('rm -f modules/com_vtiger_workflow/tasks/SumFieldTask.inc');
        @shell_exec('rm -f layouts/vlayout/modules/Settings/Workflows/Tasks/SumFieldTask.tpl');
        
    }
}
?>