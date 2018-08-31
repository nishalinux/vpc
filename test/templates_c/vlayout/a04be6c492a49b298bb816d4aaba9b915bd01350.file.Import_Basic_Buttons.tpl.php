<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 20:22:57
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Basic_Buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19225471055b772ea169a0b6-04300545%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a04be6c492a49b298bb816d4aaba9b915bd01350' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Basic_Buttons.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19225471055b772ea169a0b6-04300545',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'FOR_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b772ea16a601',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b772ea16a601')) {function content_5b772ea16a601($_smarty_tpl) {?>

<button type="submit" name="next"  class="btn btn-success"
		onclick="return ImportJs.uploadAndParse();"><strong><?php echo vtranslate('LBL_NEXT_BUTTON_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button>
&nbsp;&nbsp;
<a name="cancel" class="cursorPointer cancelLink" value="<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" onclick="location.href='index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=List'">
		<?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>

</a><?php }} ?>