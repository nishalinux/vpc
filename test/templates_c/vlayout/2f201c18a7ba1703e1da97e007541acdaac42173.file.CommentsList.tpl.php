<?php /* Smarty version Smarty-3.1.7, created on 2018-08-15 06:55:31
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/CommentsList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20869087455b73ce633fecb3-71640468%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f201c18a7ba1703e1da97e007541acdaac42173' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/CommentsList.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20869087455b73ce633fecb3-71640468',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PARENT_COMMENTS' => 0,
    'CURRENT_COMMENT' => 0,
    'CURRENT_COMMENT_PARENT_MODEL' => 0,
    'TEMP_COMMENT' => 0,
    'COMMENT' => 0,
    'COMMENTS_MODULE_MODEL' => 0,
    'CHILDS_ROOT_PARENT_MODEL' => 0,
    'PARENT_COMMENT_ID' => 0,
    'CHILD_COMMENTS_MODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73ce634436a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73ce634436a')) {function content_5b73ce634436a($_smarty_tpl) {?>
<?php if (!empty($_smarty_tpl->tpl_vars['PARENT_COMMENTS']->value)){?><ul class="liStyleNone"><?php if ($_smarty_tpl->tpl_vars['CURRENT_COMMENT']->value){?><?php $_smarty_tpl->tpl_vars['CHILDS_ROOT_PARENT_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_COMMENT']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['CURRENT_COMMENT_PARENT_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_COMMENT']->value->getParentCommentModel(), null, 0);?><?php while ($_smarty_tpl->tpl_vars['CURRENT_COMMENT_PARENT_MODEL']->value!=false){?><?php $_smarty_tpl->tpl_vars['TEMP_COMMENT'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_COMMENT_PARENT_MODEL']->value, null, 0);?><?php $_smarty_tpl->tpl_vars['CURRENT_COMMENT_PARENT_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_COMMENT_PARENT_MODEL']->value->getParentCommentModel(), null, 0);?><?php if ($_smarty_tpl->tpl_vars['CURRENT_COMMENT_PARENT_MODEL']->value==false){?><?php $_smarty_tpl->tpl_vars['CHILDS_ROOT_PARENT_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['TEMP_COMMENT']->value, null, 0);?><?php }?><?php }?><?php }?><?php if (is_array($_smarty_tpl->tpl_vars['PARENT_COMMENTS']->value)){?><?php  $_smarty_tpl->tpl_vars['COMMENT'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['COMMENT']->_loop = false;
 $_smarty_tpl->tpl_vars['Index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PARENT_COMMENTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['COMMENT']->key => $_smarty_tpl->tpl_vars['COMMENT']->value){
$_smarty_tpl->tpl_vars['COMMENT']->_loop = true;
 $_smarty_tpl->tpl_vars['Index']->value = $_smarty_tpl->tpl_vars['COMMENT']->key;
?><?php $_smarty_tpl->tpl_vars['PARENT_COMMENT_ID'] = new Smarty_variable($_smarty_tpl->tpl_vars['COMMENT']->value->getId(), null, 0);?><li class="commentDetails"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('Comment.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('COMMENT'=>$_smarty_tpl->tpl_vars['COMMENT']->value,'COMMENT_MODULE_MODEL'=>$_smarty_tpl->tpl_vars['COMMENTS_MODULE_MODEL']->value), 0);?>
<?php if ($_smarty_tpl->tpl_vars['CHILDS_ROOT_PARENT_MODEL']->value){?><?php if ($_smarty_tpl->tpl_vars['CHILDS_ROOT_PARENT_MODEL']->value->getId()==$_smarty_tpl->tpl_vars['PARENT_COMMENT_ID']->value){?><?php $_smarty_tpl->tpl_vars['CHILD_COMMENTS_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['CHILDS_ROOT_PARENT_MODEL']->value->getChildComments(), null, 0);?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('CommentsListIteration.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('CHILD_COMMENTS_MODEL'=>$_smarty_tpl->tpl_vars['CHILD_COMMENTS_MODEL']->value), 0);?>
<?php }?><?php }?></li><br><?php } ?><?php }else{ ?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('Comment.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('COMMENT'=>$_smarty_tpl->tpl_vars['PARENT_COMMENTS']->value), 0);?>
<?php }?></ul><?php }else{ ?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("NoComments.tpl"), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }?><?php }} ?>