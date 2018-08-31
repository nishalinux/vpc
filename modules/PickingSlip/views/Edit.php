<?php
Class PickingSlip_Edit_View extends Inventory_Edit_View {
	public function checkPermission(Vtiger_Request $request) {
		$record = $request->get('record');
		$dup = $request->get('isDuplicate');
		if($dup == 'true'){
			return '';
		}
		else if($record != ''){
			throw new AppException(vtranslate('LBL_PERMISSION_DENIED', $request->getModule()));
		}else{
			return '';
		}
	}

	public function process(Vtiger_Request $request) {
		$qty = $this->getProjectArchievedDetails();
		$viewer = $this->getViewer($request);
		$viewer->assign('LOCKUNLOCKQTY', $qty);
		
		$record = $request->get('record');
		if($request->get('projectid') != ''){
			$projectid = $request->get('projectid');
			$productdetails = $this->getProductDetails($projectid);
			$viewer->assign('PROJECTPRODUCTDETAILS', $productdetails);
		}
		if($record != ''){
			$recordModel = $this->record?$this->record:Vtiger_Record_Model::getInstanceById($record, "PickingSlip");
			$projectid = $recordModel->get('projectid');
			$productdetails = $this->getProductDetails($projectid);
			$viewer->assign('PROJECTPRODUCTDETAILS', $productdetails);
		}
		parent::process($request);
	}
	public function getProductDetails($projectid){
		global $adb;
		$sql2 = $adb->pquery("SELECT name,productnumber,sum(qty) as qty, sum(used_qty) as used_qty FROM vtiger_projectsproduct_details where projectid= ? group by productnumber ",array($projectid));
			$frows = $adb->num_rows($sql2);
			if($frows != 0){
				$unlock = array();
				for($i=0;$i<$frows;$i++){
					$productnumber = $adb->query_result($sql2,$i,'productnumber');
					$qty =  $adb->query_result($sql2,$i,'qty');
					$usedqty =  $adb->query_result($sql2,$i,'used_qty');
					
					$remainingqty = $qty - $usedqty;
					$unlock[$productnumber] = $remainingqty;
					
				}
			}
			return $unlock;
	}
	public function getProjectArchievedDetails(){
		global $adb;
		//Retrieving all purchase orders where project status archived
		$query = $adb->pquery("SELECT crmid  FROM vtiger_project LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_project.projectid WHERE vtiger_crmentity.deleted = 0 and projectstatus ='archived'",array());
		$rows = $adb->num_rows($query);
		if($rows != 0){
			$poid = array();
			for($i=0;$i<$rows;$i++){
				$poid[] = $adb->query_result($query,$i,'crmid');
			}
		}
		//Retrieving remaining quantity
		if(count($poid) != 0){
			$sql2 = $adb->pquery("SELECT name,sum(qty) as qty, sum(used_qty) as used_qty FROM vtiger_projectsproduct_details where projectid in (" . generateQuestionMarks($poid) . ")  group by name ",array($poid));
			$frows = $adb->num_rows($sql2);
			if($frows != 0){
				$unlock = array();
				for($i=0;$i<$frows;$i++){
					$name = $adb->query_result($sql2,$i,'name');
					$qty =  $adb->query_result($sql2,$i,'qty');
					$usedqty =  $adb->query_result($sql2,$i,'used_qty');
					
					$remainingqty = $qty - $usedqty;
					$unlock[$name] = $remainingqty;
					
				}
			}
		}
		//Projects inprogress 
		$inp = $adb->pquery("SELECT crmid  FROM vtiger_project LEFT JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_project.projectid WHERE vtiger_crmentity.deleted = 0 and projectstatus in ('initiated','in progress')",array());
		$inprows = $adb->num_rows($inp);
		if($inprows != 0){
			$proid = array();
			for($k=0;$k<$inprows;$k++){
				$proid[] = $adb->query_result($inp,$k,'crmid');
			}
		}
		if(count($proid) != 0){
			$progess = $adb->pquery("SELECT name,sum(qty) as qty FROM vtiger_projectsproduct_details where projectid in (" . generateQuestionMarks($proid) . ")  group by name ",array($proid));
			$progessrows = $adb->num_rows($progess);
			if($progessrows != 0){
				$lock = array();
				for($l=0;$l<$progessrows;$l++){
					$lname = $adb->query_result($progess,$l,'name');
					$lqty =  $adb->query_result($progess,$l,'qty');
					$lock[$lname] = $lqty;
					
				}
			}
		}


$QTY['Lock'] = $lock;
$QTY['Unlock'] = $unlock;
return $QTY;
	}
}