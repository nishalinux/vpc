<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:15:36
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/Footer.tpl" */ ?>
<?php /*%%SmartyHeaderCode:19650657685b730e381af446-17522043%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0e141d9f41e0f1156aa78b1d4746bb0f940342d9' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/Footer.tpl',
      1 => 1508320191,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '19650657685b730e381af446-17522043',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ACTIVITY_REMINDER' => 0,
    'HEADER_LINKS' => 0,
    'MAIN_PRODUCT_SUPPORT' => 0,
    'MAIN_PRODUCT_WHITELABEL' => 0,
    'FIRSTHEADERLINK' => 0,
    'FIRSTHEADERLINKCHILDRENS' => 0,
    'FEEDBACKLINKMODEL' => 0,
    'CURRENT_USER_MODEL' => 0,
    'BLOCKS' => 0,
    'PANELTABS' => 0,
    'PICKBLOCKS' => 0,
    'RECORD' => 0,
    'RECORD_STRUCTURE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b730e381fc2c',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b730e381fc2c')) {function content_5b730e381fc2c($_smarty_tpl) {?>
<input id='activityReminder' class='hide noprint' type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ACTIVITY_REMINDER']->value;?>
"/><?php if ($_smarty_tpl->tpl_vars['HEADER_LINKS']->value&&$_smarty_tpl->tpl_vars['MAIN_PRODUCT_SUPPORT']->value&&!$_smarty_tpl->tpl_vars['MAIN_PRODUCT_WHITELABEL']->value){?><?php $_smarty_tpl->tpl_vars["FIRSTHEADERLINK"] = new Smarty_variable($_smarty_tpl->tpl_vars['HEADER_LINKS']->value[0], null, 0);?><?php $_smarty_tpl->tpl_vars["FIRSTHEADERLINKCHILDRENS"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIRSTHEADERLINK']->value->get('childlinks'), null, 0);?><?php $_smarty_tpl->tpl_vars["FEEDBACKLINKMODEL"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIRSTHEADERLINKCHILDRENS']->value[2], null, 0);?><!--div id="userfeedback" class="feedback noprint"><a href="https://discussions.vtiger.com" target="_blank" xonclick="<?php echo $_smarty_tpl->tpl_vars['FEEDBACKLINKMODEL']->value->get('linkurl');?>
" class="handle"><?php echo vtranslate("LBL_FEEDBACK","Vtiger");?>
</a></div--><?php }?><?php if (!$_smarty_tpl->tpl_vars['MAIN_PRODUCT_WHITELABEL']->value&&isset($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value)){?><footer class="noprint"><div class="vtFooter"><p>Powered by&nbsp;&nbsp;<a href="http://theracanncorp.com/" target="_blank">theracanncorp.com</a>&nbsp;|&nbsp;<a href="http://theracanncorp.com/features/terms_and_conditions/" ><?php echo vtranslate('LBL_READ_LICENSE');?>
</a>&nbsp;|&nbsp;<a href="http://theracanncorp.com/features/privacy/" target="_blank"><?php echo vtranslate('LBL_PRIVACY_POLICY');?>
</a></p></div></footer><?php }?><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('JSResources.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php if (isset($_smarty_tpl->tpl_vars['BLOCKS']->value)){?><script>var vtBlockDetail = <?php echo json_encode($_smarty_tpl->tpl_vars['BLOCKS']->value);?>
;</script><?php }?><?php if (isset($_smarty_tpl->tpl_vars['PANELTABS']->value)){?><script>var panelTabs = <?php echo json_encode($_smarty_tpl->tpl_vars['PANELTABS']->value);?>
;</script><?php }?><?php if (isset($_smarty_tpl->tpl_vars['PICKBLOCKS']->value)){?><script>var pickBlocks = <?php echo json_encode($_smarty_tpl->tpl_vars['PICKBLOCKS']->value);?>
;</script><?php }?><?php if (isset($_smarty_tpl->tpl_vars['RECORD']->value)){?><script>var vtRecordModel = <?php echo json_encode($_smarty_tpl->tpl_vars['RECORD']->value);?>
;</script><?php }?><?php ob_start();?><?php echo json_encode($_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value)!='';?>
<?php $_tmp1=ob_get_clean();?><?php if (isset($_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value)&&$_tmp1){?><script>var vtRecordStructure = <?php echo json_encode($_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value);?>
;</script><?php }?><script>var vtDZActive = "<?php echo $_SESSION['VTDZINERSTATUS'];?>
";var vtSession = <?php echo json_encode($_SESSION);?>
;</script></div></body></html>
<?php }} ?>