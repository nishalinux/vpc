<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 08:25:19
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2CheckList/showWidgetActivies.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18163830405b77d7efc2ab32-22973109%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9bb9fd5aaea73213a54746d7f91f64684e13ecb1' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2CheckList/showWidgetActivies.tpl',
      1 => 1534579736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18163830405b77d7efc2ab32-22973109',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CHKLIST' => 0,
    'filterName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77d7efc50e9',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77d7efc50e9')) {function content_5b77d7efc50e9($_smarty_tpl) {?>

<div class="checklist" id="checklist"><div class=""><ul class="nav nav-list"><?php  $_smarty_tpl->tpl_vars['filterName'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['filterName']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CHKLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['filterName']->key => $_smarty_tpl->tpl_vars['filterName']->value){
$_smarty_tpl->tpl_vars['filterName']->_loop = true;
?><li><a class="vtchk" onclick="Settings_OS2Checklist_ClController_Js.triggerLoad(<?php echo $_smarty_tpl->tpl_vars['filterName']->value[1];?>
);" data-record="<?php echo $_smarty_tpl->tpl_vars['filterName']->value[1];?>
"><?php echo $_smarty_tpl->tpl_vars['filterName']->value[0];?>
</a></li><?php } ?></ul></div></div>
<?php }} ?>