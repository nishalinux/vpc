<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:37:19
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Barcode.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13550200615b73134fdd4857-17483940%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2f3538e97e3cf79d2c834c0b68ce72b4d8de4cf0' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Barcode.tpl',
      1 => 1468493292,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13550200615b73134fdd4857-17483940',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'MODULE' => 0,
    'vt_tab' => 0,
    'fldvalue' => 0,
    'BARCODE_DETAILS' => 0,
    'IMAGE_INFO' => 0,
    'ITER' => 0,
    'THEME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73134fe0989',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73134fe0989')) {function content_5b73134fe0989($_smarty_tpl) {?>
<script src="modules/Products/JsBarcode-master/dist/JsBarcode.all.js"></script><?php $_smarty_tpl->tpl_vars["FIELD_INFO"] = new Smarty_variable(Vtiger_Util_Helper::toSafeHTML(Zend_Json::encode($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldInfo())), null, 0);?><?php $_smarty_tpl->tpl_vars["SPECIAL_VALIDATOR"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getValidator(), null, 0);?><?php if ($_smarty_tpl->tpl_vars['MODULE']->value=='HelpDesk'&&($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name')=='days'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name')=='hours')){?><?php $_smarty_tpl->tpl_vars["FIELD_VALUE"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')), null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars["FIELD_VALUE"] = new Smarty_variable($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'), null, 0);?><?php }?><input type="text" tabindex="<?php echo $_smarty_tpl->tpl_vars['vt_tab']->value;?>
" name="barcode" id ="barcode" value="<?php echo $_smarty_tpl->tpl_vars['fldvalue']->value;?>
" class="detailedViewTextBox" onFocus="this.className='detailedViewTextBoxOn'" onBlur="this.className='detailedViewTextBox'"><input type="button" id="generateBC" name="generateBC" value="Generate" class="crmbutton small"  ><img id="barcode2" width="300" height="146"/><canvas id="myCanvasImage" width="50" height="50">re</canvas><textarea name="base64" id="base64"  style="display:none;" maxlength='90000'></textarea><div id="img_preview"  ></div><?php  $_smarty_tpl->tpl_vars['IMAGE_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = false;
 $_smarty_tpl->tpl_vars['ITER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['BARCODE_DETAILS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['IMAGE_INFO']->key => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value){
$_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = true;
 $_smarty_tpl->tpl_vars['ITER']->value = $_smarty_tpl->tpl_vars['IMAGE_INFO']->key;
?><div class="row-fluid"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
<?php $_tmp1=ob_get_clean();?><?php if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])&&!empty($_tmp1)){?><span class="span8" name="existingImages"><img src="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'];?>
_<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" data-image-id="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['id'];?>
"></span><span class="span3 row-fluid"><span class="row-fluid">[<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['name'];?>
]</span><span class="row-fluid"><input type="button" id="file_<?php echo $_smarty_tpl->tpl_vars['ITER']->value;?>
" value="Delete" class="barcodeDelete"></span></span><?php }?></div><?php } ?><span id="vtbusy_info" style="display:none;"><img src="<?php echo vtiger_imageurl('vtbusy.gif',$_smarty_tpl->tpl_vars['THEME']->value);?>
" border="0"></span><?php }} ?>