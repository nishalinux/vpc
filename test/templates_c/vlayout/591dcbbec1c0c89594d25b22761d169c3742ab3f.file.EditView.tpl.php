<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:39:06
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/EditView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20709809495b7313ba1d5c26-47239177%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '591dcbbec1c0c89594d25b22761d169c3742ab3f' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/EditView.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20709809495b7313ba1d5c26-47239177',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7313ba1e0c1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7313ba1e0c1')) {function content_5b7313ba1e0c1($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewBlocks.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewActions.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>