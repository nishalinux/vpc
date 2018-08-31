<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 06:18:20
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/Workflows/EditHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9733329195b77ba2c6ac684-42194290%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '527339dbd291f3b37cedfba3fd2f4c5d0b3cd766' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/Workflows/EditHeader.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9733329195b77ba2c6ac684-42194290',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORDID' => 0,
    'QUALIFIED_MODULE' => 0,
    'WORKFLOW_MODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77ba2c6c92b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77ba2c6c92b')) {function content_5b77ba2c6c92b($_smarty_tpl) {?>
<div class="editContainer" style="padding-left: 3%;padding-right: 3%"><h3><?php if ($_smarty_tpl->tpl_vars['RECORDID']->value==''){?><?php echo vtranslate('LBL_CREATING_WORKFLOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }else{ ?><?php echo vtranslate('LBL_EDITING_WORKFLOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 : <?php echo $_smarty_tpl->tpl_vars['WORKFLOW_MODEL']->value->get('summary');?>
<?php }?></h3><hr><div id="breadcrumb"><ul class="crumbs marginLeftZero"><li class="first step"  style="z-index:9" id="step1"><a><span class="stepNum">1</span><span class="stepText"><?php echo vtranslate('SCHEDULE_WORKFLOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></a></li><li style="z-index:8" class="step" id="step2"><a><span class="stepNum">2</span><span class="stepText"><?php echo vtranslate('ADD_CONDITIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></a></li><li class="step last" style="z-index:7" id="step3"><a><span class="stepNum">3</span><span class="stepText"><?php echo vtranslate('ADD_TASKS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></a></li></ul></div><div class="clearfix"></div></div><?php }} ?>