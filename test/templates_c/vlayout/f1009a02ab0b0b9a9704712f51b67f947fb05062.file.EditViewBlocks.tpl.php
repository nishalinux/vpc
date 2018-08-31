<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:17:53
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/EditViewBlocks.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19750293765b7338f1baa190-72386732%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f1009a02ab0b0b9a9704712f51b67f947fb05062' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/EditViewBlocks.tpl',
      1 => 1532585234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19750293765b7338f1baa190-72386732',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PRODUCT_CATEGORIES' => 0,
    'categoryname' => 0,
    'categoryid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7338f1bcc08',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7338f1bcc08')) {function content_5b7338f1bcc08($_smarty_tpl) {?><script>var core_productcategory = {};</script><?php  $_smarty_tpl->tpl_vars['categoryname'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categoryname']->_loop = false;
 $_smarty_tpl->tpl_vars['categoryid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PRODUCT_CATEGORIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categoryname']->key => $_smarty_tpl->tpl_vars['categoryname']->value){
$_smarty_tpl->tpl_vars['categoryname']->_loop = true;
 $_smarty_tpl->tpl_vars['categoryid']->value = $_smarty_tpl->tpl_vars['categoryname']->key;
?><script>var pname = "<?php echo $_smarty_tpl->tpl_vars['categoryname']->value;?>
";var pcid = <?php echo $_smarty_tpl->tpl_vars['categoryid']->value;?>
;core_productcategory[pname] = pcid;</script><?php } ?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("EditViewBlocksVtiger.tpl",'ProcessFlow'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("LineItemsEdit.tpl",'ProcessFlow'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div id="idProceessData"></div><?php }} ?>