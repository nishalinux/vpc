/*+***********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 *************************************************************************************/

Inventory_Edit_Js("PurchaseOrder_Edit_Js",{},{

    billingShippingFields: {'bill' :{
										'street':'',
										'pobox':'',
										'city'	:'',
										'state':'',
										'code'	:'',
										'country':''
								},
                            'ship' :{
                                        'street':'',
										'pobox':'',
										'city'	:'',
										'state':'',
										'code'	:'',
										'country':''
                                    }
										
								},
    companyDetails: false,
                              
    
	/**
	 * Function to get popup params
	 */
	getPopUpParams : function(container) {
		var params = this._super(container);
        var sourceFieldElement = jQuery('input[class="sourceField"]',container);

		if(sourceFieldElement.attr('name') == 'contact_id') {
			var form = this.getForm();
			var parentIdElement  = form.find('[name="vendor_id"]');
			if(parentIdElement.length > 0 && parentIdElement.val().length > 0 && parentIdElement.val() != 0) {
				var closestContainer = parentIdElement.closest('td');
				params['related_parent_id'] = parentIdElement.val();
				params['related_parent_module'] = closestContainer.find('[name="popupReferenceModule"]').val();
			}
        }
        return params;
    },
    /*------- Event to  populate the vendors address ---- START------------*/

	registerReferenceSelectionEvent : function(container) {
		this._super(container);
		var thisInstance = this;
		
		jQuery('input[name="vendor_id"]', container).on(Vtiger_Edit_Js.referenceSelectionEvent, function(e, data){
			//thisInstance.referenceSelectionVendorEventHandler(data, container);
			//alert("0");
		//});
	//},
//Added by Madhav			
			//thisInstance.referenceSelectionEventHandler(data, container);
			//console.log(data);
			//console.log(this);
			//console.log(jQuery('[name="module"]').val());
			var usermodule = jQuery('[name="module"]').val();
		if(usermodule =='PurchaseOrder'){
		 thisInstance.addressFieldsMappingInModule = jQuery.extend({}, thisInstance.PO_addressFieldsMappingInModule);
		 thisInstance.addressFieldsMappingBetweenModules = jQuery.extend( {}, thisInstance.PO_addressFieldsMappingBetweenModules);
		 thisInstance.addressFieldsMapping = jQuery.extend( {}, thisInstance.PO_addressFieldsMapping);

		}		
		//console.log(thisInstance.addressFieldsMappingInModule);
	 //console.log(thisInstance.addressFieldsMappingBetweenModules);
	 //console.log(thisInstance.addressFieldsMapping);
			thisInstance.referenceSelectionEventHandler(data, container);
		});
	},
//Added by Madhav	
	
	/*-------------------------------END-------------------------------*/
	registerEventForCopyingAddress : function(container){
		var thisInstance = this;
		var swapMode;
		jQuery('[name="copyAddress"]').on('click',function(e){
			var element = jQuery(e.currentTarget);
			var target = element.data('target');
			if(target == "billing"){
				swapMode = "false";
			}else if(target == "shipping"){
				swapMode = "true";
			}
			thisInstance.copyAddress(swapMode, container);
			//alert("1");
		})
	},
	

	/**
	 * Function to search module names
	 */
	searchModuleNames : function(params) {
		var aDeferred = jQuery.Deferred();

		if(typeof params.module == 'undefined') {
			params.module = app.getModuleName();
		}
		if(typeof params.action == 'undefined') {
			params.action = 'BasicAjax';
		}

		if (params.search_module == 'Contacts') {
			var form = this.getForm();
			var parentIdElement  = form.find('[name="vendor_id"]');
			if(parentIdElement.length > 0 && parentIdElement.val().length > 0) {
				var closestContainer = parentIdElement.closest('td');
				params.parent_id = parentIdElement.val();
				params.parent_module = closestContainer.find('[name="popupReferenceModule"]').val();
			}
		}

		AppConnector.request(params).then(
			function(data){
				aDeferred.resolve(data);
			},
			function(error){
				aDeferred.reject();
			}
		)
		return aDeferred.promise();
	},
	
    registerCopyCompanyAddress : function(){
		var thisInstance = this;
        var editViewForm = this.getForm();
        jQuery('[name="copyCompanyAddress"]', editViewForm).on('click', function(e){
            var addressType = (jQuery(e.currentTarget).data('target'));
            var container = jQuery(e.currentTarget).closest('table');
            
            var moduleName = app.getModuleName();
            var url = {
                'mode': 'getCompanyDetails',
                'action': 'CompanyDetails',
                'module' : moduleName
            }
            
            if(!thisInstance.companyDetails){
                AppConnector.request(url).then(function(data){
                    var response = data['result'];
                    thisInstance.companyDetails = response;
                    thisInstance.copyAddressFields(addressType, container);
                },
                function(error, err){
                });
            }else{
                thisInstance.copyAddressFields(addressType, container);
            }
		});
    }, 
		
    copyAddressFields: function(addressType, container){
        var thisInstance = this;
        var company = thisInstance.companyDetails;
        var fields = thisInstance.billingShippingFields[addressType];
        for(var key in fields){
            container.find('[name="'+ addressType +'_' + key+'"]').val(company[key]);
            container.find('[name="'+ addressType +'_' + key+'"]').trigger('change');
        }
	},
    
	
	registerEvents: function(){
		this._super();
		this.registerEventForCopyAddress();
        this.registerCopyCompanyAddress();
	}
});

