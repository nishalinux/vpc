<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 03:31:20
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Calendar/step2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13328964365b739e8881a0f7-42176366%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '66a55a22abcb76ab69e2c273efe64c23e6858d66' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Calendar/step2.tpl',
      1 => 1533201058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13328964365b739e8881a0f7-42176366',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'RECORD_ID' => 0,
    'RECORD_MODEL' => 0,
    'IS_DUPLICATE' => 0,
    'RECORD_STRUCTURE' => 0,
    'BLOCK_FIELDS' => 0,
    'BLOCK_LABEL' => 0,
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
    'USER_CHANGED_END_DATE_TIME' => 0,
    'ACCESSIBLE_USERS' => 0,
    'USER_ID' => 0,
    'CURRENT_USER' => 0,
    'INVITIES_SELECTED' => 0,
    'USER_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b739e88954c4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b739e88954c4')) {function content_5b739e88954c4($_smarty_tpl) {?>
<form class="form-horizontal eventEditView" id="event_step2" method="post" action="index.php"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="view" value="Edit" /><input type="hidden" name="mode" value="step3" /><input type="hidden" name="moduleclass" value="Events" /><input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" /><input type="hidden" name="subject" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('subject');?>
" /><input type="hidden" name="date_start" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('date_start');?>
" /><input type="hidden" name="assigned_user_id" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('assigned_user_id');?>
" /><input type="hidden" name="time_start" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('time_start');?>
" /><input type="hidden" name="due_date" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('due_date');?>
" /><input type="hidden" name="time_end" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('time_end');?>
" /><input type="hidden" name="eventstatus" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('eventstatus');?>
" /><input type="hidden" name="sendnotification" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('sendnotification');?>
" /><input type="hidden" name="activitytype" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('activitytype');?>
" /><input type="hidden" name="location" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('location');?>
" /><input type="hidden" name="taskpriority" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('taskpriority');?>
" /><input type="hidden" name="visibility" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('visibility');?>
" /><input type="hidden" name="followup_date_start" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('followup_date_start');?>
" /><input type="hidden" name="followup_time_start" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('followup_time_start');?>
" /><input type="hidden" name="followup" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('followup');?>
" /><!-- second Block --><input type="hidden" name="set_reminder" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('set_reminder');?>
" /><input type="hidden" name="remdays" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('remdays');?>
" /><input type="hidden" name="remhrs" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('remhrs');?>
" /><input type="hidden" name="remmin" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('remmin');?>
" /><!-- Thrid Block --><input type="hidden" name="recurringcheck" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('recurringcheck');?>
" /><input type="hidden" name="repeat_frequency" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('repeat_frequency');?>
" /><input type="hidden" name="recurringtype" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('recurringtype');?>
" /><input type="hidden" name="calendar_repeat_limit_date" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('calendar_repeat_limit_date');?>
" /><input type="hidden" name="sun_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('sun_flag');?>
" /><input type="hidden" name="mon_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('mon_flag');?>
" /><input type="hidden" name="tue_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('tue_flag');?>
" /><input type="hidden" name="wed_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('wed_flag');?>
" /><input type="hidden" name="thu_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('thu_flag');?>
" /><input type="hidden" name="fri_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('fri_flag');?>
" /><input type="hidden" name="sat_flag" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('sat_flag');?>
" /><input type="hidden" name="repeatMonth" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('repeatMonth');?>
" /><input type="hidden" name="repeatMonth_date" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('repeatMonth_date');?>
" /><input type="hidden" name="repeatMonth_daytype" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('repeatMonth_daytype');?>
" /><input type="hidden" name="repeatMonth_day" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('repeatMonth_day');?>
" /><input type="hidden" name="isDuplicate" value="<?php echo $_smarty_tpl->tpl_vars['IS_DUPLICATE']->value;?>
" /><input type="hidden" class="step" value="2" /><div class="well padding1per contentsBackground"><?php  $_smarty_tpl->tpl_vars['BLOCK_FIELDS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->_loop = false;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->key => $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value){
$_smarty_tpl->tpl_vars['BLOCK_FIELDS']->_loop = true;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value = $_smarty_tpl->tpl_vars['BLOCK_FIELDS']->key;
?><?php if (count($_smarty_tpl->tpl_vars['BLOCK_FIELDS']->value)<=0){?><?php continue 1?><?php }?><?php if ($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value!='LBL_EVENT_INFORMATION'&&$_smarty_tpl->tpl_vars['BLOCK_LABEL']->value!='LBL_REMINDER_INFORMATION'&&$_smarty_tpl->tpl_vars['BLOCK_LABEL']->value!='LBL_RECURRENCE_INFORMATION'){?><table class="table table-bordered blockContainer showInlineTable equalSplit"><thead><tr><th class="blockHeader" colspan="4"><?php echo vtranslate($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th></tr></thead><tbody><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(0, null, 0);?><?php  $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = false;
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
?><?php $_smarty_tpl->tpl_vars["isReferenceField"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType(), null, 0);?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="20"||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="19"){?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value=='1'){?><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
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
"></td><?php }?></tr></tbody></table><br/><?php }?><?php } ?><input type="hidden" name="userChangedEndDateTime" value="<?php echo $_smarty_tpl->tpl_vars['USER_CHANGED_END_DATE_TIME']->value;?>
" /><table class="table table-bordered blockContainer showInlineTable"><tr><th class="blockHeader" colspan="4"><?php echo vtranslate('LBL_INVITE_USER_BLOCK',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th></tr><tr><td class="fieldLabel"><label class="muted pull-right marginRight10px"><?php echo vtranslate('LBL_INVITE_USERS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></td><td class="fieldValue"><select id="selectedUsers" class="select2" multiple name="selectedusers[]" style="width:200px;"><?php  $_smarty_tpl->tpl_vars['USER_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['USER_NAME']->_loop = false;
 $_smarty_tpl->tpl_vars['USER_ID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ACCESSIBLE_USERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['USER_NAME']->key => $_smarty_tpl->tpl_vars['USER_NAME']->value){
$_smarty_tpl->tpl_vars['USER_NAME']->_loop = true;
 $_smarty_tpl->tpl_vars['USER_ID']->value = $_smarty_tpl->tpl_vars['USER_NAME']->key;
?><?php if ($_smarty_tpl->tpl_vars['USER_ID']->value==$_smarty_tpl->tpl_vars['CURRENT_USER']->value->getId()){?><?php continue 1?><?php }?><option value="<?php echo $_smarty_tpl->tpl_vars['USER_ID']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['USER_ID']->value,$_smarty_tpl->tpl_vars['INVITIES_SELECTED']->value)){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['USER_NAME']->value;?>
</option><?php } ?><select></td></tr></table><br><input type="hidden" id="nousers" value=""/><input type="hidden" id="assignedtouserstatus" value=""/><table class="table table-bordered blockContainer showInlineTable" id="finalusers"><tr><th class="blockHeader" >Invitees</th><th>TimeZone</th><th>Availability</th><th> Actions </th></tr><tbody id="inviteedata"><tr><td></td><td></td><td></td><td></td></tr></tbody></table></div><div class="pull-right block"><button type="button" class="btn btn-danger backStep"><strong><?php echo vtranslate('LBL_BACK',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>&nbsp;&nbsp;<button type="submit" class="btn btn-success nextStep"><strong><?php echo vtranslate('LBL_NEXT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>&nbsp;&nbsp;<a class="cancelLink" onclick="window.history.back()"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a><br></div><br><br></form><?php }} ?>