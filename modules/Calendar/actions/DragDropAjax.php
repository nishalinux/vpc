<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Calendar_DragDropAjax_Action extends Calendar_SaveAjax_Action {
    
    function __construct() {
		$this->exposeMethod('updateDeltaOnResize');
        $this->exposeMethod('updateDeltaOnDrop');
	}
    
    public function process(Vtiger_Request $request) {  
		$mode = $request->getMode();
		if(!empty($mode) && $this->isMethodExposed($mode)) {
			$this->invokeExposedMethod($mode, $request);
			return;
		}

	}
    
    public function updateDeltaOnResize(Vtiger_Request $request){
        $moduleName = $request->getModule();
        $activityType = $request->get('activitytype');
        $recordId = $request->get('id');
        $dayDelta = $request->get('dayDelta');
        $minuteDelta = $request->get('minuteDelta');
        $actionname = 'EditView';
        
        $response = new Vtiger_Response();
        if(isPermitted($moduleName, $actionname, $recordId) === 'no'){
            $result = array('ispermitted'=>false,'error'=>false);
            $response->setResult($result);
            $response->emit();
        }
        else{
            $result = array('ispermitted'=>true,'error'=>false);
            $record = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
            $record->set('mode','edit');

            
            $oldDateTime[] = $record->get('due_date');
            $oldDateTime[] = $record->get('time_end');
            $oldDateTime = implode(' ',$oldDateTime);
            $resultDateTime = $this->changeDateTime($oldDateTime,$dayDelta,$minuteDelta);
            $parts = explode(' ',$resultDateTime);
            $record->set('due_date',$parts[0]);
            if(activitytype != 'Task')
                $record->set('time_end',$parts[1]);

			$inviteeslist =  $this->getInviteeList($recordId);
			
            $startDateTime[] = $record->get('date_start');
            $startDateTime[] = $record->get('time_start');
            $startDateTime = implode(' ',$startDateTime);
            $startDateTime = new DateTime($startDateTime);
            
            $endDateTime[] = $record->get('due_date');
            $endDateTime[] = $record->get('time_end');
            $endDateTime = implode(' ',$endDateTime);
            $endDateTime = new DateTime($endDateTime);
            //Checking if startDateTime is less than or equal to endDateTime
			$request->set('date_start', $record->get('date_start'));
			$request->set('time_start',$record->get('time_start'));
			$request->set('due_date',$parts[0]);
			$request->set('time_end',$parts[1]);
			$request->set('assignedtouser',$record->get('assigned_user_id'));

			$check = Calendar_CheckMeeting_action::CheckMeetingusers($request);
            if($startDateTime <= $endDateTime){
				if($check == 0){
					$record->save();
				}else{
					 $result = array('iserror'=>'scheduled event this time you or invitees.');
					 //$result['error'] = true;
				}
				
            }else{
                $result['error'] = true;
			}
           $response->setResult($result);
           $response->emit();
        }
    }
    //manasa has written this for invitee disaper
	public function getInviteeList($recordId){
		global $adb;
		$query = $adb->pquery("SELECT activityid, inviteeid FROM vtiger_invitees WHERE activityid=?",array($recordId));
		$rows = $adb->num_rows($query);
		$invitee = array();
		if($rows != 0){
			for($i=0;$i<$rows;$i++){
				$invitee[] = $adb->query_result($query,$i,'inviteeid');
			}
			return $invitee;
		}else{
			return '';
		}
	}
	public function insertInviteeList($recordId,$inviteeslist){
		global $adb;
		for($i=0;$i<count($inviteeslist);$i++){
			$query = $adb->pquery("insert into vtiger_invitees (`activityid`, `inviteeid`) values(?,?)",array($recordId,$inviteeslist[$i]));
		}
	}
	//manasa code ended here
    public function updateDeltaOnDrop(Vtiger_Request $request){
        $moduleName = $request->getModule();
        $activityType = $request->get('activitytype');
        $recordId = $request->get('id');
        $dayDelta = $request->get('dayDelta');
        $minuteDelta = $request->get('minuteDelta');
        $actionname = 'EditView';
        
        $response = new Vtiger_Response();
        if(isPermitted($moduleName, $actionname, $recordId) === 'no'){
            $result = array('ispermitted'=>false);          
            $response->setResult($result);
            $response->emit();
        }
        else{
            $result = array('ispermitted'=>true);
            $record = Vtiger_Record_Model::getInstanceById($recordId, $moduleName);
            $record->set('mode','edit');
			$inviteeslist =  $this->getInviteeList($recordId);
            $oldStartDateTime[] = $record->get('date_start');
            $oldStartDateTime[] = $record->get('time_start');
            $oldStartDateTime = implode(' ',$oldStartDateTime);
            $resultDateTime = $this->changeDateTime($oldStartDateTime,$dayDelta,$minuteDelta);
            $parts = explode(' ',$resultDateTime);
            $record->set('date_start',$parts[0]);
            $record->set('time_start',$parts[1]);

            $oldEndDateTime[] = $record->get('due_date');
            $oldEndDateTime[] = $record->get('time_end');
            $oldEndDateTime = implode(' ',$oldEndDateTime);
            $resultDateTime = $this->changeDateTime($oldEndDateTime,$dayDelta,$minuteDelta);
            $parts = explode(' ',$resultDateTime);
            $record->set('due_date',$parts[0]);

			$request->set('date_start', $newparts[0]);
			$request->set('time_start',$newparts[1]);
			$request->set('due_date',$parts[0]);
			$request->set('time_end',$parts[1]);
			$request->set('assignedtouser',$record->get('assigned_user_id'));

			$check = Calendar_CheckMeeting_action::CheckMeetingusers($request);

            if(activitytype != 'Task')
                $record->set('time_end',$parts[1]);  
           if($check == 0){
				$record->save();
			}else{
				   $result = array('iserror'=>'schduled event this time you or invitees.');
			}
			            
            $response->setResult($result);
            $response->emit();
        }
    }
    /* *
     * Function adds days and minutes to datetime string
     */
    public function changeDateTime($datetime,$daysToAdd,$minutesToAdd){
        $datetime = strtotime($datetime);
        $futureDate = $datetime+(60*$minutesToAdd)+(24*60*60*$daysToAdd);
        $formatDate = date("Y-m-d H:i:s", $futureDate);
        return $formatDate;
    }
    
}
?>
