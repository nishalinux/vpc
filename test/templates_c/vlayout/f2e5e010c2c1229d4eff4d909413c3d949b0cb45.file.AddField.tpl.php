<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 21:02:14
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/AddField.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18241047865b7737d6bb0597-30166984%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f2e5e010c2c1229d4eff4d909413c3d949b0cb45' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/AddField.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18241047865b7737d6bb0597-30166984',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SELECTED_MODULE_MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'ENTITY_RECORD' => 0,
    'BLOCK_ID' => 0,
    'ADD_SUPPORTED_FIELD_TYPES' => 0,
    'FIELD_TYPE' => 0,
    'ADD_SUPPORTED_FIELD_TITLES' => 0,
    'FIELD_TYPE_INFO' => 0,
    'TYPE_INFO' => 0,
    'TYPE_INFO_VALUE' => 0,
    'SUPPORTED_MODULES' => 0,
    'MODULE_NAME' => 0,
    'SELECTED_MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7737d6c36d3',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7737d6c36d3')) {function content_5b7737d6c36d3($_smarty_tpl) {?><?php $_smarty_tpl->tpl_vars['FIELD_TYPE_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->getAddFieldTypeInfo(), null, 0);?><?php $_smarty_tpl->tpl_vars['IS_SORTABLE'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isSortableAllowed(), null, 0);?><?php $_smarty_tpl->tpl_vars['IS_BLOCK_SORTABLE'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isBlockSortableAllowed(), null, 0);?><?php $_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS'] = new Smarty_variable(array(), null, 0);?><?php $_smarty_tpl->tpl_vars['ACTIVE_FIELDS'] = new Smarty_variable(array(), null, 0);?><?php $_smarty_tpl->tpl_vars['IN_ACTIVE_FIELDS'] = new Smarty_variable(array(), null, 0);?><div class='modelContainer modal addCustomFieldView' id="layoutEditorContainer"><div class="contents tabbable"><div class="modal-header"><button class="close vtButton" data-dismiss="modal">x</button><h3><?php echo vtranslate('LBL_CREATE_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><form class="form-horizontal contentsBackground addCustomField" id="addCustomField" name="addCustomField"><input name="hdn_entityid" id="hdn_entityid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ENTITY_RECORD']->value;?>
" /><input name="hdn_blockid" id="hdn_blockid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" /><div class="modal-body"><div class="control-group"><span class="control-label"><strong>Select Field Type</strong></span><div class="controls"><span class="row-fluid"><select class="fieldTypesList span6" name="fieldType"><?php  $_smarty_tpl->tpl_vars['FIELD_TYPE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_TYPE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ADD_SUPPORTED_FIELD_TYPES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_TYPE']->key => $_smarty_tpl->tpl_vars['FIELD_TYPE']->value){
$_smarty_tpl->tpl_vars['FIELD_TYPE']->_loop = true;
?><option title="<?php echo $_smarty_tpl->tpl_vars['ADD_SUPPORTED_FIELD_TITLES']->value[$_smarty_tpl->tpl_vars['FIELD_TYPE']->value];?>
" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_TYPE']->value;?>
"<?php  $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['TYPE_INFO'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_TYPE_INFO']->value[$_smarty_tpl->tpl_vars['FIELD_TYPE']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->key => $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->value){
$_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['TYPE_INFO']->value = $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->key;
?>data-<?php echo $_smarty_tpl->tpl_vars['TYPE_INFO']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->value;?>
"<?php } ?>><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_TYPE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?></select></span></div></div><!-- Next --><div class="control-group supportedType relatedtoOption hide"><span class="control-label"><strong>Related Module</strong></span><div class="controls"><span class="row-fluid"><select class="relatedModulesList span6" id="relatedModule" name="relatedModule" onchange="setRelatedLabel(this);"><option value="Users" title="Create a relation with <?php echo vtranslate('LBL_USERS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><?php echo vtranslate("LBL_USERS",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUPPORTED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_NAME']->key => $_smarty_tpl->tpl_vars['MODULE_NAME']->value){
$_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = true;
?><option title="Create a relation with <?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value==$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?><option value="Multimodule A" title="Creates a related field from a module choice of Vendors, Leads, Organizations, Contacts and Users"><?php echo vtranslate("Multimodule A",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option value="Multimodule B" title="Creates a related field from a module choice of Campaigns, Leads, Organizations, Opportunities and Tickets"><?php echo vtranslate("Multimodule B",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option value="Multimodule C" title="Creates a related field from a module choice of Organizations and Contacts"><?php echo vtranslate("Multimodule C",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><option value="Multimodule D" title="Creates a related field from a module choice of Campaigns and Users"><?php echo vtranslate("Multimodule D",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option></select></span></div></div><div class="control-group"><span class="control-label"><strong>Label Name</strong><span class="redColor">*</span></span><div class="controls"><input class="validate[required] text-input" type="text" maxlength="50" name="fieldLabel" id="fieldLabel" value="" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"data-validator=<?php echo Zend_Json::encode(array(array('name'=>'FieldLabel')));?>
 /><!--input type="text" maxlength="50" name="fieldLabel" id="fieldLabel" value="" class="validate[required] text-input" /--></div></div><div class="control-group supportedType lengthsupported"><span class="control-label"><strong><?php echo vtranslate('LBL_LENGTH',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong><span class="redColor">*</span></span><div class="controls"><input class="validate[required]" type="text" name="fieldLength" value="" data-validation-engine="lengthsupported" /></div></div><!-- Next --><div class="control-group supportedType decimalsupported hide"><span class="control-label"><strong><?php echo vtranslate('LBL_DECIMALS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong><span class="redColor">*</span></span><div class="controls"><input class="validate[required]" type="text" name="decimal" value="" data-validation-engine="decimalsupported" /></div></div><!-- Next --><div class="control-group supportedType preDefinedValueExists hide"><span class="control-label"><strong><?php echo vtranslate('LBL_PICKLIST_VALUES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong><span class="redColor">*</span></span><div class="controls"><div class="row-fluid"><input class="validate[required] text-input span7 select2" type="hidden" id="picklistUi" name="pickListValues"placeholder="<?php echo vtranslate('LBL_ENTER_PICKLIST_VALUES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-validation-engine="preDefinedValueExists"data-validator=<?php echo Zend_Json::encode(array(array('name'=>'PicklistFieldValues')));?>
 /></div></div></div><!-- Next --><div class="control-group supportedType picklistOption hide"><span class="control-label">&nbsp;</span><div class="controls"><label class="checkbox"><input type="checkbox" class="checkbox" name="isRoleBasedPickList" value="1" >&nbsp;<?php echo vtranslate('LBL_ROLE_BASED_PICKLIST',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></div></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div></div><?php }} ?>