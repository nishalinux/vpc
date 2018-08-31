<?PHP
function RetrieveGridDetails($recordId, $table)
{
	global $log, $adb;
	//$adb->setDebug(true);
	$id=$recordId;
	$data = "SELECT * FROM ".$table." where acmprid=? ";
	$viewname_result = $adb->pquery($data, array($id));
	$griddata=array();
	while($row = $adb->fetch_array($viewname_result)){ 
		$griddata[]= $row;
	}
	return $griddata;
}
//ARPIC Persons
function RetrieveARPICDetails($recordId, $table)
{
	global $log, $adb;
	$id=$recordId;
	$data = "SELECT * FROM ".$table." where acmprid=? ";
	$viewname_result = $adb->pquery($data, array($id));
	$griddata=array();
	while($row = $adb->fetch_array($viewname_result)){ 
		 $recid = $row['contactid'];
		 $status = checkRecordStaus($recid);
		 if($status != 0){
			$recmodel = Vtiger_Record_Model::getInstanceById($recid, "Contacts");
			$row['contactname'] ="<a href='index.php?module=Accounts&view=Detail&record=".$recid."'>" .$recmodel->get('salutation').' '.$recmodel->get('firstname').' '.$recmodel->get('lastname'). "</a>";
			$row['arpicname'] = $recmodel->get('salutation').' '.$recmodel->get('firstname').' '.$recmodel->get('lastname');
		 }
		 $griddata[]= $row;
	}
	return $griddata;
}
//Persorns
function RetrievePersonGridDetails($recordId, $table)
{
	global $log, $adb;
	$id=$recordId;
	$data = "SELECT * FROM ".$table." where acmprid=? ";
	$viewname_result = $adb->pquery($data, array($id));
	$griddata=array();
	while($row = $adb->fetch_array($viewname_result)){ 
		 $recid = $row['contactid'];
		 $status = checkRecordStaus($recid);
		 if($status != 0){
			$recmodel = Vtiger_Record_Model::getInstanceById($recid, "Contacts");
			$row['contactname'] ="<a href='index.php?module=Accounts&view=Detail&record=".$recid."'>" .$recmodel->get('salutation').' '.$recmodel->get('firstname').' '.$recmodel->get('lastname'). "</a>";
			$row['personname'] = $recmodel->get('salutation').' '.$recmodel->get('firstname').' '.$recmodel->get('lastname');
		 }
		$griddata[]= $row;
	}
	return $griddata;
}
function checkRecordStaus($id){
	global $adb;
	return $adb->num_rows($adb->pquery("select * from vtiger_crmentity where crmid=? and deleted=0",array($id)));
}
function getGridInfo() {
		global $adb;
		$data = "SELECT * FROM vtigress_acmpr_settings ORDER BY vtigress_acmpr_settings.sequence ASC";
		$viewname_result = $adb->pquery($data, array());
		$griddata=array();
		while($row = $adb->fetch_array($viewname_result)){ 
			 $griddata[]= $row;
		}
		return $griddata;
}
function getActivitySubtancesInfo() {
		global $adb;
		
		$data = "SELECT * FROM vtigress_acmpr_activities_settings";
		$res = $adb->pquery($data, array());
		$info=array();
		//Possession
		$info['possession'] = $adb->query_result($res,0,'substances');
		$info['possession_purpose'] = $adb->query_result($res,0,'purpose');
		$info['possession_cannabis_other'] = $adb->query_result($res,0,'cannabis');
		//Production
		$info['production'] = $adb->query_result($res,1,'substances');
		$info['production_purpose'] = $adb->query_result($res,1,'purpose');
		$info['production_cannabis_other'] = $adb->query_result($res,1,'cannabis');
		//Sale or Provision
		$info['sale_provision'] = $adb->query_result($res,2,'substances');
		$info['sale_provision_purpose'] = $adb->query_result($res,2,'purpose');
		$info['sale_provision_cannabis_other'] = $adb->query_result($res,2,'cannabis');
		//Shipping Purpose
		$info['shipping'] = $adb->query_result($res,3,'substances');
		$info['shipping_purpose'] = $adb->query_result($res,3,'purpose');
		$info['shipping_cannabis_other'] = $adb->query_result($res,3,'cannabis');
		//Transpotion
		$info['transportation'] = $adb->query_result($res,4,'substances');
		$info['transportation_purpose'] = $adb->query_result($res,4,'purpose');
		$info['transportation_cannabis_other'] = $adb->query_result($res,4,'cannabis');
		//Delivery
		$info['delivery'] = $adb->query_result($res,5,'substances');
		$info['delivery_purpose'] = $adb->query_result($res,5,'purpose');
		$info['delivery_cannabis_other'] = $adb->query_result($res,5,'cannabis');
		//Destruction
		$info['destruction'] = $adb->query_result($res,6,'substances');
		$info['destruction_purpose'] = $adb->query_result($res,6,'purpose');
		$info['destruction_cannabis_other'] = $adb->query_result($res,6,'cannabis');
		return $info;
}
function RetrieveComboOtherDetails($recordId)
{
	global $log, $adb;
	$id=$recordId;
	$data = "SELECT * FROM combo_reasons where acmprid=? ";
	$viewname_result = $adb->pquery($data, array($id));
	$griddata=array();
	while($row = $adb->fetch_array($viewname_result)){ 
		$griddata[$row['fieldname']]= $row['reason'];
	}
	return $griddata;
}
?>