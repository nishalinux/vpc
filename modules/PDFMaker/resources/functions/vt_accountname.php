<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */

    function vtaccountname($orgid) {
		global $adb;
		if($orgid != '' && $orgid != '0' && $orgid != 0){
			return $adb->query_result($adb->pquery("select accountname from vtiger_account where accountid=?",array($orgid)),0,'accountname');
		}else{
			return '';
		}
       
    }


