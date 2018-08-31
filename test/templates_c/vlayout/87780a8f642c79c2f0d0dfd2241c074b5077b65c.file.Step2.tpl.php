<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 16:17:19
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/SumField/Step2.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13986559845b7d8c8fb63966-34577223%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87780a8f642c79c2f0d0dfd2241c074b5077b65c' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/SumField/Step2.tpl',
      1 => 1472554746,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13986559845b7d8c8fb63966-34577223',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'SITE_URL' => 0,
    'VTELICENSE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7d8c8fb95ba',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7d8c8fb95ba')) {function content_5b7d8c8fb95ba($_smarty_tpl) {?>
<div class="installationContents" style="padding-left: 3%;padding-right: 3%"><form name="EditWorkflow" action="index.php" method="post" id="installation_step2" class="form-horizontal"><input type="hidden" class="step" value="2" /><div class="padding1per" style="border:1px solid #ccc;"><label><strong><?php echo vtranslate('LBL_WELCOME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate('MODULE_LBL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate('LBL_INSTALLATION_WIZARD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></label><br><div class="control-group"><div><span><?php echo vtranslate('LBL_YOU_ARE_REQUIRED_VALIDATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></div></div><div class="control-group" style="margin-bottom:10px;"><div class="control-label"><strong><?php echo vtranslate('LBL_VTIGER_URL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></div><div class="controls" style="margin-top: 5px;"><span><?php echo $_smarty_tpl->tpl_vars['SITE_URL']->value;?>
</span></div></div><div class="control-group" style="margin-bottom:10px;"><div class="control-label"><strong><?php echo vtranslate('LBL_LICENSE_KEY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></div><div class="controls"><input type="text" id="license_key" name="license_key" value="" data-validation-engine="validate[required]" class="span4" name="summary"></div></div><?php if ($_smarty_tpl->tpl_vars['VTELICENSE']->value->result=='bad'||$_smarty_tpl->tpl_vars['VTELICENSE']->value->result=='invalid'){?><div class="alert alert-error" id="error_message"><?php echo $_smarty_tpl->tpl_vars['VTELICENSE']->value->message;?>
</div><?php }?><div class="control-group"><div><span><?php echo vtranslate('LBL_HAVE_TROUBLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <?php echo vtranslate('LBL_CONTACT_US',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></div></div><div class="control-group"><ul style="padding-left: 10px;"><li><?php echo vtranslate('LBL_EMAIL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
: &nbsp;&nbsp;<a href="mailto:Support@VTExperts.com">Support@VTExperts.com</a></li><li><?php echo vtranslate('LBL_PHONE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
: &nbsp;&nbsp;<span>+1 (818) 495-5557</span></li><li><?php echo vtranslate('LBL_CHAT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
: &nbsp;&nbsp;<?php echo vtranslate('LBL_AVAILABLE_ON',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <a href="http://www.vtexperts.com" target="_blank">http://www.VTExperts.com</a></li></ul></div><div class="control-group" style="text-align: center;"><button class="btn btn-success" name="btnActivate" type="button"><strong><?php echo vtranslate('LBL_ACTIVATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button><button class="btn btn-info" name="btnOrder" type="button" onclick="window.open('http://www.vtexperts.com/extension/vtiger-related-record-update-workflow/')"><strong><?php echo vtranslate('LBL_ORDER_NOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div></div></div><div class="clearfix"></div></form></div><?php }} ?>