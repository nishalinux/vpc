<?php /* Smarty version Smarty-3.1.7, created on 2018-08-16 15:10:51
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Audio.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4981017975b7593fb8c6246-69997522%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3e7c8ca0cb6ccdc2b1ae39abf1356beae20036c0' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Audio.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4981017975b7593fb8c6246-69997522',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'MODULE' => 0,
    'FIELD_NAME' => 0,
    'testsplit' => 0,
    'storagename' => 0,
    'finalname' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7593fb91e7a',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7593fb91e7a')) {function content_5b7593fb91e7a($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()), null, 0);?><?php $_smarty_tpl->tpl_vars["SPECIAL_VALIDATOR"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator(), null, 0);?><?php $_smarty_tpl->tpl_vars["FIELD_NAME"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'), null, 0);?><!--div><i class="icon-upload"></i>&nbsp;<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')!=''){?><?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue');?>
&nbsp;<i class="icon-download"></i>&nbsp;<i class="icon-remove"></i><audio controls><source src="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue');?>
">Your browser does not support the audio tag.</audio><?php }?></div--><style>.audio-container{/*width: 500px;border: 1px solid #333;*/padding: 4px;}.audio-wrapper {background: url(modules/vtDZiner/audio.png) no-repeat;background-size: cover;display: inline;position: absolute;width: 24px;height: 24px;}.audio-icon {width: 24px;height: 24px;/*margin-right: 100px;*/opacity: 0;filter: alpha(opacity=0); /* IE 5-7 */}</style><div>Click on icon to select a new file<div style=" width:312px;float:left;"><div style=" width:32px;float:left;"><!-- Audio --><span class="audio-container" style=" width:50px;"><span class="audio-wrapper" ><input style="width:50px;" accept="audio/*" class="audio-icon" id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" type="file" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" /></span></span><!-- Audio --></div><div style=" width:204px;float:left;" class="alert alert-info"><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')!=''){?><?php $_smarty_tpl->tpl_vars["testsplit"] = new Smarty_variable(explode("/",$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')), null, 0);?><?php $_smarty_tpl->tpl_vars["storagename"] = new Smarty_variable(end($_smarty_tpl->tpl_vars['testsplit']->value), null, 0);?><?php $_smarty_tpl->tpl_vars["finalname"] = new Smarty_variable(explode("_",$_smarty_tpl->tpl_vars['storagename']->value), null, 0);?><?php echo $_smarty_tpl->tpl_vars['finalname']->value[1];?>
&nbsp;<sup>Saved</sup><?php }else{ ?>No file uploaded<?php }?><span class="pull-left" id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_attr"></span></div></div></div><script>$('#<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
').bind('change', function() {$('#<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_attr').html(this.files[0].name +"&nbsp;<sup>New</sup><br>"+this.files[0].size + " bytes");});</script><?php }} ?>