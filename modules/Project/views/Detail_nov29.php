<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Project_Detail_View extends Vtiger_Detail_View {
	
	function __construct() {
		parent::__construct();
		$this->exposeMethod('showRelatedRecords');
		//Added on nov15 2017 Pickingslips module purpose
		$this->exposeMethod('saveUsedQty');
		$this->exposeMethod('showProductPODetails');
	}

		public function showModuleDetailView(Vtiger_Request $request) {
			$recordId = $request->get('record');
			$moduleName = $request->getModule();
			if(!$this->record){
				$this->record = Vtiger_DetailView_Model::getInstance($moduleName, $recordId);
			}
			$recordModel = $this->record->getRecord();
			$recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_DETAIL);
			$structuredValues = $recordStrucure->getStructure();
			$moduleModel = $recordModel->getModule();
			$viewer = $this->getViewer($request);
			//Manasa
			global $adb;
			$productcount = $adb->num_rows($adb->pquery("SELECT sum(qty) as qty , sum(used_qty) as usedqty FROM vtiger_projectsproduct_details WHERE projectid=? Having sum(qty) != sum(used_qty)",array($recordId)));
			$viewer->assign('PRODUCTSCOUNT', $productcount);
			//Manasa ended here
			$viewer->assign('RECORD', $recordModel);
			$viewer->assign('RECORD_STRUCTURE', $structuredValues);
			$viewer->assign('BLOCK_LIST', $moduleModel->getBlocks());
			$viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
			$viewer->assign('MODULE_NAME', $moduleName);
			$viewer->assign('IS_AJAX_ENABLED', $this->isAjaxEnabled($recordModel));
			return $viewer->view('DetailViewFullContents.tpl',$moduleName,true);
	}

	public function showModuleSummaryView($request) {
		$recordId = $request->get('record');
		$moduleName = $request->getModule();

		$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
		$recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_SUMMARY);
		
		$viewer = $this->getViewer($request);
		//Manasa
		global $adb;
		$productcount = $adb->num_rows($adb->pquery("SELECT sum(qty) as qty , sum(used_qty) as usedqty FROM vtiger_projectsproduct_details WHERE projectid=? Having sum(qty) != sum(used_qty)",array($recordId)));
		$viewer->assign('PRODUCTSCOUNT', $productcount);
		//Manasa ended here
		$viewer->assign('RECORD', $recordModel);
        $viewer->assign('IS_AJAX_ENABLED', $this->isAjaxEnabled($recordModel));
		$viewer->assign('SUMMARY_INFORMATION', $recordModel->getSummaryInfo());
		$viewer->assign('SUMMARY_RECORD_STRUCTURE', $recordStrucure->getStructure());
        $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('MODULE_NAME', $moduleName);

		return $viewer->view('ModuleSummaryView.tpl', $moduleName, true);
	}
	
	/**
	 * Function returns related records based on related moduleName
	 * @param Vtiger_Request $request
	 * @return <type>
	 */
	function showRelatedRecords(Vtiger_Request $request) {
		$parentId = $request->get('record');
		$pageNumber = $request->get('page');
		$limit = $request->get('limit');
		$relatedModuleName = $request->get('relatedModule');
		$orderBy = $request->get('orderby');
		$sortOrder = $request->get('sortorder');
		$whereCondition = $request->get('whereCondition');
		$moduleName = $request->getModule();
		
		if($sortOrder == "ASC") {
			$nextSortOrder = "DESC";
			$sortImage = "icon-chevron-down";
		} else {
			$nextSortOrder = "ASC";
			$sortImage = "icon-chevron-up";
		}
		
		$parentRecordModel = Vtiger_Record_Model::getInstanceById($parentId, $moduleName);
		$relationListView = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $relatedModuleName);
		
		if(!empty($orderBy)) {
			$relationListView->set('orderby', $orderBy);
			$relationListView->set('sortorder', $sortOrder);
		}

		if(empty($pageNumber)) {
			$pageNumber = 1;
		}

		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $pageNumber);
		if(!empty($limit)) {
			$pagingModel->set('limit', $limit);
		}

		if ($whereCondition) {
			$relationListView->set('whereCondition', $whereCondition);
		}

		$models = $relationListView->getEntries($pagingModel);
		$header = $relationListView->getHeaders();
		
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE' , $moduleName);
		$viewer->assign('RELATED_RECORDS' , $models);
		$viewer->assign('RELATED_HEADERS', $header);
		$viewer->assign('RELATED_MODULE' , $relatedModuleName);
		$viewer->assign('RELATED_MODULE_MODEL', Vtiger_Module_Model::getInstance($relatedModuleName));
		$viewer->assign('PAGING_MODEL', $pagingModel);

		return $viewer->view('SummaryWidgets.tpl', $moduleName, 'true');
	}
	//ProductDetails Getting purpose Added 20th nov 2017
	public function saveUsedQty($request){
		global $adb;
		$parentId = $request->get('recordId');
		$usedqty = $request->get('usedqty');
		$name = $request->get('productname');

		$adb->pquery("UPDATE vtiger_projectsproduct_details SET used_qty=? where projectid=? and name=?",array($usedqty,$parentId,$name));
		$response = new Vtiger_Response();
		$response->setResult($usedqty);
		$response->emit();
	}
	public function showProductPODetails($request){
		$viewer = $this->getViewer($request);
		global $adb;
		$parentId = $request->get('record');
		$query = $adb->pquery("SELECT vtiger_crmentity.*, vtiger_projectstock.*, CASE WHEN (vtiger_users.user_name NOT LIKE '') THEN CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name) ELSE vtiger_groups.groupname END AS user_name FROM vtiger_projectstock INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_projectstock.projectstockid left JOIN vtiger_crmentityrel ON (vtiger_crmentityrel.relcrmid = vtiger_crmentity.crmid OR vtiger_crmentityrel.crmid = vtiger_crmentity.crmid) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND vtiger_projectstock.projectid=? and vtiger_projectstock.stockstatus=?",array($parentId,'Approved'));
		$rows = $adb->num_rows($query);
		if($rows != 0){
			$poid = array();
			for($i=0;$i<$rows;$i++){
				$poid[] = $adb->query_result($query,$i,'projectstockid');
			}
		}
		$productnames = array();
		if(count($poid) != 0){
		$proquery = $adb->pquery("SELECT vtiger_inventoryproductrel.productid,product_no,productname,SUM( quantity ) as quantity FROM vtiger_inventoryproductrel ,vtiger_products,vtiger_crmentity WHERE vtiger_products.productid = vtiger_inventoryproductrel.productid and vtiger_crmentity.crmid = vtiger_products.productid and deleted=0 and id in (" . generateQuestionMarks($poid) . ") group by product_no " ,$poid);
		$prorows = $adb->num_rows($proquery);
			if($prorows != 0){
				$productnames = array();
				for($i=0;$i<$prorows;$i++){
					$productnames[$i]['productnum'] = $adb->query_result($proquery,$i,'product_no');
					$productnames[$i]['productname'] = $adb->query_result($proquery,$i,'productname');
					$productnames[$i]['quantity'] = $adb->query_result($proquery,$i,'quantity');
				}
			}
		}
		//
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

		//Again retrieving to display
		$sql2 = $adb->pquery("SELECT * FROM vtiger_projectsproduct_details WHERE projectid=?",array($parentId));
		$frows = $adb->num_rows($sql2);
			if($frows != 0){
				for($i=0;$i<$frows;$i++){
					$products[$i]['productnumber'] = $adb->query_result($sql2,$i,'productnumber');
					$products[$i]['productname'] = $adb->query_result($sql2,$i,'name');
					$qty =  $adb->query_result($sql2,$i,'qty');
					$products[$i]['quantity'] = $qty;
					$usedqty =  $adb->query_result($sql2,$i,'used_qty');
					$products[$i]['usedqty'] = $usedqty ;
					$products[$i]['remainingqty'] = $qty - $usedqty;					
				}
			}
		$viewer->assign('PRODUCTDETAILS',$products);
		$moduleName = $request->getModule();
		return $viewer->view('POProductsDetails.tpl',$moduleName,true);
	}
	/**
	 * Function to get the list of Script models to be included
	 * @param Vtiger_Request $request
	 * @return <Array> - List of Vtiger_JsScript_Model instances
	 */
	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
				'modules.Project.resources.CustomValidations',
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}
	//ended here
}
?>
