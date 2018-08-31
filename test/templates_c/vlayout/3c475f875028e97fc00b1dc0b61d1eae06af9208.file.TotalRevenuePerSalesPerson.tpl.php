<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:47:55
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Potentials/dashboards/TotalRevenuePerSalesPerson.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15146450155b733ffb986e27-78968897%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3c475f875028e97fc00b1dc0b61d1eae06af9208' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Potentials/dashboards/TotalRevenuePerSalesPerson.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15146450155b733ffb986e27-78968897',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b733ffb9e8a2',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b733ffb9e8a2')) {function content_5b733ffb9e8a2($_smarty_tpl) {?>
<script type="text/javascript">
	Vtiger_Pie_Widget_Js('Vtiger_Totalrevenuepersalesperson_Widget_Js',{},{});
</script>
<div class="dashboardWidgetHeader">
	<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/WidgetHeader.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('SETTING_EXIST'=>true), 0);?>

	<div class="row-fluid filterContainer hide" style="position:absolute;z-index:100001">
		<div class="row-fluid">
			<span class="span5">
				<span class="pull-right">
					<?php echo vtranslate('Created Time',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 &nbsp; <?php echo vtranslate('LBL_BETWEEN',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>

				</span>
			</span>
			<span class="span4">
				<input type="text" name="createdtime" class="dateRange widgetFilter" />
			</span>
		</div>
	</div>			
</div>
<div class="dashboardWidgetContent">
	<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/DashBoardWidgetContents.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div><?php }} ?>