<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */
if (!function_exists('PersonTable')) {

    function PersonTable() {
	
		global $adb,$current_user;
		//$dateformat = $current_user->date_format;
		$recid = $_REQUEST['record'];
		$data = "SELECT * FROM vtigress_person_griddetails where acmprid=? ";
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
			 }
			 $griddata[]= $display;
		}
		$html = '<table>
			<tbody>
				<tr>
					<td style="width:256px;height:25px;">Surname</td>
					<td style="width:217px;height:25px;">Given Name(s)</td>
					<td style="width:180px;height:25px;">Gender</td>
				</tr>';
				
		for($k=0;$k<count($griddata);$k++){
			$l = $k+1;
				$html .= '<tr>
					<td style="width:256px;height:24px;">'.$l.')'.$griddata[$k]['lastname'].'</td>
					<td style="width:217px;height:24px;">'.$griddata[$k]['firstname'].'</td>
					<td style="width:180px;height:24px;">'.$griddata[$k]['gender'].'</td>
				</tr>';
		}
		$html .='</tbody>
		</table>';
	return $html;       
    }

}
