<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */
if (!function_exists('ARPICTable')) {

    function ARPICTable() {
	
		global $adb,$current_user;
		//$dateformat = $current_user->date_format;
		$recid = $_REQUEST['record'];
		$data = "SELECT * FROM vtigress_arpic_griddetails where acmprid=? ";
		$viewname_result = $adb->pquery($data, array($recid));
		$griddata=array();
		while($row = $adb->fetch_array($viewname_result)){ 
			 $contid = $row['contactid'];
			 $status = $adb->num_rows($adb->pquery("select * from vtiger_crmentity where crmid=? and deleted=0",array($contid)));
			 if($status != 0){
				$recmodel = Vtiger_Record_Model::getInstanceById($contid, "Contacts");
				$display['contactname'] = $recmodel->get('salutation').' '.$recmodel->get('firstname').' '.$recmodel->get('lastname');
				$display['lastname'] = $recmodel->get('lastname');
				$display['firstname'] = $recmodel->get('firstname');
				$display['gender'] = $recmodel->get('gender');
				if($recmodel->get('birthday') != '' && $recmodel->get('birthday') != null){
					$display['birthday'] = date('Y/m/d',strtotime($recmodel->get('birthday')));
				}else{
					$display['birthday'] = '';
				}
				
				$display['workedhours'] = $recmodel->get('arpic_work_hours_days');
				$display['title'] = $recmodel->get('title');
				$display['othertitle'] = $recmodel->get('arpic_other_title');	
			 }
			 $griddata[]= $display;
		}
		$html = '';
for($k=0;$k<count($griddata);$k++){
		$html .= '<table>
	<tbody>
		<tr>
			<td colspan="2" style="width:100px;height:24px;">Surname</td>
			<td colspan="2" style="width:110px;height:24px;">'.$griddata[$k]['lastname'].'</td>
			<td style="width:97px;height:24px;">Given Name(s)</td>
			<td style="width:117px;height:24px;">'.$griddata[$k]['firstname'].'</td>
		</tr>
		<tr>
			<td colspan="2" style="width:100px;height:24px;">Gender</td>
			<td colspan="2" style="width:110px;height:24px;">'.$griddata[$k]['gender'].'</td>
			<td style="width:97px;height:24px;">Date of Birth<br />
			(YYYY/MM/DD)</td>
			<td style="width:237px;height:24px;">'.$griddata[$k]['birthday'].'</td>
		</tr>
		<tr>
			<td colspan="3" style="width:144px;height:43px;">Proposed Schedule &ndash;<br />
			Work Hours and Days<br />
			(e.g. 8am &ndash; 4pm, Mon &ndash; Fri)</td>
			<td colspan="3" style="width:351px;height:43px;">'.$griddata[$k]['workedhours'].'</td>
		</tr>
		<tr>
			<td colspan="3" style="width:144px;height:38px;">Ranking<br />
			(e.g. 1st A/RPIC, 2nd A/RPIC, etc.)</td>
			<td colspan="3" style="width:351px;height:38px;">'.$griddata[$k]['title'].'</td>
		</tr>
		<tr>
			<td style="width:90px;height:24px;">Other Title</td>
			<td colspan="5" style="width:404px;height:24px;">'.$griddata[$k]['othertitle'].'</td>
		</tr>
	</tbody>
</table><br/>
';
	}
	return $html;       
    }

}
