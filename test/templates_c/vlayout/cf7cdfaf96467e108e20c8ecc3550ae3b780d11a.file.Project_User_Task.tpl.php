<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 21:56:40
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProjectTask/Project_User_Task.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16387652885b774498e849d5-47214396%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cf7cdfaf96467e108e20c8ecc3550ae3b780d11a' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProjectTask/Project_User_Task.tpl',
      1 => 1501048884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16387652885b774498e849d5-47214396',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row_no' => 0,
    'pt_taskdata' => 0,
    'USERS_LIST_INFO' => 0,
    'GROUPS_LIST_INFO' => 0,
    'RECORD_ID' => 0,
    'dateFormat' => 0,
    'PT_VALUES' => 0,
    'PICKLIST_VALUE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b774498ebe8b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b774498ebe8b')) {function content_5b774498ebe8b($_smarty_tpl) {?><td style="15px;">
	<input type="hidden" name="task_userid<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" id="task_userid<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
"/>
	<span id="task_username<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['USERS_LIST_INFO']->value[$_smarty_tpl->tpl_vars['pt_taskdata']->value['userid']];?>

	<?php echo $_smarty_tpl->tpl_vars['GROUPS_LIST_INFO']->value[$_smarty_tpl->tpl_vars['pt_taskdata']->value['userid']];?>

	</span>
	<?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value){?>
	<a target="_blank" href="?module=ProjectTask&view=Detail&record=<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
&mode=showAllComments&tab_label=ModComments"><i class="icon-comment"></i></a>
	<?php }?>
</td>
<td style="25px;">
		<div class="input-append row-fluid">
			<div class="span12 row-fluid date">
			   <input id="task_startdate<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" type="text" style="width:70px;" data-date-format="<?php echo $_smarty_tpl->tpl_vars['dateFormat']->value;?>
" 
			   class="dateField input-small user_start_date" name="task_startdate<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['pt_taskdata']->value['start_date'];?>
"/>
			   <span class="add-on"><i class="icon-calendar"></i></span>
			</div>
		</div>
</td>
<td style="25px;">
		<div class="input-append row-fluid">
			<div class="span12 row-fluid date">
			   <input id="task_enddate<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" type="text" style="width:70px;" data-date-format="<?php echo $_smarty_tpl->tpl_vars['dateFormat']->value;?>
" 
			   class="dateField input-small user_end_date" name="task_enddate<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['pt_taskdata']->value['end_date'];?>
"/>
			   <span class="add-on"><i class="icon-calendar"></i></span>
			</div>
		</div>
</td>
<td style="10px;">
		<input type="text" name="task_allocatedhours<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" id="task_allocatedhours<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['pt_taskdata']->value['allocated_hours'];?>
" 
		style="width:120px;" class='user_task_allocatedhours'/>
</td>
<td style="10px;">
	<input type="text" name="task_workedhours<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" id="task_workedhours<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['pt_taskdata']->value['worked_hours'];?>
" 
		style="width:120px;" class='user_task_workedhours'/>
</td>
<td style="15px;">
	<select class="<?php if ($_smarty_tpl->tpl_vars['row_no']->value!=0){?> chzn-select <?php }?>" style="width:100px;" 
	 name="taskstatus<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" id="taskstatus<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
"  >
	   <option value=""><?php echo vtranslate('LBL_SELECT_OPTION','Vtiger');?>
</option>
	   <?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PT_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?>
	   <option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value);?>
" <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['pt_taskdata']->value['status'];?>
<?php $_tmp1=ob_get_clean();?><?php if (trim(decode_html($_tmp1))==trim($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value)){?> selected <?php }?>>
	   <?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>

	   </option>
	   <?php } ?>
	</select>
	<input type='hidden' name='notification<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
' value="<?php echo $_smarty_tpl->tpl_vars['pt_taskdata']->value['notification'];?>
" id='idNotification' >
</td>
<?php }} ?>