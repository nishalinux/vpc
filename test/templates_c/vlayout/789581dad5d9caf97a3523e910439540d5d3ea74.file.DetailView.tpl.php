<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 16:07:28
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16191479685b73a53a29c2e5-43895836%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '789581dad5d9caf97a3523e910439540d5d3ea74' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailView.tpl',
      1 => 1534922051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16191479685b73a53a29c2e5-43895836',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73a53a2b146',
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73a53a2b146')) {function content_5b73a53a2b146($_smarty_tpl) {?>
<div><div class="detailViewTopMenuDiv"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('DetailViewHeader.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="detailViewContentDiv" id="detailViewContents"><br><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('DetailViewContents.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div></div><?php }} ?>