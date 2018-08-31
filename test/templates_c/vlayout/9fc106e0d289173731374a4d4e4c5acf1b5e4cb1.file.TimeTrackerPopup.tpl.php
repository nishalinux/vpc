<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:52:35
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/TimeTracker/TimeTrackerPopup.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16683621015b7316e3bb4f92-87843472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9fc106e0d289173731374a4d4e4c5acf1b5e4cb1' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/TimeTracker/TimeTrackerPopup.tpl',
      1 => 1518595197,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16683621015b7316e3bb4f92-87843472',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_RUNNING_NAME' => 0,
    'RECORD_MODEL' => 0,
    'RECORD_RUNNING' => 0,
    'QUALIFIED_MODULE' => 0,
    'UNIQUE_ID' => 0,
    'RECORD_ID' => 0,
    'USER_MODEL' => 0,
    'SETTINGS' => 0,
    'FIELD_SETTINGS' => 0,
    'FIELDINFO' => 0,
    'FIELDNAME' => 0,
    'EVENT_MODULE_MODEL' => 0,
    'FORM_DATA' => 0,
    'FIELD_MODEL' => 0,
    'PICKLIST_VALUES' => 0,
    'PICKLIST_NAME' => 0,
    'PICKLIST_VALUE' => 0,
    'STATUS' => 0,
    'LIST_TIMER_ACTIVE' => 0,
    'TIMER_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7316e3d0e1d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7316e3d0e1d')) {function content_5b7316e3d0e1d($_smarty_tpl) {?>
<style>
    .grayBgProp{
        background-color: #f5f5f5 !important;
        background-image: none !important;
        border: 1px solid #ddd !important;
    }
</style>
<div style="width: 270px;"><link rel="stylesheet" href="layouts/vlayout/modules/TimeTracker/css/bootstrap-datetimepicker.min.css" type="text/css" media="screen" /><script type="text/javascript" src="layouts/vlayout/modules/TimeTracker/resources/bootstrap-datetimepicker.min.js"></script><script type="text/javascript" src="layouts/vlayout/modules/TimeTracker/resources/eventPause.min.js"></script><div class="modelContainer" id=""><div class="modal-header contentsBackground" style="text-align: center;"><h3><input type="hidden" id="recordName" value="<?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING_NAME']->value){?> <?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING_NAME']->value;?>
 <?php }else{ ?> <?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getName();?>
 <?php }?>"><a href="<?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getDetailViewUrl();?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['detailUrl'];?>
<?php }?>" id="header_popup"><?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><?php echo vtranslate('LBL_RUNNING_FOR',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING_NAME']->value){?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING_NAME']->value;?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['name'];?>
<?php }?><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getName();?>
<?php }?></a></h3></div><form class="form-horizontal timeTrackerForm" name="TrackerForm" method="post" action="index.php"><input type="hidden" name="form_data[unique_id]" value="<?php echo $_smarty_tpl->tpl_vars['UNIQUE_ID']->value;?>
"/><input type="hidden" name="parentId" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
"/><input type="hidden" id="dateFormat" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format');?>
"/><input type="hidden" id="dateFormat" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format');?>
"/><input type="hidden" id="timeFormat" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('hour_format');?>
"/><input type="hidden" name="form_data[module]" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getModuleName();?>
"/><div class="quickCreateContent"><div class="modal-body"><?php $_smarty_tpl->tpl_vars['FIELD_SETTINGS'] = new Smarty_variable($_smarty_tpl->tpl_vars['SETTINGS']->value['field_settings'], null, 0);?><table style="margin: 0 auto;"><?php  $_smarty_tpl->tpl_vars['FIELDINFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELDINFO']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELDNAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELDINFO']->key => $_smarty_tpl->tpl_vars['FIELDINFO']->value){
$_smarty_tpl->tpl_vars['FIELDINFO']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELDNAME']->value = $_smarty_tpl->tpl_vars['FIELDINFO']->key;
?><?php if ($_smarty_tpl->tpl_vars['FIELDINFO']->value['visible']&&$_smarty_tpl->tpl_vars['FIELDNAME']->value!='module'){?><tr><td class="fieldValue medium" colspan="2"><?php $_smarty_tpl->tpl_vars["FIELD_MODEL"] = new Smarty_variable($_smarty_tpl->tpl_vars['EVENT_MODULE_MODEL']->value->getField($_smarty_tpl->tpl_vars['FIELDNAME']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['FIELDNAME']->value=='subject'){?><div class="row-fluid"><span class="span10"><input id="<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
" type="text" style="width: 210px;" class="fieldInput propFieldInput" name="form_data[<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
]" value="<?php if (trim(decode_html($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]))!=''){?><?php echo trim(decode_html($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]));?>
<?php }elseif($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['subject'];?>
<?php }elseif(trim(decode_html($_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default']))!=''){?><?php echo $_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default'];?>
<?php }?>" placeholder="<?php echo vtranslate('LBL_ENTER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['EVENT_MODULE_MODEL']->value->getName());?>
"/></span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELDNAME']->value=='description'){?><div class="row-fluid"><span class="span10"><textarea id="<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
" name="form_data[<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
]" placeholder="<?php echo vtranslate('LBL_ENTER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['EVENT_MODULE_MODEL']->value->getName());?>
" style="width: 220px;" class="fieldInput propFieldInput" rows="10"><?php if (trim(decode_html($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]))!=''){?><?php echo trim(decode_html($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]));?>
<?php }elseif($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['description'];?>
<?php }elseif(trim(decode_html($_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default']))!=''){?><?php echo $_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default'];?>
<?php }?></textarea></span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELDNAME']->value=='activitytype'){?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><div class="row-fluid"><span class="span10"><select id="<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
" data-default-value = "<?php echo decode_html($_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default']);?>
" class="chzn-select propSelectFieldInput" name="form_data[<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
]" style="width: 210px;"><option value=""><?php echo vtranslate('LBL_SELECT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['EVENT_MODULE_MODEL']->value->getName());?>
</option><?php if ($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]||$_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data'][$_smarty_tpl->tpl_vars['FIELDNAME']->value]){?><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value);?>
"<?php if (trim(decode_html($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]))==trim($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value)||trim(decode_html($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data'][$_smarty_tpl->tpl_vars['FIELDNAME']->value]))==trim($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value)){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</option><?php } ?><?php }else{ ?><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value);?>
"<?php if (trim(decode_html($_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default']))==trim($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value)){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</option><?php } ?><?php }?></select></span></div><?php }else{ ?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><div class="row-fluid"><span class="span10"><select class="chzn-select propSelectFieldInput" name="form_data[<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
]" style="width: 210px;"><option value=""><?php echo vtranslate('LBL_SELECT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['EVENT_MODULE_MODEL']->value->getName());?>
</option><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value);?>
"<?php if (trim(decode_html($_smarty_tpl->tpl_vars['FORM_DATA']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]))==trim($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value)){?>selected<?php }elseif(trim(decode_html($_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default']))==trim($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value)){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</option><?php } ?></select></span></div><?php }?></td></tr><?php }else{ ?><input type="hidden" name="form_data[<?php echo $_smarty_tpl->tpl_vars['FIELDNAME']->value;?>
]" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_SETTINGS']->value[$_smarty_tpl->tpl_vars['FIELDNAME']->value]['default'];?>
" /><?php }?><?php } ?><tr><td class="fieldValue medium" colspan="2"><input type="text" style="width: 210px;" id="startDateTime" class="dateTimeField" name="form_data[startdate]" value="<?php if ($_smarty_tpl->tpl_vars['FORM_DATA']->value['startdate']){?><?php echo $_smarty_tpl->tpl_vars['FORM_DATA']->value['startdate'];?>
<?php }elseif($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['startdate']){?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['startdate'];?>
<?php }?>" placeholder="<?php echo vtranslate('LBL_START_DATETIME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['start_datetime_editable']!=1){?>readonly<?php }?>/></td></tr><tr><td class="fieldValue medium" colspan="2"><input type="text" style="width: 210px;" id="endDateTime" class="dateTimeField" name="form_data[enddate]" value="<?php if ($_smarty_tpl->tpl_vars['FORM_DATA']->value['enddate']){?><?php echo $_smarty_tpl->tpl_vars['FORM_DATA']->value['enddate'];?>
<?php }elseif($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['enddate']){?><?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['enddate'];?>
<?php }?>" placeholder="<?php echo vtranslate('LBL_DUE_DATETIME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['due_datetime_editable']!=1){?>readonly<?php }?>/></td></tr><tr><td class="fieldValue medium" colspan="2"><div style="text-align: center;" class="detailViewTitle"><input type="hidden" id="timeTrackerTotal" name="form_data[timeTrackerTotal]" value="<?php echo $_smarty_tpl->tpl_vars['FORM_DATA']->value['timeTrackerTotal'];?>
" /><?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><input type="hidden" id="timeTrackerTotalRunning" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['timeTrackerTotal'];?>
" /><input type="hidden" id="record_running" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['record'];?>
" /><?php }?><span class="recordLabel font-x-x-large pushDown timeTrackerTotal" style="color: #2787e0;" >00:00:00</span></div></td></tr><tr><td class="fieldValue medium" colspan="2"><div class="row-fluid" style="text-align: center"><?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['allow_create_comments']==1){?><input type="hidden" id="auto_comment" name="form_data[auto_comment]" value="<?php echo $_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments'];?>
"><a href="javascript:void(0);" id="commentIcon" data-auto-comment="<?php echo $_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments'];?>
" style="margin: 0 10px;display: inline-block;"><img src="layouts/vlayout/modules/TimeTracker/images/comment-on.jpg" width="35" id="commnentOn" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments']!=1&&$_smarty_tpl->tpl_vars['FORM_DATA']->value['auto_comment']!=1){?>style="display: none;" <?php }?>/><img src="layouts/vlayout/modules/TimeTracker/images/comment-off.jpg" width="35" id="commentOff" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments']==1||$_smarty_tpl->tpl_vars['FORM_DATA']->value['auto_comment']==1){?>style="display: none;" <?php }?>/><img src="layouts/vlayout/modules/TimeTracker/images/comment-off.jpg" width="35" id="commentOff" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments']==1||$_smarty_tpl->tpl_vars['FORM_DATA']->value['auto_comment']==1){?>style="display: none;" <?php }?>/></a><?php }else{ ?>&nbsp;<?php }?><a href="javascript:void(0);" id="btnPause" style="margin: 0 10px;display: inline-block;"><img src="layouts/vlayout/modules/TimeTracker/images/pause.jpg" width="35"></a><a href="javascript:void(0);" id="btnCancel" style="margin: 0 10px;display: inline-block;"><img src="layouts/vlayout/modules/TimeTracker/images/cancel.gif" width="35"></a></div></td></tr><tr><td colspan="2"><div class="row-fluid" style="text-align: center"><input type="hidden" name="trackerStatus" id="trackerStatus" value="<?php echo $_smarty_tpl->tpl_vars['STATUS']->value;?>
"/><button type="button" class="btn btn-success" style="padding: 4px; width: 210px;" id="controlButton" data-start-label="<?php echo vtranslate('LBL_START',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-complete-label="<?php echo vtranslate('LBL_COMPLETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-resume-label="<?php echo vtranslate('LBL_RESUME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-status="<?php echo $_smarty_tpl->tpl_vars['STATUS']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['STATUS']->value=='running'){?><?php echo vtranslate('LBL_COMPLETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }elseif($_smarty_tpl->tpl_vars['STATUS']->value=='pause'){?><?php echo vtranslate('LBL_RESUME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><?php echo vtranslate('LBL_START_TIMER_FOR',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getName();?>
<?php }else{ ?><?php ob_start();?><?php echo vtranslate('LBL_START',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
<?php }?><?php }?></button><input type="hidden" name="record_name" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getName();?>
"/></div></td></tr></table></div></div></form><?php if ($_smarty_tpl->tpl_vars['LIST_TIMER_ACTIVE']->value[0]){?><div class="modal-header contentsBackground" style="text-align: center; border-bottom: none; "><h3 style="color: #004123;"><?php echo vtranslate('LBL_ACTIVE_TIMERS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><table class="table table-bordered listViewEntriesTable" id="listActiveTimers"><?php  $_smarty_tpl->tpl_vars['TIMER_DATA'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TIMER_DATA']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LIST_TIMER_ACTIVE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TIMER_DATA']->key => $_smarty_tpl->tpl_vars['TIMER_DATA']->value){
$_smarty_tpl->tpl_vars['TIMER_DATA']->_loop = true;
?><tr id="record_<?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['record'];?>
"><td class="summaryViewEntries"><span class="alignCenter " style="color: #004123;"><a class="record_name" href="index.php?module=<?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['form_data']['module'];?>
&record=<?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['record'];?>
&view=Detail" style="display:inline-block;overflow: hidden;width: 145px;white-space: nowrap;text-overflow: ellipsis;-o-text-overflow: ellipsis;-ms-text-overflow: ellipsis;" title="<?php if ($_smarty_tpl->tpl_vars['TIMER_DATA']->value['name']!=''){?> <?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['name'];?>
 <?php }else{ ?> - <?php }?>"><?php if ($_smarty_tpl->tpl_vars['TIMER_DATA']->value['name']!=''){?> <?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['name'];?>
 <?php }else{ ?> - <?php }?></a></span></td><td class="summaryViewEntries " ><span  class="alignCenter <?php if ($_smarty_tpl->tpl_vars['TIMER_DATA']->value['status']=='running'){?>timeTrackerTotalRunning<?php }?> timeValue" style="color: #2787e0;"><?php if ($_smarty_tpl->tpl_vars['TIMER_DATA']->value['form_data']['timeTrackerTotal']!=''){?> <?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['form_data']['timeTrackerTotal'];?>
 <?php }else{ ?> - <?php }?></span></td><td class="summaryViewEntries "><span class="alignMiddle"><a class="play_icon" href="index.php?module=<?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['form_data']['module'];?>
&record=<?php echo $_smarty_tpl->tpl_vars['TIMER_DATA']->value['record'];?>
&view=Detail&go_back=1"><img src="layouts/vlayout/modules/TimeTracker/images/go_play_pause.png" alt="Go back record"/></a></span></td></tr><?php } ?><tr class="hide row_base"><td class="summaryViewEntries"><span class="alignCenter " style="color: #004123;"><a class="record_name" href="javascript:voice(0)" style="display:inline-block;overflow: hidden;width: 145px;white-space: nowrap;text-overflow: ellipsis;-o-text-overflow: ellipsis;-ms-text-overflow: ellipsis;" title=""</a></span></td><td class="summaryViewEntries" ><span class="alignCenter timeTrackerTotal timeValue" style="color: #2787e0;"></span></td><td class="summaryViewEntries "><span class="alignMiddle"><a class="play_icon" href="javascript:voice(0)"><img src="layouts/vlayout/modules/TimeTracker/images/go_play_pause.png" alt="Go back record"/></a></span></td></tr></table><?php }?></div></div><?php }} ?>