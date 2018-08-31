<?php
class PickingSlip_Record_Model extends Inventory_Record_Model {
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
        $res = $adb->pquery("SELECT pickingslip_no FROM vtiger_pickingslip WHERE pickingslipid=?", array($recordId));
        $moduleSeqNo = $adb->query_result($res, 0, 'pickingslip_no');
		return $moduleSeqNo;
	}
}