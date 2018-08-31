<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 06:15:13
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/ChecklistItems/EditViewAjax.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1601427995b77b97159a3b6-16923717%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bb38769e9d14cd1f70aab83857547b90f0c66361' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/ChecklistItems/EditViewAjax.tpl',
      1 => 1507143463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1601427995b77b97159a3b6-16923717',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_ID' => 0,
    'MODULE_NAME' => 0,
    'QUALIFIED_MODULE' => 0,
    'ENTITY' => 0,
    'LIST_MODULES' => 0,
    'MODULE' => 0,
    'ACTIVE_MODULE' => 0,
    'ITEM' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77b97161863',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77b97161863')) {function content_5b77b97161863($_smarty_tpl) {?>

<div class="container-fluid" id="vte-primary-box">
    <form class="form-inline" id="CustomView" name="CustomView" method="post" action="index.php">
        <input type=hidden name="checklistid" id="checklistid" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" />
        <input type="hidden" name="module" value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" />
        <input type="hidden" value="Settings" name="parent" />
        <input type="hidden" name="action" value="SaveSettings" />
        <input type="hidden" id="textarea_id" value="0" />

        <div class="row-fluid"  style="padding: 10px 0;">
            <h3 class="textAlignCenter">
                <?php if ($_smarty_tpl->tpl_vars['RECORD_ID']->value>0){?>
                    <?php echo vtranslate('LBL_EDIT_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

                <?php }else{ ?>
                    <?php echo vtranslate('LBL_NEW_HEADER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

                <?php }?>
                <small aria-hidden="true" data-dismiss="modal" class="pull-right ui-checklist-closer" style="cursor: pointer;" title="<?php echo vtranslate('LBL_MODAL_CLOSE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
">x</small>
            </h3>
        </div>
        <hr>
        <div class="clearfix"></div>

        <div class="listViewContentDiv row-fluid" id="listViewContents" style="height: 450px; overflow-y: auto; width: 1200px;">
            <div class="marginBottom10px" >
                <div class="row-fluid">
                    <div class="row marginBottom10px">
                        <div class="span4 textAlignRight"><?php echo vtranslate('LBL_CHECKLIST_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div>
                        <div class="fieldValue span6">
                            <input type="text" name="checklistname" value="<?php echo $_smarty_tpl->tpl_vars['ENTITY']->value['checklistname'];?>
" class="input-large" />
                        </div>
                    </div>

                    <div class="row marginBottom10px">
                        <div class="span4 textAlignRight"><?php echo vtranslate('LBL_MODULE_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</div>
                        <div class="fieldValue span6">
                            <select name="modulename" class="chzn-select">
                                <?php  $_smarty_tpl->tpl_vars['MODULE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LIST_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE']->key => $_smarty_tpl->tpl_vars['MODULE']->value){
$_smarty_tpl->tpl_vars['MODULE']->_loop = true;
?>
                                    <option value="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value['name'];?>
" <?php if ($_smarty_tpl->tpl_vars['ENTITY']->value['modulename']==$_smarty_tpl->tpl_vars['MODULE']->value['name']||$_smarty_tpl->tpl_vars['ACTIVE_MODULE']->value==$_smarty_tpl->tpl_vars['MODULE']->value['name']){?>selected<?php }?> ><?php echo $_smarty_tpl->tpl_vars['MODULE']->value['tablabel'];?>
</option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="marginBottom10px items-list">
                        <table width="100%" cellpadding="5" cellspacing="5" class="items-list-table">
                            <tbody>
                        <?php if ($_smarty_tpl->tpl_vars['ENTITY']->value['count_items']>0){?>
                            <?php  $_smarty_tpl->tpl_vars['ITEM'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ITEM']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ENTITY']->value['items']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->key => $_smarty_tpl->tpl_vars['ITEM']->value){
$_smarty_tpl->tpl_vars['ITEM']->_loop = true;
?>
                                <tr class="checklist-item">
                                    <td width="14" valign="middle"><i class="icon-move alignMiddle" title="Change ordering" data-record=""></i></td>
                                    <td width="1172">
                                        <table width="100%" cellpadding="5" cellspacing="5">
                                            <tr>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_CATEGORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/category.html" class="icon-info category_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <input type="text" name="category[]" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['category'];?>
" placeholder="<?php echo vtranslate('LBL_CATEGORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" />
                                                </td>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/title.html" class="icon-info title_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <input type="text" name="title[]" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['title'];?>
" placeholder="<?php echo vtranslate('LBL_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" />
                                                </td>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_ALLOW_UPLOAD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/allow_upload.html" class="icon-info allow_upload_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <label><?php echo vtranslate('LBL_ALLOW_UPLOAD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label>
                                                    <input type="checkbox" class="allow_upload" value="1" <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['allow_upload']==1){?>checked<?php }?> />
                                                    <input type="hidden" name="allow_upload[]" class="allow_upload_value" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['allow_upload'];?>
"  />
                                                </td>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_ALLOW_NOTE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/allow_note.html" class="icon-info allow_note_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <label><?php echo vtranslate('LBL_ALLOW_NOTE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label>
                                                    <input type="checkbox" class="allow_note" value="1" <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['allow_note']==1){?>checked<?php }?> />
                                                    <input type="hidden" name="allow_note[]" class="allow_note_value" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['allow_note'];?>
" />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <textarea name="description[]" class="description" placeholder="<?php echo vtranslate('LBL_DESCRIPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" style="width: 800px; height: 75px;"><?php echo $_smarty_tpl->tpl_vars['ITEM']->value['description'];?>
</textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="14" valign="middle">
                                        <a data-url="" class="deleteButton" href="javascript: void(0);">
                                            <i class="icon-trash alignMiddle" title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php }else{ ?>
                                <tr class="checklist-item">
                                    <td width="14" valign="middle"><i class="icon-move alignMiddle" title="Change ordering" data-record=""></i></td>
                                    <td width="1172">
                                        <table width="100%" cellpadding="5" cellspacing="5">
                                            <tr>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_CATEGORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/category.html" class="icon-info category_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <input type="text" name="category[]" value="" placeholder="<?php echo vtranslate('LBL_CATEGORY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" />
                                                </td>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/title.html" class="icon-info title_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <input type="text" name="title[]" value="" placeholder="<?php echo vtranslate('LBL_TITLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" />
                                                </td>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_ALLOW_UPLOAD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/allow_upload.html" class="icon-info allow_upload_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <label><?php echo vtranslate('LBL_ALLOW_UPLOAD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label>
                                                    <input type="checkbox" class="allow_upload" value="1" checked />
                                                    <input type="hidden" name="allow_upload[]" class="allow_upload_value" value="1"  />
                                                </td>
                                                <td width="25%">
                                                    <img title="<?php echo vtranslate('LBL_ALLOW_NOTE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-url="layouts/vlayout/modules/Settings/ChecklistItems/info/allow_note.html" class="icon-info allow_note_info" src="layouts/vlayout/modules/Settings/ChecklistItems/resources/info.png" width="16" height="16" />
                                                    <label><?php echo vtranslate('LBL_ALLOW_NOTE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</label>
                                                    <input type="checkbox" class="allow_note" value="1"  checked />
                                                    <input type="hidden" name="allow_note[]" class="allow_note_value" value="1"  />
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="4">
                                                    <textarea name="description[]" class="description" placeholder="<?php echo vtranslate('LBL_DESCRIPTION',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" style="width: 800px; height: 75px;"></textarea>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                    <td width="14" valign="middle">
                                        <a data-url="" class="deleteButton" href="javascript: void(0);">
                                            <i class="icon-trash alignMiddle" title="Delete"></i>
                                        </a>
                                    </td>
                                </tr>
                        <?php }?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <div class="filterActions" style="padding: 10px 0;">
            <button class="btn addButton btn-add pull-left marginRight10px" id="add-checklist-item" type="button"><i class="icon-plus"></i>&nbsp;<strong><?php echo vtranslate('ADD_CHECKLIST_ITEM',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>
            <button class="btn btn-success pull-right" id="save-checklist" type="button"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>
        </div>
    </form>
</div>

<?php }} ?>