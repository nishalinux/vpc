<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 20:22:57
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Step1.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11591387335b772ea1621565-62235154%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e8e70b8571699329705f8cd965a716b71b090d15' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Import/Import_Step1.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11591387335b772ea1621565-62235154',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'IMPORT_UPLOAD_SIZE' => 0,
    'IMPORT_UPLOAD_SIZE_MB' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b772ea162fa5',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b772ea162fa5')) {function content_5b772ea162fa5($_smarty_tpl) {?>
<table width="100%" cellspacing="0" cellpadding="2">
	<tr>
		<td><strong><?php echo vtranslate('LBL_IMPORT_STEP_1',$_smarty_tpl->tpl_vars['MODULE']->value);?>
:</strong></td>
		<td class="big"><?php echo vtranslate('LBL_IMPORT_STEP_1_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td>
		<td>&nbsp;</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td data-import-upload-size="<?php echo $_smarty_tpl->tpl_vars['IMPORT_UPLOAD_SIZE']->value;?>
" data-import-upload-size-mb="<?php echo $_smarty_tpl->tpl_vars['IMPORT_UPLOAD_SIZE_MB']->value;?>
">
			<input type="hidden" name="type" value="csv" />
			<input type="hidden" name="is_scheduled" value="1" />
			<input type="file" name="import_file" id="import_file" onchange="ImportJs.checkFileType()"/>
			<!-- input type="hidden" name="userfile_hidden" value=""/ -->
		</td>
	</tr>
	<tr>
		<td>&nbsp;</td>
		<td><?php echo vtranslate('LBL_IMPORT_SUPPORTED_FILE_TYPES',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td>
	</tr>
</table><?php }} ?>