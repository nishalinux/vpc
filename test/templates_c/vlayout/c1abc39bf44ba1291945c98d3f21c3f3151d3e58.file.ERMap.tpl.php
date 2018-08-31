<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 21:45:02
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/ERMap.tpl" */ ?>
<?php /*%%SmartyHeaderCode:4362506295b734d5e212888-74599974%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'c1abc39bf44ba1291945c98d3f21c3f3151d3e58' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/ERMap.tpl',
      1 => 1508323966,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '4362506295b734d5e212888-74599974',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RELATED_CHILDMODULES' => 0,
    'MODULE_MODEL' => 0,
    'RELATED_PARENTMODULES' => 0,
    'IN_ACTIVE_FIELDS' => 0,
    'SELECTED_MODULE_NAME' => 0,
    'SUPPORTED_MODULES' => 0,
    'MODULE_NAME' => 0,
    'QUALIFIED_MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b734d5e26529',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b734d5e26529')) {function content_5b734d5e26529($_smarty_tpl) {?>
<script>
// Globals used
var graph="";
var paper="";
var erd = "";
var jointJSLoaded = false;
var childModulesList = [];
var parentModulesList = [];
</script>
<?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_CHILDMODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?><script>childModulesList.push(["<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
","<?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('label'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?>
", "<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename');?>
"]);</script><?php }?><?php } ?><?php  $_smarty_tpl->tpl_vars['MODULE_MODEL'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_PARENTMODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_MODEL']->key => $_smarty_tpl->tpl_vars['MODULE_MODEL']->value){
$_smarty_tpl->tpl_vars['MODULE_MODEL']->_loop = true;
?><?php if ($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->isActive()){?><script>parentModulesList.push(["<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getId();?>
","<?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename'),$_smarty_tpl->tpl_vars['MODULE_MODEL']->value->getRelationModuleName());?>
", "<?php echo $_smarty_tpl->tpl_vars['MODULE_MODEL']->value->get('modulename');?>
"]);</script><?php }?><?php } ?><div class="container-fluid" id="layoutEditorContainer"><div class="contents row-fluid"><input type="hidden" class="inActiveFieldsArray" value='<?php echo ZEND_JSON::encode($_smarty_tpl->tpl_vars['IN_ACTIVE_FIELDS']->value);?>
' /></div></div><div class="container-fluid"><div class="contents row-fluid"><h3 style="display:inline;">ER Map for <?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
</h3><span class="pull-right">Developed using <a href="http://www.jointjs.com" target="_blank"><strong>jointJS</strong></a></span></div><div><hr></div><div width="100%"><strong>Legend : <span style="background-color:#EEE423">&nbsp;Parent Entity&nbsp;</span>&nbsp;&nbsp;<span style="background-color:#2ECC71">&nbsp;Root Entity&nbsp;</span>&nbsp;&nbsp;<span style="background-color:#0FFADE">&nbsp;Child Entity&nbsp;</span></strong><span class="pull-right"><select name="VtigerModules" id="VtigerModules" onchange="changeRootModule();"><?php  $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['SUPPORTED_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['MODULE_NAME']->key => $_smarty_tpl->tpl_vars['MODULE_NAME']->value){
$_smarty_tpl->tpl_vars['MODULE_NAME']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['MODULE_NAME']->value==$_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value){?> selected <?php }?>><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
</option><?php } ?></select></span></div><div><hr></div><br><div id="paper" width="100%">Rendering ER Map for <?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
 ...</div></div>
<script>
// Globals used
 /**
  * function to load a given css file 
  */ 
 loadCSS = function(href) {
     var cssLink = jQuery("<link rel='stylesheet' type='text/css' href='"+href+"'>");
     jQuery("head").append(cssLink); 
 };

/**
 * function to load a given js file 
 */ 
 loadJS = function(src) {
     var jsLink = jQuery("<script type='text/javascript' src='"+src+"'>");
     jQuery("head").append(jsLink); 
 }; 
 // load the css file 

function changeRootModule(){
	var rootModule = jQuery("#VtigerModules").val();
	console.log(rootModule);
	window.location.assign("index.php?parent=Settings&module=vtDZiner&view=ERMap&source_module="+rootModule);
}

function loadJointJS(){

// load scripts if not loaded yet
	loadCSS("libraries/jointJS/joint.min.css");
// load the js file 
	//loadJS("libraries/jointJS/joint.min.js");
	loadJS("libraries/jointJS/joint.js");
	loadJS("libraries/jointJS/joint.shapes.vterd.js");
	jointJSLoaded=true;
}

function drawERMap(rootModule){
if (!jointJSLoaded){
	loadJointJS();
}

jQuery('#paper').empty();

graph = new joint.dia.Graph;
paper = new joint.dia.Paper({
el: jQuery('#paper'),
width: jQuery('#paper').innerWidth(),
height: 2000,
gridSize: 1,
model: graph
});

erd = joint.shapes.erd;

var element = function(elm, x, y, label, relatedModule) {
	var xlink = ((relatedModule == null) ? "javascript:void();" : "index.php?parent=Settings&module=vtDZiner&view=ERMap&source_module="+relatedModule);
    var cell = new elm({ 
		position: { 
			x: x, 
			y: y 
		}, 
		attrs: {
		a: { 'xlink:href': xlink, cursor: 'pointer'},
			text: {
				text: label
			} 
		} 
		});
    graph.addCell(cell);
    return cell;
};

var link = function(elm1, elm2) {
    var myLink = new erd.Line({ source: { id: elm1.id }, target: { id: elm2.id }});
    graph.addCell(myLink);
    return myLink;
};

rootPositionOffset = Math.floor(Math.max(parentModulesList.length, childModulesList.length)/2);
if (parentModulesList.length != childModulesList.length) {
	if (parentModulesList.length > childModulesList.length) {
			parentPositionOffset = 0;
			childPositionOffset = Math.floor(rootPositionOffset/2);
	} else {
			childPositionOffset = 0;
			parentPositionOffset = Math.floor(rootPositionOffset/2);
	}
}

var employee = element(erd.Entity, 350, rootPositionOffset*100, rootModule, null);

jQuery.each(parentModulesList, function(index,value){
	var parententity = element(erd.ParentEntity, 0, (index+parentPositionOffset)*100,  value[1], value[2]);
	link(parententity, employee).cardinality('1..N');
});

jQuery.each(childModulesList, function(index,value){
	var childentity = element(erd.ChildEntity, 700, (index+childPositionOffset)*100, value[1], value[2]);
	link(employee, childentity).cardinality('1..N');
});

console.log(jQuery('#paper').innerWidth(), ",", jQuery('#paper').innerHeight());
};

$( document ).ready(function() {
	setTimeout(function () {
        //jQuery('.drawERMap').trigger('click');
		drawERMap('<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
');
    }, 100);
});

//element(erd.Derived, 440, 80, "amount");
//element(erd.Entity, 400, 400, "Salesman");
//element(erd.ISA, 125, 300, "ISA");
//element(erd.IdentifyingRelationship, 350, 190, "gets paid");
//element(erd.Key, 0, 90, "number");
//element(erd.Multivalued, 150, 90, "skills");
//element(erd.Normal, 590, 80, "date");
//element(erd.Relationship, 300, 390, "uses");
//element(erd.WeakEntity, 530, 200, "Wage");
//link(employee, paid).cardinality('1');
//link(salesman, uses).cardinality('0..1');;
//link(car, uses).cardinality('1..1');
//link(wage, paid).cardinality('N');
</script>

<?php }} ?>