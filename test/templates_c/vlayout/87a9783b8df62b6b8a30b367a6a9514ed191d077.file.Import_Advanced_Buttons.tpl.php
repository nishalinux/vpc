<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 07:23:29
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Advanced_Buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10428457035b7a6c71338368-59287306%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '87a9783b8df62b6b8a30b367a6a9514ed191d077' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Advanced_Buttons.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10428457035b7a6c71338368-59287306',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7a6c7134375',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7a6c7134375')) {function content_5b7a6c7134375($_smarty_tpl) {?>

<button type="submit" name="import" id="importButton" class="crmButton big edit btn btn-success"
		><strong><?php echo vtranslate('LBL_IMPORT_BUTTON_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<a type="button" name="cancel" value="<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" class="cursorPointer cancelLink" onclick="window.history.back()">
	<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>

</a><?php }} ?>