<?php
function updateProductDetails($entity){
	global $adb;	$adb->setDebug(true);
	$projectid = vtws_getIdComponents($entity->get('projectid'));
 	$projectid = $projectid[1];
	$entity_id = vtws_getIdComponents($entity->getId());
 	$entity_id = $entity_id[1];
	$product_info = $adb->pquery("SELECT productname,product_no , sum(quantity) as qty from vtiger_inventoryproductrel inner join vtiger_crmentity on vtiger_crmentity.crmid = vtiger_inventoryproductrel.id inner join vtiger_pickingslip on vtiger_pickingslip.pickingslipid = vtiger_crmentity.crmid inner join vtiger_products on vtiger_products.productid = vtiger_inventoryproductrel.productid  where deleted = 0 and projectid=?  group by product_no ",array($projectid));
	 $numrows = $adb->num_rows($product_info);
	for($index = 0;$index <$numrows;$index++){
		$productnumber = $adb->query_result($product_info,$index,'product_no');
		$qty = $adb->query_result($product_info,$index,'qty');
		$updatequery = $adb->pquery("UPDATE vtiger_projectsproduct_details set used_qty=? where projectid=? and productnumber=?",array($qty,$projectid,$productnumber));
	}
	/*$product_info = $adb->pquery("SELECT productid,sequence_no, quantity from vtiger_inventoryproductrel WHERE id=?",array($entity_id));
		$numrows = $adb->num_rows($product_info);
		for($index = 0;$index <$numrows;$index++) {
			$productid = $adb->query_result($product_info,$index,'productid');
			$qty = $adb->query_result($product_info,$index,'quantity');
			$sequence_no = $adb->query_result($product_info,$index,'sequence_no');
			$qtyinstk= getPrdstatusQtyInStck($productid);
			$upd_qty = $qtyinstk+$qty;
		}
	updateProductstatusQty($productid, $upd_qty);*/
}

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
?>