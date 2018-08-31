<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 21:35:28
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Emails/EmailPreview.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6317935535b773fa019f183-33790389%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2697dad984fb49c120d1b6819326a4eaaf8675b0' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Emails/EmailPreview.tpl',
      1 => 1467869303,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6317935535b773fa019f183-33790389',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PARENT_RECORD' => 0,
    'RECORD_ID' => 0,
    'MODULE' => 0,
    'RECORD' => 0,
    'FROM' => 0,
    'TO' => 0,
    'TO_EMAILS' => 0,
    'CC' => 0,
    'BCC' => 0,
    'ATTACHMENT_DETAILS' => 0,
    'MAIL_DATE' => 0,
    'SEND_TIME' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b773fa022c28',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b773fa022c28')) {function content_5b773fa022c28($_smarty_tpl) {?>
<div class="SendEmailFormStep2" name="emailPreview"><input type="hidden" name="parentRecord" value="<?php echo $_smarty_tpl->tpl_vars['PARENT_RECORD']->value;?>
"/><input type="hidden" name="recordId" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
"/><br><div class="well well-large zeroPaddingAndMargin"><div class="modal-header blockHeader emailPreviewHeader" style="height:30px"><h3 class='span4'><?php echo vtranslate('SINGLE_Emails',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 <?php echo vtranslate('LBL_INFO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</h3><div class='pull-right'><span class="btn-toolbar"><span class="btn-group"><button type="button" name="previewForward" class="btn" data-mode="emailForward"><strong><?php echo vtranslate('LBL_FORWARD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span><?php if (!($_smarty_tpl->tpl_vars['RECORD']->value->isSentMail())){?><span class="btn-group"><button type="button" name="previewEdit" class="btn" data-mode="emailEdit"><strong><?php echo vtranslate('LBL_EDIT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span><?php }?><span class="btn-group"><button type="button" name="previewPrint" class="btn" data-mode="previewPrint"><strong><?php echo vtranslate('LBL_PRINT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></button></span></span></div></div><form class="form-horizontal emailPreview" method="POST"><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_FROM',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><span class="row-fluid"><?php echo $_smarty_tpl->tpl_vars['FROM']->value;?>
</span></span></span></div><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_TO',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><?php if (empty($_smarty_tpl->tpl_vars['TO']->value)){?><?php $_smarty_tpl->tpl_vars['TO'] = new Smarty_variable(array(), null, 0);?><?php }?><?php $_smarty_tpl->tpl_vars['TO_EMAILS'] = new Smarty_variable(implode(",",$_smarty_tpl->tpl_vars['TO']->value), null, 0);?><span class="row-fluid"><?php echo $_smarty_tpl->tpl_vars['TO_EMAILS']->value;?>
</span></span></span></div><?php if (!empty($_smarty_tpl->tpl_vars['CC']->value)){?><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_CC',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><span class="row-fluid"><?php echo $_smarty_tpl->tpl_vars['CC']->value;?>
</span></span></span></div><?php }?><?php if (!empty($_smarty_tpl->tpl_vars['BCC']->value)){?><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_BCC',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><span class="row-fluid"><?php echo $_smarty_tpl->tpl_vars['BCC']->value;?>
</span></span></span></div><?php }?><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_SUBJECT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><span class="row-fluid"><?php echo $_smarty_tpl->tpl_vars['RECORD']->value->get('subject');?>
</span></span></span></div><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_ATTACHMENT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><span class="row-fluid"><?php  $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RECORD']->value->getAttachmentDetails(); if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->key => $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->value){
$_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->_loop = true;
?><a &nbsp;<?php if (array_key_exists('docid',$_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->value)){?>&nbsp; href="index.php?module=Documents&action=DownloadFile&record=<?php echo $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->value['docid'];?>
&fileid=<?php echo $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->value['fileid'];?>
"<?php }else{ ?>&nbsp; href="index.php?module=Emails&action=DownloadFile&attachment_id=<?php echo $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->value['fileid'];?>
"<?php }?>><?php echo $_smarty_tpl->tpl_vars['ATTACHMENT_DETAILS']->value['attachment'];?>
</a>&nbsp;&nbsp;<?php } ?></span></span></span></div><div class="row-fluid padding-bottom1per"><span class="span12 row-fluid"><span class="span2"><span class="pull-right muted"><?php echo vtranslate('LBL_DESCRIPTION',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</span></span><span class="span9"><span class="row-fluid"><?php echo decode_html($_smarty_tpl->tpl_vars['RECORD']->value->get('description'));?>
</span></span></span></div><div class="row-fluid"><span class="span1">&nbsp;</span><span class="span10 margin0px"><hr/></span></div><div class="row-fluid"><span class="span4">&nbsp;</span><span class="span4 textAlignCenter"><span class="muted"><?php if ($_smarty_tpl->tpl_vars['RECORD']->value->get('email_flag')=="SAVED"){?><small><em><?php echo vtranslate('LBL_DRAFTED_ON',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</em></small><span><small><em>&nbsp;<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString($_smarty_tpl->tpl_vars['RECORD']->value->get('createdtime'));?>
</em></small></span><?php }elseif($_smarty_tpl->tpl_vars['RECORD']->value->get('email_flag')=="MailManager"){?><small><em><?php echo vtranslate('LBL_MAIL_DATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 : </em></small><?php $_smarty_tpl->tpl_vars["MAIL_DATE"] = new Smarty_variable((($_smarty_tpl->tpl_vars['RECORD']->value->get('date_start')).(' ')).($_smarty_tpl->tpl_vars['RECORD']->value->get('time_start')), null, 0);?><span><small><em>&nbsp;<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString($_smarty_tpl->tpl_vars['MAIL_DATE']->value);?>
</em></small></span><?php }else{ ?><small><em><?php echo vtranslate('LBL_SENT_ON',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</em></small><?php $_smarty_tpl->tpl_vars["SEND_TIME"] = new Smarty_variable((($_smarty_tpl->tpl_vars['RECORD']->value->get('date_start')).(' ')).($_smarty_tpl->tpl_vars['RECORD']->value->get('time_start')), null, 0);?><span><small><em>&nbsp;<?php echo Vtiger_Util_Helper::formatDateTimeIntoDayString($_smarty_tpl->tpl_vars['SEND_TIME']->value);?>
</em></small></span><?php }?></span></span></div><div class="row-fluid"><span class="span3">&nbsp;</span><span class="span5 textAlignCenter"><span><strong> <?php echo vtranslate('LBL_OWNER',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 : <?php echo getOwnerName($_smarty_tpl->tpl_vars['RECORD']->value->get('assigned_user_id'));?>
</strong></span></span></div></form></div></div><?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('JSResources.tpl'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>
<?php }} ?>