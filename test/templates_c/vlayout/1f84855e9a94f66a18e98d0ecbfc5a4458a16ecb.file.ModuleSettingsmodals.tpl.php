<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:16
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/ModuleSettingsmodals.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5700249165b7320a81c7164-11087924%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1f84855e9a94f66a18e98d0ecbfc5a4458a16ecb' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/ModuleSettingsmodals.tpl',
      1 => 1517985849,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5700249165b7320a81c7164-11087924',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'SELECTED_MODULE_NAME' => 0,
    'TRACKINGENABLED' => 0,
    'PORTALINFO' => 0,
    'SELECTED_MODULE_MODEL' => 0,
    'PARENTTAB' => 0,
    'v' => 0,
    'moduleImage' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a8254ba',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a8254ba')) {function content_5b7320a8254ba($_smarty_tpl) {?><!--
All Module Settings Modals are written here
-->

<!-- vtDZinerDeActivation UI starts :: STP on 19th May,2013 -->               
<div class="modal vtDZinerDeActivationModal hide">
	<div class="modal-header">
		<button class="close vtButton" data-dismiss="modal">&times</button>
		<h3>vtDZiner Deactivation</h3>
		Are you sure you wish to Deactivate?<br>
		If you wish to proceed with Deactivate, click on SAVE else CANCEL
	</div>
	<form class="form-horizontal contentsBackground vtDZinerDeActivationForm">
		<div class="modal-body">
			<div class="control-group">
				<span class="control-label">
				Activation Key :
				</span>
				<div class="controls">
				<input type="text" name="vtDZinerKey" class="span4" data-validation-engine="validate[required]" />
				</div>
			</div>
		</div>
		<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

	</form>
</div>

<div class="ModuleSettingsmodals">
	<!-- upgradevtDZiner UI starts :: STP on 19th May,2013 -->               
	<div class="modal upgradevtDZinerModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">&times</button>
			<h3>vtDZiner Update</h3>
			Are you sure you wish to upgrade?<br>
			If you wish to proceed with vtDZiner update, enter your activation key amd click on SAVE<br>
			else click on CANCEL to not upgrade
		</div>
		<form class="form-horizontal contentsBackground upgradevtDZinerForm">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
					Activation Key :
					</span>
					<div class="controls">
					<input type="text" name="vtDZinerKey" class="span3" data-validation-engine="validate[required]" />
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div> 

	<div class="modal enableTrackerModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_CONFIRM_TRACKER_TOGGLE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground enableTrackerForm">
			<input type="hidden" name="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('Tracker Status',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls alignMiddle">
						<?php if ($_smarty_tpl->tpl_vars['TRACKINGENABLED']->value){?>ON<?php }else{ ?>OFF<?php }?>. Save to toggle status, cancel to retain status
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>

	<div class="modal enablePortalModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_CONFIRM_ENABLE_PORTAL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground enablePortalForm">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('Portal Status',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="checkbox" name="cbTracker" <?php if ($_smarty_tpl->tpl_vars['PORTALINFO']->value["present"]){?>checked disabled="disabled"<?php }?>/>&nbsp;
						<?php if ($_smarty_tpl->tpl_vars['PORTALINFO']->value["present"]){?>Present<?php if ($_smarty_tpl->tpl_vars['PORTALINFO']->value["visible"]){?>, Visibility is ON<?php }else{ ?>, Visibility is OFF<?php }?><br/><a href="index.php?module=CustomerPortal&parent=Settings&view=Index&block=4&fieldid=30" target="_blank">Click for More options</a><?php }else{ ?>Not Present<br/>Set checkbox on and click on SAVE to setup in CRM<?php }?>
					</div>
				</div>
				<?php if ($_smarty_tpl->tpl_vars['PORTALINFO']->value["present"]){?>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('Portal Module Source Files 6.0, 6.1',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

						</strong>
					</span>
					<div class="controls">
						<a href="test/user/<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
.6.1.zip">Click to Download</a>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('Portal Module Source Files 6.2',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

						</strong>
					</span>
					<div class="controls">
						<a href="test/user/<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
.6.2.zip">Click to Download</a>
					</div>
				</div>
				<?php }?>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>

	<div class="modal enablevtDZinerModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_CONFIRM_UPGRADE_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground enablevtDZinerForm">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('vtDZiner Compatibility',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="checkbox" name="cbvtDZiner"/>
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>

	<div class="modal disableModuleModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_CONFIRM_DISABLE_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground disableModuleForm">
			<div class="modal-body">
				<div class="control-group">
					<strong>
						<?php echo vtranslate('You can re-enable from Module Manager',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
					</strong>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>

	<!--div class="modal exportModuleModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_CONFIRM_EXPORT_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground exportModuleForm">
		<input type="hidden" name="forModule" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
">
			<div class="modal-body">
				<div class="control-group">
					<strong>
						<?php echo vtranslate('Export module and attributes to a Vtiger installable ZIP file',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
					</strong>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div-->

	<div class="modal removeModuleModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_CONFIRM_REMOVE_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground removeModuleForm">
			<div class="modal-body">
				<div class="control-group">
					<strong>
						<?php echo vtranslate('Be Absolutely SURE !!! This step is not revocable. Ensure that you have a backup and are quite sure of this step. This action will delete all module scripts, data and crm meta data',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
					</strong>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('vtDZiner Key',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="text" name="vtDZinerKey" value='' />
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('vtDZiner Reset Key',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="text" name="vtDZinerResetKey" value='' />
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>

	<div class="modal registerCustomWorkflowModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_ADD_WORKFLOW_METHOD',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground registerCustomWorkflowForm">
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_WORKFLOW_LABEL',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="text" name="cmLabel" value='' />
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_WORKFLOW_METHOD_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="text" name="cmName" value='' />
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_WORKFLOW_HANDLER_NAME',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<input type="text" name="cmHandler" value='' />
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>

	<div class="modal changeParentCategoryModal hide">
			<div class="modal-header">
					<button class="close vtButton" data-dismiss="modal">x</button>
							<h3><?php echo vtranslate('Change Parent Menu for ',"Settings::vtDZiner");?>
<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
</h3>
			</div>
			<form class="form-horizontal contentsBackground changeParentCategoryForm">
					<div class="modal-body">
							<div class="control-group">
									<span class="control-label">
									<?php echo vtranslate('LBL_MENU_CATEGORYNAME',"Settings::vtDZiner");?>
<br>
									Present Parent Menu Category is <strong><?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->parent;?>
</strong>
									</span>
									<div class="controls">
										<span class="row-fluid">
											<select class="vtselector span6" name="newParentCategory" id="newParentCategory">
												<?php  $_smarty_tpl->tpl_vars['v'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['v']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PARENTTAB']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['v']->key => $_smarty_tpl->tpl_vars['v']->value){
$_smarty_tpl->tpl_vars['v']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['v']->key;
?>
													<option value="<?php echo $_smarty_tpl->tpl_vars['v']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['v']->value;?>
</option>
												<?php } ?>
											</select>
										</span>
									</div>
							</div>
					</div>
					<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

					<input type="hidden" name="oldParentCategory" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->parent;?>
">
					<input type="hidden" name="sourceModule" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
">
			</form>
	</div>

	<div class="modal uploadModuleImageIconModal hide">
		<div class="modal-header">
			<button class="close vtButton" data-dismiss="modal">x</button>
				<h3><?php echo vtranslate('LBL_MODULE_IMAGE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
		</div>
		<form class="form-horizontal contentsBackground uploadModuleImageIconForm" enctype="multipart/form-data">
		<input name="module" id="module" type="hidden" value="vtDZiner" />
		<input name="parent" id="parent" type="hidden" value="Settings" />
		<input name="view" id="view" type="hidden" value="IndexAjax" />
		<input name="mode" id="mode" type="hidden" value="saveIcon" />
		<input id="selectedModuleName" name="selectedModuleName" type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
" />
			<div class="modal-body">
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_PRESENT_IMAGE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<?php $_smarty_tpl->tpl_vars["moduleImage"] = new Smarty_variable("layouts/vlayout/skins/images/".($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value).".png", null, 0);?>
						<?php if (file_exists($_smarty_tpl->tpl_vars['moduleImage']->value)){?>
							<img title="Present Image/Icon" alt="Present Image/Icon" src="<?php echo $_smarty_tpl->tpl_vars['moduleImage']->value;?>
" class="alignMiddle">	
						<?php }else{ ?>
							No present image found
						<?php }?>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_PROPOSED_IMAGE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<div id="preview"></div>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_SELECT_IMAGE_FILE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<!--<input type="file" id = "moduleImageFile" name="moduleImageFile" onchange="readURL(this);"/>-->
						<input type="file" id="file" class="file_uploader" multiple name="file"/>
					</div>
				</div>
				
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_PROPOSED_IMAGE_SUMVIEW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<div id="preview_sum"></div>
					</div>
				</div>
				<div class="control-group">
					<span class="control-label">
						<strong>
							<?php echo vtranslate('LBL_SELECT_IMAGE_FILE_SUMVIEW',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 <span class="redColor">*</span>
						</strong>
					</span>
					<div class="controls">
						<!--<input type="file" id = "moduleImageFile" name="moduleImageFile" onchange="readURL(this);"/>-->
						<input type="file" id="file_sum" class="file_uploader_sum" multiple name="file_sum"/>
					</div>
				</div>
			</div>
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('ModalFooter.tpl','Vtiger'), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</form>
	</div>
</div><?php }} ?>