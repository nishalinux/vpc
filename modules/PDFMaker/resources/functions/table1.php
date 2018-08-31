<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */
if (!function_exists('vttable1')) {

    function vttable1() {
		global $adb;
		$recid = $_REQUEST['record'];
		$recmodel = Vtiger_Record_Model::getInstanceById($recid, "ACMPR");
		$data = "SELECT * FROM vtigress_acmpr_griddetails where acmprid=? ";
		$viewname_result = $adb->pquery($data, array($recid));
		$griddata=array();
		while($row = $adb->fetch_array($viewname_result)){ 
			$griddata['activities'][]=$row['activities'];
			$griddata['substance'][]= $row['substance'];
			$griddata['accountname'][]= $row['accountname'];
		}
		
		$fulldetails= $griddata;
	
		$html ='<table>
			<tbody>
				<tr>
					<td colspan="3" style="width:616px;height:32px;"><strong>Building Name/Number2:&nbsp;</strong>'.$buildame.'
					</td>
				</tr>
				<tr>
					<td colspan="3" style="width:616px;height:30px;">
					<strong>Activities in areas where cannabis is present</strong></td>
				</tr>
				<tr>
					<td style="width:144px;height:45px;"><strong>Room Name/Number2</strong><br />
					<strong>(per floor plan)</strong></td>
					<td style="width:236px;height:45px;"><br />
					<strong>Activities</strong></td>
					<td style="width:236px;height:45px;"><br />
					<strong>Substance(s)</strong></td>
				</tr>';
				for($k=0;$k<count($fulldetails['accountname']);$k++){
					$html .='<tr>
						<td style="width:144px;height:41px;">'.$fulldetails['accountname'][$k].'</td>
						<td style="width:236px;height:41px;">'.$fulldetails['activities'][$k].'</td>
						<td style="width:236px;height:41px;">'.$fulldetails['substance'][$k].'</td>
					</tr>';
				}
				
				
			$html .='</tbody>
		</table>';
		
	return $html;       
    }

}
