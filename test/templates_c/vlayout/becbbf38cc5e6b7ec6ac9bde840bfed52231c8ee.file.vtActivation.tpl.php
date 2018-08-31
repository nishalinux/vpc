<?php /* Smarty version Smarty-3.1.7, created on 2018-08-29 15:24:15
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtActivation.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21425572465b86ba9f7a82e5-95165440%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'becbbf38cc5e6b7ec6ac9bde840bfed52231c8ee' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtActivation.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21425572465b86ba9f7a82e5-95165440',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ACTIVATIONACTION' => 0,
    'ACTIVATIONRESULT' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b86ba9f7c053',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b86ba9f7c053')) {function content_5b86ba9f7c053($_smarty_tpl) {?><?php if ($_GET['debug']=='yes'){?>
	<?php $_smarty_tpl->smarty->loadPlugin('Smarty_Internal_Debug'); Smarty_Internal_Debug::display_debug($_smarty_tpl); ?>
	<?php echo $_smarty_tpl->tpl_vars['ACTIVATIONACTION']->value;?>
<br>
	<?php echo $_smarty_tpl->tpl_vars['ACTIVATIONRESULT']->value;?>

<?php }?>
<div class="container-fluid">
	<hr>
	<h3>Theracann License Activation/Authentication Required</h3><hr/>
	<h4>Please submit your ACTIVATION KEY and click on the Activate button<br> For activation to work, please ensure that outbound posts are allowed from your web hosting environment to the url given below<br><br> <font color="red">http://support.vtigress.com/vtdziner</font>&nbsp;<sup><a href="javascript:testPosts();">Click to test</a></sup>
	<br><br> Without the outbound posts allowed, Theracann will fail to be activated
	<br> Contact <a href="mailto:support@theracann.com">support@theracann.com</a> if you have any problems </h4>
	<br>
	<h4>If activation fails, click on the RESET button to show the Reset Installation form</h4>
	<hr>
</div>

<div class="control-group">
	<span class="control-label">
		<strong>
			Activation Key
		</strong>
	</span>
	<div class="controls">
		<span class="row-fluid">
			<input type="text" id="registrationkey" name="registrationkey" size="80" class="span4" />
		</span>
	</div>
</div>
<!-- Next -->
<div class="control-group" id="resetblock" style="display:none">
	<span class="control-label">
		<strong>
			Reset Key
		</strong>
	</span>
	<div class="controls">
		<span class="row-fluid">
			<input type="text" id="secondarykey" name="secondarykey" size="80" class="span4" />
		</span>
	</div>
</div>
<div>
	<input type="hidden" id="regmode" name="regmode" value=".$activationAction." />
	<input id="activatebutton" type="button" class="addButton" value='Activate' onclick='activateTheracann("activate");' title="Enter the Activation Key and click to Activate"/>
	<input id="resetbutton" type="button" value='Reset' onclick='showResetBlock();' title="Click to display RESET form"/>
	<input style="display:none" id="reactivatebutton" type="button" value='Reset & Activate' onclick='activateTheracann("register");'/>
</div>
<hr>
<div>
<h3 class="validationResult redColor"></h3>
</div>
<div class="echobackResult redColor">
</div>
<script type="text/javascript" src="resources/Connector.js"></script>
<script>
function showResetBlock(){
jQuery('[id="resetblock"]').show();
jQuery('[id="activatebutton"]').hide();
jQuery('[id="reactivatebutton"]').show();
jQuery('[id="resetbutton"]').hide();
}

function testPosts(){
	jQuery(".echobackResult").html("Testing for HTTP POST from Server&nbsp;<img src='./layouts/vlayout/skins/images/vtbusy.gif'>");
	var params = {};
	params['module'] = 'vtDZiner';
	params['parent'] = 'Settings';
	params['view'] = 'Index';
	params['mode'] = 'echoback';
	AppConnector.request(params).then(function(data) {
		jQuery(".echobackResult").html(data);
	});
}

function activateTheracann(regmode){
	jQuery(".echobackResult").html('');
	jQuery(".validationResult").html('');
	var params = {};
	params['module'] = 'vtDZiner';
	params['parent'] = 'Settings';
	params['view'] = 'Index';
	params['mode'] = 'validatevtDZinerLicense';
	params['regmode'] = regmode;
	params['secondarykey'] = jQuery("#secondarykey").val();
	params['registrationkey'] = jQuery("#registrationkey").val();
	AppConnector.request(params).then(function(data) 
		{
			if (data=="") {
				window.location.reload();
			} else {
				resultInfo = data.split(":||:");
				jQuery(".validationResult").html(resultInfo[0]);
			}
		}
	);
}
</script><?php }} ?>