<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:19:47
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/GroupuserDetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12779830155b73396313e955-92212335%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5663510184c47daa8dc3d2b1d29ef5623a86dcba' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/GroupuserDetailView.tpl',
      1 => 1501687780,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12779830155b73396313e955-92212335',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'USER_MODEL' => 0,
    'FIELD_MODEL' => 0,
    'RECORD' => 0,
    'FIELD_VALUE' => 0,
    'PICKLIST_VALUE' => 0,
    'GROUPS_LIST_INFO' => 0,
    'USERS_LIST_INFO' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b733963160d4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b733963160d4')) {function content_5b733963160d4($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars['USERS_LIST_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->getAccessibleUsersForModule($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['GROUPS_LIST_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->getAccessibleGroupForModule($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_variable(explode(';',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')), null, 0);?><?php $_smarty_tpl->tpl_vars['names'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'),$_smarty_tpl->tpl_vars['RECORD']->value->getId(),$_smarty_tpl->tpl_vars['RECORD']->value), null, 0);?><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_VALUE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><?php echo $_smarty_tpl->tpl_vars['GROUPS_LIST_INFO']->value[$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value];?>
<?php echo $_smarty_tpl->tpl_vars['USERS_LIST_INFO']->value[$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value];?>
<br><?php } ?> 

<?php }} ?>