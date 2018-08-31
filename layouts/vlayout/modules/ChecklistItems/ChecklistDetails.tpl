{* ********************************************************************************
 * The content of this file is subject to the ChecklistItems ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** *}
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
    <input type="hidden" name="curr_date" value="{$CURR_DATE}" />
    <input type="hidden" name="curr_time" value="{$CURR_TIME}" />
    <span class="ui-helper-hidden-accessible"><input type="text"/></span>
    {if $COUNT_ITEM gt 0}
        {foreach item=ITEMS key=CATEGORYNAME from=$CHECKLIST_ITEMS}
            <div class="checklist-name"><h3><a href="javascript:void(0);">{$CATEGORYNAME}</a></h3></div>
            {foreach item=ITEM from=$ITEMS}
                <div class="checklist-item" data-record="{$ITEM.checklistitemsid}" id="checklist-item{$ITEM.checklistitemsid}">
                    <table width="100%">
                        <tr>
                            <td width="3%" valign="top">
                                <span data-status="{$ITEM.checklistitem_status}" class="checklist-item-status-btn checklist-item-status-icon{$ITEM.checklistitem_status}">&nbsp;</span>
                            </td>
                            <td width="97%" valign="top">
                                <div class="checklist-item-header">
                                    <div class="pull-left checklist-item-title">
                                        <a href="javascript:void(0);">{$ITEM.title}</a>
                                    </div>
                                    <div class="pull-right checklist-item-date">
                                        <div class="input-append time">
                                            <input type="text" placeholder="{vtranslate('INPUT_TIME', 'ChecklistItems')}" name="checklist_item_time" data-format="{$CURR_USER_MODEL->get('hour_format')}" class="timepicker-default input-small ui-timepicker-input" value="{$ITEM.status_time_display}" autocomplete="off">
                                            {*<span class="add-on cursorPointer"><i class="icon-time"></i></span>*}
                                        </div>
                                        <div class="date">
                                            <input type="text" placeholder="{vtranslate('INPUT_DATE', 'ChecklistItems')}" class="dateField input-small" name="checklist_item_date" data-date-format="{$CURR_USER_MODEL->get('date_format')}" value="{$ITEM.status_date_display}" >
                                            {*<span class="add-on"><i class="icon-calendar"></i></span>*}
                                        </div>
                                    </div>
                                </div>
                                <div class="checklist-item-content">
                                    <div class="checklist-item-desc">
                                        {$ITEM.description}
                                    </div>
                                    {if $ITEM.allow_upload eq 1 || $ITEM.allow_note eq 1}
                                    <div class="checklist-item-related">
                                        {if $ITEM.allow_upload eq 1}
                                            <div id="document-related{$ITEM.checklistitemsid}" class="document-related">
                                                <form action="index.php?module=Documents&action=SaveAjax" method="post" class="checklist-upload-form" enctype="multipart/form-data">
                                                    <input type="hidden" name="module" value="Documents">
                                                    <input type="hidden" name="action" value="SaveAjax">
                                                    <input type="hidden" name="sourceModule" value="ChecklistItems">
                                                    <input type="hidden" name="sourceRecord" value="{$ITEM.checklistitemsid}">
                                                    <input type="hidden" name="relationOperation" value="true">
                                                    <input type="hidden" name="notes_title" value="">
                                                    <input type="hidden" name="filelocationtype" value="I">
                                                    <input type="file" name="filename" class="add-document"/>
                                                    <a class="upload-file" href="javascript:void(0);">
                                                        {vtranslate('UPLOAD_FILE', 'ChecklistItems')}
                                                    </a>
                                                    <div class="progress progress-striped active">
                                                        <div class="bar"></div >
                                                        <div class="percent">0%</div >
                                                    </div>

                                                    <div class="checklist-item-documents">
                                                        <ul class="nav nav-tabs nav-stacked">
                                                            {if $ITEM.count_document gt 0}
                                                                {foreach item=DOCUMENT from=$ITEM.documents}
                                                                    <li class="">
                                                                        <a href="index.php?module=Documents&action=DownloadFile&record={$DOCUMENT.crmid}&fileid={$DOCUMENT.attachmentsid}">{$DOCUMENT.title}
                                                                            <span class="relationDelete pull-right" data-record="{$ITEM.checklistitemsid}" data-related-record="{$DOCUMENT.crmid}"><i title="Delete" class="icon-trash alignMiddle"></i></span>
                                                                        </a>
                                                                    </li>
                                                                {/foreach}
                                                            {/if}
                                                        </ul>
                                                    </div>
                                                </form>
                                            </div>
                                        {/if}
                                        {if $ITEM.allow_note eq 1}
                                            <div id="comment-related{$ITEM.checklistitemsid}" class="comment-related">
                                                <div class="item-note-box">
                                                    <a class="add-note" href="javascript:void(0);">
                                                        {vtranslate('ADD_NOTE', 'ChecklistItems')}
                                                    </a>
                                                    <a class="show-all-notes pull-right" href="javascript:void(0);">
                                                        {vtranslate('SHOW_ALL_NOTES', 'ChecklistItems')}
                                                    </a>
                                                    <div class="item-note-add">
                                                        <textarea class="item-note-content" placeholder="{vtranslate('LBL_ADD_YOUR_COMMENT_HERE')}"></textarea>
                                                        <button class="btn btn-success add-comment" type="button" name="submit{$ITEM.checklistitemsid}" data-record="{$ITEM.checklistitemsid}"><strong>{vtranslate('ADD_NOTE_BTN', 'ChecklistItems')}</strong></button>
                                                    </div>
                                                    <div class="item-note-list">
                                                        <ul class="commentContainer">
                                                            {if $ITEM.count_comment gt 0}
                                                                {foreach item=COMMENT from=$ITEM.comments}
                                                                    <li class="commentDetails">
                                                                        <p>{$COMMENT.commentcontent}</p>
                                                                        <p><small>{$COMMENT.displayUserName} | {$COMMENT.displayDateTime}</small></p>
                                                                    </li>
                                                                {/foreach}
                                                            {/if}
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        {/if}
                                    </div>
                                    {/if}
                                </div>
                            </td>
                        </tr>
                    </table>
                </div>
            {/foreach}
        {/foreach}
    {/if}
</div>

