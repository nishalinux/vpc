<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

/**
 * Vtiger Menu Model Class
 */
class Vtiger_Menu_Model extends Vtiger_Module_Model {

    /**
     * Static Function to get all the accessible menu models with/without ordering them by sequence
     * @param <Boolean> $sequenced - true/false
     * @return <Array> - List of Vtiger_Menu_Model instances
     */
    public static function getAll($sequenced = false) {
        $currentUser = Users_Record_Model::getCurrentUserModel();
        $userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
        $restrictedModulesList = array('Emails', 'ProjectMilestone', 'ProjectTask', 'ModComments', 'ExtensionStore', 'ExtensionStorePro',
										'Integration', 'Dashboard', 'Home', 'vtmessages', 'vttwitter');

		
        $allModules = parent::getAll(array('0','2'));
		$menuModels = array();
        $moduleSeqs = Array();
        $moduleNonSeqs = Array();
        foreach($allModules as $module){
            if($module->get('tabsequence') != -1){
                $moduleSeqs[$module->get('tabsequence')] = $module;
            }else {
                $moduleNonSeqs[] = $module;
            }
        }
        ksort($moduleSeqs);
        $modules = array_merge($moduleSeqs, $moduleNonSeqs);

		foreach($modules as $module) {
            if (($userPrivModel->isAdminUser() ||
                    $userPrivModel->hasGlobalReadPermission() ||
                    $userPrivModel->hasModulePermission($module->getId()))& !in_array($module->getName(), $restrictedModulesList) && $module->get('parent') != '') {
                    $menuModels[$module->getName()] = $module;

            }
        }

        return $menuModels;
    }
	public static function gefftBreadcrumbs($pageTitle = false)
	{
		//$moduleName = $request->getModule();

		$breadcrumbs = false;
		$request = AppRequest::init();
		$userPrivModel = Users_Privileges_Model::getCurrentUserPrivilegesModel();
		$roleMenu = 'user_privileges/menu_' . filter_var($userPrivModel->get('roleid'), FILTER_SANITIZE_NUMBER_INT) . '.php';
		if (file_exists($roleMenu)) {
			require($roleMenu);
		} else {
			require('user_privileges/menu_0.php');
		}
		if (count($menus) == 0) {
			require('user_privileges/menu_0.php');
		}
		$moduleName = $request->getModule();
		$view = $request->get('view');
		$parent = $request->get('parent');
		if ($parent !== 'Settings') {
			if (empty($parent)) {
				foreach ($parentList as &$parentItem) {
					if ($moduleName == $parentItem['mod']) {
						$parent = $parentItem['parent'];
						break;
					}
				}
			}
			$parentMenu = self::getParentMenu($parentList, $parent, $moduleName);
			if (count($parentMenu) > 0) {
				$breadcrumbs = array_reverse($parentMenu);
			}
			$moduleModel = Vtiger_Module_Model::getInstance($moduleName);
			if ($moduleModel && $moduleModel->getDefaultUrl()) {
				$breadcrumbs[] = [
					'name' => vtranslate($moduleName, $moduleName),
					'url' => $moduleModel->getDefaultUrl()
				];
			} else {
				$breadcrumbs[] = [
					'name' => vtranslate($moduleName, $moduleName)
				];
			}

			if ($pageTitle) {
				$breadcrumbs[] = [ 'name' => vtranslate($pageTitle, $moduleName)];
			} elseif ($view == 'Edit' && $request->get('record') == '') {
				$breadcrumbs[] = [ 'name' => vtranslate('LBL_VIEW_CREATE', $moduleName)];
			} elseif ($view != '' && $view != 'index' && $view != 'Index') {
				$breadcrumbs[] = [ 'name' => vtranslate('LBL_VIEW_' . strtoupper($view), $moduleName)];
			} elseif ($view == '') {
				$breadcrumbs[] = [ 'name' => vtranslate('LBL_HOME', $moduleName)];
			}
			if ($request->get('record') != '') {
				$recordLabel = Vtiger_Functions::getCRMRecordLabel($request->get('record'));
				if ($recordLabel != '') {
					$breadcrumbs[] = [ 'name' => $recordLabel];
				}
			}
		} elseif ($parent === 'Settings') {
			$qualifiedModuleName = $request->getModule(false);
			$breadcrumbs[] = [
				'name' => vtranslate('LBL_VIEW_SETTINGS', $qualifiedModuleName),
				'url' => 'index.php?module=Vtiger&parent=Settings&view=Index',
			];
			if ($moduleName !== 'Vtiger' || $view !== 'Index') {
				$fieldId = $request->get('fieldid');
				$menu = Settings_Vtiger_MenuItem_Model::getAll();
				foreach ($menu as &$menuModel) {
					if (empty($fieldId)) {
						if ($menuModel->getModule() == $moduleName) {
							$parent = $menuModel->getMenu();
							$breadcrumbs[] = [ 'name' => vtranslate($parent->get('label'), $qualifiedModuleName)];
							$breadcrumbs[] = [ 'name' => vtranslate($menuModel->get('name'), $qualifiedModuleName),
								'url' => $menuModel->getUrl()
							];
							break;
						}
					} else {
						if ($fieldId == $menuModel->getId()) {
							$parent = $menuModel->getMenu();
							$breadcrumbs[] = [ 'name' => vtranslate($parent->get('label'), $qualifiedModuleName)];
							$breadcrumbs[] = [ 'name' => vtranslate($menuModel->get('name'), $qualifiedModuleName),
								'url' => $menuModel->getUrl()
							];
							break;
						}
					}
				}

				if (is_array($pageTitle)) {
					foreach ($pageTitle as $title) {
						$breadcrumbs[] = $title;
					}
				} else {
					if ($pageTitle) {
						$breadcrumbs[] = [ 'name' => vtranslate($pageTitle, $moduleName)];
					} elseif ($view == 'Edit' && $request->get('record') == '' && $request->get('parent_roleid') == '') {
						$breadcrumbs[] = [ 'name' => vtranslate('LBL_VIEW_CREATE', $qualifiedModuleName)];
					} elseif ($view != '' && $view != 'List') {
						$breadcrumbs[] = [ 'name' => vtranslate('LBL_VIEW_' . strtoupper($view), $qualifiedModuleName)];
					}
					if ($request->get('record') != '' && $moduleName == 'Users') {
						$recordLabel = \includes\fields\Owner::getUserLabel($request->get('record'));
						if ($recordLabel != '') {
							$breadcrumbs[] = [ 'name' => $recordLabel];
						}
					}
				}
			}
		}
		return $breadcrumbs;
	}


}
