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
    <div class="editeventContainer" style="padding-left: 2%;padding-right: 2%">
		<br>
        <h3>
            {if $RECORD_ID eq ''}
                {vtranslate('LBL_CREATING_EVENT',$QUALIFIED_MODULE)}
            {else}
                {vtranslate('LBL_EDITING_EVENT',$QUALIFIED_MODULE)} : {$SUBJECT}
			{/if}
        </h3>
        <hr>
        <div>
            <ul class="crumbs marginLeftZero">
                <li class="first step"  style="z-index:9" id="step1">
                    <a>
                        <span class="stepNum">1</span>
                        <span class="stepText">{vtranslate('LBL_EVENT_DETAILS',$MODULE)}</span>
                    </a>
                </li>
                <li style="z-index:8" class="step" id="step2">
                    <a>
                        <span class="stepNum">2</span>
                        <span class="stepText">{vtranslate('LBL_EDITING_EVENT',$MODULE)}</span>
                    </a>
                </li>
                <li class="step last" style="z-index:7" id="step3">
                    <a>
                        <span class="stepNum">3</span>
                        <span class="stepText">{vtranslate('LBL_FINISH',$MODULE)}</span>
                    </a>
                </li>
            </ul>
        </div>
        <div class="clearfix"></div>
    </div>
{/strip}