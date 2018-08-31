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
		case 'getCustomFormInfo' :
            $processmasterid = $request->get("processmasterid");
			
			global $adb;
			$mcdata = "SELECT pu.customform FROM vtiger_processflow_unitprocess pu  WHERE pu.processmasterid=? order by pu.sequence";
			$mcviewname_result = $db->pquery($mcdata, array($processmasterid));
			$field = array();
			$unit_instance_data_info = array();
			$i = 0;  
			while($mcrow = $db->fetch_array($mcviewname_result))
			{
				$customform = $mcrow['customform'];
				$customform_info = json_decode(stripslashes(html_entity_decode($customform)), true);
				$frmData = $customform_info['html'];
				if(count($frmData) > 0){
					foreach($frmData as $key=>$fieldData){
						$field[$fieldData['html']['name']] = $fieldData['html']['caption'];
					}
				}
			}
		 
			$responseData = array("message"=>"Success.", 'success'=>true, "response" => json_encode($field));
			 
				
		break;

		case 'getProductsCategorysList':
				$processid = $request->get('processid');				 
				$q ="SELECT materials,vessels,tools,machinery,id_end_product_category,is_vessels,is_tools,is_machinery FROM vtiger_processmaster where processmasterid=?";
				$result = $db->pquery($q,array($processid));
				$result = $db->fetch_array($result);            
				 
				$materials = json_decode(stripslashes(html_entity_decode($result['materials'])), true);
				$materials = $this->getMaterialsInDetails($materials);
				$vessels = $this->getAssectDetailsUsingIds(trim($result['vessels'])); 
				$tools = $this->getAssectDetailsUsingIds(trim($result['tools'])); 
				$machinery = $this->getAssectDetailsUsingIds(trim($result['machinery'])); 
				$id_end_product_category = $result['id_end_product_category'];
				$responseData = array('success'=>true,'status'=>true,'materials'=>$materials,'vessels'=>$vessels,'tools'=>$tools,'machinery'=>$machinery,'productcategory'=>$id_end_product_category,'is_vessels'=>$result['is_vessels'],'is_tools'=>$result['is_tools'],'is_machinery'=>$result['is_machinery']);
				 
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
				$productCategory = $pdata['productcategory'];
				$a[$i]['qtyinstock'] = $pdata['qtyinstock'];
				
				$q1 = $adb->pquery("SELECT productcategoryid FROM vtiger_productcategory WHERE productcategory =?", array($productCategory));
				$a[$i]['productcategory'] = $adb->query_result($q1, 0, 'productcategoryid');
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
