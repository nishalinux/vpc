<?php

/* +***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * *********************************************************************************** */
require_once 'modules/ProcessFlow/RetrieveGridDetails.php';
class ProcessFlow_Detail_View extends Vtiger_Detail_View {

        public function showModuleDetailView(Vtiger_Request $request) {
			$recordId = $request->get('record');
			$moduleName = $request->getModule();

			$recordModel = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
			//TO DO, fill up from table
			global $adb;
			$pickBlocks = Array();
			$pickListsBlocks = Array();
			$pbResult = $adb->pquery("SELECT DISTINCT picklistfieldname FROM vtiger_pickblocks, vtiger_tab where vtiger_tab.tabid=vtiger_pickblocks.tabid and name= ?", Array($moduleName));
			while ($plrow = $adb->fetch_row($pbResult)){
				$picklistfieldname = $plrow["picklistfieldname"];
				$plbResult = $adb->pquery("SELECT * FROM vtiger_pickblocks, vtiger_tab where vtiger_tab.tabid=vtiger_pickblocks.tabid and name= ? and picklistfieldname=?", Array($moduleName, $picklistfieldname));
				while ($plbrow = $adb->fetch_row($plbResult)){
					$pickListsBlocks[$plbrow["picklistitem"]] = $plbrow["blockid"];
				}
				$pickBlocks[$picklistfieldname] = $pickListsBlocks;
				$pickListsBlocks = Array();
			}
			$pbResult = $adb->pquery("SELECT * from vtiger_dvpanels,vtiger_tab where vtiger_tab.tabid=vtiger_dvpanels.tabid and name= ?", Array($moduleName));
			$panelTabs = Array();
			while ($row = $adb->fetch_row($pbResult)){
				$panelTabs[$row["panellabel"]] = $row["blockids"];
			}
			$viewer = $this->getViewer($request);
			$viewer->assign('IMAGE_DETAILS', $recordModel->getImageDetails());
			$viewer->assign('GALLERY_DETAILS', $recordModel->getGalleryDetails());
			$viewer->assign('PANELTABS', $panelTabs);
			$viewer->assign('PICKBLOCKS', $pickBlocks);
			//die(print_r($recordModel->getImageDetails()));
			/*Manasa added on APR 15 2018 grids*/

			$grid1 = RetrieveGridDetails($recordId,'grid1');
			$grid2 = RetrieveGridDetails($recordId,'grid2');
			$grid3 = RetrieveGridDetails($recordId,'grid3');
			$grid4 = RetrieveGridDetails($recordId,'grid4');
			
			$module_model = new ProcessFlow_Record_Model();

			$gridinformation = $this->gridInformationByRecordid($recordId);
			$viewer->assign('GRIDINFORMATION', $gridinformation);

			$masterid = $this->getMasterid($recordId);
			$processlist = $this->getProcesslist($masterid, $recordId);
			$viewer->assign('PROCESSLIST', $processlist);

			$document = $this->getPFDocuments($recordId);
			$viewer->assign('DOCUMENT', $document);

			$process_instance_list = $this->getProcessFlowUnitprocessInstance($recordId);
			$viewer->assign('process_instance_list', $process_instance_list);

			$blocktype = $this->getBlockTypeList();
			$viewer->assign('BLOCKTYPE', $blocktype);
			$viewer->assign('RECORD_ID', $recordId);

			$viewer->assign('PROCESSFLOW_MODEL',$module_model);
			$viewer->assign('GRID1', $grid1);
			$viewer->assign('GRID2', $grid2);
			$viewer->assign('GRID3', $grid3);
			$viewer->assign('GRID4', $grid4);

			return parent::showModuleDetailView($request);
        }


	public function getHeaderScripts(Vtiger_Request $request) {
		$headerScriptInstances = parent::getHeaderScripts($request);
		$moduleName = $request->getModule();

		$jsFileNames = array(
			'~libraries/jquery/jquery.cycle.min.js',
		);

		$jsScriptInstances = $this->checkAndConvertJsScripts($jsFileNames);
		$headerScriptInstances = array_merge($headerScriptInstances, $jsScriptInstances);
		return $headerScriptInstances;
	}

	public function gridInformationByRecordid($recordId)
	{
		global $adb;
		$griddata=array();

		$mdata = "SELECT pg.*, CONCAT(u.first_name,' ',u.last_name) as fullname, pc.productcategory, p.productname FROM vtiger_processflow_grids pg LEFT JOIN vtiger_users u ON pg.issuedby = u.id LEFT JOIN vtiger_productcategory pc ON pg.productcategory = pc.productcategoryid LEFT JOIN vtiger_products p ON pg.productid = p.productid WHERE pg.processflowid=? AND pg.gridtype='grid1' order by pg.sequence";
		$mviewname_result = $adb->pquery($mdata, array($recordId));
		$m=0;
		while($mrow = $adb->FetchByAssoc($mviewname_result)){
			$griddata['Materials'][$m] = $mrow;
			$m++;
		}

		$vdata = "SELECT pg.*, CONCAT(u.first_name,' ',u.last_name) as fullname, pc.productcategory, a.assetname as productname FROM vtiger_processflow_grids pg LEFT JOIN vtiger_users u ON pg.issuedby = u.id LEFT JOIN vtiger_productcategory pc ON pg.productcategory = pc.productcategoryid LEFT JOIN vtiger_assets a ON pg.productid = a.assetsid WHERE pg.processflowid=? AND pg.gridtype='grid2' order by pg.sequence";
		$vviewname_result = $adb->pquery($vdata, array($recordId));
		$v=0;
		while($vrow = $adb->FetchByAssoc($vviewname_result)){
			$griddata['Vessels'][$v] = $vrow;
			$v++;
		}

		$tdata = "SELECT pg.*, CONCAT(u.first_name,' ',u.last_name) as fullname, pc.productcategory, a.assetname as productname FROM vtiger_processflow_grids pg LEFT JOIN vtiger_users u ON pg.issuedby = u.id LEFT JOIN vtiger_productcategory pc ON pg.productcategory = pc.productcategoryid LEFT JOIN vtiger_assets a ON pg.productid = a.assetsid WHERE pg.processflowid=? AND pg.gridtype='grid3' order by pg.sequence";
		$tviewname_result = $adb->pquery($tdata, array($recordId));
		$t=0;
		while($trow = $adb->FetchByAssoc($tviewname_result)){
			$griddata['Tools'][$t] = $trow;
			$t++;
		}
		
		$mcdata = "SELECT pg.*, CONCAT(u.first_name,' ',u.last_name) as fullname, pc.productcategory, a.assetname as productname FROM vtiger_processflow_grids pg LEFT JOIN vtiger_users u ON pg.issuedby = u.id LEFT JOIN vtiger_productcategory pc ON pg.productcategory = pc.productcategoryid LEFT JOIN vtiger_assets a ON pg.productid = a.assetsid WHERE pg.processflowid=? AND pg.gridtype='grid4' order by pg.sequence";
		$mcviewname_result = $adb->pquery($mcdata, array($recordId));
		$mc=0;
		while($mcrow = $adb->FetchByAssoc($mcviewname_result)){
			$griddata['Machinery'][$mc] = $mcrow;
			$mc++;
		}
		return $griddata;
	}

	public function getMasterid($recordId)
	{
		global $adb;
		$mcdata = "SELECT p.processmasterid FROM vtiger_processflow p WHERE p.processflowid=?";
		$mcviewname_result = $adb->pquery($mcdata, array($recordId));
		$mcrow = $adb->FetchByAssoc($mcviewname_result);
		return $mcrow['processmasterid'];
	}

	/*public function getProcesslist($masterid, $recordId)
	{
		global $adb;
		$mcdata = "SELECT pu.*, pui.* FROM vtiger_processflow_unitprocess pu LEFT JOIN vtiger_processflow_unitprocess_instance pui ON pu.unitprocessid = pui.unitprocessid WHERE pu.processmasterid=? AND pui.process_instanceid=? order by pu.sequence";
		$mcviewname_result = $adb->pquery($mcdata, array($masterid, $recordId));
		$processlist = array();
		$i=0;
		while($mcrow = $adb->FetchByAssoc($mcviewname_result)){
			$processlist[$i] = $mcrow;
			$i++;
		}
		
		return $processlist;
	}*/

	public function getProcesslist($masterid)
    { 
		global $adb;
		//$adb->setDebug(true);
       	# $sql = "SELECT u.unitprocessid,u.post_unitprocess, u.blocktype,u.description, u.unitprocess_time, ui.start_time,ui.end_time,ui.process_status, u.customicon, u.customform FROM vtiger_processflow_unitprocess u left join vtiger_processflow_unitprocess_instance ui on u.unitprocessid = ui.unitprocessid where u.processmasterid = ?  ORDER BY  u.sequence ASC " ; 
		$sql = "SELECT * FROM vtiger_processflow_unitprocess u where u.processmasterid = ?  ORDER BY  u.sequence ASC " ; 
		$result = $adb->pquery($sql,array($masterid));
		$process_list = array();
		if($adb->num_rows($result) >0 ){
			while($data = $adb->fetch_array($result)){
				$process_list[$data['unitprocessid']] = $data;   
			}
		} 
        return $process_list;
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

}
