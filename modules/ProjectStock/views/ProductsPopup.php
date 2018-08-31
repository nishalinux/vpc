<?php
class ProjectStock_ProductsPopup_View extends Inventory_ProductsPopup_View {
function getModule($request) {
		return 'Products';
	}
	
	function process (Vtiger_Request $request) {
		$viewer = $this->getViewer ($request);
		$companyDetails = Vtiger_CompanyDetails_Model::getInstanceById();
		$companyLogo = $companyDetails->getLogo();

		$this->initializeListViewContents($request, $viewer);

		$viewer->assign('COMPANY_LOGO',$companyLogo);
		$moduleName = 'Inventory';
		$viewer->assign('MODULE_NAME',$moduleName);
		$viewer->view('Popup.tpl', $moduleName);
	}
	public function transferListSearchParamsToFilterCondition($listSearchParams, $moduleModel) {
		$count = count($listSearchParams);
		$column = array();
		foreach($listSearchParams as $k=>$v){
			$column[$k]['columnname'] ='vtiger_products:product_no:product_no:Products_Product_Number:V';
			
			$column[$k]['comparator'] = $v[1] ;
			$column[$k]['value'] =$v[2] ;
			$x = $count--;
			
			if($x == 1 ){
				$column[$k]['column_condition'] ='';
			}else{
				$column[$k]['column_condition'] ='OR';
			}
		
		}
		$report[]['columns'] = $column;
	
		return $report;
              
    }

	/*
	 * Function to initialize the required data in smarty to display the List View Contents
	 */
	public function initializeListViewContents(Vtiger_Request $request, Vtiger_Viewer $viewer) {
		//src_module value is added to just to stop showing inactive products
		$request->set('src_module', $request->getModule());

		$moduleName = $this->getModule($request);
		$cvId = $request->get('cvid');
		$pageNumber = $request->get('page');
		$orderBy = $request->get('orderby');
		$sortOrder = $request->get('sortorder');
		$sourceModule = $request->get('src_module');
		$sourceField = $request->get('src_field');
		$sourceRecord = $request->get('src_record');
		$searchKey = $request->get('search_key');
		$searchValue = $request->get('search_value');
		$currencyId = $request->get('currency_id');
		
		//To handle special operation when selecting record from Popup
		$getUrl = $request->get('get_url');

		//Check whether the request is in multi select mode
		$multiSelectMode = $request->get('multi_select');
		if(empty($multiSelectMode)) {
			$multiSelectMode = false;
		}

		if(empty($cvId)) {
			$cvId = '0';
		}
		if(empty ($pageNumber)) {
			$pageNumber = '1';
		}

		$pagingModel = new Vtiger_Paging_Model();
		$pagingModel->set('page', $pageNumber);

		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$listViewModel = Vtiger_ListView_Model::getInstanceForPopup($moduleName);
		$recordStructureInstance = Vtiger_RecordStructure_Model::getInstanceForModule($moduleModel);

		if(!empty($orderBy)) {
			$listViewModel->set('orderby', $orderBy);
			$listViewModel->set('sortorder', $sortOrder);
		}
		if(!empty($sourceModule)) {
			$listViewModel->set('src_module', $sourceModule);
			$listViewModel->set('src_field', $sourceField);
			$listViewModel->set('src_record', $sourceRecord);
		}
		if((!empty($searchKey)) && (!empty($searchValue))) {
			$listViewModel->set('search_key', $searchKey);
			$listViewModel->set('search_value', $searchValue);
		}
        
		//Manasa
		$projectid = $request->get('projectid');
		if($projectid != ''){
			global $adb;
			$query = $adb->pquery("SELECT name,qty,used_qty,productnumber FROM vtiger_projectsproduct_details WHERE projectid=?",array($projectid));
			$frows = $adb->num_rows($query);
			if($frows != 0){
				$productnames = array();
				$searchParmams = array();
				for($i=0;$i<$frows;$i++){
					$productname = $adb->query_result($query,$i,'productnumber');
					$productnames[$productname] = $adb->query_result($query,$i,'qty');

					$searchParmams[] = array('productnumber','e',$productname);
				}
			}

		}
        if(empty($searchParmams)) {
            $searchParmams = array();
        }
        $transformedSearchParams = $this->transferListSearchParamsToFilterCondition($searchParmams, $listViewModel->getModule());
        $listViewModel->set('search_params',$transformedSearchParams);
//Manasa ended here
        $productModel = Vtiger_Module_Model::getInstance('Products');        
		if(!$this->listViewHeaders) {
			$this->listViewHeaders = $listViewModel->getListViewHeaders();
		}
        
		if(!$this->listViewEntries && $productModel->isActive()) {
			$this->listViewEntries = $listViewModel->getListViewEntries($pagingModel);
		}

        if(!$productModel->isActive()){
            $this->listViewEntries = array(); 
            $viewer->assign('LBL_MODULE_DISABLED', true);
        }
        
		foreach ($this->listViewEntries as $key => $listViewEntry) {
			$productId = $listViewEntry->getId();
			$subProducts = $listViewModel->getSubProducts($productId);
			if($subProducts) {
				$listViewEntry->set('subProducts', $subProducts);
			}
		}

		$noOfEntries = count($this->listViewEntries);

		if(empty($sortOrder)) {
			$sortOrder = "ASC";
		}
		if($sortOrder == "ASC") {
			$nextSortOrder = "DESC";
			$sortImage = "downArrowSmall.png";
		}else {
			$nextSortOrder = "ASC";
			$sortImage = "upArrowSmall.png";
		}
		$viewer->assign('MODULE', $moduleName);
        $viewer->assign('RELATED_MODULE', $moduleName); 
		$viewer->assign('SOURCE_MODULE', $sourceModule);
		$viewer->assign('SOURCE_FIELD', $sourceField);
		$viewer->assign('SOURCE_RECORD', $sourceRecord);

		$viewer->assign('SEARCH_KEY', $searchKey);
		$viewer->assign('SEARCH_VALUE', $searchValue);

		$viewer->assign('ORDER_BY',$orderBy);
		$viewer->assign('SORT_ORDER',$sortOrder);
		$viewer->assign('NEXT_SORT_ORDER',$nextSortOrder);
		$viewer->assign('SORT_IMAGE',$sortImage);
		$viewer->assign('GETURL', $getUrl);
		$viewer->assign('CURRENCY_ID', $currencyId);

		$viewer->assign('RECORD_STRUCTURE_MODEL', $recordStructureInstance);
		$viewer->assign('RECORD_STRUCTURE', $recordStructureInstance->getStructure());

		$viewer->assign('PAGING_MODEL', $pagingModel);
		$viewer->assign('PAGE_NUMBER',$pageNumber);

		$viewer->assign('LISTVIEW_ENTRIES_COUNT',$noOfEntries);
		$viewer->assign('LISTVIEW_HEADERS', $this->listViewHeaders);
		$viewer->assign('LISTVIEW_ENTRIES', $this->listViewEntries);
		//Manasa
		$viewer->assign('PRODUCTNAMES',$productnames);
		
		if (PerformancePrefs::getBoolean('LISTVIEW_COMPUTE_PAGE_COUNT', false)) {
			if(!$this->listViewCount){
				$this->listViewCount = $listViewModel->getListViewCount();
			}
			$totalCount = $this->listViewCount;
			$pageLimit = $pagingModel->getPageLimit();
			$pageCount = ceil((int) $totalCount / (int) $pageLimit);

			if($pageCount == 0){
				$pageCount = 1;
			}
			$viewer->assign('PAGE_COUNT', $pageCount);
			$viewer->assign('LISTVIEW_COUNT', $totalCount);
		}

		$viewer->assign('MULTI_SELECT', $multiSelectMode);
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
		$viewer->assign('TARGET_MODULE', $moduleName);
		$viewer->assign('MODULE', $request->getModule());
		$viewer->assign('GETURL', 'getTaxesURL');
		$viewer->assign('VIEW', 'ProductsPopup');
	}

/**
	 * Function to get listView count
	 * @param Vtiger_Request $request
	 */
	function getListViewCount(Vtiger_Request $request){
		$moduleName = $this->getModule($request);
		$sourceModule = $request->get('src_module');
		$sourceField = $request->get('src_field');
		$sourceRecord = $request->get('src_record');
		$orderBy = $request->get('orderby');
		$sortOrder = $request->get('sortorder');
		$currencyId = $request->get('currency_id');

		$searchKey = $request->get('search_key');
		$searchValue = $request->get('search_value');
		
		$relatedParentModule = $request->get('related_parent_module');
		$relatedParentId = $request->get('related_parent_id');
				
		if(!empty($relatedParentModule) && !empty($relatedParentId)) {
			$parentRecordModel = Vtiger_Record_Model::getInstanceById($relatedParentId, $relatedParentModule);
			$listViewModel = Vtiger_RelationListView_Model::getInstance($parentRecordModel, $moduleName, $label);
		}else{
			$listViewModel = Vtiger_ListView_Model::getInstanceForPopup($moduleName);
		}
		
		if(!empty($sourceModule)) {
			$listViewModel->set('src_module', $sourceModule);
			$listViewModel->set('src_field', $sourceField);
			$listViewModel->set('src_record', $sourceRecord);
			$listViewModel->set('currency_id', $currencyId);
		}
		
		if(!empty($orderBy)) {
			$listViewModel->set('orderby', $orderBy);
			$listViewModel->set('sortorder', $sortOrder);
		}
		if((!empty($searchKey)) && (!empty($searchValue)))  {
			$listViewModel->set('search_key', $searchKey);
			$listViewModel->set('search_value', $searchValue);
		}
		//Manasa
		$projectid = $request->get('projectid');
		if($projectid != ''){
			global $adb;
			$query = $adb->pquery("SELECT name,qty,used_qty,productnumber FROM vtiger_projectsproduct_details WHERE projectid=?",array($projectid));
			$frows = $adb->num_rows($query);
			if($frows != 0){
				$productnames = array();
				$searchParmams = array();
				for($i=0;$i<$frows;$i++){
					$productname = $adb->query_result($query,$i,'productnumber');
					$productnames[$productname] = $adb->query_result($query,$i,'qty');

					$searchParmams[] = array('productnumber','e',$productname);
				}
			}

		}
        if(empty($searchParmams)) {
            $searchParmams = array();
        }
        $transformedSearchParams = $this->transferListSearchParamsToFilterCondition($searchParmams, $listViewModel->getModule());
        $listViewModel->set('search_params',$transformedSearchParams);
//Manasa ended here
		if(!empty($relatedParentModule) && !empty($relatedParentId)) {
			$count = $listViewModel->getRelatedEntriesCount();
		}else{
			$count = $listViewModel->getListViewCount();
		}
		
		return $count;
	}

		/**
	 * Function to get the page count for list
	 * @return total number of pages
	 */
	function getPageCount(Vtiger_Request $request){
		$listViewCount = $this->getListViewCount($request);
		$pagingModel = new Vtiger_Paging_Model();
		$pageLimit = $pagingModel->getPageLimit();
		$pageCount = ceil((int) $listViewCount / (int) $pageLimit);

		if($pageCount == 0){
			$pageCount = 1;
		}
		$result = array();
		$result['page'] = $pageCount;
		$result['numberOfRecords'] = $listViewCount;
		$response = new Vtiger_Response();
		$response->setResult($result);
		$response->emit();
	}
	
}