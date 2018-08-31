<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 21:43:19
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/RelatedList.tpl" */ ?>
<?php /*%%SmartyHeaderCode:15028936895b734cf78391e3-44793351%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e8fccc6c572d4c21ed3660c7889bb816650a8db' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/RelatedList.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '15028936895b734cf78391e3-44793351',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'RELATED_MODULES' => 0,
    'MODULE_MODEL' => 0,
    'removedModuleIds' => 0,
    'ModulesList' => 0,
    'RELATED_PARENTMODULES' => 0,
    'ParentremovedModuleIds' => 0,
    'ParentModulesList' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b734cf78f77b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b734cf78f77b')) {function content_5b734cf78f77b($_smarty_tpl) {?><!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 ********************************************************************************/
-->

<script>
jQuery(document).ready(function() {
var instance = new vtDZiner_functions();
	instance.registerAddParentRelationEvent();
	instance.registerAddChildRelationEvent();
})
</script>

<div class="container-fluid relatedTabModulesList" id="relatedTabModules"><div class="relatedTabchildModules"><div class="contents tabbable"><div class="btn-toolbar"><span class="pull-right"><button class="btn addButton addChildRelation" type="button"><i class="icon-plus icon-white"></i>&nbsp;<strong><?php echo vtranslate('LBL_ADD_CHILDREL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></span><br/></div><hr/><?php if (empty($_smarty_tpl->tpl_vars['RELATED_MODULES']->value)){?><div class="emptyRelatedTabs"><div class="recordDetails"><p class="textAlignCenter"><?php echo vtranslate('LBL_NO_RELATED_INFORMATION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</p></div></div><?php }else{ ?><div class="relatedListContainer"><div class="row-fluid"><div class="span2"><strong><?php echo vtranslate('LBL_ARRANGE_CHILD_RELATED_LIST',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></div><div class="span10 row-fluid"><span class="span5"><ul class="relatedModulesList" style="list-style: none;"><?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?><li class="relatedModule module_<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
 border1px contentsBackground" style="width: 200px; padding: 5px;" data-relation-id="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
"><a><img src="<?php echo vimage_path('drag.png');?>
" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/></a>&nbsp;&nbsp;<span class="moduleLabel"><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?>
</span><!--span class="icon-pencil addChildRelation" data-dismiss="modal" data-id="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
" data-module="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName();?>
" title="Edit Relation" style="float:right;line-height:20px;"></span--><button class="close" data-dismiss="modal" title="<?php echo vtranslate('LBL_CLOSE');?>
">x&nbsp;</button></li><?php }?><?php } ?></ul></span><span class="span7" style="padding: 5% 0;"><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_RELATED_LIST_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
.<br><br><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_REMOVE_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
.<br><br><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_ADD_MODULE_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<br/><br/><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_ADD_RELATED_FIELD_INFO_EXITS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></div></div><br><div class="row-fluid"><div class="span2"><strong><?php echo vtranslate('LBL_SELECT_MODULE_TO_ADD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 Child Relation</strong></div><div class="span4"><?php $_smarty_tpl->tpl_vars['ModulesList'] = new Smarty_variable(array(), null, 0);?><?php $_smarty_tpl->tpl_vars['removedModuleIds'] = new Smarty_variable(array(), null, 0);?><ul style="list-style: none; width:213px;" class="displayInlineBlock"><li><div class="row-fluid"><select class="select2" multiple name="addToList" placeholder="<?php echo vtranslate('LBL_SELECT_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?><?php $_smarty_tpl->createLocalArrayVariable('ModulesList', null, 0);
$_smarty_tpl->tpl_vars['ModulesList']->value[$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId()] = vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?><?php if (!$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?><?php echo array_push($_smarty_tpl->tpl_vars['removedModuleIds']->value,$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId());?>
<option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?>
</option><?php }?><?php } ?></select></div></li></ul><input type="hidden" class="ModulesListArray" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['ModulesList']->value);?>
' /><input type="hidden" class="RemovedModulesListArray" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['removedModuleIds']->value);?>
' /></div><div class="span6"><button class="btn btn-success saveRelatedList" type="button" disabled="disabled"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button><br></div></div><li class="moduleCopy hide border1px contentsBackground" style="width: 200px; padding: 5px;"><a><img src="<?php echo vimage_path('drag.png');?>
" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/></a>&nbsp;&nbsp;<span class="moduleLabel"></span><button class="close cross" data-dismiss="modal" title="<?php echo vtranslate('LBL_CLOSE');?>
">x</button></li><hr/><?php }?><div class="btn-toolbar"><span class="pull-right"><button class="btn addButton addParentRelation" type="button"><i class="icon-plus icon-white"></i>&nbsp;<strong><?php echo vtranslate('LBL_ADD_PARENTREL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>&nbsp;</span><br/></div><hr/></div></div> <!-- Child Div closed --></div><div class= "relatedParentTabModulesList"><?php if (empty($_smarty_tpl->tpl_vars['RELATED_PARENTMODULES']->value)){?><div class="emptyRelatedTabs"><div class="recordDetails"><p class="textAlignCenter"><?php echo vtranslate('LBL_NO_RELATED_INFORMATION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</p></div></div><?php }else{ ?><div class="row-fluid"><div class="span2"><strong><?php echo vtranslate('LBL_MANAGE_PARENT_RELATED_LIST',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></div><div class="span10 row-fluid"><span class="span5"><ul class="relatedParentModulesList" style="list-style: none;"><?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_PARENTMODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?><li class="relatedParentModule module_<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
 border1px contentsBackground" style="width: 200px; padding: 5px;" data-relation-id="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
"><a><!--img src="<?php echo vimage_path('drag.png');?>
" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/--></a>&nbsp;&nbsp;<span class="moduleLabel"><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?>
</span><button class="close" data-dismiss="modal" title="<?php echo vtranslate('LBL_RELATED_FIELDS');?>
">+</button></li><?php }?><?php } ?></ul></span><span class="span7"><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_RELATED_PARENT_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
.<br><br><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_ADD_RELATED_FIELD_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
.<br><br><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_ADD_MODULE_INFO',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
.<br/></br/><i class="icon-info-sign alignMiddle"></i>&nbsp;<?php echo vtranslate('LBL_ADD_RELATED_FIELD_INFO_EXITS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></div></div><div class="row-fluid"><div class="span2"><strong><?php echo vtranslate('LBL_SELECT_MODULE_TO_ADD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 Parent Relation</strong></div><div class="span4"><?php $_smarty_tpl->tpl_vars['ParentModulesList'] = new Smarty_variable(array(), null, 0);?><?php $_smarty_tpl->tpl_vars['ParentremovedModuleIds'] = new Smarty_variable(array(), null, 0);?><ul style="list-style: none; width:213px;" class="displayInlineBlock"><li><div class="row-fluid"><select class="select2" multiple name="addToParentList" placeholder="<?php echo vtranslate('LBL_SELECT_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_PARENTMODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?><?php $_smarty_tpl->createLocalArrayVariable('ParentModulesList', null, 0);
$_smarty_tpl->tpl_vars['ParentModulesList']->value[$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId()] = vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?><?php if (!$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?><?php echo array_push($_smarty_tpl->tpl_vars['ParentremovedModuleIds']->value,$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId());?>
<option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?>
</option><?php }?><?php } ?></select></div></li></ul><input type="hidden" class="ParentModulesListArray" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['ParentModulesList']->value);?>
' /><input type="hidden" class="ParentRemovedModulesListArray" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['ParentremovedModuleIds']->value);?>
' /><li class="moduleParentCopy hide border1px contentsBackground" style="width: 200px; padding: 5px;"><a><!--img src="<?php echo vimage_path('drag.png');?>
" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/--></a>&nbsp;&nbsp;<span class="moduleParentLabel"></span><button class="close" data-dismiss="modal" title="<?php echo vtranslate('LBL_CLOSE');?>
">+</button></li></div><div class="span6"><button class="btn btn-success saveParentRelatedList" type="button" disabled="disabled"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button><br></div></div></div><?php }?></div><?php }} ?>