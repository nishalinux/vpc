<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 16:07:28
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailViewContents.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1125517065b73a53a2f6fe8-22257594%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f79865f2dfa3b5ef33f60390e1baa34c50633469' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailViewContents.tpl',
      1 => 1534922051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1125517065b73a53a2f6fe8-22257594',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73a53a33656',
  'variables' => 
  array (
    'ISSUES_LIST' => 0,
    'WIDTH' => 0,
    'QUALIFIED_MODULE' => 0,
    'SEARCH_USERNAME' => 0,
    'SEARCH_MODULENAME' => 0,
    'SEARCH_FIELDNAME' => 0,
    'SEARCH_PRE_VALUE' => 0,
    'SEARCH_POST_VALUE' => 0,
    'SEARCH_CHANGEDON' => 0,
    'MODULE' => 0,
    'LINE_ITEM_DETAIL' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73a53a33656')) {function content_5b73a53a33656($_smarty_tpl) {?>
<div class="container-fluid"><div class="row-fluid"><input type="hidden" name="moduledata" id="moduledata" value="<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['ISSUES_LIST']->value));?>
"><table class="table table-striped table-bordered login_table modules-data"><thead><tr><th width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" style="border-left: 1px solid #DDD !important;" nowrap="nowrap"><?php echo vtranslate('LBL_WHODID',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" style="border-left: 1px solid #DDD !important;" nowrap="nowrap"><?php echo vtranslate('LBL_MODULES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" style="border-left: 1px solid #DDD !important;" nowrap="nowrap"><?php echo vtranslate('LBL_FIELDNAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" style="border-left: 1px solid #DDD !important;" nowrap="nowrap"><?php echo vtranslate('LBL_PRE_VALUE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" style="border-left: 1px solid #DDD !important;" nowrap="nowrap"><?php echo vtranslate('LBL_POST_VALUE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th width="<?php echo $_smarty_tpl->tpl_vars['WIDTH']->value;?>
%" style="border-left: 1px solid #DDD !important;" nowrap="nowrap"><?php echo vtranslate('LBL_CHANGEON',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th><th></th></tr><tr><th><div class="row-fluid"><input type="text" name="search_username" class="span9 listSearchContributor autoComplete ui-autocomplete-input" id="listviewsearchfield" value ="<?php echo $_smarty_tpl->tpl_vars['SEARCH_USERNAME']->value;?>
"/></div></th><th><div class="row-fluid"><input type="text" name="search_modulename" class="span9 listSearchContributor autoComplete ui-autocomplete-input" id="listviewsearchfield" value ="<?php echo $_smarty_tpl->tpl_vars['SEARCH_MODULENAME']->value;?>
"/></div></th><th><div class="row-fluid"><input type="text" name="search_fieldname" class="span9 listSearchContributor autoComplete ui-autocomplete-input" id="listviewsearchfield" value ="<?php echo $_smarty_tpl->tpl_vars['SEARCH_FIELDNAME']->value;?>
"/></div></th><th><div class="row-fluid"><input type="text" name="search_prevalue" class="span9 listSearchContributor autoComplete ui-autocomplete-input" id="listviewsearchfield" value ="<?php echo $_smarty_tpl->tpl_vars['SEARCH_PRE_VALUE']->value;?>
"/></div></th><th><div class="row-fluid"><input type="text" name="search_postvalue" class="span9 listSearchContributor autoComplete ui-autocomplete-input" id="listviewsearchfield" value ="<?php echo $_smarty_tpl->tpl_vars['SEARCH_POST_VALUE']->value;?>
"/></div></th><th><div class="row-fluid"><input id="listviewsearchfield" type="text" class="changedon dateField span9 listSearchContributor autoComplete ui-autocomplete-input" name="search_changedon" data-date-format="dd-mm-yyyy" value="<?php echo $_smarty_tpl->tpl_vars['SEARCH_CHANGEDON']->value;?>
" data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"><span class="add-on"><i class="icon-calendar change"></i></span><!-- 	<input type="text" name="search_changedon" class="span9 listSearchContributor autoComplete ui-autocomplete-input" id="listviewsearchfield" value ="<?php echo $_smarty_tpl->tpl_vars['SEARCH_CHANGEDON']->value;?>
"/> --></div></th><th><div class="row-fluid"><button class="btn search_btn" data-trigger="listSearch"><?php echo vtranslate('LBL_SEARCH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</button></div></th></tr></thead><tbody><?php if ($_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['totalcount']>0){?><?php  $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->_loop = false;
 $_smarty_tpl->tpl_vars['INDEX'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ISSUES_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->key => $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value){
$_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->_loop = true;
 $_smarty_tpl->tpl_vars['INDEX']->value = $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->key;
?><tr><td><?php echo $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value["whodid"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value["module"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value["fieldname"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value["prevalue"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value["postvalue"];?>
</td><td><?php echo $_smarty_tpl->tpl_vars['LINE_ITEM_DETAIL']->value['changedon'];?>
</td><td></td></tr><?php } ?><?php }else{ ?><tr><td colspan='7'>No Actions Performed</td></tr><?php }?></tbody></table></div></div>
<script type="text/javascript">
	$(document).ready(function(){

   	   app.registerEventForDatePickerFields('.changedon');
		jQuery('.change').on('click',function(){
		  jQuery(".changedon").trigger("focus");
		 });
});	
</script>
 	  <?php }} ?>