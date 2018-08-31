<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:24:45
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Rss/ListViewContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11318231895b733a8d442914-22939048%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f9607b9a1dcafd8a8fcdd833bb819991c269d32' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Rss/ListViewContents.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11318231895b733a8d442914-22939048',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SOURCE_MODULE' => 0,
    'MODULE' => 0,
    'RECORD' => 0,
    'QUICK_LINKS' => 0,
    'SINGLE_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b733a8d476e3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b733a8d476e3')) {function content_5b733a8d476e3($_smarty_tpl) {?>
<input type="hidden" id="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SOURCE_MODULE']->value;?>
" /><div class="listViewEntriesDiv"><span class="listViewLoadingImageBlock hide modal" id="loadingListViewModal"><img class="listViewLoadingImage" src="<?php echo vimage_path('loading.gif');?>
" alt="no-image" title="<?php echo vtranslate('LBL_LOADING',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"/><p class="listViewLoadingMsg"><?php echo vtranslate('LBL_LOADING_LISTVIEW_CONTENTS',$_smarty_tpl->tpl_vars['MODULE']->value);?>
........</p></span><div class="feedContainer"><?php if ($_smarty_tpl->tpl_vars['RECORD']->value){?><input id="recordId" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
"><div class="row-fluid"><span class="btn-toolbar pull-right"><span class="btn-group"><button id="deleteButton" class="btn">&nbsp;<strong><?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span><span class="btn-group"><button id="makeDefaultButton" class="btn">&nbsp;<strong><?php echo vtranslate('LBL_SET_AS_DEFAULT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span></span><span class="row-fluid" id="rssFeedHeading"><h3> <?php echo vtranslate('LBL_FEEDS_LIST_FROM',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 : <?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
 </h3></span></div><div class="feedListContainer" style="overflow: auto;"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('RssFeedContents.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }else{ ?><table class="emptyRecordsDiv"><tbody><tr><td><?php $_smarty_tpl->tpl_vars['SINGLE_MODULE'] = new Smarty_variable("SINGLE_".($_smarty_tpl->tpl_vars['MODULE']->value), null, 0);?><?php echo vtranslate('LBL_EQ_ZERO');?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate('LBL_FOUND');?>
. <?php echo vtranslate('LBL_CREATE');?>
 <a class="rssAddButton" href="#" data-href="<?php echo $_smarty_tpl->tpl_vars['QUICK_LINKS']->value['SIDEBARLINK'][0]->getUrl();?>
">&nbsp;<?php echo vtranslate($_smarty_tpl->tpl_vars['SINGLE_MODULE']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></td></tr></tbody></table><?php }?></div></div><br /><div class="feedFrame"></div><?php }} ?>