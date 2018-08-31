<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 19:23:46
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Reports/ChartReportContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15007245b747dc2c0a827-15665564%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90c3c67cea7af38e2f510028555f75f5c1448d69' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Reports/ChartReportContents.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15007245b747dc2c0a827-15665564',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CHART_TYPE' => 0,
    'DATA' => 0,
    'CLICK_THROUGH' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b747dc2c176a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b747dc2c176a')) {function content_5b747dc2c176a($_smarty_tpl) {?>

<input type='hidden' name='charttype' value="<?php echo $_smarty_tpl->tpl_vars['CHART_TYPE']->value;?>
" />
<input type='hidden' name='data' value='<?php echo $_smarty_tpl->tpl_vars['DATA']->value;?>
' />
<input type='hidden' name='clickthrough' value="<?php echo $_smarty_tpl->tpl_vars['CLICK_THROUGH']->value;?>
" />

<br>
<div style="margin:0px 20px;">
	<div class='border1px' style="padding:30px 100px;">
		<div id='chartcontent' style="min-height:400px;" ></div>
		<br>
		<?php if ($_smarty_tpl->tpl_vars['CLICK_THROUGH']->value!='true'){?>
			<div class='row-fluid alert-info' style="padding:20px">
				<span class='span3 offset4'> &nbsp;</span>
				<span class='span alert-info'>
					<i class="icon-info-sign"></i>
					<?php echo vtranslate('LBL_CLICK_THROUGH_NOT_AVAILABLE',$_smarty_tpl->tpl_vars['MODULE']->value);?>

				</span>
			</div>
			<br>
		<?php }?>
	</div>
</div>
<br>
<?php }} ?>