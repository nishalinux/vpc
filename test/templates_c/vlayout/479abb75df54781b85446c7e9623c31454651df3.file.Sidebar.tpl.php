<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 06:14:56
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/ChecklistItems/Sidebar.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19311985435b77b96052fc34-62394821%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '479abb75df54781b85446c7e9623c31454651df3' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/ChecklistItems/Sidebar.tpl',
      1 => 1507143463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19311985435b77b96052fc34-62394821',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'USER_MODEL' => 0,
    'QUALIFIED_MODULE' => 0,
    'SETTINGS_MENUS' => 0,
    'MENU' => 0,
    'SELECTED_MENU' => 0,
    'SELECTED_FIELDID' => 0,
    'MENUITEM' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77b96059a8e',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77b96059a8e')) {function content_5b77b96059a8e($_smarty_tpl) {?>
<?php if ($_smarty_tpl->tpl_vars['USER_MODEL']->value->isAdminUser()){?><div class="sidebarTitleBlock"><h3 class="titlePadding themeTextColor unSelectedQuickLink cursorPointer"><a href="index.php?module=Vtiger&parent=Settings&view=Index"><?php echo vtranslate('LBL_SETTINGS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a></h3></div><!--div><input class='input-medium' type='text' name='settingsSearch' placeholder=<?php echo vtranslate("LBL_SEARCH_SETTINGS_PLACEHOLDER",$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 ></div--><div class="quickWidgetContainer accordion" id="settingsQuickWidgetContainer"><?php  $_smarty_tpl->tpl_vars['MENU'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MENU']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SETTINGS_MENUS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MENU']->key => $_smarty_tpl->tpl_vars['MENU']->value){
$_smarty_tpl->tpl_vars['MENU']->_loop = true;
?><div class="quickWidget"><div class="accordion-heading accordion-toggle quickWidgetHeader" data-parent="#settingsQuickWidgetContainer" data-target="#Settings_sideBar_<?php echo Vtiger_Util_Helper::replaceSpaceWithUnderScores($_smarty_tpl->tpl_vars['MENU']->value->getLabel());?>
"data-toggle="collapse" data-parent="#quickWidgets"><span class="pull-left"><img class="imageElement" data-rightimage="<?php echo vimage_path('rightArrowWhite.png');?>
" data-downimage="<?php echo vimage_path('downArrowWhite.png');?>
" src="<?php if ($_smarty_tpl->tpl_vars['SELECTED_MENU']->value->get('blockid')==$_smarty_tpl->tpl_vars['MENU']->value->get('blockid')&&!empty($_smarty_tpl->tpl_vars['SELECTED_FIELDID']->value)){?><?php echo vimage_path('downArrowWhite.png');?>
<?php }else{ ?><?php echo vimage_path('rightArrowWhite.png');?>
<?php }?>" /></span><h5 class="title paddingLeft10px widgetTextOverflowEllipsis" title="<?php echo vtranslate($_smarty_tpl->tpl_vars['MENU']->value->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['MENU']->value->getLabel(),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h5><div class="clearfix"></div></div><div  style="border-bottom: 1px solid black;" class="widgetContainer accordion-body <?php if ($_smarty_tpl->tpl_vars['SELECTED_MENU']->value->get('blockid')==$_smarty_tpl->tpl_vars['MENU']->value->get('blockid')&&!empty($_smarty_tpl->tpl_vars['SELECTED_FIELDID']->value)){?> in <?php }?> collapse" id="Settings_sideBar_<?php echo Vtiger_Util_Helper::replaceSpaceWithUnderScores($_smarty_tpl->tpl_vars['MENU']->value->getLabel());?>
"><?php  $_smarty_tpl->tpl_vars['MENUITEM'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MENUITEM']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['MENU']->value->getMenuItems(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MENUITEM']->key => $_smarty_tpl->tpl_vars['MENUITEM']->value){
$_smarty_tpl->tpl_vars['MENUITEM']->_loop = true;
?><div class="<?php if ($_smarty_tpl->tpl_vars['MENUITEM']->value->getId()==$_smarty_tpl->tpl_vars['SELECTED_FIELDID']->value){?> selectedMenuItem selectedListItem<?php }?>" style="padding:7px;border-top:0px;"><div class="row-fluid menuItem"  data-actionurl="<?php echo $_smarty_tpl->tpl_vars['MENUITEM']->value->getPinUnpinActionUrl();?>
"><a href="<?php echo $_smarty_tpl->tpl_vars['MENUITEM']->value->getUrl();?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['MENUITEM']->value->getId();?>
" class="span9 menuItemLabel" data-menu-item="true" ><?php echo vtranslate($_smarty_tpl->tpl_vars['MENUITEM']->value->get('name'),$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a><span class="span1">&nbsp;</span><img style="margin-right: 6%" id="<?php echo $_smarty_tpl->tpl_vars['MENUITEM']->value->getId();?>
_menuItem" data-pintitle="<?php echo vtranslate('LBL_PIN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-unpintitle="<?php echo vtranslate('LBL_UNPIN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" data-id="<?php echo $_smarty_tpl->tpl_vars['MENUITEM']->value->getId();?>
" class="pinUnpinShortCut cursorPointer hide pull-right" data-unpinimageurl="<?php ob_start();?><?php echo vimage_path('unpin.png');?>
<?php $_tmp1=ob_get_clean();?><?php echo $_tmp1;?>
"  data-pinimageurl="<?php ob_start();?><?php echo vimage_path('pin.png');?>
<?php $_tmp2=ob_get_clean();?><?php echo $_tmp2;?>
" <?php if ($_smarty_tpl->tpl_vars['MENUITEM']->value->isPinned()){?> title="<?php echo vtranslate('LBL_UNPIN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" src="<?php echo vimage_path('unpin.png');?>
" data-action="unpin" <?php }else{ ?> title="<?php echo vtranslate('LBL_PIN',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
" src="<?php echo vimage_path('pin.png');?>
" data-action="pin" <?php }?> /><div class="clearfix"></div></div></div><?php } ?></div></div><?php } ?></div><div class="row-fluid"><button type="button" class="row-fluid extensionStorebtn" onclick='window.location.href="index.php?module=ExtensionStore&parent=Settings&view=ExtensionStore"'><?php echo vtranslate('LBL_EXTENSION_STORE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</button></div><?php }else{ ?><div><table cellspacing="0" cellpadding="5" border="0" width="98%"><tbody><tr><td align="center"><img src="layouts/vlayout/skins/images/denied.gif"></td></tr><tr><td align="center" nowrap="nowrap" style="border-bottom: 1px solid rgb(204, 204, 204);"><span class="genHeaderSmall"><?php echo vtranslate('LBL_PERMISSION_DENIED',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</span></td></tr><tr><td align="right" nowrap="nowrap" class="small"><a href="javascript:window.history.back();">Go back</a><br></td></tr></tbody></table></div><?php }?>
<?php }} ?>