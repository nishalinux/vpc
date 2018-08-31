<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:17:02
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/JsignDetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17868718305b7338be4e79b5-25374087%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1d2b9ac3e61eff043f31ec7fea89a5e6b7b1f381' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/JsignDetailView.tpl',
      1 => 1532087694,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17868718305b7338be4e79b5-25374087',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD' => 0,
    'IMAGE_INFO' => 0,
    'imgpath' => 0,
    'FIELD_MODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7338be503b1',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7338be503b1')) {function content_5b7338be503b1($_smarty_tpl) {?>

<?php  $_smarty_tpl->tpl_vars['IMAGE_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = false;
 $_smarty_tpl->tpl_vars['ITER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RECORD']->value->getJsignDetails(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['IMAGE_INFO']->key => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value){
$_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = true;
 $_smarty_tpl->tpl_vars['ITER']->value = $_smarty_tpl->tpl_vars['IMAGE_INFO']->key;
?>
	<?php $_smarty_tpl->tpl_vars['imgpath'] = new Smarty_variable(($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])."_".($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['name']), null, 0);?>
	
	<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
<?php $_tmp1=ob_get_clean();?><?php if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])&&!empty($_tmp1)&&($_smarty_tpl->tpl_vars['imgpath']->value==$_smarty_tpl->tpl_vars['RECORD']->value->get($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName()))){?>		
		<img src="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'];?>
_<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['name'];?>
" data-image-id="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['id'];?>
" width="150" height="80" >
	<?php }?>
<?php } ?><?php }} ?>