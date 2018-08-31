<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:15
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/Index.tpl" */ ?>
<?php /*%%SmartyHeaderCode:501152955b7320a7afe337-34113021%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1b57c1048129a118ef4890327ab2137b5816ad89' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/Index.tpl',
      1 => 1517811362,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '501152955b7320a7afe337-34113021',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SELECTED_MODULE_NAME' => 0,
    'QUALIFIED_MODULE' => 0,
    'SELECTED_MODULE_MODEL' => 0,
    'VTDZINER_CURRENTVERSION' => 0,
    'VTDZINER_LATESTVERSION' => 0,
    'VTDZINER_UPGRADEABLE' => 0,
    'AVAILABLEMODULESLIST' => 0,
    'MODULE_MODEL' => 0,
    'MODULE_NAME' => 0,
    'SUPPORTED_MODULES' => 0,
    'MODULEMODEL' => 0,
    'IS_SORTABLE' => 0,
    'BLOCKS' => 0,
    'BLOCK_MODEL' => 0,
    'BLOCK_ID' => 0,
    'BLOCK_LABEL_KEY' => 0,
    'IS_BLOCK_SORTABLE' => 0,
    'FIELDS_LIST' => 0,
    'FIELD_MODEL' => 0,
    'IS_MANDATORY' => 0,
    'FIELD_INFO' => 0,
    'PICKLIST_VALUES' => 0,
    'PICKLIST_NAME' => 0,
    'PICKLIST_VALUE' => 0,
    'FIELD_VALUE_LIST' => 0,
    'USER_MODEL' => 0,
    'INVENTORY_TERMS_AND_CONDITIONS_MODEL' => 0,
    'IN_ACTIVE_FIELDS' => 0,
    'ALL_BLOCK_LABELS' => 0,
    'BLOCK_LABEL' => 0,
    'ADD_SUPPORTED_FIELD_TYPES' => 0,
    'FIELD_TYPE' => 0,
    'FIELD_TYPE_INFO' => 0,
    'TYPE_INFO' => 0,
    'TYPE_INFO_VALUE' => 0,
    'VTIGERTHEMES' => 0,
    'PANELTABS' => 0,
    'MODULEWIDGETS' => 0,
    'LANGUAGES' => 0,
    'LANGUAGESLIST' => 0,
    'LANGUAGECODES' => 0,
    'LANGUAGE' => 0,
    'MODULELANGUAGELABELS' => 0,
    'MODULELANGUAGEJSLABELS' => 0,
    'OTHERLANGUAGESLIST' => 0,
    'JSOTHERLANGUAGESLIST' => 0,
    'HOST_DIRECTORY_SEPERATOR' => 0,
    'RELATED_PARENTMODULES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a7e8843',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a7e8843')) {function content_5b7320a7e8843($_smarty_tpl) {?>
<div class="container-fluid" id="layoutEditorContainer"><input id="selectedModuleName" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
" /><div class="vtContents widget_header row-fluid"><div class="span6"><h3 style="display:inline"><?php echo vtranslate('vtDZiner',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<!--:: <span title="<?php echo vtranslate($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->label,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 is the External name for this module"><?php echo vtranslate($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->label,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span>&nbsp;[ <span title="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
 is the internal CRM name for module"><?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
</span> ]<span title="Click on the link to view and accept recent updates to vtDZiner. Installed version is <?php echo $_smarty_tpl->tpl_vars['VTDZINER_CURRENTVERSION']->value;?>
. Latest version is <?php echo $_smarty_tpl->tpl_vars['VTDZINER_LATESTVERSION']->value;?>
"><?php if ($_smarty_tpl->tpl_vars['VTDZINER_UPGRADEABLE']->value){?>&nbsp;<sup><a class="upgradevtDZiner">Updates</a></sup><?php }?></span></h3>--></div><!-- Feb 2 2018 :: Manasa Added the Following Code --><?php $_smarty_tpl->tpl_vars['AVAILABLEMODULESLIST'] = new Smarty_variable(Settings_ModuleManager_Module_Model::getAll(), null, 0);?><select class="select2 span3 hide" name="AvailableModules"><?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['MODULE_ID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['AVAILABLEMODULESLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['MODULE_ID']->value = $_smarty_tpl->tpl_vars['MODULE_MODEL']->key;
?><?php $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('name'), null, 0);?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" ><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</option><?php } ?></select><!-- Feb 2 2018 :: Manasa Added the Following Code Ended --><div class="span6"><div class="pull-right"><select class="select2 span3" name="layoutEditorModules"><?php  $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUPPORTED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_NAME']->key => $_smarty_tpl->tpl_vars['MODULE_NAME']->value){
$_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value==$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?></select>&nbsp;<button class="btn" style="margin-top: 0;" title="Test drive <?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
" onclick="window.open('index.php?module=<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
&view=List','_self')">&nbsp;<i class="icon-road alignMiddle"></i>&nbsp;</button></div></div></div><hr><?php $_smarty_tpl->tpl_vars['MODULEMODEL'] = new Smarty_variable(Vtiger_Module_Model::getInstance($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value), null, 0);?><div class="contents tabbable"><ul class="nav nav-tabs layoutTabs massEditTabs"><li class="jtab vtModuleTab active"><a data-toggle="tab" href="#vtModuleSettings"><i class="icon-th-large"></i>&nbsp;<strong><?php echo vtranslate('LBL_MODULE_OPTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><li class="jtab vtLayoutTab"><a data-toggle="tab" href="#detailViewLayout"><strong><?php echo vtranslate('LBL_DETAILVIEW_LAYOUT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><li class="jtab relatedListTab"><a data-toggle="tab" href="#relatedTabOrder"><i class="icon-random"></i>&nbsp;<strong><?php echo vtranslate('LBL_ARRANGE_RELATED_TABS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><!--li class="jtab vtDZinerTab"><a data-toggle="tab" href="#vtEventDZinerSettings"><i class="icon-binoculars"></i>&nbsp;<strong><?php echo vtranslate('LBL_EVENTDZINER_SETTINGS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li--><?php if ($_smarty_tpl->tpl_vars['MODULEMODEL']->value->isExportable()){?><li class="jtab vtDZinerTab"><a data-toggle="tab" href="#vtViewDZinerSettings"><i class="icon-binoculars"></i>&nbsp;<strong><?php echo vtranslate('LBL_VIEWDZINER_SETTINGS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><?php }?><li class="jtab vtDZinerTab"><a data-toggle="tab" href="#vtWidgetDZinerSettings"><strong><?php echo vtranslate('LBL_WIDGETDZINER_SETTINGS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><li class="jtab vtDZinerTab"><a data-toggle="tab" href="#vtLanguageDZinerSettings"><strong><?php echo vtranslate('LBL_LANGUAGEDZINER_SETTINGS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><li class="jtab vtDZinerTab"><a data-toggle="tab" href="#vtDZinerSettings"><i class="icon-cog"></i>&nbsp;<strong><?php echo vtranslate('LBL_VTDZINER_SETTINGS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li><!--li class="jtab vtDZinerTab"><a data-toggle="tab" href="#vtDZinerAbout"><i class="icon-bullhorn"></i>&nbsp;<strong><?php echo vtranslate('LBL_VTDZINER_ABOUT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></a></li--></ul><div class="tab-content layoutContent padding20 themeTableColor overflowVisible"><div class="tab-pane active" id="vtModuleSettings"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("vtModuleSettings.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="tab-pane" id="vtDZinerSettings"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("vtDZinerSettings.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="tab-pane" id="vtEventDZinerSettings"><h3>Coming Soon</h3></div><?php if ($_smarty_tpl->tpl_vars['MODULEMODEL']->value->isExportable()){?><div class="tab-pane" id="vtViewDZinerSettings"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("vtViewDZinerSettings.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><?php }?><div class="tab-pane" id="vtWidgetDZinerSettings"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("vtWidgetDZinerSettings.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><div class="tab-pane" id="vtLanguageDZinerSettings"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("vtLanguageDZinerSettings.tpl",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</div><!--div class="tab-pane" id="vtDZinerAbout"></div--><div class="tab-pane" id="detailViewLayout"><?php $_smarty_tpl->tpl_vars['FIELD_TYPE_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->getAddFieldTypeInfo(), null, 0);?><?php $_smarty_tpl->tpl_vars['IS_SORTABLE'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isSortableAllowed(), null, 0);?><?php $_smarty_tpl->tpl_vars['IS_BLOCK_SORTABLE'] = new Smarty_variable($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isBlockSortableAllowed(), null, 0);?><?php $_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS'] = new Smarty_variable(array(), null, 0);?><?php if ($_smarty_tpl->tpl_vars['IS_SORTABLE']->value){?><div class="btn-toolbar"><button class="btn addButton addCustomBlock" type="button"><i class="icon-plus"></i>&nbsp;<strong><?php echo vtranslate('LBL_ADD_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>&nbsp;<button class="btn addButton" type="button" onclick="window.open('index.php?parent=Settings&module=Picklist&view=Index&source_module=<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
','_self')"><i class="icon-list"></i>&nbsp;<strong><?php echo vtranslate('Edit Picklists',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>&nbsp;<span class="pull-right"><button class="btn btn-success saveFieldSequence hide" type="button"><strong><?php echo vtranslate('LBL_SAVE_FIELD_SEQUENCE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></span></div><?php }?><div id="moduleBlocks"><?php  $_smarty_tpl->tpl_vars['BLOCK_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['BLOCK_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['BLOCKS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_MODEL']->key => $_smarty_tpl->tpl_vars['BLOCK_MODEL']->value){
$_smarty_tpl->tpl_vars['BLOCK_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value = $_smarty_tpl->tpl_vars['BLOCK_MODEL']->key;
?><?php $_smarty_tpl->tpl_vars['FIELDS_LIST'] = new Smarty_variable($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->getLayoutBlockActiveFields(), null, 0);?><?php $_smarty_tpl->tpl_vars['BLOCK_ID'] = new Smarty_variable($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->get('id'), null, 0);?><?php $_smarty_tpl->createLocalArrayVariable('ALL_BLOCK_LABELS', null, 0);
$_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS']->value[$_smarty_tpl->tpl_vars['BLOCK_ID']->value] = $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value;?><div id="block_<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" class="editFieldsTable block_<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
 marginBottom10px border1px <?php if ($_smarty_tpl->tpl_vars['IS_BLOCK_SORTABLE']->value){?> blockSortable<?php }?>" data-block-id="<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" data-sequence="<?php echo $_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->get('sequence');?>
" style="border-radius: 4px 4px 0px 0px;background: white;"><div class="row-fluid layoutBlockHeader"><div class="blockLabel span5 padding10 marginLeftZero"><img class="alignMiddle" src="<?php echo vimage_path('drag.png');?>
" />&nbsp;&nbsp;<strong><?php echo vtranslate($_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</strong></div><div class="span6 marginLeftZero" style="float:right !important;"><div class="pull-right btn-toolbar blockActions" style="margin: 4px;"><?php if ($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->isAddCustomFieldEnabled()){?><div class="btn-group"><!--<button class="btn addCustomFields" type="button"><strong><?php echo vtranslate('LBL_ADD_CUSTOM_FIELDS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>--><button class="btn addCustomField" type="button"><strong><?php echo vtranslate('LBL_ADD_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div><?php }?><?php if ($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->isActionsAllowed()){?><div class="btn-group"><button class="btn dropdown-toggle" data-toggle="dropdown"><strong><?php echo vtranslate('LBL_ACTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>&nbsp;&nbsp;<i class="caret"></i></button><ul class="dropdown-menu pull-right"><li class="blockVisibility" data-visible="<?php if (!$_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->isHidden()){?>1<?php }else{ ?>0<?php }?>" data-block-id="<?php echo $_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->get('id');?>
"><a href="javascript:void(0)"><i class="icon-ok <?php if ($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->isHidden()){?> hide <?php }?>"></i>&nbsp;<?php echo vtranslate('LBL_ALWAYS_SHOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li><li class="inActiveFields"><a href="javascript:void(0)"><?php echo vtranslate('LBL_INACTIVE_FIELDS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li><?php if ($_smarty_tpl->tpl_vars['BLOCK_MODEL']->value->isCustomized()){?><li class="deleteCustomBlock"><a href="javascript:void(0)"><?php echo vtranslate('LBL_DELETE_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li><?php }?></ul></div><?php }?></div></div></div><div class="blockFieldsList <?php if ($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isFieldsSortableAllowed($_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value)){?>blockFieldsSortable <?php }?> row-fluid" style="padding:5px;min-height: 27px"><ul name="sortable1" class="connectedSortable span6" style="list-style-type: none; float: left;min-height: 1px;padding:2px;"><?php  $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['FIELDS_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fieldlist']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->key => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value){
$_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fieldlist']['index']++;
?><?php $_smarty_tpl->tpl_vars['FIELD_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo(), null, 0);?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['fieldlist']['index']%2==0){?><li><div class="opacity editFields marginLeftZero border1px" data-block-id="<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" data-field-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" data-sequence="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('sequence');?>
"><div class="row-fluid padding1per"><?php $_smarty_tpl->tpl_vars['IS_MANDATORY'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory(), null, 0);?><span class="span1">&nbsp;<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()){?><a><img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/></a><?php }?></span><div class="span11 marginLeftZero" style="word-wrap: break-word;"><span class="fieldLabel"><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
&nbsp;<?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?><span class="redColor">*</span><?php }?></span><span class="btn-group pull-right actions"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()){?><a href="javascript:void(0)" class="dropdown-toggle editFieldDetails" data-toggle="dropdown"><i class="icon-pencil alignMiddle" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a><div class="basicFieldOperations pull-right hide" style="width : 250px;"><form class="form-horizontal fieldDetailsForm" method="POST"><div class="modal-header contentsBackground"><strong><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</strong><div class="pull-right"><a href="javascript:void(0)" class='cancel'>X</a></div></div><div style="padding-bottom: 5px;"><span><input type="hidden" name="mandatory" value="O" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="mandatory" <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatoryOptionDisabled()){?> readonly="readonly" <?php }?> value="M" />&nbsp;<?php echo vtranslate('LBL_MANDATORY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="presence" value="1" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="presence" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isViewable()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isActiveOptionDisabled()){?> readonly="readonly" class="optionDisabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?> readonly="readonly" <?php }?> value="2" />&nbsp;<?php echo vtranslate('LBL_ACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="quickcreate" value="1" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="quickcreate" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isQuickCreateEnabled()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isQuickCreateOptionDisabled()){?> readonly="readonly" class="optionDisabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?> readonly="readonly" <?php }?> value="2" />&nbsp;<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="summaryfield" value="0"/><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="summaryfield" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isSummaryField()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isSummaryFieldOptionDisabled()){?> readonly="readonly" class="optionDisabled"<?php }?> value="1" />&nbsp;<?php echo vtranslate('LBL_SUMMARY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="masseditable" value="2" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="masseditable" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMassEditable()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMassEditOptionDisabled()){?> readonly="readonly" <?php }?> value="1" />&nbsp;<?php echo vtranslate('LBL_MASS_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="defaultvalue" value="" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="defaultvalue" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isDefaultValueOptionDisabled()){?> readonly="readonly" <?php }?> value="" />&nbsp;<?php echo vtranslate('LBL_DEFAULT_VALUE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="padding1per defaultValueUi <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> zeroOpacity <?php }?>" style="padding : 0px 10px 0px 25px;"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isDefaultValueOptionDisabled()!="true"){?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="picklist"){?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><select class="span2" name="fieldDefaultValue" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?> data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value));?>
'><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value);?>
" <?php if (decode_html($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'))==$_smarty_tpl->tpl_vars['PICKLIST_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option><?php } ?></select><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="multipicklist"){?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><?php $_smarty_tpl->tpl_vars["FIELD_VALUE_LIST"] = new Smarty_variable(explode(' |##| ',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue')), null, 0);?><select multiple class="span2" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  name="fieldDefaultValue" data-fieldinfo='<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value));?>
'><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value);?>
" <?php if (in_array(Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value),$_smarty_tpl->tpl_vars['FIELD_VALUE_LIST']->value)){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option><?php } ?></select><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="boolean"){?><input type="hidden" name="fieldDefaultValue" value="" /><input type="checkbox" name="fieldDefaultValue" value="1"<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue')==1){?> checked <?php }?> data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' /><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="time"){?><div class="input-append time"><input type="text" class="input-small" data-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('hour_format');?>
" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?> data-toregister="time" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" name="fieldDefaultValue" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'/><span class="add-on cursorPointer"><i class="icon-time"></i></span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="date"){?><div class="input-append date"><?php $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'), null, 0);?><input type="text" class="input-medium" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?> name="fieldDefaultValue" data-toregister="date" data-date-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format');?>
" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'));?>
" /><span class="add-on"><i class="icon-calendar"></i></span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="percentage"){?><div class="input-append"><input type="number" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  class="input-medium" name="fieldDefaultValue"value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' step="any" /><span class="add-on">%</span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="currency"){?><div class="input-prepend"><span class="add-on"><?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_symbol');?>
</span><input type="text" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  class="input-medium" name="fieldDefaultValue"data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'));?>
"data-decimal-seperator='<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_decimal_separator');?>
' data-group-seperator='<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_grouping_separator');?>
' /></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName()=="terms_conditions"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')==19){?><?php $_smarty_tpl->tpl_vars['INVENTORY_TERMS_AND_CONDITIONS_MODEL'] = new Smarty_variable(Settings_Vtiger_MenuItem_Model::getInstance("INVENTORYTERMSANDCONDITIONS"), null, 0);?><a href="<?php echo $_smarty_tpl->tpl_vars['INVENTORY_TERMS_AND_CONDITIONS_MODEL']->value->getUrl();?>
" target="_blank"><?php echo vtranslate('LBL_CLICK_HERE_TO_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a><?php }else{ ?><input type="text" class="input-medium" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  name="fieldDefaultValue" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'/><?php }?><?php }?></div></span></div><div class="modal-footer" style="padding: 0px;"><span class="pull-right"><div class="pull-right"><a href="javascript:void(0)" style="margin: 5px;color:#AA3434;margin-top:10px;" class='cancel'><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div><button class="btn btn-success saveFieldDetails" data-field-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" type="submit" style="margin: 5px;"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></span></div></form></div><?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isCustomField()=='true'){?><a href="javascript:void(0)" class="deleteCustomField" data-field-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
"><i class="icon-trash alignMiddle" title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a><?php }?></span></div></div></div></li><?php }?><?php } ?></ul><ul <?php if ($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->isFieldsSortableAllowed($_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value)){?>name="sortable2"<?php }?> class="connectedSortable span6" style="list-style-type: none; margin: 0; float: left;min-height: 1px;padding:2px;"><?php  $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['FIELDS_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fieldlist1']['index']=-1;
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->key => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value){
$_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['smarty']->value['foreach']['fieldlist1']['index']++;
?><?php $_smarty_tpl->tpl_vars['FIELD_INFO'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo(), null, 0);?><?php if ($_smarty_tpl->getVariable('smarty')->value['foreach']['fieldlist1']['index']%2!=0){?><li><div class="opacity editFields marginLeftZero border1px" data-block-id="<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" data-field-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" data-sequence="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('sequence');?>
"><div class="row-fluid padding1per"><?php $_smarty_tpl->tpl_vars['IS_MANDATORY'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatory(), null, 0);?><span class="span1">&nbsp;<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()){?><a><img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/></a><?php }?></span><div class="span11 marginLeftZero" style="word-wrap: break-word;"><span class="fieldLabel"><?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?><span class="redColor">*</span><?php }?><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
&nbsp;</span><span class="btn-group pull-right actions"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()){?><a href="javascript:void(0)" class="dropdown-toggle editFieldDetails" data-toggle="dropdown"><i class="icon-pencil alignMiddle" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a><div class="basicFieldOperations pull-right hide" style="width : 250px;"><form class="form-horizontal fieldDetailsForm" method="POST"><div class="modal-header contentsBackground"><strong><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</strong><div class="pull-right"><a href="javascript:void(0)" class="cancel">X</a></div></div><div style="padding-bottom: 5px;"><span><input type="hidden" name="mandatory" value="O" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="mandatory" <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMandatoryOptionDisabled()){?> readonly="readonly" <?php }?> value="M" />&nbsp;<?php echo vtranslate('LBL_MANDATORY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="presence" value="1" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="presence" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isViewable()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isActiveOptionDisabled()){?> readonly="readonly" class="optionDisabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?> readonly="readonly" <?php }?> value="2" />&nbsp;<?php echo vtranslate('LBL_ACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="quickcreate" value="1" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="quickcreate" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isQuickCreateEnabled()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isQuickCreateOptionDisabled()){?> readonly="readonly" class="optionDisabled"<?php }?> <?php if ($_smarty_tpl->tpl_vars['IS_MANDATORY']->value){?> readonly="readonly" <?php }?> value="2" />&nbsp;<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="summaryfield" value="0"/><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="summaryfield" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isSummaryField()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isSummaryFieldOptionDisabled()){?> readonly="readonly" class="optionDisabled"<?php }?> value="1" />&nbsp;<?php echo vtranslate('LBL_SUMMARY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="masseditable" value="2" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="masseditable" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMassEditable()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isMassEditOptionDisabled()){?> readonly="readonly" <?php }?> value="1" />&nbsp;<?php echo vtranslate('LBL_MASS_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="defaultvalue" value="" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="defaultvalue" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> checked <?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isDefaultValueOptionDisabled()){?> readonly="readonly" <?php }?> value="" />&nbsp;<?php echo vtranslate('LBL_DEFAULT_VALUE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="padding1per defaultValueUi <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> zeroOpacity <?php }?>" style="padding : 0px 10px 0px 25px;"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isDefaultValueOptionDisabled()!="true"){?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="picklist"){?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><select class="span2" name="fieldDefaultValue" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?> data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-fieldinfo='<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value));?>
'><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['PICKLIST_NAME']->value = $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_NAME']->value);?>
" <?php if (decode_html($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'))==$_smarty_tpl->tpl_vars['PICKLIST_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option><?php } ?></select><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="multipicklist"){?><?php $_smarty_tpl->tpl_vars['PICKLIST_VALUES'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getPicklistValues(), null, 0);?><?php $_smarty_tpl->tpl_vars["FIELD_VALUE_LIST"] = new Smarty_variable(explode(' |##| ',$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue')), null, 0);?><select multiple class="span2" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  name="fieldDefaultValue" data-fieldinfo='<?php echo Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value));?>
'><?php  $_smarty_tpl->tpl_vars['PICKLIST_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PICKLIST_VALUES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->key => $_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value){
$_smarty_tpl->tpl_vars['PICKLIST_VALUE']->_loop = true;
?><option value="<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value);?>
" <?php if (in_array(Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value),$_smarty_tpl->tpl_vars['FIELD_VALUE_LIST']->value)){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['PICKLIST_VALUE']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option><?php } ?></select><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="boolean"){?><input type="hidden" name="fieldDefaultValue" value="" /><input type="checkbox" name="fieldDefaultValue" value="1"<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue')==1){?> checked <?php }?> data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' /><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="time"){?><div class="input-append time"><input type="text" class="input-small" data-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('hour_format');?>
" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?> data-toregister="time" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" name="fieldDefaultValue" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'/><span class="add-on cursorPointer"><i class="icon-time"></i></span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="date"){?><div class="input-append date"><?php $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'), null, 0);?><input type="text" class="input-medium" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?> name="fieldDefaultValue" data-toregister="date" data-date-format="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format');?>
" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'));?>
" /><span class="add-on"><i class="icon-calendar"></i></span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="percentage"){?><div class="input-append"><input type="number" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  class="input-medium" name="fieldDefaultValue"value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' step="any" /><span class="add-on">%</span></div><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=="currency"){?><div class="input-prepend"><span class="add-on"><?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_symbol');?>
</span><input type="text" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  class="input-medium" name="fieldDefaultValue"data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
' value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getEditViewDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue'));?>
"data-decimal-seperator='<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_decimal_separator');?>
' data-group-seperator='<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('currency_grouping_separator');?>
' /></div><?php }else{ ?><input type="text" class="input-medium" data-validation-engine="validate[required,funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" <?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->hasDefaultValue()){?> disabled="" <?php }?>  name="fieldDefaultValue" value="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('defaultvalue');?>
" data-fieldinfo='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['FIELD_INFO']->value);?>
'/><?php }?><?php }?></div></span></div><div class="modal-footer" style="padding: 0px;"><span class="pull-right"><div class="pull-right"><a href="javascript:void(0)" style="margin: 5px;color:#AA3434;margin-top:10px;" class="cancel"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div><button class="btn btn-success saveFieldDetails" data-field-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
" type="submit" style="margin: 5px;"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></span></div></form></div><?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isCustomField()=='true'){?><a href="javascript:void(0)" class="deleteCustomField" data-field-id="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('id');?>
"><i class="icon-trash alignMiddle" title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a><?php }?></span></div></div></div></li><?php }?><?php } ?></ul></div></div><?php } ?></div><input type="hidden" class="inActiveFieldsArray" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['IN_ACTIVE_FIELDS']->value);?>
' /><div class="newCustomBlockCopy hide marginBottom10px border1px <?php if ($_smarty_tpl->tpl_vars['IS_BLOCK_SORTABLE']->value){?>blockSortable <?php }?>" data-block-id="" data-sequence="" style="border-radius: 4px;"><div class="row-fluid layoutBlockHeader"><div class="span6 blockLabel padding10"><img class="alignMiddle" src="<?php echo vimage_path('drag.png');?>
" />&nbsp;&nbsp;</div><div class="span6 marginLeftZero"><div class="pull-right btn-toolbar blockActions" style="margin: 4px;"><div class="btn-group"><button class="btn addCustomField hide" type="button"><strong><?php echo vtranslate('LBL_ADD_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div><div class="btn-group"><button class="btn dropdown-toggle" data-toggle="dropdown"><strong><?php echo vtranslate('LBL_ACTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>&nbsp;&nbsp;<i class="caret"></i></button><ul class="dropdown-menu pull-right"><li class="blockVisibility" data-visible="1" data-block-id=""><a href="javascript:void(0)"><i class="icon-ok"></i>&nbsp;<?php echo vtranslate('LBL_ALWAYS_SHOW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li><li class="inActiveFields"><a href="javascript:void(0)"><?php echo vtranslate('LBL_INACTIVE_FIELDS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li><li class="deleteCustomBlock"><a href="javascript:void(0)"><?php echo vtranslate('LBL_DELETE_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></li></ul></div></div></div></div><div class="blockFieldsList row-fluid blockFieldsSortable" style="padding:5px;min-height: 27px"><ul class="connectedSortable span6 ui-sortable" style="list-style-type: none; float: left;min-height:1px;padding:2px;" name="sortable1"></ul><ul class="connectedSortable span6 ui-sortable" style="list-style-type: none; margin: 0;float: left;min-height:1px;padding:2px;" name="sortable2"></ul></div></div><li class="newCustomFieldCopy hide"><div class="marginLeftZero border1px" data-field-id="" data-sequence=""><div class="row-fluid padding1per"><span class="span1">&nbsp;<?php if ($_smarty_tpl->tpl_vars['IS_SORTABLE']->value){?><a><img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"/></a><?php }?></span><div class="span11 marginLeftZero" style="word-wrap: break-word;"><span class="fieldLabel"></span><span class="btn-group pull-right actions"><?php if ($_smarty_tpl->tpl_vars['IS_SORTABLE']->value){?><a href="javascript:void(0)" class="dropdown-toggle editFieldDetails" data-toggle="dropdown"><i class="icon-pencil alignMiddle" title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a><div class="basicFieldOperations hide pull-right" style="width: 250px;"><form class="form-horizontal fieldDetailsForm" method="POST"><div class="modal-header contentsBackground"></div><div style="padding-bottom: 5px;"><span><input type="hidden" name="mandatory" value="O" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="mandatory" value="M" />&nbsp;<?php echo vtranslate('LBL_MANDATORY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="presence" value="1" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="presence" value="2" />&nbsp;<?php echo vtranslate('LBL_ACTIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="quickcreate" value="1" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="quickcreate" value="2" />&nbsp;<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="summaryfield" value="0"/><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="summaryfield" value="1" />&nbsp;<?php echo vtranslate('LBL_SUMMARY_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="masseditable" value="2" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="masseditable" value="1" />&nbsp;<?php echo vtranslate('LBL_MASS_EDIT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></span><span><input type="hidden" name="defaultvalue" value="" /><label class="checkbox" style="padding-left: 25px; padding-top: 5px;"><input type="checkbox" name="defaultvalue" value="" />&nbsp;<?php echo vtranslate('LBL_DEFAULT_VALUE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label><div class="padding1per defaultValueUi" style="padding : 0px 10px 0px 25px;"></div></span></div><div class="modal-footer"><span class="pull-right"><div class="pull-right"><a href="javascript:void(0)" style="margin-top: 5px;margin-left: 10px;color:#AA3434;" class='cancel'><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div><button class="btn btn-success saveFieldDetails" data-field-id="" type="submit"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></span></div></form></div><?php }?><a href="javascript:void(0)" class="deleteCustomField" data-field-id=""><i class="icon-trash alignMiddle" title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i></a></span></div></div></div></li><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModuleSettingsmodals.tpl','Settings::vtDZiner'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('NewModule.tpl','Settings::vtDZiner'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('NewMenuCategory.tpl','Settings::vtDZiner'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<div class="modal addBlockModal hide"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3><?php echo vtranslate('LBL_ADD_CUSTOM_BLOCK',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><form class="form-horizontal addCustomBlockForm" method="POST"><div class="modal-body"><div class="control-group"><span class="control-label"><span class="redColor">*</span><span><?php echo vtranslate('LBL_BLOCK_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></span><div class="controls"><input type="text" name="label" class="span3" data-validation-engine="validate[required]" /></div></div><div class="control-group"><span class="control-label"><?php echo vtranslate('LBL_ADD_AFTER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><div class="controls"><span class="row-fluid"><select class="span8" name="beforeBlockId"><?php  $_smarty_tpl->tpl_vars['BLOCK_LABEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['BLOCK_LABEL']->_loop = false;
 $_smarty_tpl->tpl_vars['BLOCK_ID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['BLOCK_LABEL']->key => $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value){
$_smarty_tpl->tpl_vars['BLOCK_LABEL']->_loop = true;
 $_smarty_tpl->tpl_vars['BLOCK_ID']->value = $_smarty_tpl->tpl_vars['BLOCK_LABEL']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['BLOCK_ID']->value;?>
" data-label="<?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL']->value;?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['BLOCK_LABEL']->value,$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value);?>
</option><?php } ?></select></span></div></div><div class="control-group"><span class="control-label"><strong><?php echo vtranslate('LBL_CUSTOM_BLOCK_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></span><div class="controls"><span class="row-fluid"><select class="span8" name="blockType"><option title = "Vanilla Vtiger Block of Data fields" value="Standard" data-label="Standard">Standard</option><!--option title = "Enables Comments block access from right side panel" value="Comments" data-label="Comments">Comments</option><!--<option value="Related" data-label="Related">Related</option><option value="Subpanels" data-label="Subpanels">Subpanels</option><option value="Pickblock" data-label="Pickblock">Pickblock</option><option value="Address" data-label=""></option><option value="Grid" data-label=""></option>--></select></span></div></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div><div class="modal createFieldModal hide"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3><?php echo vtranslate('LBL_CREATE_CUSTOM_FIELD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><form class="form-horizontal createCustomFieldForm" method="POST"><div class="modal-body"><div class="control-group"><span class="control-label"><?php echo vtranslate('LBL_SELECT_FIELD_TYPE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><div class="controls"><span class="row-fluid"><select class="fieldTypesList span7" name="fieldType"><?php  $_smarty_tpl->tpl_vars['FIELD_TYPE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_TYPE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ADD_SUPPORTED_FIELD_TYPES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_TYPE']->key => $_smarty_tpl->tpl_vars['FIELD_TYPE']->value){
$_smarty_tpl->tpl_vars['FIELD_TYPE']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['FIELD_TYPE']->value;?>
"<?php  $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->_loop = false;
 $_smarty_tpl->tpl_vars['TYPE_INFO'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_TYPE_INFO']->value[$_smarty_tpl->tpl_vars['FIELD_TYPE']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->key => $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->value){
$_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->_loop = true;
 $_smarty_tpl->tpl_vars['TYPE_INFO']->value = $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->key;
?>data-<?php echo $_smarty_tpl->tpl_vars['TYPE_INFO']->value;?>
="<?php echo $_smarty_tpl->tpl_vars['TYPE_INFO_VALUE']->value;?>
"<?php } ?>><?php echo vtranslate($_smarty_tpl->tpl_vars['FIELD_TYPE']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?></select></span></div></div><div class="control-group supportedType relatedtoOption hide"><span class="control-label"><strong><?php echo vtranslate('LBL_RELATED_MODULE_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></span><div class="controls"><span class="row-fluid"><select class="relatedModulesList span6" name="relatedModule"><?php  $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUPPORTED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_NAME']->key => $_smarty_tpl->tpl_vars['MODULE_NAME']->value){
$_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value==$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?></select></span></div></div><div class="control-group"><span class="control-label"><span class="redColor">*</span>&nbsp;<?php echo vtranslate('LBL_LABEL_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><div class="controls"><input type="text" maxlength="50" name="fieldLabel" value="" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]"data-validator=<?php echo Zend_Json::encode(array(array('name'=>'FieldLabel')));?>
 /></div></div><div class="control-group supportedType lengthsupported"><span class="control-label"><span class="redColor">*</span>&nbsp;<?php echo vtranslate('LBL_LENGTH',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><div class="controls"><input type="text" name="fieldLength" value="" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" /></div></div><div class="control-group supportedType decimalsupported hide"><span class="control-label"><span class="redColor">*</span>&nbsp;<?php echo vtranslate('LBL_DECIMALS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><div class="controls"><input type="text" name="decimal" value="" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" /></div></div><div class="control-group supportedType preDefinedValueExists hide"><span class="control-label"><span class="redColor">*</span>&nbsp;<?php echo vtranslate('LBL_PICKLIST_VALUES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span><div class="controls"><div class="row-fluid"><input type="hidden" id="picklistUi" class="span7 select2" name="pickListValues"placeholder="<?php echo vtranslate('LBL_ENTER_PICKLIST_VALUES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-validation-engine="validate[required, funcCall[Vtiger_Base_Validator_Js.invokeValidation]]" data-validator=<?php echo Zend_Json::encode(array(array('name'=>'PicklistFieldValues')));?>
 /></div></div></div><div class="control-group supportedType picklistOption hide"><span class="control-label">&nbsp;</span><div class="controls"><label class="checkbox span3" style="margin-left: 0px;"><input type="checkbox" class="checkbox" name="isRoleBasedPickList" value="1" >&nbsp;<?php echo vtranslate('LBL_ROLE_BASED_PICKLIST',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label></div></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
</form></div><div class="modal inactiveFieldsModal hide"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button><h3><?php echo vtranslate('LBL_INACTIVE_FIELDS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3></div><form class="form-horizontal inactiveFieldsForm" method="POST"><div class="modal-body"><div class="row-fluid inActiveList"></div></div><div class="modal-footer"><div class=" pull-right cancelLinkContainer"><a class="cancelLink" type="reset" data-dismiss="modal"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></div><button class="btn btn-success" type="submit" name="reactivateButton"><strong><?php echo vtranslate('LBL_REACTIVATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button></div></form></div></div><div class="tab-pane" id="relatedTabOrder"></div></div></div></div>
<script>
	var blocksList = <?php echo json_encode($_smarty_tpl->tpl_vars['ALL_BLOCK_LABELS']->value);?>
;
	var themesList = <?php echo json_encode($_smarty_tpl->tpl_vars['VTIGERTHEMES']->value);?>
;
	var tabid = <?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->id;?>
;
	var sourceModule = "<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
";
	var path = "";
	var mypath = [];
	var plparams ={};
	var pickBlock = {};			// will hold the array of blockids assigned as pickblock for each picklist item
	var vtDZ_pickBlocks = {};	// will hold the array of blockids that have been chosed as pickblocks for the picklist 
	var plFieldId = {};			// will hold the fieldid of the picklist field
	var plFieldName = {};		// will hold the fieldid of the picklist field
	var plFieldBlockId = {};	// will hold the blockid of the picklist field, used to prevent selection as pickblock
	var plFieldLabel2Name = {}; // will hold the field label as value of the picklist field, used to preload
	var panelsList = <?php echo json_encode($_smarty_tpl->tpl_vars['PANELTABS']->value);?>
;
	if (panelsList.length == 0) panelsList = {};
	var widgetObject = <?php echo json_encode($_smarty_tpl->tpl_vars['MODULEWIDGETS']->value);?>
; 
	languagesList=[];
	crmLanguages = <?php echo json_encode($_smarty_tpl->tpl_vars['LANGUAGES']->value);?>
;
	alllanguagesList = <?php echo json_encode($_smarty_tpl->tpl_vars['LANGUAGESLIST']->value);?>
;			// global
	worldLanguages  = <?php echo json_encode($_smarty_tpl->tpl_vars['LANGUAGECODES']->value);?>
;				// Not used
	currentLanguage = "<?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>
";
	langlabelsobject ="";										// Re used, conside local scope
	bulkLabels ="";												// Re used, conside local scope
	jsbulkLabels ="";											// Re used, conside local scope
	langLabels_Smarty = <?php echo json_encode($_smarty_tpl->tpl_vars['MODULELANGUAGELABELS']->value);?>
;
	jslangLabels_Smarty = <?php echo json_encode($_smarty_tpl->tpl_vars['MODULELANGUAGEJSLABELS']->value);?>
;
	otherlangLabels_Smarty = <?php echo json_encode($_smarty_tpl->tpl_vars['OTHERLANGUAGESLIST']->value);?>
;
	jsotherlangLabels_Smarty = <?php echo json_encode($_smarty_tpl->tpl_vars['JSOTHERLANGUAGESLIST']->value);?>
;
	// TODO Get rid of this messy handling in splitting path names
	directory_separator = "<?php echo $_smarty_tpl->tpl_vars['HOST_DIRECTORY_SEPERATOR']->value;?>
";
	var vtDZParentRelations = []; 
	var moduleLanguagesList;
	var widgetTypesList = [
		["DETAILVIEW","Place a button in the Detail View header","index.php?module=Reports&view=Detail&record=12"],
		["DETAILVIEWBASIC","Adds a hyperlink in Actions button, in Detail View mode only, ( eg Import)","index.php?module=gas&view=Import<br/> index.php?module=Documents&action=EditView&return_module=$MODULE$&return_action=DetailView&return_id=$RECORD$&parent_id=$RECORD$ <br/> index.php?module=gas&view=Export&selected_ids=[$RECORD$]"],
		["DASHBOARDWIDGET","Place a widget in the Dashboard Add Widget button dropdown","index.php?module=modulename&view=ShowWidget&name=History -- History of records"],
		["DETAILVIEWSETTING","Adds a hyperlink in Settings dropdown in Detail View mode only, ( eg Import)","index.php?module=MenuEditor&parent=Settings&view=Index -- Menu Editor<br/> index.php?module=MenuEditor&parent=Settings&view=Index&block=2&fieldid=11 -- Users List"],
		
		["DETAILVIEWSIDEBARLINK","Place a hyperlink in the Sidebar, in Detail View mode only","index.php?module=Contacts&view=List"],
		["DETAILVIEWSIDEBARWIDGET","Place a action window in the Sidebar, in Detail View mode only","module=Products&view=List&viewname=52"],
		["DETAILVIEWTAB","Adds items to right side bar in Detail View (eg Record Summary)","index.php?module=Products&view=List&viewname=52<br/>index.php?module=modulename&view=ShowWidget&name=History"],
		["DETAILVIEWWIDGET","Adds a Block to Detail view with Custom Actions, like Comments block","module=Products&view=List&viewname=52"],
		
		["HEADERCSS","Preloads the specified source CSS in CRM","Write your own for css menu modification and upload into crm and give proper path suppose <b>layouts\vlayout\skins\firebrick\style.css</b>"],
		["HEADERLINK","Place a link in the CRM Header Area, to the right of the default links",'Please Specify proper url'],
		["HEADERSCRIPT","Preloads the specified source javascript in CRM","Add your javascript code with disturbing header.tpl add new js, External js also it is accepting.Inside crm js means give proper path."],
		["LISTVIEW","Adds a hyperlink in Actions button, in List View mode only, ( eg Import)"," http://www.google.com, Internal CRM paths"],
		["LISTVIEWBASIC","Place a button in the List View header"," http://www.google.com, Internal CRM paths or custom functionalty on popup like add folder in documents module"],
		["LISTVIEWMASSACTION ","Add a Mass Action link in Actions drop down, to be operated on all selected records","Please write your own functionality to do something or give inside crm paths index.php?module=Documents&view=List"],
		["LISTVIEWSETTING","Adds a hyperlink in Settings dropdown in List View mode only, ( eg Import)","module=Users&parent=Settings&view=List"],
		["LISTVIEWSIDEBARLINK","Place a hyperlink in the Sidebar, in List View mode only","module=Users&parent=Settings&view=List"],
		["LISTVIEWSIDEBARWIDGET","Place a action window in the Sidebar, in List View mode only","module=Users&parent=Settings&view=List"],
		["SIDEBARLINK","Place a hyperlink in the Sidebar, irrespective of View mode","index.php?module=Contacts&view=List"],
		["SIDEBARWIDGET","Place a action window in the Sidebar, irrespective of View mode","module=Products&view=List&viewname=52"]
	];

	// http://www.geocities.ws/xpf51/HTMLREF/HEX_CODES.html
		colornames={};
		colornames['#CD5C5C'] = 'indianred';
		colornames['#F08080'] = 'lightcoral';
		colornames['#FA8072'] = 'salmon';
		colornames['#E9967A'] = 'darksalmon';
		colornames['#FFA07A'] = 'lightsalmon';
		colornames['#DC143C'] = 'crimson';
		colornames['#FF0000'] = 'red';
		colornames['#B22222'] = 'firebrick';
		colornames['#8B0000'] = 'darkred';
		colornames['#FFC0CB'] = 'pink';
		colornames['#FFB6C1'] = 'lightpink';
		colornames['#FF69B4'] = 'hotpink';
		colornames['#FF1493'] = 'deeppink';
		colornames['#C71585'] = 'mediumvioletred';
		colornames['#DB7093'] = 'palevioletred';
		colornames['#FFA07A'] = 'lightsalmon';
		colornames['#FF7F50'] = 'coral';
		colornames['#FF6347'] = 'tomato';
		colornames['#FF4500'] = 'orangered';
		colornames['#FF8C00'] = 'darkorange';
		colornames['#FFA500'] = 'orange';
		colornames['#FFD700'] = 'gold';
		colornames['#FFFF00'] = 'yellow';
		colornames['#FFFFE0'] = 'lightyellow';
		colornames['#FFFACD'] = 'lemonchiffon';
		colornames['#FAFAD2'] = 'lightgoldenrodyellow';
		colornames['#FFEFD5'] = 'papayawhip';
		colornames['#FFE4B5'] = 'moccasin';
		colornames['#FFDAB9'] = 'peachpuff';
		colornames['#EEE8AA'] = 'palegoldenrod';
		colornames['#F0E68C'] = 'khaki';
		colornames['#BDB76B'] = 'darkkhaki';
		colornames['#E6E6FA'] = 'lavender';
		colornames['#D8BFD8'] = 'thistle';
		colornames['#DDA0DD'] = 'plum';
		colornames['#EE82EE'] = 'violet';
		colornames['#DA70D6'] = 'orchid';
		colornames['#FF00FF'] = 'fuchsia';
		colornames['#FF00FF'] = 'magenta';
		colornames['#BA55D3'] = 'mediumorchid';
		colornames['#9370DB'] = 'mediumpurple';
		colornames['#8A2BE2'] = 'blueviolet';
		colornames['#9400D3'] = 'darkviolet';
		colornames['#9932CC'] = 'darkorchid';
		colornames['#8B008B'] = 'darkmagenta';
		colornames['#800080'] = 'purple';
		colornames['#4B0082'] = 'indigo';
		colornames['#6A5ACD'] = 'slateblue';
		colornames['#483D8B'] = 'darkslateblue';
		colornames['#7B68EE'] = 'mediumslateblue';
		colornames['#ADFF2F'] = 'greenyellow';
		colornames['#7FFF00'] = 'chartreuse';
		colornames['#7CFC00'] = 'lawngreen';
		colornames['#00FF00'] = 'lime';
		colornames['#32CD32'] = 'limegreen';
		colornames['#98FB98'] = 'palegreen';
		colornames['#90EE90'] = 'lightgreen';
		colornames['#00FA9A'] = 'mediumspringgreen';
		colornames['#00FF7F'] = 'springgreen';
		colornames['#3CB371'] = 'mediumseagreen';
		colornames['#2E8B57'] = 'seagreen';
		colornames['#228B22'] = 'forestgreen';
		colornames['#008000'] = 'green';
		colornames['#006400'] = 'darkgreen';
		colornames['#9ACD32'] = 'yellowgreen';
		colornames['#6B8E23'] = 'olivedrab';
		colornames['#808000'] = 'olive';
		colornames['#556B2F'] = 'darkolivegreen';
		colornames['#66CDAA'] = 'mediumaquamarine';
		colornames['#8FBC8F'] = 'darkseagreen';
		colornames['#20B2AA'] = 'lightseagreen';
		colornames['#008B8B'] = 'darkcyan';
		colornames['#008080'] = 'teal';
		colornames['#00FFFF'] = 'aqua';
		colornames['#00FFFF'] = 'cyan';
		colornames['#E0FFFF'] = 'lightcyan';
		colornames['#AFEEEE'] = 'paleturquoise';
		colornames['#7FFFD4'] = 'aquamarine';
		colornames['#40E0D0'] = 'turquoise';
		colornames['#48D1CC'] = 'mediumturquoise';
		colornames['#00CED1'] = 'darkturquoise';
		colornames['#5F9EA0'] = 'cadetblue';
		colornames['#4682B4'] = 'steelblue';
		colornames['#B0C4DE'] = 'lightsteelblue';
		colornames['#B0E0E6'] = 'powderblue';
		colornames['#ADD8E6'] = 'lightblue';
		colornames['#87CEEB'] = 'skyblue';
		colornames['#87CEFA'] = 'lightskyblue';
		colornames['#00BFFF'] = 'deepskyblue';
		colornames['#1E90FF'] = 'dodgerblue';
		colornames['#6495ED'] = 'cornflowerblue';
		colornames['#7B68EE'] = 'mediumslateblue';
		colornames['#4169E1'] = 'royalblue';
		colornames['#0000FF'] = 'blue';
		colornames['#0000CD'] = 'mediumblue';
		colornames['#00008B'] = 'darkblue';
		colornames['#000080'] = 'navy';
		colornames['#191970'] = 'midnightblue';
		colornames['#FFF8DC'] = 'cornsilk';
		colornames['#FFEBCD'] = 'blanchedalmond';
		colornames['#FFE4C4'] = 'bisque';
		colornames['#FFDEAD'] = 'navajowhite';
		colornames['#F5DEB3'] = 'wheat';
		colornames['#DEB887'] = 'burlywood';
		colornames['#D2B48C'] = 'tan';
		colornames['#BC8F8F'] = 'rosybrown';
		colornames['#F4A460'] = 'sandybrown';
		colornames['#DAA520'] = 'goldenrod';
		colornames['#B8860B'] = 'darkgoldenrod';
		colornames['#CD853F'] = 'peru';
		colornames['#D2691E'] = 'chocolate';
		colornames['#8B4513'] = 'saddlebrown';
		colornames['#A0522D'] = 'sienna';
		colornames['#A52A2A'] = 'brown';
		colornames['#800000'] = 'maroon';
		colornames['#FFFFFF'] = 'white';
		colornames['#FFFAFA'] = 'snow';
		colornames['#F0FFF0'] = 'honeydew';
		colornames['#F5FFFA'] = 'mintcream';
		colornames['#F0FFFF'] = 'azure';
		colornames['#F0F8FF'] = 'aliceblue';
		colornames['#F8F8FF'] = 'ghostwhite';
		colornames['#F5F5F5'] = 'whitesmoke';
		colornames['#FFF5EE'] = 'seashell';
		colornames['#F5F5DC'] = 'beige';
		colornames['#FDF5E6'] = 'oldlace';
		colornames['#FFFAF0'] = 'floralwhite';
		colornames['#FFFFF0'] = 'ivory';
		colornames['#FAEBD7'] = 'antiquewhite';
		colornames['#FAF0E6'] = 'linen';
		colornames['#FFF0F5'] = 'lavenderblush';
		colornames['#FFE4E1'] = 'mistyrose';
		colornames['#DCDCDC'] = 'gainsboro';
		colornames['#D3D3D3'] = 'lightgrey';
		colornames['#C0C0C0'] = 'silver';
		colornames['#A9A9A9'] = 'darkgray';
		colornames['#808080'] = 'gray';
		colornames['#696969'] = 'dimgray';
		colornames['#778899'] = 'lightslategray';
		colornames['#708090'] = 'slategray';
		colornames['#2F4F4F'] = 'darkslategray';
		colornames['#000000'] = 'black';
	// end color names http://www.geocities.ws/xpf51/HTMLREF/HEX_CODES.html
</script>

<?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_PARENTMODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?>
	<?php if ($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?>
	<script>
		vtDZParentRelations.push("<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename');?>
");
	</script>
	<?php }?>
<?php } ?><?php }} ?>