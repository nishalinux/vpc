<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 06:18:34
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/PointSale/SummaryViewWidgets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11214283285b7a5d3a7cc017-79014833%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '03a113db9b70d7bccd2f85764e064ce162cfc3f7' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/PointSale/SummaryViewWidgets.tpl',
      1 => 1534744125,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11214283285b7a5d3a7cc017-79014833',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_SUMMARY' => 0,
    'DETAILVIEW_LINKS' => 0,
    'DETAIL_VIEW_WIDGET' => 0,
    'MODULE_NAME' => 0,
    'RELATED_ACTIVITIES' => 0,
    'TAX' => 0,
    'POS_DETAIL' => 0,
    'data' => 0,
    'total_qty' => 0,
    'pos_amount' => 0,
    'totalwithouttax' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7a5d3a83247',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7a5d3a83247')) {function content_5b7a5d3a83247($_smarty_tpl) {?>
<?php if (!empty($_smarty_tpl->tpl_vars['MODULE_SUMMARY']->value)){?><div class="row-fluid"><div class="span7"><div class="summaryView row-fluid"><?php echo $_smarty_tpl->tpl_vars['MODULE_SUMMARY']->value;?>
</div><?php }?><?php  $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWWIDGET']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['count']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->key => $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value){
$_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['count']['index']++;
?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['count']['index']%2==0){?><div class="summaryWidgetContainer"><div class="widgetContainer_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['count']['index'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span8 margin0px"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span></div><div class="widget_contents"></div></div></div><?php }?><?php } ?></div><div class="span5" style="overflow: hidden"><div id="relatedActivities"><?php echo $_smarty_tpl->tpl_vars['RELATED_ACTIVITIES']->value;?>
</div><?php  $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWWIDGET']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['count']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->key => $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value){
$_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['count']['index']++;
?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['count']['index']%2!=0){?><div class="summaryWidgetContainer"><div class="widgetContainer_<?php echo $_smarty_tpl->getVariable('smarty')->value['foreach']['count']['index'];?>
" data-url="<?php echo $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span8 margin0px"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span></div><div class="widget_contents"></div></div></div><?php }?><?php } ?><div class="summaryWidgetContainer"><div ><b><?php echo 'BILL OF SALE';?>
</b></div><hr><table class="table table-striped table-bordered"><thead><tr><th>Product</th><th>Qty</th><th>Price</th><th>Total</th><?php if ($_smarty_tpl->tpl_vars['TAX']->value==1){?><th>TotalWithTax</th><?php }?></tr></thead><tbody><?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['POS_DETAIL']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['data']->key;
?><tr><td><?php echo $_smarty_tpl->tpl_vars['data']->value['productname'];?>
</td><td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['data']->value['selected_qty']);?>
</td><td><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['data']->value['price']);?>
</td><td><?php echo $_smarty_tpl->tpl_vars['data']->value['selected_qty']*sprintf("%.2f",$_smarty_tpl->tpl_vars['data']->value['price']);?>
</td><?php if ($_smarty_tpl->tpl_vars['TAX']->value==1){?><td><?php echo sprintf("%.2f",(($_smarty_tpl->tpl_vars['data']->value['selected_qty']*$_smarty_tpl->tpl_vars['data']->value['price'])+(($_smarty_tpl->tpl_vars['data']->value['selected_qty']*$_smarty_tpl->tpl_vars['data']->value['price'])*($_smarty_tpl->tpl_vars['data']->value['taxpercent']/100))));?>
</td><?php }?></tr><?php } ?></tbody></table><hr><table class="table table-striped table-bordered"><tbody><tr><td>Total Items</td><td colspan=3><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['total_qty']->value);?>
</td></tr><?php if ($_smarty_tpl->tpl_vars['TAX']->value==1){?><tr><td>Total</td><td colspan=3><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['pos_amount']->value['total_amount']);?>
</td></tr><?php }else{ ?><tr><td>Total Amount</td><td colspan=3><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['totalwithouttax']->value);?>
</td></tr><tr><td>Total With Tax</td><td colspan=3><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['pos_amount']->value['total_amount']);?>
</td></tr><?php }?><tr><td>Cash Tendered</td><td colspan=3><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['pos_amount']->value['paid_amount']);?>
</td></tr><tr><td>Change Return</td><td colspan=3><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['pos_amount']->value['return_amount']);?>
</td></tr></tbody></table></div></div></div><?php }} ?>