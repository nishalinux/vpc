<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 06:13:42
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ChecklistItems/ChecklistDetails.tpl" */ ?>
<?php /*%%SmartyHeaderCode:10309810765b77b916676976-42339146%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '92a17bd818bd23af07ec32cd158148c6e431c108' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ChecklistItems/ChecklistDetails.tpl',
      1 => 1507143463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '10309810765b77b916676976-42339146',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CURR_DATE' => 0,
    'CURR_TIME' => 0,
    'COUNT_ITEM' => 0,
    'CHECKLIST_ITEMS' => 0,
    'CATEGORYNAME' => 0,
    'ITEMS' => 0,
    'ITEM' => 0,
    'CURR_USER_MODEL' => 0,
    'DOCUMENT' => 0,
    'COMMENT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77b9166f068',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77b9166f068')) {function content_5b77b9166f068($_smarty_tpl) {?>
<style>
    .blockUI{
        top: 10px !important;
    }
    #vte-checklist-details{
        width: 1024px;
        height: 600px;
        padding: 10px 10px;
        overflow-y: auto;
    }
    #vte-checklist-details h3{
        text-align: center;
        font-size: 26px;
        color: #288ebe;
        padding: 0;
        margin-top: 15px;
        overflow: hidden;
    }
    #vte-checklist-details h3:before,
    #vte-checklist-details h3:after {
        background-color: #288ebe;
        content: "";
        display: inline-block;
        height: 1px;
        position: relative;
        vertical-align: middle;
        width: 50%;
    }
    #vte-checklist-details h3:before {
        right: 0.5em;
        margin-left: -50%;
    }
    #vte-checklist-details h3:after {
        left: 0.5em;
        margin-right: -50%;
    }

    #vte-checklist-details .checklist-item{
        display: block;
        padding: 10px 0 0 0;
    }
    #vte-checklist-details .checklist-item-header,
    #vte-checklist-details .checklist-item-content{
        display: block;
        overflow: hidden;
    }
    #vte-checklist-details .checklist-item-title{
        display: block;
        width: 400px;
        color: #40aad2;
        font-size: 14px;
    }
    #vte-checklist-details .checklist-item-date{
        display: block;
        width: 300px;
        color: #40aad2;
        font-style: italic;
    }
    #vte-checklist-details .checklist-item-date input.input-small{
        width: 90px;
    }
    #vte-checklist-details .checklist-item-date div.date,
    #vte-checklist-details .checklist-item-date div.time{
        display: inline;
        float: right;
    }
    #vte-checklist-details .checklist-item-status{
        display: none;
    }
    #vte-checklist-details .checklist-item-status-btn{
        width: 16px;
        height: 16px;
        display: block;
        margin-top: 15px;
    }
    #vte-checklist-details .checklist-item-status-btn{
        background: url('layouts/vlayout/modules/ChecklistItems/resources/uncheck.png') no-repeat top left;
        cursor: pointer;
    }
    #vte-checklist-details .checklist-item-status-iconChecked{
        background: url('layouts/vlayout/modules/ChecklistItems/resources/checked.png') no-repeat top left;
    }
    #vte-checklist-details .checklist-item-status-iconExcl{
        background: url('layouts/vlayout/modules/ChecklistItems/resources/exclamation.png') no-repeat top left;
    }
    #vte-checklist-details .checklist-item-status-iconQ{
        background: url('layouts/vlayout/modules/ChecklistItems/resources/question.png') no-repeat top left;
    }
    #vte-checklist-details .checklist-item-status-iconX{
        background: url('layouts/vlayout/modules/ChecklistItems/resources/cancel.png') no-repeat top left;
    }
    #vte-checklist-details .checklist-item-header{
        padding-top: 15px;
    }
    #vte-checklist-details .checklist-item-date{
        margin-top: -10px;
    }
    #vte-checklist-details .checklist-item-date input{
        border-top: none;
        box-shadow: none;
        border-right: none;
        border-left: none;
    }
    #vte-checklist-details .progress{
        display: none;
        margin: 0;
    }
    #vte-checklist-details .percent{
        margin-top: -18px;
    }
    #vte-checklist-details .nav-tabs:first-child{
        margin-bottom: 5px;
        margin-top: 5px;
    }
    #vte-checklist-details .item-note-add{
        display: none;
    }
    #vte-checklist-details .upload-file,
    #vte-checklist-details .add-note,
    #vte-checklist-details .show-all-notes{
        text-decoration: underline;
    }
    #vte-checklist-details .item-note-list{
        margin-top: 5px;
    }
    #vte-checklist-details .item-note-list li{
        display: none;
        list-style: none;
    }
    #vte-checklist-details .item-note-list li:first-child{
        display: block;
    }
    #vte-checklist-details .item-note-list p{
        margin: 0;
    }
    #vte-checklist-details .commentContainer{
        margin: 0;
    }
    #vte-checklist-details .add-document{
        margin: 0;
        padding: 0;
        height: 24px;
        line-height: 24px;
        display: none;
    }
    #vte-checklist-details .checklist-item-related{
        display: block;
        overflow: hidden;
        margin-top: 10px;
    }
    #vte-checklist-details .document-related{
        display: inline-block;
        width: 30%;
        float: left;
    }
    #vte-checklist-details .comment-related{
        display: inline-block;
        width: 65%;
        float: right;
    }

</style>
<script src="libraries/jquery/jquery.form.js" type="text/javascript"></script>
<div class="container-fluid" id="vte-checklist-details">
    <input type="hidden" name="curr_date" value="<?php echo $_smarty_tpl->tpl_vars['CURR_DATE']->value;?>
" />
    <input type="hidden" name="curr_time" value="<?php echo $_smarty_tpl->tpl_vars['CURR_TIME']->value;?>
" />
    <span class="ui-helper-hidden-accessible"><input type="text"/></span>
    <?php if ($_smarty_tpl->tpl_vars['COUNT_ITEM']->value>0){?>
        <?php  $_smarty_tpl->tpl_vars['ITEMS'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ITEMS']->_loop = false;
 $_smarty_tpl->tpl_vars['CATEGORYNAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CHECKLIST_ITEMS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ITEMS']->key => $_smarty_tpl->tpl_vars['ITEMS']->value){
$_smarty_tpl->tpl_vars['ITEMS']->_loop = true;
 $_smarty_tpl->tpl_vars['CATEGORYNAME']->value = $_smarty_tpl->tpl_vars['ITEMS']->key;
?>
            <div class="checklist-name"><h3><a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['CATEGORYNAME']->value;?>
</a></h3></div>
            <?php  $_smarty_tpl->tpl_vars['ITEM'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['ITEM']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ITEMS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['ITEM']->key => $_smarty_tpl->tpl_vars['ITEM']->value){
$_smarty_tpl->tpl_vars['ITEM']->_loop = true;
?>
                <div class="checklist-item" data-record="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
" id="checklist-item<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
">
                    <table width="100%">
                        <tr>
                            <td width="3%" valign="top">
                                <span data-status="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitem_status'];?>
" class="checklist-item-status-btn checklist-item-status-icon<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitem_status'];?>
">&nbsp;</span>
                            </td>
                            <td width="97%" valign="top">
                                <div class="checklist-item-header">
                                    <div class="pull-left checklist-item-title">
                                        <a href="javascript:void(0);"><?php echo $_smarty_tpl->tpl_vars['ITEM']->value['title'];?>
</a>
                                    </div>
                                    <div class="pull-right checklist-item-date">
                                        <div class="input-append time">
                                            <input type="text" placeholder="<?php echo vtranslate('INPUT_TIME','ChecklistItems');?>
" name="checklist_item_time" data-format="<?php echo $_smarty_tpl->tpl_vars['CURR_USER_MODEL']->value->get('hour_format');?>
" class="timepicker-default input-small ui-timepicker-input" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['status_time_display'];?>
" autocomplete="off">
                                            
                                        </div>
                                        <div class="date">
                                            <input type="text" placeholder="<?php echo vtranslate('INPUT_DATE','ChecklistItems');?>
" class="dateField input-small" name="checklist_item_date" data-date-format="<?php echo $_smarty_tpl->tpl_vars['CURR_USER_MODEL']->value->get('date_format');?>
" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['status_date_display'];?>
" >
                                            
                                        </div>
                                    </div>
                                </div>
                                <div class="checklist-item-content">
                                    <div class="checklist-item-desc">
                                        <?php echo $_smarty_tpl->tpl_vars['ITEM']->value['description'];?>

                                    </div>
                                    <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['allow_upload']==1||$_smarty_tpl->tpl_vars['ITEM']->value['allow_note']==1){?>
                                    <div class="checklist-item-related">
                                        <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['allow_upload']==1){?>
                                            <div id="document-related<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
" class="document-related">
                                                <form action="index.php?module=Documents&action=SaveAjax" method="post" class="checklist-upload-form" enctype="multipart/form-data">
                                                    <input type="hidden" name="module" value="Documents">
                                                    <input type="hidden" name="action" value="SaveAjax">
                                                    <input type="hidden" name="sourceModule" value="ChecklistItems">
                                                    <input type="hidden" name="sourceRecord" value="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
">
                                                    <input type="hidden" name="relationOperation" value="true">
                                                    <input type="hidden" name="notes_title" value="">
                                                    <input type="hidden" name="filelocationtype" value="I">
                                                    <input type="file" name="filename" class="add-document"/>
                                                    <a class="upload-file" href="javascript:void(0);">
                                                        <?php echo vtranslate('UPLOAD_FILE','ChecklistItems');?>

                                                    </a>
                                                    <div class="progress progress-striped active">
                                                        <div class="bar"></div >
                                                        <div class="percent">0%</div >
                                                    </div>

                                                    <div class="checklist-item-documents">
                                                        <ul class="nav nav-tabs nav-stacked">
                                                            <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['count_document']>0){?>
                                                                <?php  $_smarty_tpl->tpl_vars['DOCUMENT'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['DOCUMENT']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ITEM']->value['documents']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['DOCUMENT']->key => $_smarty_tpl->tpl_vars['DOCUMENT']->value){
$_smarty_tpl->tpl_vars['DOCUMENT']->_loop = true;
?>
                                                                    <li class="">
                                                                        <a href="index.php?module=Documents&action=DownloadFile&record=<?php echo $_smarty_tpl->tpl_vars['DOCUMENT']->value['crmid'];?>
&fileid=<?php echo $_smarty_tpl->tpl_vars['DOCUMENT']->value['attachmentsid'];?>
"><?php echo $_smarty_tpl->tpl_vars['DOCUMENT']->value['title'];?>

                                                                            <span class="relationDelete pull-right" data-record="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
" data-related-record="<?php echo $_smarty_tpl->tpl_vars['DOCUMENT']->value['crmid'];?>
"><i title="Delete" class="icon-trash alignMiddle"></i></span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php }?>
                                        <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['allow_note']==1){?>
                                            <div id="comment-related<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
" class="comment-related">
                                                <div class="item-note-box">
                                                    <a class="add-note" href="javascript:void(0);">
                                                        <?php echo vtranslate('ADD_NOTE','ChecklistItems');?>

                                                    </a>
                                                    <a class="show-all-notes pull-right" href="javascript:void(0);">
                                                        <?php echo vtranslate('SHOW_ALL_NOTES','ChecklistItems');?>

                                                    </a>
                                                    <div class="item-note-add">
                                                        <textarea class="item-note-content" placeholder="<?php echo vtranslate('LBL_ADD_YOUR_COMMENT_HERE');?>
"></textarea>
                                                        <button class="btn btn-success add-comment" type="button" name="submit<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
" data-record="<?php echo $_smarty_tpl->tpl_vars['ITEM']->value['checklistitemsid'];?>
"><strong><?php echo vtranslate('ADD_NOTE_BTN','ChecklistItems');?>
</strong></button>
                                                    </div>
                                                    <div class="item-note-list">
                                                        <ul class="commentContainer">
                                                            <?php if ($_smarty_tpl->tpl_vars['ITEM']->value['count_comment']>0){?>
                                                                <?php  $_smarty_tpl->tpl_vars['COMMENT'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['COMMENT']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['ITEM']->value['comments']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['COMMENT']->key => $_smarty_tpl->tpl_vars['COMMENT']->value){
$_smarty_tpl->tpl_vars['COMMENT']->_loop = true;
?>
                                                                    <li class="commentDetails">
                                                                        <p><?php echo $_smarty_tpl->tpl_vars['COMMENT']->value['commentcontent'];?>
</p>
                                                                        <p><small><?php echo $_smarty_tpl->tpl_vars['COMMENT']->value['displayUserName'];?>
 | <?php echo $_smarty_tpl->tpl_vars['COMMENT']->value['displayDateTime'];?>
</small></p>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php }?>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php }?>
                                    </div>
                                    <?php }?>
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            <?php } ?>
        <?php } ?>
    <?php }?>
</div>

<?php }} ?>