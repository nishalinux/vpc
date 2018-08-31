<?php /* Smarty version Smarty-3.1.7, created on 2018-08-16 15:10:51
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Video.tpl" */ ?>
<?php /*%%SmartyHeaderCode:11121021725b7593fb92c305-65545464%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '0fd144c7a6c613ca47f344c2d00184006f5659b2' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Video.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '11121021725b7593fb92c305-65545464',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'MODULE' => 0,
    'FIELD_NAME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7593fb94d11',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7593fb94d11')) {function content_5b7593fb94d11($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo()), null, 0);?><?php $_smarty_tpl->tpl_vars["SPECIAL_VALIDATOR"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator(), null, 0);?><?php $_smarty_tpl->tpl_vars["FIELD_NAME"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name'), null, 0);?><style>.upload-container{/*width: 500px;border: 1px solid #333;*/padding: 4px;}.upload-wrapper {background: url(modules/vtDZiner/video.png) no-repeat;background-size: cover;display: block;position: relative;width: 24px;height: 24px;}.movie-upload {width: 24px;height: 24px;margin-right: 100px;opacity: 0;filter: alpha(opacity=0); /* IE 5-7 */}</style>Current: <?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue');?>
<div class="upload-container"><span class="upload-wrapper"><input accept="video/*" class="movie-upload" id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
" type="file" name="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" /></span></div><span id="<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_attr"></span><script>$('#<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
').bind('change', function() {$('#<?php echo $_smarty_tpl->tpl_vars['MODULE']->value;?>
_editView_fieldName_<?php echo $_smarty_tpl->tpl_vars['FIELD_NAME']->value;?>
_attr').html("Selected: "+this.files[0].name +", "+this.files[0].size + " bytes");});</script>
<?php }} ?>