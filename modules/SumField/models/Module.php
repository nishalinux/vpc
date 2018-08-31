<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */

class SumField_Module_Model extends Vtiger_Module_Model {

    function getSettingLinks() {
        $settingsLinks[] = array(
            'linktype' => 'MODULESETTING',
            'linklabel' => 'Settings',
            'linkurl' => 'index.php?module=SumField&parent=Settings&view=Settings',
            'linkicon' => ''
        );
        $settingsLinks[] = array(
            'linktype' => 'MODULESETTING',
            'linklabel' => 'License & Upgrade',
            'linkurl' => 'index.php?module=SumField&parent=Settings&view=Upgrade',
            'linkicon' => ''
        );
        $settingsLinks[] = array(
            'linktype' => 'MODULESETTING',
            'linklabel' => 'Uninstall',
            'linkurl' => 'index.php?module=SumField&parent=Settings&view=Uninstall',
            'linkicon' => ''
        );
        return $settingsLinks;
    }
}