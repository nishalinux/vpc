/*
Installedd via a HEADERSCRIPT
Some functions are duplicated in vtDZiner.js
To rewrite to behave like a standard vtiger JS class
*/
document.write("<script type='text/javascript' src='test/user/InFormStatus.js'></"+"script>");
var cssLink = jQuery("<link rel='stylesheet' type='text/css' href='modules/vtDZiner/vtDZiner.css'>");
jQuery("head").append(cssLink); 
var exemptModules = Array("Vtiger", "Calendar", "CustomerPortal", "Dashboard", "Emails", "EmailTemplates", "Events", "Google", "Home", "Import", "Mobile", "ModComments", "ModTracker", "Portal", "RecycleBin", "Reports", "Rss", "SMSNotifier", "Users", "vtDZiner", "Webforms", "Webmails", "WSAPP", "Roles", "Profiles", "Groups", "SharingAccess", "LoginHistory", "LayoutEditor", "Picklist", "PickListDependency", "MenuEditor", "ModuleManager", "Currency", "MailConverter", "Workflows", "CronTasks", "PBXManager", "ExtensionStore");
var iF_FieldEdit_Flag = true;

// Start gathering vtDZiner TPL javascript

	// From vtModuleSettings.tpl
	function showModuleInfoDetails(obj){
		jQuery.each(obj, function(i, v){
			//console.log(i, v);
		});
	}

	// Add Relations
	function selectRelatedFields(rel){
		if (jQuery('#relatedfields').is(":checked")){
			jQuery('.relatedfieldslistarea').removeClass("hide");
			// Sync Ajax for field names
			if (rel=='parent') {
				getRelatedModuleFields(jQuery('#parentmodule').val());
			} else {
				getRelatedModuleFields(jQuery("#selectedModuleName").val());
			}
		} else {
			jQuery('.relatedfieldslistarea').addClass("hide");
		}
	}

	function selectReferenceField(rel){
		if (jQuery('#relatedreference').is(":checked")){
			jQuery('.relatedFieldGroup').removeClass("hide");
			if (rel=='parent') {
				jQuery('#referencelabel').val(jQuery('#parentmodule').val()+" Reference");
			} else {
				jQuery('#referencelabel').val(jQuery('#selectedModuleName').val()+" Reference");
			}
		} else {
			jQuery('.relatedFieldGroup').addClass("hide");
		}
	}

	function getRelatedModuleFields(sourceModule){
		var fieldsrequest = new XMLHttpRequest();
		fieldsrequest.open('GET', 'index.php?module=vtDZiner&parent=Settings&sourceModule='+sourceModule+'&view=IndexAjax&mode=getRelatedModuleFields', false);  // `false` makes the request synchronous
		fieldsrequest.send(null);
		if (fieldsrequest.status === 200) {
			var relatedfields = eval("(" + fieldsrequest.responseText + ')');
			relatedfields = relatedfields.result;
			jQuery("#sel_col").empty();
			jQuery.each(relatedfields, function( index, value ) {
				jQuery("#sel_col").append('<option value="'+value.id+'">'+value.label+'</option>');
			});
		}
	}

	// From AddField.tpl
	function setRelatedLabel(obj){
		jQuery(obj).closest("form").find('[name="fieldLabel"]').val(obj.options[obj.selectedIndex].text+" Reference");
	}

	// Add Fields
	function allowNewBlockInfo(){
		if (jQuery("#createNewBlock").is(':checked')) {
			jQuery("#newBlockLabel").prop('disabled', false);
		} else {
			jQuery("#newBlockLabel").prop('disabled', true);
			jQuery("#newBlockLabel").val('');
		}
	}

	function setFieldProperties(obj, fieldno){
		jQuery("#properties_"+fieldno+"  > tbody > tr").addClass("hide");
		switch (jQuery(obj).val())
		{
		case "Text" : 
		case "Integer" :
			jQuery("#properties_"+fieldno+" .standard").removeClass("hide");
			jQuery("#properties_"+fieldno+" .fielddecimals").addClass("hide");
		break;

		case "Picklist" :
		case "MultiSelectCombo" :
			jQuery("#properties_"+fieldno+" .fieldpicklist").removeClass("hide");
			jQuery("#properties_"+fieldno).removeClass("hide");
		break;

		case "Relatedto" : 
			jQuery("#properties_"+fieldno+" .fieldrelation").removeClass("hide");
			jQuery("#properties_"+fieldno).removeClass("hide");
		break;

		case "Decimal" : 
		case "Currency" : 
		jQuery("#properties_"+fieldno+" .standard").removeClass("hide");
		jQuery("#properties_"+fieldno+" .fielddecimals").removeClass("hide");
		break;

		default :
			//jQuery("#properties_"+fieldno).addClass("hide");
			jQuery("#properties_"+fieldno+"  > tbody > tr").addClass("hide");
		break;
		}
	}


// From Index.tpl
	function readURL(input) {
		if (input.files && input.files[0]) {
			var reader = new FileReader();
			reader.onload = function (e) {
				jQuery('#uploadedImage').attr('src', e.target.result);
			}
			reader.readAsDataURL(input.files[0]);
		}
	}

// From vtDZinerSettings.tpl

	jQuery('body').ready(
		function(){
			if(InFormMode) jQuery("#cbInFormMode").prop( 'checked', true);
		}
	);

	function cbInFormClicked(){
		cmsg = (jQuery("#cbInFormMode").prop('checked'))? "Set inForm DZiner ON ?<br>Click <b>Change</b> to confirm settings update" : "Set inForm DZiner OFF ?<br>Click <b>Change</b> to confirm settings update";
		bootbox.confirm(cmsg,"Don't Change", 'Change', function(result){
			if (result){
				inFormSettings('Set\/Reset');
			} else {
				if (jQuery("#cbInFormMode").prop( 'checked')){
					jQuery("#cbInFormMode").prop( 'checked', false)
				} else {
					jQuery("#cbInFormMode").prop( 'checked', true)
				}
			}
		}).find('.btn-primary').addClass('btn-info').removeClass('btn-primary');
	}

// From vtLanguageDZiner.tpl
	function selectAllText(textbox) {
		textbox.focus();
		textbox.select(); 
	}

	function togglebulklabels(bulkMode) {
		if (bulkMode=="js"){
			jQuery(".bulkTranslateForm").find(".bulkLabelsContainer").addClass("hide");
			jQuery(".bulkTranslateForm").find(".jsbulkLabelsContainer").removeClass("hide");
		} else {
			jQuery(".bulkTranslateForm").find(".bulkLabelsContainer").removeClass("hide");
			jQuery(".bulkTranslateForm").find(".jsbulkLabelsContainer").addClass("hide");	}
	}

	function update_textarea(obj) {
		//http://blog.ekini.net/2009/02/24/jquery-getting-the-latest-textvalue-inside-a-textarea/
		jQuery('#mydiv').text(jQuery(obj).attr('value')); //whatever you type in the textarea would be reflected in #mydiv
	}

	function showLanguagesSummaryView(){
		jQuery(".LanguageLabelsEditView").addClass("hide");
		jQuery(".LanguagesSummaryView").removeClass("hide");
	}

	function createSelectedLanguage(forlanguage, sourceModule){
		jQuery(".LanguagesSummaryView").addClass("hide");
		jQuery(".LanguageLabelsEditView").removeClass("hide");
		//loadModuleLanguage(forlanguage, sourceModule);
		jQuery("#languageLabelsForm").find("[id='sourceModule']").val(sourceModule);
		jQuery("#languageLabelsForm").find("[id='forLanguage']").val(forlanguage);
		jQuery("#languageLabelsForm").find("[id='languageMode']").val("CREATE");
		jQuery("#languageFormHeading").html("<h3>Creating language file "+crmLanguages[forlanguage]+"<br/> ./languages/"+forlanguage+"/"+sourceModule+".php</h3>");
	}

	function editSelectedLanguage(forlanguage, sourceModule){
		jQuery(".LanguagesSummaryView").addClass("hide");
		jQuery(".LanguageLabelsEditView").removeClass("hide");
		loadModuleLanguage(forlanguage, sourceModule);
		jQuery("#languageLabelsForm").find("[id='sourceModule']").val(sourceModule);
		jQuery("#languageLabelsForm").find("[id='forLanguage']").val(forlanguage);
		jQuery("#languageLabelsForm").find("[id='languageMode']").val("UPDATE");
		jQuery("#languageFormHeading").html("<h3>Editing language file "+crmLanguages[forlanguage]+"<br/> ./languages/"+forlanguage+"/"+sourceModule+".php</h3>");
	}

	function loadModuleLanguage(forlanguage, sourceModule){
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
			'enabled' : true
			}
		});
		var params = {};
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['view'] = 'IndexAjax';
		params['mode'] = 'loadModuleLanguage';
		params['sourceModule'] = sourceModule;
		params['forLanguage'] = forlanguage;
		hideparams = {};
		hideparams['mode'] = 'hide';
		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator(hideparams);
				jQuery('#labelEditForm').empty();
				jQuery('#jslabelEditForm').empty();
				if (data !="") {
					langlabelsobject = eval("(" + data + ')');
					langlabelsobject = eval("(" + langlabelsobject.result + ')');

					jQuery.each(langlabelsobject.langlabels, function( index, value ) {
					  jQuery('#labelEditForm').append('<tr><td class="span4">'+index+'</td><td class="span8"><input class="span8" id="'+index+'" name="'+index+'" type=text size=200 value="'+value+'" /></td></tr>');
					  bulkLabels +=value+"\n";
					});
					jQuery.each(langlabelsobject.jslanglabels, function( index, value ) {
					  jQuery('#jslabelEditForm').append('<tr><td class="span4">'+index+'</td><td class="span8"><input class="span8" id="'+index+'" name="'+index+'" type=text size=200 value="'+value+'" /></td></tr>');
					  jsbulkLabels +=value+"\n";
					});
				} else {
					var params = {};
					params["text"]="Error loading language file";
					params["type"]="error";
					Settings_Vtiger_Index_Js.showMessage(params);
				}
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				alert("Error");
			}
		);
	}

	function setLanguageName(obj){
		jQuery("#loadLanguageLink").text(jQuery("#loadLanguageLink").text() +  " " + jQuery(obj).children(':selected').text());
		var params = {};
		params['text'] = jQuery(obj).children(':selected').text()+' selected\nSelect Load Language from Actions to get the labels';
		Settings_Vtiger_Index_Js.showMessage(params);
	}

	function setLanguageCode(obj){
		var params = {};
		params['text'] = jQuery(obj).children(':selected').text()+' selected ['+obj.value+']\nClick on <b>SAVE</b> to create a new Language Pack';
		jQuery(".newCRMLanguageForm").find("#languageISOCode").val(obj.value);
		jQuery(".newCRMLanguageForm").find("#languageName").val(jQuery(obj).children(':selected').text());
		jQuery(".newCRMLanguageForm").find("#languageLabel").val(jQuery(obj).children(':selected').text());
		Settings_Vtiger_Index_Js.showMessage(params);
	}

	function deleteNewLabel(obj){
		jQuery(obj).closest('tr').remove();
		var params = {};
		params['text'] ='Label Deleted';
		Settings_Vtiger_Index_Js.showMessage(params);
	}

	function addNewLabel(item){
		data = jQuery(".newLanguageLabelModalData").html();
		app.showModalWindow(data);
		jQuery('.newLanguageLabelModal').removeClass("hide");
		jQuery('.newLanguageLabelForm').on('submit',function(e) {
			var params = jQuery(e.currentTarget).serializeFormData();
			if (item == "lang") {
				jQuery('#labelEditForm').prepend('<tr><td class="span4">'+params["labeltag"]+' <span class="pull-right"><i class="icon-trash alignMiddle" title="Delete label" onclick="deleteNewLabel(this)"></i></span></td><td class="span8"><input class="span8" id="'+params["labeltag"]+'" name="'+params["labeltag"]+'" type=text size=200 value="'+params["labelvalue"]+'" /></td></tr>');
			} else {
				jQuery('#jslabelEditForm').prepend('<tr><td class="span4">'+params["labeltag"]+' <span class="pull-right"><i class="icon-trash alignMiddle" title="Delete label" onclick="deleteNewLabel(this)"></i></span></td><td class="span8"><input class="span8" id="'+params["labeltag"]+'" name="'+params["labeltag"]+'" type=text size=200 value="'+params["labelvalue"]+'" /></td></tr>');
			}
			jQuery('.newLanguageLabelModal').addClass("hide");
			//To prevent form submit
			app.hideModalWindow();
			e.preventDefault();	
		});
	}

	function listModuleLanguages(sourceModule){
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
			'enabled' : true
			}
		});
		var params = {};
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['view'] = 'IndexAjax';
		params['mode'] = 'listModuleLanguages';
		params['sourceModule'] = sourceModule;
		params['forLanguage'] = '';
		hideparams = {};
		hideparams['mode'] = 'hide';

		AppConnector.request(params, false).then(
			function(data) {
				var obj = eval("(" + data + ')');
				languagesList = obj.result.split("\n");
				languagesList.splice(-1,1);
				jQuery(".modulelanguageslist").empty();
				jQuery(".missinglanguageslist").empty();
				mlc=[];// temporary array language codes for Module Languages
				lca=[];// temporary array language codes for CRM Languages
				jQuery.each(crmLanguages, function( index, value ) {
				lca.push(index); 
				});
				jQuery.each(languagesList, function( index, value ) {
				  value=value.split(directory_separator);
				  mlc.push(value[1]);
				  if (value[1]==currentLanguage)
				  {
					  jQuery(".modulelanguageslist").append("<tr><td><b>"+crmLanguages[value[1]]+"<sup>#</sup></b><span class='pull-right'><i class='icon-pencil' onclick='editSelectedLanguage(\""+value[1]+"\", \""+sourceModule+"\");'></i></span></td></tr>");
				  } else {
					  jQuery(".modulelanguageslist").append("<tr><td>"+crmLanguages[value[1]]+"<span class='pull-right'><i class='icon-pencil' onclick='editSelectedLanguage(\""+value[1]+"\", \""+sourceModule+"\");'></i></span></td></tr>");
				  }
				});

				//http://jsfiddle.net/i_like_robots/KpCt2/
				//jQuery.arrayIntersect = function(a, b) {
				//	return jQuery.grep(a, function(i) {
				//	return jQuery.inArray(i, b) > -1;
				//	});
				//};
				//console.log($.arrayIntersect(array2,mlc ));

				tbc= jQuery(lca).not(mlc).get(); // To Be Created languages Array
				jQuery.each(tbc, function( index, value ) {
					jQuery(".missinglanguageslist").append("<tr><td>"+crmLanguages[value]+"<span class='pull-right'><i class='icon-plus' onclick='createSelectedLanguage(\""+value+"\", \""+sourceModule+"\");' title='Click to add missing language file to this module'></i></span></td></tr>");
				});
				jQuery('.modulelanguages').html(languagesList.length);
				progressIndicatorElement.progressIndicator(hideparams);
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				alert("Error");
			}
		);
		return languagesList;
	}

	function getModuleLanguageFile(){
	}

	function getCRMLanguageFile(){
		//jQuery.parseJSON( jsonString );
	}

	function saveModuleLanguage(){
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
			'enabled' : true
			}
		});

		var params = {};
		params['langstrings'] = JSON.stringify(jQuery( "#languageLabelsForm" ).serializeFormData());
		params['jslangstrings'] = JSON.stringify(jQuery( "#JSlanguageLabelsForm" ).serializeFormData());
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['view'] = 'IndexAjax';
		params['mode'] = 'saveModuleLanguage';
		params['sourceModule'] = jQuery("#languageLabelsForm").find("#sourceModule").val();
		params['forLanguage'] = jQuery("#languageLabelsForm").find("#forLanguage").val();
		hideparams = {};
		hideparams['mode'] = 'hide';
		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator(hideparams);
				data = eval("(" + data + ')');
				mparams = {};
				mparams['text'] = data.result;
				Settings_Vtiger_Index_Js.showMessage(mparams);
				listModuleLanguages(jQuery("#languageLabelsForm").find("#sourceModule").val());
				showLanguagesSummaryView();
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				alert("Error");
			}
		);
	}

	function newCRMLanguage(){
		data = jQuery(".newCRMLanguageModalData").html();
		// TODO set up the intersected worldLanguages array as the select options
		// tbc= $(lca).not(mlc).get();
		app.showModalWindow(data);

		jQuery(".newCRMLanguageModal").find(".cancelLink").click(function(){
			jQuery('.newCRMLanguageModal').addClass('hide');
			jQuery(".newCRMLanguageModal").find(".vtselector").select2("destroy");
		});

		app.showSelect2ElementView(jQuery(".newCRMLanguageModal").find(".vtselector"));
		jQuery('.newCRMLanguageModal').removeClass("hide");
		jQuery('.newCRMLanguageForm').on('submit',function(e) {
			jQuery(".newCRMLanguageModal").find(".vtselector").select2("destroy");
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
				'enabled' : true
				}
			});
			var params = jQuery(e.currentTarget).serializeFormData();
			params['module'] = 'vtDZiner';
			params['parent'] = 'Settings';
			params['view'] = 'IndexAjax';
			params['languageName'] = params['languageLabel'];
			params['mode'] = 'makeLanguagePack';
			hideparams = {};
			hideparams['mode'] = 'hide';
			AppConnector.request(params).then(
				function(data) {
					progressIndicatorElement.progressIndicator(hideparams);
					data = eval("(" + data + ')');
					var params = {};
					if (data.success){
						params['text'] = data.result;
					} else {
						params['text'] = data.error.message;
						params['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					progressIndicatorElement.progressIndicator(hideparams);
					alert("Error");
				}
			);
			jQuery('.newCRMLanguageModal').addClass("hide");
		});
	}

	function bulkTranslate() {
		data = jQuery(".bulkTranslateModalData").html();
		bulkLabels = "";
		jsbulkLabels = "";
		langlabelsobject={};
		var smlang = jQuery("#languageLabelsForm").find("[id='forLanguage']").val();
		var formodule = jQuery("#languageLabelsForm").find("[id='sourceModule']").val();
		var selectedmodule = jQuery("#selectedModuleName").val();
		
		if(selectedmodule != formodule){

			langlabelsobject['langlabels'] = otherlangLabels_Smarty[formodule];
			langlabelsobject['jslanglabels'] = jsotherlangLabels_Smarty[formodule];
			langLabels_Smarty = otherlangLabels_Smarty[formodule];
			jslangLabels_Smarty = jsotherlangLabels_Smarty[formodule];
		}else{
			
			langlabelsobject['langlabels'] = langLabels_Smarty;
			langlabelsobject['jslanglabels'] = jslangLabels_Smarty;
		}
		jQuery.each(langLabels_Smarty, function( index, value ) {
		  bulkLabels +=value+"\n";
		});
		jQuery.each(jslangLabels_Smarty, function( index, value ) {
		  jsbulkLabels +=value+"\n";
		});


		//ZeroClipboard.config( { swfPath: "http://23.253.167.171/634vtigerwork610/libraries/ZeroClipboard/ZeroClipboard.swf" } );
		//var client = new ZeroClipboard(document.getElementById('copy2Clipboard') );
		//var client = new ZeroClipboard(jQuery("#copy2Clipboard"));

		app.showModalWindow(data);

		jQuery(".bulkTranslateModal").find(".cancelLink").click(function(){
			jQuery('.bulkTranslateModal').addClass('hide');
		});
		jQuery('.bulkTranslateModal').removeClass("hide");
		jQuery(".bulkTranslateForm").find("[name='bulkLabels']").val(bulkLabels);
		jQuery(".bulkTranslateForm").find("[name='jsbulkLabels']").val(jsbulkLabels);
		//jQuery(".bulkTranslateForm").find("#tabs").tabs(); 
		jQuery(".bulkTranslateForm").find("#tabs").tabs().removeClass('ui-widget-content').addClass('overwrite-ui-widget-content'); 
		jQuery(".bulkTranslateForm").find("#tabs").tabs().removeClass('ui-tabs-panel').addClass('overwrite-ui-tabs-panel'); 
		
		//jQuery('#tabs').attr('style', 'height: auto !important');
		//alert("stop");
		jQuery('.bulkTranslateForm').on('submit',function(e) {
			newlabels = jQuery(e.currentTarget).find("[name='bulkLabels']").val();
			newlabels = newlabels.split("\n");
			counter=0;
			jQuery('#labelEditForm').empty();
			jQuery.each(langlabelsobject.langlabels, function( index, value ) {
				jQuery('#labelEditForm').append('<tr><td class="span4">'+index+'</td><td class="span8"><input class="span8" id="'+index+'" name="'+index+'" type=text size=200 value="'+newlabels[counter]+'" /></td></tr>');
				counter++;
			});

			jQuery('#jslabelEditForm').empty();
			jQuery.each(langlabelsobject.jslanglabels, function( index, value ) {
			  jQuery('#jslabelEditForm').append('<tr><td class="span4">'+index+'</td><td class="span8"><input class="span8" id="'+index+'" name="'+index+'" type=text size=200 value="'+value+'" /></td></tr>');
			  jsbulkLabels +=value+"\n";
			});

			jQuery('.bulkTranslateModal').addClass("hide");
			app.hideModalWindow();
			e.preventDefault();
		});
	}

	function setupLangDZiner(){
		languagesList = alllanguagesList;
		jQuery(".modulelanguageslist").empty();
		jQuery(".missinglanguageslist").empty();
		mlc=[];// temporary array language codes for Module Languages
		lca=[];// temporary array language codes for CRM Languages
		jQuery.each(crmLanguages, function( index, value ) {
		lca.push(index); 
		});
		sourceModule = jQuery("#sourceModule").val();
		jQuery.each(alllanguagesList, function( index, value ) {
		  value=value.split(directory_separator);
		  mlc.push(value[1]);
		
		  if(value.length == 3){
		  if (value[1]==currentLanguage)
		  {
			  jQuery(".modulelanguageslist").append("<tr><td><b>"+crmLanguages[value[1]]+"<sup>#</sup></b><span class='pull-right'><i class='icon-pencil' onclick='editSelectedLanguage(\""+value[1]+"\", \""+sourceModule+"\");'></i></span></td></tr>");
		  } else {
			  jQuery(".modulelanguageslist").append("<tr><td>"+crmLanguages[value[1]]+"<span class='pull-right'><i class='icon-pencil' onclick='editSelectedLanguage(\""+value[1]+"\", \""+sourceModule+"\");'></i></span></td></tr>");
		  }
		  }//
		});

		tbc= jQuery(lca).not(mlc).get(); // To Be Created languages Array
		jQuery.each(tbc, function( index, value ) {
			jQuery(".missinglanguageslist").append("<tr><td>"+crmLanguages[value]+"<span class='pull-right'><i class='icon-plus' onclick='createSelectedLanguage(\""+value+"\", \""+sourceModule+"\");' title='Click to add missing language file to this module'></i></span></td></tr>");
		});
		jQuery('.modulelanguages').html(alllanguagesList.length);
	}

// From vtViewDZiner.tpl
	function displayPanels(){
		jQuery(".panelsList tbody").empty();
		jQuery.each(panelsList, function(index, value){
			var blockIds = value[0].split(",");
			var blockLabels = [];
			jQuery.each(blockIds, function(bindex, bvalue){
				blockLabels.push(blocksList[bvalue]);
			});
			jQuery(".panelsList").append('<tr><td>'+value[1]+'</td><td>'+blockLabels.join(", ")+'</td><td><span class="pull-right"><i title="Edit panel properties" class="icon-pencil alignMiddle" onclick="editPanel(\''+value[1]+'\', \'UPDATE\', \''+blockLabels.join(",")+'\');"></i><i title="Edit panel properties" class="icon-trash alignMiddle" onclick="deletePanelInfo(\''+index+'\');"></i></span></td></tr>');
		});
	}
	function displayPanelDetails(plist){
		jQuery(".panelsList tbody").empty();
		jQuery.each(plist, function(index, value){
			var blockIds = value[0].split(",");
			var blockLabels = [];
			jQuery.each(blockIds, function(bindex, bvalue){
				blockLabels.push(blocksList[bvalue]);
			});
			jQuery(".panelsList").append('<tr><td>'+value[1]+'</td><td>'+blockLabels.join(", ")+'</td><td><span class="pull-right"><i title="Edit panel properties" class="icon-pencil alignMiddle" onclick="editPanel(\''+value[1]+'\', \'UPDATE\', \''+blockLabels.join(",")+'\');"></i><i title="Edit panel properties" class="icon-trash alignMiddle" onclick="deletePanelInfo(\''+index+'\');"></i></span></td></tr>');
		});
	}

	function displayThemes(){
		jQuery(".themesList tbody").empty();
		jQuery.each(themesList, function(index, value){
			jQuery(".themesList").append('<tr><td class="span2">'+index.charAt(0).toUpperCase() + index.slice(1)+'</td><td class="span2" bgcolor="'+value+'"></td><td>'+value+'</td><td>'+value+'</td><td><span class="pull-right"><i title="Edit theme properties" class="icon-pencil alignMiddle" onclick="showThemePalette(\''+index+'\', \'UPDATE\');">&nbsp;</i><i title="Delete theme properties" class="icon-trash alignMiddle" onclick="editTheme(\''+index+'\', \'DELETE\');"></i></span></td></tr>');
		});
	}

	function editPanel(panelLabel, mode, selectedblocks){
		data = jQuery(".panelBlockSelectionModalData").html();
		app.showModalWindow(data);
		jQuery(".vtselector").val([]);
		switch (mode)
		{
		case "INSERT" :
			panelLabel="New Panel";
			jQuery(".panelBlockSelectionModal").find("#panelLabel").prop('type', 'text');
			jQuery(".panelBlockSelectionModal").find(".panellabelfield").show();
			break;
		case "UPDATE" :
			jQuery(".panelBlockSelectionModal").find(".panellabelfield").hide();
			jQuery(".panelBlockSelectionModal").find("#panelLabel").prop('type', 'hidden');
			selectedblocks=selectedblocks.split(',');
			jQuery.each(selectedblocks, function(index, value){
				jQuery(".vtselector option:contains(" + value + ")").attr('selected', 'selected');
				//$("#HowYouKnow option").each(function() {
				//  if($(this).text() == theText) {
				//    $(this).attr('selected', 'selected');            
				//  }                        
				//});
			});
			break;
		default :
			break;
		}

		jQuery(".panelBlockSelectionModal").find("#panelHeader").html(panelLabel);
		jQuery(".panelBlockSelectionModal").find("#panelLabel").val(panelLabel);
		jQuery('.panelBlockSelectionModal').removeClass("hide");

		jQuery(".panelBlockSelectionModal").find(".cancelLink").click(function(){
			jQuery('.panelBlockSelectionModal').addClass('hide');
			jQuery(selectElement).select2("destroy");
		});

		var selectElement = jQuery(".panelBlockSelectionModal").find(".vtselector");
		app.changeSelectElementView(selectElement, 'select2', {maximumSelectionSize: 12, dropdownCss : {}});

		jQuery('.panelBlockSelectionForm').on('submit',function(e) {
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
				'enabled' : true
				}
			});
			jQuery(selectElement).select2("destroy");
			var params = jQuery(e.currentTarget).serializeFormData();
			params['blockIds'] = params['blockIds'].toString();
			params['module'] = 'vtDZiner';
			params['parent'] = 'Settings';
			params['action'] = 'Module';
			params['vtpanelaction'] = mode;
			params['mode'] = 'savePanelInfo';
			hideparams = {};
			hideparams['mode'] = 'hide';
			panelLabel = params['panelLabel'];
			blockIds = params['blockIds'];
			AppConnector.request(params).then(
				function(data) {
					progressIndicatorElement.progressIndicator(hideparams);
					var params = {};
					if (data.success){
						params['text'] = data.result.message;
						getPanelInfo();
					} else {
						params['text'] = data.error.message;
						params['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					progressIndicatorElement.progressIndicator(hideparams);
					alert("Error");
				}
			);
			jQuery('.panelBlockSelectionModal').addClass("hide");
			app.hideModalWindow();

		});
	}

	function showThemePalette(themeLabel, mode){
			jQuery(".InstalledThemes").addClass("hide");
			jQuery(".ThemeCssScript").addClass("hide");
			jQuery(".ThemePalette").removeClass("hide");
	}

	function viewThemeList(themeLabel, mode){
			jQuery(".InstalledThemes").removeClass("hide");
			jQuery(".ThemeCssScript").addClass("hide");
			jQuery(".ThemePalette").addClass("hide");
	}

	function viewThemeCSS(themeLabel, mode){
			var fieldsrequest = new XMLHttpRequest();
			fieldsrequest.open('GET', 'layouts/vlayout/skins/almond/style.css', false);  // `false` makes the request synchronous
			fieldsrequest.send(null);
			if (fieldsrequest.status === 200) {
					cssText = fieldsrequest.responseText;
					var allCssClasses = getAllCSSClasses(cssText);
					cssText = "/*Edited by vtThemeDZiner*/\n\n"+ fieldsrequest.responseText;
					jQuery(".ThemeCssScript").find("#cssScriptTextArea").val(cssText);
					jQuery(".ThemeCssScript").find("#cssScriptTextArea").on('keyup keypress click change' ,function() {
						jQuery("#caretpos").html(doGetCaretPosition(document.getElementById("cssScriptTextArea")));
					});
			} else {
				alert("Error in getting style sheet, error code received " + fieldsrequest.status);
			}
			jQuery(".InstalledThemes").addClass("hide");
			jQuery(".ThemeCssScript").removeClass("hide");
			jQuery(".ThemePalette").addClass("hide");
	}

	function findTextInCssScript(searchText){
		cursor_pos = doGetCaretPosition(document.getElementById('cssScriptTextArea'));
		var str = document.getElementById('cssScriptTextArea').value;
		var loc = str.indexOf(searchText, cursor_pos); 
		if (loc == -1) alert("No more found");
		setCaretPosition(document.getElementById('cssScriptTextArea'), loc+1);
		document.getElementById('cssScriptTextArea').selectionStart = loc;
		document.getElementById('cssScriptTextArea').selectionEnd = loc + searchText.length;
		document.getElementById('cssScriptTextArea').focus();
		document.getElementById('CssSearchText').value=searchText;
		document.getElementById('CssSearchText').focus();
		//jQuery('#cssScriptTextArea').highlightTextarea({words: [searchText] });
	}

	function getAllCSSClasses(text){
		//var regex = '/(\w+)?(\s*>\s*)?(#\w+)?\s*(\.\w+)?\s*{/'; // Class Names
		//var allClassNames = text.match(/(\w+)?(\s*>\s*)?(#\w+)?\s*(\.\w+)?\s*{/gm);
		var allClassNames = text.match(/\.-?[_a-zA-Z]+[_a-zA-Z0-9-]*\s*\{/gm);
		jQuery.each(allClassNames, function(index,value){
			value = value.replace(/\s*{/,"");
			allClassNames[index]=value;
			//jQuery('#styleClassNames').append('<option selected="selected" value="'+value+'">'+value+'</option>');
		});
		jQuery( "#styleClassNames" ).autocomplete({source: allClassNames, select: function( event, ui ) {
			findTextInCssScript(ui["item"]["value"]);
		}});
	}

	/*
	FROM
	http://blog.vishalon.net/index.php/javascript-getting-and-setting-caret-position-in-textarea/
	*/

	function setCaretProcess() {
		var no = document.getElementById('caretPosition').value;
		setCaretPosition(document.getElementById('cssScriptTextArea'),no);
	}

	function doGetCaretPosition (ctrl) {
		var CaretPos = 0;	// IE Support
		if (document.selection) {
		ctrl.focus ();
			var Sel = document.selection.createRange ();
			Sel.moveStart ('character', -ctrl.value.length);
			CaretPos = Sel.text.length;
		}
		// Firefox support
		else if (ctrl.selectionStart || ctrl.selectionStart == '0')
			CaretPos = ctrl.selectionStart;
		return (CaretPos);
	}

	function setCaretPosition(ctrl, pos){
		if(ctrl.setSelectionRange)
		{
			ctrl.focus();
			ctrl.setSelectionRange(pos,pos);
		}
		else if (ctrl.createTextRange) {
			var range = ctrl.createTextRange();
			range.collapse(true);
			range.moveEnd('character', pos);
			range.moveStart('character', pos);
			range.select();
		}
	}

	function editTheme(themeLabel, mode){
		data = jQuery(".themeBlockSelectionModalData").html();
		jQuery(".themeBlockSelectionModalData").find("#themeBaseColor").height( 50 );
		app.showModalWindow(data);
		jQuery(".vtselector").val([]);
		switch (mode)
		{
		case "INSERT" :
			themeLabel="New Theme";
			jQuery(".themeBlockSelectionModal").find("#themeLabel").prop('type', 'text');
			jQuery(".themeBlockSelectionModal").find(".themelabelfield").show();
			break;
		case "UPDATE" :
			jQuery(".themeBlockSelectionModal").find(".themelabelfield").hide();
			jQuery(".themeBlockSelectionModal").find("#themeLabel").prop('type', 'hidden');
			break;
		case "DELETE" :
		default :
			break;
		}

		jQuery(".themeBlockSelectionModal").find("#themeHeader").html(themeLabel);
		jQuery(".themeBlockSelectionModal").find("#themeLabel").val(themeLabel);
		jQuery('.themeBlockSelectionModal').removeClass("hide");

		jQuery(".themeBlockSelectionModal").find(".cancelLink").click(function(){
			jQuery('.themeBlockSelectionModal').addClass('hide');
			jQuery(selectElement).select2("destroy");
		});

		var selectElement = jQuery(".themeBlockSelectionModal").find(".vtselector");
		app.changeSelectElementView(selectElement, 'select2', {maximumSelectionSize: 12,dropdownCss : {}});

		jQuery('.themeBlockSelectionForm').on('submit',function(e) {
			var progressIndicatorElement = jQuery.progressIndicator({
				'position' : 'html',
				'blockInfo' : {
				'enabled' : true
				}
			});
			jQuery(selectElement).select2("destroy");
			var params = jQuery(e.currentTarget).serializeFormData();
			params['module'] = 'vtDZiner';
			params['parent'] = 'Settings';
			params['action'] = 'Module';
			params['vtthemeaction'] = mode;
			params['mode'] = 'saveThemeInfo';
			hideparams = {};
			hideparams['mode'] = 'hide';
			themeLabel = params['themeLabel'];
			AppConnector.request(params).then(
				function(data) {
					progressIndicatorElement.progressIndicator(hideparams);
					displayThemes();
					var params = {};
					if (data.success){
						params['text'] = data.result.message;
					} else {
						params['text'] = data.error.message;
						params['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					progressIndicatorElement.progressIndicator(hideparams);
					alert("Error");
				}
			);
			jQuery('.themeBlockSelectionModal').addClass("hide");
			app.hideModalWindow();
		});
	}

	function addFilterView(source_module){
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
			'enabled' : true
			}
		});
		hideparams = {};
		hideparams['mode'] = 'hide';
		var params = {};
		params['module'] = 'CustomView';
		params['source_module'] = source_module;
		params['view'] = 'EditAjax';

		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator(hideparams);
				jQuery(".editCustomView").html(data);
				jQuery(".editCustomView").removeClass("hide");
				jQuery("#vtFilterSettings").hide();
				app.changeSelectElementView(jQuery("#viewColumnsSelect"), 'select2', {maximumSelectionSize: 12,dropdownCss : {}});
				mparams = {};
				mparams['text'] = "Create the new filter view";
				Settings_Vtiger_Index_Js.showMessage(mparams);
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				alert("Error");
			}
		);
	}

	function vtplwalker(key, value) {
		var savepath = path;
		path = path ? (path + "::||::" + key) : key;
		if (key=="uitype" && (value=="15" || value=="16")){
			var fieldid=mypath.pop();
			var fields=mypath.pop();
			var blockid=mypath.pop();
			mypath.push(blockid);
			mypath.push(fields);
			mypath.push(fieldid);

			pllabel = vtBlockDetail[blockid][fields][fieldid].label;
			var pickfieldinfo = vtBlockDetail[blockid][fields][fieldid].fieldInfo;
			if(typeof pickfieldinfo != 'undefined'){
				//picklistvalues
				plvalues = Object.keys(vtBlockDetail[blockid][fields][fieldid].fieldInfo.picklistvalues);
				plparams[pllabel] = plvalues;
			}
			vtDZ_pickBlocks[pllabel] = [];
			plFieldBlockId[pllabel] = vtBlockDetail[blockid]["id"];
			plFieldId[pllabel] = vtBlockDetail[blockid][fields][fieldid].id;
			plFieldName[pllabel] = vtBlockDetail[blockid][fields][fieldid].name;
			plFieldLabel2Name[vtBlockDetail[blockid][fields][fieldid].name] = pllabel;

			jQuery(".pickblocklist").append("<tr><td>" + pllabel + "</td><td id='"+pllabel+"' title='Click to select pick blocks for "+pllabel+"' onclick='selectPickBlocks(this, \""+pllabel+"\");'>No blocks selected</td><td>" + getLinkHtml(plvalues, pllabel) + "</td><td><span class ='pull-right'><i title='Clear pickblocks for "+ pllabel +"' class='icon-trash alignMiddle' onclick='clearPickBlocks(\""+ pllabel +"\");'></i>&nbsp;<i title='Save pickblocks for "+ pllabel +" field' class='icon-plus alignMiddle' onclick='savePickBlocks(\""+ pllabel +"\");'></i><br/><button id='save_"+pllabel+"' style='display:none' type='button' class='btn btn-success' onclick='savePickBlocks(\""+ pllabel +"\");'><strong>Save</strong></button></span></td></tr>");
		}
		if (value !== null && typeof value === "object") {
			// Recurse into children
			mypath.push(key);
			jQuery.each(value, vtplwalker);
			mypath.pop();
		}
		path = savepath;
	}

	function setUpPickBlocks(){
		jQuery.each(pickBlocks, function(index, value){
			pbHtml="";
			jQuery.each(value, function(i,e){
				jQuery("[id='pickblock_"+plFieldLabel2Name[index]+"_"+i+"']").text(blocksList[e]);
				pbHtml += blocksList[e] + "<br/>";
				vtDZ_pickBlocks[plFieldLabel2Name[index]].push(e);
			});
			jQuery("[id='"+plFieldLabel2Name[index]+"']").html(pbHtml);

		});
	}

	function getLinkHtml(pickkeys, pllabel){
		var plHtml = "";
		jQuery.each(pickkeys, function(index, value){
			plHtml += '<span><a href="javascript:selectPickBlock(\''+value+'\', \''+pllabel+'\');" title="Display Block :: '+getPickblock(value,pllabel)+', click to modify">'+value+'</a></span><span class="pull-right" id="pickblock_' + pllabel + '_' + value + '">'+getPickblock(value,pllabel)+'</span><br/>';
		});

		return plHtml;
	}

	function checkAllSelected(pickkey){
		var allSelected = true;
		jQuery("[id^='pickblock_"+ pickkey+ "_"+"']").each(function(){
			if (jQuery(this).html() == "Not selected") {
				allSelected = false;
			}
		});
		return allSelected;
	}

	function savePickBlocks(pickkey){
		// validations
		// pickblocks must be selected
		// all value assignments to be completed
		mode = "INSERT";
		var params = {};
		var mparams = {};
		if (vtDZ_pickBlocks[pickkey].length > 0) {
			if (checkAllSelected(pickkey)) {
				params['module'] = 'vtDZiner';
				params['parent'] = 'Settings';
				params['action'] = 'Module';
				params['vtpanelaction'] = mode;
				params['mode'] = 'savePickblockInfo';
				params['sourceModule'] = sourceModule;
				params['tabid'] = tabid;

				params['picklist'] = pickkey;
				params['pickBlocks'] = vtDZ_pickBlocks[pickkey];
				params['pickBlock']  = pickBlock;
				pldbvalues = [];
				jQuery.each(pickBlock[pickkey], function(index, value){
					pldbvalues.push([params['tabid'], pickkey, plFieldId[pickkey], plFieldName[pickkey], index, value[0], value[1]]);
				});
				
				params['pldbvalues'] = pldbvalues;

				// Ajax here
				AppConnector.request(params).then(
					function(data) {
		//				progressIndicatorElement.progressIndicator(hideparams);
						if (data.success){
							mparams['text'] = data.result.message;
							
						} else {
							mparams['text'] = data.error.message;
							mparams['type'] = 'error';
						}
					},
					function(error) {
						//progressIndicatorElement.progressIndicator(hideparams);
						alert("Error");
					}
				);
				mparams['text'] = 'Saved Pickblocks selected for picklist field '+ pickkey;
			} else {
				mparams['type'] = 'error';
				mparams['text'] = 'Pickblock assignments incomplete for picklist field '+ pickkey;
			}
		} else {
			mparams['text'] = 'No Pickblocks selected for picklist field '+ pickkey;
			mparams['type'] = 'error';
		}

		Settings_Vtiger_Index_Js.showMessage(mparams);
	}

	function clearPickBlocks(pickkey){
		jQuery("[id^='pickblock_"+pickkey+"_']").text("Not selected");
		vtDZ_pickBlocks[pickkey] = [];
		jQuery("#"+pickkey).html("No blocks selected");
		jQuery("[id='save_"+pickkey+"']").hide();
		var params ={};
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['vtpanelaction'] = "DELETE";
		params['mode'] = 'savePickblockInfo';
		params['sourceModule'] = sourceModule;
		params['tabid'] = tabid;
		params['picklist'] = pickkey;
		var message = app.vtranslate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE_PICKBLOCKS');
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(
		function(e) {
			AppConnector.request(params).then(
				function(data) {
					//progressIndicatorElement.progressIndicator(hideparams);
					mparams={};
					
					if (data.success){
						mparams['text'] = data.result.message;
					} else {
						mparams['text'] = data.error.message;
						mparams['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(mparams);
				},
				function(error) {
					//progressIndicatorElement.progressIndicator(hideparams);
					alert("Error");
				}
			);
		});
	}

	function selectPickBlocks(pickarea, pickkey){
		data = jQuery(".pickBlocksSelectionModalData").html();
		app.showModalWindow(data);
		var selectElement = jQuery(".pickBlocksSelectionModal").find(".vtselector");
		jQuery(selectElement).empty();
		jQuery.each(blocksList, function(index, value){
			if (plFieldBlockId[pickkey] != index.toString()) {
				if (jQuery.inArray(index.toString(), vtDZ_pickBlocks[pickkey]) > -1  ) {
					selectElement.append('<option selected value="'+index+'" data-label="'+value+'">'+value+'</option>');
				} else {
					selectElement.append('<option value="'+index+'" data-label="'+value+'">'+value+'</option>');
				}
			}
		});
		app.changeSelectElementView(selectElement, 'select2', {maximumSelectionSize: 12, dropdownCss : {}});

		//jQuery(".vtselector").val([]);
		//jQuery(".pickBlocksSelectionModalData vtselector").val([]);
		//$(".pickBlocksSelectionModalData vtselector option").prop("selected", false);

		/* preselect existing blocks */
		jQuery.each(vtDZ_pickBlocks[pickkey], function(index, value){
			jQuery("#pickblockIds option[value='" + value + "']").prop('selected', true);
		});

		jQuery(".pickBlocksSelectionModal").find("#pickblocksHeader").html(pickkey);
		jQuery(".pickBlocksSelectionModal").find("#pickblocksLabel").val(pickkey);
		jQuery('.pickBlocksSelectionModal').removeClass("hide");

		jQuery(".pickBlocksSelectionModal").find(".cancelLink").click(function(){
			jQuery('.pickBlocksSelectionModal').addClass('hide');
			jQuery(selectElement).select2("destroy");
		});

		jQuery('.pickBlocksSelectionForm').on('submit',function(e) {
			jQuery(selectElement).select2("destroy");

			var params = jQuery(e.currentTarget).serializeFormData();
			vtDZ_pickBlocks[pickkey] = params['pickblockIds'];

			blocksHtml = "";
			jQuery.each(params['pickblockIds'], function(index, value){
				blocksHtml += blocksList[value] + "<br/>";
			});

			jQuery("[id='"+pickkey+"']").html(blocksHtml);
			
			jQuery('.pickBlocksSelectionModal').addClass("hide");
			app.hideModalWindow();
			e.preventDefault();
		});
	}

	function selectPickBlock(pickkey, picklist){
		if (vtDZ_pickBlocks[picklist].length != 0) {
			selectBlockForPicklistValue(pickkey, picklist);
		} else {
			var params = {};
			params['text'] = 'No Pickblocks selected for '+ picklist;
			params['type'] = 'error';
			Settings_Vtiger_Index_Js.showMessage(params);
		}
	}

	function selectBlockForPicklistValue(pickkey, picklist){
		data = jQuery(".pickBlockSelectionModalData").html();
		app.showModalWindow(data);
		var selectElement = jQuery(".pickBlockSelectionModal").find(".vtselector");
		jQuery(selectElement).empty();
		jQuery.each(blocksList, function(index, value){
			selectElement.append('<option value="'+index+'" data-label="'+value+'">'+value+'</option>');
		});
		if(typeof pickBlock[picklist] != "undefined") {
			if(typeof pickBlock[picklist][pickkey] != "undefined")
				jQuery(".pickBlockSelectionModal").find(".vtselector").val(pickBlock[picklist][pickkey]);
			else {
				pickBlock[picklist][pickkey] = {};
				jQuery(".pickBlockSelectionModal").find(".vtselector").val("");
			}
		}
		else {
			pickBlock[picklist] = {};
			jQuery(".pickBlockSelectionModal").find(".vtselector").val("");
		}
			//TODO :: STRANGE DIFFERENCE
			//show only the pick blocks from full list 
			jQuery.each(selectElement.find('option'), function(index, value){
				//jQuery(".vtselector option[value='" + value + "']").prop('selected', true);
				// TODO check the string values also in the inArray test
				temparray = Object.keys(vtDZ_pickBlocks[picklist]).map(function (key) {return parseInt(vtDZ_pickBlocks[picklist][key])});
				if (jQuery.inArray(parseInt(jQuery(this).val()), temparray) > -1){
				} else {
					jQuery(this).remove();
				}
			});

		jQuery(".pickBlockSelectionModal").find("#pickblockHeader").html(pickkey);
		jQuery(".pickBlockSelectionModal").find("#pickblockLabel").val(pickkey);
		jQuery('.pickBlockSelectionModal').removeClass("hide");

		jQuery(".pickBlockSelectionModal").find(".cancelLink").click(function(){
			jQuery('.pickBlockSelectionModal').addClass('hide');
			jQuery(selectElement).select2("destroy");
		});

		app.changeSelectElementView(selectElement, 'select2', {maximumSelectionSize: 1,dropdownCss : {}});

		jQuery('.pickBlockSelectionForm').on('submit',function(e) {
			jQuery(selectElement).select2("destroy");
			var params = jQuery(e.currentTarget).serializeFormData();
			jQuery("option:selected", selectElement).each(function(i){
				pickBlock[picklist][pickkey] = [params["blockId"], jQuery(this).text()];
				jQuery("[id='pickblock_"+picklist+"_"+pickkey+"']").text(jQuery(this).text());
			});
			// TODO Refresh the assignment list on screen

			// Show the save button if all selected
			if (checkAllSelected(picklist)) {
				jQuery("[id='save_"+picklist+"']").show();
			}
			jQuery('.pickBlockSelectionModal').addClass("hide");
			app.hideModalWindow();
			e.preventDefault();
		});
	}

	function getPickblock(pickkey, picklist){
			if(typeof pickBlock[picklist] != "undefined") {
			if(typeof pickBlock[picklist][pickkey] != "undefined") {
				}
			else {
				pickBlock[picklist][pickkey] = {};
			}
		}
		else {
			pickBlock[picklist] = {};
			pickBlock[picklist][pickkey] = {};
		}
		return (typeof pickBlock[picklist][1] != "undefined") ? pickBlock[picklist][pickkey][1] : "Not selected";
	}

	// From vtWidgetSettings.tpl
	//http://www.hongjun.sg/2013/10/htmlencode-and-htmldecode-in-javascript.html
	function htmlEncode(value) {
			return jQuery('<div/>').text(value).html();
	}

	function htmlDecode(value) {
		return jQuery('<div/>').html(value).text();
	}

	function toggleWidgetLinkMode(linkmode){
		if (linkmode=='url') {
			jQuery(".modeURLAttributes").removeClass("hide");
			jQuery(".modeHandlerAttributes").addClass("hide");
		} else {
			jQuery(".modeHandlerAttributes").removeClass("hide");
			jQuery(".modeURLAttributes").addClass("hide");
		}
	}
	// End www.hongjun.sg

	function addWidget(){
		//manasa on aug 2 2016
		jQuery(".widgetProperties").find("[name='linklabel']").val('');
		jQuery(".widgetProperties").find("[name='linkid']").val('');
		jQuery(".widgetProperties").find("[name='linkurl']").val('');
		jQuery(".widgetProperties").find("[name='linkicon']").val('');
		jQuery(".widgetProperties").find("[name='linktype']").val('');
		jQuery(".widgetProperties").find("[name='handler_path']").val('');
		jQuery(".widgetProperties").find("[name='handler_class']").val('');
		jQuery(".widgetProperties").find("[name='handler']").val('');
		jQuery(".widgetProperties").find("[name='sequence']").val('');
		jQuery(".widgetProperties").find("[name='linkdescription']").val('');
		//jQuery("#linktype").trigger("change");
		//jQuery(".widgetProperties").find("[name='tabid']").val(widgetObject[index].tabid);
		//jQuery(".widgetProperties").find("[name='vtwidgettableid']").val('');
		//manasa ended here
		jQuery(".WidgetList").addClass("hide");
		jQuery(".addWidgetForm").removeClass("hide");
		jQuery(".widgetProperties").find("[name='vtwidgetaction']").val("INSERT");
		jQuery("#vtWidgetFormTitle").html("<h3>New Widget</h3>");
	}

	function showWidgetList(){
		jQuery(".widgetlist > tbody").empty();
		jQuery.each( widgetObject, function( index, value ) {
			//manasa added on aug 2 2016 deletewidget
			//console.log(index);
			if('linkid' in value){
			jQuery(".widgetlist").append("<tr><td>"+value.linklabel+"</td><td>"+value.linktype+"</td><td>"+value.linkurl+"</td><td><span class='pull-right'><i title='Edit widget properties' class='icon-pencil alignMiddle' onclick='editWidget("+value.linkid+");'></i><i title='Edit widget properties' class='icon-trash alignMiddle' onclick='deleteWidget("+value.linkid+");'></i></td></tr>");
			}
		});
	}
		jQuery("#listViewvtdzinerNextPageButton").click(function(){
		var pagenumber = parseInt(jQuery("#pageToJumpvtdziner").val())+1;
		paginationTest(pagenumber);
	});
	jQuery("#listViewvtdzinerPreviousPageButton").click(function(){
		var pagenumber = parseInt(jQuery("#pageToJumpvtdziner").val())-1;
		paginationTest(pagenumber);
	});
	jQuery("#pageToJumpvtdziner").change(function(){
		var pagenumber = parseInt(jQuery("#pageToJumpvtdziner").val());
		paginationTest(pagenumber);
	});
jQuery('#listViewvtdzinerPageJumpDropDown').on('click','li',function(e){
			e.stopImmediatePropagation();
		}).on('keypress','#pageToJumpvtdziner',function(e){
			if(e.which == 13){
				var thisInstance = this;
				e.stopImmediatePropagation();
				var element = jQuery(e.currentTarget);
				var response = Vtiger_WholeNumberGreaterThanZero_Validator_Js.invokeValidation(element);
				if(typeof response != "undefined"){
					element.validationEngine('showPrompt',response,'',"topLeft",true);
				} else {
					element.validationEngine('hideAll');
					var currentPageElement = jQuery('#pageNumbervtdziner');
					var currentPageNumber = currentPageElement.val();
					//var newPageNumber = parseInt(jQuery(e.currentTarget).val());
					var newPageNumber = parseInt(jQuery("#pageToJumpvtdziner").val());
					//paginationTest(pagenumber);
					var totalPages = parseInt(jQuery('#totalPageCount').text());
					if(newPageNumber > totalPages){
						var error = app.vtranslate('JS_PAGE_NOT_EXIST');
						element.validationEngine('showPrompt',error,'',"topLeft",true);
						return;
					}
					if(newPageNumber == currentPageNumber){
						var message = app.vtranslate('JS_YOU_ARE_IN_PAGE_NUMBER')+" "+newPageNumber;
						var params = {
							text: message,
							type: 'info'
						};
						Vtiger_Helper_Js.showMessage(params);
						return;
					}
					currentPageElement.val(newPageNumber);
					paginationTest(newPageNumber);
				}
				return false;
			}
		});
	function paginationTest(pagenumber){
		var params = {};
		//var tabid = jQuery("#tabid").val();
		params["tabid"] = tabid;
		params["pagenumber"] = pagenumber;
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Paging';
		//params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'getPaginationValues';
		AppConnector.request(params).then(
				function(data) {
					//progressIndicatorElement.progressIndicator(hideparams);
					var params = {};
					if (data.success){
						var widgetObject = jQuery.parseJSON(data.result.result);
						jQuery(".widgetlist > tbody").empty();
						//console.log(widgetObject);
						//console.log(data.result.result.pagination);
						jQuery.each( widgetObject, function( index, value ) {
						//if(typeof value.linklabel != 'undefined' ){
							if('linkid' in value){
								jQuery(".widgetlist").append("<tr><td>"+value.linklabel+"</td><td>"+value.linktype+"</td><td>"+value.linkurl+"</td><td><span class='pull-right'><i title='Edit widget properties' class='icon-pencil alignMiddle' onclick='editWidget("+value.linkid+");'></i><i title='Edit widget properties' class='icon-trash alignMiddle' onclick='deleteWidget("+value.linkid+");'></i></td></tr>");
								}else{
									jQuery("#pageToJump").val(pagenumber);
									jQuery("#pageNumbersText").text(value.range.start+" to "+value.range.end);
									jQuery("#totalNumberOfRecords").text("of "+value.totalcount);
									jQuery("#totalPageCount").text(value.pageCount);
									if(value.prevPageExists){
										jQuery("#listViewvtdzinerPreviousPageButton").removeAttr("disabled");
									}else{
										jQuery("#listViewvtdzinerPreviousPageButton").attr("disabled",true);
									}
									if(value.nextPageExists){
										jQuery("#listViewvtdzinerNextPageButton").removeAttr("disabled");
									}else{
										jQuery("#listViewvtdzinerNextPageButton").attr("disabled",true);
									}
								}
					});
					} else {
						params['text'] = data.error.message;
						params['type'] = 'error';
					}
					//Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					//progressIndicatorElement.progressIndicator(hideparams);
				//	alert("Very serious error. Investigate!!");
				});	
	}
	//manasa added this on aug 3rd 2016
	function showModuleWidgetList(){
		var params = {};
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'getWidgetsList';
		AppConnector.request(params).then(
			function(data) {
				//progressIndicatorElement.progressIndicator(hideparams);
				var params = {};
				if (data.success){
					var widgetObject = jQuery.parseJSON(data.result.result);
					jQuery(".widgetlist > tbody").empty();
					jQuery.each( widgetObject, function( index, value ) {
						//manasa added on aug 2 2016 deletewidget
						//console.log(value.linklabel);
						//console.log("INDEX"+index);if('linkid' in value){
						if(typeof value.linklabel != 'undefined' ){
							if('linkid' in value){
								jQuery(".widgetlist").append("<tr><td>"+value.linklabel+"</td><td>"+value.linktype+"</td><td>"+value.linkurl+"</td><td><span class='pull-right'><i title='Edit widget properties' class='icon-pencil alignMiddle' onclick='editWidget("+value.linkid+");'></i><i title='Edit widget properties' class='icon-trash alignMiddle' onclick='deleteWidget("+value.linkid+");'></i></td></tr>");
								}
							}
					});
					
				}
				//Settings_Vtiger_Index_Js.showMessage(params);
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				console.log("Very serious error. Investigate function showModuleWidgetList in vtDZinerSetup.js");
			}
		);
	}
	//manasa ended here


	function showWidgetListView(){
		jQuery(".WidgetList").removeClass("hide");
		jQuery(".addWidgetForm").addClass("hide");
	}

	function editWidget(index){
		var widgetdetails = getWidgetDetails(index);
	}
	//Manasa added this edit widget to get details
	function getWidgetDetails(index){
		var params = {};
		params["linkid"] = index;
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'getWidgetProperties';
		AppConnector.request(params).then(
			function(data) {
				if (data.success){
					var widgetdata = data.result.message;
					widgetdata = jQuery.parseJSON(widgetdata);
					var urld = widgetdata[0].linkurl;
					var linkurl = htmlDecode(urld);
				
					jQuery(".widgetProperties").find("[name='linklabel']").val(widgetdata[0].linklabel);
					jQuery(".widgetProperties").find("[name='linkid']").val(widgetdata[0].linkid);
					jQuery(".widgetProperties").find("[name='linkurl']").val(linkurl);
					jQuery(".widgetProperties").find("[name='linkicon']").val(widgetdata[0].linkicon);
					jQuery(".widgetProperties").find("[name='linktype']").val(widgetdata[0].linktype);
					jQuery(".widgetProperties").find("[name='handler_path']").val(widgetdata[0].handler_path);
					jQuery(".widgetProperties").find("[name='handler_class']").val(widgetdata[0].handler_class);
					jQuery(".widgetProperties").find("[name='handler']").val(widgetdata[0].handler);
					jQuery(".widgetProperties").find("[name='sequence']").val(widgetdata[0].sequence);
					jQuery(".widgetProperties").find("[name='tabid']").val(widgetdata[0].tabid);
					jQuery(".widgetProperties").find("[name='vtwidgetaction']").val("UPDATE");
					jQuery(".widgetProperties").find("[name='vtwidgettableid']").val(widgetdata[0].tabid);
					var linktype = widgetdata[0].linktype;
					
					jQuery.each(widgetTypesList, function(index, value){
						if(value[0] == linktype){
							jQuery("[name='linkdescription']").val(value[1]);
							var note = value[2]+"<br/><strong>NOTE:</strong>Using a URL type method requires a properly formed.";
							//jQuery(".widgetProperties").find("[name='helpinfoarea'").html(note);
							jQuery('#helpinfoarea').html(note);
						}
					});
					if(linktype == ''){
							jQuery("[name='linkdescription']").val("");
					}
					jQuery(".WidgetList").addClass("hide");
					jQuery(".addWidgetForm").removeClass("hide");
					jQuery("#vtWidgetFormTitle").html("<h3>Edit Widget</h3>");
				}
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				console.log("Very serious error. Investigate function getWidgetDetails in vtDZinerSetup.js");
			}
		);
	}
	//manasa added on aug 2 2016 for widget delete purpose
	function deletePanelInfo(index){
		var params = {};
		params["panelid"] = index;
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'deletePanelInfo';
		var message = app.vtranslate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE');
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(
		function(e) {
			AppConnector.request(params).then(
				function(data) {
					//progressIndicatorElement.progressIndicator(hideparams);
					var params = {};
					if (data.success){
						params['text'] = data.result.message;
						getPanelInfo();
						//showModuleWidgetList();
						paginationTest(1);
					} else {
						params['text'] = data.error.message;
						params['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					progressIndicatorElement.progressIndicator(hideparams);
					console.log("Very serious error. Investigate function deletePanelInfo in vtDzinerSetup.js");
				}
			);
		});
	}
	function getPanelInfo(){
		var params = {};
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'getPanelDetails';
			AppConnector.request(params).then(
				function(data) {
					panelsList = data.result.result;
					displayPanelDetails(panelsList);
				},
				function(error) {
					progressIndicatorElement.progressIndicator(hideparams);
					console.log("Very serious error. Investigate function getPanelInfo in vtDzinerSetup.js");
				}
			);
	}
	function deleteWidget(index){
		var params = {};
		params["linkid"] = index;
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'deleteWidgetProperties';
		var message = app.vtranslate('JS_LBL_ARE_YOU_SURE_YOU_WANT_TO_DELETE');
		Vtiger_Helper_Js.showConfirmationBox({'message' : message}).then(
		function(e) {
			AppConnector.request(params).then(
				function(data) {
					//progressIndicatorElement.progressIndicator(hideparams);
					var params = {};
					if (data.success){
						params['text'] = data.result.message;
						//showModuleWidgetList();
						paginationTest(1);
					} else {
						params['text'] = data.error.message;
						params['type'] = 'error';
					}
					Settings_Vtiger_Index_Js.showMessage(params);
				},
				function(error) {
					progressIndicatorElement.progressIndicator(hideparams);
					console.log("Very serious error. Investigate function deleteWidget in vtDzinerSetup.js");
				}
			);
		});
		jQuery(".WidgetList").removeClass("hide");
		jQuery(".addWidgetForm").addClass("hide");
		
	}
//manasa ended here
	function saveWidget(){
		var linklabel = jQuery("input[name=linklabel]").val();
		var linktype = jQuery("#linktype").val();
		var linksource = jQuery("input[name=linkurl]").val();
		if(linklabel == '' || linktype == '' || linksource == ''){
			alert("Please fill (*) all required elements.");
			return false;
		}
		var progressIndicatorElement = jQuery.progressIndicator({
			'position' : 'html',
			'blockInfo' : {
			'enabled' : true
			}
		});
		hideparams = {};
		hideparams['mode'] = 'hide';
		var params=jQuery(".widgetProperties").serializeFormData();

		// TODO update/refresh of the table is necessary using the index value

		jQuery.extend( widgetObject[params["vtwidgettableid"]], params );
		params["linktype"] = jQuery("#linktype").val();
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['sourceModule'] = jQuery("#selectedModuleName").val();
		params['mode'] = 'saveWidgetProperties';
		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator(hideparams);
				var params = {};
				if (data.success){
					params['text'] = data.result.message;
					//showModuleWidgetList();
					//var pagenumber = parseInt(jQuery("#pageToJump").val());
					paginationTest(1);
				} else {
					params['text'] = data.error.message;
					params['type'] = 'error';
				}
				Settings_Vtiger_Index_Js.showMessage(params);
			},
			function(error) {
				progressIndicatorElement.progressIndicator(hideparams);
				console.log("Very serious error. Investigate function saveWidget in vtDZinerSetup.js");
			}
		);

		jQuery(".WidgetList").removeClass("hide");
		jQuery(".addWidgetForm").addClass("hide");
		//showModuleWidgetList();
	}

	function showLinkDescription(obj){
		var index = jQuery("#linktype")[0].selectedIndex-1;	
		jQuery("[name='linkdescription']").val(widgetTypesList[index][1]);
		var note = widgetTypesList[index][2]+"<br/><strong>NOTE:</strong>Using a URL type method requires a properly formed.";
		jQuery('#helpinfoarea').html(note);
	}

// Document ready state moved to vtDZiner.js

// All done from TPLs

function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
}

jQuery(document).ready(function(){
	vtsourceModule = app.getModuleName();
	viewname = app.getViewName();
	recordid = jQuery("#recordId").val();
	if (exemptModules.indexOf(vtsourceModule) == -1 && typeof vtDZActive !== 'undefined'){
		if (vtDZActive == "ACTIVE") {
			setup_vtDZWYSIWYG(vtsourceModule, viewname, recordid);
			jQuery("head").append(jQuery("<script type='text/javascript' src='libraries/vtDZinerSupport.js'>"));
			jQuery("head").append(jQuery("<script type='text/javascript' src='modules/Vtiger/resources/CkEditor.js'>"));
			jQuery("head").append(jQuery("<script type='text/javascript' src='libraries/jquery/ckeditor/adapters/jquery.js'>"));
			jQuery("head").append(jQuery("<script type='text/javascript' src='libraries/jquery/ckeditor/ckeditor.js'>"));
			jQuery("head").append(jQuery("<script type='text/javascript' src='libraries/jquery/multiplefileupload/jquery_MultiFile.js'>"));
		} else { 
			var aDeferred = jQuery.Deferred();
			var params = {};
			params['module'] = 'vtDZiner';
			params['parent'] = 'Settings';
			params['view'] = 'Index';
			params['mode']   = 'checkvtDZAllowed';
			AppConnector.request(params).then(
				function(data) {
					if (data.lastIndexOf("FAILURE:||:", 0) === 0 || data.lastIndexOf('<div class="container-fluid">', 0) === 0){
						window.location.href ="index.php?module=vtDZiner&parent=Settings";
					} else {
						data = eval("(" + data + ")");
						switch (data.result.message){
						case "vtDZiner key successful":
							setup_vtDZWYSIWYG(vtsourceModule, viewname, recordid);
							break;
						
						case "vtDZiner is disabled":
							break;

						default :
							window.location.href ="index.php?module=vtDZiner&parent=Settings";
							break;
						}
					}
				},
				function(error) {
					window.location.href ="index.php?module=vtDZiner&parent=Settings";
				}
			);
		}
	}
});

function showMessage(customParams) {
	var params = {};
	params.animation = "show";
	params.type = 'info';
	params.title = app.vtranslate('JS_MESSAGE');

	if(typeof customParams != 'undefined') {
			var params = jQuery.extend(params,customParams);
	}
	Vtiger_Helper_Js.showPnotify(params);
}

function addCustomBlock() {
	var params = {
		module : 'vtDZiner',
		parent : 'Settings',
		sourceModule : app.getModuleName(),
		view : 'IndexAjax',
		mode : 'getCustomBlockForm'
	}
	AppConnector.request(params).then(function(data) {
	app.showModalWindow(data);
	form = jQuery('.addCustomBlockForm');
	var select2params = {formatResult: formatforSelect2, formatSelection: formatforSelect2};
	app.showSelect2ElementView(form.find('.vtselector'), select2params);
	var select2params = {}
	var select2params = {tags: [],tokenSeparators: [","]}
	app.showSelect2ElementView(form.find('[name="pickListValues"]'), select2params);
	registerAddBlock(jQuery(data), form);
	});
}

function registerAddBlock (data, form) {
	jQuery('.addCustomBlockForm').on('submit',function(e) {
		var aDeferred = jQuery.Deferred();
		var progressIndicatorElement = jQuery.progressIndicator(
			{
				'position' : 'html',
				'blockInfo' : { 'enabled' : true }
			}
		);
		var form = jQuery(e.currentTarget);
		var params = jQuery(e.currentTarget).serializeFormData();
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings',
		params['sourceModule'] =app.getModuleName(),
		params['view'] = 'IndexAjax';
		params['mode'] = 'addCustomBlock';
		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				//aDeferred.resolve(data);
				data=jQuery.parseJSON( data );
				app.hideModalWindow();
				params['text'] = data.result+"\nRefreshing automatically after a second";
				params['type'] = 'success';
				showMessage(params);
				setTimeout(function () {
					window.location.reload();
				}, 1000);  // After 1 secs
			},
			function(error) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				//aDeferred.reject(error);
			}
		);
		e.preventDefault();
	});
}

function formatforSelect2(option){
	var originalText = option.text;
	if (typeof option.element != "undefined"){
		return "<span data-toggle='tooltip' title ='" + option.element[0].title + "'>" + originalText + "</span>";
	} else {
		return originalText;
	}
}

function newCustomFields(obj, blockId, recordid, modulename) {
	var progressIndicatorElement = jQuery.progressIndicator({'position':'html', 'message':"<h4>Loading new custom fields form</h4>", 'blockInfo':{'enabled':true}});	
	var params = {
		module : 'vtDZiner',
		parent : 'Settings',
		source_module : app.getModuleName(),
		view : 'IndexAjax',
		mode : 'GetNewFieldsForm',
		blockid : blockId,
		recordid : recordid
	}

	AppConnector.request(params).then(function(data) {
		progressIndicatorElement.progressIndicator({'mode' : 'hide'});
		app.showModalWindow(data);
		var contents = jQuery('#addCustomFieldsContainer').find('.contents');
		form = contents.find('.addCustomFields');
		var select2params = {};
		var select2params = {formatResult: formatforSelect2, formatSelection: formatforSelect2};
		app.showSelect2ElementView(contents.find('select'), select2params);
		var select2params = {};
		var select2params = {tags: [],tokenSeparators: [","]}
		app.showSelect2ElementView(form.find('[name="pickListValues"]'), select2params);
		registerAddFields(jQuery(data), form);
	});
}

function registerAddFields (data, form) {
	// customised overriding of form validation
	jQuery('#addCustomFields').on('submit',function(e) {
		var form = jQuery(e.currentTarget);
		var params = jQuery(e.currentTarget).serializeFormData();
		for (numfields=0;numfields<10;numfields++){
			j=numfields+1;
			fl_key="fieldLabel["+j+"]";
			ui_key="fieldType["+j+"]";
			ln_key="fieldlength["+j+"]";
			dc_key="fielddecimallength["+j+"]";
			pv_key="fieldpicklistvalues["+j+"]";
			rm_key="fieldrelatedmodule["+j+"]";
			if (params[fl_key]==""){
				break;
			}
		}
		formisvalid = false;
		if (numfields > 0){
			// temporarily disabling input fields which are have no fieldlabel, indicating end of fields submitted
			// to take care for the validation
			// if unsucessful to reenable

			for (j=numfields+1;j<=10 ;j++ ){
				fl_key="fieldLabel["+j+"]";
				ui_key="fieldType["+j+"]";
				ln_key="fieldlength["+j+"]";
				dc_key="fielddecimallength["+j+"]";
				pv_key="fieldpicklistvalues["+j+"]";
				rm_key="fieldrelatedmodule["+j+"]";
				form.find('[name="'+fl_key+'"]').prop('disabled',true);
				form.find('[name="'+ui_key+'"]').prop('disabled',true);
				form.find('[name="'+ln_key+'"]').prop('disabled',true);
				form.find('[name="'+dc_key+'"]').prop('disabled',true);
				form.find('[name="'+pv_key+'"]').prop('disabled',true);
				form.find('[name="'+rm_key+'"]').prop('disabled',true);
			}

			formisvalid = form.validationEngine('validate')

			for (j=numfields+1;j<=10 ;j++ ){
				fl_key="fieldLabel["+j+"]";
				ui_key="fieldType["+j+"]";
				ln_key="fieldlength["+j+"]";
				dc_key="fielddecimallength["+j+"]";
				pv_key="fieldpicklistvalues["+j+"]";
				rm_key="fieldrelatedmodule["+j+"]";
				form.find('[name="'+fl_key+'"]').prop('disabled',false);
				form.find('[name="'+ui_key+'"]').prop('disabled',false);
				form.find('[name="'+ln_key+'"]').prop('disabled',false);
				form.find('[name="'+dc_key+'"]').prop('disabled',false);
				form.find('[name="'+pv_key+'"]').prop('disabled',false);
				form.find('[name="'+rm_key+'"]').prop('disabled',false);
			}

			if (formisvalid){
				params['blockid'] = form.find('[name="hdn_blockid"]').val();
				params['module'] = 'vtDZiner';
				params['parent'] = 'Settings',
				params['sourceModule'] =app.getModuleName(),
				params['numfields'] = numfields;
				params['view'] = 'IndexAjax';
				params['mode'] = 'Addfields';
				if (params["createNewBlock"] == "on") {
					bparams={};
					bparams['blockType'] = 'Standard';
					bparams['label'] = params['newBlockLabel'];
					bparams['beforeBlockId'] = form.find('[name="hdn_blockid"]').val();
					bparams['mode'] = 'save';
					bparams['action'] = 'Block';
					bparams['module'] = 'vtDZiner';
					bparams['parent'] = 'Settings',
					bparams['sourceModule'] =app.getModuleName(),
					AppConnector.request(bparams).then(
						function(data) {
							if (data.success) {
								app.hideModalWindow();
								showMessage({"text":"New block "+data.result.label+" created, now creating fields", "type":"success"});
								params['blockid'] = data.result.id;
								AppConnector.request(params).then(function(data) {
									showMessage({"text":"<strong>Custom fields created in new block</strong>", "type":"success"});
									window.location.reload();
								});
							}
						}
					);
				} else {
					AppConnector.request(params).then(function(data) {
						app.hideModalWindow();
						showMessage({"text":"<strong>Custom fields created in current block</strong>", "type":"success"});
						window.location.reload();
					});
				}
			}
		} else {
				bootbox.alert("<strong>At least one new field must be described to submit this form. Click the Cancel link in the form otherwise</strong>");
		}
		e.preventDefault();
	});
}

function newCustomField(obj, blockId, recordid, modulename) {
	var progressIndicatorElement = jQuery.progressIndicator({'position':'html', 'message':"<h4>Loading new custom field form</h4>", 'blockInfo':{'enabled':true}});
	var params = {
		module : 'vtDZiner',
		parent : 'Settings',
		source_module : app.getModuleName(),
		view : 'IndexAjax',
		mode : 'GetNewFieldForm',
		blockid : blockId,
		recordid : recordid
	}

	AppConnector.request(params).then(function(data) {
		progressIndicatorElement.progressIndicator({'mode':'hide'});
		app.showModalWindow(data);
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		form = contents.find('.addCustomField');
		var select2params = {formatResult: formatforSelect2, formatSelection: formatforSelect2};
		app.showSelect2ElementView(contents.find('select'), select2params);
		var select2params = {}
		var select2params = {tags: [],tokenSeparators: [","]}
		app.showSelect2ElementView(form.find('[name="pickListValues"]'), select2params);
		registerAddField(jQuery(data), form);
	});
}

function registerAddField (data, form) {
	jQuery('#addCustomField').find('[name="fieldType"]').on('change', function(e) {
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		form = contents.find('.addCustomField');
		var currentTarget = jQuery(e.currentTarget);
		var lengthInput = jQuery('#addCustomField').find('[name="fieldLength"]');
		var lengthValidator = [{'name' : 'DecimalMaxLength'}];
		var maxLengthValidator = [{'name' : 'MaxLength'}];
		var decimalValidator = [{'name' : 'FloatingDigits'}];
		lengthInput.data('validator', maxLengthValidator);
		var lengthInput = jQuery('#addCustomField').find('[name="fieldLength"]');
		var selectedOption = currentTarget.find('option:selected');

		//hide all the elements like length, decimal,picklist 
		jQuery('#addCustomField').find('.supportedType').addClass('hide');
		var contents = jQuery('#layoutEditorContainer').find('.contents');
		if(selectedOption.data('lengthsupported')) {
			form.find('.lengthsupported').removeClass('hide');
			lengthInput.data('validator', maxLengthValidator);
		}
		
		if(selectedOption.data('decimalsupported')) {
			var decimalFieldUi = jQuery('#addCustomField').find('.decimalsupported');
			decimalFieldUi.removeClass('hide');
			var decimalInput = decimalFieldUi.find('[name="decimal"]');
			var maxFloatingDigits = selectedOption.data('maxfloatingdigits');
			if(typeof maxFloatingDigits != "undefined") {
				decimalInput.data('validator', decimalValidator);
				lengthInput.data('validator', lengthValidator);
			}
			if(selectedOption.data('decimalreadonly')) {
				decimalInput.val(maxFloatingDigits).attr('readonly', true);
			} else {
				decimalInput.removeAttr('readonly').val('');
			}
		}
		
		if(selectedOption.data('predefinedvalueexists')) {
			var pickListUi = jQuery('#addCustomField').find('.preDefinedValueExists');
			pickListUi.removeClass('hide');	
		}
		if(selectedOption.data('picklistoption')) {
			var pickListOption = jQuery('#addCustomField').find('.picklistOption');
			pickListOption.removeClass('hide');	
		}
		// Added STP 11 December 2014 for UI Type 10
		if(selectedOption.data('relatedtooption')) {
			var relatedtoOption = jQuery('#addCustomField').find('.relatedtoOption');
			relatedtoOption.removeClass('hide');
			// set the field label initial value 
			//form.find('[name="fieldLabel"]').val("Initial Value");
		}
	
	});

	jQuery('#addCustomField').on('submit',function(e) {
	var form = jQuery(e.currentTarget);
	var validationResult = form.validationEngine('validate');

	if (validationResult) {
		var params = jQuery(e.currentTarget).serializeFormData();
		params['blockid'] = form.find('[name="hdn_blockid"]').val();
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings',
		params['sourceModule'] =app.getModuleName(),
		params['view'] = 'IndexAjax';
		params['mode'] = 'Addfield';
		AppConnector.request(params).then(function(data) {
			window.location.reload();
				if(typeof data.result != 'undefined') {
					//app.hideModalWindow();
					//Settings_Vtiger_Index_Js.showMessage({text:app.vtranslate('JS_VALUE_ASSIGNED_SUCCESSFULLY'),type : 'success'})
				}
			});
	}
	e.preventDefault();
	
	});
}

function registerEditField (data, form) {
	// Any form setup functions here via jquery

	jQuery("#saveFieldDetails").on('click',function(e) {
	params = [];
	params['module'] = 'vtDZiner';
	params['parent'] = 'Settings';
	params['sourceModule'] =app.getModuleName();
	params['view'] = 'IndexAjax';
	params['mode'] = 'ModifyFieldAttributes';
	params['fieldid'] = jQuery('[name="hdn_fieldid"]').val();
	params['fieldlabel'] = jQuery("#txtfieldlabel").val();
	params['mandatory'] = jQuery("#cbmandatory").prop('checked');
	params['presence'] = jQuery("#cbpresence").prop('checked');
	params['summaryfield'] = jQuery("#cbsummaryfield").prop('checked');
	params['quickcreate'] = jQuery("#cbquickcreate").prop('checked');
	params['masseditable'] = jQuery("#cbmasseditable").prop('checked');
	params['helpinfo'] = jQuery("#txthelpinfo").val();
	AppConnector.request(params).then(function(data) {
		if(typeof data.result != 'undefined') {
			params['text'] = app.vtranslate('JS_VALUE_ASSIGNED_SUCCESSFULLY');
			showMessage(params);
		}
		app.hideModalWindow();
		window.location.reload();
		});
	e.preventDefault();
	});
}
function editFieldAttributes(e, elemid, currentmodule){
	//var elemid=jQuery(this).attr('id');
	var elemid_arr=elemid.split('_detailView_fieldLabel_');
	var lastelm= elemid_arr[elemid_arr.length-1];
	var currentmodule=elemid_arr[0];

	e.preventDefault();
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({'position':'html','blockInfo':{'enabled':true}});
	var params = {};
	params['module'] = "vtDZiner";
	params['parent'] = 'Settings';
	params['view'] = 'IndexAjax';
	params['mode'] = 'ModifyFieldInformation';
	params['fieldname'] = lastelm;
	params['status'] = status;
	params['current_module'] = currentmodule;

	AppConnector.request(params).then(
		function(data){
			var callback = function(container){
				
			}
			var params1 = {};
			params1.data = data ;
			params1.css = {'width':'30%','text-align':'left','left':'1.5%'};
			app.showModalWindow(params1,callback);
			registerEditField(jQuery(data), form);
		},
		function(error){
		}
	)
}

function setupFieldWYSIWYG(modulename) {
	jQuery('td[id^="'+modulename+'_detailView_fieldLabel"]').each(function(){
		var fieldlabel = jQuery(this).find("label").filter(":first").text();
		jQuery(this).append('<span id="edit_'+fieldlabel+'" onclick="editFieldAttributes(event, \''+jQuery(this).attr('id')+'\', \''+modulename+'\');"><i class="icon-edit" title="Click to modify settings of\n'+fieldlabel+'"></i></span>');
	});
}

function setupBlockWYSIWYG(modulename, recordid) {
	jQuery(".blockHeader").each(function() {
		jQuery(this).attr("title","Click on the pencil icon to access block & field functions for \n"+jQuery(this).text().trim());
		var blockId = jQuery(this).find("img").filter(":first").data('id');

		blockWYSIWYG_Html = '<div class="actions pull-right"><div class="btn-group cursorPointer"><button class="btn dropdown-toggle" data-toggle="dropdown" href="#"><i class="icon-pencil" title="Block Settings" alt="Block Settings"></i>&nbsp;<i class="caret"></i></button>';
		blockWYSIWYG_Html += '<ul class="listViewSetting dropdown-menu" style="left: -120px;">';
		blockWYSIWYG_Html += '<li><a onclick="newCustomField(this, '+blockId+', '+recordid+',\''+ modulename+'\');" href="#" title="Add a custom field to this block">Add Field</a></li>';
		blockWYSIWYG_Html += '<li><a title="Add multiple custom fields to this block" id="addField_'+blockId+'" onclick="newCustomFields(this, '+blockId+', '+recordid+',\''+ modulename+'\');">Add Fields</a></li>';
		blockWYSIWYG_Html += '<li><a onclick="addCustomBlock();" title="Add Custom Block">Add Block</a></li>';
		if (iF_FieldEdit_Flag){
			blockWYSIWYG_Html += '<li><a onclick="iF_FieldEditSetting(false);" title="Disable field attribute editing">Disable Field Edit</a></li>';
		} else {
			blockWYSIWYG_Html += '<li><a onclick="iF_FieldEditSetting(true);" title="Enable field attribute editing">Enable Field Edit</a></li>';
		}
		blockWYSIWYG_Html += '</ul></div></div>';

		jQuery(this).find("img").filter(":first").closest("th").append(blockWYSIWYG_Html);
	});
}

function iF_FieldEditSetting(setting){
	app.setCookie("iF_FieldEdit_Flag", (setting)?"true":"false", null);
	window.location.reload();
}

function setup_vtDZWYSIWYG(modulename,viewname, recordid) {
    var messagetext = app.getCookie("messagetext");
    if (messagetext != "" && messagetext != null) {
        bootbox.alert(messagetext);
		app.setCookie("messagetext", "", null);
    }

	if (app.getCookie("iF_FieldEdit_Flag") != "true") {
		iF_FieldEdit_Flag = false
		app.setCookie("iF_FieldEdit_Flag", "false", null);
	} else {
		iF_FieldEdit_Flag = true;
	}

	if (InFormMode == false){
		inFormLabel = '<span id=iFDZmode style="color:red;"><input type=radio>&nbsp;On&nbsp;<input type=radio checked>&nbsp;Off</span>';
	} else {
		inFormLabel = '<span id=iFDZmode style="color:red;"><input type=radio checked>&nbsp;On&nbsp;<input type=radio>&nbsp;Off</span>';

	vtDZinerLink = "index.php?parent=Settings&module=vtDZiner&sourceModule="+modulename;
	vtDZWYSIWYG_Html = '<div class="btn-group cursorPointer"><img width="24px" height="24px" class="alignMiddle" src="modules/vtDZiner/vtDZiner.png" alt="vtDZiner" title="Click for vtDZiner Options Menu" data-toggle="dropdown">';
	vtDZWYSIWYG_Html += '<ul class="dropdown-menu">';
	vtDZWYSIWYG_Html += '<li><a onclick="inFormSettings(\'Set/Reset\');" title="Toggle the inForm DZiner mode, allows vtDZiner fuctionality within the module views">inForm DZiner '+inFormLabel+'</a></li>';
	vtDZWYSIWYG_Html += '<li class="divider"></li>';

	vtDZWYSIWYG_Html += '<li><a title="Access a range of module design functions">Module DZiner</a><ul class="dropdown-menu pull-right"><li><a onclick="showModuleDZiner();" title="Create new modules for functional extensions to a Vtiger instance">New Module</a></li><li class="divider"><li><a href="#">Customize</a><ul class="dropdown-menu pull-right"><li class=""><a href="javascript:updateModuleConfig(\'uploadModuleImageIcon\');">Icon/Image</a></li><li class=""><a href="javascript:updateModuleConfig(\'registerCustomWorkflow\');">Workflow Methods</a></li><li class=""><a href="javascript:updateModuleConfig(\'enableTracker\');">Enable Tracker</a></li><li class=""><a href="javascript:updateModuleConfig(\'enablePortal\');">Portal Settings</a></li></ul></li><li><a href="#">Relations</a><ul class="dropdown-menu pull-right"><li><a href="javascript:displayAddChildForm(\'child\',\''+modulename+'\');">Children</a></li><li><a href="javascript:displayAddChildForm(\'parent\',\''+modulename+'\');">Parents</a></li></ul></li><li class="divider"></li><li><a href="#">Management</a><ul class="dropdown-menu pull-right"><li class=""><a href="javascript:updateModuleConfig(\'enablevtDZiner\');">Enable vtDZiner</a></li><li class=""><a href="javascript:updateModuleConfig(\'exportModule\');">Export module</a></li><li class=""><a href="index.php?module=ModuleManager&parent=Settings&view=ModuleImport&mode=importUserModuleStep1">Install from ZIP</a></li><li class=""><a href="javascript:updateModuleConfig(\'disableModule\');">Disable module</a></li><li class=""><a href="javascript:updateModuleConfig(\'removeModule\');">Remove module</a></li></ul></li><li><a href="#">View Configuration</a></li><li><a href="'+vtDZinerLink+'&view=ERMap">ER Map</a></li></ul></li>';

	//vtDZWYSIWYG_Html += '<li><a href="'+vtDZinerLink+'&view=ERMap" title="View the module centric relatonship view in this CRM">ER Map for '+modulename+'</a></li>';

	vtDZWYSIWYG_Html += '<li><a href="#" title="Manage menu categories for modules in this Vtiger instance">Menu DZiner</a><ul class="dropdown-menu pull-right"><li class=""><a href="javascript:updateModuleConfig(\'changeParentCategory\');" title="Change the menu category for '+modulename+'">Modify Module Category</a></li><li><a onclick="displayMenuCategoryForm();" title="Create a new category for modules in this Vtiger instance">New Category</a></li><li><a href="#" title="Manage the categories and linked modules for this instance">Manage Categories</a></li></ul></li>';

	vtDZWYSIWYG_Html += '<li class="divider">';
	vtDZWYSIWYG_Html += '<li><a href="'+vtDZinerLink+'#vtViewDZinerSettings" title="Assign blocks to panels for a better Detail View UI">Panels</a></li>';
	vtDZWYSIWYG_Html += '<li><a href="'+vtDZinerLink+'#vtViewDZinerSettings" title="Manage block visibility on assigned picklist and record value">Pickblocks</a></li>';
	vtDZWYSIWYG_Html += '<li><a href="'+vtDZinerLink+'#vtWidgetDZinerSettings" title="Create widget scaffolding in Vtiger">Widgets</a></li>';
	vtDZWYSIWYG_Html += '<li><a href="'+vtDZinerLink+'#vtLanguageDZinerSettings" title="Manage CRM and module languages">Languages</a></li>';
	vtDZWYSIWYG_Html += '<li class="divider"></li>';
	vtDZWYSIWYG_Html += '<li><a href="'+vtDZinerLink+'" title="Open vtDZiner in Classic Mode for '+modulename+'">Classic Mode</a></li>';
	vtDZWYSIWYG_Html += '<li><a href="https://drive.google.com/file/d/0B_W4iPZxUrNQVjlmTDRicG9LRVU/view?usp=sharing" target="_blank" title="Get documented assistance about vtDZiner">Documentation</a></li>';
	vtDZWYSIWYG_Html += '</ul></div>';

	jQuery(".quickActions").find(".commonActionsButtonContainer").filter(":last").append(vtDZWYSIWYG_Html);
	}
	if (InFormMode){
		if (viewname == 'List') setupListWYSIWYG(modulename);
		if (viewname == 'Detail') setupDetailWYSIWYG(modulename, recordid);
		// TO DO STP Reenable 
		//if (viewname == 'Detail' || viewname == 'List') setupSideBarWYSIWYG(modulename);
		if (viewname == 'Edit') setupEditWYSIWYG(modulename, recordid);
	}
	
	//Settings_vtDZiner_Js.registerChangeParentCategory();

	//showMessage({"text":"<strong>inForm DZiner is now ready</strong>", "type":"success"});
}

function setupSideBarWYSIWYG(modulename) {
	jQuery(".mainContainer").find(".sideBarContents").parent().append('<div class="btn-group cursorPointer"><a data-toggle="dropdown" href="javascript:void(0);" title="Choose from standard widgets or DZine your own"><strong>Sidebar Widget DZiner</strong></a><ul class="dropdown-menu"><li><b>Coming Soon! Please be patient</b></li><li><a onclick=";">Add Chart</a></li><li><a >Add Clock</a></li><li><a >Add Weather</a></li><li><a >Add RSS</a></li><li><a >Add IFRAME</a></li><li><a >Mini Report</a></li><li><a >Hierarchy</a></li><li><a >SideBar DZiner</a></li></ul></div>');
}

function setupListWYSIWYG(modulename) {
	//dropdown_Html = '<div class="btn-group"><a class="btn dropdown-toggle" data-toggle="dropdown" href="#"> vtDZiner <span class="caret"/></a><ul class="dropdown-menu pull-right"><li><a href="#">Settings</a></li><li><a href="#">Customize</a><ul class="dropdown-menu pull-right"><li><a href="#">Parent Category</a><ul class="dropdown-menu pull-right"><li><a href="#">Add</a></li><li><a href="#">Rename</a></li><li><a href="#">Modify</a></li></ul></li><li><a href="#">Icon/Image</a></li><li><a href="#">Workflow Methods</a></li><li><a href="#">Enable Tracker</a></li><li><a href="#">Portal Settings</a></li></ul></li><li><a href="#">Relations</a><ul class="dropdown-menu pull-right"><li><a href="javascript:displayAddChildForm(\'child\',\''+modulename+'\');">Children</a></li><li><a href="javascript:displayAddChildForm(\'parent\',\''+modulename+'\');">Parents</a></li></ul></li><li class="divider"></li><li><a href="#">Management</a><ul class="dropdown-menu pull-right"><li><a href="#">Enable vtDZiner</a></li><li><a href="#">Emport module</a></li><li><a href="#">Install from ZIP</a></li><li><a href="#">Disable module</a></li><li><a href="#">Remove module</a></li></ul></li><li><a href="#">ER Map</a></li></ul></div>';
	//jQuery(".listViewActionsDiv").find(".btn-toolbar").filter(":first").append(dropdown_Html); 

	//TO DO STP BY NEXT RELEASE
	//jQuery(".listViewActionsDiv").find(".btn-toolbar").filter(":first").append('<span class="btn-group"><button data-toggle="dropdown" href="#" class="btn dropdown-toggle" title="Choose from standard widgets or DZine your own"><strong><font color="blue">Widgets</font>&nbsp;&nbsp;<i class="caret"></i></button><ul class="listViewSetting dropdown-menu"><li><a onclick=";">LV Action Link</a></li><li><a href="index.php?parent=Settings&module=vtDZiner&sourceModule='+modulename+'">LV Button</a></li><li><a href="http://help.vtigress.com" target="_blank">LV Settings Link</a></li><li><a href="index.php?parent=Settings&module=vtDZiner&view=ERMap&source_module='+modulename+'">ER Map for '+modulename+'</a></li></ul></span>'); 
}

function setupEditWYSIWYG(modulename, recordid) {
	setupBlockWYSIWYG(modulename, recordid);
	//setupFieldWYSIWYG(modulename);
}

function setupDetailWYSIWYG(modulename, recordid) {

	setupBlockWYSIWYG(modulename, recordid);
	if (iF_FieldEdit_Flag){
		setupFieldWYSIWYG(modulename);
	}

	//TO DO STP BY NEXT RELEASE
	//jQuery(".detailViewInfo").find(".related").prepend('<div class="btn-group cursorPointer pull-right"><a  data-toggle="dropdown" href="javascript:void(0);" title="DZiner new view layouts"><strong>Compose View</strong></a><ul class="dropdown-menu"><li><b>Coming Soon! Please be patient</b></li><li><a >Summary View</a></li><li><a>Clone Detail View</a></li><li><a >Multi Relations</a></li><li><a >Dashboard View</a></li><li><a>Custom View</a></li></ul></div><br/>');
	
	// DEPRECATED
	//TO DO STP BY NEXT RELEASE
	//jQuery(".detailViewButtoncontainer").find('.btn-toolbar').prepend('<span class="btn-group"><button data-toggle="dropdown" class="btn dropdown-toggle" title="Choose from standard widgets or DZine your own"><strong>Widgets</strong>&nbsp;<i class="caret"></i></button><ul class="dropdown-menu pull-right"><li><a onclick=";">DV Button</a></li><li><a onclick=";">DV Action Link</a></li></ul></span>');

	//jQuery(".detailViewButtoncontainer").find('.btn-toolbar').prepend('<span class="btn-group"><button data-toggle="dropdown" class="btn dropdown-toggle" title="Manage relations for this module"><strong>Relations</strong>&nbsp;<i class="caret"></i></button><ul class="dropdown-menu pull-right"><li><a onclick="displayAddChildForm(\'child\',\''+modulename+'\');">Children</a></li><li><a onclick="displayAddChildForm(\'parent\',\''+modulename+'\');">Parents</a></li></ul></span>');
}

function inFormSettings(tparam){
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = {};
	params['module'] = 'vtDZiner';
	params['parent'] = 'Settings';
	params['action'] = 'Field';
	params['mode']   = 'inFormToggle';
	params['tparam'] = tparam;

	AppConnector.request(params).then(
			function(data) {
					progressIndicatorElement.progressIndicator({'mode' : 'hide'});
					//alert(data.result.message+'\n\nYou can change the settings from vtDZiner Options\nCurrent page will be refreshed');
					params['text'] = data.result.message;
					//Settings_Vtiger_Index_Js.showMessage(params);
					showMessage(params);
					window.location.reload();
			},
			function(error) {
					progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			}
	);
}

function saveNewModule(data){
	app.showModalWindow(data);
	jQuery('.addCustomModuleModal').removeClass("hide");
	app.showSelect2ElementView(jQuery(".addCustomModuleModal").find(".vtselector"));
	jQuery('.addCustomModuleForm').on('submit',function(e) {
		var form = jQuery(e.currentTarget);
		if (form.validationEngine('validate')){
			var aDeferred = jQuery.Deferred();
			var progressIndicatorElement = jQuery.progressIndicator({'position':'html', 'message':"<h4>Creating new module ...</h4>", 'blockInfo':{'enabled':true}});	

			//var progressIndicatorElement = jQuery.progressIndicator({'position':'html','blockInfo':{'enabled':true }});
			var params = form.serializeFormData();
				params['module'] = 'vtDZiner';
				params['parent'] = 'Settings',
				params['action'] = 'Module';
				params['mode'] = 'save';
			AppConnector.request(params).then(
				function(data) {
					progressIndicatorElement.progressIndicator({'mode' : 'hide'});
					modulename=data['result']['MODULE'];
					aDeferred.resolve(data);
					switch(params['returnaction']){
						case "vtdziner" :
							window.location = "index.php?parent=Settings&module=vtDZiner&sourceModule="+modulename+"";
						break;
						case "newmodule" :
							window.location = "index.php?module="+modulename+"&view=List";
						break;
						case "showhome" :
							window.location = "index.php?module=Home&view=DashBoard";
						break;
						case "stayback" :
						app.setCookie("messagetext", "New Module "+modulename+" has been created", 1);
						default :
							window.location.reload();
						break;
					}
				},
				function(error) {
					progressIndicatorElement.progressIndicator({'mode' : 'hide'});
					aDeferred.reject(error);
				}
			);
			return aDeferred.promise();
		}
		e.preventDefault();
	});
}

function showModuleDZiner(){
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
				'enabled' : true
		}
	});
	var params = {
		module : 'vtDZiner',
		parent : 'Settings',
		source_module : app.getModuleName(),
		view : 'IndexAjax',
		mode : 'DisplayNewModule',
	}
	AppConnector.request(params).then(
		function(data) {
			saveNewModule(data);
		}
	);
}

function displayMenuCategoryForm() {
	var progressIndicatorElement = jQuery.progressIndicator({'position' : 'html','blockInfo' : {'enabled' : true}});
	var params = {
		module : 'vtDZiner',
		parent : 'Settings',
		source_module : app.getModuleName(),
		view : 'IndexAjax',
		mode : 'DisplayMenuCategory',
	}
	AppConnector.request(params).then(function(data) {	
		saveNewMenuCategory(data);
	});
}

function saveNewMenuCategory(data) {
		app.showModalWindow(data);
		jQuery('.addParentcatModal').removeClass("hide");
		jQuery('.addParentCatForm').on('submit',function(e) {
			var form = jQuery(e.currentTarget);
			if (form.validationEngine('validate')){
				var aDeferred = jQuery.Deferred();
				var progressIndicatorElement = jQuery.progressIndicator(
					{
						'position' : 'html',
						'blockInfo' : { 'enabled' : true }
					}
				);
				var params = form.serializeFormData();
					params['module'] = 'vtDZiner';
					params['parent'] = 'Settings',
					params['action'] = 'Module';
					params['mode']   = 'processparentcat';

				AppConnector.request(params).then(
					function(data) {
						if (data.success){
							progressIndicatorElement.progressIndicator({'mode' : 'hide'});
							aDeferred.resolve(data);
							bootbox.alert(data.result.Parentcatname+", new menu category added");
						} else {
							bootbox.alert("<span class='redColor'><strong>"+data.error.message+"</strong></span>");
							window.location.reload();
						}
					},
					function(error) {
						progressIndicatorElement.progressIndicator({'mode' : 'hide'});
						aDeferred.reject(error);
					}
				);
				return aDeferred.promise();
				//window.location.reload();
			}
			e.preventDefault();
		});
}

function saveChildRelation(data, relation) {
	app.showModalWindow(data, function(data){
		app.showSelect2ElementView(jQuery(data).find(".vtselector"));
		var selectElement = jQuery('#sel_col');
		//jQuery('#sel_col').addClass('chzn-select');
		app.changeSelectElementView(selectElement, 'select2', {maximumSelectionSize: 12,dropdownCss : {}});
		var select2Element = app.getSelect2ElementFromSelect(selectElement);
		var chozenChoiceElement = select2Element.find('ul.select2-choices');
		chozenChoiceElement.sortable({
		'containment': chozenChoiceElement,
		start: function() { jQuery('#selectedColumnsList').select2("onSortStart"); },
		update: function() { jQuery('#selectedColumnsList').select2("onSortEnd"); }
		});
	});
	
	jQuery('.addRelationModal').removeClass("hide");
	jQuery('.addRelationForm').on('submit',function(e) {
	var form = jQuery(e.currentTarget);
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator(
		{
			'position' : 'html',
			'blockInfo' : { 'enabled' : true }
		}
	);

	var params = form.serializeFormData();
		params['module'] = 'vtDZiner';
		params['parent'] = 'Settings';
		params['action'] = 'Module';
		params['mode']   = 'addRelation';
		params['reciprocate']    = 'true';
		params['relationtype']   = relation;
		source_module	 = jQuery('#childmodule').val();
		AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
			if(typeof data.result != 'undefined') {
				params['text'] = data.result.message;
				showMessage(params);
				window.location.reload();
			}
		},

		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);

	return aDeferred.promise();
	e.preventDefault();
	});
}

function displayAddChildForm(relation,selectedModuleName) {
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
				'enabled' : true
		}
	});
    var source_module=selectedModuleName!="" ? selectedModuleName : app.getModuleName();
	var params = {
	module : 'vtDZiner',
	parent : 'Settings',
	source_module : source_module,
	view : 'IndexAjax',
	mode : 'DisplayChildRelForm',
	relationtype : relation
	}

	AppConnector.request(params).then(function(data) {
		saveChildRelation(data, relation);
	});
}

// Frome vtDZiner.js
function rr_changeParentCategory(data) {
	var params = {};
	if(data['result'] && data['result']['SUCCESS']=='Yes') {
		params['text'] = app.vtranslate(data['result']['message']);
		showMessage(params);
		location.reload(true);
	} else {
		var message = data['error']['message'];
		form.find('[name="newParentCategory"]').validationEngine('showPrompt', message , 'error','topLeft',true);
		saveButton.removeAttr('disabled');
	}
}
function rr_enableTracker(data){
	rr_au_ModuleSettings(data);
}
function rr_registerCustomWorkflow(data) {
	rr_au_ModuleSettings(data);
}
function rr_enablePortal(data){
	var params = {};
	if(data['result'] && data['result']['SUCCESS']=='Yes') {
		var message=data['result']['message'];
		params['text'] = app.vtranslate(message);
		Settings_Vtiger_Index_Js.showMessage(params);
	} else {
		var message = data['error']['message'];
		form.find('[name="label_parcat"]').validationEngine('showPrompt', message , 'error','topLeft',true);
		saveButton.removeAttr('disabled');    
	}
	app.hideModalWindow();
}	
function rr_disableModule(data){
	var params = {};
	params['text'] = app.vtranslate('Current Module has been diabled');
	Settings_Vtiger_Index_Js.showMessage(params);
	saveButton.removeAttr('disabled');    
}
function rr_exportModule(data){
	rr_au_ModuleSettings(data);
}
function rr_uploadModuleImageIcon(data){
}
function rr_removeModule(data){
	rr_au_ModuleSettings(data);
}
function rr_enablevtDZiner(data){
	var params = {};
	//var result = data['result'];
	if(data['result'] && data['result']['SUCCESS']=='Yes') {
		var parentcat=data['result']['Parentcatname'];
		params['text'] = app.vtranslate(parentcat+' has been created');
		Settings_Vtiger_Index_Js.showMessage(params);
		//location.reload(true);
	} else {
		var message = data['error']['message'];
		form.find('[name="label_parcat"]').validationEngine('showPrompt', message , 'error','topLeft',true);
		saveButton.removeAttr('disabled');    
	}
}
function rr_addCategory(data){
	var params = {};
	if(data['result'] && data['result']['SUCCESS']=='Yes') {
		var parentcat=data['result']['Parentcatname'];
		params['text'] = app.vtranslate(parentcat+' has been created');
		Settings_Vtiger_Index_Js.showMessage(params);
		location.reload(true);
	} else {
		var message = data['error']['message'];
		var form = jQuery(".addCategoryModal");
		var saveButton = form.find(':submit');
		params['text'] = message;
		params['type'] = 'error';
		Vtiger_Helper_Js.showPnotify(params);
		//form.find('[name="label_parcat"]').validationEngine('showPrompt', message , 'error','topLeft',true);
		saveButton.removeAttr('disabled');    
	}
}
function rr_upgradevtDZiner(data){

	app.hideModalWindow();
	var params = {};
	if(data['result'] && data['result']['SUCCESS']=='Yes') {
		params['text'] = data['result']['message'];
		Settings_Vtiger_Index_Js.showMessage(params);
		//location.reload(true);
	} else {
		var message = data['error']['message'];
		form.find('[name="label_parcat"]').validationEngine('showPrompt', message , 'error','topLeft',true);
		saveButton.removeAttr('disabled');    
	}
}
function rr_addCustomModule(data){
	var params = {};
	if(data['result'] && data['result']['SUCCESS']=='Yes') {
		var modulename=data['result']['MODULE'];
		params['text'] = app.vtranslate(modulename+' module created');
		Settings_Vtiger_Index_Js.showMessage(params);
		switch(data['result']['returnaction']){
			case "vtdziner" :
			window.location = "index.php?parent=Settings&module=vtDZiner&sourceModule="+modulename+"";
			break;
			case "newmodule" :
			window.location = "index.php?module="+modulename+"&view=List";
			break;
			case "showhome" :
			window.location = "index.php?module=Home&view=DashBoard";
			break;
			case "stayback" :
			default :
			window.location.reload();
			break;
		}
	} else {
		var message = data['error']['message'];
		form.find('[name="label_modulename"]').validationEngine('showPrompt', message , 'error','topLeft',true);
		saveButton.removeAttr('disabled');    
	}
}

function au_addCustomModule(form) {
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = form.serializeFormData();
	params['module'] = app.getModuleName();
	params['parent'] = app.getParentModuleName();
	params['sourceModule'] = jQuery('#selectedModuleName').val();
	params['action'] = 'Module';
	params['mode'] = 'save';
	AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_addCategory(form) {
	var modalHeader = form.closest('#globalmodal').find('.modal-header h3');
	var aDeferred = jQuery.Deferred();
	modalHeader.progressIndicator({smallLoadingImage : true, imageContainerCss : {display : 'inline', 'margin-left' : '18%',position : 'absolute'}});
	var params = form.serializeFormData();
	params['module'] = app.getModuleName();
	params['parent'] = app.getParentModuleName();
	params['sourceModule'] = jQuery('#selectedModuleName').val();
	params['action'] = 'Module';
	params['mode'] = 'processparentcat';
	
		AppConnector.request(params).then(
		function(data) {
			modalHeader.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			modalHeader.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_enablevtDZiner(form) {				// to enable vtDZiner features in native entity modules
	var thisInstance = this;
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = form.serializeFormData();
	params['module'] = app.getModuleName();
	params['parent'] = app.getParentModuleName();
	params['sourceModule'] = jQuery('#selectedModuleName').val();
	params['action'] = 'Module';
	params['mode'] = 'enablevtDZiner';
	
	AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_registerCustomWorkflow(form) {
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = form.serializeFormData();
	params['module'] = app.getModuleName();
	params['parent'] = app.getParentModuleName();
	params['sourceModule'] = jQuery('#selectedModuleName').val();
	params['action'] = 'Module';
	params['mode'] = 'saveWFMethod';
	
	AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_enableTracker(form) {
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = form.serializeFormData();
	params['module'] = 'vtDZiner'
	params['parent'] = 'Settings'
	params['action'] = 'Module';
	params['mode'] = 'saveTrackerOptions';
	form.validationEngine('detach');
	form.validationEngine('attach');
	AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_disableModule(form) {
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = {};
	params['action']='Basic';
	params['mode']='updateModuleStatus';
	params['module']='ModuleManager';
	params['parent']='Settings';
	params['forModule']=jQuery('#selectedModuleName').val();
	params['updateStatus']='false';

	AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_exportModule(form) {
	var aDeferred = jQuery.Deferred();
	var moduleexport = app.getModuleName();
	window.open("index.php?forModule="+moduleexport+"&module=ModuleManager&parent=Settings&action=ModuleExport&mode=exportModule");
	return aDeferred.promise();
}
function au_enablePortal(form) {
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = form.serializeFormData();
	params['module'] = app.getModuleName();
	params['parent'] = app.getParentModuleName();
	params['sourceModule'] = jQuery('#selectedModuleName').val();
	params['action'] = 'Module';
	params['mode'] = 'setupPortalOptions';
	form.validationEngine('detach');
	form.validationEngine('attach');
	if ("cbTracker" in params) {
		AppConnector.request(params).then(
			function(data) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				aDeferred.resolve(data);
			},
			function(error) {
				progressIndicatorElement.progressIndicator({'mode' : 'hide'});
				aDeferred.reject(error);
			}
		);
	} else {
		progressIndicatorElement.progressIndicator({'mode' : 'hide'});
		alert("Checkbox not ticked. Please try again");
	}
	return aDeferred.promise();
}
function au_removeModule(form) {
	var aDeferred = jQuery.Deferred();
	var progressIndicatorElement = jQuery.progressIndicator({
		'position' : 'html',
		'blockInfo' : {
			'enabled' : true
		}
	});
	var params = form.serializeFormData();
	params['module'] = app.getModuleName();
	params['parent'] = app.getParentModuleName();
	params['sourceModule'] = jQuery('#selectedModuleName').val();
	params['action'] = 'Module';
	params['mode'] = 'removeModule';
	
	AppConnector.request(params).then(
		function(data) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			progressIndicatorElement.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_changeParentCategory(form) {
	var modalHeader = form.closest('#globalmodal').find('.modal-header h3');
	var aDeferred = jQuery.Deferred();
	modalHeader.progressIndicator({smallLoadingImage : true, imageContainerCss : {display : 'inline', 'margin-left' : '18%',position : 'absolute'}});
	var params = form.serializeFormData();
	params['module'] = 'vtDZiner';
	params['parent'] = 'Settings';
	params['action'] = 'Module';
	params['mode'] = 'updateparentcat';
	AppConnector.request(params).then(
		function(data) {
			modalHeader.progressIndicator({'mode' : 'hide'});
			aDeferred.resolve(data);
		},
		function(error) {
			modalHeader.progressIndicator({'mode' : 'hide'});
			aDeferred.reject(error);
		}
	);
	return aDeferred.promise();
}
function au_upgradevtDZiner(form){
}

function cb_moduleSettings(data, target){
	jQuery('.'+target+'Modal').removeClass('hide');
	if (target !== 'uploadModuleImageIcon'){
		app.showSelect2ElementView(data.find('select'));
		var form = data.find('.'+target+'Form');
		var params = app.validationEngineOptions;
		params.onValidationComplete = function(form, valid){
			if(valid) {
				var saveButton = form.find(':submit');
				saveButton.attr('disabled', 'disabled');
				window['au_'+target](form).then(
					function(data) {
						window['rr_'+target](data);
					}
				);
			}
			return false;
		}
		form.validationEngine(params);  
	}
}

function moduleSettingsOnClick(contents, target){
	var actionContainer = contents.find('.'+target+'Modal').clone(true, true);
	gMC_callBackFunction = "cb_"+target;
	app.showModalWindow(actionContainer,function(data) {
		//if(typeof window[gMC_callBackFunction] == 'function') {
			//window[gMC_callBackFunction](data, target);
		//}
		if(typeof cb_moduleSettings == 'function') {
			cb_moduleSettings(data, target);
		}
	}, {'width':'1000px'});
}

function rr_au_ModuleSettings(data){
	app.hideModalWindow();
	var params = {};
	if(data['success']){
		params['text'] = data['result']['message'];
		params['type'] = 'success';
	} else {
		var message = data['result']['error'];
		params['type'] = 'error';
		saveButton.removeAttr('disabled');    
	}
	showMessage(params);
}

function updateModuleConfig(target) {
	var params = {
		module : 'vtDZiner',
		parent : 'Settings',
		sourceModule : app.getModuleName(),
		view : 'IndexAjax',
		mode : 'getModuleModals'
	}
	AppConnector.request(params).then(function(data) {
		moduleSettingsOnClick(jQuery(data), target);
	});
}

//"javascript:updateModuleConfig(\'upgradevtDZiner\');"

