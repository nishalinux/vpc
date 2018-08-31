<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 09:07:17
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/ImportUndoResult.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17562976885b7a84c5402e58-48781243%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '55b8fe2e56181aa1f5e5d1d1c42c91bb4a92fd43' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/ImportUndoResult.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17562976885b7a84c5402e58-48781243',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LEFTPANELHIDE' => 0,
    'FOR_MODULE' => 0,
    'MODULE' => 0,
    'ERROR_MESSAGE' => 0,
    'TOTAL_RECORDS' => 0,
    'DELETED_RECORDS_COUNT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7a84c5444b4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7a84c5444b4')) {function content_5b7a84c5444b4($_smarty_tpl) {?>
<div id="toggleButton" class="toggleButton" title="<?php echo vtranslate('LBL_LEFT_PANEL_SHOW_HIDE','Vtiger');?>
"><i id="tButtonImage" class="<?php if ($_smarty_tpl->tpl_vars['LEFTPANELHIDE']->value!='1'){?>icon-chevron-left<?php }else{ ?>icon-chevron-right<?php }?>"></i></div>&nbsp<div style="padding-left: 15px;"><input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
" /><table style=" width:90%;margin-left: 5% " cellpadding="10" class="searchUIBasic well"><tr><td class="font-x-large" align="left" colspan="2"><strong><?php echo vtranslate('LBL_IMPORT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['FOR_MODULE']->value,$_smarty_tpl->tpl_vars['FOR_MODULE']->value);?>
 - <?php echo vtranslate('LBL_UNDO_RESULT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></td></tr><?php if ($_smarty_tpl->tpl_vars['ERROR_MESSAGE']->value!=''){?><tr><td class="style1" align="left" colspan="2"><?php echo $_smarty_tpl->tpl_vars['ERROR_MESSAGE']->value;?>
</td></tr><?php }?><tr><td colspan="2" valign="top"><table cellpadding="10" cellspacing="0" align="center" class="dvtSelectedCell thickBorder importContents"><tr><td><?php echo vtranslate('LBL_TOTAL_RECORDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td width="10%">:</td><td width="10%"><?php echo $_smarty_tpl->tpl_vars['TOTAL_RECORDS']->value;?>
</td></tr><tr><td><?php echo vtranslate('LBL_NUMBER_OF_RECORDS_DELETED',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td width="10%">:</td><td width="10%"><?php echo $_smarty_tpl->tpl_vars['DELETED_RECORDS_COUNT']->value;?>
</td></tr></table></td></tr><tr><td align="right" colspan="2"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('Import_Done_Buttons.tpl','Import'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</td></tr></table></div><?php }} ?>