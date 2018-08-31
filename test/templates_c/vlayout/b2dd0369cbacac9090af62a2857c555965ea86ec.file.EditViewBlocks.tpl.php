<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 21:56:40
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProjectTask/EditViewBlocks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13815112555b774498c886c4-24706472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b2dd0369cbacac9090af62a2857c555965ea86ec' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProjectTask/EditViewBlocks.tpl',
      1 => 1501689935,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13815112555b774498c886c4-24706472',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'USER_MODEL' => 0,
    'PICKIST_DEPENDENCY_DATASOURCE' => 0,
    'MODULE' => 0,
    'IS_PARENT_EXISTS' => 0,
    'SPLITTED_MODULE' => 0,
    'RECORD_ID' => 0,
    'IS_RELATION_OPERATION' => 0,
    'SOURCE_MODULE' => 0,
    'SOURCE_RECORD' => 0,
    'SINGLE_MODULE_NAME' => 0,
    'RECORD_STRUCTURE_MODEL' => 0,
    'RECORD_STRUCTURE' => 0,
    'BLOCK_FIELDS' => 0,
    'BLOCK_LABEL' => 0,
    'FIELD_NAME' => 0,
    'FIELD_MODEL' => 0,
    'COUNTER' => 0,
    'WIDTHTYPE' => 0,
    'isReferenceField' => 0,
    'REFERENCE_LIST' => 0,
    'REFERENCE_LIST_COUNT' => 0,
    'DISPLAYID' => 0,
    'REFERENCED_MODULE_STRUCT' => 0,
    'value' => 0,
    'REFERENCED_MODULE_NAME' => 0,
    'ProjectTask_MODULE_MODEL' => 0,
    'PT_FIELD_MODEL' => 0,
    'USERS_LIST_INFO' => 0,
    'GROUPS_LIST_INFO' => 0,
    'PROJECT_TASK_USERINFO' => 0,
    'pt_taskdata' => 0,
    'row_no' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b774498de06b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b774498de06b')) {function content_5b774498de06b($_smarty_tpl) {?>

<link rel='stylesheet' href='libraries/jstree/themes/default/style.min.css' /><style>.jstree-grid-wrapper {border:1px solid #ddd;}.jstree-grid-midwrapper  {background-color:white;}.jstree-grid-header-cell {text-align:left;font-size:11px;border:1px solid #ddd;padding:5px;white-space:nowrap;color:#333;background: #fff;background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ededed));background: -moz-linear-gradient(top,  #fff,  #ededed);filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed');}.jstree-grid-separator {display:none;}.jstree-anchor,.jstree-grid-cell {text-overflow:ellipsis !important;white-space:nowrap !important;overflow:hidden !important;}</style><div class='container-fluid editViewContainer'><form class="form-horizontal recordEditView" id="EditView" name="EditView" method="post" action="index.php" enctype="multipart/form-data"><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('rowheight'), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']->value)){?><input type="hidden" name="picklistDependency" value='<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']->value);?>
' /><?php }?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME'] = new Smarty_variable($_tmp1, null, 0);?><?php $_smarty_tpl->tpl_vars['IS_PARENT_EXISTS'] = new Smarty_variable(strpos($_smarty_tpl->tpl_vars['MODULE']->value,":"), null, 0);?><?php if ($_smarty_tpl->tpl_vars['IS_PARENT_EXISTS']->value){?><?php $_smarty_tpl->tpl_vars['SPLITTED_MODULE'] = new Smarty_variable(explode(":",$_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['SPLITTED_MODULE']->value[1];?>
" /><input type="hidden" name="parent" value="<?php echo $_smarty_tpl->tpl_vars['SPLITTED_MODULE']->value[0];?>
" /><?php }else{ ?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><?php }?><input type="hidden" name="action" value="Save" /><input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" /><input type="hidden" name="defaultCallDuration" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('callduration');?>
" /><input type="hidden" name="defaultOtherEventDuration" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('othereventduration');?>
" /><?php if ($_smarty_tpl->tpl_vars['IS_RELATION_OPERATION']->value){?><input type="hidden" name="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
" /><input type="hidden" name="sourceRecord" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_RECORD']->value;?>
" /><input type="hidden" name="relationOperation" value="<?php echo $_smarty_tpl->tpl_vars['IS_RELATION_OPERATION']->value;?>
" /><?php }?><div class="contentHeader row-fluid"><?php $_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME'] = new Smarty_variable(('SINGLE_').($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value!=''){?><h3 class="span8 textOverflowEllipsis" title="<?php echo vtranslate('LBL_EDITING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['RECORD_STRUCTURE_MODEL']->value->getRecordName();?>
"><?php echo vtranslate('LBL_EDITING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 - <?php echo $_smarty_tpl->tpl_vars['RECORD_STRUCTURE_MODEL']->value->getRecordName();?>
</h3><?php }else{ ?><h3 class="span8 textOverflowEllipsis"><?php echo vtranslate('LBL_CREATING_NEW',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3><?php }?><span class="pull-right"><button class="btn btn-success" type="submit"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><a class="cancelLink" type="reset" onclick="javascript:window.history.back();"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></span></div><?php  $_smarty_tpl->tpl_vars['BLOCK_FIELDS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->_loop = false;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->key => $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value){
$_smarty_tpl->tpl_vars['BLOCK_FIELDS']->_loop = true;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value = $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->key;
?><?php if (count($_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value)<=0){?><?php continue 1?><?php }?><?php if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value=='Project Parent Tree'){?><table class="table table-bordered "><?php }else{ ?><table class="table table-bordered blockContainer showInlineTable equalSplit"><?php }?><thead><tr><th class="blockHeader" colspan="4"><?php echo vtranslate($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th></tr></thead><tbody><?php if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value=='Project Parent Tree'){?><tr><td colspan='4'><div class='row-fluid'><span type='button' class='btn btn-success' id='btnjsTreeProjectTasks'>Load Project Parent Tree</span><!--<input type='hidden' name='pcm_parent_task_id' id='ProjectTask_editView_fieldName_pcm_parent_task_id' >--><div><input class="search-input form-control" placeholder='Search' style='display:none;'></input></div><div id='task_tree_in_editer' class=''></div></div></td></tr><?php }?><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['FIELD_MODEL']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['FIELD_MODEL']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->key => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value){
$_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_MODEL']->key;
 $_smarty_tpl->tpl_vars['FIELD_MODEL']->iteration++;
 $_smarty_tpl->tpl_vars['FIELD_MODEL']->last = $_smarty_tpl->tpl_vars['FIELD_MODEL']->iteration === $_smarty_tpl->tpl_vars['FIELD_MODEL']->total;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['blockfields']['last'] = $_smarty_tpl->tpl_vars['FIELD_MODEL']->last;
?><?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value=='pcm_active'){?><!--<input type='hidden' name='<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
' value="1">--><?php }?><?php $_smarty_tpl->tpl_vars["isReferenceField"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType(), null, 0);?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="20"||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="19"){?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value=='1'){?><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td></tr><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(0, null, 0);?><?php }?><?php }?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value==2){?></tr><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(1, null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable($_smarty_tpl->tpl_vars['COUNTER']->value+1, null, 0);?><?php }?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['isReferenceField']->value!="reference"){?><label class="muted pull-right marginRight10px"><?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()==true&&$_smarty_tpl->tpl_vars['isReferenceField']->value!="reference"){?> <span class="redColor">*</span> <?php }?><?php if ($_smarty_tpl->tpl_vars['isReferenceField']->value=="reference"){?><?php $_smarty_tpl->tpl_vars["REFERENCE_LIST"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getReferenceList(), null, 0);?><?php $_smarty_tpl->tpl_vars["REFERENCE_LIST_COUNT"] = new Smarty_variable(count($_smarty_tpl->tpl_vars['REFERENCE_LIST']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['REFERENCE_LIST_COUNT']->value>1){?><?php $_smarty_tpl->tpl_vars["DISPLAYID"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'), null, 0);?><?php $_smarty_tpl->tpl_vars["REFERENCED_MODULE_STRUCT"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getReferenceModule($_smarty_tpl->tpl_vars['DISPLAYID']->value), null, 0);?><?php if (!empty($_smarty_tpl->tpl_vars['REFERENCED_MODULE_STRUCT']->value)){?><?php $_smarty_tpl->tpl_vars["REFERENCED_MODULE_NAME"] = new Smarty_variable($_smarty_tpl->tpl_vars['REFERENCED_MODULE_STRUCT']->value->get('name'), null, 0);?><?php }?><span class="pull-right"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()==true){?> <span class="redColor">*</span> <?php }?><select id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
_dropDown" class="chzn-select referenceModulesList streched" style="width:160px;"><optgroup><?php  $_smarty_tpl->tpl_vars['value'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['value']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['REFERENCE_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['value']->key => $_smarty_tpl->tpl_vars['value']->value){
$_smarty_tpl->tpl_vars['value']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['value']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['value']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['value']->value==$_smarty_tpl->tpl_vars['REFERENCED_MODULE_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['value']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</option><?php } ?></optgroup></select></span><?php }else{ ?><label class="muted pull-right marginRight10px"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()==true){?> <span class="redColor">*</span> <?php }?><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><?php }?><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="83"){?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('COUNTER'=>$_smarty_tpl->tpl_vars['COUNTER']->value,'MODULE'=>$_smarty_tpl->tpl_vars['MODULE']->value), 0);?>
<?php }else{ ?><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['isReferenceField']->value!="reference"){?></label><?php }?></td><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="83"){?><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='19'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='20'){?> colspan="3" <?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable($_smarty_tpl->tpl_vars['COUNTER']->value+1, null, 0);?> <?php }?>><div class="row-fluid"><span class="span10"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('BLOCK_FIELDS'=>$_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value), 0);?>
</span></div></td><?php }?><?php if (count($_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value)==1&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="19"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="20"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="30"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name')!="recurringtype"){?><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><?php }?><?php if ($_smarty_tpl->tpl_vars['MODULE']->value=='Events'&&$_smarty_tpl->tpl_vars['BLOCK_LABEL']->value=='LBL_EVENT_INFORMATION'&&$_smarty_tpl->getVariable('smarty')->value['foreach']['blockfields']['last']){?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('uitypes/FollowUp.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('COUNTER'=>$_smarty_tpl->tpl_vars['COUNTER']->value), 0);?>
<?php }?><?php } ?><?php if (end($_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value)==true&&count($_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value)!=1&&$_smarty_tpl->tpl_vars['COUNTER']->value==1){?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><?php }?></tr><?php if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value=='Users'){?><tr><?php $_smarty_tpl->tpl_vars['ProjectTask_MODULE_MODEL'] = new Smarty_variable(Vtiger_Module_Model::getInstance('ProjectTask'), null, 0);?><?php $_smarty_tpl->tpl_vars['PT_FIELD_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['ProjectTask_MODULE_MODEL']->value->getField('projecttaskstatus'), null, 0);?><?php $_smarty_tpl->tpl_vars['PT_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['PT_FIELD_MODEL']->value->getPicklistValues(), null, 0);?><?php $_smarty_tpl->tpl_vars["dateFormat"] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format'), null, 0);?><?php $_smarty_tpl->tpl_vars["USERS_LIST_INFO"] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->getAccessibleUsersForModule($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><?php $_smarty_tpl->tpl_vars["GROUPS_LIST_INFO"] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->getAccessibleGroupForModule($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><input type="hidden" id="ACCESSIBLE_USER_LIST" value="<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['USERS_LIST_INFO']->value));?>
"/><input type="hidden" id="ACCESSIBLE_GROUP_LIST" value="<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['GROUPS_LIST_INFO']->value));?>
"/><td colspan='4'><table class="table table-bordered userinfo equalSplit" id="userinfotable"><thead><tr><th>User</th><th>Start Date</th><th>End Date</th><th>Allocated Hours</th><th>Worked Hours</th><th>Status</th></tr></thead><tbody id="Userinfoblock"><tr id="userrow0" class="hide userslineItemCloneCopy"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("Project_User_Task.tpl",'ProjectTask'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('row_no'=>0,'data'=>array()), 0);?>
</tr><?php  $_smarty_tpl->tpl_vars['pt_taskdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pt_taskdata']->_loop = false;
 $_smarty_tpl->tpl_vars['info'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROJECT_TASK_USERINFO']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pt_taskdata']->key => $_smarty_tpl->tpl_vars['pt_taskdata']->value){
$_smarty_tpl->tpl_vars['pt_taskdata']->_loop = true;
 $_smarty_tpl->tpl_vars['info']->value = $_smarty_tpl->tpl_vars['pt_taskdata']->key;
?><?php $_smarty_tpl->tpl_vars['row_no'] = new Smarty_variable($_smarty_tpl->tpl_vars['pt_taskdata']->value['userid'], null, 0);?><tr id="userrow<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" class="userslineItemRow"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("Project_User_Task.tpl",'ProjectTask'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('row_no'=>$_smarty_tpl->tpl_vars['row_no']->value,'data'=>$_smarty_tpl->tpl_vars['pt_taskdata']->value), 0);?>
</tr><?php } ?></tbody></table></td></tr><?php }?></tbody></table><br><?php } ?><script src="https://code.jquery.com/jquery-1.8.0.js"    crossorigin="anonymous"></script><script src='libraries/jquery/jquery.dataAttr.min.js?v=6.4.0'></script><script src='libraries/jstree/jstree.js?v=6.4.0'></script><script src='libraries/jstree/jstreegrid_new.js?v=6.4.0'></script><script>jQuery(document).ready(function(){var active  = $('#ProjectTask_editView_fieldName_pcm_active').val();if(active == 0){jQuery("input,select,textarea").prop('disabled', true);jQuery('button').prop('disabled', true);}});</script><?php }} ?>