<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:36:51
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/TimeTracker/TimerTrackerPopupForAll.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13892784655b7313333aefa7-48434387%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '83a0ceb72d3b089e72f4454bb47ab4573e1fb803' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/TimeTracker/TimerTrackerPopupForAll.tpl',
      1 => 1507143471,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13892784655b7313333aefa7-48434387',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SETTINGS' => 0,
    'FORM_DATA' => 0,
    'RECORD_RUNNING' => 0,
    'LIST_TIMER_ACTIVE' => 0,
    'QUALIFIED_MODULE' => 0,
    'TIMER_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73133340353',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73133340353')) {function content_5b73133340353($_smarty_tpl) {?>
<div style="width: 270px;"><div class="modelContainer" id=""><form class="form-horizontal timeTrackerForm" name="TrackerForm" method="post" action="index.php"><div class="quickCreateContent"><div class="modal-body"><?php $_smarty_tpl->tpl_vars['FIELD_SETTINGS'] = new Smarty_variable($_smarty_tpl->tpl_vars['SETTINGS']->value['field_settings'], null, 0);?><table style="margin: 0 auto;"><tr><td class="fieldValue medium" colspan="2"><input type="hidden" id="timeTrackerTotal" name="form_data[timeTrackerTotal]" value="<?php echo $_smarty_tpl->tpl_vars['FORM_DATA']->value['timeTrackerTotal'];?>
" /><?php if ($_smarty_tpl->tpl_vars['RECORD_RUNNING']->value){?><input type="hidden" id="timeTrackerTotalRunning" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['form_data']['timeTrackerTotal'];?>
" /><input type="hidden" id="record_running" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_RUNNING']->value['record'];?>
" /><?php }?><div class="row-fluid" style="text-align: center"><?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['allow_create_comments']==1){?><input type="hidden" id="auto_comment" name="form_data[auto_comment]" value="<?php echo $_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments'];?>
"><a href="javascript:void(0);" id="commentIcon" data-auto-comment="<?php echo $_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments'];?>
" style="margin: 0 10px;display: inline-block;"><img src="layouts/vlayout/modules/TimeTracker/images/comment-on.jpg" width="35" id="commnentOn" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments']!=1&&$_smarty_tpl->tpl_vars['FORM_DATA']->value['auto_comment']!=1){?>style="display: none;" <?php }?>/><img src="layouts/vlayout/modules/TimeTracker/images/comment-off.jpg" width="35" id="commentOff" <?php if ($_smarty_tpl->tpl_vars['SETTINGS']->value['auto_create_comments']==1||$_smarty_tpl->tpl_vars['FORM_DATA']->value['auto_comment']==1){?>style="display: none;" <?php }?>/></a><?php }else{ ?>&nbsp;<?php }?><a href="javascript:void(0);" id="btnPause" style="margin: 0 10px;display: inline-block;"><img src="layouts/vlayout/modules/TimeTracker/images/pause.jpg" width="35"></a><a href="javascript:void(0);" id="btnCancel" style="margin-left: 20px;display: inline-block;"><img src="layouts/vlayout/modules/TimeTracker/images/cancel.gif" width="35"></a></div></td></tr></table></div></div></form><?php if ($_smarty_tpl->tpl_vars['LIST_TIMER_ACTIVE']->value[0]){?><div class="modal-header contentsBackground" style="text-align: center; border-bottom: none; "><h3 style="color: #004123;"><?php echo vtranslate('LBL_ACTIVE_TIMERS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
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
&view=Detail&go_back=1"><img src="layouts/vlayout/modules/TimeTracker/images/go_play_pause.png" alt="Go back record"/></a></span></td></tr><?php } ?><tr class="hide row_base"><td class="summaryViewEntries"><span class="alignCenter " style="color: #004123;"><a class="record_name" href="javascript:voice(0)" style="display:inline-block;overflow: hidden;width: 145px;white-space: nowrap;text-overflow: ellipsis;-o-text-overflow: ellipsis;-ms-text-overflow: ellipsis;" title=""</a></span></td><td class="summaryViewEntries" ><span class="alignCenter timeTrackerTotal timeValue" style="color: #2787e0;"></span></td><td class="summaryViewEntries "><span class="alignMiddle"><a class="play_icon" href="javascript:voice(0)"><img src="layouts/vlayout/modules/TimeTracker/images/go_play_pause.png" alt="Go back record"/></a></span></td></tr></table><input type="hidden" id="listActiveTimer" value="1" /><?php }else{ ?><input type="hidden" id="listActiveTimer" value="0" /><?php }?></div></div><?php }} ?>