<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 16:17:19
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/SumField/InstallerHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21056956895b7d8c8fa0cc50-99384359%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '879146c201d942c789db216de32359a905e5d97d' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/SumField/InstallerHeader.tpl',
      1 => 1472554746,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21056956895b7d8c8fa0cc50-99384359',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7d8c8fa377b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7d8c8fa377b')) {function content_5b7d8c8fa377b($_smarty_tpl) {?>
<div class="editContainer" style="padding-left: 3%;padding-right: 3%"><h3><?php echo vtranslate('MODULE_LBL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3><hr><div id="breadcrumb"><ul class="crumbs marginLeftZero"><li class="first step"  style="z-index:9" id="step1"><a><span class="stepNum">1</span><span class="stepText"><?php echo vtranslate('LBL_REQUIREMENTS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></a></li><li style="z-index:8" class="step" id="step2"><a><span class="stepNum">2</span><span class="stepText"><?php echo vtranslate('LBL_LICENSING',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></a></li><li class="step last" style="z-index:7" id="step3"><a><span class="stepNum">3</span><span class="stepText"><?php echo vtranslate('LBL_COMPLETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></a></li></ul></div><div class="clearfix"></div></div><?php }} ?>