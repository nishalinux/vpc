{*<!-- {[The file is published on the basis of YetiForce Public License that can be found in the following directory: licenses/License.html]} --!>*}
{strip}
	{if !$RECORD}
		<input type="hidden" id="mailActionBarID" value="" />
		<div class="noRecords">
		{Vtiger_ModulesHierarchy_Model::accessModulesByLevel()|@print_r} 
			{vtranslate('LBL_MAIL_NOT_FOUND_IN_DB',$MODULE_NAME)} <a class="importMail">{vtranslate('LBL_IMPORT_MAIL_MANUALLY',$MODULE_NAME)}</a>
		</div>
	{else}
		<input type="hidden" id="mailActionBarID" value="{$RECORD}" />
		{assign var="MODULES_LEVEL_0" value=Vtiger_ModulesHierarchy_Model::getModulesByLevel()}
		{assign var="MODULES_LEVEL_1" value=Vtiger_ModulesHierarchy_Model::getModulesByLevel(1)}
		{assign var="MODULES_LEVEL_2" value=Vtiger_ModulesHierarchy_Model::getModulesByLevel(2)}
		<input type="hidden" id="modulesLevel0" value="{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode(array_keys($MODULES_LEVEL_0)))}" />
		<input type="hidden" id="modulesLevel1" value="{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode(array_keys($MODULES_LEVEL_1)))}" />
		<input type="hidden" id="modulesLevel2" value="{Vtiger_Util_Helper::toSafeHTML(ZEND_JSON::encode(array_keys($MODULES_LEVEL_2)))}" />
		<div class="head row">
			{if !empty($MODULES_LEVEL_0)}
				<div class="col-4" data-type="link">
					<div class="col">
						{vtranslate('LBL_RELATIONS',$MODULE_NAME)}
						<div class="pull-right">
							{assign var="ACCESS_LEVEL_0" value=Vtiger_ModulesHierarchy_Model::accessModulesByLevel()}
							
							{if $ACCESS_LEVEL_0}
								<select class="module">
									{foreach item="ITEM" key="MODULE" from=$ACCESS_LEVEL_0}
										<option value="{$MODULE}">
											{vtranslate($MODULE, $MODULE)}
										</option>
									{/foreach}
								</select>
								<button class="addRecord" title="{vtranslate('LBL_ADD_RECORD',$MODULE_NAME)}">
									<span class="glyphicon glyphicon-plus" aria-hidden="true"></span>
								</button>
							{/if}
							{if Vtiger_ModulesHierarchy_Model::accessModulesByLevel(0,'DetailView')}
								<button class="selectRecord" data-type="0" title="{vtranslate('LBL_SELECT_RECORD',$MODULE_NAME)}">
									<span class="glyphicon glyphicon-search" aria-hidden="true"></span>
								</button>
							{/if}
						</div>
					</div>
				</div>
			{/if}
		
	
		</div>
		<div class="data row">
			{if !empty($MODULES_LEVEL_0)}
				<div class="col-4" data-type="link">
					<div class="col">
						{foreach key=MODULE item=ITEM from=$MODULES_LEVEL_0}
							{foreach item=RELETED from=$RELETED_RECORDS[$MODULE]}
								{include file='MailActionBarRow.tpl'|@vtemplate_path:$MODULE_NAME}
							{/foreach}
						{/foreach}
					</div>
				</div>
			{/if}
			{if !empty($MODULES_LEVEL_1)}
				<div class="col-4" data-type="link">
					<div class="col">
						{foreach key=MODULE item=ITEM from=$MODULES_LEVEL_1}
							{foreach item=RELETED from=$RELETED_RECORDS[$MODULE]}
								{include file='MailActionBarRow.tpl'|@vtemplate_path:$MODULE_NAME}
							{/foreach}
						{/foreach}
					</div>
				</div>
			{/if}
			{if !empty($MODULES_LEVEL_2)}
				<div class="col-4" data-type="link">
					<div class="col">
						{foreach key=MODULE item=ITEM from=$MODULES_LEVEL_2}
							{foreach item=RELETED from=$RELETED_RECORDS[$MODULE]}
								{include file='MailActionBarRow.tpl'|@vtemplate_path:$MODULE_NAME}
							{/foreach}
						{/foreach}
					</div>
				</div>
			{/if}
		</div>
	{/if}
{/strip}
