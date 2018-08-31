<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:17:02
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/DetailViewBlockView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:8491466575b7338be134304-50384923%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'd1b898ad806c1a88a1bfa4d084cde60948b359be' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/DetailViewBlockView.tpl',
      1 => 1532585234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '8491466575b7338be134304-50384923',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RECORD_STRUCTURE' => 0,
    'BLOCK_LABEL_KEY' => 0,
    'BLOCK_LIST' => 0,
    'BLOCK' => 0,
    'FIELD_MODEL_LIST' => 0,
    'USER_MODEL' => 0,
    'CURRENT_USER_MODEL' => 0,
    'DAY_STARTS' => 0,
    'IS_HIDDEN' => 0,
    'MODULE_NAME' => 0,
    'FIELD_MODEL' => 0,
    'TAXCLASS_DETAILS' => 0,
    'tax' => 0,
    'COUNTER' => 0,
    'WIDTHTYPE' => 0,
    'MODULE' => 0,
    'IMAGE_DETAILS' => 0,
    'IMAGE_INFO' => 0,
    'BASE_CURRENCY_SYMBOL' => 0,
    'RECORD' => 0,
    'IS_AJAX_ENABLED' => 0,
    'KITDETAILS' => 0,
    'kit' => 0,
    'GRIDINFORMATION' => 0,
    'index' => 0,
    'data' => 0,
    'datainfo' => 0,
    'PROCESSLIST' => 0,
    'pdata' => 0,
    'process_instance_list' => 0,
    'process_instance_data' => 0,
    'ps' => 0,
    'style' => 0,
    'BLOCKTYPE' => 0,
    'PROCESSFLOW_MODEL' => 0,
    'MINITS' => 0,
    'RECORD_ID' => 0,
    'cdata' => 0,
    'DOCUMENT' => 0,
    'userid' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7338be31ad4',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7338be31ad4')) {function content_5b7338be31ad4($_smarty_tpl) {?>
<style>.commentscontainer {border: 2px solid #dedede;border-radius: 5px;padding: 10px;margin: 10px 0;}.darker {border-color: #ccc;}.commentscontainer::after {content: "";clear: both;display: table;}.commentscontainer img {float: left;max-width: 60px;width: 40px;height: 33px;margin-right: 10px;border-radius: 50%;}.commentscontainer img.right {float: right;margin-left: 30px;margin-right: -7px;margin-top: 26px;}.darker h4{float: right;margin-left: -34px;margin-bottom: 43px;display: block;}.time-right {float: right;color: #aaa;}.time-left {float: left;color: #999;}.savecomment{position: relative;left: 87%;top: 4px;}.commentspanel{float: right;margin-left: 13px;min-width: 343px;width: 68%;}</style><?php  $_smarty_tpl->tpl_vars['FIELD_MODEL_LIST'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->_loop = false;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['RECORD_STRUCTURE']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->key => $_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->value){
$_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->_loop = true;
 $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value = $_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->key;
?><?php $_smarty_tpl->tpl_vars['BLOCK'] = new Smarty_variable($_smarty_tpl->tpl_vars['BLOCK_LIST']->value[$_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value], null, 0);?><?php if ($_smarty_tpl->tpl_vars['BLOCK']->value==null||count($_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->value)<=0){?><?php continue 1?><?php }?><?php $_smarty_tpl->tpl_vars['IS_HIDDEN'] = new Smarty_variable($_smarty_tpl->tpl_vars['BLOCK']->value->isHidden(), null, 0);?><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('rowheight'), null, 0);?><?php $_smarty_tpl->tpl_vars["userid"] = new Smarty_variable($_smarty_tpl->tpl_vars['CURRENT_USER_MODEL']->value->get('id'), null, 0);?><input type=hidden name="timeFormatOptions" data-value='<?php echo $_smarty_tpl->tpl_vars['DAY_STARTS']->value;?>
' /><table class="table table-bordered equalSplit detailview-table"><thead><tr><th class="blockHeader" colspan="4"><img class="cursorPointer alignMiddle blockToggle <?php if (!($_smarty_tpl->tpl_vars['IS_HIDDEN']->value)){?> hide <?php }?> "  src="<?php echo vimage_path('arrowRight.png');?>
" data-mode="hide" data-id=<?php echo $_smarty_tpl->tpl_vars['BLOCK_LIST']->value[$_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value]->get('id');?>
><img class="cursorPointer alignMiddle blockToggle <?php if (($_smarty_tpl->tpl_vars['IS_HIDDEN']->value)){?> hide <?php }?>"  src="<?php echo vimage_path('arrowDown.png');?>
" data-mode="show" data-id=<?php echo $_smarty_tpl->tpl_vars['BLOCK_LIST']->value[$_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value]->get('id');?>
>&nbsp;&nbsp;<?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['BLOCK_LABEL_KEY']->value;?>
<?php $_tmp1=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
<?php $_tmp2=ob_get_clean();?><?php echo vtranslate($_tmp1,$_tmp2);?>
</th></tr></thead><tbody <?php if ($_smarty_tpl->tpl_vars['IS_HIDDEN']->value){?> class="hide" <?php }?>><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(0, null, 0);?><tr><?php  $_smarty_tpl->tpl_vars['FIELD_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = false;
 $_smarty_tpl->tpl_vars['FIELD_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['FIELD_MODEL']->key => $_smarty_tpl->tpl_vars['FIELD_MODEL']->value){
$_smarty_tpl->tpl_vars['FIELD_MODEL']->_loop = true;
 $_smarty_tpl->tpl_vars['FIELD_NAME']->value = $_smarty_tpl->tpl_vars['FIELD_MODEL']->key;
?><?php if (!$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isViewableInDetailView()){?><?php continue 1?><?php }?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="83"){?><?php  $_smarty_tpl->tpl_vars['tax'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tax']->_loop = false;
 $_smarty_tpl->tpl_vars['count'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['TAXCLASS_DETAILS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tax']->key => $_smarty_tpl->tpl_vars['tax']->value){
$_smarty_tpl->tpl_vars['tax']->_loop = true;
 $_smarty_tpl->tpl_vars['count']->value = $_smarty_tpl->tpl_vars['tax']->key;
?><?php if ($_smarty_tpl->tpl_vars['tax']->value['check_value']==1){?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value==2){?></tr><tr><?php $_smarty_tpl->tpl_vars["COUNTER"] = new Smarty_variable(1, null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars["COUNTER"] = new Smarty_variable($_smarty_tpl->tpl_vars['COUNTER']->value+1, null, 0);?><?php }?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class='muted pull-right marginRight10px'><?php echo vtranslate($_smarty_tpl->tpl_vars['tax']->value['taxlabel'],$_smarty_tpl->tpl_vars['MODULE']->value);?>
(%)</label></td><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><span class="value"><?php echo $_smarty_tpl->tpl_vars['tax']->value['percentage'];?>
</span></td><?php }?><?php } ?><?php }elseif($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="69"||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="105"){?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value!=0){?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value==2){?></tr><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(0, null, 0);?><?php }?><?php }?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><label class="muted pull-right marginRight10px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label');?>
<?php $_tmp3=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
<?php $_tmp4=ob_get_clean();?><?php echo vtranslate($_tmp3,$_tmp4);?>
</label></td><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"><div id="imageContainer" width="300" height="200"><?php  $_smarty_tpl->tpl_vars['IMAGE_INFO'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = false;
 $_smarty_tpl->tpl_vars['ITER'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['IMAGE_DETAILS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['IMAGE_INFO']->key => $_smarty_tpl->tpl_vars['IMAGE_INFO']->value){
$_smarty_tpl->tpl_vars['IMAGE_INFO']->_loop = true;
 $_smarty_tpl->tpl_vars['ITER']->value = $_smarty_tpl->tpl_vars['IMAGE_INFO']->key;
?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
<?php $_tmp5=ob_get_clean();?><?php if (!empty($_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'])&&!empty($_tmp5)){?><img src="<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['path'];?>
_<?php echo $_smarty_tpl->tpl_vars['IMAGE_INFO']->value['orgname'];?>
" width="300" height="200"><?php }?><?php } ?></div></td><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable($_smarty_tpl->tpl_vars['COUNTER']->value+1, null, 0);?><?php }else{ ?><?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="20"||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=="19"){?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value=='1'){?><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td></tr><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(0, null, 0);?><?php }?><?php }?><?php if ($_smarty_tpl->tpl_vars['COUNTER']->value==2){?></tr><tr><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable(1, null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable($_smarty_tpl->tpl_vars['COUNTER']->value+1, null, 0);?><?php }?><?php if (($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()=='autologout_time')&&($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('is_admin')!='on')){?><td></td><?php }else{ ?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
_detailView_fieldLabel_<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()=='description'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='69'){?> style='width:8%'<?php }?>><label class="muted pull-right marginRight10px"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('label');?>
<?php $_tmp6=ob_get_clean();?><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
<?php $_tmp7=ob_get_clean();?><?php echo vtranslate($_tmp6,$_tmp7);?>
<?php if (($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='72')&&($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()=='unit_price')){?>(<?php echo $_smarty_tpl->tpl_vars['BASE_CURRENCY_SYMBOL']->value;?>
)<?php }?></label></td><?php }?><?php if (($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName()=='autologout_time')&&($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('is_admin')!='on')){?><td></td><?php }else{ ?><td class="fieldValue <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
" id="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
_detailView_fieldValue_<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getName();?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='19'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='20'){?> colspan="3" <?php $_smarty_tpl->tpl_vars['COUNTER'] = new Smarty_variable($_smarty_tpl->tpl_vars['COUNTER']->value+1, null, 0);?> <?php }?>><span class="value" data-field-type="<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType();?>
" <?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='19'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='20'||$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')=='21'){?> style="white-space:normal;" <?php }?>><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getDetailViewTemplateName(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['FIELD_MODEL']->value,'USER_MODEL'=>$_smarty_tpl->tpl_vars['USER_MODEL']->value,'MODULE'=>$_smarty_tpl->tpl_vars['MODULE_NAME']->value,'RECORD'=>$_smarty_tpl->tpl_vars['RECORD']->value), 0);?>
</span><?php if ($_smarty_tpl->tpl_vars['IS_AJAX_ENABLED']->value&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isEditable()=='true'&&($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()!=Vtiger_Field_Model::REFERENCE_TYPE)&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->isAjaxEditable()=='true'){?><span class="hide edit"><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getUITypeModel()->getTemplateName(),$_smarty_tpl->tpl_vars['MODULE_NAME']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array('FIELD_MODEL'=>$_smarty_tpl->tpl_vars['FIELD_MODEL']->value,'USER_MODEL'=>$_smarty_tpl->tpl_vars['USER_MODEL']->value,'MODULE'=>$_smarty_tpl->tpl_vars['MODULE_NAME']->value), 0);?>
<?php if ($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getFieldDataType()=='multipicklist'){?><input type="hidden" class="fieldname" value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
[]' data-prev-value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue'));?>
' /><?php }else{ ?><input type="hidden" class="fieldname" value='<?php echo $_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name');?>
' data-prev-value='<?php echo Vtiger_Util_Helper::toSafeHTML($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->getDisplayValue($_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('fieldvalue')));?>
' /><?php }?></span><?php }?></td><?php }?><?php }?><?php if (count($_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->value)==1&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="19"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="20"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="30"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('name')!="recurringtype"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="69"&&$_smarty_tpl->tpl_vars['FIELD_MODEL']->value->get('uitype')!="105"){?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><?php }?><?php } ?><?php if (end($_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->value)==true&&count($_smarty_tpl->tpl_vars['FIELD_MODEL_LIST']->value)!=1&&$_smarty_tpl->tpl_vars['COUNTER']->value==1){?><td class="fieldLabel <?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
"></td><?php }?></tr></tbody></table><br><?php } ?><?php if ($_smarty_tpl->tpl_vars['KITDETAILS']->value['ckymotype']){?><?php $_smarty_tpl->tpl_vars["kit"] = new Smarty_variable($_smarty_tpl->tpl_vars['KITDETAILS']->value['kid'], null, 0);?><table class="table table-bordered equalSplit"><thead><tr><th class="" colspan="4"><img class="cursorPointer alignMiddle blockToggle <?php if (($_smarty_tpl->tpl_vars['IS_HIDDEN']->value)){?> hide <?php }?>"  src="<?php echo vimage_path('arrowDown.png');?>
" data-mode="show"  >&nbsp;&nbsp; Phylos Bioscience Genetic Info widget</th></tr></thead><tbody><tr><td><iframe width="600" height="600" scrolling="no" frameborder="0" allowtransparency="true" src="https://dataviz.phylosbioscience.com/seal/?size=600&id=<?php echo $_smarty_tpl->tpl_vars['kit']->value;?>
&bkgd=ffffff"></iframe></td></tr></tbody></table><?php }?><?php if ($_smarty_tpl->tpl_vars['GRIDINFORMATION']->value){?><?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['GRIDINFORMATION']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['data']->key;
?><table class="table table-bordered equalSplit"><thead><tr class="blockHeader"><th  colspan="6" style="border-bottom: 1px solid #ddd;"><?php echo $_smarty_tpl->tpl_vars['index']->value;?>
</th></tr></thead><tbody><tr><th class="" colspan="">Product Category</th><th class="" colspan="">Product Name</th><th class="" colspan="">Present Stock</th><th class="" colspan="">Issued Qty</th><th class="" colspan="">Issued By</th><th class="" colspan="">Remarks</th></tr><?php  $_smarty_tpl->tpl_vars['datainfo'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['datainfo']->_loop = false;
 $_smarty_tpl->tpl_vars['id'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['data']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['datainfo']->key => $_smarty_tpl->tpl_vars['datainfo']->value){
$_smarty_tpl->tpl_vars['datainfo']->_loop = true;
 $_smarty_tpl->tpl_vars['id']->value = $_smarty_tpl->tpl_vars['datainfo']->key;
?><tr><td class="" colspan=""><?php echo $_smarty_tpl->tpl_vars['datainfo']->value['productcategory'];?>
</td><td class="" colspan=""><?php echo $_smarty_tpl->tpl_vars['datainfo']->value['productname'];?>
</td><td class="" colspan=""><?php echo $_smarty_tpl->tpl_vars['datainfo']->value['prasentqty'];?>
</td><td class="" colspan=""><?php echo $_smarty_tpl->tpl_vars['datainfo']->value['issuedqty'];?>
</td><td class="" colspan=""><?php echo $_smarty_tpl->tpl_vars['datainfo']->value['fullname'];?>
</td><td class="" colspan=""><?php echo $_smarty_tpl->tpl_vars['datainfo']->value['remarks'];?>
</td></tr><?php } ?></tbody></table><br><?php } ?><?php }?><!--Accordion wrapper--><?php if ($_smarty_tpl->tpl_vars['PROCESSLIST']->value){?><div class="accordion" id="accordion2"><?php  $_smarty_tpl->tpl_vars['pdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pdata']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROCESSLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pdata']->key => $_smarty_tpl->tpl_vars['pdata']->value){
$_smarty_tpl->tpl_vars['pdata']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['pdata']->key;
?><?php $_smarty_tpl->tpl_vars["customform"] = new Smarty_variable($_smarty_tpl->tpl_vars['pdata']->value['customform'], null, 0);?><?php $_smarty_tpl->tpl_vars['process_instance_data'] = new Smarty_variable($_smarty_tpl->tpl_vars['process_instance_list']->value[$_smarty_tpl->tpl_vars['index']->value], null, 0);?><?php $_smarty_tpl->tpl_vars["ps"] = new Smarty_variable($_smarty_tpl->tpl_vars['process_instance_data']->value['process_status'], null, 0);?><?php $_smarty_tpl->tpl_vars["style"] = new Smarty_variable('', null, 0);?><?php if ($_smarty_tpl->tpl_vars['ps']->value==1){?><?php $_smarty_tpl->tpl_vars["style"] = new Smarty_variable("font-size: 20px;color: #f89406;border: 4px solid #f89406;border-radius: 5px;", null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['ps']->value==2){?><?php $_smarty_tpl->tpl_vars["style"] = new Smarty_variable("font-size: 20px;color: #356635;border: 4px solid #356635;border-radius: 5px;", null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['ps']->value==3){?><?php $_smarty_tpl->tpl_vars["style"] = new Smarty_variable("font-size: 20px;color: #49afcd;border: 4px solid #49afcd;border-radius: 5px;", null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['ps']->value==4){?><?php $_smarty_tpl->tpl_vars["style"] = new Smarty_variable("font-size: 20px;color: #0088cc;border: 4px solid #0088cc;border-radius: 5px;", null, 0);?><?php }elseif($_smarty_tpl->tpl_vars['ps']->value==5){?><?php $_smarty_tpl->tpl_vars["style"] = new Smarty_variable("font-size: 20px;color: #f44336;border: 4px solid #f44336;border-radius: 5px;", null, 0);?><?php }?><div class="accordion-group"><div class="accordion-heading"><a class="accordion-toggle" data-toggle="collapse" style="<?php echo $_smarty_tpl->tpl_vars['style']->value;?>
" data-parent="#accordion2" href="#collapse<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
"><img src="assets/icons/<?php if ($_smarty_tpl->tpl_vars['pdata']->value['customicon']==null){?><?php echo $_smarty_tpl->tpl_vars['BLOCKTYPE']->value[$_smarty_tpl->tpl_vars['pdata']->value['blocktype']];?>
<?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['pdata']->value['customicon'];?>
<?php }?>"  style='width:30px;' /><strong > <?php echo $_smarty_tpl->tpl_vars['pdata']->value['description'];?>
<br></strong></a></div><div id="collapse<?php echo $_smarty_tpl->tpl_vars['index']->value;?>
" class="accordion-body collapse <?php if ($_smarty_tpl->tpl_vars['ps']->value==1||$_smarty_tpl->tpl_vars['ps']->value==3||$_smarty_tpl->tpl_vars['ps']->value==4){?>in<?php }?>"><div class="accordion-inner"><table width="100%" style="border:0px solid gray;"><tbody><tr><td width="" class="span3"><?php if ($_smarty_tpl->tpl_vars['pdata']->value['unitprocess_time']){?><?php $_smarty_tpl->tpl_vars['MINITS'] = new Smarty_variable($_smarty_tpl->tpl_vars['PROCESSFLOW_MODEL']->value->getHoursMints($_smarty_tpl->tpl_vars['pdata']->value['unitprocess_time']), null, 0);?><p class='bold'>Process Time(HH:MM) : <?php echo $_smarty_tpl->tpl_vars['MINITS']->value;?>
</p><?php }?><?php if ($_smarty_tpl->tpl_vars['process_instance_data']->value['start_time']){?><p class="bold">Start Time : <?php echo $_smarty_tpl->tpl_vars['process_instance_data']->value['start_time'];?>
</p><?php }?><?php if ($_smarty_tpl->tpl_vars['process_instance_data']->value['end_time']){?><p class="bold">End Time : <?php echo $_smarty_tpl->tpl_vars['process_instance_data']->value['end_time'];?>
 </p><?php }?><?php if ($_smarty_tpl->tpl_vars['pdata']->value['assignedto']){?><p class="bold">Assigned to: <?php echo $_smarty_tpl->tpl_vars['pdata']->value['assignedto'];?>
<b></b></p><?php }?></td><td width="" class="span3"><p class="clsPLrnMode"></p><?php  $_smarty_tpl->tpl_vars['cdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cdata']->_loop = false;
 $_smarty_tpl->tpl_vars['sindex'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROCESSFLOW_MODEL']->value->getCustomFormInfo($_smarty_tpl->tpl_vars['pdata']->value['processmasterid'],$_smarty_tpl->tpl_vars['pdata']->value['unitprocessid'],$_smarty_tpl->tpl_vars['RECORD_ID']->value); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cdata']->key => $_smarty_tpl->tpl_vars['cdata']->value){
$_smarty_tpl->tpl_vars['cdata']->_loop = true;
 $_smarty_tpl->tpl_vars['sindex']->value = $_smarty_tpl->tpl_vars['cdata']->key;
?><form id="myform119" name="myform119" method="POST" enctype="multipart/form-data" class="ui-dform-form"><div class="ui-dform-div"><label for="<?php echo $_smarty_tpl->tpl_vars['cdata']->value['name'];?>
" class="ui-dform-label"><?php echo $_smarty_tpl->tpl_vars['cdata']->value['caption'];?>
 :<?php if ($_smarty_tpl->tpl_vars['cdata']->value['type']=="checkbox"){?><?php if ($_smarty_tpl->tpl_vars['cdata']->value['value']=="on"){?>yes<?php }else{ ?>no<?php }?><?php }else{ ?><?php echo $_smarty_tpl->tpl_vars['cdata']->value['value'];?>
<?php }?><?php if ($_smarty_tpl->tpl_vars['pdata']->value['blocktype']==3){?><?php if ($_smarty_tpl->tpl_vars['DOCUMENT']->value[$_smarty_tpl->tpl_vars['pdata']->value['unitprocessid']]['documentid']&&$_smarty_tpl->tpl_vars['cdata']->value['type']=="file"){?>files<a href="index.php?module=Documents&view=Detail&record=<?php echo $_smarty_tpl->tpl_vars['DOCUMENT']->value[$_smarty_tpl->tpl_vars['pdata']->value['unitprocessid']]['documentid'];?>
" target="_blank"><i class="icon-file"></i></a><?php }?><?php }?></label></div></form><?php } ?></td><td width="" class="span3" id=""><div class='commentsdiv' style="max-height:300px;overflow: auto;"><?php  $_smarty_tpl->tpl_vars['cdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cdata']->_loop = false;
 $_smarty_tpl->tpl_vars['index'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROCESSFLOW_MODEL']->value->getProcessFlowComments($_smarty_tpl->tpl_vars['pdata']->value['unitprocessid'],$_smarty_tpl->tpl_vars['RECORD_ID']->value); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cdata']->key => $_smarty_tpl->tpl_vars['cdata']->value){
$_smarty_tpl->tpl_vars['cdata']->_loop = true;
 $_smarty_tpl->tpl_vars['index']->value = $_smarty_tpl->tpl_vars['cdata']->key;
?><div class="commentscontainer <?php if ($_smarty_tpl->tpl_vars['userid']->value!=$_smarty_tpl->tpl_vars['cdata']->value['id']){?>darker<?php }?>"><h4><?php echo $_smarty_tpl->tpl_vars['cdata']->value['user_name'];?>
</h4><img src="<?php if ($_smarty_tpl->tpl_vars['cdata']->value['imagename']!=''){?><?php echo $_smarty_tpl->tpl_vars['cdata']->value['imagepath'];?>
<?php echo $_smarty_tpl->tpl_vars['cdata']->value['attachmentsid'];?>
_<?php echo $_smarty_tpl->tpl_vars['cdata']->value['imagename'];?>
<?php }else{ ?>layouts/vlayout/skins/images/DefaultUserIcon.png<?php }?>" alt="Avatar" class="<?php if ($_smarty_tpl->tpl_vars['userid']->value!=$_smarty_tpl->tpl_vars['cdata']->value['id']){?>right<?php }?>"><p><?php echo $_smarty_tpl->tpl_vars['cdata']->value['comments'];?>
</p><span class="time-<?php if ($_smarty_tpl->tpl_vars['userid']->value!=$_smarty_tpl->tpl_vars['cdata']->value['id']){?>left<?php }else{ ?>right<?php }?>"><?php echo date("H:i",$_smarty_tpl->tpl_vars['cdata']->value['date_time']);?>
</span></div><?php } ?></div></td></tr></tbody></table></div></div></div><?php } ?></div><?php }?>
<?php }} ?>