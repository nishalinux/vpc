<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 08:16:28
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2CheckList/EditAjax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:723596165b77d5dc8b6619-39484936%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '7b39cd4c91e51aed38d1aefec911e352370eec33' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2CheckList/EditAjax.tpl',
      1 => 1534579736,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '723596165b77d5dc8b6619-39484936',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_MODEL' => 0,
    'CURRENCY_ID' => 0,
    'COUNT' => 0,
    'PICKLIST_MODULES' => 0,
    'modulename' => 0,
    'PICKLIST_MODULE' => 0,
    'foo' => 0,
    'CATEGORY' => 0,
    'TITLE' => 0,
    'UPLOAD' => 0,
    'NOTE' => 0,
    'DESCRIPTION' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77d5dc90b30',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77d5dc90b30')) {function content_5b77d5dc90b30($_smarty_tpl) {?>
<style>
	.checklist-item {
		border: 1px solid #ccc;
		padding: 20px 0;
		display: block;
		overflow: hidden;
		margin: 10px 0;
	}
	label {
		display: inline-block;
	}
</style>

<?php $_smarty_tpl->tpl_vars['CURRENCY_ID'] = new Smarty_variable($_smarty_tpl->tpl_vars['RECORD_MODEL']->value->getId(), null, 0);?><form id='CustomView' class="form-horizontal" method="POST"><div class="container-fluid" id="vte-primary-box" style="height: 563px; width: 1240px;"><input type="hidden" name="module" value="OS2CheckList" /><input type="hidden" value="Settings" name="parent"><input type="hidden" name="action" value="SaveAjax"><input type="hidden" id="textarea_id" name="count" value="0"><input type="hidden" name="checklistid" id="checklistid" value="<?php echo $_smarty_tpl->tpl_vars['CURRENCY_ID']->value;?>
"><input type="hidden" id="nameee" value="<?php echo $_smarty_tpl->tpl_vars['COUNT']->value;?>
"><div class="row-fluid" style="padding: 10px 0;"><h3 class="textAlignCenter">Edit<small aria-hidden="true" data-dismiss="modal" class="pull-right ui-checklist-closer" style="cursor: pointer;" title=" LBL_MODAL_CLOSE">x</small></h3><hr></div><div class="listViewContentDiv row-fluid" id="listViewContents" style="height: 450px; overflow-y: auto; width: 1250px;"><div class="marginBottom10px"><div class="row-fluid"><div class="row marginBottom10px"><div class="span4 textAlignRight">Check List Name</div><div class="fieldValue span6"><input type="text" name="checklistname" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_MODEL']->value->get('checklistname');?>
" class="input-large"></div></div><div class="row marginBottom10px"><div class="span4 textAlignRight">Module Name</div><div class="fieldValue span6"><select name="modulename" class="chzn-select" ><?php  $_smarty_tpl->tpl_vars['PICKLIST_MODULE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->key => $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_MODULE']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->key;
?><option <?php if ($_smarty_tpl->tpl_vars['modulename']->value==$_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value[0]){?> selected="" <?php }?> value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value[0];?>
"><?php echo $_smarty_tpl->tpl_vars['PICKLIST_MODULE']->value[1];?>
</option><?php } ?></select></div></div></div><div class="marginBottom10px items-list"><table width="100%" cellpadding="5" cellspacing="5" class="items-list-table"><tbody class="ui-sortable"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['COUNT']->value-1;?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['foo']->step = 1;$_smarty_tpl->tpl_vars['foo']->total = (int)ceil(($_smarty_tpl->tpl_vars['foo']->step > 0 ? $_tmp1+1 - (0) : 0-($_tmp1)+1)/abs($_smarty_tpl->tpl_vars['foo']->step));
if ($_smarty_tpl->tpl_vars['foo']->total > 0){
for ($_smarty_tpl->tpl_vars['foo']->value = 0, $_smarty_tpl->tpl_vars['foo']->iteration = 1;$_smarty_tpl->tpl_vars['foo']->iteration <= $_smarty_tpl->tpl_vars['foo']->total;$_smarty_tpl->tpl_vars['foo']->value += $_smarty_tpl->tpl_vars['foo']->step, $_smarty_tpl->tpl_vars['foo']->iteration++){
$_smarty_tpl->tpl_vars['foo']->first = $_smarty_tpl->tpl_vars['foo']->iteration == 1;$_smarty_tpl->tpl_vars['foo']->last = $_smarty_tpl->tpl_vars['foo']->iteration == $_smarty_tpl->tpl_vars['foo']->total;?><tr class="checklist-item"><td width="14" valign="middle"><i class="icon-move alignMiddle" title="Change ordering" data-record=""></i></td><td width="1172"><table width="100%" cellpadding="5" cellspacing="5"><tbody class="ui-sortable"><tr><td width="25%"><img title="Category" data-url="" class="icon-info category_info" src="layouts/vlayout/modules/Settings/OS2CheckList/resources/info.png" width="16" height="16"><input type="text" name="category[]" value="<?php echo $_smarty_tpl->tpl_vars['CATEGORY']->value[$_smarty_tpl->tpl_vars['foo']->value];?>
" ></td><td width="25%"><img title="Title" data-url="" class="icon-info title_info" src="layouts/vlayout/modules/Settings/OS2CheckList/resources/info.png" width="16" height="16"><input type="text" name="title[]" value="<?php echo $_smarty_tpl->tpl_vars['TITLE']->value[$_smarty_tpl->tpl_vars['foo']->value];?>
" placeholder="Title"></td><td width="25%"><img title="Require Document/Attachment?" data-url="" class="icon-info allow_upload_info" src="layouts/vlayout/modules/Settings/OS2CheckList/resources/info.png" width="16" height="16"><label>Require Document/Attachment?</label><input type="checkbox" class="allow_upload" value="0" <?php if ($_smarty_tpl->tpl_vars['UPLOAD']->value[$_smarty_tpl->tpl_vars['foo']->value]==1){?>checked<?php }?>><input type="hidden" name="allow_upload[]" class="allow_upload_value" value="<?php echo $_smarty_tpl->tpl_vars['UPLOAD']->value[$_smarty_tpl->tpl_vars['foo']->value];?>
"></td><td width="25%"><img title="Allow Notes" data-url="" class="icon-info allow_note_info" src="layouts/vlayout/modules/Settings/OS2CheckList/resources/info.png" width="16" height="16"><label>Allow Notes</label><input type="checkbox" class="allow_note" value="0" <?php if ($_smarty_tpl->tpl_vars['NOTE']->value[$_smarty_tpl->tpl_vars['foo']->value]==1){?>checked<?php }?>><input type="hidden" name="allow_note[]" class="allow_note_value" value="<?php echo $_smarty_tpl->tpl_vars['NOTE']->value[$_smarty_tpl->tpl_vars['foo']->value];?>
"></td></tr><tr><td colspan="4"><textarea name="description[]" class="description" placeholder="Description" style="width: 800px; height: 75px; visibility: hidden; display: none;" id="desc_0"><?php echo $_smarty_tpl->tpl_vars['DESCRIPTION']->value[$_smarty_tpl->tpl_vars['foo']->value];?>
</textarea></td></tr></tbody></table></td></tr><?php }} ?></tbody></table></div><div class="filterActions" style="padding: 10px 0;"><button class="btn addButton btn-add pull-left marginRight10px" id="add-checklist-item" type="button"><i class="icon-plus"></i>&nbsp;<strong>Add Checklist Item</strong></button><button class="btn btn-success pull-right" id="save-checklist" type="submit"><strong>Save</strong></button></div></div></form><script type="text/javascript" src="libraries/jquery/ckeditor/ckeditor.js"></script>	<?php }} ?>