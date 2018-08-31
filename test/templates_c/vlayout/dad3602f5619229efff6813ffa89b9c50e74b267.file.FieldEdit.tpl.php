<?php /* Smarty version Smarty-3.1.7, created on 2018-08-20 18:08:11
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/FieldEdit.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10431156875b7b038bd634d1-43511914%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'dad3602f5619229efff6813ffa89b9c50e74b267' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/FieldEdit.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10431156875b7b038bd634d1-43511914',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELDMODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7b038bd9c2c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7b038bd9c2c')) {function content_5b7b038bd9c2c($_smarty_tpl) {?><form id="FieldDetails"><div id="globalmodal" style="display: block;"><div class="currencyModalContainer"><div class="modal-header contentsBackground"><button aria-hidden="true" data-dismiss="modal" class="close" type="button">×</button><h3>Edit Field</h3></div><table width="100%" border="0" class="table table-bordered table-condensed"><tr><td>Field Label</td><td><input name="hdn_fieldid" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->id;?>
" /><input id = "txtfieldlabel" name="fieldlabel" type="text" value="<?php echo $_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->label;?>
" /></td></tr><tr><td>UI Type</td><td><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->uitype=="16"){?>Click to Manage Picklist<?php }?></td></tr><tr><td>Mandatory Field</td><td><?php if (strstr($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->typeofdata,"~M")!=''){?><input type="checkbox" name="mandatory" id="cbmandatory" checked><?php }else{ ?><input type="checkbox" name="mandatory" id="cbmandatory"><?php }?></td></tr><tr><td>Active</td><td><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->presence==2){?><input type="checkbox" name="presence" id="cbpresence" checked><?php }elseif($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->presence==0){?><input type="checkbox" name="presence" id="cbpresence" checked disabled><?php }elseif($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->presence==1){?><input type="checkbox" name="presence" id="cbpresence"><?php }?></td></tr><tr><td>Quick Create</td><td><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->quickcreate==1){?><input type="checkbox" name="quickcreate" id="cbquickcreate" checked><?php }else{ ?><input type="checkbox" name="quickcreate" id="cbquickcreate"><?php }?></td></tr><tr><td>Summary View</td><td><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->summaryfield==1){?><input type="checkbox" name="summaryfield" id="cbsummaryfield" checked><?php }else{ ?><input type="checkbox" name="summaryfield" id="cbsummaryfield"><?php }?></td></tr><tr><td>Mass Edit</td><td><?php if ($_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->masseditable==1){?><input type="checkbox" name="masseditable" id="cbmasseditable" checked><?php }else{ ?><input type="checkbox" name="masseditable" id="cbmasseditable"><?php }?></td></tr><tr><td>Helpinfo</td><td><input name="helpinfo" id="txthelpinfo"  type="text" value = "<?php echo $_smarty_tpl->tpl_vars['FIELDMODEL']->value[0]->helpinfo;?>
"></td></tr><!--<tr><td>Searchable</td><td><input type="checkbox" value="" name="searchable"></td></tr><tr><td>All Filter</td><td><input type="checkbox" value="" name="inAllFilter"></td></tr>--><tr><td align="right" colspan="2"><span class="pull-right"><button style="margin: 5px;" id = "saveFieldDetails" type="submit" data-field-id="117" class="btn btn-success saveFieldDetails"><strong>Save</strong></button></span></td></tr></table></div></div></form><?php }} ?>