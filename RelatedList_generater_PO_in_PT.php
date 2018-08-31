<?php

	include_once('config.inc.php');
	include_once('vtlib/Vtiger/Module.php');
	$accountsmodule = vtiger_module::getinstance('ProjectTask');//parent module
	$moduleinstance = vtiger_module::getinstance('PurchaseOrder');//child module 
	$relationlabel = 'PurchaseOrder';
	$accountsmodule->setrelatedlist($moduleinstance, $relationlabel, array('add','select'));
	
	// else 
	
?>