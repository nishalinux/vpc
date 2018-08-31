<?php

/**
 * VGS Gantt Charts Module
 *
 *
 * @package        VGS Gantt Charts Module
 * @author         Conrado Maggi
 * @license        Commercial
 * @copyright      2014 VGS Global - www.vgsglobal.com
 * @version        Release: 1.0
 */

include_once 'modules/VGSGanttCharts/models/VGSLicenseManager.php';

class VGSGanttCharts_List_View extends Vtiger_Index_View
{
    
    public function process(Vtiger_Request $request) {
        
        if (!aW8bgzsTs3Xp($request->getModule())) {
            
            header('Location: index.php?module=' . $request->getModule() . '&view=VGSLicenseSettings&parent=Settings');
        } 
        else {
            $viewer = $this->getViewer($request);
            $viewer->view('List.tpl', $request->getModule());
        }
    }
}
