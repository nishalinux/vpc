<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 21:10:57
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/LoginPage/ListViewContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:7404165955b7b2e61e74855-56943585%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f4fc9b1ad6c1df5444aab867db98b917cd3136c9' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/LoginPage/ListViewContents.tpl',
      1 => 1533721275,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '7404165955b7b2e61e74855-56943585',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'THEMELIST' => 0,
    'WIDTHTYPE' => 0,
    'WIDTH' => 0,
    'j' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7b2e61ec068',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7b2e61ec068')) {function content_5b7b2e61ec068($_smarty_tpl) {?>
<div class="widget_header row-fluid"><div class="span6"><h3>Login Themes</h3></div></div><hr/><div class="row-fluid"><span class="span8 btn-toolbar"><a href='index.php?module=LoginPage&parent=Settings&view=NewTheme' title="Add Theme"><button class="btn addButton"><i class="icon-plus"></i>&nbsp;<strong>Add Theme</strong></button></a></span></div><div class="listViewEntriesDiv" style='overflow-x:auto;'><span class="listViewLoadingImageBlock hide modal" id="loadingListViewModal"><img class="listViewLoadingImage" src="<?php echo vimage_path('loading.gif');?>
" alt="no-image" title="<?php echo vtranslate('LBL_LOADING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"/><p class="listViewLoadingMsg"><?php echo vtranslate('LBL_LOADING_LISTVIEW_CONTENTS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
........</p></span><table class="table table-bordered listViewEntriesTable" id="Themes" width="60%"><thead><tr class="listViewHeaders"><th>S.No</th><th>Theme Name</th><th>Status</th><th>Preview</th><th>Action</th></tr></thead><tbody><?php $_smarty_tpl->tpl_vars["j"] = new Smarty_variable("1", null, 0);?><?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['THEMELIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?><tr><td class="listViewEntryValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"  width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" nowrap><?php echo $_smarty_tpl->tpl_vars['j']->value;?>
</td><td nowrap class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
</td><td nowrap class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><input type='radio' class="radio" name='themestatus' data-id="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
" data-display="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" value="" <?php if ($_smarty_tpl->tpl_vars['i']->value['status']==1){?>checked<?php }?> /></td><td nowrap class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><a target='_blank' class="btn btn-success" href="<?php echo $_smarty_tpl->tpl_vars['i']->value['previewurl'];?>
"><strong>Preview</strong></a></td><td nowrap class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><a class="deleteRecordButton" data-name="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"><i title="Delete" class="icon-trash alignMiddle"></i></a><a class="edit" data-name="<?php echo $_smarty_tpl->tpl_vars['i']->value['name'];?>
" href="?module=LoginPage&parent=Settings&view=NewTheme&record=<?php echo $_smarty_tpl->tpl_vars['i']->value['id'];?>
"><i title="Edit" class="icon-pencil alignMiddle"></i></a></td></tr><?php $_smarty_tpl->tpl_vars["j"] = new Smarty_variable($_smarty_tpl->tpl_vars['j']->value+1, null, 0);?><?php } ?></tbody></table></div><?php }} ?>