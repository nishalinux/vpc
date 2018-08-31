<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:36:50
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/HelpDesk/dashboards/OpenTickets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21210842795b7313325d24b7-80396624%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3b96ff5e51e88818f4f51f17b4b25c996fb01091' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/HelpDesk/dashboards/OpenTickets.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21210842795b7313325d24b7-80396624',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7313325f512',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7313325f512')) {function content_5b7313325f512($_smarty_tpl) {?>
<div class="dashboardWidgetHeader">
	<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/WidgetHeader.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>
<div class="dashboardWidgetContent">
	<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/DashBoardWidgetContents.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

</div>

<script type="text/javascript">
	Vtiger_Pie_Widget_Js('Vtiger_Opentickets_Widget_Js',{},{
		/**
		 * Function which will give chart related Data
		 */
		generateData : function() {
			var container = this.getContainer();
			var jData = container.find('.widgetData').val();
			var data = JSON.parse(jData);
			var chartData = [];
			for(var index in data) {
				var row = data[index];
				var rowData = [row.name, parseInt(row.count), row.id];
				chartData.push(rowData);
			}
			return {'chartData':chartData};
		}
	});
</script><?php }} ?>