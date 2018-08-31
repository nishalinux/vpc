<?php 

class ProcessFlow_AjaxValidations_Action extends Vtiger_Action_Controller{
	public function checkPermission(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$recordId = $request->get('record');
	}
	public function process(Vtiger_Request $request) {
		
		global $db;
		$db = PearDatabase::getInstance();
		#$db->setDebug(true);
		$mode = $request->get('mode'); 
		$response = new Vtiger_Response();
		 

	switch ($mode) {  

		case 'check_inventory':	 
			
			$productid = $request->get('productid');
            $product_quantity = $request->get('product_quantity');

            $q ="SELECT * FROM vtiger_products where productid = ?";
            $result = $db->pquery($q,array($productid));
            $result = $db->fetch_array($result);            
            $qtyinstock = (int)$result['qtyinstock'];
            $pname = $result['productname'];

            if($qtyinstock >= $product_quantity ){
                $responseData = array("message"=>"Task Assigned Successfully.", 'success'=>true,'status'=>true);
            }else{
                $responseData = array("message"=>"$product_quantity items of <b>$pname</b> is Not Available, please update stock and try again.", 'success'=>true,'status'=>false);
            } 
		break; 

		case 'getProductsCategorysList':
				$processid = $request->get('processid');				 
				$q ="SELECT materials,vessels,tools,machinery FROM vtiger_processmaster where processmasterid=?";
				$result = $db->pquery($q,array($processid));
				$result = $db->fetch_array($result);            
				 
				$materials = json_decode(stripslashes(html_entity_decode($result['materials'])), true);
				$materials = $this->getMaterialsInDetails($materials);
				$vessels = $this->getAssectDetailsUsingIds(trim($result['vessels'])); 
				$tools = $this->getAssectDetailsUsingIds(trim($result['tools'])); 
				$machinery = $this->getAssectDetailsUsingIds(trim($result['machinery'])); 
				$responseData = array('success'=>true,'status'=>true,'materials'=>$materials,'vessels'=>$vessels,'tools'=>$tools,'machinery'=>$machinery);
				 
			break;
		default:	

		} 
		$response->setResult($responseData);
		$response->emit();
	}	
	public function getMaterialsInDetails($materials){
		global $adb;
		if(count($materials) > 0){
			$a = array();$i=0;
			foreach($materials as $material){
				$product_id = $material['materialid'];
				$a[$i]['qty'] = $material['qty'];
				$q = "SELECT * FROM vtiger_products where productid= ? ";
				$query = $adb->pquery($q,array($product_id));
				$pdata = $adb->fetch_array($query);
				$a[$i]['productid'] = $pdata['productid'];
				$a[$i]['productname'] = $pdata['productname'];
				$a[$i]['productcategory'] = $pdata['productcategory'];
				$a[$i]['qtyinstock'] = $pdata['qtyinstock'];
				$i++;
			}
			return $a;
		}
		return array();
	}

	public function getAssectDetailsUsingIds($assetIds){
		global $adb;
		if($assetIds != ''){			
			$assetIds = explode(',',$assetIds);
			$assetIds = implode(',',$assetIds);
			$q = "SELECT a.assetsid,a.assetname,ac.cf_829 FROM vtiger_assets a left join vtiger_assetscf ac on a.assetsid = ac.assetsid where a.assetsid in ($assetIds) ";
			$query = $adb->pquery($q,array());
			$finalarray = array();$i=0;
			while($data = $adb->fetch_array($query)){
				$finalarray[$i] = $data;
				$i++;
			}
			return $finalarray;
		}
		return array();
	}
	 

	
}
