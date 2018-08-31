{* ********************************************************************************
 * The content of this file is subject to the ChecklistItems ("License");
 * You may not use this file except in compliance with the License
 * The Initial Developer of the Original Code is VTExperts.com
 * Portions created by VTExperts.com. are Copyright(C) VTExperts.com.
 * All Rights Reserved.
 * ****************************************************************************** *}
<script type="text/javascript" src="layouts/vlayout/modules/ChecklistItems/resources/ChecklistItems.js" />
<link href="layouts/vlayout/modules/ChecklistItems/resources/ChecklistItems.css" type="text/css" />
<div class="container-fluid" id="vte-checklist">
    <ul class="nav nav-list">
    {foreach item=CHECKLIST from=$CHECKLISTS}
        <li>
            <a href="javascript:void(0);" class="checklist-name" data-record="{$CHECKLIST.checklistid}">
                {$CHECKLIST.checklistname}
            </a>
        </li>
    {/foreach}
    </ul>
</div>

