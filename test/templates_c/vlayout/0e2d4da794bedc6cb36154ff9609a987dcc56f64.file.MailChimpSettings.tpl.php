<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 19:44:18
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/Mailchimp/MailChimpSettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13718037235b7b1a126a6035-78641967%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e2d4da794bedc6cb36154ff9609a987dcc56f64' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/Mailchimp/MailChimpSettings.tpl',
      1 => 1469835942,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13718037235b7b1a126a6035-78641967',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'APIKEY' => 0,
    'SUBSCRIBERTYPE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7b1a126d4a6',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7b1a126d4a6')) {function content_5b7b1a126d4a6($_smarty_tpl) {?>
<form  method="POST" name="mailchimpsettings"  id="mailchimpsettings" ><div id="MailchimpContainer" name="MailchimpContainer" class="container-fluid span12"><div class="widget_header row-fluid"><h3><?php echo vtranslate('LBL_SETUP_MODULE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3></div><hr><input class="btn editButton" id="editmailchimpconfig" name="editmailchimpconfig"   type="button" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" style ="visibility:hidden"  value="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"><div class="contents row-fluid paddingTop20"><table class="table table-bordered table-condensed themeTableColor"><input type='hidden' name='module' value='Mailchimp'><input type='hidden' name='action' value='saveMailchimpSettings'><tr class="blockHeader"><th class="medium" colspan="3"><?php echo vtranslate('LBL_MAILCHIMP_SETTINGS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</th></tr><tr class="opacity" ><td class="textAlignLeft medium span4" style="border-left: block;"><label class="span3 menuItemLabel"><?php echo vtranslate('LBL_ENTER_APP_KEY',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></td><td class="textAlignLeft medium" ><input class="span6" type="text" value="<?php echo $_smarty_tpl->tpl_vars['APIKEY']->value;?>
" name="apikey" id="apikey"></td></tr><tr class="opacity" ><td class="textAlignLeft medium" style="border-left: block;"><label class="span3 menuItemLabel"><?php echo vtranslate('LBL_CREATE_AS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></td><?php if ($_smarty_tpl->tpl_vars['SUBSCRIBERTYPE']->value=='lead'){?><td  class="small smalltxt"><input type="radio" name="newsubscriber" id="makeContact" value="contact"/><label for="makeContact"><?php echo vtranslate('LBL_CONTACTS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><input type="radio" name="newsubscriber" id="makeLead" value="lead" checked="true"  /><label for="makeLead"><?php echo vtranslate('LBL_LEADS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></td><?php }else{ ?><td  class="small smalltxt"><input type="radio" name="newsubscriber" id="makeContact" value="contact" checked="true" /><label for="makeContact"><?php echo vtranslate('LBL_CONTACTS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label><input type="radio" name="newsubscriber" id="makeLead" value="lead" /><label for="makeLead"><?php echo vtranslate('LBL_LEADS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></td><?php }?></tr></table></div><br><table ><tr ><td class="small" align="right" ><input class="btn btn-success saveButton" id="savemailchimpconfig" name="savemailchimpconfig" title="<?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"  type="button" value="<?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
">&nbsp;</td></tr></table></div></form><?php }} ?>