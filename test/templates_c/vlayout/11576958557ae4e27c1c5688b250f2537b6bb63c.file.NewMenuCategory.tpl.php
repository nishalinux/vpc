<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:16
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/NewMenuCategory.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4412569415b7320a8281051-41449488%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '11576958557ae4e27c1c5688b250f2537b6bb63c' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/NewMenuCategory.tpl',
      1 => 1517656883,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4412569415b7320a8281051-41449488',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a828c25',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a828c25')) {function content_5b7320a828c25($_smarty_tpl) {?><!-- Parent Category UI starts :: Vivek on 19th May,2013 --><div class="modal addCategoryModal hide"><div class="modal-header"><button class="close vtButton" data-dismiss="modal">x</button><h3><?php echo vtranslate('LBL_CREATE_PARENT_MENU',"Settings::vtDZiner");?>
</h3></div><form class="form-horizontal contentsBackground addCategoryForm"><div class="modal-body"><div class="control-group"><span class="control-label"><?php echo vtranslate('LBL_MENU_CATEGORYNAME',"Settings::vtDZiner");?>
</span><div class="controls"><!--input type="text" name="label_parcat" class="span3" data-validation-engine="validate[required]" /--><input type="text" name="label_parcat" class="span3 validate[required] text-input" data-validation-engine='validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]],funcCall[Vtiger_AlphaNumericName_Validator_Js.invokeValidation]]' /></div></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div><!-- Parent Category UI ends :: Vivek on 19th May,2013 --><?php }} ?>