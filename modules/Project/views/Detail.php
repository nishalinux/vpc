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
		//Manasa ended here qq
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
		global $adb;
		//$adb->setDebug(true);
		$recordModel = Vtiger_Record_Model::getInstanceById($recordId);
		$recordStrucure = Vtiger_RecordStructure_Model::getInstanceFromRecordModel($recordModel, Vtiger_RecordStructure_Model::RECORD_STRUCTURE_MODE_SUMMARY);
		
		$viewer = $this->getViewer($request);
		$viewer->assign('RECORD', $recordModel);
		$viewer->assign('IS_AJAX_ENABLED', $this->isAjaxEnabled($recordModel));
		$viewer->assign('SUMMARY_INFORMATION_PROCESSFLOW', $recordModel->getSummaryInfoProcessFlow($recordId));
		$viewer->assign('SUMMARY_INFORMATION', $recordModel->getSummaryInfo());
		$processflows_list = $this->getProjectProcessFlows($recordId);
		$viewer->assign('PROJECT_PROCESSFLOWS', $processflows_list);
		$inprogress_processes = $this->getProjectInProgressProcessFlows($recordId);
		$viewer->assign('PROJECT_INPROGRESSPROCESSFLOWS', $inprogress_processes);
		$viewer->assign('SUMMARY_RECORD_STRUCTURE', $recordStrucure->getStructure());
        $viewer->assign('USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('MODULE_NAME', $moduleName);
		$viewer->assign('RECORDID', $recordId);

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
	#ProductDetails Getting purpose Added 12th Dec 2017
	public function showProductPODetails($request){
			$viewer = $this->getViewer($request);
			global $adb;
			//$adb->setDebug(true);
			$parentId = $request->get('record');
			$query = $adb->pquery("SELECT vtiger_crmentity.*, vtiger_products.*, CASE WHEN (vtiger_users.user_name NOT LIKE '') THEN CONCAT(vtiger_users.first_name,' ',vtiger_users.last_name) ELSE vtiger_groups.groupname END AS user_name FROM vtiger_products INNER JOIN vtiger_crmentity ON vtiger_crmentity.crmid = vtiger_products.productid INNER JOIN vtiger_crmentityrel ON (vtiger_crmentityrel.relcrmid = vtiger_crmentity.crmid OR vtiger_crmentityrel.crmid = vtiger_crmentity.crmid) LEFT JOIN vtiger_users ON vtiger_users.id = vtiger_crmentity.smownerid LEFT JOIN vtiger_groups ON vtiger_groups.groupid = vtiger_crmentity.smownerid WHERE vtiger_crmentity.deleted = 0 AND (vtiger_crmentityrel.crmid = ? OR vtiger_crmentityrel.relcrmid = ?)",array($parentId,$parentId));
			$rows = $adb->num_rows($query);
			$productdetails = array();
			if($rows != 0){
				$poid = array();
				for($i=0;$i<$rows;$i++){
					$productdetails[$i]['productid'] = $adb->query_result($query,$i,'productid');
					$productdetails[$i]['product_no'] = $adb->query_result($query,$i,'product_no');
					$productdetails[$i]['productname']= $adb->query_result($query,$i,'productname');
					$productdetails[$i]['productqty']= $adb->query_result($query,$i,'qtyinstock');
				}
			}
			$sql1= $adb->fetch_row($adb->pquery("select count(*) as count from vtiger_projectproductqty_details where projectid=?",array($parentId)),0,'count');
			if($sql1['count'] == 0){
				for($j=0;$j<count($productdetails);$j++){
					$details = array();
					$details[] = $productdetails[$j]['productid'];
					$details[] = $parentId;
					$details[] = $productdetails[$j]['product_no'];
					$details[] = $productdetails[$j]['productname'];
					$details[] = $productdetails[$j]['productqty'];
					$adb->pquery("INSERT INTO vtiger_projectproductqty_details(productid, projectid, productnumber, productname, productqty) VALUES (?,?,?,?,?)",$details);	
				}
			}else{
				for($j=0;$j<count($productdetails);$j++){
					$details = array();
					$update = array();
					$update[] = $productdetails[$j]['productqty'];
					$update[] = $parentId;
					$update[] = $productdetails[$j]['productid'];

					$details[] = $productdetails[$j]['productid'];
					$details[] = $parentId;
					$details[] = $productdetails[$j]['product_no'];
					$details[] = $productdetails[$j]['productname'];
					$details[] = $productdetails[$j]['productqty'];
					
					$sql3= $adb->fetch_row($adb->pquery("select count(*) as count from vtiger_projectproductqty_details where projectid=? and productid=?",array($parentId,$productdetails[$j]['productid'])),0,'count');
					if($sql3['count'] == 0){
						$adb->pquery("INSERT INTO vtiger_projectproductqty_details(productid, projectid, productnumber, productname, productqty) VALUES (?,?,?,?,?)",$details);		
					}else{
						$adb->pquery("UPDATE vtiger_projectproductqty_details SET productqty=? where projectid=? and productid=?",$update);
					}
				}
				
			}

			//Again retrieving to display
			$sql2 = $adb->pquery("SELECT * FROM vtiger_projectproductqty_details WHERE projectid=?",array($parentId));
			$frows = $adb->num_rows($sql2);
				if($frows != 0){
					for($i=0;$i<$frows;$i++){
						$productid = $adb->query_result($sql2,$i,'productid');
						$recordModel = Vtiger_Record_Model::getInstanceById($productid, 'Products');
						$prodet = $recordModel->getData();
						$price = round($prodet['unit_price'],2);
						$qty =  $adb->query_result($sql2,$i,'allocatedtqty');
						$products[$i]['price'] = $price;
						$products[$i]['totalprice'] = $price * $qty;
						$products[$i]['productid'] = $productid;
						$products[$i]['productnumber'] = $prodet['product_no'];
						$products[$i]['productname'] = $prodet['productname'];
						$products[$i]['productqty'] = $prodet['qtyinstock'];
						$products[$i]['is_edit'] = $adb->query_result($sql2,$i,'is_edit');
						$products[$i]['is_checked'] = $adb->query_result($sql2,$i,'is_checked');
						$qty =  $adb->query_result($sql2,$i,'allocatedtqty');
						$products[$i]['allocatedtqty'] = $qty;
						$usedqty =  $adb->query_result($sql2,$i,'used_qty');
						$products[$i]['usedqty'] = $usedqty ;
						$products[$i]['remainingqty'] = $qty - $usedqty;					
					}
				}
			$viewer->assign('PRODUCTDETAILS',$products);
			$moduleName = $request->getModule();
			return $viewer->view('POProductsDetails.tpl',$moduleName,true);
		}

	public function getProjectProcessFlows($recordId)
	{
		global $adb;
		$pc = "select pf.processflowname, pf.processflowid, pf.process_flow_start_time, pf.process_flow_end_time from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?";
		$pcresult = $adb->pquery($pc,array($recordId));
		$i=0;
		$pclistitems = array();
		while($abc=$adb->fetch_array($pcresult))
		{
			$pclistitems[] = $abc;
			$i++;
		}
		return $pclistitems;
	}
	public function getProjectInProgressProcessFlows($recordId)
	{
		global $adb;
		$pc = "SELECT pu.description,pui.process_instanceid,pui.start_time, pui.end_time, p.processflowname,pu.assignedto  from vtiger_processflow_unitprocess_instance pui left join vtiger_processflow_unitprocess pu on pu.unitprocessid = pui.unitprocessid left join vtiger_processflow p on p.processflowid = pui.process_instanceid where pui.process_status in (1,4) and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
		$pcresult = $adb->pquery($pc,array($recordId));
		$i=0;
		$pclistitems = array();
		while($abc=$adb->fetch_array($pcresult))
		{
			$pclistitems[] = $abc;
			$i++;
		}
		return $pclistitems;
	}

/*
	public function PendingDecision()
	{
		print_r($_REQUEST);exit;
	}
	
	public function PendingApproval()
	{
		print_r($_REQUEST);exit;
	}
	
	public function TaskCompleted()
	{
		print_r($_REQUEST);exit;
	}
	*/
	
}
?>
