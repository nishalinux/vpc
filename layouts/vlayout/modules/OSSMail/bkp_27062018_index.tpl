{*<!--
/*+***********************************************************************************************************************************
 * The contents of this file are subject to the YetiForce Public License Version 1.1 (the "License"); you may not use this file except
 * in compliance with the License.
 * Software distributed under the License is distributed on an "AS IS" basis, WITHOUT WARRANTY OF ANY KIND, either express or implied.
 * See the License for the specific language governing rights and limitations under the License.
 * The Original Code is YetiForce.
 * The Initial Developer of the Original Code is YetiForce. Portions created by YetiForce are Copyright (C) www.yetiforce.com. 
 * All Rights Reserved.
 *************************************************************************************************************************************/
-->*}
<input type="hidden" value="" id="tempField" name="tempField"/>
<script>
var height = window.innerHeight;

$(document).ready( function(){
	$('#roundcube_interface').css('height', height-83);
  
} );
</script>
<input type="hidden" name="senderemail" id="senderemail" value="{$SENDEREMAIL}">
<input type="hidden" name="senderid" id="senderid" value="{$SENDERID}">
<iframe id="roundcube_interface" style="width: 100%; height: 590px;margin-bottom: -5px;" frameborder="0" src="{$URL}" frameborder="0" onload="osmailclicked()" onKeyPress="osmailclicked()"> </iframe>
