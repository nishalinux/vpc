<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:24:45
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Rss/SideBarLinks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5875686715b733a8d3b7b39-75945619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e6a771f1bb8e62e09b7ef676e0aff2305bc50e2a' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Rss/SideBarLinks.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5875686715b733a8d3b7b39-75945619',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUICK_LINKS' => 0,
    'SIDEBARLINK' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b733a8d3dc53',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b733a8d3dc53')) {function content_5b733a8d3dc53($_smarty_tpl) {?>
<div class="quickLinksDiv"><?php $_smarty_tpl->tpl_vars['SIDEBARLINK'] = new Smarty_variable($_smarty_tpl->tpl_vars['QUICK_LINKS']->value['SIDEBARLINK'][0], null, 0);?><div style="margin-bottom: 5px" class="btn-group row-fluid"><button id="rssAddButton" class="btn addButton span12 rssAddButton" data-href="<?php echo $_smarty_tpl->tpl_vars['SIDEBARLINK']->value->getUrl();?>
"><img src="layouts/vlayout/skins/images/rss_add.png" /><strong>&nbsp;&nbsp; <?php echo vtranslate($_smarty_tpl->tpl_vars['SIDEBARLINK']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></div><div class="rssAddFormContainer hide"></div></div><?php }} ?>