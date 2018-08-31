<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 04:21:00
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/PreferenceDetailViewHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6322286965b73aa2c24e2b1-11754470%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ab27aaefe63e4a6750b977b5c78553067bfbe22c' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/PreferenceDetailViewHeader.tpl',
      1 => 1534262611,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6322286965b73aa2c24e2b1-11754470',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE_MODEL' => 0,
    'RECORD' => 0,
    'IMAGE_INFO' => 0,
    'MODULE_NAME' => 0,
    'DETAILVIEW_LINKS' => 0,
    'DETAIL_VIEW_BASIC_LINK' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73aa2c2907b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73aa2c2907b')) {function content_5b73aa2c2907b($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars["MODULE_NAME"] = new Smarty_variable($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('name'), null, 0);?><input id="recordId" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getId();?>
" /><div class="detailViewContainer"><div class="detailViewTitle" id="prefPageHeader"><div class="row-fluid"><div class="span8"><span class="row-fluid marginLeftZero"><span class="logo span1"><?php  $_smarty_tpl->tpl_vars['IMAGE_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = false;
 $_smarty_tpl->tpl_vars['ITER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RECORD']->value->getImageDetails(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['IMAGE_INFO']->key => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value){
$_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = true;
 $_smarty_tpl->tpl_vars['ITER']->value = $_smarty_tpl->tpl_vars['IMAGE_INFO']->key;
?><?php if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])&&!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'])){?><img src="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'];?>
_<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" alt="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" title="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" data-image-id="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['id'];?>
"><?php }?><?php } ?></span><span class="span9"><span id="myPrefHeading" class="row-fluid"><h3><?php echo vtranslate('LBL_MY_PREFERENCES',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
 </h3></span><span class="row-fluid"><?php echo vtranslate('LBL_USERDETAIL_INFO',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
&nbsp;&nbsp;"<b><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->getName();?>
</b>"</span></span></span></div><div class="span4"><div class="row-fluid pull-right detailViewButtoncontainer"><div class="btn-toolbar pull-right"><div class="btn-group"><!--button class="btn" id="sendemailpass" name="sendemailpass" value=""><strong>Email Password</strong></button--></div><?php  $_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWPREFERENCE']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->key => $_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->value){
$_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->_loop = true;
?><div class="btn-group"><button class="btn"<?php if ($_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->value->isPageLoadLink()){?>onclick="window.location.href='<?php echo $_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->value->getUrl();?>
'"<?php }else{ ?>onclick=<?php echo $_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->value->getUrl();?>
<?php }?>><strong><?php echo vtranslate($_smarty_tpl->tpl_vars['DETAIL_VIEW_BASIC_LINK']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button></div><?php } ?></div></div></div></div></div><div class="detailViewInfo userPreferences row-fluid"><div class="details span12"><form id="detailView" data-name-fields='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getNameFields());?>
' method="POST"><div class="contents"><?php }} ?>