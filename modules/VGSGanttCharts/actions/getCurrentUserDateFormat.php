<?php

class VGSGanttCharts_getCurrentUserDateFormat_Action extends Vtiger_Action_Controller {

    public function checkPermission(Vtiger_Request $request) {
        return true;
    }

    public function process(Vtiger_Request $request) {

        $currentUser = Users_Record_Model::getCurrentUserModel();
        
        switch ($currentUser->get('date_format')) {
            case 'mm-dd-yyyy':
                $dateFormat = '%m-%d-%Y';

                break;
            case 'yyyy-mm-dd':
                $dateFormat = '%Y-%m-%d';

                break;

            default:
                $dateFormat = '%d-%m-%Y';
                
                break;
        }

        $response = new Vtiger_Response();
        $response->setResult($dateFormat);
        $response->emit();
    }

}
