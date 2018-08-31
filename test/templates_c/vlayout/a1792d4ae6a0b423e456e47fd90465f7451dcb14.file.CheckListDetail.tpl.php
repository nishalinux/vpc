<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 09:17:49
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2CheckList/CheckListDetail.tpl" */ ?>
<?php /*%%SmartyHeaderCode:3458590125b77dafc0f2527-50535322%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a1792d4ae6a0b423e456e47fd90465f7451dcb14' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2CheckList/CheckListDetail.tpl',
      1 => 1534583851,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '3458590125b77dafc0f2527-50535322',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77dafc15504',
  'variables' => 
  array (
    'recordId' => 0,
    'checklistname' => 0,
    'Array' => 0,
    'CATEGORY' => 0,
    'COUNTS' => 0,
    'checklistid' => 0,
    'LIST' => 0,
    'TITLE' => 0,
    'COMMENT' => 0,
    'CDATA' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77dafc15504')) {function content_5b77dafc15504($_smarty_tpl) {?>
<style>

    #vte-checklist-details{
        width: 900px;
        height: 500px;
        padding: 10px 10px;
        overflow-y: auto;
		 background-color: #fcf8e3;
    }
	#vte-checklist-details .item-note-add{
        display: none;
    }
    #vte-checklist-details .upload-file,
    #vte-checklist-details .add-note,
    #vte-checklist-details .show-all-notes{
        text-decoration: underline;
    }
	
.panel-pricing {
  -moz-transition: all .3s ease;
  -o-transition: all .3s ease;
  -webkit-transition: all .3s ease;
}
.panel-pricing:hover {
  box-shadow: 0px 0px 30px rgba(0, 0, 0, 0.2);
}

.panel-pricing .list-group-item {
  color: #777777;
  border-bottom: 1px solid rgba(250, 250, 250, 0.5);
}
.panel-pricing .list-group-item:last-child {
  border-bottom-right-radius: 0px;
  border-bottom-left-radius: 0px;
}
.panel-pricing .list-group-item:first-child {
  border-top-right-radius: 0px;
  border-top-left-radius: 0px;
}
.panel-pricing .panel-body {
  background-color: #f0f0f0;
  font-size: 40px;
  color: #777777;
  padding: 20px;
  margin: 0px;
}
.panel-warning{
border-color: #faebcc;
}
.panel-pricing{
  
}

</style>

<div class="modelContainer" id="vte-checklist-details"><input type="hidden" name="curr_date" value=""><input type="hidden" name="curr_time" value=""><input type="hidden" name="accountid" id="accountid" value="<?php echo $_smarty_tpl->tpl_vars['recordId']->value;?>
"><div class="col-md-4 text-center" style=" background-color: #fcf8e3;"><center><i class="fa fa-desktop"></i><h2 style="color:brown;"><?php echo $_smarty_tpl->tpl_vars['checklistname']->value;?>
</h2></center></div><?php  $_smarty_tpl->tpl_vars['CATEGORY'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['CATEGORY']->_loop = false;
 $_smarty_tpl->tpl_vars['COUNTS'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['Array']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['CATEGORY']->key => $_smarty_tpl->tpl_vars['CATEGORY']->value){
$_smarty_tpl->tpl_vars['CATEGORY']->_loop = true;
 $_smarty_tpl->tpl_vars['COUNTS']->value = $_smarty_tpl->tpl_vars['CATEGORY']->key;
?><!--<?php  $_smarty_tpl->tpl_vars['ITEM'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ITEM']->_loop = false;
 $_smarty_tpl->tpl_vars['COUNT'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CATEGORY']->value['tit']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->key => $_smarty_tpl->tpl_vars['ITEM']->value){
$_smarty_tpl->tpl_vars['ITEM']->_loop = true;
 $_smarty_tpl->tpl_vars['COUNT']->value = $_smarty_tpl->tpl_vars['ITEM']->key;
?>--><div class=""><table width="100%" class="table" style="border-color:#faebcc;"><tr class="panel panel-warning panel-pricing"><div class="fa fa-desktop"><h3><?php echo $_smarty_tpl->tpl_vars['CATEGORY']->value['cat'];?>
</h3></div><td width="3%" valign="top"></td><td width="52%" valign="top"><div class="checklist-item-header"><div class="checklist-item-title"><center><h4><?php echo $_smarty_tpl->tpl_vars['CATEGORY']->value['tit'];?>
</h4></center></div></div><div class="list-group text-center"><div class="list-group-item"><span style="font-family:'Open Sans', Arial, sans-serif;font-size:14px;text-align:justify;"><?php echo $_smarty_tpl->tpl_vars['CATEGORY']->value['desc'];?>
</span></div><!--<pre><?php echo print_r($_smarty_tpl->tpl_vars['Array']->value);?>
</pre><?php echo '-----';?>
<?php echo $_smarty_tpl->tpl_vars['COUNTS']->value;?>
--></div></td><td width="50%"><div class="checklist-item-related"><?php if ($_smarty_tpl->tpl_vars['CATEGORY']->value['notes']==1){?><div class="document-related"><form action="index.php?module=Documents&action=SaveAjax&count=<?php echo $_smarty_tpl->tpl_vars['COUNTS']->value;?>
" method="post" class="checklist-upload-form" enctype="multipart/form-data"><input type="hidden" name="module" value="Documents"><input type="hidden" name="action" value="SaveAjax"><input type="hidden" name="sourceModule" value="Accounts"><input type="hidden" name="sourceRecord" id= "checklistid" value="<?php echo $_smarty_tpl->tpl_vars['checklistid']->value;?>
"><input type="hidden" name="relationOperation" value="true"><input type="hidden" name="notes_title" value=""><input type="hidden" name="filelocationtype" value="I"><input type="file" name="filename" class="add-document" ><input type="hidden" name="sequence" id="sequence" value="<?php echo $_smarty_tpl->tpl_vars['COUNTS']->value;?>
" ><div class="checklist-item-documents"><ul class="nav nav-tabs nav-stacked"><?php  $_smarty_tpl->tpl_vars['TITLE'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['TITLE']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['LIST']->value[$_smarty_tpl->tpl_vars['COUNTS']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['TITLE']->key => $_smarty_tpl->tpl_vars['TITLE']->value){
$_smarty_tpl->tpl_vars['TITLE']->_loop = true;
?><li><a href="index.php?module=Documents&action=DownloadFile&record=<?php echo $_smarty_tpl->tpl_vars['TITLE']->value['notesid'];?>
&fileid="><?php echo $_smarty_tpl->tpl_vars['TITLE']->value['title'];?>
<span class="relationDelete pull-right" data-record="<?php echo $_smarty_tpl->tpl_vars['checklistid']->value;?>
" data-related-record="<?php echo $_smarty_tpl->tpl_vars['TITLE']->value['notesid'];?>
"><i title="Delete" class="icon-trash alignMiddle"></i></span></a></li><?php } ?></ul></div></form></div><?php }?><?php if ($_smarty_tpl->tpl_vars['CATEGORY']->value['comments']==1){?><div class="comment-related"><div class="item-note-box"><a class="add-note" href="javascript:void(0);"><?php echo 'Add Note';?>
</a><div class="item-note-add" ><textarea class="item-note-content" placeholder="Add your comment here..."></textarea></br><button class="btn btn-success add-comment" type="button" name="submit<?php echo $_smarty_tpl->tpl_vars['COUNTS']->value;?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['checklistid']->value;?>
"><strong>Submit</strong></button></div><div class="item-note-list"><ul class="commentContainer"><?php  $_smarty_tpl->tpl_vars['CDATA'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['CDATA']->_loop = false;
 $_smarty_tpl->tpl_vars['foo'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['COMMENT']->value[$_smarty_tpl->tpl_vars['COUNTS']->value]; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['CDATA']->key => $_smarty_tpl->tpl_vars['CDATA']->value){
$_smarty_tpl->tpl_vars['CDATA']->_loop = true;
 $_smarty_tpl->tpl_vars['foo']->value = $_smarty_tpl->tpl_vars['CDATA']->key;
?><li class="commentDetails"><p><?php echo $_smarty_tpl->tpl_vars['CDATA']->value['comment_content'];?>
</p><p><small><?php echo $_smarty_tpl->tpl_vars['CDATA']->value['username'];?>
 | <?php echo $_smarty_tpl->tpl_vars['CDATA']->value['time'];?>
</small></p></li><?php } ?></ul></div></div></div><?php }?></div></td></tr></tbody></table><!--<?php } ?>--></div><?php } ?></div>
<script src="http://malsup.github.com/jquery.form.js"></script>
<script src='jquery.form.js' type="text/javascript" language="javascript"></script>

<?php }} ?>