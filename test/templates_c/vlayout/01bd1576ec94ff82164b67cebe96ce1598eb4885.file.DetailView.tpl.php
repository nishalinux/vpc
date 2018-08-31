<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 21:19:26
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Portal/DetailView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8358193725b773bde639a17-77170027%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '01bd1576ec94ff82164b67cebe96ce1598eb4885' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Portal/DetailView.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8358193725b773bde639a17-77170027',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'RECORDS_LIST' => 0,
    'RECORD' => 0,
    'RECORD_ID' => 0,
    'URL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b773bde66524',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b773bde66524')) {function content_5b773bde66524($_smarty_tpl) {?>
<div class="listViewPageDiv"><span class="btn-toolbar span4"><span class="btn-group"><button id="addBookmark" class="btn addButton"><i class="icon-plus"></i>&nbsp;<strong><?php echo vtranslate('LBL_ADD_BOOKMARK',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span></span><span class="span2">&nbsp;</span><span><div class="pull-right"><div class="control-label span2"><label class="textAlignRight" style="padding-top: 14px;"><?php echo vtranslate('LBL_BOOKMARKS_LIST',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></div><div class="controls span4" style="padding-top: 10px;"><select class="select2-container select2 pull-right customFilterMainSpan" id="bookmarksDropdown" name="bookmarksList"><?php  $_smarty_tpl->tpl_vars['RECORD'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RECORD']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RECORDS_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RECORD']->key => $_smarty_tpl->tpl_vars['RECORD']->value){
$_smarty_tpl->tpl_vars['RECORD']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value['id'];?>
" <?php if ($_smarty_tpl->tpl_vars['RECORD']->value['id']==$_smarty_tpl->tpl_vars['RECORD_ID']->value){?>selected<?php }?>><?php echo $_smarty_tpl->tpl_vars['RECORD']->value['portalname'];?>
</option><?php } ?></select></div></div></span><span class="listViewLoadingImageBlock hide modal noprint" id="loadingListViewModal"><img class="listViewLoadingImage" src="<?php echo vimage_path('loading.gif');?>
" alt="no-image" title="<?php echo vtranslate('LBL_LOADING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"/><p class="listViewLoadingMsg"><?php echo vtranslate('LBL_LOADING_LISTVIEW_CONTENTS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
........</p></span><br><?php if (substr($_smarty_tpl->tpl_vars['URL']->value,0,8)!='https://'){?><div id="portalDetailViewHttpError" class="row-fluid"><div class="span12"><?php echo vtranslate('HTTP_ERROR',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</div></div><?php }?><br><iframe src="<?php if (substr($_smarty_tpl->tpl_vars['URL']->value,0,4)!='http'){?>//<?php }?><?php echo $_smarty_tpl->tpl_vars['URL']->value;?>
" frameborder="1" height="600" scrolling="auto" width="100%" style="border: solid 2px; border-color: #dddddd;"></iframe></div><?php }} ?>