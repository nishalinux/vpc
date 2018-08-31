<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:41:42
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Jsign.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10340496365b73226673f494-66030998%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '30b0935995d3eddcde77fcb1fc5a2197d6d26d04' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/uitypes/Jsign.tpl',
      1 => 1532509383,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10340496365b73226673f494-66030998',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FIELD_MODEL' => 0,
    'JSIGN_DETAILS' => 0,
    'IMAGE_INFO' => 0,
    'ITER' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b732266770cf',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b732266770cf')) {function content_5b732266770cf($_smarty_tpl) {?>
<meta charset="utf-8"><!-- Always force latest IE rendering engine (even in intranet) & Chrome FrameRemove this if you use the .htaccess --><meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1"><meta name="viewport" content="initial-scale=1.0, target-densitydpi=device-dpi" /><!-- this is for mobile (Android) Chrome --><meta name="viewport" content="initial-scale=.5, width=device-height"><!--  mobile Safari, FireFox, Opera Mobile  --><script src="./libraries/jSignature-master/src/jSignature.js"></script><script src="./libraries/jSignature-master/src/plugins/jSignature.CompressorBase30.js"></script><style type="text/css">#signatureparent {color:darkblue;background-color:darkgrey;/*max-width:600px;*/padding:20px;}/*This is the div within which the signature canvas is fitted*/.signature {border: 2px dotted black;background-color:lightgrey;width:300px;height:80px;position:left;left:e.pageX;top:e.pageY;}/* Drawing the 'gripper' for touch-enabled devices */html.touch #content {float:left;width:52%;}html.touch #scrollgrabber {width:4%;margin-right:2%;background-image:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAAFCAAAAACh79lDAAAAAXNSR0IArs4c6QAAABJJREFUCB1jmMmQxjCT4T/DfwAPLgOXlrt3IwAAAABJRU5ErkJggg==)}span[name=existingImages] img {height:100px;width:300px;}</style><div id="signature<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" class='signature'></div><img id="sigimage<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
"><div style="display: inline-block;"><p><input id="donebutton<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" type="button" value="Done"><input id="clearbutton<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" type="button" value="Clear"></p><input name="imagedata[<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
]" value="" id ="idimagedata<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
" type="hidden" /></div><textarea name="jbase64" id="jbase64<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
"   maxlength='90000' style="display: none;"></textarea><div id="img_preview"  ></div><?php  $_smarty_tpl->tpl_vars['IMAGE_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = false;
 $_smarty_tpl->tpl_vars['ITER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['JSIGN_DETAILS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['IMAGE_INFO']->key => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value){
$_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = true;
 $_smarty_tpl->tpl_vars['ITER']->value = $_smarty_tpl->tpl_vars['IMAGE_INFO']->key;
?><?php $_smarty_tpl->tpl_vars['imgpath'] = new Smarty_variable(($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])."_".($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['name']), null, 0);?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
<?php $_tmp1=ob_get_clean();?><?php if ($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path']!=''&&$_tmp1!=''){?><div class="row-fluid"><span class="span8" name="existingImages"><img src="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'];?>
_<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" data-image-id="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['id'];?>
"></span><span class="span3 row-fluid"><span class="row-fluid">[<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['name'];?>
]</span><span class="row-fluid"><input type="button" id="file_<?php echo $_smarty_tpl->tpl_vars['ITER']->value;?>
" value="Delete" class="signDelete"></span></span></div><?php }?><?php } ?>

 
 <script type="text/javascript">
 jQuery(document).ready(function() {
	var field_name = "<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldName();?>
"; 
	jQuery("#signature"+field_name).jSignature();
	jQuery('#donebutton'+field_name).click(function() {
	var signatureCheck =  jQuery('#signature'+field_name).jSignature('getData', 'image');
    if (signatureCheck.length === 0) {		
		alert('Signature required.');
    } else {
		jQuery('#sigimage'+field_name).attr('src', jQuery('#signature'+field_name).jSignature('getData')); 
		jQuery('#sigimage'+field_name).show();
		var imagedata = jQuery('#signature'+field_name).jSignature('getData');
		jQuery('#idimagedata'+field_name).val(imagedata);
    }
  });
  jQuery('#clearbutton'+field_name).click(function () {
		jQuery('#signature'+field_name).jSignature('clear');
		jQuery('#signature'+field_name).show();
		jQuery('#sigimage'+field_name).hide();
    });	
	jQuery('.signDelete').click(function(element){
		var file_id = jQuery(this).id;
		var formElement = jQuery('#EditView');
		var recordId = formElement.find('input[name="record"]').val();		 
		var element = jQuery(this);	 
		var imageId = element.closest('div').find('img').data().imageId;
		console.log(element);
		element.closest('div').remove();
		//var exisitingImages = parentTd.find('[name="existingImages"]');		
		if(formElement.find('[name=imageid]').length != 0) {
			var imageIdValue = JSON.parse(formElement.find('[name=imageid]').val());
			imageIdValue.push(imageId);
			formElement.find('[name=imageid]').val(JSON.stringify(imageIdValue));
		} else {
			var imageIdJson = [];
			imageIdJson.push(imageId);
			formElement.append('<input type="hidden" name="signDeleted" value="true" />');
			formElement.append('<input type="hidden" name="imageid" value="'+JSON.stringify(imageIdJson)+'" />');
		} 
	});
   });
   </script>
 <?php }} ?>