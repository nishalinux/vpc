<?php
/*********************************************************************************
 * The content of this file is subject to the PDF Maker license.
 * ("License"); You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is IT-Solutions4You s.r.o.
 * Portions created by IT-Solutions4You s.r.o. are Copyright(C) IT-Solutions4You s.r.o.
 * All Rights Reserved.
 * *******************************************************************************/

class PDFMaker_Display_Model extends Vtiger_Base_Model {
    
    public function __construct() {
        $this->db = PearDatabase::GetInstance();
    }    
    public function CheckDisplayConditions($pdftemplateResult,$Entry,$formodule){
        
        $v = true;
        
        $Fields = array();
        
        if ($formodule == "Calendar"){
            $Fields[] = "activitytype";
        } 
        if ($pdftemplateResult["conditions"] != "") {
            $Load_Conditions = Zend_Json::decode(decode_html($pdftemplateResult["conditions"]));
            $Conditions = $this->transformConditionsToFilter($Load_Conditions);
            
            $displayed = $pdftemplateResult["displayed"];
            if ($displayed == "1") $v = false; 

            if (count($Conditions) > 0) {
                //print_r($Conditions);
                foreach ($Conditions AS $condition) {
                    list($columntable, $columnname, $fieldname, $label, $columntype) = explode(":",$condition['fieldname']);
                    if ($fieldname == "folderid" && $formodule == "Documents") $loadDocuments = true;
                    if (!in_array($fieldname, $Fields)) $Fields[] = $fieldname;
                }    
 

                $DisplayModel = PDFMaker_Display_Model::getInstance($formodule, '0', $Fields);
                $QueryGenerator = $DisplayModel->get("query_generator");
                $meta = $QueryGenerator->getMeta($QueryGenerator->getModule());
                $moduleFields = $meta->getModuleFields();

                if (!$this->evaluate($formodule, $Conditions, $Entry, $moduleFields)){                   
                    if ($displayed == "1") 
                        $v = true;
                    else 
                        $v = false;
                } 
            } 
        }
        return $v;           
    }
    public static function getInstance($moduleName, $viewId='0', $New_Fields) {
        $db = PearDatabase::getInstance();
        $currentUser = vglobal('current_user');

        $modelClassName = Vtiger_Loader::getComponentClassName('Model', 'ListView', $moduleName);
        $instance = new $modelClassName();
        $moduleModel = Vtiger_Module_Model::getInstance($moduleName);
        $queryGenerator = new QueryGenerator($moduleModel->get('name'), $currentUser);
        $customView = new CustomView();
        if (!empty($viewId) && $viewId != "0") {
                $queryGenerator->initForCustomViewById($viewId);
                $viewId = $customView->getViewId($moduleName);
        } else {
                $viewId = $customView->getViewId($moduleName);
                if(!empty($viewId) && $viewId != 0) {
                        $queryGenerator->initForDefaultCustomView();
                } else {
                        $entityInstance = CRMEntity::getInstance($moduleName);
                        $listFields = $entityInstance->list_fields_name;
                        $listFields[] = 'id';
                        $queryGenerator->setFields($listFields);
                }
        }
        $controller = new ListViewController($db, $currentUser, $queryGenerator);

        if (count($New_Fields) > 0) {
            $Fields = $queryGenerator->getFields();
            
            foreach ($New_Fields AS $add_fieldname) {
                if (!in_array($add_fieldname,$Fields)) $Fields[] = $add_fieldname; 
            }    
            $queryGenerator->setFields($Fields);
        }        
        return $instance->set('module', $moduleModel)->set('query_generator', $queryGenerator)->set('listview_controller', $controller);
    }
    function evaluate($row_module, $expr, $entityData, $moduleFields){
        $finalResult = TRUE;
        if (is_array($expr)){
            $data = $entityData->getData();
            $groupResults = array();
            $expressionResults = array();
            $i = 0;
            foreach ($expr as $cond) {
                $conditionGroup = $cond['groupid'];
                if (empty($conditionGroup))
                        $conditionGroup = 0;
                 
                $expressionResults[$conditionGroup][$i]['result'] = $this->checkCondition($row_module, $entityData, $cond, $moduleFields);
                $expressionResults[$conditionGroup][$i + 1]['logicaloperator'] = (!empty($cond['joincondition'])) ? $cond['joincondition'] : 'and';
                $groupResults[$conditionGroup]['logicaloperator'] = (!empty($cond['groupjoin'])) ? $cond['groupjoin'] : 'and';
                $i++;
            }

            foreach ($expressionResults as $groupId => $groupExprResultSet) {
                $groupResult = TRUE;
                foreach ($groupExprResultSet as $exprResult) {
                    $result = $exprResult['result'];
                    $logicalOperator = $exprResult['logicaloperator'];
                    if (isset($result)) { // Condition to skip last condition
                        if (!empty($logicalOperator)) {
                                switch ($logicalOperator) {
                                        case 'and' : $groupResult = ($groupResult && $result);
                                                break;
                                        case 'or' : $groupResult = ($groupResult || $result);
                                                break;
                                }
                        } else { // Case for the first condition
                                $groupResult = $result;
                        }
                    }
                }
                $groupResults[$groupId]['result'] = $groupResult;
            }
            foreach ($groupResults as $groupId => $groupResult) {
                $result = $groupResult['result'];
                $logicalOperator = $groupResult['logicaloperator'];
                if (isset($result)) { // Condition to skip last condition
                    if (!empty($logicalOperator)) {
                        switch ($logicalOperator) {
                                case 'and' : $finalResult = ($finalResult && $result);
                                        break;
                                case 'or' : $finalResult = ($finalResult || $result);
                                        break;
                        }
                    } else { // Case for the first condition
                            $finalResult = $result;
                    }
                }
            }
        }
        return $finalResult;
    }
    function startsWith($str, $subStr) {
        $sl = strlen($str);
        $ssl = strlen($subStr);
        if ($sl >= $ssl) {
                return substr_compare($str, $subStr, 0, $ssl) == 0;
        } else {
                return FALSE;
        }
    }
    function endsWith($str, $subStr) {
        $sl = strlen($str);
        $ssl = strlen($subStr);
        if ($sl >= $ssl) {
                return substr_compare($str, $subStr, $sl - $ssl, $ssl) == 0;
        } else {
                return FALSE;
        }
    }
    function checkCondition($row_module, $entityData, $cond, $moduleFields, $referredEntityData=null) {
        $data = $entityData->getData();
        $Strip_Tags_Fields = array("reference", "url", "email");
        $condition = $cond['operation'];
        $field_data_type = "";
        $field_uitype = "";
        list($columntable, $columnname, $fieldname, $label, $columntype) = explode(":",$cond['fieldname']);

        if (isset($moduleFields[$fieldname])) {
            $fieldModel = $moduleFields[$fieldname];
            $field_data_type = $fieldModel->getFieldDataType();
        }

        if ($row_module == "Events" && $fieldname == "eventstatus"){
            $fieldValue = $data["taskstatus"];
        } elseif ($row_module == "Documents" && $fieldname == "folderid" && isset($this->Att_Folders[$fieldValue])){
            $fieldValue = $this->Att_Folders[$fieldValue];
        } else {   
            $fieldValue = $data[$fieldname];
        }

        $old_fieldValue = $fieldValue;
        $fieldValue = strip_tags($fieldValue);

        if (is_array($cond['value'])){ 
            $value = implode(",",$cond['value']);
        } else {    
            $value = trim(html_entity_decode($cond['value']));
        }
        $expressionType = $cond['valuetype'];

        if ($expressionType == 'fieldname'){
            if ($referredEntityData != null){
                $referredData = $referredEntityData->getData();
            } else {
                $referredData = $data;
            }
            $value = $referredData[$value];
        } elseif ($expressionType == 'expression'){
            require_once 'modules/com_vtiger_workflow/expression_engine/include.inc';

            $parser = new VTExpressionParser(new VTExpressionSpaceFilter(new VTExpressionTokenizer($value)));
            $expression = $parser->expression();
            $exprEvaluater = new VTFieldExpressionEvaluater($expression);
            if ($referredEntityData != null) {
                    $value = $exprEvaluater->evaluate($referredEntityData);
            } else {
                    $value = $exprEvaluater->evaluate($entityData);
            }
        }

        global $current_user;

        if($fieldValue != "" && $field_data_type == 'datetime'){
            //Convert the DB Date Time Format to User Date Time Format
            $date = new DateTimeField($fieldValue);
            $fieldValue = $date->getDisplayDateTimeValue();
            $valueArray = explode(' ', $value);
            if(count($valueArray) == 1 && $condition != "less than hours before" && $condition != "less than hours later" && $condition != "more than hours before" && $condition != "more than hours later") {
                    $fieldValueArray = explode(' ', $fieldValue);
                    $fieldValue = getValidDBInsertDateValue($fieldValueArray[0]);
            } else {
                $fieldValue = $date->getDBInsertDateTimeValue();
            }
        }
        //strtotime condition is added for days before, days after where we give integer values, so strtotime will return 0 for such cases.
        if($field_data_type == 'date'){
                //Convert User Date Format filter value to DB date format
                $fieldValue = getValidDBInsertDateValue($fieldValue);
       
        } elseif ($field_data_type == 'reference'){        
            $fieldValues = getEntityName($row_module, $fieldValue);
            $fieldValue = $fieldValues[$fieldValue];
        } elseif ($field_data_type == 'time'){
                $value = $value.':00';	// time fields will not have seconds appended to it, so we are adding 
        } elseif ($field_data_type == 'owner' ){ 
            if($condition == 'is' || $condition == 'is not'){ 
                //To avoid again checking whether it is user or not 
                //$idList = array();
                //$idList[] = vtws_getWebserviceEntityId('Users',$value); 
                //$idList[] = vtws_getWebserviceEntityId('Groups',$value);
                //$value = $idList;
                $value = getOwnerName($value);
                $condition = ($condition == 'is') ? 'contains' : 'does not contain';
            } 
        } elseif ($field_data_type == 'currency' || $field_data_type == 'integer' || $field_data_type == 'percentage') {
            $fieldValue = CurrencyField::convertToDBFormat($fieldValue);
        } elseif (($field_data_type == 'picklist' || $field_data_type == 'multipicklist') && $value != "") {
            $value = vtranslate($value, $row_module);
        } elseif ($field_data_type == 'boolean') {
            if($value == 1) {
                $value = vtranslate('yes',$row_module);
            } elseif($value == 0) {
                $value = vtranslate('no',$row_module);
            } 
        }
        switch ($condition) {
            case "equal to":
                    return $fieldValue == $value;
            case "less than":
                    return $fieldValue < $value;
            case "greater than":
                    return $fieldValue > $value;
            case "does not equal":
                    return $fieldValue != $value;
            case "less than or equal to":
                    return $fieldValue <= $value;
            case "greater than or equal to":
                    return $fieldValue >= $value;
            case "is":
                    if (preg_match('/([^:]+):boolean$/', $value, $match)) {
                            $value = $match[1];
                            if ($value == 'true') {
                                    return $fieldValue === 'on' || $fieldValue === 1 || $fieldValue === '1';
                            } else {
                                    return $fieldValue === 'off' || $fieldValue === 0 || $fieldValue === '0' || $fieldValue === '';
                            }
                    } else {
                            return $fieldValue == $value;
                    }
            case "is not":
                    if (preg_match('/([^:]+):boolean$/', $value, $match)) {
                            $value = $match[1];
                            if ($value == 'true') {
                                    return $fieldValue === 'off' || $fieldValue === 0 || $fieldValue === '0' || $fieldValue === '';
                            } else {
                                    return $fieldValue === 'on' || $fieldValue === 1 || $fieldValue === '1';
                            }
                    } else {
                            return $fieldValue != $value;
                    }
            case "contains":
                    return strpos($fieldValue, $value) !== FALSE;
            case "does not contain":
                    if(empty($value)) unset($value);
                    return strpos($fieldValue, $value) === FALSE;
            case "starts with":
                    return $this->startsWith($fieldValue, $value);
            case "ends with":
                    return $this->endsWith($fieldValue, $value);
            case "matches":
                    return preg_match($value, $fieldValue);
            case "is empty":
                    if(empty($fieldValue)) {
                            return true;
                    }
                    return false;
            case "is not empty":
                    if(empty($fieldValue)) {
                            return false;
                    }
                    return true;
                                    case "before":
                    if(empty($fieldValue)) {
                            return false;
                    }
                    if($fieldValue < $value) {

                            return true;
                    }
                    return false;
            case "after":
                    if(empty($fieldValue)) {
                            return false;
                    }
                    if($fieldValue > $value) {

                            return true;
                    }
                    return false;
            case "between":
                    if(empty($fieldValue)) {
                            return false;
                    }
                    $values = explode(',', $value);
                    //$values = array_map('getValidDBInsertDateValue',$values);
                    if($fieldValue > $values[0] && $fieldValue < $values[1]) {
                            return true;
                    }
                    return false;
            case 'is today':
                    $today = date('Y-m-d');

                    if($fieldValue == $today) {
                            return true;
                    }
                    return false;
            case 'less than days ago':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $today = date('Y-m-d');
                    $olderDate = date('Y-m-d', strtotime('-'.$value.' days'));
                    if($olderDate <= $fieldValue && $fieldValue <= $today) {
                            return true;
                    }
                    return false;
            case 'more than days ago':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $olderDate = date('Y-m-d', strtotime('-'.$value.' days'));
                    if($fieldValue <= $olderDate) {
                            return true;
                    }
                    return false;
            case 'in less than':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $today = date('Y-m-d');
                    $futureDate = date('Y-m-d', strtotime('+'.$value.' days'));
                    if($today <= $fieldValue && $fieldValue <= $futureDate) {
                            return true;
                    }
                    return false;
            case 'in more than':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $futureDate = date('Y-m-d', strtotime('+'.$value.' days'));
                    if($fieldValue >= $futureDate) {
                            return true;
                    }
                    return false;
            case 'days ago':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $olderDate = date('Y-m-d', strtotime('-'.$value.' days'));
                    if($fieldValue == $olderDate) {
                            return true;
                    }
                    return false;
            case 'days later':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $futureDate = date('Y-m-d', strtotime('+'.$value.' days'));
                    if($fieldValue == $futureDate) {
                            return true;
                    }
                    return false;

            case 'less than hours before':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $currentTime = date('Y-m-d H:i:s');
                    $olderDateTime = date('Y-m-d H:i:s', strtotime('-'.$value.' hours'));
                    if($olderDateTime <= $fieldValue && $fieldValue <= $currentTime) {
                            return true;
                    }
                    return false;

            case 'less than hours later':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $currentTime = date('Y-m-d H:i:s');
                    $futureDateTime = date('Y-m-d H:i:s', strtotime('+'.$value.' hours'));
                    if($currentTime <= $fieldValue && $fieldValue <= $futureDateTime) {
                            return true;
                    }
                    return false;

            case 'more than hours before':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $olderDateTime = date('Y-m-d H:i:s', strtotime('-'.$value.' hours'));
                    if($fieldValue <= $olderDateTime) {
                            return true;
                    }
                    return false;
            case 'more than hours later':
                    if(empty($fieldValue) || empty($value)) {
                            return false;
                    }
                    $futureDateTime = date('Y-m-d H:i:s', strtotime('+'.$value.' hours'));
                    if($fieldValue >= $futureDateTime) {
                            return true;
                    }
                    return false;
            case 'is added':
                    //This condition was used only for comments. It should not execute from not from workflows, So it was always "FALSE"
                    return false;
            default:
                    //Unexpected condition
                    throw new Exception("Found an unexpected condition: " . $condition);
        }
    }    
    function transformConditionsToFilter($conditions) {
        $wfCondition = array();

        if(!empty($conditions)) {
            foreach($conditions as $index => $condition) {
                $columns = $condition['columns'];
                if($index == '1' && empty($columns)) {
                        $wfCondition[] = array('fieldname'=>'', 'operation'=>'', 'value'=>'', 'valuetype'=>'', 
                                'joincondition'=>'', 'groupid'=>'0');
                }
                if(!empty($columns) && is_array($columns)) {
                    foreach($columns as $column) {

                        list($columntable, $columnname, $fieldname, $label, $columntype) = explode(":",$column['columnname']);

                        if ($columntype == "D" && $column['valuetype'] == "rawtext" && in_array($column['comparator'],$this->ConvertDate)) {

                            if ($column['comparator'] == "between") {
                                $values = explode(',', $column['value']);
                                $column['value'] = array_map('getValidDBInsertDateValue',$values);
                            } else {
                                $column['value'] = getValidDBInsertDateValue($column['value']);
                            }
                        }    

                        $wfCondition[] = array('fieldname'=>$column['columnname'], 'operation'=>$column['comparator'],
                                    'value'=>$column['value'], 'valuetype'=>$column['valuetype'], 'joincondition'=>$column['column_condition'],
                                    'groupjoin'=>$condition['condition'], 'groupid'=>$column['groupid']);
                    }
                }
            }
        }
        return $wfCondition;
    }
}
