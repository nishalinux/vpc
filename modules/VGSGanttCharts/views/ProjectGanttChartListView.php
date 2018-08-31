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

include_once 'modules/VGSGanttCharts/models/VGSLicenseManager.php';

Class VGSGanttCharts_ProjectGanttChartListView_View extends Vtiger_ListAjax_View {

    function __construct() {
        parent::__construct();

        $this->exposeMethod('loadGanttData');
        $this->exposeMethod('updateTaskData');
        $this->exposeMethod('createTask');
    }

    function loadGanttData($request) {


        if (!aW8bgzsTs3Xp('VGSGanttCharts')) {
            return false;
        }    

        $selectedIds = $request->get('selected_ids');

        if (is_array($selectedIds) && count($selectedIds) > 0) {
            $selected_ids = '(' . implode(',', $selectedIds) . ')';
        } elseif ($selectedIds != '' && !is_array($selectedIds)) {
            $selected_ids = '(' . $selectedIds . ')';
        }

        $ganttModel = Vtiger_Module_Model::getInstance('VGSGanttCharts');

        $projectList = $ganttModel->getQueryResult($request);
        $data = array();
        foreach ($projectList as $projectId) {

            $taskArray = $ganttModel->getTaskArray($projectId, $request->get('for_module'), $selected_ids);
            $data = array_merge($data, $taskArray);

            $milestoneArray = $ganttModel->getMilestoneArray($projectId, $request->get('for_module'), $selected_ids);
            $data = array_merge($data, $milestoneArray);

            $projectArray = $ganttModel->getProjectArray($projectId);
            $data = array_merge($data, $projectArray);
        }

           usort($data, function($a, $b) {
            return $a['id'] - $b['id'];
        });

        $dataGantt = array(
            'data' => $data
        );


        echo json_encode($dataGantt);
    }

    function updateTaskData($request) {
        global $adb;
        $taskId = $request->get('task_id');
        $progress = round($request->get('progress') * 100, -1) . '%';
        $startDate = date('Y-m-d', $request->get('start_date'));
        $endDate = date('Y-m-d', $request->get('end_date'));

        $setType = getSalesEntityType($taskId);

        if ($setType == 'ProjectTask') {
            $query = ("UPDATE vtiger_projecttask SET projecttaskprogress=?,startdate=?,enddate=? WHERE projecttaskid=?");
            $params = array($progress, $startDate, $endDate, $taskId);
            $adb->pquery($query, $params);
        } elseif ($setType == 'ProjectMilestone') {
            $query = ("UPDATE vtiger_projectmilestone SET projectmilestonedate=? WHERE projectmilestoneid=?");
            $params = array($startDate, $taskId);
            $adb->pquery($query, $params);
        } else {
            $query = ("UPDATE vtiger_project SET progress=?,startdate=?,actualenddate=? WHERE projectid=?");
            $params = array($progress, $startDate, $endDate, $taskId);
            $adb->pquery($query, $params);
        }
    }

    function createTask($request) {
        global $adb;
        include_once 'modules/ProjectTask/ProjectTask.php';

        $projecttaskname = $request->get('projecttaskname');
        $projectId = $request->get('project_id');
        $progress = round($request->get('progress') * 100, -1) . '%';
        $startDate = date('Y-m-d', $request->get('start_date') + 86400);
        $endDate = date('Y-m-d', $request->get('end_date') + 86400);

        $focus_task = New ProjectTask();
        $focus_task->column_fields['projecttaskname'] = $projecttaskname;
        $focus_task->column_fields['projectid'] = $projectId;
        $focus_task->column_fields['projecttaskprogress'] = $progress;
        $focus_task->column_fields['startdate'] = $startDate;
        $focus_task->column_fields['enddate'] = $endDate;
        $focus_task->column_fields['assigned_user_id'] = $current_user->id;

        $focus_task->save('ProjectTask');

        if ($focus_task->id != '') {
            echo 'Success::' . $focus_task->id;
        } else {
            echo json_encode('error');
        }
    }

}
