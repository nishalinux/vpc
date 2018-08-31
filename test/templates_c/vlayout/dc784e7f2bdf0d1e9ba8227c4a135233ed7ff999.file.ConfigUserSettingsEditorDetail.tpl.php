<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 04:48:36
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2UserSettings/ConfigUserSettingsEditorDetail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8158407715b73b0a4a905a6-02212811%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dc784e7f2bdf0d1e9ba8227c4a135233ed7ff999' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2UserSettings/ConfigUserSettingsEditorDetail.tpl',
      1 => 1533809902,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8158407715b73b0a4a905a6-02212811',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CURRENT_USER_MODEL' => 0,
    'MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'WIDTHTYPE' => 0,
    'USERSETTINGS' => 0,
    'i' => 0,
    'keys' => 0,
    'FIELD_NAME' => 0,
    'FIELD_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73b0a4b116c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73b0a4b116c')) {function content_5b73b0a4b116c($_smarty_tpl) {?>
<div class="container-fluid" id="ConfigUserSettingsEditorDetails"><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->get('rowheight'), null, 0);?><div class="widget_header row-fluid"><div class="span8"><h3>OS2UserSettings Configuration</h3></div><div class="span4"><div class="pull-right"><button class="btn editButtonUserSettings" data-url='<?php echo $_smarty_tpl->tpl_vars['MODEL']->value->getEditViewUrl();?>
' type="button" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><strong><?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div></div></div><hr><div class="contents"><table class="table table-bordered table-condensed themeTableColor"><thead><tr class="blockHeader"><th colspan="2" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span class="alignMiddle">Common Configuration for Users</span></th></tr></thead><tbody><?php $_smarty_tpl->tpl_vars['FIELD_DATA'] = new Smarty_variable($_smarty_tpl->tpl_vars['MODEL']->value->getViewableData(), null, 0);?><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Failed Logins Criteria</label></td><td style="border-left: none;" class="medium"><span><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==0){?>No check for failed login<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==1){?>IP Check<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==2){?>Calendar Check<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==3){?>Calendar and IP Check<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==4){?>Password Check<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==5){?>PW and IP Check<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==6){?>PW and Calendar Check<?php }?><?php if ($_smarty_tpl->tpl_vars['USERSETTINGS']->value['failed_logins_criteria']==7){?>PW, Calendar and IP Check<?php }?></span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Max Login Attempts</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['max_login_attempts'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Security Observer Name 1	</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_name_one'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Security Observer Email 1	</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_email_id_one'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Security Observer Name 2	</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_name_two'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Security Observer Email 2	</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['uc_email_id_two'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Working Hours Start</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['working_hours_start'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Working Hours Start</label></td><td style="border-left: none;" class="medium"><span><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['working_hours_end'];?>
</span></td></tr><tr><td width="30%" class="medium"><label class="muted marginRight10px pull-right">Working Week Days</label></td><?php if (!empty($_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks'])){?><td style="border-left: none;" class="medium"><span><?php echo implode(",",$_smarty_tpl->tpl_vars['USERSETTINGS']->value['weeks']);?>
</span></td><?php }else{ ?><td style="border-left: none;" class="medium"><span></span></td><?php }?></tr></tbody></table><table class="table table-bordered table-condensed themeTableColor"><thead><tr class="blockHeader"><th colspan="2" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
">Holidays</th></tr><tr class="blockHeader"><th class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
" >Name</th><th class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
">Date</th></tr></thead><tbody><?php if (!empty($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val'])){?><?php $_smarty_tpl->tpl_vars['keys'] = new Smarty_variable(array_keys($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val']), null, 0);?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->value = 0;
  if ($_smarty_tpl->tpl_vars['i']->value<count($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val'])){ for ($_foo=true;$_smarty_tpl->tpl_vars['i']->value<count($_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val']); $_smarty_tpl->tpl_vars['i']->value++){
?><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted marginRight10px pull-right"><?php echo $_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->tpl_vars['i']->value];?>
 </label></td><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['USERSETTINGS']->value['holiday_lbl_val'][$_smarty_tpl->tpl_vars['keys']->value[$_smarty_tpl->tpl_vars['i']->value]];?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
 </span></td></tr><?php }} ?><?php }else{ ?><tr><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted marginRight10px pull-right"><?php echo $_smarty_tpl->tpl_vars['FIELD_DATA']->value['lbl'][$_smarty_tpl->tpl_vars['FIELD_NAME']->value];?>
 </label></td><td width="30%" class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span><?php echo $_smarty_tpl->tpl_vars['FIELD_DATA']->value['val'][$_smarty_tpl->tpl_vars['FIELD_NAME']->value];?>
 </span></td></tr><?php }?></tbody></table></div></div>
<?php }} ?>