<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update(Workflow) ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */

class SumField_Upgrade_View extends Settings_Vtiger_Index_View {
    function __construct() {
        parent::__construct();
        $this->vteLicense();
    }

    function vteLicense() {
        $vTELicense=new SumField_VTELicense_Model('SumField');
        if(!$vTELicense->validate()){
            header("Location: index.php?module=SumField&parent=Settings&view=Settings&mode=step2");
        }
    }
    public function process(Vtiger_Request $request) {
        global $site_URL;
        $adb = PearDatabase::getInstance();
        $module = $request->getModule();
        $viewer = $this->getViewer($request);
        $vTELicense=new SumField_VTELicense_Model($module);
        $licenseInfo=$vTELicense->getLicenseInfo();
        $licenseInfo['site_url']=$site_URL;

        // Check license expires
        if($licenseInfo['expiration_date'] !='' && $licenseInfo['expiration_date'] !='0000-00-00') {
            if(strtotime('-30 days') < strtotime($licenseInfo['expiration_date'])) {
                $licenseExpires=vtranslate('LBL_EXPIRED_ON',$module)." ".date('m-d-Y',strtotime(date("Y-m-d", strtotime($licenseInfo['date_created'])).'+30 days'));
            }else{
                $licenseExpires=vtranslate('LBL_EXPIRES_ON',$module)." ".date('m-d-Y',strtotime(date("Y-m-d", strtotime($licenseInfo['date_created'])).'+30 days'));
            }
        }

        if($licenseInfo['date_created'] !='') {
            // Check support expires
            if (strtotime('-1 year') < strtotime($licenseInfo['date_created'])) {
                $isSupport = true;
                $supportExpires = vtranslate('LBL_EXPIRED_ON', $module) . " " . date('m-d-Y', strtotime(date("Y-m-d", strtotime($licenseInfo['date_created'])) . '+1 year'));
            } else {
                $isSupport = false;
                $supportExpires = vtranslate('LBL_EXPIRES_ON', $module) . " " . date('m-d-Y', strtotime(date("Y-m-d", strtotime($licenseInfo['date_created'])) . '+1 year'));
            }
        }
        $viewer->assign('LICENSE_INFO', $licenseInfo);
        $viewer->assign('IS_SUPPORT', $isSupport);
        $viewer->assign('LICENSE_EXPIRES', $licenseExpires);
        $viewer->assign('SUPPORT_EXPIRES', $supportExpires);
        $viewer->assign('QUALIFIED_MODULE', $module);
        echo $viewer->view('Upgrade.tpl',$module,true);
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
            "modules.$moduleName.resources.Upgrade",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }
}