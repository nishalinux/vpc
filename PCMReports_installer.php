<?php
include_once 'vtlib/Vtiger/Module.php';
$Vtiger_Utils_Log = true;
$MODULENAME = 'PCMReports';
$moduleInstance = Vtiger_Module::getInstance($MODULENAME);
if ($moduleInstance || file_exists('modules/'.$MODULENAME)) {
        echo "Module already present - choose a different name.";
} else {
        $moduleInstance = new Vtiger_Module();
        $moduleInstance->name = $MODULENAME;
        $moduleInstance->parent= 'Analytics';
        $moduleInstance->save();        
        // Sharing Access Setup
        $moduleInstance->setDefaultSharing();

        // Webservice Setup
        $moduleInstance->initWebservice();

        mkdir('modules/'.$MODULENAME,0777);
        echo "OK\n";
}
