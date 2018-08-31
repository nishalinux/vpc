<?php
 
class Project_Pfwidgets_View extends Vtiger_Index_View{
	
	public function checkPermission(Vtiger_Request $request) {
		 return true;
	}	
	public function process(Vtiger_Request $request) {
		 
		global $adb;
		$adb = PearDatabase::getInstance();
		//$adb->setDebug(true);
		$mode = $request->get('mode');	 
		$recordId = $request->get('record');	 
		$response = new Vtiger_Response();
        $createdon = time();
		switch ($mode) {
			case "PendingDecision":
				#Pending Decision
				$pd = "SELECT * from vtiger_processflow_unitprocess_instance pui LEFT JOIN vtiger_processflow_unitprocess pu ON pui.unitprocessid = pu.unitprocessid left join vtiger_processflow p on p.processflowid = pui.process_instanceid where pui.process_status = 1 and pu.blocktype = 2 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
				$pdresult = $adb->pquery($pd,array($recordId));
				$pendingdecision_arr = array();
				$i=1;
				?>
				<table style="width: 100%;">
					<tr>
						<th>S/No</th>
						<th>Process Flow Name</th>
						<th>Process Flow Start Time</th>
						<th>Process Flow End Time</th>
						<th>Process Status</th>
						<th>Process Name</th>
						<th>Learner Mode Details</th>
						<th>Assigned To</th>
					</tr>
				<?php

					while($pdlistitems = $adb->fetch_array($pdresult)) {
						
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $pdlistitems['processflowname']?></td>
							<td><?php echo $pdlistitems['process_flow_start_time']?></td>
							<td><?php echo $pdlistitems['process_flow_end_time']?></td>
							<td>In Progress</td>
							<td><?php echo $pdlistitems['description']?></td>
							<td><?php echo $pdlistitems['learnermodedetails']?></td>
							<td><?php echo $pdlistitems['assignedto']?></td>
						</tr>
						<?php
						$i++;
					}
				
				?>
				</table>
				<?php
				//echo json_encode($taskcompleted_arr);

			break;

			case "PendingApproval":
				#Pending Approval
				$pa = "SELECT * from vtiger_processflow_unitprocess_instance pui LEFT JOIN vtiger_processflow_unitprocess pu ON pui.unitprocessid = pu.unitprocessid left join vtiger_processflow p on p.processflowid = pui.process_instanceid where pui.process_status = 1 and pu.blocktype = 5 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
				$paresult = $adb->pquery($pa,array($recordId));
				$pendingapprovals_arr = array();
				$i=1;
				?>
				<table style="width: 100%;">
					<tr>
						<th>S/No</th>
						<th>Process Flow Name</th>
						<th>Process Flow Start Time</th>
						<th>Process Flow End Time</th>
						<th>Process Status</th>
						<th>Process Name</th>
						<th>Learner Mode Details</th>
						<th>Assigned To</th>
					</tr>
				<?php

					while($palistitems = $adb->fetch_array($paresult)) {
						switch($palistitems['process_status']){
							case '0' : 
								$process_status = "Not started";
							break;
							case '1' : 
								$process_status = "started";
							break;
							case '2' : 
								$process_status = "Completed";
							break;
							case '3' : 
								$process_status = "Interupted";
							break;
							case '4' : 
								$process_status = "Waiting for Branch Process";
							break;
							case '5' : 
								$process_status = "Aborted";
							break;
						}
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $pclistitems['processflowname']?></td>
							<td><?php echo $pclistitems['process_flow_start_time']?></td>
							<td><?php echo $pclistitems['process_flow_end_time']?></td>
							<td><?php echo $process_status;?></td>
							<td><?php echo $pclistitems['description']?></td>
							<td><?php echo $pclistitems['learnermodedetails']?></td>
							<td><?php echo $pclistitems['assignedto']?></td>
						</tr>
						<?php
						$i++;
					}
				?>
				</table>
				<?php
				//echo json_encode($taskcompleted_arr);

			break;

			case "TaskCompleted":
				$pc = "SELECT * from vtiger_processflow_unitprocess_instance pui left join vtiger_processflow_unitprocess pu on pu.unitprocessid = pui.unitprocessid left join vtiger_processflow p on p.processflowid = pui.process_instanceid where pui.process_status = 2 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)"; 
				$pcresult = $adb->pquery($pc,array($recordId));
				$taskcompleted_arr = array();
				$i=1;
				?>
				<table style="width: 100%;">
					<tr>
						<th>S/No</th>
						<th>Process Flow Name</th>
						<th>Process Flow Start Time</th>
						<th>Process Flow End Time</th>
						<th>Process Status</th>
						<th>Process Name</th>
						<th>Learner Mode Details</th>
						<th>Assigned To</th>
					</tr>
				<?php

					while($pclistitems = $adb->fetch_array($pcresult)) {
						switch($pclistitems['process_status']){
							case '0' : 
								$process_status = "Not started";
							break;
							case '1' : 
								$process_status = "started";
							break;
							case '2' : 
								$process_status = "Completed";
							break;
							case '3' : 
								$process_status = "Interupted";
							break;
							case '4' : 
								$process_status = "Waiting for Branch Process";
							break;
							case '5' : 
								$process_status = "Aborted";
							break;
						}
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $pclistitems['processflowname']?></td>
							<td><?php echo $pclistitems['process_flow_start_time']?></td>
							<td><?php echo $pclistitems['process_flow_end_time']?></td>
							<td><?php echo $process_status;?></td>
							<td><?php echo $pclistitems['description']?></td>
							<td><?php echo $pclistitems['learnermodedetails']?></td>
							<td><?php echo $pclistitems['assignedto']?></td>
						</tr>
						<?php
						$i++;
					}
				?>
				</table>
				<?php
				//echo json_encode($taskcompleted_arr);

			break;

			case "TotalTimeSpent":
			$pts = "SELECT p.processflowname, pu.description, pu.unitprocess_time, pui.start_time, pui.end_time,pui.process_status, CONCAT(u.first_name, ' ' ,u.last_name) as assignedname from vtiger_processflow_unitprocess_instance pui left join vtiger_processflow_unitprocess pu on pu.unitprocessid = pui.unitprocessid left join vtiger_processflow p on p.processflowid = pui.process_instanceid left join vtiger_users u on u.user_name = pu.assignedto where pui.process_status = 2 and pui.process_instanceid in (select pf.processflowid from vtiger_processflow pf left join vtiger_crmentity c on c.crmid = pf.processflowid  where c.deleted =0 and pf.pf_project_id = ?)";
			$ptsresult = $adb->pquery($pts,array($recordId));
			$pts_arr = array();
			$i=1;
				?>
				<table style="width: 100%;">
					<tr>
						<th>S/No</th>
						<th>Process Name</th>
						<th>Status</th>
						<th>Process FLow</th>
						<th>Start Time</th>
						<th>End Time</th>
						<th>Actual Time<br>hh:mm</th>
						<th>Time DIfference<br>hh:mm</th>
						<th>Assigned To</th>
					</tr>
				<?php

					while($ptslistitems = $adb->fetch_array($ptsresult)) {
						
						switch($ptslistitems['process_status']){
							case '0' : 
								$process_status = "Not started";
							break;
							case '1' : 
								$process_status = "started";
							break;
							case '2' : 
								$process_status = "Completed";
							break;
							case '3' : 
								$process_status = "Interupted";
							break;
							case '4' : 
								$process_status = "Waiting for Branch Process";
							break;
							case '5' : 
								$process_status = "Aborted";
							break;
						}

						$start_time = $ptslistitems['start_time'];
						$end_time = $ptslistitems['end_time'];
						$start  = date_create($start_time);
						$end 	= date_create($end_time); // Current time and date
						$diff  	= date_diff( $start, $end );
						$minutes = $diff->i;
						$hours = floor($minutes / 60);
						$min = $minutes - ($hours * 60);
						$time = $hours.":".$min;

						$pminutes = $ptslistitems['unitprocess_time'];
						$phours = floor($pminutes / 60);
						$pmin = $pminutes - ($phours * 60);
						$ptime = $phours.":".$pmin;
						
						?>
						<tr>
							<td><?php echo $i;?></td>
							<td><?php echo $ptslistitems['description'];?></td>
							<td><?php echo $process_status;?></td>
							<td><?php echo $ptslistitems['processflowname'];?></td>
							<td><?php echo $ptslistitems['start_time'];?></td>
							<td><?php echo $ptslistitems['end_time'];?></td>
							<td><?php echo $ptime;?></td>
							<td><?php echo $time;?></td>
							<td><?php echo $ptslistitems['assignedname']?></td>
						</tr>
						<?php
						$i++;
					}
				?>
				</table>
				<?php
				//echo json_encode($taskcompleted_arr);
			break;
				
			default:				 
		} 
         
        

	}	
	
}
		
