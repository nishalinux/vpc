<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:15:36
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/Login.Custom.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15497083805b730e381740f2-90046056%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '27853c2bc2e733a0e84ad1ca493363ce210af6ea' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/Login.Custom.tpl',
      1 => 1533820399,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15497083805b730e381740f2-90046056',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b730e3817c7a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b730e3817c7a')) {function content_5b730e3817c7a($_smarty_tpl) {?>
<?php $_smarty_tpl->smarty->_tag_stack[] = array('php', array()); $_block_repeat=true; echo smarty_php_tag(array(), null, $_smarty_tpl, $_block_repeat);while ($_block_repeat) { ob_start();?>

	require_once "modules/Settings/LoginPage/views/VTigress_Theme_Settings.php";
<?php $_block_content = ob_get_clean(); $_block_repeat=false; echo smarty_php_tag(array(), $_block_content, $_smarty_tpl, $_block_repeat); } array_pop($_smarty_tpl->smarty->_tag_stack);?>

<?php }} ?>