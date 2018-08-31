<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 20:59:41
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/PointSale/Settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6284668475b7b2bbdbb0452-78151934%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1fc782ed545cde6fc994df6a0c0c3587f203724f' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/PointSale/Settings.tpl',
      1 => 1534744125,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6284668475b7b2bbdbb0452-78151934',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'TAX' => 0,
    'CURRENCY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7b2bbdbfaa8',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7b2bbdbfaa8')) {function content_5b7b2bbdbfaa8($_smarty_tpl) {?>
<div class="container-fluid"><div class="widget_header row-fluid"><h3><?php echo 'POS Settings';?>
</h3></div><hr><div class="clearfix"></div><form action="index.php" id="formSettings"><input type="hidden" name="module" value="PointSale"/><input type="hidden" name="action" value="IndexAjax"/><input type="hidden" name="mode" value="posSettings"/><div class="summaryWidgetContainer"><ul class="nav nav-tabs massEditTabs"><li class="active"><a href="#module_tax_settings" data-toggle="tab"><strong><?php echo 'Tax Settings';?>
</strong></a></li><li><a href="#module_currency_settings" data-toggle="tab"><strong><?php echo 'Currency Settings';?>
</strong></a></li></ul><div class="tab-content massEditContent"><div class="tab-pane active" id="module_tax_settings"><div class="widgetContainer" style="padding: 20px 5px 5px 20px;"><div id="stepone"><br/><b>Display Tax Calculation</b><br/><br/><input type="radio" name="taxstatus" class="taxstatus" value="1" <?php if ($_smarty_tpl->tpl_vars['TAX']->value=='1'){?>Checked<?php }?> >&nbsp;Individually For Single Products<br/><input type="radio" name="taxstatus" class="taxstatus" value="2" <?php if ($_smarty_tpl->tpl_vars['TAX']->value=='2'){?>Checked<?php }?> >&nbsp;Display Total Tax at the end.<br/></div></div></div><div class="tab-pane" id="module_currency_settings"><div class="widgetContainer" style="padding: 20px 5px 5px 20px;"><div id="steptwo"><br/><b>To Display Currency in Numeric Pad</b><br/><ul style="list-style-type: none;"><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="10" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='10'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='10'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='10'){?>Checked<?php }?>>&nbsp;10</li><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="20" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='20'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='20'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='20'){?>Checked<?php }?>>&nbsp;20</li><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="50" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='50'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='50'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='50'){?>Checked<?php }?>>&nbsp;50</li><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="100" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='100'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='100'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='100'){?>Checked<?php }?>>&nbsp;100</li><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="200" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='200'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='200'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='200'){?>Checked<?php }?>>&nbsp;200</li><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="500" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='500'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='500'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='500'){?>Checked<?php }?>>&nbsp;500</li><li><input class="BoxSelect" name="BoxSelect[]" type="checkbox" value="1000" <?php if ($_smarty_tpl->tpl_vars['CURRENCY']->value[0]=='1000'||$_smarty_tpl->tpl_vars['CURRENCY']->value[1]=='1000'||$_smarty_tpl->tpl_vars['CURRENCY']->value[2]=='1000'){?>Checked<?php }?>>&nbsp;1000</li></ul></div></div></div><div style="margin-top: 20px;"><span><button class="btn btn-success" type="button" id="btnSavePOSSettings"><?php echo vtranslate('LBL_SAVE');?>
</button></span></div></div></form></div>

<script type="text/javascript">

</script><?php }} ?>