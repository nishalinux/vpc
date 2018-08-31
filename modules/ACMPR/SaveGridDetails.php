<?PHP
function saveAcmprGridDetails(&$focus, $module)
{
	global $log, $adb;
	$id=$focus->id;
	$log->debug("Entering into function saveAcmprGridDetails($module).");
	//Added to get the convertid
	if(isset($_REQUEST['duplicate_from']) && $_REQUEST['duplicate_from'] !='')
	{
		$id=vtlib_purify($_REQUEST['duplicate_from']); 
	}
	$ext_prod_arr = Array();
	if($focus->mode == 'edit')
	{
		$adb->pquery("DELETE FROM vtigress_acmpr_griddetails WHERE acmprid=?",array($id));		
	}
	$tot_no_prod = array();
	foreach ($_REQUEST as $key => $value) {
		if (strpos($key, 'accountname') === 0) {
			$tot_no_prod[] = $key;
		}
	}
	for($i=1; $i<count($tot_no_prod); $i++)
	{
		$xid = split('accountname',$tot_no_prod[$i]);
		$id = $xid[1];
		$accountname = $_REQUEST['accountname'.$id];
		$activities = $_REQUEST['activities'.$id];
		$substance = $_REQUEST['substance'.$id];
		$query ="INSERT INTO vtigress_acmpr_griddetails(acmprid, accountname, activities, substance) values(?,?,?,?)";
		$qparams = array($focus->id,$accountname,$activities,$substance);
		$adb->pquery($query,$qparams);
	}
	$log->debug("Exit from function saveAcmprGridDetails($module).");
}
function saveARPICGridDetails(&$focus, $module)
{
	global $log, $adb;
	$id=$focus->id;
	$log->debug("Entering into function saveARPICGridDetails($module).");
	if(isset($_REQUEST['duplicate_from']) && $_REQUEST['duplicate_from'] !='')
	{
		$id=vtlib_purify($_REQUEST['duplicate_from']); 
	}
	$ext_prod_arr = Array();
	if($focus->mode == 'edit')
	{
		$adb->pquery("DELETE FROM vtigress_arpic_griddetails WHERE acmprid=?",array($id));		
	}
	$tot_no_prod = array();
	foreach ($_REQUEST as $key => $value) {
		if (strpos($key, 'arpicid') === 0) {
			$tot_no_prod[] = $key;
		}
	}
	for($i=1; $i<count($tot_no_prod); $i++)
	{
		$xid = split('arpicid',$tot_no_prod[$i]);
		$id = $xid[1];
		$arpicid = $_REQUEST['arpicid'.$id];
		$surname = $_REQUEST['surname'.$id];
		$givenname = $_REQUEST['givenname'.$id];
		$gender = $_REQUEST['gender'.$id];
		
		$dateofbirth = $_REQUEST['dateofbirth'.$id];
		$ranking = $_REQUEST['ranking'.$id];
		$whdays = $_REQUEST['whdays'.$id];
		$othertitle = $_REQUEST['othertitle'.$id];
		
		$query ="INSERT INTO vtigress_arpic_griddetails(acmprid, contactid, surname, givenname, gender, dateofbirth, ranking, whdays, othertitle) VALUES (?,?,?,?,?,?,?,?,?)";
		$qparams = array($focus->id,$arpicid,$surname,$givenname,$gender,$dateofbirth,$ranking,$whdays,$othertitle);
		$adb->pquery($query,$qparams);
	}
	$log->debug("Exit from function saveAPRICGridDetails($module).");
}
function savePersonGridDetails(&$focus, $module)
{
	global $log, $adb;
	$id=$focus->id;
	$log->debug("Entering into function savePersonGridDetails($module).");
	if(isset($_REQUEST['duplicate_from']) && $_REQUEST['duplicate_from'] !='')
	{
		$id=vtlib_purify($_REQUEST['duplicate_from']); 
	}
	$ext_prod_arr = Array();
	if($focus->mode == 'edit')
	{
		$adb->pquery("DELETE FROM vtigress_person_griddetails WHERE acmprid=?",array($id));		
	}
	$tot_no_prod = array();
	foreach ($_REQUEST as $key => $value) {
		if (strpos($key, 'personid') === 0) {
			$tot_no_prod[] = $key;
		}
	}
	for($i=1; $i<count($tot_no_prod); $i++)
	{
		$xid = split('personid',$tot_no_prod[$i]);
		$id = $xid[1];
		$personid = $_REQUEST['personid'.$id];
		$surname = $_REQUEST['surname'.$id];
		$givenname = $_REQUEST['givenname'.$id];
		$gender = $_REQUEST['gender'.$id];
		
		$query ="INSERT INTO vtigress_person_griddetails(acmprid, contactid, surname, givenname, gender) VALUES (?,?,?,?,?)";
		$qparams = array($focus->id,$personid,$surname,$givenname,$gender);
		$adb->pquery($query,$qparams);
	}
	$log->debug("Exit from function savePersonGridDetails($module).");
}
function saveComboOther(&$focus){
	global $log, $adb;
	$id=$focus->id;
	$log->debug("Entering into function saveComboOther($module).");
	$combos = array();
	$i=0;
	foreach($_REQUEST as $key => $value) {
		if (strpos($key, 'Combo_otherreason_') === 0) {
			$keyarr =explode("Combo_otherreason_",$key);
			$combos[$i]['key'] = $keyarr[1];
			$combos[$i]['value'] = $_REQUEST[$key];
			$i++;
		}
	}
	$adb->pquery("DELETE FROM combo_reasons WHERE acmprid=?",array($id));
	for($k=0;$k<count($combos);$k++){
		$insarr = array($id,$combos[$k]['key'],$combos[$k]['value']);
		$adb->pquery("INSERT INTO combo_reasons(acmprid, fieldname, reason) VALUES (?,?,?)",$insarr);
	}
}
?>