<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 07:23:43
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Finish_Buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19401517505b7a6c7f54f5c4-18360076%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b42243668599d6e688929fe2fd2fcf34023b3168' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Finish_Buttons.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19401517505b7a6c7f54f5c4-18360076',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FOR_MODULE' => 0,
    'MODULE' => 0,
    'OWNER_ID' => 0,
    'MERGE_ENABLED' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7a6c7f5690a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7a6c7f5690a')) {function content_5b7a6c7f5690a($_smarty_tpl) {?>

<button name="next" class="create btn"
	   onclick="location.href='index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=Import&return_module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&return_action=index'" ><strong><?php echo vtranslate('LBL_IMPORT_MORE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<button name="next" class="cancel btn"
		onclick="return window.open('index.php?module=<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
&for_module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=List&start=1&foruser=<?php echo $_smarty_tpl->tpl_vars['OWNER_ID']->value;?>
','test','width=700,height=650,resizable=1,scrollbars=0,top=150,left=200');"><strong><?php echo vtranslate('LBL_VIEW_LAST_IMPORTED_RECORDS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<?php if ($_smarty_tpl->tpl_vars['MERGE_ENABLED']->value=='0'){?>
<button name="next" class="delete btn"
		onclick="location.href='index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=Import&mode=undoImport&foruser=<?php echo $_smarty_tpl->tpl_vars['OWNER_ID']->value;?>
'"><strong><?php echo vtranslate('LBL_UNDO_LAST_IMPORT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<?php }?>
<button name="cancel" class="edit btn btn-success"
		onclick="location.href='index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=List'"><strong><?php echo vtranslate('LBL_FINISH_BUTTON_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php }} ?>