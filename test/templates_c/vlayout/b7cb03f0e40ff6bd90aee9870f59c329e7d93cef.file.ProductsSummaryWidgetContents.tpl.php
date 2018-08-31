<?php /* Smarty version Smarty-3.1.7, created on 2018-08-24 17:35:25
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/ProductsSummaryWidgetContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12289955225b8041ddd3f4d6-54305854%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b7cb03f0e40ff6bd90aee9870f59c329e7d93cef' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/ProductsSummaryWidgetContents.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12289955225b8041ddd3f4d6-54305854',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RELATED_HEADERS' => 0,
    'HEADER' => 0,
    'MODULE' => 0,
    'PRODUCT_NAME_HEADER' => 0,
    'PRODUCT_UNITPRICE_HEADER' => 0,
    'RELATED_RECORDS' => 0,
    'RELATED_RECORD' => 0,
    'RELATED_MODULE' => 0,
    'NUMBER_OF_RECORDS' => 0,
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b8041dddeaab',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b8041dddeaab')) {function content_5b8041dddeaab($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['HEADER'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['HEADER']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_HEADERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['HEADER']->key => $_smarty_tpl->tpl_vars['HEADER']->value){
$_smarty_tpl->tpl_vars['HEADER']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['HEADER']->value->get('label')=="Product Name"){?><?php ob_start();?><?php echo vtranslate($_smarty_tpl->tpl_vars['HEADER']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['PRODUCT_NAME_HEADER'] = new Smarty_variable($_tmp1, null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['HEADER']->value->get('label')=="Unit Price"){?><?php ob_start();?><?php echo vtranslate($_smarty_tpl->tpl_vars['HEADER']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
<?php $_tmp2=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['PRODUCT_UNITPRICE_HEADER'] = new Smarty_variable($_tmp2, null, 0);?><?php }?><?php } ?><div class="row-fluid"><span class="span7"><strong><?php echo $_smarty_tpl->tpl_vars['PRODUCT_NAME_HEADER']->value;?>
</strong></span><span class="span4"><span class="pull-right"><strong><?php echo $_smarty_tpl->tpl_vars['PRODUCT_UNITPRICE_HEADER']->value;?>
</strong></span></span></div><?php  $_smarty_tpl->tpl_vars['RELATED_RECORD'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RELATED_RECORD']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_RECORDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RELATED_RECORD']->key => $_smarty_tpl->tpl_vars['RELATED_RECORD']->value){
$_smarty_tpl->tpl_vars['RELATED_RECORD']->_loop = true;
?><div class="recentActivitiesContainer"><ul class="unstyled"><li><div class="row-fluid"><span class="span7 textOverflowEllipsis"><a href="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDetailViewUrl();?>
" id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE']->value;?>
_Related_Record_<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->get('id');?>
" title="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('productname');?>
"><?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('productname');?>
</a></span><span class="span4"><span class="pull-right"><?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue('unit_price');?>
</span></span></div></li></ul></div><?php } ?><?php $_smarty_tpl->tpl_vars['NUMBER_OF_RECORDS'] = new Smarty_variable(count($_smarty_tpl->tpl_vars['RELATED_RECORDS']->value), null, 0);?><?php if ($_smarty_tpl->tpl_vars['NUMBER_OF_RECORDS']->value==5){?><div class="row-fluid"><div class="pull-right"><a class="moreRecentProducts cursorPointer"><?php echo vtranslate('LBL_MORE',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</a></div></div><?php }?><?php }} ?>