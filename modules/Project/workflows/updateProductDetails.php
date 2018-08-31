<?php
function updateProductDetails($entity){
	global $adb;
	$projectid = vtws_getIdComponents($entity->get('projectid'));
 	$projectid = $projectid[1];
	$entity_id = vtws_getIdComponents($entity->getId());
 	$entity_id = $entity_id[1];
	$product_info = $adb->pquery("SELECT * from vtiger_projectsproduct_details WHERE projectid=?",array($entity_id));
		$numrows = $adb->num_rows($product_info);
		$existingstock = 0;
		for($index = 0;$index <$numrows;$index++) {
			$productnumber = $adb->query_result($product_info,$index,'productnumber');
			$qty = $adb->query_result($product_info,$index,'qty');
			$used_qty = $adb->query_result($product_info,$index,'used_qty');
			$upd_qty = $qty-$used_qty;
			$existingstock = $adb->query_result($adb->pquery("select qtyinstock from vtiger_products  where product_no=?",array($productnumber)),0,'qtyinstock');
			$existingstock = $existingstock+$upd_qty;
			$adb->pquery("UPDATE vtiger_products SET qtyinstock=? where product_no=?",array($existingstock,$productnumber));
			//Remaining qty update purpose
			$adb->pquery("update vtiger_projectsproduct_details set used_qty=? where productnumber=?",array($qty,$productnumber));
		}
}
?>