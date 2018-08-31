<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:16:12
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/KanbanView/IndexViewPreProcess.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1758269655b73388cc58ff4-87125442%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'cb9eea70a4a2c6dea590673fe68947cb07b4eb7d' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/KanbanView/IndexViewPreProcess.tpl',
      1 => 1507911071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1758269655b73388cc58ff4-87125442',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'KANBAN_PARENT_MODULE' => 0,
    'CUSTOM_VIEWS' => 0,
    'GROUP_LABEL' => 0,
    'GROUP_CUSTOM_VIEWS' => 0,
    'CUSTOM_VIEW' => 0,
    'CURRENT_USER_MODEL' => 0,
    'VIEWID' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73388ccd0ad',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73388ccd0ad')) {function content_5b73388ccd0ad($_smarty_tpl) {?>
<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("Header.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path("BasicHeader.tpl",$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

<div class="bodyContents">
	<div class="mainContainer row-fluid">
        <div class="contentsBox contentsDiv">
        <div class="listViewActionsDiv row-fluid">
            <input id="kbParentModule" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['KANBAN_PARENT_MODULE']->value;?>
">
            <span class="span4">&nbsp;</span>
            <span class="btn-toolbar span4">
                <span class="customFilterMainSpan btn-group">
                    <?php if (count($_smarty_tpl->tpl_vars['CUSTOM_VIEWS']->value)>0){?>

                        <select id="customFilter" style="width:350px;">
                            <?php  $_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS']->_loop = false;
 $_smarty_tpl->tpl_vars['GROUP_LABEL'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CUSTOM_VIEWS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS']->key => $_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS']->value){
$_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS']->_loop = true;
 $_smarty_tpl->tpl_vars['GROUP_LABEL']->value = $_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS']->key;
?>
                                <optgroup label=' <?php if ($_smarty_tpl->tpl_vars['GROUP_LABEL']->value=='Mine'){?> &nbsp; <?php }else{ ?> <?php echo vtranslate($_smarty_tpl->tpl_vars['GROUP_LABEL']->value);?>
 <?php }?>' >
                                    <?php  $_smarty_tpl->tpl_vars["CUSTOM_VIEW"] = new Smarty_Variable; $_smarty_tpl->tpl_vars["CUSTOM_VIEW"]->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['GROUP_CUSTOM_VIEWS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars["CUSTOM_VIEW"]->key => $_smarty_tpl->tpl_vars["CUSTOM_VIEW"]->value){
$_smarty_tpl->tpl_vars["CUSTOM_VIEW"]->_loop = true;
?>
                                        <option  data-editurl="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getEditUrl();?>
" data-deleteurl="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getDeleteUrl();?>
" data-approveurl="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getApproveUrl();?>
" data-denyurl="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getDenyUrl();?>
" data-editable="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->isEditable();?>
" data-deletable="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->isDeletable();?>
" data-pending="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->isPending();?>
" data-public="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->isPublic()&&$_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->isAdminUser();?>
" id="filterOptionId_<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('cvid');?>
" value="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('cvid');?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('cvid');?>
" <?php if ($_smarty_tpl->tpl_vars['VIEWID']->value!=''&&$_smarty_tpl->tpl_vars['VIEWID']->value!='0'&&$_smarty_tpl->tpl_vars['VIEWID']->value==$_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getId()){?> selected="selected" <?php }elseif(($_smarty_tpl->tpl_vars['VIEWID']->value==''||$_smarty_tpl->tpl_vars['VIEWID']->value=='0')&&$_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->isDefault()=='true'){?> selected="selected" <?php }?> class="filterOptionId_<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('cvid');?>
"><?php if ($_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('viewname')=='All'){?><?php echo vtranslate($_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('viewname'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate($_smarty_tpl->tpl_vars['KANBAN_PARENT_MODULE']->value,'KANBAN_PARENT_MODULE');?>
<?php }else{ ?><?php echo vtranslate($_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->get('viewname'),$_smarty_tpl->tpl_vars['MODULE']->value);?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['GROUP_LABEL']->value!='Mine'){?> [ <?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getOwnerName();?>
 ]  <?php }?></option>
                                    <?php } ?>
                                </optgroup>
                            <?php } ?>
                        </select>
                        <span class="filterActionsDiv hide">
                            <hr>
                            <ul class="filterActions">
                                <li data-value="create" id="createFilter" data-createurl="<?php echo $_smarty_tpl->tpl_vars['CUSTOM_VIEW']->value->getCreateUrl();?>
"><i class="icon-plus-sign"></i> <?php echo vtranslate('LBL_CREATE_NEW_FILTER');?>
</li>
                            </ul>
                        </span>
                        <img class="filterImage" src="<?php echo vimage_path('filter.png');?>
" style="display:none;height:13px;margin-right:2px;vertical-align: middle;">
                    <?php }else{ ?>
                        <input type="hidden" value="0" id="customFilter" />
                    <?php }?>
                </span>
            </span>
            <span class="span3" style = "width: 27.5%;padding-top: 10px;" >
                <button class="btn pull-right" onclick="KanbanView_Js.getSettingView('<?php echo $_smarty_tpl->tpl_vars['KANBAN_PARENT_MODULE']->value;?>
','KanbanView')"><?php echo vtranslate('LBL_CONFIGURE_KANBAN_VIEW','KanbanView');?>
</button>
                <a class="btn pull-right" style="margin-right: 15px;" href="index.php?module=<?php echo $_smarty_tpl->tpl_vars['KANBAN_PARENT_MODULE']->value;?>
&view=List&viewname=<?php echo $_smarty_tpl->tpl_vars['VIEWID']->value;?>
"> <?php echo vtranslate('LBL_GO_BACK_TO_LISTVIEW','KanbanView');?>
</a>
            </span>
        <span class="hide filterActionImages pull-right">
            <i title="<?php echo vtranslate('LBL_DENY',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-value="deny" class="icon-ban-circle alignMiddle denyFilter filterActionImage pull-right"></i>
            <i title="<?php echo vtranslate('LBL_APPROVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-value="approve" class="icon-ok alignMiddle approveFilter filterActionImage pull-right"></i>
            <i title="<?php echo vtranslate('LBL_DELETE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-value="delete" class="icon-trash alignMiddle deleteFilter filterActionImage pull-right"></i>
            <i title="<?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-value="edit" class="icon-pencil alignMiddle editFilter filterActionImage pull-right"></i>
        </span>
    </div>
<?php }} ?>