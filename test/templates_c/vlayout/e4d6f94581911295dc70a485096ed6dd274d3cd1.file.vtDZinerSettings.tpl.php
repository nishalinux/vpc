<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:16
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtDZinerSettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2524671035b7320a803cf62-62487685%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'e4d6f94581911295dc70a485096ed6dd274d3cd1' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtDZinerSettings.tpl',
      1 => 1517656884,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2524671035b7320a803cf62-62487685',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'QUALIFIED_MODULE' => 0,
    'usagecontents' => 0,
    'VTDZINER_CURRENTVERSION' => 0,
    'VTDZINER_LATESTVERSION' => 0,
    'VTDZINER_UPGRADEABLE' => 0,
    'GOOGLEAPIKEY' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a80590d',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a80590d')) {function content_5b7320a80590d($_smarty_tpl) {?><div class="contents">
	<table class="table">
		<tr class="alignMiddle">
			<td>
			<div>
				<div class="blockLabel marginLeftZero">
					<h3 style="display:inline;"><?php echo vtranslate('LBL_VTDZ_SETTINGS_TEXT',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
					<span class="pull-right">
						<button class="btn vtDZinerDeActivation">
							<i class="icon-remove"></i>&nbsp;<strong><?php echo vtranslate('LBL_VTDEACTIVATE',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</strong>
						</button>
					</span>
				</div>
			</div>
			</td>
		</tr>
	</table>
  <table class="table table-bordered equalSplit">
    <tbody>
      <tr>
        <td class="opacity">
          <div class="row-fluid moduleManagerBlock">
			  <table class="table narrow">
				<tr>
					<td>
						<strong><?php echo vtranslate('vtDZiner',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
 Usage Log</strong>
					</td>
					<td>
						<?php $_smarty_tpl->tpl_vars['usagecontents'] = new Smarty_variable($_smarty_tpl->getSubTemplate ("file:test/user/vtDZiner.log", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>

						<textarea class="form-control" rows="5" id="usagecontents"><?php echo $_smarty_tpl->tpl_vars['usagecontents']->value;?>
</textarea>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Inform DZiner Status</strong>
					</td>
					<td>
						<input type="checkbox" id="cbInFormMode" onclick="cbInFormClicked();">
					</td>
				</tr>
				<!--
				<tr>
					<td>
						<strong>vtDZiner Installed Version is <?php echo $_smarty_tpl->tpl_vars['VTDZINER_CURRENTVERSION']->value;?>
<br/>
						Latest Version is <?php echo $_smarty_tpl->tpl_vars['VTDZINER_LATESTVERSION']->value;?>
</strong>
					</td>
					<td>
						<?php if ($_smarty_tpl->tpl_vars['VTDZINER_UPGRADEABLE']->value){?>
						<button class="btn upgradevtDZiner"><i class="icon-refresh"></i>&nbsp;Update</button>
						<?php }else{ ?>
						<strong>vtDZiner is uptodate !!</strong>
						<?php }?>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Uninstall vtDZiner</strong>
					</td>
					<td>
						<button class="btn"><i class="icon-trash"></i>&nbsp;Uninstall</button>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Import UI Types (Requires UI Types ZIP file from vTigress.com)</strong>
					</td>
					<td>
						<button class="btn"><i class="icon-download-alt"></i>&nbsp;Import</button>
					</td>
				</tr>
				<tr>
					<td>
						<strong>Import vTigress Extensions</strong>
					</td>
					<td>
						<select>
							<optgroup label="Enhancements">
								<option>Forex Synchroniser</option>
								<option>vtTestData</option>
								<option>Inventory Import</option>
								<option>vtVisualizer</option>
								<option>vtTogether</option>
							</optgroup>
							<optgroup label="Integrations">
								<option>Orange HRM</option>
								<option>FrontAccounting</option>
								<option>Quickbooks</option>
								<option>Tally</option>
								<option>SAP</option>
								<option>GnuCash</option>
								<option>Magento</option>
								<option>Joomla</option>
								<option>Zen Cart</option>
								<option>SmartPOS</option>
							</optgroup>
						</select>
						<br>
						<button class="btn"><i class="icon-circle-arrow-down"></i>&nbsp;Install</button>
					</td>
				</tr>
				-->
			  </table>
          </div>
        </td>
      </tr>
    </tbody>
  </table>
  
  <table class="table">
		<tr class="alignMiddle">
			<td colspan="2">
			<div>
				<div class="blockLabel marginLeftZero">
					<h3 style="display:inline;"><?php echo vtranslate('LBL_GOOGLE_MAP_KEY',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</h3>
					
				</div>
			</div>
			</td>
		</tr>
		<tr>
			<td style="font-size:14px;">
			<span class="pull-right" >
							<strong>Google API KEY</strong>
			</span>
			</td>
			<td>
			<span class="googleapikeydisplay">
			<?php $_smarty_tpl->tpl_vars['GOOGLEAPIKEY'] = new Smarty_variable($_smarty_tpl->getSubTemplate ("file:test/user/googlemap.txt", $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0));?>

				<?php echo $_smarty_tpl->tpl_vars['GOOGLEAPIKEY']->value;?>
&nbsp;&nbsp;<span class="icon-pencil editgooglemapkey" title="Edit Google API Key" >
				</span>
				&nbsp;<br/><br/>
				<span style="color:blue">More info how to create google API key <a href="https://developers.google.com/maps/documentation/javascript/get-api-key" target="_blank" >Click here </a>
				</span>
			</span>
			<span class="edit hide">
				<input type="text" name="mapkey" id="mapkey" value="<?php echo $_smarty_tpl->tpl_vars['GOOGLEAPIKEY']->value;?>
"/>
				&nbsp;&nbsp;<button class="btn btn-success googleapikey" type="button" >
				<strong>Save</strong>
			</button>
			</span>
			</td>
		</tr>
		
	</table>
</div><?php }} ?>