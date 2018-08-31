<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */
vimport('~~modules/com_vtiger_workflow/include.inc');
vimport('~~modules/com_vtiger_workflow/tasks/VTEntityMethodTask.inc');
vimport('~~modules/com_vtiger_workflow/VTEntityMethodManager.inc');
class SumField_ActionAjax_Action extends Vtiger_Action_Controller {

    function checkPermission(Vtiger_Request $request) {
        return;
    }

    function __construct() {
        parent::__construct();
        $this->exposeMethod('enableModule');
         $this->vteLicense();
    }

    function vteLicense() {
        $vTELicense=new SumField_VTELicense_Model('SumField');
        if(!$vTELicense->validate()){
            header("Location: index.php?module=SumField&parent=Settings&view=Settings&mode=step2");
        }
    }

    function process(Vtiger_Request $request) {
        $mode = $request->get('mode');
        if(!empty($mode)) {
            $this->invokeExposedMethod($mode, $request);
            return;
        }
    }

    function enableModule(Vtiger_Request $request) {
        global $adb;
        $value=$request->get('value');
        $response = new Vtiger_Response();
        $adb->pquery("UPDATE `sumfield_settings` SET `enable`=?",array($value));
        if($value==1) {
            $sql1 = "SELECT * FROM com_vtiger_workflow_tasktypes WHERE tasktypename = ?";
            $result1 = $adb->pquery($sql1,array('SumFieldTask'));
            if ($adb->num_rows($result1) == 0) {
                // Add workflow task
                $taskType = array("name"=>"SumFieldTask", "label"=>"Sum Field Task", "classname"=>"SumFieldTask", "classpath"=>"modules/SumField/workflow/SumFieldTask.inc", "templatepath"=>"modules/SumField/taskforms/SumFieldTask.tpl", "modules"=>array('include' => array(), 'exclude'=>array()), "sourcemodule"=>'SumField');
                VTTaskType::registerTaskType($taskType);
            }
        }else{
            // Remove workflow task
            $adb->pquery('DELETE FROM com_vtiger_workflow_tasktypes WHERE tasktypename=? AND sourcemodule=? AND classname=?', array('SumFieldTask','SumField','SumFieldTask'));
        }

        $response->setEmitType(Vtiger_Response::$EMIT_JSON);
        $response->setResult(array('result'=>'success'));
        $response->emit();
    }

}