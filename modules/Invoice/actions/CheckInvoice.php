<?php
/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

class Invoice_CheckInvoice_Action extends Vtiger_Action_Controller{
    function preProcess(Vtiger_Request $request) {
        return true;
    }
    public   function checkPermission(Vtiger_Request $request) {
        return ;
    }
	public function process(Vtiger_Request $request) {
        $mode=$request->get('mode');
        if($mode=='checkTotalGrams'){
            $result=$this->checkTotalGrams($request);
            $response = new Vtiger_Response();
            $response->setResult($result);
            $response->emit();
        }
	}
    function  checkTotalGrams(Vtiger_Request $request){
        global $adb;
        $info=array();
        $info['allow']=true;
        $info['msg']='test';

        $products=$request->get('products');
        $record=$request->get('record');
        $contactid=$request->get('contact_id');
        $invoicedate=$request->get('invoicedate');
        $invoicedate= date_create_from_format('m-d-Y',$invoicedate);

        if(empty($contactid)||empty($invoicedate)) return $info;

        $new_grams=0;
        foreach ($products as $product_id =>$quantity){
            $query="SELECT cf_920  FROM vtiger_products p INNER JOIN vtiger_productcf pf ON p.productid=pf.productid WHERE p.productid=?";
            $rs=$adb->pquery($query,array($product_id));
            $gram=$adb->query_result($rs,0,'cf_920');
            if($quantity!='' && $gram!=''){
                $grams=$gram*$quantity;
                $new_grams+=$grams;
            }
        }

        $query="SELECT cf.cf_759 as max, cd.support_start_date,cd.support_end_date,cf.cf_761 as left_on_prescription,
                cf.cf_767 as total_ordered_in_grams, cf.cf_996 as total_30day_orders
                FROM vtiger_contactscf cf INNER JOIN vtiger_contactdetails  c ON c.contactid=cf.contactid
                INNER JOIN vtiger_customerdetails cd ON cd.customerid=cf.contactid
                 WHERE cf.contactid=?";
        $rs=$adb->pquery($query,array($contactid));
        $max=$adb->query_result($rs,0,'max');
        $support_start_date=$adb->query_result($rs,0,'support_start_date');
        $support_start_date=date_create($support_start_date);
        $support_end_date=$adb->query_result($rs,0,'support_end_date');
        $support_end_date=date_create($support_end_date);

        $total_30day_orders=$adb->query_result($rs,0,'total_30day_orders');
        if($total_30day_orders=='') $total_30day_orders=0;
        $left_on_prescription=$adb->query_result($rs,0,'left_on_prescription');
        if($left_on_prescription=='') $left_on_prescription=0;

        //$total_ordered_in_grams=$adb->query_result($rs,0,'total_ordered_in_grams');
        //$invoicedate= date_create(strtotime($invoicedate) );

        if($invoicedate<$support_start_date) {
            //$info['allow']=true;
			$info['allow']=false;
            $info['msg']='Prescription as expired, please renew prescription';
            return $info;           
        }

        // different between suport start date and invoice date
        $diff=date_diff($support_start_date,$invoicedate, false);
        $days= $diff->format("%R%a");
        $number_30days=floor($days/30);
        if($number_30days==0){
            $perriod_start_day=$support_start_date;
        }else{
            $perriod_start_day= $support_start_date->add(DateInterval::createFromDateString(($number_30days*30).' days'));
        }
        $start_day=date_format($perriod_start_day,"Y-m-d");
        $perriod_end_day= $perriod_start_day->add(DateInterval::createFromDateString('30 days'));

        $end_day=date_format($perriod_end_day,"Y-m-d");
       // $info['test']='test '.$number_30days.' '.$start_day.' '.$end_day;

       /* if( $days> 30) {
            $info['allow']=true;
            return $info;
        }*/
        //check Max 30 day grams exceeded
        $currentmonth=date('m');
        $query="SELECT  sum(inp.quantity*pcf.cf_920) as total_grams FROM vtiger_invoice i
                    INNER JOIN vtiger_invoicecf icf ON i.invoiceid=icf.invoiceid
                    INNER JOIN vtiger_contactdetails c ON i.contactid=c.contactid
										INNER JOIN vtiger_inventoryproductrel inp ON i.invoiceid=inp.id
										INNER JOIN vtiger_productcf pcf ON inp.productid=pcf.productid
                    INNER JOIN vtiger_crmentity cr ON i.contactid=cr.crmid
                    WHERE cr.deleted=0 AND i.contactid=? AND i.invoicedate >= ? and i.invoicedate <= ? ";
        if(!empty($record)) $query.=' AND i.invoiceid !='.$record;

        $rs=$adb->pquery($query,array($contactid,$start_day,$end_day));
        $all_previous_sum_grams=$adb->query_result($rs,0,'total_grams');
        if($all_previous_sum_grams=='') $all_previous_sum_grams=0;

        $new_sum_total=$new_grams+$all_previous_sum_grams;
        if($new_sum_total>$max) /// rule 1
        {
            $info['allow']=false;
            $msg='Invoice Total Quantity Ordered exceeds Maximum 30 Day Order';
            $info['msg']=$msg;

        }else    /// rule 2
        {
			
              if($new_sum_total>$left_on_prescription){
                 $info['allow']=false;
                 $info['msg']='Invoice Total Quantity Ordered exceeds Left of Prescription Amount';
             }else      // rule 3
             {
				 $diff=date_diff($support_end_date,$invoicedate, false);
				$days= $diff->format("%R%a");
             if($days>0) {
                // if($invoicedate > $support_end_date) {
                     $info['allow']=false;
                     $info['msg']='Prescription as expired, please renew prescription';
                 }else{
                     $sql="UPDATE vtiger_contactscf SET cf_996=? WHERE contactid=?";
                     $adb->pquery($sql,array($new_sum_total,$contactid));
                 }

             }
        }

        return $info;
    }

}
