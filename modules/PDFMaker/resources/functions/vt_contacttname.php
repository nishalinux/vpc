<?php

/* A function to take a date in ($date) in specified date() format (eg mm/dd/yy for 12/08/10) and 
 * return date in $outFormat (eg d.m.Y for 20.10.1208; )
 *  datum $date - Datum containing the literal date that will be modified
 *  string $outFormat - String containing the desired date output, format the same as date()
 * 
 * [CUSTOMFUNCTION|datefmt|$INVOICE_DUEDATE$|d.m.Y|CUSTOMFUNCTION] 
 */

    function vtcontactname($contactid) {
		global $adb;
		if($contactid != '' && $contactid != '0' && $contactid != 0){
			return $adb->query_result($adb->pquery("SELECT concat(salutation,' ',firstname,' ',lastname) as name FROM vtiger_contactdetails WHERE contactid=?",array($contactid)),0,'name');
		}else{
			return ' ';
		}
       
    }


