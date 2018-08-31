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
	<div class="eventContents">
		<form class="form-horizontal eventEditView" id="event_step1" method="post" action="index.php">
			<input type="hidden" name="module" value="{$MODULE}" />
			<input type="hidden" name="view" value="{$VIEW}" />
			<input type="hidden" name="mode" value="step2" />
			<input type="hidden" name="moduleclass" value="Events" />
			<input type="hidden" class="step" value="1" />
			<input type="hidden" name="isDuplicate" value="{$IS_DUPLICATE}" />
			<input type="hidden" name="record" value="{$RECORD_ID}" />
			<div class="well contentsBackground">
				{foreach key=BLOCK_LABEL item=BLOCK_FIELDS from=$RECORD_STRUCTURE name="EditViewBlockLevelLoop"}
            {if $BLOCK_FIELDS|@count lte 0}{continue}{/if}
			{if $BLOCK_LABEL eq 'LBL_EVENT_INFORMATION' ||  $BLOCK_LABEL eq 'LBL_REMINDER_INFORMATION' ||  $BLOCK_LABEL eq 'LBL_RECURRENCE_INFORMATION'}
            <table class="table table-bordered blockContainer showInlineTable equalSplit">
                <thead>
                    <tr>
                        <th class="blockHeader" colspan="4">{vtranslate($BLOCK_LABEL, $MODULE)}</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        {assign var=COUNTER value=0}
                        {foreach key=FIELD_NAME item=FIELD_MODEL from=$BLOCK_FIELDS name=blockfields}

                            {assign var="isReferenceField" value=$FIELD_MODEL->getFieldDataType()}
                            {if $FIELD_MODEL->get('uitype') eq "20" or $FIELD_MODEL->get('uitype') eq "19"}
                                {if $COUNTER eq '1'}
                                    <td class="{$WIDTHTYPE}"></td><td class="{$WIDTHTYPE}"></td>
                                </tr>
                                <tr>
                                    {assign var=COUNTER value=0}
                                {/if}
                            {/if}
                            {if $COUNTER eq 2}
                            </tr>
                            <tr>
                                {assign var=COUNTER value=1}
                            {else}
                                {assign var=COUNTER value=$COUNTER+1}
                            {/if}
                            <td class="fieldLabel {$WIDTHTYPE}">
                            {if $isReferenceField neq "reference"}<label class="muted pull-right marginRight10px">{/if}
                            {if $FIELD_MODEL->isMandatory() eq true && $isReferenceField neq "reference"} <span class="redColor">*</span> {/if}
                            {if $isReferenceField eq "reference"}
                                {assign var="REFERENCE_LIST" value=$FIELD_MODEL->getReferenceList()}
                                {assign var="REFERENCE_LIST_COUNT" value=count($REFERENCE_LIST)}
                                {if $REFERENCE_LIST_COUNT > 1}
                                    {assign var="DISPLAYID" value=$FIELD_MODEL->get('fieldvalue')}
                                    {assign var="REFERENCED_MODULE_STRUCT" value=$FIELD_MODEL->getUITypeModel()->getReferenceModule($DISPLAYID)}
                                    {if !empty($REFERENCED_MODULE_STRUCT)}
                                        {assign var="REFERENCED_MODULE_NAME" value=$REFERENCED_MODULE_STRUCT->get('name')}
                                    {/if}
                                    <span class="pull-right">
                                    {if $FIELD_MODEL->isMandatory() eq true} <span class="redColor">*</span> {/if}
                                    <select id="{$MODULE}_editView_fieldName_{$FIELD_MODEL->getName()}_dropDown" class="chzn-select referenceModulesList streched" style="width:160px;">
                                        <optgroup>
                                            {foreach key=index item=value from=$REFERENCE_LIST}
                                                <option value="{$value}" {if $value eq $REFERENCED_MODULE_NAME} selected {/if}>{vtranslate($value, $MODULE)}</option>
                                            {/foreach}
                                        </optgroup>
                                    </select>
                                </span>
                            {else}
                                <label class="muted pull-right marginRight10px">{if $FIELD_MODEL->isMandatory() eq true} <span class="redColor">*</span> {/if}{vtranslate($FIELD_MODEL->get('label'), $MODULE)}</label>
                            {/if}
                        {else if $FIELD_MODEL->get('uitype') eq "83"}
                            {include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE) COUNTER=$COUNTER MODULE=$MODULE}
                        {else}
                            {vtranslate($FIELD_MODEL->get('label'), $MODULE)}
                        {/if}
                    {if $isReferenceField neq "reference"}</label>{/if}
            </td>
            {if $FIELD_MODEL->get('uitype') neq "83"}
                <td class="fieldValue {$WIDTHTYPE}" {if $FIELD_MODEL->get('uitype') eq '19' or $FIELD_MODEL->get('uitype') eq '20'} colspan="3" {assign var=COUNTER value=$COUNTER+1} {/if}>
                    <div class="row-fluid">
                        <span class="span10">
                            {include file=vtemplate_path($FIELD_MODEL->getUITypeModel()->getTemplateName(),$MODULE) BLOCK_FIELDS=$BLOCK_FIELDS}
                        </span>
                    </div>
                </td>
            {/if}
            {if $BLOCK_FIELDS|@count eq 1 and $FIELD_MODEL->get('uitype') neq "19" and $FIELD_MODEL->get('uitype') neq "20" and $FIELD_MODEL->get('uitype') neq "30" and $FIELD_MODEL->get('name') neq "recurringtype"}
                <td class="{$WIDTHTYPE}"></td><td class="{$WIDTHTYPE}"></td>
            {/if}
            {if $MODULE eq 'Events' && $BLOCK_LABEL eq 'LBL_EVENT_INFORMATION' && $smarty.foreach.blockfields.last }
                {include file=vtemplate_path('uitypes/FollowUp.tpl',$MODULE) COUNTER=$COUNTER}
            {/if}
        {/foreach}
		{* adding additional column for odd number of fields in a block *}
		{if $BLOCK_FIELDS|@end eq true and $BLOCK_FIELDS|@count neq 1 and $COUNTER eq 1}
			<td class="fieldLabel {$WIDTHTYPE}"></td><td class="{$WIDTHTYPE}"></td>
		{/if}
    </tr>
</tbody>
</table>
<br/>
{/if}
{/foreach}
			</div>
		<div class="pull-right">
			<button type="submit" class="btn btn-success nextStep"><strong>{vtranslate('LBL_NEXT',$MODULE)}</strong></button>&nbsp;&nbsp;
			<a onclick='window.history.back()' class="cancelLink cursorPointer">{vtranslate('LBL_CANCEL',$MODULE)}</a>
		</div>
	</form>
</div>
{/strip}