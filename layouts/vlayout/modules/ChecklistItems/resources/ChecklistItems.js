/* ********************************************************************************
 * The content of this file is subject to the ChecklistItems ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** */

var Vtiger_ChecklistItems_Js = {

    registerAddChecklist: function (container) {
        var thisInstance = this;
        jQuery(container).on('click', '.checklist-name', function (event) {
            event.preventDefault();
            var aDeferred = jQuery.Deferred();
            var progressIndicatorElement = jQuery.progressIndicator({
                'position': 'html',
                'blockInfo': {
                    'enabled': true
                }
            });
            var source_record = jQuery('#recordId').val();
            var source_module = app.getModuleName();
            var checklistid = jQuery(this).data('record');
            var params = {};
            params['module'] = 'ChecklistItems';
            params['action'] = 'AddChecklistItems';
            params['checklistid'] = checklistid;
            params['source_record'] = source_record;
            params['source_module'] = source_module;
            AppConnector.request(params).then(
                function (data) {
                    if (data.result == 2 || data.result == 1) {
                        aDeferred.resolve(data);
                        thisInstance.showChecklistDetails(params);
                        progressIndicatorElement.progressIndicator({
                            'mode': 'hide'
                        });
                        return;
                    }
                },
                function (error, err) {
                    aDeferred.resolve(data);
                    progressIndicatorElement.progressIndicator({
                        'mode': 'hide'
                    });
                }
            )
        });
    },

    registerDateTimeChange: function(){
        var thisInstance = this;
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('change', 'input[name=checklist_item_date', function (event) {
            event.preventDefault();
            var parentElement = jQuery(this).closest('.checklist-item');
            var record = parentElement.data('record');
            var date = jQuery.trim(jQuery(this).val());
            var time = jQuery.trim(jQuery('input[name=checklist_item_time]', parentElement).val());
            if(date && time){
                thisInstance.updateDateTimeField(record, date+' '+time);
            }
        });
        jQuery(container).on('change', 'input[name=checklist_item_time', function (event) {
            event.preventDefault();
            var parentElement = jQuery(this).closest('.checklist-item');
            var record = parentElement.data('record');
            var time = jQuery.trim(jQuery(this).val());
            var date = jQuery.trim(jQuery('input[name=checklist_item_date]', parentElement).val());
            if(date && time){
                thisInstance.updateDateTimeField(record, date+' '+time);
            }
        });
    },

    registerUpdateChecklistItemStatus: function () {
        var thisInstance = this;
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('click', '.checklist-item-status-btn', function (event) {
            event.preventDefault();
            var aDeferred = jQuery.Deferred();
            var btnElement = jQuery(this);
            var currStatus = btnElement.data('status');
            var itemElement = jQuery(this).closest('.checklist-item');
            var params = {};
            params['module'] = 'ChecklistItems';
            params['action'] = 'UpdateChecklistItem';
            params['mode'] = 'Status';
            params['record'] = itemElement.data('record');
            params['status'] = currStatus;
            AppConnector.request(params).then(
                function (data) {
                    if (data.success) {
                        var result = data.result;
                        var statusValue = result.status;
                        if (statusValue != currStatus) {
                            btnElement.data('status', statusValue);
                            btnElement.removeClass('checklist-item-status-icon'+currStatus);
                            btnElement.addClass('checklist-item-status-icon'+statusValue);
                            itemElement.find('input[name=checklist_item_date]').val(result.currDate);
                            itemElement.find('input[name=checklist_item_time]').val(result.currTime);
                        }
                        aDeferred.resolve(data);
                    }
                },
                function (error, err) {

                }
            )
        });
    },

    registerShowCommentBox: function () {
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('click', '.add-note', function (event) {
            event.preventDefault();
            var note_box = jQuery(this).closest('.checklist-item-related').find('.item-note-add');
            if (note_box.css('display') == 'none') {
                note_box.css('display', 'block');
            } else {
                note_box.css('display', 'none');
            }
        });
    },

    registerShowAllComment: function () {
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('click', '.show-all-notes', function (event) {
            event.preventDefault();
            var note_box_list = jQuery(this).closest('.checklist-item-related').find('.item-note-list');

            if (note_box_list.hasClass('open')) {
                note_box_list.find('li').each(function(index){
                    if(index>0){
                        jQuery(this).slideUp();
                    }
                });
                note_box_list.removeClass('open');
            } else {
                note_box_list.find('li').each(function(index){
                    if(index>0){
                        jQuery(this).slideDown();
                    }
                });
                note_box_list.addClass('open');
            }
        });
    },

    registerShowSelectFileBox : function (){
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('click', '.upload-file', function (event) {
            event.preventDefault();
            jQuery(this).closest('form').find('input[type=file]').trigger('click');
        });
    },

    registerAutoUploadFile: function (form) {
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('change', 'input[name=filename]', function (event) {
            var filePath = jQuery(this).val();
            if (filePath) {
                var form = jQuery(this).closest('form');
                form.find('input[name=notes_title]').val(filePath.replace(/.*(\/|\\)/, ''));
                form.submit();
            }
        });
    },

    registerAddDocument: function(){
        var thisInstance = this;
        var container = jQuery('#vte-checklist-details');
        // attach handler to form's submit event
        jQuery('.checklist-upload-form', container).submit(function(e) {
            e.preventDefault();
            // submit the form
            var form = jQuery(this);
            form.ajaxSubmit({
                beforeSend: function(xhr) {
                    form.find('.progress').show();
                    var percentVal = '0%';
                    form.find('.bar').width(percentVal);
                    form.find('.percent').html(percentVal);
                },
                uploadProgress: function(event, position, total, percentComplete) {console.log('uploadProgress');
                    var percentVal = percentComplete + '%';
                    form.find('.bar').width(percentVal);
                    form.find('.percent').html(percentVal);
                },
                success: function() {
                    var percentVal = '100%';
                    form.find('.bar').width(percentVal);
                    form.find('.percent').html(percentVal);
                },
                complete: function(xhr) {
                    var data = jQuery.parseJSON(xhr.responseText);
                    var record = data.result._recordId;
                    var fileid = record + 1;
                    var title = data.result.notes_title.display_value;
                    var sourceRecord = form.find('input[name=sourceRecord]').val();
                    var newfile = '';
                    newfile += '<a href="index.php?module=Documents&action=DownloadFile&record='+record+'&fileid='+fileid+'">'+title;
                    newfile += '<span class="relationDelete pull-right" data-record="'+sourceRecord+'" data-related-record="'+record+'"><i title="Delete" class="icon-trash alignMiddle"></i></span>';
                    newfile += '</a>'
                    form.find('ul').prepend('<li>'+newfile+'</li>');
                    form.find('input[type=file]').val('');
                    thisInstance.updateDateTimeField(sourceRecord, '');
                    setTimeout(function(){
                        form.find('.progress').hide();
                    }, 5000);
                }
            });
            // return false to prevent normal browser submit and page navigation
            return false;
        });

    },

    registerAddComment: function () {
        var container = jQuery('#vte-checklist-details');
        var thisInstance = this;
        jQuery(container).on('click', '.add-comment', function (event) {
            event.preventDefault();
            var comment_box = jQuery(this).closest('.item-note-box');
            var comment_content = comment_box.find('.item-note-content').val();
            if (jQuery.trim(comment_content) == '') {
                alert(app.vtranslate('COMMENT_CONTENT_EMPTY'));
                return;
            }

            var aDeferred = jQuery.Deferred();
            var record = jQuery(this).data('record');
            var params = {};
            params['module'] = 'ChecklistItems';
            params['action'] = 'UpdateChecklistItem';
            params['checklistitemsid'] = record;
            params['mode'] = 'AddComment';
            params['comment'] = comment_content;

            AppConnector.request(params).then(
                function (data) {
                    if (data.result) {
                        comment_box.find('.item-note-list ul').prepend(data.result);
                        comment_box.find('.item-note-content').val('');
                        comment_box.find('.item-note-add').hide();
                        thisInstance.updateDateTimeField(record, '');
                    }
                    aDeferred.resolve(data);
                },
                function (error, err) {

                }
            )
        });
    },

    registerDeleteDocument: function () {
        var container = jQuery('#vte-checklist-details');
        jQuery(container).on('click', '.relationDelete', function (event) {
            event.preventDefault();
            var element = jQuery(this);
            var params = {};
            params['module'] = 'ChecklistItems';
            params['action'] = 'RelationAjax';
            params['src_record'] = element.data('record');
            params['related_record_list'] = [element.data('related-record')];
            params['mode'] = 'deleteRelation';
            params['related_module'] = 'Documents';
            Vtiger_Helper_Js.showConfirmationBox({'message' : app.vtranslate('LBL_DELETE_CONFIRMATION')}).then(
                function(e) {
                    AppConnector.request(params).then(
                        function (data) {
                            if (data == 1) {
                                element.closest('li').remove();
                            }
                            aDeferred.resolve(data);
                        },
                        function (error, err) {

                        }
                    );
                },
                function(error, err){
                }
            );
        });
    },

    showChecklistDetails: function (actionParams, container) {
        var aDeferred = jQuery.Deferred();
        var thisInstance = this;
        var params = {};
        params['module'] = 'ChecklistItems';
        params['view'] = 'ChecklistDetails';
        params['checklistid'] = actionParams['checklistid'];
        params['source_record'] = actionParams['source_record'];
        params['source_module'] = actionParams['source_module'];

        AppConnector.request(params).then(
            function (data) {
                app.showModalWindow(data);
                app.registerEventForTimeFields();
                thisInstance.registerUpdateChecklistItemStatus();
                thisInstance.registerShowCommentBox();
                thisInstance.registerShowAllComment();
                thisInstance.registerAddComment();
                thisInstance.registerShowSelectFileBox();
                thisInstance.registerAutoUploadFile();
                thisInstance.registerAddDocument();
                thisInstance.registerDeleteDocument();
                thisInstance.registerDateTimeChange();
                aDeferred.resolve(data);
            },
            function (error, err) {

            }
        )
    },

    updateDateTimeField: function(record, datetime){
        var aDeferred = jQuery.Deferred();
        var params = {};
        params['module'] = 'ChecklistItems';
        params['action'] = 'UpdateChecklistItem';
        params['mode'] = 'DateTime';
        params['record'] = record;
        params['datetime'] = datetime;
        AppConnector.request(params).then(
            function (data) {
                if (data.success) {
                    var result = data.result;
                    jQuery('#vte-checklist-details #checklist-item'+record).find('input[name=checklist_item_date]').val(result.currDate);
                    jQuery('#vte-checklist-details #checklist-item'+record).find('input[name=checklist_item_time]').val(result.currTime);
                }
                aDeferred.resolve(data);
            },
            function (error, err) {

            }
        )
    },


    registerEvents: function () {
        var container = jQuery('#vte-checklist');
        this.registerAddChecklist(container);
    }

}
jQuery(document).ready(function () {
    Vtiger_ChecklistItems_Js.registerEvents();
});