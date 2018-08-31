<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 09:07:17
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Done_Buttons.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3420584345b7a84c544a8f5-23818910%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '107c830b422975864da2731ce11c55f658526806' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Done_Buttons.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3420584345b7a84c544a8f5-23818910',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FOR_MODULE' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7a84c54528d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7a84c54528d')) {function content_5b7a84c54528d($_smarty_tpl) {?>

<button class="btn btn-success" name="ok"
		onclick="location.href='index.php?module=<?php echo $_smarty_tpl->tpl_vars['FOR_MODULE']->value;?>
&view=Import'"><strong><?php echo vtranslate('LBL_OK_BUTTON_LABEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><?php }} ?>