<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */
ini_set('display_errors','0');
class SumField_Settings_View extends Settings_Vtiger_Index_View {

    function __construct() {
        parent::__construct();
    }

    public function preProcess(Vtiger_Request $request) {
        parent::preProcess($request);
        // Check module valid
        $adb = PearDatabase::getInstance();
        $module = $request->getModule();
        $viewer = $this->getViewer($request);
        $viewer->assign('QUALIFIED_MODULE', $module);
        $rs=$adb->pquery("SELECT * FROM `vte_modules` WHERE module=? AND valid='1';",array($module));
        if($adb->num_rows($rs)==0) {
            $viewer->view('InstallerHeader.tpl', $module);
        }
    }

    public function process(Vtiger_Request $request) {
        $module = $request->getModule();
        $adb = PearDatabase::getInstance();
        $vTELicense=new SumField_VTELicense_Model($module);
         if(!$vTELicense->validate()){
              $this->step2($request, $vTELicense);
          }else
        {
            $rs=$adb->pquery("SELECT * FROM `vte_modules` WHERE module=? AND valid='1';",array($module));
            if($adb->num_rows($rs)==0) {
                $this->step3($request);
            }else{
                $mode = $request->getMode();
                if ($mode) {
                    $this->$mode($request);
                } else {
                    $this->renderSettingsUI($request);
                }
            }
        }
    }

    function step2(Vtiger_Request $request, $vTELicense) {
        global $site_URL;
        $module = $request->getModule();
        $viewer = $this->getViewer($request);

        $viewer->assign('VTELICENSE', $vTELicense);
        $viewer->assign('SITE_URL', $site_URL);
        $viewer->view('Step2.tpl', $module);
    }

    function step3(Vtiger_Request $request) {
        $module = $request->getModule();
        $viewer = $this->getViewer($request);
        $viewer->view('Step3.tpl', $module);
    }

    function renderSettingsUI(Vtiger_Request $request) {
        $adb = PearDatabase::getInstance();
        $module = $request->getModule();
        $viewer = $this->getViewer($request);

        /*   $sum_module='Invoice';
           $total_sum_module='Contacts';
           $sumModuleModel = Vtiger_Module_Model::getInstance($sum_module);
           $totalsumModuleModel = Vtiger_Module_Model::getInstance($total_sum_module);

           $viewer->assign('QUALIFIED_MODULE',$module);
           $viewer->assign('SUM_MODULE_NAME',$sum_module);
           $viewer->assign('SUM_MODULE_MODEL',$sumModuleModel);
           $viewer->assign('TOTALSUM_MODULE_NAME',$total_sum_module);
           $viewer->assign('TOTALSUM_MODULE_MODEL',$totalsumModuleModel);
           $viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());*/
        $rs=$adb->pquery("SELECT `enable` FROM `sumfield_settings`;",array());
        $enable=$adb->query_result($rs,0,'enable');
        $viewer->assign('ENABLE', $enable);
        echo $viewer->view('Settings.tpl',$module,true);
    }

    /**
     * Function to get the list of Script models to be included
     * @param Vtiger_Request $request
     * @return <Array> - List of Vtiger_JsScript_Model instances
     */
    function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);
        $moduleName = $request->getModule();

        $jsFileNames = array(
            "modules.$moduleName.resources.Settings",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}