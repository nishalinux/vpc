<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:37:20
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/PictureDetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13257876865b7313501b9a68-15272387%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bbf43780ed0fb238e1e2a800cadfa42ab2826a18' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/PictureDetailView.tpl',
      1 => 1517656807,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13257876865b7313501b9a68-15272387',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'RECORD' => 0,
    'IMAGE_INFO' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7313501d0c8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7313501d0c8')) {function content_5b7313501d0c8($_smarty_tpl) {?>
<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
<?php $_tmp1=ob_get_clean();?><?php  $_smarty_tpl->tpl_vars['IMAGE_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = false;
 $_smarty_tpl->tpl_vars['ITER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RECORD']->value->getGalleryDetails($_tmp1); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['IMAGE_INFO']->key => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value){
$_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = true;
 $_smarty_tpl->tpl_vars['ITER']->value = $_smarty_tpl->tpl_vars['IMAGE_INFO']->key;
?>
	<?php if ($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['fieldid']==$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()){?>
		<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
<?php $_tmp2=ob_get_clean();?><?php if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])&&!empty($_tmp2)){?>
			<img src="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'];?>
_<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" width="150" height="80">
		<?php }?>
	<?php }?>
<?php } ?>
<?php }} ?>