<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */

if (!function_exists('vttable2')) {

    function vttable2() {
		global $adb;
		$recid = $_REQUEST['record'];
		$recmodel = Vtiger_Record_Model::getInstanceById($recid, "ACMPR");
		
	$row1 = explode("|##|",$recmodel->get('possession'));
	$row2 = explode("|##|",$recmodel->get('production'));
	$row3 = explode("|##|",$recmodel->get('sale_provision'));//Sale or Provision
	$row4 = explode("|##|",$recmodel->get('shipping'));
	$row5 = explode("|##|",$recmodel->get('transportation'));
	$row6 = explode("|##|",$recmodel->get('delivery'));//delhivery
	$row7 = explode("|##|",$recmodel->get('destruction'));//descrtuction
	

	$arraycheck = array('Dried Marihuana','Marihuana Plants','Marihuana Seeds','Cannabis Oil','Fresh Marihuana','Cannabis Other1');
	$row1 = array_map('trim', $row1);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row1))
		{
			$tddisplay1 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay1 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}	
//20
	$row2 = array_map('trim', $row2);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row2))
		{
			$tddisplay2 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay2 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}
	//38px
	$row3 = array_map('trim', $row3);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row3))
		{
			$tddisplay3 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay3 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}		
	//41px
	$row4 = array_map('trim', $row4);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row4))
		{
			$tddisplay4 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay4 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}
	//5px
	$row5 = array_map('trim', $row5);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row5))
		{
			$tddisplay5 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay5 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}		
	//6
	$row6 = array_map('trim', $row6);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row6))
		{
			$tddisplay6 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay6 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}	
	//7
	$row7 = array_map('trim', $row7);
	for($i=0;$i<5;$i++){
		if(in_array($arraycheck[$i],$row7))
		{
			$tddisplay7 .= '<td style="width:47px;height:49px;"><center>
			&#10004;</center>';
		}else{
			$tddisplay7 .='<td style="width:38px;height:49px;">&nbsp;</td>';
		}
	}	
		
		$html ='<table class="specialvertical">
	<tbody>
		<tr>
			<td rowspan="2" style="width:80px;height:47px;"><br />
			<strong>Activity</strong><br />
			<strong>Requested</strong></td>
			<td colspan="6" style="width:222px;height:47px;"><br />
			<strong>Substances Requested</strong></td>
			<td rowspan="2" style="width:148px;height:47px;"><br />
			<strong>Purpose</strong><br />
			<strong>(Specify for each activity and substance)</strong></td>
		</tr>
		<tr>
			<td style="width:18px;height:104px;padding:5px;" text-rotate="90"><strong>Dried</strong> <strong>Marihuana</strong></td>
			<td style="width:18px;height:104px;padding:5px;" text-rotate="90"><strong>Marihuana Plants</strong></td>
			<td style="width:18px;height:104px;padding:5px;" text-rotate="90"><strong>Marihuana</strong> <strong>Seeds</strong></td>
			<td style="width:18px;height:104px;padding:5px;" text-rotate="90"><strong>Cannabis Oil</strong></td>
			<td style="width:18px;height:104px;padding:5px;" text-rotate="90"><strong>Fresh Marihuana</strong></td>
			<td style="width:144px;height:104px;"><strong>Cannabis Other1</strong><br />
			(specify substance(s)<br />
			for each activity)</td>
		</tr>
		<tr>
			<td style="width:90px;height:49px;"><br />
			<strong>Possession</strong></td>
			'.$tddisplay1.'
			<td style="width:44px;height:49px;">'.$recmodel->get('possession_cannabis_other').'</td>
			<td style="width:134px;height:49px;">'.$recmodel->get('possession_purpose').'</td>
		</tr>
		<tr>
			<td style="width:90px;height:44px;"><br />
			<strong>Production</strong></td>'.$tddisplay2.'
			<td style="width:44px;height:44px;">'.$recmodel->get('production_cannabis_other').'</td>
			<td style="width:134px;height:44px;">'.$recmodel->get('production_purpose').'</td>
		</tr>
		<tr>
			<td style="width:90px;height:41px;"><strong>Sale or</strong><br />
			<strong>Provision</strong></td>
			'.$tddisplay3.'
			<td style="width:44px;height:41px;">'.$recmodel->get('sale_provision_cannabis_other').'</td>
			<td style="width:134px;height:41px;">'.$recmodel->get('sale_provision_purpose').'</td>
		</tr>
		<tr>
			<td style="width:90px;height:47px;"><br />
			<strong>Shipping</strong></td>
			'.$tddisplay4.'
			<td style="width:44px;height:47px;">'.$recmodel->get('shipping_cannabis_other').'</td>
			<td style="width:134px;height:47px;">'.$recmodel->get('shipping_purpose').'</td>
		</tr>
		<tr>
			<td style="width:90px;height:46px;"><br />
			<strong>Transportation</strong></td>'.$tddisplay5.'
			<td style="width:44px;height:46px;">'.$recmodel->get('transportation_cannabis_other').'</td>
			<td style="width:134px;height:46px;">'.$recmodel->get('transportation_purpose').'</td>
		</tr>
		<tr>
			<td style="width:90px;height:47px;"><br />
			<strong>Delivery</strong></td>'.$tddisplay6.'
			<td style="width:44px;height:47px;">'.$recmodel->get('delivery_cannabis_other').'</td>
			<td style="width:134px;height:47px;">'.$recmodel->get('delivery_purpose').'</td>
		</tr>
		<tr>
			<td style="width:90px;height:48px;"><br />
			<strong>Destruction</strong></td>'.$tddisplay7.'
			<td style="width:44px;height:48px;">'.$recmodel->get('destruction_cannabis_other').'</td>
			<td style="width:134px;height:48px;">'.$recmodel->get('destruction_purpose').'</td>
		</tr>
	</tbody>
</table>';
	return $html;      
    }

}
