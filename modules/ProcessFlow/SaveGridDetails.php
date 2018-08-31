<?PHP
function saveGridDetails(&$focus, $module,$gridnumber='')
{
	global $log, $adb;
	$id=$focus->id;
	//$adb->setDebug(true);
	$log->debug("Entering into function saveGridDetails($gridnumber).");
	$gridblocks = array('grid1','grid2','grid3','grid4');
	$griddetails = array();
	foreach ($_REQUEST as $key => $value) {
		foreach($gridblocks as $gtype){
			$gridkey = $gtype.'productid';
			if (strpos($key, $gridkey) === 0) { 
				$griddetails[$gtype][] = $key;
			}
		 
			$asset_gridkey = $gtype.'assetsid';
			if (strpos($key, $asset_gridkey) === 0) { 
				$asset_griddetails[$gtype][] = $key;
			}

		}
	} 
	
	foreach($asset_griddetails as $gridblock=>$gridfields){  	
		$adb->pquery("DELETE FROM vtiger_processflow_grids WHERE processflowid=? and gridtype=?",array($focus->id,$gridblock));	
		for($i=1; $i<count($gridfields); $i++)
		{
			$gridkey = $gridblock.'assetsid'; 
			$xid = split($gridkey,$gridfields[$i]);
			$id = $xid[1];
			$proid=$gridkey.$id;
			$productid = $_REQUEST[$proid];
	
			$batid=$gridblock.'assetcategory'.$id;
			$productcategoryid = $_REQUEST[$batid];
			
			$prasentqty = '';
			//$preqty=$gridblock.'prasentqty'.$id;
			//$prasentqty = $_REQUEST[$preqty];
			
			$issueqty=$gridblock.'issuedqty'.$id;
			$issuedqty = $_REQUEST[$issueqty];
			
			$whomby=$gridblock.'issuedby'.$id;
			$issuedby = $_REQUEST[$whomby];
			
			$comments=$gridblock.'remarks'.$id;
			$remarks = $_REQUEST[$comments];
			
			$query ="INSERT INTO vtiger_processflow_grids(processflowid,productid, productcategory, prasentqty, issuedqty, issuedby, remarks, sequence, gridtype) VALUES (?,?,?,?,?,?,?,?,?)";
			$qparams = array($focus->id,$productid,$productcategoryid,$prasentqty,$issuedqty,$issuedby,$remarks,$i,$gridblock);
			$adb->pquery($query,$qparams);
		}
	}
	foreach($griddetails as $gridblock=>$gridfields){  	
		$adb->pquery("DELETE FROM vtiger_processflow_grids WHERE processflowid=? and gridtype=?",array($focus->id,$gridblock));	
		for($i=1; $i<count($gridfields); $i++)
		{
			$gridkey = $gridblock.'productid';
			$xid = split($gridkey,$gridfields[$i]);
			$id = $xid[1];
			$proid=$gridkey.$id;
			$productid = $_REQUEST[$proid];
	
			$batid=$gridblock.'productcategory'.$id;
			$productcategoryid = $_REQUEST[$batid];
			
			$preqty=$gridblock.'prasentqty'.$id;
			$prasentqty = $_REQUEST[$preqty];
			
			$issueqty=$gridblock.'issuedqty'.$id;
			$issuedqty = $_REQUEST[$issueqty];
			
			$whomby=$gridblock.'issuedby'.$id;
			$issuedby = $_REQUEST[$whomby];
			
			$comments=$gridblock.'remarks'.$id;
			$remarks = $_REQUEST[$comments];
			
			$query ="INSERT INTO vtiger_processflow_grids(processflowid,productid, productcategory, prasentqty, issuedqty, issuedby, remarks, sequence, gridtype) VALUES (?,?,?,?,?,?,?,?,?)";
			$qparams = array($focus->id,$productid,$productcategoryid,$prasentqty,$issuedqty,$issuedby,$remarks,$i,$gridblock);
			$adb->pquery($query,$qparams);
		}
	}
	 
	$log->debug("Exit from function saveGridDetails($gridnumber).");
}
?>