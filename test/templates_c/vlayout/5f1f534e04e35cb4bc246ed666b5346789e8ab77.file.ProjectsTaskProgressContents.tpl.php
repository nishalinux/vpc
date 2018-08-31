<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 03:36:27
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/dashboards/ProjectsTaskProgressContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:12683956335b739fbb26eee6-64418840%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5f1f534e04e35cb4bc246ed666b5346789e8ab77' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/dashboards/ProjectsTaskProgressContents.tpl',
      1 => 1499871949,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '12683956335b739fbb26eee6-64418840',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODELS' => 0,
    'MODULE_HEADER' => 0,
    'HEADER' => 0,
    'MODULE_NAME' => 0,
    'VALUE' => 0,
    'ITEM_VALUE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b739fbb28c44',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b739fbb28c44')) {function content_5b739fbb28c44($_smarty_tpl) {?>
 
<div class="dashboardWidgetContent">
	<?php if (count($_smarty_tpl->tpl_vars['MODELS']->value)>0){?>
	<div style='padding:5px'>
		<div class='row-fluid'>
		<table class='table'>
			<tr>
			<?php  $_smarty_tpl->tpl_vars['HEADER'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['HEADER']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['MODULE_HEADER']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['HEADER']->key => $_smarty_tpl->tpl_vars['HEADER']->value){
$_smarty_tpl->tpl_vars['HEADER']->_loop = true;
?>				 
				<td>
					<b><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['HEADER']->value;?>
<?php $_tmp1=ob_get_clean();?><?php echo vtranslate($_tmp1,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</b>
				</td>				 
			<?php } ?>				 
			</tr>
		   <?php  $_smarty_tpl->tpl_vars['VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['KEY_VALUE'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MODELS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['VALUE']->key => $_smarty_tpl->tpl_vars['VALUE']->value){
$_smarty_tpl->tpl_vars['VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['KEY_VALUE']->value = $_smarty_tpl->tpl_vars['VALUE']->key;
?>
			    <tr>				 	
				   <?php  $_smarty_tpl->tpl_vars['ITEM_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ITEM_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['KEY_VALUE'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['VALUE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM_VALUE']->key => $_smarty_tpl->tpl_vars['ITEM_VALUE']->value){
$_smarty_tpl->tpl_vars['ITEM_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['KEY_VALUE']->value = $_smarty_tpl->tpl_vars['ITEM_VALUE']->key;
?>	 
						<td><?php echo $_smarty_tpl->tpl_vars['ITEM_VALUE']->value;?>
</td>			 
					<?php } ?>			 
				</tr>
			<?php } ?>
		</div>
	</div>
	<?php }else{ ?>
		<span class="noDataMsg">
			<?php echo vtranslate('LBL_NO');?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 <?php echo vtranslate('LBL_MATCHED_THIS_CRITERIA');?>

		</span>
	<?php }?>
</div>
<?php }} ?>