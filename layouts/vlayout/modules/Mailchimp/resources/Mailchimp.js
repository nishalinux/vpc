/*********************************************************************************
 * The contents of this file are copyright to Target Integration Ltd and are governed
 * by the license provided with the application. You may not use this file except in 
 * compliance with the License.
 * For support please visit www.targetintegration.com 
 * or email support@targetintegration.com
 * All Rights Reserved.
 * Modified and improved by crm-now.de
 *********************************************************************************/
var Settings_Mailchimp_Js = {

	regiserSelectGroupEvent : function(data) {
		data.find('[name="mcgrouplist"]').on('change',function(e) {
			var recordId = jQuery( "#recordId" ).val();
			Settings_Mailchimp_Js.getGroups (recordId);
		});
	},
	getGroups :  function(id) {
		var listeid = document.getElementById('mcgrouplist').value;
		document.getElementById('groups').disabled = false;
		var groups_name ="";
		var params = 'index.php?module=Mailchimp&action=LoadSyncValues&get=getGroupInfos&id='+id+'&listeid='+listeid;
		AppConnector.request(params).then(
			function(result) {
				if(result.result =='nogroupfound') {
					//no group found
					groups_name= 'default';
					document.getElementById('newgroupname_row').style.display ="";
					document.getElementById('groupname').style.display ="none";
					document.getElementById('new_groupname').style.display ="block";
					document.getElementById('groups_row').style.display ="none";
					document.getElementById('newGroupName').value="default";
					//document.getElementById('newGroupName').disabled = false;
				}
				else {
					//group found
					groups_name=result.result;
					document.getElementById('newgroupname_row').style.display ="none";
					document.getElementById('groupname').style.display ="block";
					document.getElementById('new_groupname').style.display ="none";
					document.getElementById('groups_row').style.display ="";
					document.getElementById('groups').value = groups_name;
					document.getElementById('groups').disabled ="disabled";
				}
			}
		);
	}


}
function loadMailchimpList(type,id) {
	var element = type+"_cv_list";
	var value = document.getElementById(element).value;        

	var filter = jQuery(element)[jQuery(element).selectedIndex].value	;
	if(filter=='None')return false;
	if(value != '') {
		jQuery("status").style.display="inline";
		new Ajax.Request(
			'index.php',
			{queue: {position: 'end', scope: 'command'},
				method: 'post',
				postBody: 'module=Mailchimp&action=MailchimpAjax&file=LoadList&ajax=true&return_action=DetailView&return_id='+id+'&list_type='+type+'&cvid='+value,
				onComplete: function(response) {
					jQuery("status").style.display="none";
					jQuery("RLContents").update(response.responseText);
				}
			}
		);
	}
}



MailChimpCommon = {
	OVERLAYID: '__MailChimpCommonOverlay__',
	
	initOverlay : function() {
		var overlaynode = document.createElement('div');
		overlaynode.id = MailChimpCommon.OVERLAYID;
		overlaynode.style.width = '550px';
		overlaynode.style.display = 'block';		
		overlaynode.style.zIndex = '1000000';
		overlaynode.style.backgroundColor = '#333';

		document.body.appendChild(overlaynode);
	},
	showlist: function(record) {
		if (!jQuery( "#mailchimplog" ).length ) {
			alert(app.vtranslate('JSLBL_GOTO_DETAIL_VIEW'));
		}
		else {
			MailChimpCommon.initOverlay();
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
				'enabled' : true
				}
			});

			var params = 'index.php?module=Mailchimp&view=showGroupOverlay&record='+encodeURIComponent(record);
			AppConnector.request(params).then(
				function(result) {
					progressIndicatorElement.progressIndicator({'mode':'hide'});
					var callBackFunction = function(result) {
						jQuery('[name="addItemForm"]',result).validationEngine();
						Settings_Mailchimp_Js.regiserSelectGroupEvent(result);
					}
					app.showModalWindow(result, function(data) {
						if(typeof callBackFunction == 'function') {
							callBackFunction(data);
						}
					});
				}
			);
		}
	},
	

	checklist : function() {
		var e = document.getElementById('mcgrouplist');
		if ( e.options[e.selectedIndex].value =='') {
			alert (alert_arr.LBL_NO_DATA_SELECTED);
			return false;
		}
		return true;
	},
	
	sync : function(id) {
		var list = document.getElementById('mcgrouplist').value;
		if(document.getElementById('groups')!=null && document.getElementById('newgroupname_row').style.display !='none' && !isNaN(groups)) {
			var  groups = document.getElementById('groups').value;
			groups = listInfo[groups].name;
		} else {
			var  groups = "";
			var group = document.getElementById('newGroupName').value;
		}
		MailChimpCommon.syncstart("Mailchimp",id,"MailchimpSyncStep1",list,groups,group);
	},
	
	syncstart : function getStep(module,id, step,listeid,groups,group){ 
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
			'enabled' : true
			}
		});
		var record			= id;
		var module_nameurl	= module;//document.getElementById('module_nameurl').value;
		var module_name		= module;
		if (typeof(groups) == 'undefined') {
			groups='';
		}
		if (typeof(group) == 'undefined') {
			group='';
		}
		var responseBox = "mailchimplog";
		var params = 'index.php?module=Mailchimp&action=MailChimpStepController&function='+step+'&ajax=true&record='+record+'&module_name='+module_name+'&module_nameurl='+module_nameurl+"&list_id="+listeid+'&groupslist='+groups+'&group='+group;
		AppConnector.request(params).then(
			function(result) {
				progressIndicatorElement.progressIndicator({'mode':'hide'});
				if(jQuery.parseJSON(result.result) == "FAILURE"){
						alert(app.vtranslate('JSLBL_ENTER_MC_VALUE'));
						return false;
					}
					else{
						if(result.result!="" && step=='MailchimpSyncStep1') {
							jQuery.each( jQuery.parseJSON(result.result), function( key, value ) {
								jQuery('#mailchimplog').append('<div>'+value.text+'</div>');
								jQuery('#mailchimplog div:last-child').attr('style', value.style);
							});
							getStep(module,id,'MailchimpSyncStep2',listeid,groups,group);
						}
						if(result.result!="" && step=='MailchimpSyncStep2') {
							jQuery.each( jQuery.parseJSON(result.result), function( key, value ) {
								jQuery('#mailchimplog').append('<div>'+value.text+'</div>');
								jQuery('#mailchimplog div:last-child').attr('style', value.style);
							});
							getStep(module,id,'MailchimpSyncStep3',listeid);
						}
					
						if(result.result!="" && step=='MailchimpSyncStep3') {
							jQuery.each( jQuery.parseJSON(result.result), function( key, value ) {
								jQuery('#mailchimplog').append('<div>'+value.text+'</div>');
								jQuery('#mailchimplog div:last-child').attr('style', value.style);
							});
							getStep(module,id,'MailchimpSyncStep4',listeid,groups,group);
						}
						
						if(result.result!="" && step=='MailchimpSyncStep4') {
							jQuery.each( jQuery.parseJSON(result.result), function( key, value ) {
								jQuery('#mailchimplog').append('<div>'+value.text+'</div>');
								jQuery('#mailchimplog div:last-child').attr('style', value.style);
							});
						}
						progressIndicatorElement.progressIndicator({'mode':'hide'});
					}
			}
		);
		progressIndicatorElement.progressIndicator({'mode':'hide'});
	},
	/**
	 * Function to empty the log field entries
	 */
	emptyLog : function() {
		jQuery('#mailchimplog').children().remove();
	},
	
	
}
