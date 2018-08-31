<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:17:54
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/EditViewActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8745004475b7338f220ed64-49965661%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '94f9d58863f71cb13795bac7859da97d41aeeaa0' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/EditViewActions.tpl',
      1 => 1532585234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8745004475b7338f220ed64-49965661',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'PROCESSMASTER_JSON_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7338f221d83',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7338f221d83')) {function content_5b7338f221d83($_smarty_tpl) {?>

<!-- <div class="row-fluid"><div class="pull-right"><button class="btn btn-success" type="submit"><strong><?php echo vtranslate('LBL_SAVE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button><a class="cancelLink" type="reset" onclick="javascript:window.history.back();"><?php echo vtranslate('LBL_CANCEL',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a></div></div>--></form><input type="hidden" id="idIsVessels" value="<?php echo $_smarty_tpl->tpl_vars['PROCESSMASTER_JSON_DATA']->value['is_vessels'];?>
"><input type="hidden" id="idIsTools" value="<?php echo $_smarty_tpl->tpl_vars['PROCESSMASTER_JSON_DATA']->value['is_tools'];?>
"><input type="hidden" id="idIsMachinery" value="<?php echo $_smarty_tpl->tpl_vars['PROCESSMASTER_JSON_DATA']->value['is_machinery'];?>
"></div><?php }} ?>