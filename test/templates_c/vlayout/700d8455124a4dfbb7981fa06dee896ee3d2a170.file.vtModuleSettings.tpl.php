<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:15
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtModuleSettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:9075982455b7320a7f02b92-98192399%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '700d8455124a4dfbb7981fa06dee896ee3d2a170' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtModuleSettings.tpl',
      1 => 1517985631,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '9075982455b7320a7f02b92-98192399',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'moduleImage' => 0,
    'SELECTED_MODULE_NAME' => 0,
    'QUALIFIED_MODULE' => 0,
    'TRACKINGENABLED' => 0,
    'Module' => 0,
    'SELECTED_MODULE_MODEL' => 0,
    'MODULEDELETABLE' => 0,
    'SHOWVALUES' => 0,
    'MODULEENABLED' => 0,
    'MODULEHIERARCHYENABLED' => 0,
    'PANELTABS' => 0,
    'PICKBLOCKS' => 0,
    'GRIDBLOCKSENABLED' => 0,
    'PORTALINFO' => 0,
    'TYPEDBLOCKS' => 0,
    'USERCUSTOMVIEWID' => 0,
    'BLOCKS' => 0,
    'ALLMODULEFIELDS' => 0,
    'RELATEDLIST' => 0,
    'CUSTOMVIEWS' => 0,
    'LISTBLOCKID' => 0,
    'MODULEWIDGETS' => 0,
    'WORKFLOWLIST' => 0,
    'WIDGETLIST' => 0,
    'SCRIPT_NAME' => 0,
    'USER_MODEL' => 0,
    'SKIN_PATH' => 0,
    'PORTAL_URL' => 0,
    'SUPPORTED_MODULES' => 0,
    'ALLTABSINFO' => 0,
    'LANGUAGES' => 0,
    'PARENTTAB' => 0,
    'MODULE' => 0,
    'VTDZINSTALLED' => 0,
    'VTDZLATEST' => 0,
    'ADD_SUPPORTED_FIELD_TYPES' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a8037fd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a8037fd')) {function content_5b7320a8037fd($_smarty_tpl) {?><div class="row-fluid layoutBlockHeader">
  <div class="blockLabel padding10 span5 marginLeftZero">
	<?php $_smarty_tpl->tpl_vars["moduleImage"] = new Smarty_variable("layouts/vlayout/skins/images/".($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value).".png", null, 0);?>
	<?php if (file_exists($_smarty_tpl->tpl_vars['moduleImage']->value)){?>
		<img id="moduleimg" title="Module Image/Icon" alt="Module Image/Icon" src="<?php echo $_smarty_tpl->tpl_vars['moduleImage']->value;?>
" class="alignMiddle moduleimg">
	<?php }else{ ?>
		<img title="Module Image/Icon(default)" alt="Module Image/Icon(default)" src="layouts/vlayout/skins/images/DefaultModule.png" class="alignMiddle">
	<?php }?>
    <h3 style="display:inline">
      <?php echo vtranslate($_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 :: <?php echo vtranslate('LBL_MODULEDZINER_OPTIONS',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>

    </h3>
  </div>
  <div style="float:right !important;" class="span6 marginLeftZero moduleDZinerButtons">
    <div style="margin: 4px;" class="pull-right btn-toolbar blockActions">
		<!--
		<button class="btn addButton vtDZinerTestDrive" type="button" onclick="window.location.href = 'index.php?module=<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
&view=List';"><i class="icon-road"></i>&nbsp;<strong><?php echo vtranslate('LBL_TESTDRIVE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong></button>
		&nbsp;
		-->
		<button class="btn addButton addCategory inline" type="button">
			<i class="icon-list"></i>&nbsp;
			<strong>Menu DZiner</strong>
		</button>
		&nbsp;
		<button class="btn addButton addCustomModule" type="button">
			<i class="icon-plus icon-white"></i>&nbsp;
			<strong><?php echo vtranslate('LBL_CREATE_MODULE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
		</button>
		&nbsp;
      <div class="btn-group" style="top:10px;">
        <button data-toggle="dropdown" class="btn dropdown-toggle">
          <strong>
            Actions
          </strong>
          &nbsp;&nbsp;
          <i class="caret">
          </i>
        </button>
        <ul class="dropdown-menu pull-right">
          <li class="ERMap">
            <a href="index.php?parent=Settings&module=vtDZiner&view=ERMap&source_module=<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
">
              ER Map 
            </a>
          </li>
          <li class="changeParentCategory">
            <a href="javascript:void(0)">
              Parent Category
            </a>
          </li>
          <li class="uploadModuleImageIcon">
            <a href="javascript:void(0)">
              Upload Icon/Image
            </a>
          </li>
          <li class="registerCustomWorkflow">
            <a href="javascript:void(0)">
              Workflow Methods
            </a>
          </li>
          <li class="enableTracker">
            <a href="javascript:void(0)">
              <?php if ($_smarty_tpl->tpl_vars['TRACKINGENABLED']->value){?>Disable Tracker<?php }else{ ?>Enable Tracker<?php }?>
            </a>
          </li>
          <!--li class="enablePortal">
            <a href="javascript:void(0)">
              Portal Settings
            </a>
          </li-->
          <li class="enablevtDZiner">
            <a href="javascript:void(0)">
              Enable <?php echo vtranslate('vtDZiner',$_smarty_tpl->tpl_vars['Module']->value);?>

            </a>
          </li>
          <li class="exportModule">
            <!--a href="javascript:void(0)"-->
            <a href="index.php?module=ModuleManager&parent=Settings&action=ModuleExport&mode=exportModule&forModule=<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
">
              Export module
            </a>
          </li>
          <li class="importModule">
            <a href="index.php?module=ModuleManager&parent=Settings&view=ModuleImport&mode=importUserModuleStep1">
              Import module from ZIP
            </a>
          </li>
          <li class="disableModule">
            <a href="javascript:void(0)">
              Disable module
            </a>
          </li>
          <!--li class="removeModule">
            <a href="javascript:void(0)">
              Remove module
            </a>
          </li-->
        </ul>
      </div>
    </div>
  </div>
</div>
<hr/>
<div class="panel-group" id="accordion">
	<div class="panel panel-default blockHeader">
		<div class="panel-heading blockLabel">
			<h3 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse1"><i class="icon-chevron-down alignMiddle"></i>&nbsp;Properties</a>
			</h3><br>
		</div>
		<div id="collapse1" class="panel-collapse collapse">
			<table class="table equalSplit">
				<tr><td>MODULE ID</td><td><?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->id;?>
</td><td>Fixed during setup or install</td></tr>
				<tr><td>MODULE NAME</td><td><?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
</td><td></td></tr>
				<tr><td>MODULE LABEL</td><td><?php echo vtranslate($_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->label,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</td><td></td></tr>
				<tr><td>MODULE CATEGORY</td><td><?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->parent;?>
</td><td></td></tr>
				<tr><td>MODULE DELETABLE</td><td><?php echo $_smarty_tpl->tpl_vars['MODULEDELETABLE']->value;?>
</td><td></td></tr>
				<tr><td>SHOW VALUES</td><td><?php echo $_smarty_tpl->tpl_vars['SHOWVALUES']->value;?>
</td><td></td></tr>
				<tr><td>MODULE ENABLED</td><td><?php echo $_smarty_tpl->tpl_vars['MODULEENABLED']->value;?>
</td><td></td></tr>
				<tr><td>MODULE HIERARCHY ENABLED</td><td><?php echo $_smarty_tpl->tpl_vars['MODULEHIERARCHYENABLED']->value;?>
</td><td></td></tr>
				<tr><td>MODULE PANEL ENABLED</td><td><?php if (isset($_smarty_tpl->tpl_vars['PANELTABS']->value)){?>Yes<?php }else{ ?>No<?php }?></td><td></td></tr>
				<tr><td>MODULE PICKBLOCK ENABLED</td><td><?php if (isset($_smarty_tpl->tpl_vars['PICKBLOCKS']->value)){?>Yes<?php }else{ ?>No<?php }?></td><td></td></tr>
				<tr><td>GRID BLOCKS ENABLED</td><td><?php echo $_smarty_tpl->tpl_vars['GRIDBLOCKSENABLED']->value;?>
</td><td></td></tr>
				<tr><td>PORTAL ENABLED</td><td><?php if ($_smarty_tpl->tpl_vars['PORTALINFO']->value["present"]){?>Present<?php if ($_smarty_tpl->tpl_vars['PORTALINFO']->value["visible"]){?>, Visibility is ON<?php }else{ ?>, Visibility is OFF<?php }?><?php }else{ ?>Not Present<?php }?></td><td></td></tr>
				<tr><td>TRACKING ENABLED</td><td><?php if ($_smarty_tpl->tpl_vars['TRACKINGENABLED']->value){?>Yes<?php }else{ ?>No<?php }?></td><td></td></tr>
				<tr><td>TYPED BLOCKS</td><td><?php echo $_smarty_tpl->tpl_vars['TYPEDBLOCKS']->value;?>
</td><td></td></tr>
				<tr><td>USER CUSTOM VIEW ID</td><td><?php echo $_smarty_tpl->tpl_vars['USERCUSTOMVIEWID']->value;?>
</td><td></td></tr>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
				<a data-toggle="collapse" data-parent="#accordion" href="#collapse2"><i class="icon-chevron-down alignMiddle"></i>&nbsp;Components</a>
			</h3><br>
		</div>
		<div id="collapse2" class="panel-collapse collapse">
			<table class="table equalSplit">
			<tr><td>MODULE LANGUAGES LIST</td><td class="dvtCellInfo modulelanguages"></td><td></td></tr>
			<tr><td>BLOCKS</td><td onmouseover="showModuleInfoDetails(blocksList);"><?php echo count($_smarty_tpl->tpl_vars['BLOCKS']->value);?>
</td><td></td></tr>
			<tr><td>ALL MODULE FIELDS</td><td><?php echo count($_smarty_tpl->tpl_vars['ALLMODULEFIELDS']->value);?>
</td><td></td></tr>
			<tr><td>RELATED LIST</td><td><?php echo $_smarty_tpl->tpl_vars['RELATEDLIST']->value;?>
</td><td></td></tr>
			<tr><td>PARENT RELATIONS LIST</td><td><?php echo $_smarty_tpl->tpl_vars['RELATEDLIST']->value;?>
</td><td></td></tr>
			<tr><td>CUSTOM VIEWS</td><td><?php echo count($_smarty_tpl->tpl_vars['CUSTOMVIEWS']->value);?>
</td><td></td></tr>
			<tr><td>GRID BLOCKS LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['LISTBLOCKID']->value);?>
</td><td></td></tr>
			<tr><td>PANEL LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['PANELTABS']->value);?>
</td><td></td></tr>
			<tr><td>PICKBLOCKS</td><td><?php echo count($_smarty_tpl->tpl_vars['PICKBLOCKS']->value);?>
</td><td></td></tr>
			<tr><td>WIDGET LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['MODULEWIDGETS']->value);?>
</td><td></td></tr>
			<tr><td>WORKFLOW LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['WORKFLOWLIST']->value);?>
</td><td></td></tr>
			<tr><td>FIELDFORMULA LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['WIDGETLIST']->value);?>
</td><td></td></tr>
			<tr><td>TOOLTIP LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['WIDGETLIST']->value);?>
</td><td></td></tr>
			<tr><td>IMPORT MAPPINGS LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['WIDGETLIST']->value);?>
</td><td></td></tr>
			<tr><td>SCRIPTS LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['WIDGETLIST']->value);?>
</td><td></td></tr>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse3"><i class="icon-chevron-down alignMiddle"></i>&nbsp;Environment</a>
			</h3><br>
		</div>
		<div id="collapse3" class="panel-collapse collapse">
			<table class="table equalSplit">
				<tr><td>SCRIPT_NAME</td><td><?php echo $_smarty_tpl->tpl_vars['SCRIPT_NAME']->value;?>
</td><td></td></tr>
				<tr><td>DATEFORMAT</td><td><?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->date_format;?>
</td><td></td></tr>
				<tr><td>IMAGE_PATH</td><td><?php echo $_smarty_tpl->tpl_vars['SKIN_PATH']->value;?>
</td><td></td></tr>
				<tr><td>THEME</td><td><?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->theme;?>
</td><td></td></tr>
				<tr><td>PORTAL URL</td><td><?php echo $_smarty_tpl->tpl_vars['PORTAL_URL']->value;?>
</td><td></td></tr>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse4"><i class="icon-chevron-down alignMiddle"></i>&nbsp;ERP Info</a>
			</h3><br>
		</div>
		<div id="collapse4" class="panel-collapse collapse">
			<table class="table equalSplit">
				<tr><td>MODULES</td><td><?php echo count($_smarty_tpl->tpl_vars['SUPPORTED_MODULES']->value);?>
</td><td></td></tr>
				<tr><td>ALL TABS INFO</td><td><?php echo $_smarty_tpl->tpl_vars['ALLTABSINFO']->value;?>
</td><td></td></tr>
				<tr><td>LANGUAGES LIST</td><td><?php echo count($_smarty_tpl->tpl_vars['LANGUAGES']->value);?>
</td><td></td></tr>
				<tr><td>PARENT CATEGORIES</td><td><?php echo count($_smarty_tpl->tpl_vars['PARENTTAB']->value);?>
</td><td></td></tr>
			</table>
		</div>
	</div>
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse5"><i class="icon-chevron-down alignMiddle"></i>&nbsp;<?php echo vtranslate('vtDZiner',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</a>
			</h3><br>
		</div>
		<div id="collapse5" class="panel-collapse collapse">
			<table class="table equalSplit">
				<tr><td><?php echo vtranslate('Dzined',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</td><td><?php echo $_smarty_tpl->tpl_vars['VTDZINSTALLED']->value;?>
</td><td></td></tr>
				<tr><td>UPDATED</td><td><?php echo $_smarty_tpl->tpl_vars['VTDZLATEST']->value;?>
</td><td></td></tr>
				<tr><td>UI TYPES</td><td><?php echo count($_smarty_tpl->tpl_vars['ADD_SUPPORTED_FIELD_TYPES']->value);?>
</td><td></td></tr>
			</table>
		</div>
	</div>
	<!--
	<div class="panel panel-default">
		<div class="panel-heading">
			<h3 class="panel-title">
			<a data-toggle="collapse" data-parent="#accordion" href="#collapse6"><i class="icon-chevron-down alignMiddle"></i>&nbsp;vtDZiner IDE</a>
			</h3><br>
		</div>
		<div id="collapse6" class="panel-collapse collapse">
			<h4>Enter vtDZiner script for results</h4>
			<table class="table equalSplit">
				<tr>
					<th>
					Tools
					</th>
					<th>
					Input Control Area
					</th>
					<th>
					Result Area
					</th>
				</tr>
				<tr>
					<td><span class="pull-left">
						<table>
						<tr>
						<td><i class="icon-asterisk alignMiddle"></i></td>
						<td><i class="icon-plus alignMiddle"></i></td>
						<td><i class="icon-minus alignMiddle"></i></td>
						<td><i class="icon-home alignMiddle"></i></td>
						<td><i class="icon-file alignMiddle"></i></td>
						<td><i class="icon-envelope alignMiddle"></i></td>
						<td><i class="icon-pencil alignMiddle"></i></td>
						<td><i class="icon-glass alignMiddle"></i></td>
						<td><i class="icon-music alignMiddle"></i></td>
						<td><i class="icon-search alignMiddle"></i></td>
						</tr>
						<tr>
						<td><i class="icon-heart alignMiddle"></i></td>
						<td><i class="icon-star alignMiddle"></i></td>
						<td><i class="icon-star-empty alignMiddle"></i></td>
						<td><i class="icon-user alignMiddle"></i></td>
						<td><i class="icon-film alignMiddle"></i></td>
						<td><i class="icon-th-large alignMiddle"></i></td>
						<td><i class="icon-th alignMiddle"></i></td>
						<td><i class="icon-th-list alignMiddle"></i></td>
						<td><i class="icon-ok alignMiddle"></i></td>
						<td><i class="icon-remove alignMiddle"></i></td>
						</tr>
						<tr>
						<td><i class="icon-zoom-in alignMiddle"></i></td>
						<td><i class="icon-zoom-out alignMiddle"></i></td>
						<td><i class="icon-off alignMiddle"></i></td>
						<td><i class="icon-signal alignMiddle"></i></td>
						<td><i class="icon-cog alignMiddle"></i></td>
						<td><i class="icon-time alignMiddle"></i></td>
						<td><i class="icon-road alignMiddle"></i></td>
						<td><i class="icon-download-alt alignMiddle"></i></td>
						<td><i class="icon-download alignMiddle"></i></td>
						<td><i class="icon-upload alignMiddle"></i></td>
						</tr>
						<tr>
						<td><i class="icon-inbox alignMiddle"></i></td>
						<td><i class="icon-play-circle alignMiddle"></i></td>
						<td><i class="icon-repeat alignMiddle"></i></td>
						<td><i class="icon-refresh alignMiddle"></i></td>
						<td><i class="icon-list-alt alignMiddle"></i></td>
						<td><i class="icon-lock alignMiddle"></i></td>
						<td><i class="icon-flag alignMiddle"></i></td>
						<td><i class="icon-headphones alignMiddle"></i></td>
						<td><i class="icon-volume-off alignMiddle"></i></td>
						<td><i class="icon-volume-down alignMiddle"></i></td>
						</tr>
						<tr>
						<td><i class="icon-volume-up alignMiddle"></i></td>
						<td><i class="icon-qrcode alignMiddle"></i></td>
						<td><i class="icon-barcode alignMiddle"></i></td>
						<td><i class="icon-tag alignMiddle"></i></td>
						<td><i class="icon-tags alignMiddle"></i></td>
						<td><i class="icon-book alignMiddle"></i></td>
						<td><i class="icon-bookmark alignMiddle"></i></td>
						<td><i class="icon-print alignMiddle"></i></td>
						<td><i class="icon-camera alignMiddle"></i></td>
						<td><i class="icon-font alignMiddle"></i></td>
						</tr>
						<tr>
						<td><i class="icon-bold alignMiddle"></i></td>
						<td><i class="icon-italic alignMiddle"></i></td>
						<td><i class="icon-text-height alignMiddle"></i></td>
						<td><i class="icon-text-width alignMiddle"></i></td>
						<td><i class="icon-align-left alignMiddle"></i></td>
						<td><i class="icon-align-center alignMiddle"></i></td>
						<td><i class="icon-align-right alignMiddle"></i></td>
						<td><i class="icon-align-justify alignMiddle"></i></td>
						<td><i class="icon-list alignMiddle"></i></td>
						<td><i class="icon-indent-left alignMiddle"></i></td>
						</tr>
						<tr>
						</tr>
						</table>
						</span>
					</td>
					<td>
					<textarea class="form-control" rows="10">&nbsp;</textarea>
					</td>
					<td>
					<textarea class="form-control" rows="10">&nbsp;</textarea>
					</td>
				</tr>
			</table>
		</div>
	</div>


	//jQuery(document).ready(function(){    
	//    jQuery('#collapse6').on('shown', function () {
	//       jQuery(".icon-chevron-down").removeClass("icon-chevron-down").addClass("icon-chevron-up");
	//    });
	//
	//    jQuery('#collapse6').on('hidden', function () {
	//       jQuery(".icon-chevron-up").removeClass("icon-chevron-up").addClass("icon-chevron-down");
	//    });
	//});

	-->
</div><?php }} ?>