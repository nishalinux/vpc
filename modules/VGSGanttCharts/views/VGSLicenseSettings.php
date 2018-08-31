<?php


include_once 'modules/VGSGanttCharts/models/VGSLicenseManager.php';

class VGSGanttCharts_VGSLicenseSettings_View extends Settings_Vtiger_Index_View {

    public function process(Vtiger_Request $request) {

        $viewer = $this->getViewer($request);
        $viewer->assign('LICENSEID', aWPbgzsTs3Yp($request->getModule()));
        $viewer->assign('IS_VALIDATED', aW8bgzsTs3Xp($request->getModule()));
        $viewer->assign('MODULE', $request->getModule());
        $viewer->view('VGSActivateLicense.tpl', $request->getModule());
    }

    function getPageTitle(Vtiger_Request $request) {
        return vtranslate('LBL_MODULE_NAME', $request->getModule());
    }

    /**
     * Function to get the list of Script models to be included
     * @param Vtiger_Request $request
     * @return <Array> - List of Vtiger_JsScript_Model instances
     */
    function getHeaderScripts(Vtiger_Request $request) {
        $headerScriptInstances = parent::getHeaderScripts($request);

        $jsFileNames = array(
            "layouts.vlayout.modules.VGSGanttCharts.resources.VGSLicense",
        );

        $jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
        $headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
        return $headerScriptInstances;
    }

}
