<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 03:36:27
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/dashboards/ProjectsTaskProgress.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3670056535b739fbb23f5a6-22333319%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '103c3f7ce912cdf00267220ff73c0b4f6404e94b' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/dashboards/ProjectsTaskProgress.tpl',
      1 => 1499871949,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3670056535b739fbb23f5a6-22333319',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'WIDGET' => 0,
    'MODULE_NAME' => 0,
    'PROJECTLIST' => 0,
    'PID' => 0,
    'PNAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b739fbb2696c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b739fbb2696c')) {function content_5b739fbb2696c($_smarty_tpl) {?>

<div class="dashboardWidgetHeader">
	<table width="100%" cellspacing="0" cellpadding="0">
	<thead>
		<tr>
			<th class="span4">
				<div class="dashboardTitle" title="<?php echo vtranslate($_smarty_tpl->tpl_vars['WIDGET']->value->getTitle(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
"><b>&nbsp;&nbsp;<?php echo vtranslate($_smarty_tpl->tpl_vars['WIDGET']->value->getTitle());?>
</b></div>
			</th>
			<th class="span2">
				<div>
					<select class="widgetFilter" id="" name="type" style='width:100px;margin-bottom:0px'>
						<option value="" ><?php echo vtranslate('LBL_ALL');?>
</option>
							<?php  $_smarty_tpl->tpl_vars['PNAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PNAME']->_loop = false;
 $_smarty_tpl->tpl_vars['PID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROJECTLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PNAME']->key => $_smarty_tpl->tpl_vars['PNAME']->value){
$_smarty_tpl->tpl_vars['PNAME']->_loop = true;
 $_smarty_tpl->tpl_vars['PID']->value = $_smarty_tpl->tpl_vars['PNAME']->key;
?>
							<option value="<?php echo $_smarty_tpl->tpl_vars['PID']->value;?>
" ><?php echo $_smarty_tpl->tpl_vars['PNAME']->value;?>
</option>
								<?php } ?>
					</select>
				</div>
			</th>
			<th class="refresh span1" align="right">
				<span style="position:relative;"></span>
			</th>
			<th class="widgeticons span5" align="right">
				<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/DashboardHeaderIcons.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

			</th>
		</tr>
	</thead>
	</table>
</div> 
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("dashboards/ProjectsTaskProgressContents.tpl",$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php }} ?>