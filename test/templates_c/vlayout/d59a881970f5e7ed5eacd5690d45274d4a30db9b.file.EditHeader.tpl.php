<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 03:31:02
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Calendar/EditHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16878746685b739e763f1580-02083083%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd59a881970f5e7ed5eacd5690d45274d4a30db9b' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Calendar/EditHeader.tpl',
      1 => 1533201058,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16878746685b739e763f1580-02083083',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_ID' => 0,
    'QUALIFIED_MODULE' => 0,
    'SUBJECT' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b739e764124e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b739e764124e')) {function content_5b739e764124e($_smarty_tpl) {?>
<div class="editeventContainer" style="padding-left: 2%;padding-right: 2%"><br><h3><?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value==''){?><?php echo vtranslate('LBL_CREATING_EVENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }else{ ?><?php echo vtranslate('LBL_EDITING_EVENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 : <?php echo $_smarty_tpl->tpl_vars['SUBJECT']->value;?>
<?php }?></h3><hr><div><ul class="crumbs marginLeftZero"><li class="first step"  style="z-index:9" id="step1"><a><span class="stepNum">1</span><span class="stepText"><?php echo vtranslate('LBL_EVENT_DETAILS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></a></li><li style="z-index:8" class="step" id="step2"><a><span class="stepNum">2</span><span class="stepText"><?php echo vtranslate('LBL_EDITING_EVENT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></a></li><li class="step last" style="z-index:7" id="step3"><a><span class="stepNum">3</span><span class="stepText"><?php echo vtranslate('LBL_FINISH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></a></li></ul></div><div class="clearfix"></div></div><?php }} ?>