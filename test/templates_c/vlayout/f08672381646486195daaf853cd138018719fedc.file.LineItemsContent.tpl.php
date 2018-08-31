<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:17:54
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/LineItemsContent.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9845225885b7338f20e88c8-37850846%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'f08672381646486195daaf853cd138018719fedc' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/LineItemsContent.tpl',
      1 => 1532585234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9845225885b7338f20e88c8-37850846',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'row_no' => 0,
    'CURRENT_USER_MODEL' => 0,
    'MODULE' => 0,
    'productcategory' => 0,
    'PRODUCT_CATEGORIES' => 0,
    'categoryid' => 0,
    'categoryname' => 0,
    'data' => 0,
    'productcategoryid' => 0,
    'batchid' => 0,
    'productName' => 0,
    'productid' => 0,
    'prasentqty' => 0,
    'issuedqty' => 0,
    'qty' => 0,
    'qtyInStock' => 0,
    'issuedby' => 0,
    'ALL_ACTIVEUSER_LIST' => 0,
    'OWNER_ID' => 0,
    'userid' => 0,
    'OWNER_NAME' => 0,
    'remarks' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7338f216d64',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7338f216d64')) {function content_5b7338f216d64($_smarty_tpl) {?>
<?php $_smarty_tpl->tpl_vars["deleted"] = new Smarty_variable(("deleted").($_smarty_tpl->tpl_vars['row_no']->value), null, 0);?><?php $_smarty_tpl->tpl_vars["userid"] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->get('id'), null, 0);?><td>&nbsp;<a><img src="<?php echo vimage_path('drag.png');?>
" border="0" title="<?php echo vtranslate('LBL_DRAG',$_smarty_tpl->tpl_vars['MODULE']->value);?>
"/></a><input type="hidden" class="rowNumber" value="<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" /></td><td><select class="<?php echo $_smarty_tpl->tpl_vars['productcategory']->value;?>
<?php if ($_smarty_tpl->tpl_vars['row_no']->value!=0){?> chzn-select <?php }?>" style="width:220px;"name="<?php echo $_smarty_tpl->tpl_vars['productcategory']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['productcategory']->value;?>
"  ><option value=""><?php echo vtranslate('LBL_SELECT_OPTION','Vtiger');?>
</option><?php  $_smarty_tpl->tpl_vars['categoryname'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['categoryname']->_loop = false;
 $_smarty_tpl->tpl_vars['categoryid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PRODUCT_CATEGORIES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['categoryname']->key => $_smarty_tpl->tpl_vars['categoryname']->value){
$_smarty_tpl->tpl_vars['categoryname']->_loop = true;
 $_smarty_tpl->tpl_vars['categoryid']->value = $_smarty_tpl->tpl_vars['categoryname']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['categoryid']->value;?>
" data-pc-label="<?php echo $_smarty_tpl->tpl_vars['categoryname']->value;?>
" <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['productcategory']->value];?>
<?php $_tmp1=ob_get_clean();?><?php if (trim(decode_html($_tmp1))==trim($_smarty_tpl->tpl_vars['categoryid']->value)){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['categoryname']->value;?>
</option><?php } ?></select><!--input type="text" id="<?php echo $_smarty_tpl->tpl_vars['productcategoryid']->value;?>
"  name="<?php echo $_smarty_tpl->tpl_vars['productcategoryid']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['productcategoryid']->value];?>
" class="productcategoryid"/><input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['batchid']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['batchid']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['batchid']->value];?>
" class="batchid"/--></td><td><!-- Product Re-Ordering Feature Code Addition Starts --><input type="hidden" name="row<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
" id="row<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
"  value="<?php echo $_smarty_tpl->tpl_vars['row_no']->value;?>
"/><!-- Product Re-Ordering Feature Code Addition endsvalidate[required] --><div><input type="text" id="<?php echo $_smarty_tpl->tpl_vars['productName']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['productName']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['productName']->value];?>
" class="productName <?php if ($_smarty_tpl->tpl_vars['row_no']->value!=0){?> autoComplete <?php }?>" placeholder="<?php echo vtranslate('LBL_TYPE_SEARCH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-validation-engine="" <?php if (!empty($_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['productName']->value])){?> disabled="disabled" <?php }?>/><input type="hidden" id="<?php echo $_smarty_tpl->tpl_vars['productid']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['productid']->value;?>
" value="<?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['productid']->value];?>
" class="productid"/><input type="hidden" name="popupReferenceModule" id="popupReferenceModule" value="Products"/><img class="lineItemPopup cursorPointer alignMiddle" data-popup="Popup" data-module-name="Products" title="<?php echo vtranslate('Products',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-field-name="productid" src="<?php echo vimage_path('Products.png');?>
"/> &nbsp;<i class="icon-remove-sign clearLineItem cursorPointer" title="<?php echo vtranslate('LBL_CLEAR',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" style="vertical-align:middle"></i></div></td><td><!-- Prasent QtY data-validation-engine="validate[funcCall[Vtiger_GreaterThanZero_Validator_Js.invokeValidation]]"--><input id="<?php echo $_smarty_tpl->tpl_vars['prasentqty']->value;?>
" readonly name="<?php echo $_smarty_tpl->tpl_vars['prasentqty']->value;?>
" type="text" class="prasentqty smallInputBox"  value="<?php if (!empty($_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['prasentqty']->value])){?><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['prasentqty']->value];?>
<?php }else{ ?><?php }?>"/></td><td><!-- Issued Qty --><input id="<?php echo $_smarty_tpl->tpl_vars['issuedqty']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['issuedqty']->value;?>
" type="text" class="qty smallInputBox" data-validation-engine="validate[funcCall[Vtiger_GreaterThanZero_Validator_Js.invokeValidation]]" value="<?php if (!empty($_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['issuedqty']->value])){?><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['issuedqty']->value];?>
<?php }else{ ?><?php }?>"/><span class="stockAlert redColor <?php if ($_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['qty']->value]<=$_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['qtyInStock']->value]){?>hide<?php }?>" ><?php echo vtranslate('LBL_STOCK_NOT_ENOUGH',$_smarty_tpl->tpl_vars['MODULE']->value);?>
<br><?php echo vtranslate('LBL_MAX_QTY_SELECT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
&nbsp;<span class="maxQuantity"><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['qtyInStock']->value];?>
</span></span></td><td><!-- Issued BY --><select class="<?php echo $_smarty_tpl->tpl_vars['issuedby']->value;?>
<?php if ($_smarty_tpl->tpl_vars['row_no']->value!=0){?> chzn-select <?php }?>" style="width:220px;"name="<?php echo $_smarty_tpl->tpl_vars['issuedby']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['issuedby']->value;?>
"  ><option value=""><?php echo vtranslate('LBL_SELECT_OPTION','Vtiger');?>
</option><?php  $_smarty_tpl->tpl_vars['OWNER_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['OWNER_NAME']->_loop = false;
 $_smarty_tpl->tpl_vars['OWNER_ID'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['ALL_ACTIVEUSER_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['OWNER_NAME']->key => $_smarty_tpl->tpl_vars['OWNER_NAME']->value){
$_smarty_tpl->tpl_vars['OWNER_NAME']->_loop = true;
 $_smarty_tpl->tpl_vars['OWNER_ID']->value = $_smarty_tpl->tpl_vars['OWNER_NAME']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['OWNER_ID']->value;?>
" <?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['issuedby']->value];?>
<?php $_tmp2=ob_get_clean();?><?php if (trim(decode_html($_tmp2))==trim($_smarty_tpl->tpl_vars['OWNER_ID']->value)){?> selected <?php }else{?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['issuedby']->value];?>
<?php $_tmp3=ob_get_clean();?><?php if (trim(decode_html($_tmp3))==''&&$_smarty_tpl->tpl_vars['userid']->value==$_smarty_tpl->tpl_vars['OWNER_ID']->value){?>selected <?php }}?>  ><?php echo $_smarty_tpl->tpl_vars['OWNER_NAME']->value;?>
</option><?php } ?></select></td><td><textarea id="<?php echo $_smarty_tpl->tpl_vars['remarks']->value;?>
" name="<?php echo $_smarty_tpl->tpl_vars['remarks']->value;?>
" class="lineItemCommentBox"><?php echo $_smarty_tpl->tpl_vars['data']->value[$_smarty_tpl->tpl_vars['remarks']->value];?>
</textarea></td><?php }} ?>