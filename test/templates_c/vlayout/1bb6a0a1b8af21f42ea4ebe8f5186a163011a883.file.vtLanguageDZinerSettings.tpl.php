<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:16
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtLanguageDZinerSettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:13145081905b7320a8082797-38681737%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1bb6a0a1b8af21f42ea4ebe8f5186a163011a883' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtLanguageDZinerSettings.tpl',
      1 => 1517659511,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '13145081905b7320a8082797-38681737',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'OTHERFILESLIST' => 0,
    'languagelabel' => 0,
    'MODULE' => 0,
    'LANGUAGE' => 0,
    'item' => 0,
    'LANGUAGES' => 0,
    'languagetag' => 0,
    'SELECTED_MODULE_NAME' => 0,
    'MODULELANGUAGELABELS' => 0,
    'langtag' => 0,
    'langlabel' => 0,
    'MODULELANGUAGEJSLABELS' => 0,
    'LANGUAGECODES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a80e6fa',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a80e6fa')) {function content_5b7320a80e6fa($_smarty_tpl) {?>
<style>
.overwrite-ui-widget-content {
  border-radius: 6px;
  border-color: #ffffff;
  box-shadow: 0 0 3px -1px inset;
  margin-top: 2px;
  margin-left: 5px;
}

.overwrite-ui-tabs-panel {
    background: none repeat scroll 0 0 rgba(0, 0, 0, 0);
    border-width: 0;
    display: block;
    padding: 1em 1.4em;
}
</style>

<div class="contents">
	<table class="table table-bordered ">
		<tbody>
			<tr>
				<td class="opacity">
					<div class="row-fluid moduleManagerBlock">
						<div class="LanguagesSummaryView hide">
							<div class="row-fluid layoutBlockHeader">
							  <div class="blockLabel span5 padding10 marginLeftZero">
								<h3>
								  Languages in this CRM instance
								</h3>
							  <br/>The <b>current language</b> is highlighted in bold and marked with <sup><b>#</b></sup>
							  </div>
							  <div style="float:right !important;" class="span6 marginLeftZero">
							  
								<div style="margin: 4px;" class="pull-right btn-toolbar">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">
											<strong><?php echo vtranslate('LBL_ACTIONS_OTHER_FILES',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 </strong>&nbsp;&nbsp;
											<i class="caret"></i>
										</button>
										<ul class="dropdown-menu pull-right otherCRMLanguageFiles">
											<?php  $_smarty_tpl->tpl_vars['languagelabel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['languagelabel']->_loop = false;
 $_smarty_tpl->tpl_vars['languagetag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['OTHERFILESLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['languagelabel']->key => $_smarty_tpl->tpl_vars['languagelabel']->value){
$_smarty_tpl->tpl_vars['languagelabel']->_loop = true;
 $_smarty_tpl->tpl_vars['languagetag']->value = $_smarty_tpl->tpl_vars['languagelabel']->key;
?>
											<?php if (count($_smarty_tpl->tpl_vars['languagelabel']->value)==1){?>
											<?php if ($_smarty_tpl->tpl_vars['languagelabel']->value!='Vtiger'){?>
											<li class="newCRMLanguage">
												&nbsp;&nbsp;<?php echo vtranslate($_smarty_tpl->tpl_vars['languagelabel']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>

												<span class="pull-right"><i onclick="editSelectedLanguage('<?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>
', '<?php echo $_smarty_tpl->tpl_vars['languagelabel']->value;?>
');" class="icon-pencil"></i>&nbsp;&nbsp;</span>
												
											</li>
											<?php }?>
											<?php }else{ ?>
											<li class="divider"></li>
											<li class="newCRMLanguage">
												&nbsp;&nbsp;Settings
												<ul class="dropdown-menu pull-right">
												<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['languagelabel']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
													<?php if ($_smarty_tpl->tpl_vars['item']->value!='Vtiger'){?>
												<li class="newCRMLanguage">
													&nbsp;&nbsp;<?php echo vtranslate($_smarty_tpl->tpl_vars['item']->value,$_smarty_tpl->tpl_vars['MODULE']->value);?>

												<span class="pull-right"><i onclick="editSelectedLanguage('<?php echo $_smarty_tpl->tpl_vars['LANGUAGE']->value;?>
/Settings', '<?php echo $_smarty_tpl->tpl_vars['item']->value;?>
');" class="icon-pencil"></i>&nbsp;&nbsp;</span>
												</li>
													<?php }?>
												<?php } ?>
												</ul>
											</li>
											<?php }?>
											<?php } ?>
										</ul>
									</div>
								</div>
								<div style="margin: 4px;" class="pull-right btn-toolbar">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown">
											<strong><?php echo vtranslate('LBL_ACTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>&nbsp;&nbsp;
											<i class="caret"></i>
										</button>
										<ul class="dropdown-menu pull-right">
											<li class="newCRMLanguage">
												<a id="newCRMLanguageLink" href="javascript:newCRMLanguage();"><?php echo vtranslate('Make New Language Pack',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a>
											</li>
											<!--li class="exportLanguage">
												<a href="javascript:void(0)"><?php echo vtranslate('Export Language pack',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</a>
											</li-->
										</ul>
									</div>
								</div>
							  </div>
							</div>
							<hr/>
							<table class="table equalSplit">
								<tr>
									<td>
										<strong>CRM Languages</strong>
										<table class="table crmlanguageslist">
										<?php  $_smarty_tpl->tpl_vars['languagelabel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['languagelabel']->_loop = false;
 $_smarty_tpl->tpl_vars['languagetag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['LANGUAGES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['languagelabel']->key => $_smarty_tpl->tpl_vars['languagelabel']->value){
$_smarty_tpl->tpl_vars['languagelabel']->_loop = true;
 $_smarty_tpl->tpl_vars['languagetag']->value = $_smarty_tpl->tpl_vars['languagelabel']->key;
?>
										<tr><td>
										<?php if ($_smarty_tpl->tpl_vars['languagetag']->value==$_smarty_tpl->tpl_vars['LANGUAGE']->value){?>
											<b><?php echo $_smarty_tpl->tpl_vars['languagelabel']->value;?>
<sup>#</sup></b>
										<?php }else{ ?>
											<?php echo $_smarty_tpl->tpl_vars['languagelabel']->value;?>

										<?php }?>
										</td></tr>
										<?php } ?>
										</table>
									</td>
									<td>
										<strong>Module Languages</strong>
										<table class="table modulelanguageslist">
										<tr><td></td></tr>
										</table>
									</td>
									<td>
										<strong>Module Languages to be created</strong>
										<table class="table missinglanguageslist">
										<tr><td></td></tr>
										</table>
									</td>
								</tr>
								<tr>
									<td colspan="3">
										<hr/>
									</td>
								</tr>
							</table>
						</div>

						<div class="LanguageLabelsEditView hide">
						<table class="table">
							<tr>
								<td class="span7">
									<span id="languageFormHeading">
									</span>
								<hr/>
								<!--strong>
										Please edit the labels as necessary and select SAVE from Actions Button to confirm your changes
										<span class="pull-right"><button class="btn btn-success" name="vtbulktranslate" id="vtbulktranslate" onclick="bulkTranslate();" ><strong>Bulk Translate</strong></button></span>
								</strong-->
								</td>
								<td class="span2">
									<span class="pull-right"><button class="btn btn-success" onclick="saveModuleLanguage();" ><strong>Save</strong></button><a onclick="showLanguagesSummaryView();" type="reset" class="cancelLink">Cancel</a></span>
								</td>
							</tr>
						</table>
						<hr/>
							<div>
								<strong>
									Language Labels
								</strong>
								<span class="pull-right">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown" onclick="addNewLabel('lang');">
											<i class="icon-plus"></i>&nbsp;
											<strong><?php echo vtranslate('Add Label',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>&nbsp;&nbsp;
										</button>
									</div>
								</span>
							</div>
							<hr/>
							<form id="languageLabelsForm">
								<table>
									<tr><td colspan="2">
										<input type=hidden id="languageMode" />
										<input type=hidden id="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
" />
										<input type=hidden id="forLanguage" />
									</td></tr>
								</table>
								<table width=100% id="labelEditForm">
									<?php  $_smarty_tpl->tpl_vars['langlabel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['langlabel']->_loop = false;
 $_smarty_tpl->tpl_vars['langtag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MODULELANGUAGELABELS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['langlabel']->key => $_smarty_tpl->tpl_vars['langlabel']->value){
$_smarty_tpl->tpl_vars['langlabel']->_loop = true;
 $_smarty_tpl->tpl_vars['langtag']->value = $_smarty_tpl->tpl_vars['langlabel']->key;
?>
										<tr>
											<td class="span4">
												<?php echo $_smarty_tpl->tpl_vars['langtag']->value;?>

											</td>
											<td class="span8">
												<input class="span8" id='<?php echo $_smarty_tpl->tpl_vars['langtag']->value;?>
' name='<?php echo $_smarty_tpl->tpl_vars['langtag']->value;?>
' type=text size=200 value='<?php echo $_smarty_tpl->tpl_vars['langlabel']->value;?>
' />
											</td>
										</tr>
									<?php } ?>
								</table>
							</form>
							<div>
								<strong>
									JS Language Labels
								</strong>
								<span class="pull-right">
									<div class="btn-group pull-right">
										<button class="btn dropdown-toggle" data-toggle="dropdown" onclick="addNewLabel('jslang');">
											<i class="icon-plus"></i>&nbsp
											<strong><?php echo vtranslate('Add JS Label',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>&nbsp;&nbsp;
										</button>
									</div>
								</span>
							</div>
							<hr/>
							
								<form id="JSlanguageLabelsForm">
									<table width=100% id="jslabelEditForm">
									<?php  $_smarty_tpl->tpl_vars['langlabel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['langlabel']->_loop = false;
 $_smarty_tpl->tpl_vars['langtag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MODULELANGUAGEJSLABELS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['langlabel']->key => $_smarty_tpl->tpl_vars['langlabel']->value){
$_smarty_tpl->tpl_vars['langlabel']->_loop = true;
 $_smarty_tpl->tpl_vars['langtag']->value = $_smarty_tpl->tpl_vars['langlabel']->key;
?>
										<tr>
											<td class="span4">
												<?php echo $_smarty_tpl->tpl_vars['langtag']->value;?>

											</td>
											<td class="span8">
												<input class="span8" id='<?php echo $_smarty_tpl->tpl_vars['langtag']->value;?>
' name='<?php echo $_smarty_tpl->tpl_vars['langtag']->value;?>
' type=text size=200 value='<?php echo $_smarty_tpl->tpl_vars['langlabel']->value;?>
' />
											</td>
										</tr>
									<?php } ?>
									</table>
								</form>
							
						</div>
					</div>
				</td>
			</tr>
		</tbody>
	</table>
</div>

<!--  newLanguageLabelModalData UI starts :: STP on 19th May,2013 -->
<div class="newLanguageLabelModalData">
	<div class="modal newLanguageLabelModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal" onclick="jQuery('.newLanguageLabelModal').addClass('hide');">&times</button>
			<h3>Create a new label</h3>
			Click on SAVE else CANCEL
		</div>
		<form class="form-horizontal contentsBackground newLanguageLabelForm">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
					Label Tag :
					</span>
					<div class="controls">
					<input type="text" id="labeltag" name="labeltag">
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
					Language Label :
					</span>
					<div class="controls">
					<input type="text" id="labelvalue" name="labelvalue" title="Update if needed to reflect local naming">
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>
</div>

<!--  newCRMLanguageModalData UI starts :: STP on 19th May,2013 -->
<div class="newCRMLanguageModalData">
	<div class="modal newCRMLanguageModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal" onclick="jQuery('.newCRMLanguageModal').addClass('hide');">&times</button>
			<h3>Create New Language Pack</h3>
			A complete replica of the US English Language Pack will be created for the new language selected<br>
			Please select a language from the world languages list<br>
			If you wish to proceed with creating, click on SAVE else CANCEL
		</div>
		<form class="form-horizontal contentsBackground newCRMLanguageForm">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
					Language Name :
					</span>
					<div class="controls">
					<input type="hidden" name="languageName" id="languageName"/>
						<select name="languageCode" id="languageCode" style="width:250px;" placeholder="<?php echo vtranslate('LBL_LANGUAGE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-errormessage="<?php echo vtranslate('LBL_CHOOSE_LANGUAGE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" class="validate[required] vtselector" onchange="setLanguageCode(this);">
								<?php  $_smarty_tpl->tpl_vars['languagelabel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['languagelabel']->_loop = false;
 $_smarty_tpl->tpl_vars['languagetag'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['LANGUAGECODES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['languagelabel']->key => $_smarty_tpl->tpl_vars['languagelabel']->value){
$_smarty_tpl->tpl_vars['languagelabel']->_loop = true;
 $_smarty_tpl->tpl_vars['languagetag']->value = $_smarty_tpl->tpl_vars['languagelabel']->key;
?>
									<option value="<?php echo $_smarty_tpl->tpl_vars['languagetag']->value;?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['languagelabel']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option>
								<?php } ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
					Language Code :
					</span>
					<div class="controls">
					<input type="text" id="languageISOCode" name="languageISOCode" disabled>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
					Language Label :
					</span>
					<div class="controls">
					<input type="text" id="languageLabel" name="languageLabel" title="Update if needed to reflect local naming">
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>
</div>

<!--  bulkTranslateModalData UI starts :: STP on 19th May,2013 -->
<div class="bulkTranslateModalData">
	<div class="modalContainer modal bulkTranslateModal hide">
		<div class="contents tabbable">
			<div class="modal-header">
				<button class="close vtButton" data-dismiss="modal" onclick="jQuery('.bulkTranslateModal').addClass('hide');">&times</button>
				<h3>Bulk Translation</h3>
				The entire label set from the US English language is copied into the text area.	Copy the textarea contents to a translation program (viz Google Translate) and copy back the translated text into the text area. Review the results and click on SAVE else CANCEL
			</div>
			<form class="form-horizontal contentsBackground bulkTranslateForm">
				<div class="modal-body">
					<div class="control-group">
						<div id="tabs">
						  <ul>
							<li><a href="#tabs-1">PHP/TPL Labels</a></li>
							<li><a href="#tabs-2">JS Labels</a></li>
						  </ul>
						  <div id="tabs-1" style="height:225px">
                            <div class="control-group bulkLabelsContainer"><!--
                            <span class="control-label">
                            <strong>Bulk Labels</strong>
                            </span>
                            <div class="controls">-->
                            <textarea class="form-control" id="bulkLabels" name="bulkLabels" rows="10" onkeyup="update_textarea(this)">
                            </textarea>
                            <!--</div>-->
                            </div>
						  </div>
						  <div id="tabs-2" style="height:225px">
                            <div class="control-group jsbulkLabelsContainer"><!--
                            <span class="control-label">
                            <strong>JS Bulk Labels</strong>
                            </span>
                            <div class="controls">-->
                            <textarea class="form-control" id="jsbulkLabels" name="jsbulkLabels" rows="10" onkeyup="update_textarea(this)">
                            </textarea>
                            <!--</div>-->
					</div>

						  </div>
						 
						</div>
					</div>
				
				</div>
				<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

			</form>
		</div>
	</div>
</div><?php }} ?>