<?php
/* ********************************************************************************
 * The content of this file is subject to the Related Record Update ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */
require_once('modules/com_vtiger_workflow/VTEntityCache.inc');
require_once('modules/com_vtiger_workflow/VTWorkflowUtils.php');
require_once('data/CRMEntity.php');

class SumFieldTask extends VTTask {

    public $executeImmediately = true;
    public $total_sum_module = 'Contacts';

    public function getFieldNames() {
        return array('field_value_mapping');
    }
    public function getProductModule(){

        return Vtiger_Module_Model::getInstance('Products');
    }
    public function getTotalSumModule(){

        return Vtiger_Module_Model::getInstance($this->total_sum_module);
    }

    public function doTask($entity) {
        global $adb, $current_user, $default_charset;
        $util = new VTWorkflowUtils();
        $current_user = $util->loggedInUser();

        $moduleName = $entity->getModuleName();
        $entityId = $entity->getId();
        $recordId = vtws_getIdComponents($entityId);
        $recordId = $recordId[1];

        $fieldValueMapping = array();
        if (!empty($this->field_value_mapping)) {
            $fieldValueMapping = Zend_Json::decode($this->field_value_mapping);
        }
        if (!empty($fieldValueMapping) && count($fieldValueMapping) > 0) {

            foreach ($fieldValueMapping as $fieldInfo) {
                $sum_field =trim($fieldInfo['sum_field']);
                $update_field = trim($fieldInfo['update_field']);
                $total_modulename = trim($fieldInfo['total_modulename']);
                $total_field = trim($fieldInfo['total_field']);
                $total_sumby =trim($fieldInfo['total_sumby']);
            }


            $focus = CRMEntity::getInstance($moduleName);
            $focus->id = $recordId;
            $focus->retrieve_entity_info($recordId, $moduleName);
            //$relateid = $focus->column_fields['contactid'];

            // get sum
            $sql="SELECT sum(".$sum_field."*ip.quantity) as total FROM vtiger_inventoryproductrel ip INNER JOIN vtiger_invoice i ON ip.id=i.invoiceid
                        INNER JOIN vtiger_crmentity c ON ip.id=c.crmid
                        INNER JOIN vtiger_products p ON ip.productid=p.productid
                        INNER JOIN vtiger_productcf pcf ON ip.productid=pcf.productid
                        WHERE  c.deleted=0 AND ip.id=?";
            $rs=$adb->pquery($sql,array($recordId));
            $sumresult=$adb->query_result($rs,0,'total');

            //update sum to update_field

            $rs= $adb->pquery('SELECT tablename FROM vtiger_field WHERE fieldname=? and tabid=?',array($update_field,getTabid($moduleName)));
            $tablename=$adb->query_result($rs,0,'tablename');
            $sql="UPDATE $tablename SET $update_field=?  WHERE ".$focus->table_index."=?";
            $adb->pquery($sql,array($sumresult,$recordId));

            //======== update total sum by month to total field
            // get value of field related
            if($total_modulename!=''){
                $totalfocus = CRMEntity::getInstance($total_modulename);
                $rs= $adb->pquery('SELECT tablename FROM vtiger_field WHERE (fieldname=? OR columnname=?) and tabid=?',array($totalfocus->table_index,$totalfocus->table_index,getTabid($moduleName)));
                $tablename =$adb->query_result($rs,0,'tablename');
                $rs= $adb->pquery("SELECT ".$totalfocus->table_index ." FROM ". $tablename."  WHERE  ".$focus->table_index."=?",array($recordId));
                $relateid =$adb->query_result($rs,0,$totalfocus->table_index);

                $currentmonth=date('m');
                $strWhere='';
                if($total_sumby=='month'){
                    $strWhere .= " AND MONTH(i.invoicedate)='$currentmonth''";
                }
                $sql="SELECT sum(".$update_field.") as sumtotal FROM vtiger_invoice i
                    INNER JOIN vtiger_invoicecf icf ON i.invoiceid=icf.invoiceid
                    INNER JOIN vtiger_contactdetails c ON i.contactid=c.contactid
                    INNER JOIN vtiger_crmentity cr ON i.contactid=cr.crmid
                    WHERE cr.deleted=0 AND i.contactid=? $strWhere";
                $rs=$adb->pquery($sql,array($relateid));
                $sumtotal=$adb->query_result($rs,0,'sumtotal');

                $rs= $adb->pquery('SELECT tablename FROM vtiger_field WHERE fieldname=? and tabid=?',array($total_field,getTabid($total_modulename)));
                $tablename=$adb->query_result($rs,0,'tablename');
                $sql="UPDATE $tablename SET $total_field=?  WHERE ".$totalfocus->table_index."=?";
                $adb->pquery($sql,array($sumtotal,$relateid));
            }
        }
        $util->revertUser();
    }
}

?>