<?php

/**
 * VGS Gantt Charts Module
 *
 *
 * @package        VGS Gantt Charts Module
 * @author         Conrado Maggi
 * @license        Commercial
 * @copyright      2014 VGS Global - www.vgsglobal.com
 * @version        Release: 1.0
 */


class VGSGanttCharts_Module_Model extends Vtiger_Module_Model {

    function getQueryResult($request) {
        global $currentModule, $current_user, $adb;

        $forModule = $request->get('for_module');

        $customView = new CustomView($forModule);
        $viewid = $customView->getViewId($forModule);

        $selectedIds = $request->get('selected_ids');
        if (is_array($selectedIds) && count($selectedIds) > 0) {
            $selected_ids = '(' . implode(',', $selectedIds) . ')';
        }elseif($selectedIds != ''){
            $selected_ids = '(' . $selectedIds . ')';
        }


        $queryGenerator = new QueryGenerator($forModule, $current_user);
        if ($viewid != "0") {
            $queryGenerator->initForCustomViewById($viewid);
        } else {
            $queryGenerator->initForDefaultCustomView();
        }

        // Enabling Module Search
        $url_string = '';
        if ($_REQUEST['query'] == 'true') {
            $queryGenerator->addUserSearchConditions($_REQUEST);
            $ustring = getSearchURL($_REQUEST);
            $url_string .= "&query=true$ustring";
            $smarty->assign('SEARCH_URL', $url_string);
        }

        $list_query = $queryGenerator->getQuery();
        $where = $queryGenerator->getConditionalWhere();
        if (isset($where) && $where != '') {
            $_SESSION['export_where'] = $where;
        } else {
            unset($_SESSION['export_where']);
        }

        //Selected Ids
        if (!empty($selectedIds) && $forModule == 'Project') {
            $list_query .= ' AND vtiger_project.projectid IN ' . $selected_ids;
        } elseif (!empty($selectedIds) && $forModule == 'ProjectTask') {
            $list_query .= ' AND vtiger_projecttask.projecttaskid IN ' . $selected_ids;
        }

        // Sorting
        if (!empty($order_by)) {
            if ($order_by == 'smownerid')
                $list_query .= ' ORDER BY user_name ' . $sorder;
            else {
                $tablename = getTableNameForField($forModule, $order_by);
                $tablename = ($tablename != '') ? ($tablename . '.') : '';
                $list_query .= ' ORDER BY ' . $tablename . $order_by . ' ' . $sorder;
            }
        }


        $result = $adb->query($list_query);

        if ($adb->num_rows($result) > 0) {

            $projectList = array();
            for ($i = 0; $i < $adb->num_rows($result); $i++) {

                $projectList[] = $adb->query_result($result, $i, 'projectid');
            }
        }


        return array_unique($projectList);
    }

    function getProjectArray($projectId) {
        $db = PearDatabase::getInstance();
        $projectData = array();

        $result = $db->query("SELECT * FROM vtiger_project 
                        INNER JOIN vtiger_crmentity ON vtiger_project.projectid=vtiger_crmentity.crmid
                        WHERE vtiger_project.projectid = '$projectId'  AND vtiger_crmentity.deleted=0");

        if ($db->num_rows($result) > 0) {



            $data['id'] = $projectId;
            $data['start_date'] = $db->query_result($result, 0, 'startdate');
            $data['type'] = 'project';
            $data['duration'] = $this->calcTaskDuration($db->query_result($result, 0, 'startdate'), $db->query_result($result, 0, 'targetenddate'));
            $data['text'] = $db->query_result($result, 0, 'projectname');
            $progress = $db->query_result($result, 0, 'progress');
            if($progress == '100%'){
                $data['progress'] = 1;
            }  else {
                $data['progress'] = floatval(substr($progress, 0, 2)) / 100;
            }
            $data['open'] = 'true';
            $data['parent'] = '';

            array_push($projectData, $data);
        }
        return $projectData;
    }

    function getTaskArray($projectId, $forModule, $selected_ids) {
        $db = PearDatabase::getInstance();
        $tasksData = array();

        $sql = 'SELECT * FROM vtiger_project 
            INNER JOIN vtiger_projecttask ON vtiger_project.projectid=vtiger_projecttask.projectid
            INNER JOIN vtiger_crmentity ON vtiger_projecttask.projecttaskid=vtiger_crmentity.crmid
            WHERE vtiger_project.projectid = ? AND vtiger_crmentity.deleted=0';

        if ($forModule == 'ProjectTask' && $selected_ids != '') {
            $sql .= ' AND vtiger_projecttask.projecttaskid IN ' . $selected_ids;
        }

        $result = $db->pquery($sql, array($projectId));

        if ($db->num_rows($result) > 0) {

            for ($i = 0; $i < $db->num_rows($result); $i++) {

                $data['id'] = $db->query_result($result, $i, 'projecttaskid');
                $data['type'] = '';
                $data['start_date'] = $db->query_result($result, $i, 'startdate');
                $data['duration'] = $this->calcTaskDuration($db->query_result($result, $i, 'startdate'), $db->query_result($result, $i, 'enddate'));
                $data['text'] = $db->query_result($result, $i, 'projecttaskname');
                $progress = $db->query_result($result, $i, 'projecttaskprogress');
                if($progress == '100%'){
                    $data['progress'] = 1;
                }  else {
                    $data['progress'] = floatval(substr($progress, 0, 2)) / 100;
                }
                $data['open'] = 'true';
                $data['parent'] = $projectId;

                array_push($tasksData, $data);
            }
        }

        return $tasksData;
    }

    function getMilestoneArray($projectId, $forModule,$selected_ids) {
        $db = PearDatabase::getInstance();
        $milestoneData = array();

        if ($forModule == 'Project') {

            $result = $db->query("SELECT * FROM vtiger_projectmilestone
            INNER JOIN vtiger_crmentity ON vtiger_projectmilestone.projectmilestoneid=vtiger_crmentity.crmid
              WHERE vtiger_projectmilestone.projectid = '$projectId'  AND vtiger_crmentity.deleted=0");

            if ($db->num_rows($result) > 0) {

                for ($i = 0; $i < $db->num_rows($result); $i++) {

                    $data['id'] = $db->query_result($result, $i, 'projectmilestoneid');
                    $data['type'] = 'milestone';
                    $data['start_date'] = $db->query_result($result, $i, 'projectmilestonedate');
                    $data['text'] = $db->query_result($result, $i, 'projectmilestonename');
                    $data['open'] = 'true';
                    $data['progress'] = 0;
                    $data['parent'] = $projectId;

                    array_push($milestoneData, $data);
                }
            }
        } elseif ($forModule == 'ProjectTask' && $selected_ids != '') {

            //We add two dummy milestones to show when the project would eventyually start and finished

            $projectInfoResult = $db->pquery("SELECT vtiger_project.projectname,min(vtiger_projecttask.startdate) as projectstartdate, max(vtiger_projecttask.enddate) as projectenddate, vtiger_project.progress 
				FROM vtiger_project 
                                INNER JOIN vtiger_projecttask ON vtiger_project.projectid=vtiger_projecttask.projectid
                                INNER JOIN vtiger_crmentity ON vtiger_projecttask.projecttaskid=vtiger_crmentity.crmid
                                WHERE vtiger_project.projectid = ?  AND vtiger_crmentity.deleted=0", array($projectId));


            $data['id'] = rand(1000000, 10000000);
            $data['type'] = 'milestone';
            $data['start_date'] = date('Y-m-d', strtotime('-0 days', strtotime($db->query_result($projectInfoResult, 0, 'projectstartdate'))));
            $data['text'] = 'Project Start';
            $data['open'] = 'true';
            $data['progress'] = 0;
            $data['parent'] = $projectId;

            array_push($milestoneData, $data);

            $data['id'] = rand(1000000, 10000000);
            $data['type'] = 'milestone';
            $data['start_date'] = date('Y-m-d', strtotime('+1 days', strtotime($db->query_result($projectInfoResult, 0, 'projectenddate'))));
            $data['text'] = 'Project End';
            $data['open'] = 'true';
            $data['progress'] = 0;
            $data['parent'] = $projectId;

            array_push($milestoneData, $data);
        }

        return $milestoneData;
    }

    function calcTaskDuration($start, $end) {
        $start = strtotime($start);
        $end = strtotime($end);

        $duration = ($end - $start) / (24 * 60 * 60);

        return $duration + 1;
    }

}
