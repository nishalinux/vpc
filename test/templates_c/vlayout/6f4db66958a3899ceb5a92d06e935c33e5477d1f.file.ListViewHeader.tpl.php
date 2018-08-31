<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 07:14:18
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/ListViewHeader.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17130714255b73a52f15dd92-81885313%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6f4db66958a3899ceb5a92d06e935c33e5477d1f' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/ListViewHeader.tpl',
      1 => 1534922051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17130714255b73a52f15dd92-81885313',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73a52f1913c',
  'variables' => 
  array (
    'MODULE' => 0,
    'QUALIFIED_MODULE' => 0,
    'TOTAL_LOGIN' => 0,
    'USERSLIST' => 0,
    'USER' => 0,
    'USERNAME' => 0,
    'SELECTED_USER' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73a52f1913c')) {function content_5b73a52f1913c($_smarty_tpl) {?>
<div class="listViewPageDiv"><div class="listViewTopMenuDiv noprint"><div class="container-fluid"><div class="widget_header row-fluid"><div class="span6"><h3><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><div class="span6 pull-right" style="text-align:right; margin-top:10px;"><b><?php echo vtranslate("Total Logged in Users",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 : <?php echo $_smarty_tpl->tpl_vars['TOTAL_LOGIN']->value;?>
</b></div></div><hr><div class="row-fluid"><span class="span5 btn-toolbar"><span class="btn-group listViewMassActions"><button class="btn dropdown-toggle" data-toggle="dropdown"><strong>Actions</strong>&nbsp;&nbsp;<i class="caret"></i></button><ul class="dropdown-menu"><li id=""><a href="javascript:void(0);" id="exportForm">Export</a></li></ul></span><span class="btn-group" style="display:inline-table"><input id="startdate" type="text" class="dateField span2 listSearchContributor autoComplete ui-autocomplete-input" name="start_date" data-date-format="dd-mm-yyyy" value="" data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"><span class="add-on"><i class="icon-calendar cal1"></i></span></span><span class="btn-group" style="display:inline-table"><input id="enddate" type="text" class="dateField span2 listSearchContributor autoComplete ui-autocomplete-input" name="start_date" data-date-format="dd-mm-yyyy" value="" data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"><span class="add-on"><i class="icon-calendar cal2"></i></span></span></span><div class="span3 btn-toolbar"><select class="chzn-select" id="usersFilter"><option value=""><?php echo vtranslate('LBL_ALL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['USERNAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['USERNAME']->_loop = false;
 $_smarty_tpl->tpl_vars['USER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['USERSLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['USERNAME']->key => $_smarty_tpl->tpl_vars['USERNAME']->value){
$_smarty_tpl->tpl_vars['USERNAME']->_loop = true;
 $_smarty_tpl->tpl_vars['USER']->value = $_smarty_tpl->tpl_vars['USERNAME']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['USER']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['USERNAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['USERNAME']->value==$_smarty_tpl->tpl_vars['SELECTED_USER']->value){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['USERNAME']->value;?>
</option><?php } ?></select></div><span class="span4 btn-toolbar"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ListViewActions.tpl',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</span></div></div></div><div class="clearfix"></div><div class="listViewContentDiv" id="listViewContents">

<!-- added by jyothi for login++ -->
<script>
   $(document).ready(function(){

   	   app.registerEventForDatePickerFields('#startdate');
		jQuery('.cal1').on('click',function(){
		  jQuery("#startdate").trigger("focus");
		 });

		app.registerEventForDatePickerFields('#enddate');
		jQuery('.cal2').on('click',function(){
		  jQuery("#enddate").trigger("focus");
		 });

       jQuery('#exportForm').bind("click", function() {
             var user = $('#usersFilter option:selected').text();
             var startdate = $('#startdate').val();
             // alert(startdate);
             var enddate = $('#enddate').val();
             // alert(enddate);
            window.location.href='index.php?module=OS2LoginHistory&parent=Settings&action=ListAjaxData&user='+$.trim(user)+'&startdate='+startdate+'&enddate='+enddate;
       });
   });
</script>
<!-- ended here -->
<?php }} ?>