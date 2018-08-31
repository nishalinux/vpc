<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 03:31:33
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Calendar/step3.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13723030655b739e952be300-22852947%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'da407e68691877ef98c5be304b1db00d9f58f350' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Calendar/step3.tpl',
      1 => 1533201058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13723030655b739e952be300-22852947',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'RECORD_ID' => 0,
    'IS_DUPLICATE' => 0,
    'PICKIST_DEPENDENCY_DATASOURCE' => 0,
    'IS_PARENT_EXISTS' => 0,
    'SPLITTED_MODULE' => 0,
    'USER_MODEL' => 0,
    'IS_RELATION_OPERATION' => 0,
    'SOURCE_MODULE' => 0,
    'SOURCE_RECORD' => 0,
    'RECORD_MODEL' => 0,
    'EVENTUSERS' => 0,
    'item' => 0,
    'i' => 0,
    'EVENTCONTACTS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b739e9537a7c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b739e9537a7c')) {function content_5b739e9537a7c($_smarty_tpl) {?>
<form class="form-horizontal eventEditView" id="event_step3" method="post" action="index.php"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><input type="hidden" name="action" value="Save" /><input type="hidden" name="moduleclass" value="Events" /><input type="hidden" name="record" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" /><input type="hidden" name="isDuplicate" value="<?php echo $_smarty_tpl->tpl_vars['IS_DUPLICATE']->value;?>
" /><?php if (!empty($_smarty_tpl->tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']->value)){?><input type="hidden" name="picklistDependency" value='<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKIST_DEPENDENCY_DATASOURCE']->value);?>
' /><?php }?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['QUALIFIED_MODULE_NAME'] = new Smarty_variable($_tmp1, null, 0);?><?php $_smarty_tpl->tpl_vars['IS_PARENT_EXISTS'] = new Smarty_variable(strpos($_smarty_tpl->tpl_vars['MODULE']->value,":"), null, 0);?><?php if ($_smarty_tpl->tpl_vars['IS_PARENT_EXISTS']->value){?><?php $_smarty_tpl->tpl_vars['SPLITTED_MODULE'] = new Smarty_variable(explode(":",$_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['SPLITTED_MODULE']->value[1];?>
" /><input type="hidden" name="parent" value="<?php echo $_smarty_tpl->tpl_vars['SPLITTED_MODULE']->value[0];?>
" /><?php }else{ ?><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
" /><?php }?><input type="hidden" name="defaultCallDuration" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('callduration');?>
" /><input type="hidden" name="defaultOtherEventDuration" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('othereventduration');?>
" /><?php if ($_smarty_tpl->tpl_vars['IS_RELATION_OPERATION']->value){?><input type="hidden" name="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
" /><input type="hidden" name="sourceRecord" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_RECORD']->value;?>
" /><input type="hidden" name="relationOperation" value="<?php echo $_smarty_tpl->tpl_vars['IS_RELATION_OPERATION']->value;?>
" /><?php }?><input type="hidden" name="subject" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('subject');?>
" /><input type="hidden" name="mode" value="<?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value){?>edit<?php }?>" /><input type="hidden" name="date_start" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('date_start');?>
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
" /><!-- Step2 related fields --><input type="hidden" name="popupReferenceModule" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('popupReferenceModule');?>
" /><input type="hidden" name="contact_id_display" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('contact_id_display');?>
" /><input type="hidden" name="relatedContactInfo" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('relatedContactInfo');?>
" /><input type="hidden" name="parent_id" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('parent_id');?>
" /><input type="hidden" name="parent_id_display" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('parent_id_display');?>
" /><input type="hidden" name="description" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('description');?>
" /><input type="hidden" name="userChangedEndDateTime" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('userChangedEndDateTime');?>
" /><input type="hidden" name="contactidlist" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('contactidlist');?>
" /><input type="hidden" name="inviteesid" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('inviteesid');?>
" /><input type="hidden" name="selectedusers" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get("selectedusers"));?>
' /><!-- Step2 ended here --><input type="hidden" class="step" value="3" /><!-- New Custom Fields --><input type="hidden" name="invoiceid" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('invoiceid');?>
" /><input type="hidden" name="duration_seconds" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('duration_seconds');?>
" /><input type="hidden" name="cf_activityid" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('cf_activityid');?>
" /><!-- Ended Here --><div class="padding1per contentsBackground">The following users and contacts are invited for event created.<br/><b>Users:</b><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['EVENTUSERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?><li><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</li><?php } ?><?php } ?></ul><b>Contacts:</b><ul><?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['EVENTCONTACTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['item']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?><li><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</li><?php } ?><?php } ?></ul></div><br><div class="pull-right block"><button type="button" class="btn btn-danger backStep"><strong><?php echo vtranslate('LBL_BACK',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>&nbsp;&nbsp;<button type="submit" class="btn btn-success" id="generateReport"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>&nbsp;&nbsp;<a  class="cancelLink" onclick="window.history.back()"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a>&nbsp;&nbsp;</div></form>
<?php }} ?>