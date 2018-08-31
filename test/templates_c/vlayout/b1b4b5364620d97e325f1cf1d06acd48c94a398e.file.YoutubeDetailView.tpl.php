<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:19:47
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/YoutubeDetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14185726315b733963294381-31318396%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b1b4b5364620d97e325f1cf1d06acd48c94a398e' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/YoutubeDetailView.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14185726315b733963294381-31318396',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'FIELD_VALUE' => 0,
    'SRC' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7339632b2fd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7339632b2fd')) {function content_5b7339632b2fd($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()), null, 0);?>
<?php $_smarty_tpl->tpl_vars["SPECIAL_VALIDATOR"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator(), null, 0);?>
<?php $_smarty_tpl->tpl_vars["FIELD_NAME"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'), null, 0);?>
<?php $_smarty_tpl->tpl_vars["FIELD_VALUE"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'), null, 0);?>
<?php $_smarty_tpl->tpl_vars["SRC"] = new Smarty_variable(explode("?v=",$_smarty_tpl->tpl_vars['FIELD_VALUE']->value), null, 0);?> 
<?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value;?>

<?php if ($_smarty_tpl->tpl_vars['FIELD_VALUE']->value){?>
<iframe  width="360" height="150" src="https://www.youtube.com/embed/<?php echo $_smarty_tpl->tpl_vars['SRC']->value[1];?>
" ></iframe>
<?php }?>
<script>
$("#<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
").closest("td").css('vertical-align','top');
</script><?php }} ?>