<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:16
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/NewModule.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13638454575b7320a8260847-57877340%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f05a9e188c7333a154ebca7ffbebc430c1f0cab0' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/NewModule.tpl',
      1 => 1517656880,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13638454575b7320a8260847-57877340',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'PARENTTAB' => 0,
    'v' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a827d57',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a827d57')) {function content_5b7320a827d57($_smarty_tpl) {?><!-- vtDZiner Add Module UI starts :: STP on 19th May,2013 --><div class="modal addCustomModuleModal hide"><div class="modal-header"><button class="close vtButton" data-dismiss="modal">x</button><h3><?php echo vtranslate('LBL_CREATE_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><form class="form-horizontal contentsBackground addCustomModuleForm"><div class="modal-body"><div class="control-group"><span class="control-label"><strong><?php echo vtranslate('LBL_CUSTOM_MODULE_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></span><div class="controls"><span class="row-fluid"><select class="span6 vtselector" name="moduleType"><option value="Entity" data-label="Entity">Entity</option><!--option value="Extension" data-label="Extension">Extension</option><!--option value="Language" disabled data-label="Language">Language</option><option value="Theme" disabled data-label="Theme">Theme</option><option value="Portal" disabled data-label="Portal">Portal</option><option value="Process" disabled data-label="Process">Process</option><option value="Chart" disabled data-label="Chart">Chart</option--></select></span></div></div><div class="control-group"><span class="control-label"><strong><?php echo vtranslate('LBL_MODULE_PARENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span></strong></span><div class="controls"><span class="row-fluid"><select class="vtselector span6" name="label" id="label_dropdown"><?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PARENTTAB']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option><?php } ?></select></span></div></div><div class="control-group"><span class="control-label"><strong><?php echo vtranslate('LBL_MODULE_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span></strong></span><div class="controls"><!--input type="text" name="label_modulename" class="span3" data-validation-engine="validate[required]" /--><input type="text" name="label_modulename" class="span3 validate[required] text-input" data-validation-engine='validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]],funcCall[Vtiger_AlphaNumericName_Validator_Js.invokeValidation]]'  /></div></div><div class="control-group"><span class="control-label"><strong><?php echo vtranslate('LBL_RETURN_ACTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></span><div class="controls"><span class="row-fluid">Choose an option<br><input class="span1" name="returnaction" id="returnaction" type="radio" title="Check to stay in current module after creation" value="stayback"/>&nbsp;Stay in current module<br><input class="span1" name="returnaction" id="returnaction" type="radio" title="Check to proceed to vtDZine new module after creation" value="vtdziner" checked="checked"/>&nbsp;TheracannDZine New Module<br><input class="span1" name="returnaction" id="returnaction" type="radio" title="Check to proceed to new module after creation" value="newmodule"/>&nbsp;Go to new module<br><input class="span1" name="returnaction" id="returnaction" type="radio" title="Check to proceed to Home after creation" value="showhome"/>&nbsp;Home<br></span></div></div><!--<div class="control-group"><span class="control-label"><strong><?php echo vtranslate('LBL_AUTOSEQUENCE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></span><div class="controls"><span class="row-fluid"><table class="span2" ><tr><td><input name="autosequence" id="returnaction" type="checkbox" title="Check to autosequence entity records"/></td></tr></table><table class="span2" ><tr><td><input class="span2" name="as_prefix" id="as_prefix" type="text" title="Enter a preferred prefix for auto sequencing"/></td></tr><tr><td><span>A/s Prefix</span></td></tr></table><table class="span2" ><tr><td><input class="span2" name="as_startnumber" id="as_startnumber" type="text" title="Enter the start number for auto sequencing"/></td></tr><tr><td><span>A/s Start</span></td></tr></table></span></div></div>--></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div><!-- vtDZiner Add Module UI ends :: STP on 19th May,2013 --><?php }} ?>