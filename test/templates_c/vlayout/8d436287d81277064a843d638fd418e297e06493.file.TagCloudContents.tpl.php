<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 21:14:41
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/dashboards/TagCloudContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17364398215b734641b00476-36702013%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8d436287d81277064a843d638fd418e297e06493' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/dashboards/TagCloudContents.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17364398215b734641b00476-36702013',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TAGS' => 0,
    'TAG_ID' => 0,
    'TAG_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b734641b1568',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b734641b1568')) {function content_5b734641b1568($_smarty_tpl) {?>
<div class="tagsContainer" id="tagCloud"><?php  $_smarty_tpl->tpl_vars['TAG_ID'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TAG_ID']->_loop = false;
 $_smarty_tpl->tpl_vars['TAG_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['TAGS']->value[1]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TAG_ID']->key => $_smarty_tpl->tpl_vars['TAG_ID']->value){
$_smarty_tpl->tpl_vars['TAG_ID']->_loop = true;
 $_smarty_tpl->tpl_vars['TAG_NAME']->value = $_smarty_tpl->tpl_vars['TAG_ID']->key;
?><a class="tagName cursorPointer" data-tagid="<?php echo $_smarty_tpl->tpl_vars['TAG_ID']->value;?>
" rel="<?php echo $_smarty_tpl->tpl_vars['TAGS']->value[0][$_smarty_tpl->tpl_vars['TAG_NAME']->value];?>
"><?php echo $_smarty_tpl->tpl_vars['TAG_NAME']->value;?>
</a>&nbsp;<?php } ?></div>	<?php }} ?>