<?php 
/** License Text Here **/
class PCMReports_DashBoard_View extends Vtiger_Index_View {
    function __construct() {
		parent::__construct();		
		$this->exposeMethod('ProjectsWorkStatus'); 
		$this->exposeMethod('ProjectDetails'); 
	}	 

    function ProjectsWorkStatus(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$projects = $moduleModel->getProjects();
		$projects_data=$moduleModel->getProjectsWorkStatus();
		
		$viewer = $this->getViewer($request);
		$viewer->assign('PROJECT_DATA', $projects_data);		
		$viewer->assign('PROJECTS', $projects);		 
		$viewer->view('ProjectsWorkStatus.tpl', $moduleName);
	} 
	
	function ProjectDetails(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$projectid = $request->get('projectid');
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);		 
		$projects_data=$moduleModel->getProjectsDetails();
		
		$viewer = $this->getViewer($request);
		$viewer->assign('PROJECT_DATA', $projects_data);		 	 
		$viewer->view('ProjectsTaskWorkStatus.tpl', $moduleName);
	}
	
	public function preProcess(Vtiger_Request $request, $display = true) {
		$viewer = $this->getViewer($request);
		$viewer->assign('MODULE_NAME', $request->getModule());

		parent::preProcess($request, false);
		if($display) {
			$this->preProcessDisplay($request);
		}
	}
   
	protected function preProcessTplName(Vtiger_Request $request) {
		return 'DashboardViewPreProcess.tpl';
	}
	public function getHeaderCss1(Vtiger_Request $request) {
		$moduleName = $request->getModule();
		$parentCSSScripts = parent::getHeaderCss($request);
		$styleFileNames = array(
			"~/layouts/vlayout/modules/PCMReports/resources/css/bootstrap.min.css",
			"~/layouts/vlayout/modules/PCMReports/resources/css/logo-nav.css",
			);
		$cssScriptInstances = $this->checkAndConvertCssStyles($styleFileNames);
		$headerCSSScriptInstances = array_merge($parentCSSScripts, $cssScriptInstances);
		return $headerCSSScriptInstances;
	}
	public function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$jsFileNames = array(
			"modules.PCMReports.resources.DashBoardView",
			//"modules.PCMReports.resources.NumberFormat",
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	public function process(Vtiger_Request $request) {
		$mode = $request->getMode();
		if(!empty($mode)) {
			echo $this->invokeExposedMethod($mode, $request);
			return;
		}
		$viewer = $this->getViewer($request);
		$moduleName = $request->getModule();
		$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
		$viewer->assign('MODULEMODEL', $moduleModel);
		$viewer->assign('MODULE', $moduleName);
		$viewer->view('Index.tpl', $request->getModule());
	}
	
}
?>