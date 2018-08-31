<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 19:21:10
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Reports/EditChartHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13812114465b747d261076a6-25439357%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'fee5d21bfe424f8c4fe0858d39be3ace1c5dfc82' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Reports/EditChartHeader.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13812114465b747d261076a6-25439357',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_ID' => 0,
    'QUALIFIED_MODULE' => 0,
    'REPORT_MODEL' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b747d2613edc',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b747d2613edc')) {function content_5b747d2613edc($_smarty_tpl) {?>
<div class="editContainer" style="padding-left: 1%;padding-right: 3%"><h3><?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value==''){?><?php echo vtranslate('LBL_CREATING_CHART_REPORT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }else{ ?><?php echo vtranslate('LBL_EDITING_CHART_REPORT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 : <?php echo $_smarty_tpl->tpl_vars['REPORT_MODEL']->value->get('reportname');?>
<?php }?></h3><hr><div><ul class="crumbs marginLeftZero"><li class="first step"  style="z-index:9" id="step1"><a><span class="stepNum">1</span><span class="stepText"><?php echo vtranslate('LBL_REPORT_DETAILS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></a></li><li style="z-index:8" class="step" id="step2"><a><span class="stepNum">2</span><span class="stepText"><?php echo vtranslate('LBL_FILTERS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></a></li><li class="step last" style="z-index:7" id="step3"><a><span class="stepNum">3</span><span class="stepText"><?php echo vtranslate('LBL_SELECT_CHART',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></a></li></ul></div><div class="clearfix"></div></div><?php }} ?>