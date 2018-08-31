{*<!--
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
-->*}
{strip}
<div class="listViewPageDiv">
		<div class="listViewTopMenuDiv noprint">
<div class="container-fluid">
	<div class="widget_header row-fluid">
		<div class="span6"><h3>{vtranslate($MODULE, $QUALIFIED_MODULE)}</h3></div>
		<div class="span6 pull-right" style="text-align:right; margin-top:10px;"><b>{vtranslate("Total Logged in Users", $QUALIFIED_MODULE)} : {$TOTAL_LOGIN}</b></div>
	</div>
	<hr>
	<div class="row-fluid">
		<span class="span5 btn-toolbar">
		        <span class="btn-group listViewMassActions">
		            <button class="btn dropdown-toggle" data-toggle="dropdown">
					<strong>Actions</strong>&nbsp;&nbsp;<i class="caret"></i></button>
					<ul class="dropdown-menu">
					  <li id="">
					   <a href="javascript:void(0);" id="exportForm">Export</a>
					  </li>
					</ul>
				</span>
				<span class="btn-group" style="display:inline-table">
					<input id="startdate" type="text" class="dateField span2 listSearchContributor autoComplete ui-autocomplete-input" name="start_date" data-date-format="dd-mm-yyyy" value="" data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]">
					<span class="add-on"><i class="icon-calendar cal1"></i></span>
				</span>
				<span class="btn-group" style="display:inline-table">
				    <input id="enddate" type="text" class="dateField span2 listSearchContributor autoComplete ui-autocomplete-input" name="start_date" data-date-format="dd-mm-yyyy" value="" data-validation-engine="validate[funcCall[Vtiger_Base_Validator_Js.invokeValidation]]">
					 <span class="add-on"><i class="icon-calendar cal2"></i></span>
				</span>
		</span>	
		
		<div class="span3 btn-toolbar">
		    <select class="chzn-select" id="usersFilter">
						<option value="">{vtranslate('LBL_ALL', $QUALIFIED_MODULE)}</option>
						{foreach item=USERNAME key=USER from=$USERSLIST}
							<option value="{$USER}" name="{$USERNAME}" {if $USERNAME eq $SELECTED_USER} selected {/if}>{$USERNAME}</option>
						{/foreach}
			</select>
		</div>	
		<span class="span4 btn-toolbar">
			{include file='ListViewActions.tpl'|@vtemplate_path:$QUALIFIED_MODULE}
		</span>
	</div>
	</div>
		</div>
	<div class="clearfix"></div>
	<div class="listViewContentDiv" id="listViewContents">
{/strip}

<!-- added by jyothi for login++ -->
<script>
   $(document).ready(function(){

   	   app.registerEventForDatePickerFields('#startdate');
		jQuery('.cal1').on('click',function(){
		  jQuery("#startdate").trigger("focus");
		 });

		app.registerEventForDatePickerFields('#enddate');
		jQuery('.cal2').on('click',function(){
		  jQuery("#enddate").trigger("focus");
		 });

       jQuery('#exportForm').bind("click", function() {
             var user = $('#usersFilter option:selected').text();
             var startdate = $('#startdate').val();
             // alert(startdate);
             var enddate = $('#enddate').val();
             // alert(enddate);
            window.location.href='index.php?module=OS2LoginHistory&parent=Settings&action=ListAjaxData&user='+$.trim(user)+'&startdate='+startdate+'&enddate='+enddate;
       });
   });
</script>
<!-- ended here -->
