<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 16:53:45
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2UserSettings/ConfigUserSettingsEditorEdit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4911071555b745a99862a45-75311382%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '42828caed87d493e8fe6bebd86771a8afc64b78c' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2UserSettings/ConfigUserSettingsEditorEdit.tpl',
      1 => 1533802051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4911071555b745a99862a45-75311382',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'CURRENT_USER_MODEL' => 0,
    'WIDTHTYPE' => 0,
    'USERFIELDS' => 0,
    'USERSETTINGS' => 0,
    'FIELD_VALIDATION' => 0,
    'FIELD_NAME' => 0,
    'i' => 0,
    'keys' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b745a9998732',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b745a9998732')) {function content_5b745a9998732($_smarty_tpl) {?>
<div class="container-fluid"><div class="contents"><form id="ConfigUserSettingsEditorForm" class="form-horizontal" data-detail-url="<?php echo $_smarty_tpl->tpl_vars['MODEL']->value->getDetailViewUrl();?>
" method="POST"><div class="widget_header row-fluid"><div class="span8"><h3><?php echo vtranslate('LBL_USER_CONFIG_EDITOR',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>&nbsp;<?php echo vtranslate('LBL_CONFIG_DESCRIPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div><div class="span4 btn-toolbar"><div class="pull-right"><button class="btn btn-success saveButton" type="submit" title="<?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button><a type="reset" class="cancelLink" title="<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div></div></div><hr><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->get('rowheight'), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALIDATION'] = new Smarty_variable(array('UC_EMAIL_ID_ONE'=>array('name'=>'Email'),'UC_EMAIL_ID_TWO'=>array('name'=>'Email'),'max_login_attempts'=>array('name'=>'NumberRange5')), null, 0);?><table class="table table-bordered table-condensed themeTableColor"><thead><tr class="blockHeader"><th colspan="2" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
">Common Configuration for Users</th></tr></thead><tbody><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['failed_logins_criteria']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span class="span3"><select class="select2 row-fluid" name="failed_logins_criteria"><option value="0" <?php if ("0"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>No check for failed login</option><option value="1" <?php if ("1"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>IP Check</option><option value="2" <?php if ("2"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>Calendar Check</option><option value="3" <?php if ("3"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>Calendar and IP Check</option><option value="4" <?php if ("4"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>Password Check</option><option value="5" <?php if ("5"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>PW and IP Check</option><option value="6" <?php if ("6"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>PW and Calendar Check</option><option value="7" <?php if ("7"==$_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']){?> selected <?php }?>>PW, Calendar and IP Check</option></select></span></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['max_login_attempts']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="max_login_attempts" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['max_login_attempts']){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['max_login_attempts']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['max_login_attempts'];?>
"  /></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['UC_NAME_ONE']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="UC_NAME_ONE" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_NAME_ONE']){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_NAME_ONE']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_name_one'];?>
"  /></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['UC_EMAIL_ID_ONE']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="UC_EMAIL_ID_ONE" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_EMAIL_ID_ONE']){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_EMAIL_ID_ONE']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_email_id_one'];?>
"  /></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['UC_NAME_TWO']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="UC_NAME_TWO" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_NAME_TWO']){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_NAME_TWO']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_name_two'];?>
"  /></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['UC_EMAIL_ID_TWO']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="UC_EMAIL_ID_TWO" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_EMAIL_ID_TWO']){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['UC_EMAIL_ID_TWO']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_email_id_two'];?>
"  /></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['Working_Hours_start']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><div class="input-append time"><input type="text" name="Working_Hours_start" data-format="24" data-toregister="time" class="timepicker-default input-small" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['Working_Hours_start']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['working_hours_start'];?>
"/><span class="add-on cursorPointer"><i class="icon-time"></i></span></div></td></tr><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['Working_Hours_end']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><div class="input-append time"><input type="text" name="Working_Hours_end" data-format="24" data-toregister="time" class="timepicker-default input-small" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if ($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value[$_smarty_tpl->tpl_vars['FIELD_NAME']->value]){?> data-validator=<?php echo Zend_Json::encode(array($_smarty_tpl->tpl_vars['FIELD_VALIDATION']->value['Working_Hours_end']));?>
 <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['working_hours_end'];?>
"/><span class="add-on cursorPointer"><i class="icon-time"></i></span></div></td></tr><tr><input type="hidden" name="totaldays" id="" value="6"><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php echo $_smarty_tpl->tpl_vars['USERFIELDS']->value['working_week_days']['label'];?>
</label></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php if (!empty($_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?><input type="checkbox" name="week_0" value="Sunday" <?php if (in_array("Sunday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?> > &nbsp; Sunday&nbsp;<input type="checkbox" name="week_1" value="Monday" <?php if (in_array("Monday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?>> &nbsp; Monday&nbsp;<input type="checkbox" name="week_2" value="Tuesday" <?php if (in_array("Tuesday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?>> &nbsp; Tuesday&nbsp;<input type="checkbox" name="week_3" value="Wednesday" <?php if (in_array("Wednesday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?>> &nbsp; Wednesday&nbsp;<input type="checkbox" name="week_4" value="Thursday" <?php if (in_array("Thursday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?>> &nbsp; Thursday&nbsp;<input type="checkbox" name="week_5" value="Friday" <?php if (in_array("Friday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?>> &nbsp; Friday&nbsp;<input type="checkbox" name="week_6" value="Saturday" <?php if (in_array("Saturday",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?>checked<?php }?>> &nbsp; Saturday&nbsp;<?php }else{ ?><input type="checkbox" name="week_0" value="Sunday"> &nbsp; Sunday&nbsp;<input type="checkbox" name="week_1" value="Monday"> &nbsp; Monday&nbsp;<input type="checkbox" name="week_2" value="Tuesday"> &nbsp; Tuesday&nbsp;<input type="checkbox" name="week_3" value="Wednesday"> &nbsp; Wednesday&nbsp;<input type="checkbox" name="week_4" value="Thursday"> &nbsp; Thursday&nbsp;<input type="checkbox" name="week_5" value="Friday"> &nbsp; Friday&nbsp;<input type="checkbox" name="week_6" value="Saturday"> &nbsp; Saturday&nbsp;<?php }?></td></tr></tbody><table class="table table-bordered table-condensed themeTableColor"><thead><tr class="blockHeader"><th colspan="2" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
">Holidays</th></tr><tr class="blockHeader"><th class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
">Name</th><th class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
">Date</th></tr></thead><tbody id="holiday_name_date"><?php if (!empty($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val'])){?><?php $_smarty_tpl->tpl_vars['keys'] = new Smarty_variable(array_keys($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val']), null, 0);?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 0;
  if ($_smarty_tpl->tpl_vars['i']->value<count($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val'])){ for ($_foo=true;$_smarty_tpl->tpl_vars['i']->value<count($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val']); $_smarty_tpl->tpl_vars['i']->value++){
?><tr id="tr_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="holiday_lbl_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"   value="<?php echo $_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->tpl_vars['i']->value];?>
" placeholder="Holiday Name"/></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><div class="input-append row-fluid"><div class="span12 row-fluid date"><input type="text" id="holiday_val_0" data-date-format="yyyy-mm-dd" name="holiday_val_<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
" class="dateField" value="<?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val'][$_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->tpl_vars['i']->value]];?>
" placeholder="YYYY-MM-DD"/><span class="add-on"><i class="icon-calendar"></i></span><div class="span6 pull-left holidaybuttons"><?php if ($_smarty_tpl->tpl_vars['i']->value==0){?><button class="btn btn-success addHolidayRow" type="button" title="Add"><strong>Add</strong></button><?php }?><?php if ($_smarty_tpl->tpl_vars['i']->value>0){?><a type="" class="Link removeHolidayRow" title="Remove">Remove</a><?php }?></div></div></div></td></tr><?php }} ?><?php }else{ ?><tr id="tr_0"><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="holiday_lbl_0"   value="<?php echo $_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->tpl_vars['i']->value];?>
" placeholder="Holiday Name"/></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><div class="input-append row-fluid"><div class="span12 row-fluid date"><input type="text" id="holiday_val_0" data-date-format="yyyy-mm-dd" name="holiday_val_0" class="dateField" value="" placeholder="YYYY-MM-DD"/><span class="add-on"><i class="icon-calendar"></i></span><div class="span6 pull-left holidaybuttons"><button class="btn btn-success addHolidayRow" type="button" title="Add"><strong>Add</strong></button></div></div></div></td></tr><?php }?></tbody></table><input type="hidden" name="totalcount" id="totalcount" value="<?php echo count($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val']);?>
"><input type="hidden" name="itemcount" id="itemcount" value="<?php echo count($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val']);?>
"></form></div></div>
<script>
$(document).ready(function(){
	var tc = $('#idHdnTermsConditions').val();
	$('#idTextareaTC').val(tc);	
		var itemcount = $("#itemcount").val();
	$(".addHolidayRow").click(function(){
		itemcount++;
		var html = '<tr id="tr_'+itemcount+'"><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type="text" name="holiday_lbl_'+itemcount+'"   value="" placeholder="Holiday Name"/></td><td style="border-left: none;" class="row-fluid <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><div class="input-append row-fluid"><div class="span12 row-fluid date"><input type="text" id="holiday_val_'+itemcount+'" data-date-format="yyyy-mm-dd" name="holiday_val_'+itemcount+'" class="dateField" value="" placeholder="YYYY-MM-DD"/><span class="add-on"><i class="icon-calendar"></i></span><div class="span6 pull-left holidaybuttons"><a type="" class="Link removeHolidayRow" title="Remove">Remove</a></div></div></div></td></tr>';
		$("#holiday_name_date").append(html);	
		$('#itemcount').val(itemcount);
	});
	
	$(".removeHolidayRow").click(function(){
		if(itemcount > 0)
		{
			$('#tr_'+itemcount).remove();
			itemcount--;
			$('#itemcount').val(itemcount);
		}
	});
});
</script>
<?php }} ?>