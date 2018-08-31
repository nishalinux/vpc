<?php
function getPrdstatusQtyInStck($product_id)
{
	global $log;
	$log->debug("Entering getPrdstatusQtyInStck(".$product_id.") method ...");
	global $adb;
	$query1 = "SELECT qtyinstock FROM vtiger_products WHERE productid = ?";
	$result=$adb->pquery($query1, array($product_id));
	$qtyinstck= $adb->query_result($result,0,"qtyinstock");
	$log->debug("Exiting getPrdstatusQtyInStck method ...");
	return $qtyinstck;
}
function updateProductstatusQty($product_id, $upd_qty)
{
	global $log;
	$log->debug("Entering updateProductstatusQty(".$product_id.",". $upd_qty.") method ...");
	global $adb;
	$query= "update vtiger_products set qtyinstock=? where productid=?";
    $adb->pquery($query, array($upd_qty, $product_id));
	$log->debug("Exiting updateProductQty method ...");

}
function updateQtyProductRelLock($entity) {
	global $log, $adb;
	$entity_id = vtws_getIdComponents($entity->getId());
	$entity_id = $entity_id[1];
	$projectids = vtws_getIdComponents($entity->get('projectid'));
	$projectid = $projectids[1];
	$log->debug("Entering into function updateInventoryProductRel(".$entity_id.").");
	$moduleName = $entity->getModuleName();
	$statusChanged = false;
	$vtEntityDelta = new VTEntityDelta ();
	$statusFieldName = 'stockstatus';
	$updateInventoryProductRel_deduct_stock = true;
	$oldEntity = $vtEntityDelta->getOldValue($moduleName, $entity_id, $statusFieldName);
	$recordDetails = $entity->getData();
	$newstatus  = $entity->get('stockstatus');
	$statusFieldValue = "Approved";
	$statusChanged = $vtEntityDelta->hasChanged($moduleName, $entity_id, $statusFieldName);
	$updateInventoryProductRel_deduct_stock = false;
	if($statusChanged) {
		if($recordDetails[$statusFieldName] == $statusFieldValue) {
			$updateInventoryProductRel_deduct_stock = true;
			$deduct = "+";
		} elseif($oldEntity == $statusFieldValue) {
			$updateInventoryProductRel_deduct_stock = true;
			$deduct = "-";
		}
	}

	if($updateInventoryProductRel_deduct_stock) {
		$product_info = $adb->pquery("SELECT productid,sequence_no, quantity from vtiger_inventoryproductrel WHERE id=?",array($entity_id));
		$numrows = $adb->num_rows($product_info);
		for($index = 0;$index <$numrows;$index++) {
			$productid = $adb->query_result($product_info,$index,'productid');
			$qty = $adb->query_result($product_info,$index,'quantity');
			$sequence_no = $adb->query_result($product_info,$index,'sequence_no');
			$qtyinstk= getPrdstatusQtyInStck($productid);
			if($deduct = '+' && $newstatus == 'Approved'){
				$upd_qty = $qtyinstk-$qty;
				getProjectStockQtyUpdate($entity_id,$projectid);//To Add Products in Projects
			} elseif($oldEntity == $statusFieldValue) {
				$upd_qty = $qtyinstk+$qty;
			}
			updateProductstatusQty($productid, $upd_qty);
		}
		$log->debug("Exit from function updateInventoryProductRel(".$entity_id.")");
	}
}
 function getProjectStockQtyUpdate($projectstockid,$parentId){
	$productnames = array();
	global $adb;
	//$adb->setDebug(true);
	$proquery = $adb->pquery("SELECT vtiger_inventoryproductrel.productid,product_no,productname,SUM( quantity ) as quantity FROM vtiger_inventoryproductrel ,vtiger_products,vtiger_crmentity WHERE vtiger_products.productid = vtiger_inventoryproductrel.productid and vtiger_crmentity.crmid = vtiger_products.productid and deleted=0 and id in (?)  group by product_no " ,array($projectstockid));
	$prorows = $adb->num_rows($proquery);
		if($prorows != 0){
			$productnames = array();
			for($i=0;$i<$rows;$i++){
				$productnames[$i]['productnum'] = $adb->query_result($proquery,$i,'product_no');
				$productnames[$i]['productname'] = $adb->query_result($proquery,$i,'productname');
				$productnames[$i]['quantity'] = $adb->query_result($proquery,$i,'quantity');
			}
		}
	print_r($productnames);
	$sql1= $adb->fetch_row($adb->pquery("select count(*) as count from vtiger_projectsproduct_details where projectid=?",array($parentId)),0,'count');
		
		if($sql1['count'] == 0){
			for($j=0;$j<count($productnames);$j++){
				$details = array();
				$details[] = $parentId;
				$details[] = $productnames[$j]['productname'];
				$details[] = $productnames[$j]['quantity'];
				$details[] = $productnames[$j]['productnum'];
				$adb->pquery("INSERT INTO vtiger_projectsproduct_details( projectid, name, qty,productnumber) VALUES (?,?,?,?)",$details);	
			}
		}else{
			for($j=0;$j<count($productnames);$j++){
				$details = array();
				$qty =  $productnames[$j]['quantity'];
				$details[] = $qty;
				$details[] = $parentId;
				$name = $productnames[$j]['productname'];
				$productnumber = $productnames[$j]['productnum'];
				$details[] = $productnumber;
				
				 $sql3= $adb->fetch_row($adb->pquery("select count(*) as count from vtiger_projectsproduct_details where projectid=? and productnumber=?",array($parentId,$productnumber)),0,'count');
				if($sql3['count'] == 0){
					$adb->pquery("INSERT INTO vtiger_projectsproduct_details( projectid, name, qty,productnumber) VALUES (?,?,?,?)",array($parentId,$name,$qty,$productnumber));	
				}else{
					$adb->pquery("UPDATE vtiger_projectsproduct_details SET qty=? where projectid=? and productnumber=?",$details);
				}
			}
			
		}
}
?>