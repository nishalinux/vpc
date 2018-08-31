<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:52:31
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/ModuleSummaryView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:16026528275b7316dfdffa95-35796019%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2c6e3944a820f1d6c38315b99d36aacb07866b1f' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/ModuleSummaryView.tpl',
      1 => 1532594459,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '16026528275b7316dfdffa95-35796019',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SUMMARY_INFORMATION_PROCESSFLOW' => 0,
    'FIELD_VALUE_DATA' => 0,
    'FIELD_NAME' => 0,
    'MODULE_NAME' => 0,
    'FIELD_VALUE' => 0,
    'RECORDID' => 0,
    'SUMMARY_INFORMATION' => 0,
    'SUMMARY_CATEGORY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7316dfe8d98',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7316dfe8d98')) {function content_5b7316dfe8d98($_smarty_tpl) {?>
<div class="recordDetails"><div><h4>Process Flow Module Summary</h4><hr></div><?php  $_smarty_tpl->tpl_vars['FIELD_VALUE_DATA'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_VALUE_DATA']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME_DATA'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['SUMMARY_INFORMATION_PROCESSFLOW']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_VALUE_DATA']->key => $_smarty_tpl->tpl_vars['FIELD_VALUE_DATA']->value){
$_smarty_tpl->tpl_vars['FIELD_VALUE_DATA']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME_DATA']->value = $_smarty_tpl->tpl_vars['FIELD_VALUE_DATA']->key;
?><div class="row-fluid textAlignCenter roundedCorners"><?php  $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_VALUE_DATA']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_VALUE']->key => $_smarty_tpl->tpl_vars['FIELD_VALUE']->value){
$_smarty_tpl->tpl_vars['FIELD_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_VALUE']->key;
?><span class="well squeezedWell span3"><div><label class="font-x-small"><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</label></div><div><label class="font-x-x-large <?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Pending Decision"||$_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Pending Approval"||$_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Task Completed"||$_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Total Time Spent"){?>showpopup<?php }?>" <?php if ($_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Pending Decision"||$_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Pending Approval"||$_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Task Completed"||$_smarty_tpl->tpl_vars['FIELD_NAME']->value=="Total Time Spent"){?>data-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
"<?php }?>><?php if (!empty($_smarty_tpl->tpl_vars['FIELD_VALUE']->value['total'])&&$_smarty_tpl->tpl_vars['FIELD_VALUE']->value['filter']!=''){?><a href="index.php?module=Project&relatedModule=ProcessFlow&view=Detail&record=<?php echo $_smarty_tpl->tpl_vars['RECORDID']->value;?>
&mode=showRelatedList&tab_label=ProcessFlow&pf_process_status=<?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value['filter'];?>
" ><?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value['total'];?>
</a><?php }else{ ?><a href="#x"><?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value['total'];?>
</a><?php }?></label></div></span><?php } ?></div><?php } ?></div><div class="recordDetails"><div><h4>Project <?php echo vtranslate('LBL_RECORD_SUMMARY',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
	</h4><hr></div><?php  $_smarty_tpl->tpl_vars['SUMMARY_CATEGORY'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['SUMMARY_CATEGORY']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUMMARY_INFORMATION']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['SUMMARY_CATEGORY']->key => $_smarty_tpl->tpl_vars['SUMMARY_CATEGORY']->value){
$_smarty_tpl->tpl_vars['SUMMARY_CATEGORY']->_loop = true;
?><div class="row-fluid textAlignCenter roundedCorners"><?php  $_smarty_tpl->tpl_vars['FIELD_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['SUMMARY_CATEGORY']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_VALUE']->key => $_smarty_tpl->tpl_vars['FIELD_VALUE']->value){
$_smarty_tpl->tpl_vars['FIELD_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_VALUE']->key;
?><span class="well squeezedWell span3"><div><label class="font-x-small"><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</label></div><div><label class="font-x-x-large" ><?php if (!empty($_smarty_tpl->tpl_vars['FIELD_VALUE']->value)){?><a href="index.php?module=Project&relatedModule=ProjectTask&view=Detail&record=<?php echo $_smarty_tpl->tpl_vars['RECORDID']->value;?>
&mode=showRelatedList&tab_label=Project Tasks&type=<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" data-label-key="Project Tasks"><?php echo $_smarty_tpl->tpl_vars['FIELD_VALUE']->value;?>
</a><?php }else{ ?>0<?php }?></label></div></span><?php } ?></div><?php } ?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('SummaryViewContents.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><!-- Button trigger modal --><!-- Modal --><!-- Modal --><style>.modal{width: 80%; /* respsonsive width */margin-left:-40%; /* width/2) */}table {font-family: arial, sans-serif;border-collapse: collapse;width: 100%;}td, th {border: 1px solid #dddddd;text-align: left;padding: 8px;}tr:nth-child(even) {background-color: #dddddd;}</style><div class="modal fade" id="myModal" role="dialog"><div class="modal-dialog modal-lg"><div class="modal-content"><div class="modal-header"><button type="button" class="close" data-dismiss="modal">&times;</button><h4 class="modal-title">Modal Header</h4></div><div class="modal-body"><p>This is a large modal.</p></div><div class="modal-footer"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div>
<?php }} ?>