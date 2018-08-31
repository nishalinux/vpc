<?php
class PickingSlip extends CRMEntity {
    var $log;
    var $db;
    var $table_name = "vtiger_pickingslip";
    var $table_index = 'pickingslipid';
    var $tab_name = Array('vtiger_crmentity', 'vtiger_pickingslip', 'vtiger_pickingslipcf','vtiger_inventoryproductrel');
    var $tab_name_index = Array('vtiger_crmentity' => 'crmid', 'vtiger_pickingslip' => 'pickingslipid', 'vtiger_pickingslipcf' => 'pickingslipid','vtiger_inventoryproductrel'=>'id');
    var $customFieldTable = Array('vtiger_pickingslipcf', 'pickingslipid');
    var $entity_table = "vtiger_crmentity";
    var $object_name = "PickingSlip";
    var $new_schema = true;
    var $update_product_array = Array();
    var $column_fields = Array();
    var $sortby_fields = Array('pickingslip_no', 'smownerid', 'createdtime');
    // This is used to retrieve related vtiger_fields from form posts.
    var $additional_column_fields = Array('smownerid', 'pickingslip_no');
    
    var $list_fields = Array(
        'PickingSlip No' => Array('pickingslip', 'pickingslip_no'),
        'Project' => Array('pickingslip' => 'projectid'),
        'Created Time' => Array('pickingslip' => 'createdtime'),
        'Assigned To' => Array('crmentity' => 'smownerid')
    );
    
    var $list_fields_name = Array(
        'PickingSlip No' => 'pickingslip_no',
        'Project' => 'projectid',
        'Created Time' => 'createdtime',
        'Assigned To' => 'assigned_user_id'
    );
    
    var $list_link_field = 'pickingslip_no';
    
    var $search_fields = Array(
        'PickingSlip No' => Array('pickingslip', 'pickingslip_no'),
        'Project' => Array('pickingslip', 'projectid'),
        'Created Time' => Array('pickingslip', 'createdtime'),
        'Assigned To' => Array('crmentity', 'smownerid')
    );
    var $search_fields_name = Array(
        'PickingSlip No' => 'pickingslip_no',
        'Project' => 'projectid',
        'Created Time' => 'createdtime',
        'Assigned To' => 'assigned_user_id'
    );
    
    var $required_fields = array();
    
    var $default_order_by = 'createdtime';
    var $default_sort_order = 'ASC';

    var $mandatory_fields = Array('pickingslip_no', 'createdtime', 'modifiedtime', 'assigned_user_id');
    var $def_basicsearch_col = 'pickingslip_no';
    var $isLineItemUpdate = true;

    /** 
     * Constructor Function for pickingslip class
     * This function creates an instance of LoggerManager class using getLogger method
     * creates an instance for PearDatabase class and get values for column_fields array of pickingslip class.
     */
    function PickingSlip() {
        $this->log = LoggerManager::getLogger('PickingSlip');
        $this->db = PearDatabase::getInstance();
        $this->column_fields = getColumnFields('PickingSlip');
    }

    function save_module($module) {
        $db = PearDatabase::getInstance();
        if ($_REQUEST['action'] != 'PickingSlipAjax' && $_REQUEST['ajxaction'] != 'DETAILVIEW' && $_REQUEST['action'] != 'MassEditSave' && $_REQUEST['action'] != 'ProcessDuplicates' && $_REQUEST['action'] != 'SaveAjax' && $this->isLineItemUpdate != false) {
            $recordModel = Vtiger_Record_Model::getInstanceById($this->id, 'PickingSlip');
            
            //get the old qty values for the products
            $oldRelatedProducts = $recordModel->getProducts();
                    
            saveInventoryProductDetails($this, 'PickingSlip');
            
            $newRelatedProducts = $recordModel->getProducts();
            
            //add the old products back into the product qty and then remove the new products
           /* foreach ($oldRelatedProducts as $key => $relatedProduct) {
                if($relatedProduct['qty'.$key]){
                    $productId = $relatedProduct['hdnProductId'.$key];
                    $result = $db->pquery("SELECT qtyinstock FROM vtiger_products WHERE productid=?", array($productId));
                    $qty = $db->query_result($result,0,"qtyinstock");
                    $stock = $qty + $relatedProduct['qty'.$key];
                    $db->pquery("UPDATE vtiger_products SET qtyinstock=? WHERE productid=?", array($stock, $productId));
                }
            }
            
            foreach ($newRelatedProducts as $key => $relatedProduct) {
                if($relatedProduct['qty'.$key]){
                    $productId = $relatedProduct['hdnProductId'.$key];
                    $result = $db->pquery("SELECT qtyinstock FROM vtiger_products WHERE productid=?", array($productId));
                    $qty = $db->query_result($result,0,"qtyinstock");
                    $stock = $qty - $relatedProduct['qty'.$key];
                    $db->pquery("UPDATE vtiger_products SET qtyinstock=? WHERE productid=?", array($stock, $productId));
                }
            }*/
        }
    }

    /** 
     * Function to get activities associated with the Picking Slip
     * This function accepts the id as arguments and execute the MySQL query using the id
     * and sends the query and the id as arguments to renderRelatedActivities() method
     */
    function get_activities($id, $cur_tab_id, $rel_tab_id, $actions = false) {
        global $log, $singlepane_view, $currentModule, $current_user;
        $log->debug("Entering get_activities(" . $id . ") method ...");
        $this_module = $currentModule;

        $related_module = vtlib_getModuleNameById($rel_tab_id);
        require_once("modules/$related_module/Activity.php");
        $other = new Activity();
        vtlib_setup_modulevars($related_module, $other);
        $singular_modname = vtlib_toSingular($related_module);

        $parenttab = getParentTab();

        if ($singlepane_view == 'true')
            $returnset = '&return_module=' . $this_module . '&return_action=DetailView&return_id=' . $id;
        else
            $returnset = '&return_module=' . $this_module . '&return_action=CallRelatedList&return_id=' . $id;

        $button = '';

        $button .= '<input type="hidden" name="activity_mode">';

        if ($actions) {
            if (is_string($actions))
                $actions = explode(',', strtoupper($actions));
            if (in_array('ADD', $actions) && isPermitted($related_module, 1, '') == 'yes') {
                if (getFieldVisibilityPermission('Calendar', $current_user->id, 'parent_id', 'readwrite') == '0') {
                    $button .= "<input title='" . getTranslatedString('LBL_NEW') . " " . getTranslatedString('LBL_TODO', $related_module) . "' class='crmbutton small create'" .
                            " onclick='this.form.action.value=\"EditView\";this.form.module.value=\"$related_module\";this.form.return_module.value=\"$this_module\";this.form.activity_mode.value=\"Task\";' type='submit' name='button'" .
                            " value='" . getTranslatedString('LBL_ADD_NEW') . " " . getTranslatedString('LBL_TODO', $related_module) . "'>&nbsp;";
                }
            }
        }

        $userNameSql = getSqlForNameInDisplayFormat(array('first_name' =>
            'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');
        $query = "SELECT case when (vtiger_users.user_name not like '') then $userNameSql else vtiger_groups.groupname end as user_name,vtiger_contactdetails.lastname, vtiger_contactdetails.firstname, vtiger_contactdetails.contactid, vtiger_activity.*,vtiger_seactivityrel.crmid as parent_id,vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_crmentity.modifiedtime from vtiger_activity inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_activity.activityid left join vtiger_cntactivityrel on vtiger_cntactivityrel.activityid= vtiger_activity.activityid left join vtiger_contactdetails on vtiger_contactdetails.contactid = vtiger_cntactivityrel.contactid left join vtiger_users on vtiger_users.id=vtiger_crmentity.smownerid left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid where vtiger_seactivityrel.crmid=" . $id . " and activitytype='Task' and vtiger_crmentity.deleted=0 and (vtiger_activity.status is not NULL and vtiger_activity.status != 'Completed') and (vtiger_activity.status is not NULL and vtiger_activity.status !='Deferred')";

        $return_value = GetRelatedList($this_module, $related_module, $other, $query, $button, $returnset);

        if ($return_value == null)
            $return_value = Array();
        $return_value['CUSTOM_BUTTON'] = $button;

        $log->debug("Exiting get_activities method ...");
        return $return_value;
    }

    /** 
     * Function to get the activities history associated with the Picking Slip
     * This function accepts the id as arguments and execute the MySQL query using the id
     * and sends the query and the id as arguments to renderRelatedHistory() method
     */
    function get_history($id) {
        global $log;
        $log->debug("Entering get_history(" . $id . ") method ...");
        $userNameSql = getSqlForNameInDisplayFormat(array('first_name' =>
            'vtiger_users.first_name', 'last_name' => 'vtiger_users.last_name'), 'Users');
        
        $query = "SELECT vtiger_contactdetails.lastname, vtiger_contactdetails.firstname,
			vtiger_contactdetails.contactid,vtiger_activity.*, vtiger_seactivityrel.*,
			vtiger_crmentity.crmid, vtiger_crmentity.smownerid, vtiger_crmentity.modifiedtime,
			vtiger_crmentity.createdtime, vtiger_crmentity.description, case when
			(vtiger_users.user_name not like '') then $userNameSql else vtiger_groups.groupname
			end as user_name from vtiger_activity
				inner join vtiger_seactivityrel on vtiger_seactivityrel.activityid=vtiger_activity.activityid
				inner join vtiger_crmentity on vtiger_crmentity.crmid=vtiger_activity.activityid
				left join vtiger_cntactivityrel on vtiger_cntactivityrel.activityid= vtiger_activity.activityid
				left join vtiger_contactdetails on vtiger_contactdetails.contactid = vtiger_cntactivityrel.contactid
                                left join vtiger_groups on vtiger_groups.groupid=vtiger_crmentity.smownerid
				left join vtiger_users on vtiger_users.id=vtiger_crmentity.smownerid
                where activitytype='Task'
				and (vtiger_activity.status = 'Completed' or vtiger_activity.status = 'Deferred')
				and vtiger_seactivityrel.crmid=" . $id . "
                                and vtiger_crmentity.deleted = 0";
        //Don't add order by, because, for security, one more condition will be added with this query in include/RelatedListView.php

        $log->debug("Exiting get_history method ...");
        return getHistory('PickingSlip', $query, $id);
    }

    function insertIntoEntityTable($table_name, $module, $fileid = '') {
        //Ignore relation table insertions while saving of the record
        if ($table_name == 'vtiger_inventoryproductrel') {
            return;
        }
        parent::insertIntoEntityTable($table_name, $module, $fileid);
    }

    /**
     * Function to create records in current module.
     * This function called while importing records to this module
     */

    function createRecords($obj) {
        $createRecords = createRecords($obj);
        return $createRecords;
    }
    
    /**
     * Function to return the status count of imported records in current module.
     * This function called while importing records to this module
     */

    function getImportStatusCount($obj) {
        $statusCount = getImportStatusCount($obj);
        return $statusCount;
    }

    function undoLastImport($obj, $user) {
        $undoLastImport = undoLastImport($obj, $user);
    }
}
