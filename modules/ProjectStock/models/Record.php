<?php
class ProjectStock_Record_Model extends Inventory_Record_Model {
    public function getPDF() {
		$recordId = $this->getId();
		$moduleName = $this->getModuleName();

		$controllerClassName = "Vtiger_". $moduleName ."PDFController";

		$controller = new $controllerClassName($moduleName);
		$controller->loadRecord($recordId);

        $fileName = $this->getModuleSequenceNumber($recordId);
		$controller->Output($fileName.'.pdf', 'D');
	}
    
    function getModuleSequenceNumber($recordId) {
        $adb = PearDatabase::getInstance();
        $res = $adb->pquery("SELECT projectstock_no FROM vtiger_projectstock WHERE projectstockid=?", array($recordId));
        $moduleSeqNo = $adb->query_result($res, 0, 'projectstock_no');
		return $moduleSeqNo;
	}
}