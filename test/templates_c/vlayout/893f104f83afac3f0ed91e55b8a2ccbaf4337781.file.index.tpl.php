<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 21:17:59
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/OSSMail/index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:428306595b734707a33f02-97130726%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '893f104f83afac3f0ed91e55b8a2ccbaf4337781' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/OSSMail/index.tpl',
      1 => 1530098856,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '428306595b734707a33f02-97130726',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SENDEREMAIL' => 0,
    'SENDERID' => 0,
    'ATTACHPDF' => 0,
    'URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b734707a3e98',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b734707a3e98')) {function content_5b734707a3e98($_smarty_tpl) {?>
<input type="hidden" value="" id="tempField" name="tempField"/>
<script>
var height = window.innerHeight;

$(document).ready( function(){
	$('#roundcube_interface').css('height', height-83);
  
} );
</script>
<input type="hidden" name="senderemail" id="senderemail" value="<?php echo $_smarty_tpl->tpl_vars['SENDEREMAIL']->value;?>
">
<input type="hidden" name="senderid" id="senderid" value="<?php echo $_smarty_tpl->tpl_vars['SENDERID']->value;?>
">
<input type="hidden" name="attachpdf" id="attachpdf" value="<?php echo $_smarty_tpl->tpl_vars['ATTACHPDF']->value;?>
">
<iframe id="roundcube_interface" name="roundcube_interface" style="width: 100%; height: 590px;margin-bottom: -5px;" frameborder="0" src="<?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
" frameborder="0" onload="osmailclicked()" onKeyPress="osmailclicked()"> </iframe>
<?php }} ?>