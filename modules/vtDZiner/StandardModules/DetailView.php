<?php
class ModelModule_DetailView_Model extends Vtiger_DetailView_Model {
	public function getDetailViewLinks(){
		$links = parent::getDetailViewLinks();
		$extralinks = $this->getDetailViewExtraLinks();
		if(count($extralinks) > 0){
			$links = array_merge_recursive($links, $extralinks);
		}
		return $links;
	}
	public function getDetailViewExtraLinks(){
		global $adb;
		//$adb->setDebug(true);
		$module = $_REQUEST['module'];
		$tabid=getTabid($module);
		$linkypes = array($tabid);
		$res = $adb->pquery("SELECT * FROM vtiger_links WHERE linktype in ('DETAILVIEWBASIC','DETAILVIEW','DETAILVIEWSETTING','DETAILVIEWTAB', 'DETAILVIEWWIDGET') and tabid=?",$linkypes);
		$noofrows = $adb->num_rows($res);
		for($i=0;$i<$noofrows;$i++){
			$detailViewLinks[] = array(
				'linktype' =>$adb->query_result($res, $i, 'linktype'),
				'linklabel' => $adb->query_result($res, $i, 'linklabel'),
				'linkurl' => $adb->query_result($res, $i, 'linkurl'),
				'linkicon' => $adb->query_result($res, $i, 'linkicon')
			);
		}
		
		foreach ($detailViewLinks as $detailViewLink) {
			$linkModelList[$detailViewLink['linktype']][] = Vtiger_Link_Model::getInstanceFromValues($detailViewLink);
		}
		return $linkModelList;
	}
	

} 
?>