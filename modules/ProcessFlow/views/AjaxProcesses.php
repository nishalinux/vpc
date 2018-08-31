<?php
include 'modules/ProcessFlow/models/Record.php';
Class ProcessFlow_AjaxProcesses_View extends Vtiger_Index_View {

    function __construct() {
        parent::__construct();
	}

	function preProcess(Vtiger_Request $request) {
		return true;
	}

	function postProcess(Vtiger_Request $request) {
		return true;
    }
    
	public function process(Vtiger_Request $request) { 
        global $adb;
        //$adb->setDebug(true);
		$recordId = $request->get('recordId');       
        $viewer = $this->getViewer($request);
		$moduleName = $request->getModule();       
        $viewer->assign('MODULE', $moduleName);	
        $current_time = date('Y-m-d H:i:s');
		$viewer->assign('CURRENT_TIME',$current_time);	 
		$viewer->assign('CURRENT_USER_MODEL', Users_Record_Model::getCurrentUserModel());
        if(!empty($recordId)){ 
			$module_model = new ProcessFlow_Record_Model();
			$viewer->assign('PROCESSFLOW_MODEL',$module_model);
			$viewer->assign('RECORD_ID',$recordId);
			$viewer->assign('PROCESS_MASTER_DATA', $this->getProcessData($recordId));
        }
        
		echo $viewer->view('EditViewBlocksProcessFlowEdit.tpl', $moduleName, true);
	}

	function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);

		$jsFileNames = array(
			//'~libraries/jquery/jquery.dform-1.1.0.min.js'
		);
		 
		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	public function getProcessMasterList(){
		 
		global $adb;
		$result = $adb->pquery("SELECT * FROM vtiger_processmaster where is_draft = 0",array());
		$final = array();
		if($adb->num_rows($result) >0 ){ 
			while($data = $adb->fetch_array($result)){ 
				$final[$data['processmasterid']] = $data['processmastername'];
			}
		}
		return $final;
	}
	public function getProductList(){
		global $adb;
		$result = $adb->pquery("SELECT productid,productname FROM vtiger_products p left join vtiger_crmentity c on p.productid = c.crmid where deleted = 0",array());
		$final = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$final[$data['productid']] = $data['productname'];
			}
		}
		return $final;
	}
	public function getProductCategoryList(){
		 
		global $adb;
		$result = $adb->pquery("SELECT productcategoryid, productcategory FROM vtiger_productcategory ORDER BY sortorderid ASC",array());
		$final = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$final[$data['productcategoryid']] = $data['productcategory'];
			}
		}
		return $final;
	}
 
	public function getProcessData($recordId){
		global $adb;
		#get process manager id 
		$result = $adb->pquery("SELECT p.*,c.smownerid FROM vtiger_processflow p left join vtiger_crmentity c on p.processflowid = c.crmid where p.processflowid = ?",array($recordId));

        $processflowData = $adb->fetch_array($result);
       	 
		$final_array = array();
		$final_array['assigne_role'] = $this->getRoleidFromUserId($processflowData['smownerid']);
		#$final_array['assigne_users'] = $this->getUserFullNames($processflowData['pf_assignee']);
		$final_array['assigne_users'] = $this->getUserFullNames();
		$final_array['assignee_data'] = $this->getAssigneeData($recordId);
		$final_array['products_data'] = $this->getProductsData($processflowData['raw_materials']);
		$final_array['created_by'] = $processflowData['smownerid'];

		$final_array['process_master_id'] = $processflowData['processmasterid'];
		$final_array['termination_status'] = $processflowData['pf_termination'];
		$final_array['process_start_date_time'] = $processflowData['process_flow_start_time'];
		$final_array['process_name'] = $processflowData['processflowname'];
		
		$processmaster_data = $this->getProcessMasterData($processflowData['processmasterid']);
		$final_array['supervisor_roleid'] = $processmaster_data['supervisor_roleid'];
		$final_array['operator_roleid'] = $processmaster_data['operator_roleid'];
		$final_array['sound_notifications'] = $processmaster_data['sound_notifications'];
		$final_array['help_details'] = $processmaster_data['details'];

		$final_array['process_list'] = $this->getProcessFlowUnitprocess($processflowData['processmasterid']);
		$final_array['process_instance_list'] = $this->getProcessFlowUnitprocessInstance($recordId);
		$final_array['process_Block_list'] = $this->getBlockTypeList();
		$final_array['process_destails']   = $this->getProcessDetails($recordId); 

		$ct_array = array_filter(array_map(function($arr){
						if ($arr['process_status'] == 1)
							return $arr['unitprocessid'];
						}, $final_array['process_instance_list']));
		$final_array['current_task'] = $this->getCurrentTask($recordId);

		$final_array['total_tasks'] = count($final_array['process_list']);
		
		$process_instance_list = $this->pf_array_count($final_array['process_instance_list'], 'process_status', '2');
		$final_array['total_completed_tasks'] = $process_instance_list;
		$final_array['total_not_started_tasks'] =  count($final_array['process_list']) - $process_instance_list;
		$final_array['total_tasks_Waiting'] = $this->getWaitingTasksCount($recordId);
		$final_array['pf_documents'] = $this->getPFDocuments($recordId);
	 	 
		return $final_array;
	}

	public function getPFDocuments($recordId){
		global $adb;
		$q = "SELECT * FROM vtiger_processflow_documents where process_instanceid = ?";
		$result = $adb->pquery($q, array($recordId));
		$rows = $adb->num_rows($result);
		$finaldata = array();
		if($rows > 0){
			while($data = $adb->fetch_array($result)){
				$finaldata[$data['unitprocessid']] = $data;   
			}
			return $finaldata;
		}
		return $finaldata;
	}

	public function getAssigneeData($recordId){
		global $adb;
		$q = "SELECT unitprocessid,assignee_user_id FROM vtiger_processflow_assignee where processflowid = ?";
		$result = $adb->pquery($q, array($recordId));
		$rows = $adb->num_rows($result);
		$finaldata = array();
		if($rows > 0){
			while($data = $adb->fetch_array($result)){
				$finaldata[$data['unitprocessid']] = $data['assignee_user_id'];   
			}
			return $finaldata;
		}
		return $finaldata;
	}

	public function getProductsData($products_list){
        global $adb;
        $final = array();       
        if(trim($products_list) != ''){
            $result = $adb->pquery("SELECT productid,productname FROM vtiger_products p left join vtiger_crmentity c on p.productid = c.crmid where p.productid in ($products_list) ",array());
            $final = array();
            if($adb->num_rows($result) >0 ){
                while($data = $adb->fetch_array($result)){
                    $final[$data['productid']] = $data['productname'];
                }
            }
        }
		return $final;
	}


	public function getUserFullNames(){
		/*if(!empty($users)){
			$users = explode(';',$users);
			$data = array();
			foreach($users as $user){
				$data[$user] = getUserFullName($user);
			}
			return $data;
		}
		return array();
		*/
		global $adb;
		//$adb->setDebug(true);
		$users_List = array();
		$result = $adb->pquery("SELECT id,user_name,CONCAT(first_name,' ',last_name) as fullname FROM `vtiger_users` WHERE deleted = 0 and status = 'Active' ", array());
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$users_List[$data['id']] = $data;   
			}
		}  
		return $users_List;
	}
	public function getCurrentTask($recordId){
		global $adb;
		$q = "SELECT count(*) as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and process_status = 2 group by unitprocessid";
		$result = $adb->pquery($q, array($recordId));
		return $adb->num_rows($result)+1;
	}

	public function getWaitingTasksCount($recordId){
		global $adb;
		//$adb->setDebug(true);
		$q = "SELECT count(*) as total FROM vtiger_processflow_unitprocess_instance where process_instanceid = ? and process_status = 4 group by unitprocessid";
		$result = $adb->pquery($q, array($recordId));
		return $adb->num_rows($result);
	}

	public function getProcessMasterData($pmid){
		global $adb;
		$q = "SELECT * FROM vtiger_processmaster where processmasterid = ?";
		$result = $adb->pquery($q,array($pmid));
		$result = $adb->fetch_array($result);
		return $result;

	}

	public function pf_array_count($array, $key, $value = NULL)
	{
		$c = 0;
		if (is_null($value)) {
			foreach ($array as $i => $subarray) {
				$c += ($subarray[$key] != '');
			}
		} else {
			foreach ($array as $i => $subarray) {
				$c += ($subarray[$key] == $value);
			}
		}
		return $c;
	}

	public function getProcessFlowUnitprocess($pid)
    { 
		global $adb;
		//$adb->setDebug(true);
       	# $sql = "SELECT u.unitprocessid,u.post_unitprocess, u.blocktype,u.description, u.unitprocess_time, ui.start_time,ui.end_time,ui.process_status, u.customicon, u.customform FROM vtiger_processflow_unitprocess u left join vtiger_processflow_unitprocess_instance ui on u.unitprocessid = ui.unitprocessid where u.processmasterid = ?  ORDER BY  u.sequence ASC " ; 
		$sql = "SELECT * FROM vtiger_processflow_unitprocess u where u.processmasterid = ?  ORDER BY  u.sequence ASC " ; 
		$result = $adb->pquery($sql,array($pid));
		$process_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$process_list[$data['unitprocessid']] = $data;   
			}
		} 
        return $process_list;
	}

	public function getProcessFlowUnitprocessInstance($recordId){
		global $adb; 
		$q = "SELECT distinct unitprocessid,unit_instanceid,start_time,end_time,process_status,process_iteration,unit_instance_data  FROM vtiger_processflow_unitprocess_instance where process_instanceid = ?";
		$result = $adb->pquery($q,array($recordId));
		$process_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				 
				$data['start_time'] = $this->convertTimeToUserTimezone($data['start_time']);
				$data['end_time'] = $this->convertTimeToUserTimezone($data['end_time']); 
				$process_list[$data['unitprocessid']] = $data;   
			}
		} 
        return $process_list;
	}

	public function convertTimeToUserTimezone($time){
		global $adb;
		$userid = $_SESSION['authenticated_user_id'];
		$sql= $adb->pquery("SELECT time_zone FROM vtiger_users where id = ?",array($userid));
		$timezone = $adb->fetch_array($sql);  
		//date_default_timezone_set('UTC');
		$datetime = new DateTime($time,new DateTimeZone('UTC')); 
	
		$la_time = new DateTimeZone($timezone['time_zone']);
		
		$datetime->setTimezone($la_time);
		return $datetime->format('Y-m-d H:i:s');
	}

	public function getBlockTypeList(){
		global $adb;
		$sql = "SELECT processblocktypeid ,blocktype_icon  FROM vtiger_process_block_types " ;
		$result = $adb->pquery($sql,array());
		$process_block_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$process_block_list[$data['processblocktypeid']] = $data['blocktype_icon'];   
			}
		}   
        return $process_block_list;
	}

	public function getProcessDetails($recordId)
	{
		global $adb; 
		$current_time = date('Y-m-d H:i:s');
		// SELECT *, timediff(NOW() , process_flow_start_time) AS elapsed_time FROM vtiger_processflow where processflowid = 93
		$sql = "SELECT *, timediff(? , process_flow_start_time) AS elapsed_time FROM vtiger_processflow where processflowid = ?" ;
		$result = $adb->pquery($sql,array($current_time,$recordId));        
        return $adb->fetch_array($result) ;
	}

	function getRoleidFromUserId($userid){
	 
		global $adb; 
		$sql = "SELECT roleid FROM `vtiger_user2role` where userid = ?" ;
		$result = $adb->pquery($sql,array($userid));        
		$data = $adb->fetch_array($result);
		return $data['roleid'];
	}

}