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
include_once 'modules/Vtiger/CRMEntity.php';
include_once 'include/utils/utils.php';

class VGSGanttCharts extends Vtiger_CRMEntity {

    /**
     * Invoked when special actions are performed on the module.
     * @param String Module name
     * @param String Event Type
     */
    function vtlib_handler($moduleName, $eventType) {
        global $adb;
        if ($eventType == 'module.postinstall') {
            // TODO Handle actions after this module is installed.
            require_once('vtlib/Vtiger/Link.php');

            $tabid = getTabId("VGSGanttCharts");
            $ProjectTabid = getTabId("Project");
            $ProjectTaskTabid = getTabId("ProjectTask");

            Vtiger_Link::addLink($tabid, 'HEADERSCRIPT', 'VGSGanttCharts', 'layouts/vlayout/modules/VGSGanttCharts/resources/VGSGanttCharts.js', '', 0, '');
            Vtiger_Link::addLink($ProjectTaskTabid, 'LISTVIEWBASIC', 'View Gantt', "javascript:ViewGanttChart('ProjectTask')", '', 0, '');
            Vtiger_Link::addLink($ProjectTabid, 'LISTVIEWBASIC', 'View Gantt', "javascript:ViewGanttChart('Project')", '', 0, '');
            Vtiger_Link::addLink($ProjectTabid, 'DETAILVIEWBASIC', 'View Gantt', 'javascript:ViewGanttChart($RECORD$)', '', 0, '');
            
        } else if ($eventType == 'module.disabled') {
            // TODO Handle actions before this module is being uninstalled.
        } else if ($eventType == 'module.preuninstall') {
            // TODO Handle actions when this module is about to be deleted.
            require_once('vtlib/Vtiger/Link.php');
            $tabid = getTabId("VGSGanttCharts");
            Vtiger_Link::deleteAll($tabid);
            
        } else if ($eventType == 'module.preupdate') {
            require_once('vtlib/Vtiger/Link.php');
            $tabid = getTabId("VGSGanttCharts");
            Vtiger_Link::deleteAll($tabid);
            
        } else if ($eventType == 'module.postupdate') {
            require_once('vtlib/Vtiger/Link.php');

            $tabid = getTabId("VGSGanttCharts");
            $ProjectTabid = getTabId("Project");
            $ProjectTaskTabid = getTabId("ProjectTask");

            Vtiger_Link::addLink($tabid, 'HEADERSCRIPT', 'VGSGanttCharts', 'layouts/vlayout/modules/VGSGanttCharts/resources/VGSGanttCharts.js', '', 0, '');
            Vtiger_Link::addLink($ProjectTaskTabid, 'LISTVIEWBASIC', 'View Gantt', "javascript:ViewGanttChart('ProjectTask')", '', 0, '');
            Vtiger_Link::addLink($ProjectTabid, 'LISTVIEWBASIC', 'View Gantt', "javascript:ViewGanttChart('Project')", '', 0, '');
            Vtiger_Link::addLink($ProjectTabid, 'DETAILVIEWBASIC', 'View Gantt', 'javascript:ViewGanttChart($RECORD$)', '', 0, '');
        }
    }

}
