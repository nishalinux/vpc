<?PHP
function RetrieveGridDetails($recordId,$type='')
{
	global $log, $adb;
	$id=$recordId;
	//$adb->setDebug(true);
	//echo "<pre>";
	$data = "SELECT * FROM vtiger_processflow_grids where processflowid=? ";
	if($type != ''){
		$data .= " and gridtype='".$type."'";
	}
	$data .= " order by sequence";
	$viewname_result = $adb->pquery($data, array($id,$module));
	$griddata=array();
	while($row = $adb->fetch_array($viewname_result)){

		//echo '<pre>';print_r($row);echo '</pre>';
	$rowdata = array();		
	 $recid = $row['productid'];
	 $status = checkRecordStaus($recid);
	 if($status != 0){
		$recmodel = Vtiger_Record_Model::getInstanceById($recid,'Products');
		$row['productName'] = $recmodel->getName();
	 }
	 $productcategory = $row['productcategory'];
	 /*$batchstatus = checkRecordStaus($productcategory);
	 if($batchstatus != 0){
		$batchmodel = Vtiger_Record_Model::getInstanceById($productcategory, 'Products');
		$row['batchname'] = $batchmodel->getName();
	 }*/
	 $seq =$row['sequence'];
	 if($type == 'grid1'){
		$rowdata[$type.'productid'.$seq] = $row['productid'];
	 	$rowdata[$type.'productName'.$seq] = $row['productName'];
		$rowdata[$type.'productcategory'.$seq] = $row['productcategory'];
		$rowdata[$type.'prasentqty'.$seq] = $row['prasentqty'];
	 }else{
		$rowdata[$type.'assetsid'.$seq] = $row['productid'];
	 	$rowdata[$type.'assetName'.$seq] = $row['productName'];
		$rowdata[$type.'assetcategory'.$seq] = $row['productcategory'];
	 }
	 
	 $rowdata[$type.'issuedqty'.$seq] = $row['issuedqty'];	 
	 $rowdata[$type.'issuedby'.$seq] = $row['issuedby'];
	 $rowdata[$type.'remarks'.$seq] = $row['remarks'];
	 $griddata[]= $rowdata;
	}
	return $griddata;
}

function checkRecordStaus($id){
	global $adb;
	return $adb->num_rows($adb->pquery("select * from vtiger_crmentity where crmid=? and deleted=0",array($id)));
}
?>