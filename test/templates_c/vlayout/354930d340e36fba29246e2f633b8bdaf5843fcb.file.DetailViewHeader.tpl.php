<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 16:07:28
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailViewHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:556671355b73a53a2b4637-09410688%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '354930d340e36fba29246e2f633b8bdaf5843fcb' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailViewHeader.tpl',
      1 => 1534922051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '556671355b73a53a2b4637-09410688',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73a53a2d75c',
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'ISSUES_LIST' => 0,
    'PICKLIST_MODULES_LIST' => 0,
    'SELECTED_MODULE_NAME' => 0,
    'PICKLIST_MODULE' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73a53a2d75c')) {function content_5b73a53a2d75c($_smarty_tpl) {?>
<div class="container-fluid"><div class="widget_header row-fluid"><h3><?php echo vtranslate('LBL_VTLOGIN_HISTORY_DETAILS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3><!-- <?php echo print_r($_smarty_tpl->tpl_vars['ISSUES_LIST']->value);?>
 --></div><hr><div class="row-fluid"><span class="span8 btn-toolbar"><!-- <select class="chzn-select chzn-done" id="basicSearchModulesList" > --><select class="chzn-select picklistFilter" id="picklistFilter" name="picklistFilter"><optgroup><option value=""><?php echo vtranslate('LBL_ALL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['PICKLIST_MODULE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->_loop = false;
 $_smarty_tpl->tpl_vars['LIST'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_MODULES_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->key => $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_MODULE']->_loop = true;
 $_smarty_tpl->tpl_vars['LIST']->value = $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->key;
?><option  <?php if ($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value==$_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value->get('name')){?> selected="" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value->get('name');?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value->get('label'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?></optgroup></select></span><input type="hidden" value="<?php echo json_encode($_smarty_tpl->tpl_vars['ISSUES_LIST']->value);?>
" id="tabledata"><span class="span4 btn-toolbar"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('DetailViewActions.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</span></div><div class="clearfix"></div><div class="detailViewContentDiv" id="detailViewContents">
<?php }} ?>