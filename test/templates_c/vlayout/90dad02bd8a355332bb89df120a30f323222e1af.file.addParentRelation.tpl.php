<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 21:43:56
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/addParentRelation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14678070575b734d1c7293a7-44470364%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '90dad02bd8a355332bb89df120a30f323222e1af' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/addParentRelation.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14678070575b734d1c7293a7-44470364',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SELECTED_MODULE_NAME' => 0,
    'SUPPORTED_MODULES' => 0,
    'MODULE_NAME' => 0,
    'RELATED_MODULES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b734d1c7535e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b734d1c7535e')) {function content_5b734d1c7535e($_smarty_tpl) {?><div class="modal addRelationModal hide">
	<div class="modal-header">
		<button class="close vtButton" data-dismiss="modal">x</button>
			<h3><?php echo vtranslate('LBL_ADD_PARENT_RELATION',"Settings::vtDZiner");?>
</h3>
	</div>
	<form class="form-horizontal contentsBackground addRelationForm">
		<div class="modal-body">
			<div class="control-group">
				<span class="control-label">
					<strong>
						<?php echo vtranslate('LBL_RELATED_MODULE_NAME',"Settings::vtDZiner");?>
 <span class="redColor">*</span>
					</strong>
				</span>
				<div class="controls">
					<input type="hidden" name="childmodule" value='<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
' />
					<select name="parentmodule" id="parentmodule" class="span3 vtselector" data-validation-engine="validate[required]" onchange="getRelatedModuleFields(this.value);selectReferenceField('parent');">
					<?php  $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUPPORTED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_NAME']->key => $_smarty_tpl->tpl_vars['MODULE_NAME']->value){
$_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = true;
?>
					<?php if (in_array($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['RELATED_MODULES']->value['Parenttabs'])){?>
					<?php }else{ ?>
						<option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
</option>
					<?php }?>
					<?php } ?>
					</select>
				</div>
			</div>
			<div class="control-group">
				<span class="control-label">
					<strong>
						<?php echo vtranslate('LBL_RELATED_REFERENCE',"Settings::vtDZiner");?>
 <span class="redColor">*</span>
					</strong>
				</span>
				<div class="controls">
					<input type="checkbox" name="relatedreference" id="relatedreference" onclick="selectReferenceField('parent');" />
				</div>
			</div>
			<!-- <div class="relatedFieldGroup hide">
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_RELATED_REFERENCE_LABEL',"Settings::vtDZiner");?>

						</strong>
					</span>
					<div class="controls">
						<input type="text" name="referencelabel" id="referencelabel" /><br/>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_RELATED_MODULE_FIELDS',"Settings::vtDZiner");?>

						</strong>
					</span>
					<div class="controls">
						<input type="checkbox" name="relatedfields" id="relatedfields" onclick="selectRelatedFields('parent');" />
						<span class="relatedfieldslistarea hide">
						<br>Select fields from drop down and arrange their sequence
						<hr>
                        <select name="sel_col" id="sel_col"   class="select2-container columnsSelect" multiple>
                        </select>
						</span>
					</div>
				</div>
			</div>-->
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</form>
</div><?php }} ?>