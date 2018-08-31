<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 06:14:56
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/ChecklistItems/Settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4592162115b77b9605d5435-05967672%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8fa368e8da745e263f3c2f78d14f6a8a109d6dce' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/ChecklistItems/Settings.tpl',
      1 => 1507143463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4592162115b77b9605d5435-05967672',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'CURRENT_USER' => 0,
    'USER_PERMISSION' => 0,
    'COUNT_ENTITY' => 0,
    'ENTITIES' => 0,
    'ENTITY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77b96061a9b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77b96061a9b')) {function content_5b77b96061a9b($_smarty_tpl) {?>
 
<div class="container-fluid">
    <div class="contentHeader row-fluid">
        <h3 class="span8 textOverflowEllipsis">
            <a href="index.php?module=ModuleManager&parent=Settings&view=List">&nbsp;<?php echo vtranslate('MODULE_MANAGEMENT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a>&nbsp;>&nbsp;<?php echo vtranslate('LBL_SETTING_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

        </h3>
    </div>
    <hr>
    <div class="clearfix"></div>

    <div class="listViewContentDiv row-fluid" id="listViewContents">
        <div class="marginBottom10px">
            <span class="row btn-toolbar">
                <button type="button" data-url="index.php?module=ChecklistItems&view=EditViewAjax&parent=Settings" class="btn addButton editButton">
                    <i class="icon-plus"></i>&nbsp;
                    <strong><?php echo vtranslate('LBL_ADD_MORE_BTN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
                </button>
                <?php if ($_smarty_tpl->tpl_vars['CURRENT_USER']->value->isAdminUser()){?>
                <span class="pull-right">
                    <label for="none_user_permission" style="display: inline;"><?php echo vtranslate('LBL_ALLOW_NONE_USER_CREATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label>
                    <input type="checkbox" id="none_user_permission" <?php if ($_smarty_tpl->tpl_vars['USER_PERMISSION']->value==1){?>checked="true"<?php }?> value="1" style="display: inline; margin-left: 5px;"/>
                </span>
                <?php }?>
            </span>
        </div>
        <div class="marginBottom10px">
            <table class="table table-bordered listViewEntriesTable vte-checklist-items">
                <thead>
                    <tr class="listViewHeaders">
                        <th class="medium"></th>
                        <th class="medium"><?php echo vtranslate('LBL_CHECKLIST_NAME_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th>
                        <th class="medium"><?php echo vtranslate('LBL_MODULE_NAME_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th>
                        <th class="medium"><?php echo vtranslate('LBL_CREATED_DATE_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th>
                        <th class="medium" colspan="2"><?php echo vtranslate('LBL_STATUS_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($_smarty_tpl->tpl_vars['COUNT_ENTITY']->value>0){?>
                        <?php  $_smarty_tpl->tpl_vars['ENTITY'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ENTITY']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ENTITIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ENTITY']->key => $_smarty_tpl->tpl_vars['ENTITY']->value){
$_smarty_tpl->tpl_vars['ENTITY']->_loop = true;
?>
                            <tr>
                                <td class="listViewEntryValue" width="5%">
                                    <i class="icon-move alignMiddle" title="<?php echo vtranslate('LBL_MOVE_BTN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistid'];?>
"></i>
                                </td>
                                <td class="listViewEntryValue" width="45%">
                                    <a class="editButton" href="javascript:void(0)" data-url="index.php?module=ChecklistItems&view=EditViewAjax&parent=Settings&record=<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistid'];?>
">
                                    <?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistname'];?>

                                    </a>
                                </td>
                                <td class="listViewEntryValue" width="15%"><?php echo vtranslate($_smarty_tpl->tpl_vars['ENTITY']->value['modulename'],$_smarty_tpl->tpl_vars['ENTITY']->value['modulename']);?>
</td>
                                <td class="listViewEntryValue" width="20%"><?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['createddate'];?>
</td>
                                <td class="listViewEntryValue" width="10%">
                                    <a href="javascript:void(0);" class="checklist_status" data-status="<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['status'];?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistid'];?>
" title="<?php if ($_smarty_tpl->tpl_vars['ENTITY']->value['status']=='Active'){?><?php echo vtranslate('LBL_INACTIVE_BTN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }else{ ?><?php echo vtranslate('LBL_ACTIVE_BTN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
<?php }?>">
                                        <?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['status'];?>

                                    </a>
                                </td>
                                <td class="listViewEntryValue" width="5%">
                                    <div class="actions pull-right">
                                        <span class="actionImages">
                                            <a data-url="index.php?module=ChecklistItems&view=EditViewAjax&parent=Settings&record=<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistid'];?>
&modulename=<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['modulename'];?>
" class="editButton" href="javascript: void(0);">
                                                <i class="icon-pencil alignMiddle" title="<?php echo vtranslate('LBL_EDIT_BTN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>
                                            </a>
                                            <a data-url="index.php?module=ChecklistItems&action=DeleteAjax&parent=Settings&record=<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistid'];?>
&modulename=<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['modulename'];?>
" class="deleteButton" href="javascript: void(0);">
                                                <i class="icon-trash alignMiddle" title="<?php echo vtranslate('LBL_DELETE_BTN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"></i>
                                            </a>
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php }?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php }} ?>