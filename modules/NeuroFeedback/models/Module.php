<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ************************************************************************************/

class NeuroFeedback_Module_Model extends Vtiger_Module_Model {
	/**
	 * Function to get the Quick Links for the module
	 * @param <Array> $linkParams
	 * @return <Array> List of Vtiger_Link_Model instances
	 */
	public function getSideBarLinks($linkParams) {
		$parentQuickLinks = parent::getSideBarLinks($linkParams);

		$quickLink = array(
				'linktype' => 'SIDEBARLINK',
				'linklabel' => 'LBL_DASHBOARD',
				'linkurl' => $this->getDashBoardUrl(),
				'linkicon' => '',
		);

		//Check profile permissions for Dashboards
		$moduleModel = Vtiger_Module_Model::getInstance('Dashboard');
		$userPrivilegesModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$permission = $userPrivilegesModel->hasModulePermission($moduleModel->getId());
		if($permission) {
			$parentQuickLinks['SIDEBARLINK'][] = Vtiger_Link_Model::getInstanceFromValues($quickLink);
		}

		return $parentQuickLinks;
	}

	/**
	 * Function returns the Calendar Events for the module
	 * @param <Vtiger_Paging_Model> $pagingModel
	 * @return <Array>
	 */
	public function getCalendarActivities($mode, $pagingModel, $user, $recordId = false) {	}

	/**
	 * Function returns query for module record's search
	 * @param <String> $searchValue - part of record name (label column of crmentity table)
	 * @param <Integer> $parentId - parent record id
	 * @param <String> $parentModule - parent module name
	 * @return <String> - query
	 */
	function getSearchRecordsQuery($searchValue, $parentId=false, $parentModule=false) {
	}


	/**
	 * Function to get relation query for particular module with function name
	 * @param <record> $recordId
	 * @param <String> $functionName
	 * @param Vtiger_Module_Model $relatedModule
	 * @return <String>
	 */
	public function getRelationQuery($recordId, $functionName, $relatedModule) {
	}

	/**
	 * Function to get list view query for popup window
	 * @param <String> $sourceModule Parent module
	 * @param <String> $field parent fieldname
	 * @param <Integer> $record parent id
	 * @param <String> $listQuery
	 * @return <String> Listview Query
	 */
	public function getQueryByModuleField($sourceModule, $field, $record, $listQuery) {
	}

    public function getDefaultSearchField(){
        return "lastname";
    }

}