<?php

class ProjectStock_ProductsPopupAjax_View extends ProjectStock_ProductsPopup_View {
function __construct() {
		parent::__construct();
		$this->exposeMethod('getListViewCount');
		$this->exposeMethod('getRecordsCount');
		$this->exposeMethod('getPageCount');
	}
	
	/**
	 * Function returns module name for which Popup will be initialized
	 * @param type $request
	 */
	public function getModule($request) {
		return 'Products';
	}
	function process (Vtiger_Request $request) {
		$mode = $request->get('mode');
		if(!empty($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}
		$viewer = $this->getViewer ($request);

		$this->initializeListViewContents($request, $viewer);
		$moduleName = 'ProjectStock';
		$viewer->assign('MODULE_NAME',$moduleName);
		echo $viewer->view('PopupContents.tpl', $moduleName, true);
	}
}