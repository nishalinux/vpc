<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */
if (!function_exists('vttable4')) {

    function vttable4() {
	
		global $adb;
		$recid = $_REQUEST['record'];
		$recmodel = Vtiger_Record_Model::getInstanceById($recid, "ACMPR");

		$html = '<table class="table4">
			<tbody>
				<tr class="headerrow1">
					<td style="width:130px;height:31px;">&nbsp;</td>
					<td style="width:148px;height:31px;color:#ffffff;">Completed Security Clearance<br />
					Application Form:</td>
					<td style="width:338px;height:31px;color:#ffffff;">Completed Security Clearance Fingerprint Third Party<br />
					Consent to Release Personal Information form:</td>
				</tr>
				<tr>
					<td style="width:130px;height:49px;">Individual Applicant</td>
					<td style="width:148;height:49px;">';
					
					if($recmodel->get('individual_applicant') == '1'){
						$html .=  'Attached';
						$html .='</td>
						<td style="width:338px;height:49px;">
						<input type="checkbox" checked="checked" />
						submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
						<input type="checkbox" checked="checked" /> third party consent<br />
						<input type="checkbox" checked="checked" /> copy of valid photo identification</td>';
					}elseif($recmodel->get('individual_applicant') == '0'){
						$html .= 'To Followed';
						$html .='</td>
						<td style="width:338px;height:49px;">
						<input type="checkbox"  />
						submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
						<input type="checkbox"  /> third party consent<br />
						<input type="checkbox"  /> copy of valid photo identification</td>';
					}else{
						$html .= '';
						$html .='</td>
						<td style="width:338px;height:49px;">
						submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
						third party consent<br />
						copy of valid photo identification</td>';
					}
				$html .= '</tr>
				<tr>
					<td style="width:130px;height:48px;">Corporate<br />
					Applicant (Officers and Directors)</td>
					<td style="width:148px;height:48px;">';
					if($recmodel->get('officers_directors') == '1'){
						$html .= 'Attached</td><td style="width:338px;height:49px;"><input type="checkbox" checked="checked" /> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox" checked="checked" /> third party consent<br />
					<input type="checkbox" checked="checked" /> copy of valid photo identification</td>';
					}elseif($recmodel->get('officers_directors') == '0'){
						$html .= 'To Followed</td><td style="width:338px;height:49px;"><input type="checkbox"  /> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox"  /> third party consent<br />
					<input type="checkbox"  /> copy of valid photo identification</td>';
					}else{
						$html .= '</td><td style="width:338px;height:49px;">submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					 third party consent<br />
					copy of valid photo identification</td>';
					}
				
			$html .='	</tr>
				<tr>
					<td style="width:130px;height:48px;">Senior Person in<br />
					Charge</td>
					<td style="width:148px;height:48px;">';
					if($recmodel->get('spic') == '1'){
					$html .='Attached</td>
					<td style="width:338px;height:48px;"><input type="checkbox" checked="checked" /> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox" checked="checked" /> third party consent<br />
					<input type="checkbox" checked="checked" /> copy of valid photo identification</td>';
					}elseif($recmodel->get('spic') == '0'){
						$html .='To Followed</td>
					<td style="width:338px;height:48px;"><input type="checkbox"  /> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox"  /> third party consent<br />
					<input type="checkbox"  /> copy of valid photo identification</td>';
					}else{
						$html .='</td>
					<td style="width:338px;height:48px;"> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					third party consent<br />
					copy of valid photo identification</td>';
						
					}
			$html .='</tr>
				<tr>
					<td style="width:130px;height:48px;">Responsible<br />
					Person in Charge</td>
					<td style="width:148px;height:48px;">';
					if($recmodel->get('rpic') == '1'){
					$html .='Attached </td>
					<td style="width:338px;height:48px;"><input type="checkbox" checked="checked" />submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox" checked="checked" /> third party consent<br />
					<input type="checkbox" checked="checked" /> copy of valid photo identification</td>';
					}elseif($recmodel->get('rpic') == '0'){
						$html .='To Followed </td>
					<td style="width:338px;height:48px;"><input type="checkbox"  />submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox"  /> third party consent<br />
					<input type="checkbox"  /> copy of valid photo identification</td>';
					}else{
						$html .='</td>
					<td style="width:338px;height:48px;">submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					 third party consent<br />
					copy of valid photo identification</td>';
					}
				$html .='</tr>
				<tr>
					<td style="width:130px;height:70px;">Alternate Person(s)<br />
					in Charge</td>
					<td style="width:148px;height:70px;">';
					if($recmodel->get('arpic') == '1'){
				$html .='Attached </td>
					<td style="width:368px;height:70px;"><input type="checkbox" checked="checked" /> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox" checked="checked" /> third party consent<br />
					<input type="checkbox" checked="checked" /> copy of valid photo identification</td>';
					}elseif($recmodel->get('arpic') == '0'){
						$html .='To Followed</td>
					<td style="width:368px;height:70px;"><input type="checkbox"  /> submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					<input type="checkbox"  /> third party consent<br />
					<input type="checkbox"  /> copy of valid photo identification</td>';
					}else{
						$html .='</td>
					<td style="width:368px;height:70px;">submitted to a Canadian police force or a fingerprinting company accredited by the RCMP<br />
					 third party consent<br />
					copy of valid photo identification</td>';
					}
				$html .='</tr>
			</tbody>
		</table>';
	return $html;       
    }

}
