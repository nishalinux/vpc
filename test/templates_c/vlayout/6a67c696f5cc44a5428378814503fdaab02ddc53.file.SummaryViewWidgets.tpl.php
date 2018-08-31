<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:52:32
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/SummaryViewWidgets.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13444019285b7316e004a502-02973427%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '6a67c696f5cc44a5428378814503fdaab02ddc53' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/SummaryViewWidgets.tpl',
      1 => 1533931404,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13444019285b7316e004a502-02973427',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'DETAILVIEW_LINKS' => 0,
    'DETAIL_VIEW_WIDGET' => 0,
    'MODULE_SUMMARY' => 0,
    'COMMENTS_WIDGET_MODEL' => 0,
    'MODULE_NAME' => 0,
    'HELPDESK_WIDGET_MODEL' => 0,
    'RELATED_MODULE_MODEL' => 0,
    'FIELD_MODEL' => 0,
    'FIELD_INFO' => 0,
    'SPECIAL_VALIDATOR' => 0,
    'PICKLIST_VALUES' => 0,
    'PICKLIST_NAME' => 0,
    'PICKLIST_VALUE' => 0,
    'PROJECT_PROCESSFLOWS' => 0,
    'process_data' => 0,
    'start_date' => 0,
    'end_date' => 0,
    'PROJECT_INPROGRESSPROCESSFLOWS' => 0,
    'MILESTONE_WIDGET_MODEL' => 0,
    'TASKS_WIDGET_MODEL' => 0,
    'DOCUMENT_WIDGET_MODEL' => 0,
    'UPDATES_WIDGET_MODEL' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7316e01b389',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7316e01b389')) {function content_5b7316e01b389($_smarty_tpl) {?>
<?php  $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['DETAILVIEW_LINKS']->value['DETAILVIEWWIDGET']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->key => $_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value){
$_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->_loop = true;
?><?php if (($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel()=='Documents')){?><?php $_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value, null, 0);?><?php }elseif(($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel()=='LBL_MILESTONES')){?><?php $_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value, null, 0);?><?php }elseif(($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel()=='HelpDesk')){?><?php $_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value, null, 0);?><?php }elseif(($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel()=='LBL_TASKS')){?><?php $_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value, null, 0);?><?php }elseif(($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel()=='ModComments')){?><?php $_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value, null, 0);?><?php }elseif(($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value->getLabel()=='LBL_UPDATES')){?><?php $_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['DETAIL_VIEW_WIDGET']->value, null, 0);?><?php }?><?php } ?><div class="row-fluid"><div class="span7"><div class="summaryView row-fluid"><?php echo $_smarty_tpl->tpl_vars['MODULE_SUMMARY']->value;?>
</div><?php if ($_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value){?><div class="summaryWidgetContainer"><div class="widgetContainer_comments" data-url="<?php echo $_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span9"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span><span class="span3"><?php if ($_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value->get('action')){?><button class="btn pull-right addButton createRecord" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value->get('actionURL');?>
"><strong><?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><?php }?></span><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['COMMENTS_WIDGET_MODEL']->value->get('linkName');?>
" /></div><div class="widget_contents"></div></div></div><?php }?><?php if ($_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value){?><div class="summaryWidgetContainer"><div class="widgetContainer_troubleTickets" data-url="<?php echo $_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span9"><div class="row-fluid"><span class="span4 margin0px"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span><span class="span7"><?php $_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL'] = new Smarty_variable(Vtiger_Module_Model::getInstance('HelpDesk'), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL']->value->getField('ticketstatus'), null, 0);?><?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()), null, 0);?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><?php $_smarty_tpl->tpl_vars["SPECIAL_VALIDATOR"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator(), null, 0);?><select class="chzn-select" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
" data-validation-engine="validate[<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()==true){?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD_INFO']->value, ENT_QUOTES, 'UTF-8', true);?>
' <?php if (!empty($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value)){?>data-validator='<?php echo Zend_Json::encode($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value);?>
'<?php }?> ><option><?php echo vtranslate('LBL_SELECT_STATUS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')==$_smarty_tpl->tpl_vars['PICKLIST_NAME']->value){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</option><?php } ?></select></span></div></span><span class="span3"><?php if ($_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value->get('action')){?><button class="btn pull-right addButton createRecord" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value->get('actionURL');?>
"><strong><?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><?php }?></span><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['HELPDESK_WIDGET_MODEL']->value->get('linkName');?>
" /></div><div class="widget_contents"></div></div></div><?php }?></div><div class='span5' style="overflow: hidden"><div class="summaryWidgetContainer"><div class="widgetContainer_processflow" ><div class="widget_header row-fluid"><span class="span9"><h4>Process Flows</h4></span></div><div class="widget_contents_process"><div class="row-fluid"><span class="span6"><strong>Process Flow Name</strong></span><span class="span3"><span class="pull-right"><strong>Start Date</strong></span></span><span class="span3"><span class="pull-right"><strong>End Date</strong></span></span></div><div class="recentActivitiesContainer_processflow"><?php  $_smarty_tpl->tpl_vars['process_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['process_data']->_loop = false;
 $_smarty_tpl->tpl_vars['process_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROJECT_PROCESSFLOWS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['process_data']->key => $_smarty_tpl->tpl_vars['process_data']->value){
$_smarty_tpl->tpl_vars['process_data']->_loop = true;
 $_smarty_tpl->tpl_vars['process_key']->value = $_smarty_tpl->tpl_vars['process_data']->key;
?><div class="row-fluid"><span class="span6 textOverflowEllipsis"><a href="index.php?module=ProcessFlow&view=Edit&record=<?php echo $_smarty_tpl->tpl_vars['process_data']->value['processflowid'];?>
" id="" title=""><?php echo $_smarty_tpl->tpl_vars['process_data']->value['processflowname'];?>
</a></span><span class="span3 horizontalLeftSpacingForSummaryWidgetContents"><span class="pull-right"><?php $_smarty_tpl->tpl_vars["start_date"] = new Smarty_variable(explode(" ",$_smarty_tpl->tpl_vars['process_data']->value['process_flow_start_time']), null, 0);?><?php echo $_smarty_tpl->tpl_vars['start_date']->value[0];?>
</span></span><span class="span3 horizontalLeftSpacingForSummaryWidgetContents"><span class="pull-right"><?php $_smarty_tpl->tpl_vars["end_date"] = new Smarty_variable(explode(" ",$_smarty_tpl->tpl_vars['process_data']->value['process_flow_end_time']), null, 0);?><?php echo $_smarty_tpl->tpl_vars['end_date']->value[0];?>
</span></span></div><?php } ?></div></div></div></div><div class="summaryWidgetContainer"><div class="widgetContainer_processflow" ><div class="widget_header row-fluid"><span class="span9"><h4>In Progress Processes</h4></span></div><div class="widget_contents_process"><div class="row-fluid"><span class="span4"><strong>Process Flow</strong></span><span class="span4 pull-left"><strong>Processes</strong></span><span class="pull-right"><strong>Assigned</strong></span></div><div class="recentActivitiesContainer_processflow"><?php  $_smarty_tpl->tpl_vars['process_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['process_data']->_loop = false;
 $_smarty_tpl->tpl_vars['process_key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROJECT_INPROGRESSPROCESSFLOWS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['process_data']->key => $_smarty_tpl->tpl_vars['process_data']->value){
$_smarty_tpl->tpl_vars['process_data']->_loop = true;
 $_smarty_tpl->tpl_vars['process_key']->value = $_smarty_tpl->tpl_vars['process_data']->key;
?><div class="row-fluid"><span class="span4 "><a href="#" title=""><?php echo $_smarty_tpl->tpl_vars['process_data']->value['processflowname'];?>
</a></span><span class="span4 textOverflowEllipsis"><span class="pull-left"><a href="#" title=""><?php echo $_smarty_tpl->tpl_vars['process_data']->value['description'];?>
</a></span></span><span class="span4 horizontalLeftSpacingForSummaryWidgetContents"><span class="pull-right"><a href="#" title=""><?php echo $_smarty_tpl->tpl_vars['process_data']->value['assignedto'];?>
</a></span></span></div><?php } ?></div></div></div></div><?php if ($_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value){?><div class="summaryWidgetContainer"><div class="widgetContainer_mileStone" data-url="<?php echo $_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span9"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span><span class="span3"><span class=" pull-right"><?php if ($_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value->get('action')){?><button class="btn addButton" id="createProjectMileStone" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value->get('actionURL');?>
" data-parent-related-field="projectid"><strong><?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><?php }?></span></span><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['MILESTONE_WIDGET_MODEL']->value->get('linkName');?>
" /></div><div class="widget_contents"></div></div></div><?php }?><?php if ($_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value){?><div class="summaryWidgetContainer"><div class="widgetContainer_tasks" data-url="<?php echo $_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span9"><div class="row-fluid"><span class="span4 margin0px"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span><span class="span7"><?php $_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL'] = new Smarty_variable(Vtiger_Module_Model::getInstance('ProjectTask'), null, 0);?><?php $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_variable($_smarty_tpl->tpl_vars['RELATED_MODULE_MODEL']->value->getField('projecttaskprogress'), null, 0);?><?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()), null, 0);?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><?php $_smarty_tpl->tpl_vars["SPECIAL_VALIDATOR"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator(), null, 0);?><select style="width: 160px;" class="chzn-select" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
" data-validation-engine="validate[<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory()==true){?> required,<?php }?>funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='<?php echo htmlspecialchars($_smarty_tpl->tpl_vars['FIELD_INFO']->value, ENT_QUOTES, 'UTF-8', true);?>
' <?php if (!empty($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value)){?>data-validator='<?php echo Zend_Json::encode($_smarty_tpl->tpl_vars['SPECIAL_VALIDATOR']->value);?>
'<?php }?> ><option><?php echo vtranslate('LBL_SELECT_PROGRESS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')==$_smarty_tpl->tpl_vars['PICKLIST_NAME']->value){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value;?>
</option><?php } ?></select></span></div></span><span class="span3"><?php if ($_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value->get('action')){?><button class="btn pull-right addButton" id="createProjectTask" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value->get('actionURL');?>
" data-parent-related-field="projectid"><strong><?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><?php }?></span><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['TASKS_WIDGET_MODEL']->value->get('linkName');?>
" /></div><div class="widget_contents"></div></div></div><?php }?><?php if ($_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value){?><div class="summaryWidgetContainer"><div class="widgetContainer_documents" data-url="<?php echo $_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span9"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span><span class="span3"><?php if ($_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value->get('action')){?><button class="btn pull-right addButton createRecord" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value->get('actionURL');?>
"><strong><?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><?php }?></span><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['DOCUMENT_WIDGET_MODEL']->value->get('linkName');?>
" /></div><div class="widget_contents"></div></div></div><?php }?><?php if ($_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value){?><div class="summaryWidgetContainer"><div class="widgetContainer_updates" data-url="<?php echo $_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value->getUrl();?>
" data-name="<?php echo $_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value->getLabel();?>
"><div class="widget_header row-fluid"><span class="span9"><h4><?php echo vtranslate($_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value->getLabel(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</h4></span><span class="span3"><?php if ($_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value->get('action')){?><button class="btn pull-right addButton createRecord" type="button" data-url="<?php echo $_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value->get('actionURL');?>
"><strong><?php echo vtranslate('LBL_ADD',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</strong></button><?php }?></span><input type="hidden" name="relatedModule" value="<?php echo $_smarty_tpl->tpl_vars['UPDATES_WIDGET_MODEL']->value->get('linkName');?>
" /></div><div class="widget_contents"></div></div></div><?php }?></div></div><?php }} ?>