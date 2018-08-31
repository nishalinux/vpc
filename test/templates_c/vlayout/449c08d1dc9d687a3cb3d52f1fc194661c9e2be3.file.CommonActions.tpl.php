<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 17:36:46
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/CommonActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:197054715b73132e515b01-94302472%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '449c08d1dc9d687a3cb3d52f1fc194661c9e2be3' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Vtiger/CommonActions.tpl',
      1 => 1533562434,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '197054715b73132e515b01-94302472',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ANNOUNCEMENT' => 0,
    'USER_MODEL' => 0,
    'COMPANY_LOGO' => 0,
    'MODULE_NAME' => 0,
    'SEARCHABLE_MODULES' => 0,
    'SEARCHED_MODULE' => 0,
    'announcement' => 0,
    'MODULE' => 0,
    'MAIN_PRODUCT_WHITELABEL' => 0,
    'MENUS' => 0,
    'moduleModel' => 0,
    'singularLabel' => 0,
    'quickCreateModule' => 0,
    'count' => 0,
    'moduleName' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73132e5888b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73132e5888b')) {function content_5b73132e5888b($_smarty_tpl) {?>

<?php $_smarty_tpl->tpl_vars["announcement"] = new Smarty_variable($_smarty_tpl->tpl_vars['ANNOUNCEMENT']->value->get('announcement'), null, 0);?><?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable(0, null, 0);?><?php $_smarty_tpl->tpl_vars["dateFormat"] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('date_format'), null, 0);?><div class="navbar commonActionsContainer noprint"><div class="actionsContainer row-fluid"><div class="span2"><span class="companyLogo"><img src="<?php echo $_smarty_tpl->tpl_vars['COMPANY_LOGO']->value->get('imagepath');?>
" title="<?php echo $_smarty_tpl->tpl_vars['COMPANY_LOGO']->value->get('title');?>
" alt="<?php echo $_smarty_tpl->tpl_vars['COMPANY_LOGO']->value->get('alt');?>
"/>&nbsp;</span></div><div class="span10"><div class="row-fluid"><div class="searchElement span8"><div class="select-search"><select class="chzn-select" id="basicSearchModulesList" style="width:150px;"><option value="" class="globalSearch_module_All"><?php echo vtranslate('LBL_ALL_RECORDS',$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</option><?php  $_smarty_tpl->tpl_vars['fieldObject'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['fieldObject']->_loop = false;
 $_smarty_tpl->tpl_vars['MODULE_NAME'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['SEARCHABLE_MODULES']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['fieldObject']->key => $_smarty_tpl->tpl_vars['fieldObject']->value){
$_smarty_tpl->tpl_vars['fieldObject']->_loop = true;
 $_smarty_tpl->tpl_vars['MODULE_NAME']->value = $_smarty_tpl->tpl_vars['fieldObject']->key;
?><?php if (isset($_smarty_tpl->tpl_vars['SEARCHED_MODULE']->value)&&$_smarty_tpl->tpl_vars['SEARCHED_MODULE']->value==$_smarty_tpl->tpl_vars['MODULE_NAME']->value&&$_smarty_tpl->tpl_vars['SEARCHED_MODULE']->value!=='All'){?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" class="globalSearch_module_<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" selected><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</option><?php }else{ ?><option value="<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
" class="globalSearch_module_<?php echo $_smarty_tpl->tpl_vars['MODULE_NAME']->value;?>
"><?php echo vtranslate($_smarty_tpl->tpl_vars['MODULE_NAME']->value,$_smarty_tpl->tpl_vars['MODULE_NAME']->value);?>
</option><?php }?><?php } ?></select></div><div class="input-append searchBar"><input type="text" class="" id="globalSearchValue" placeholder="<?php echo vtranslate('LBL_GLOBAL_SEARCH');?>
" results="10" /><span id="searchIcon" class="add-on search-icon"><i class="icon-white icon-search "></i></span><span class="adv-search  pull-left"><a class="alignMiddle" id="globalSearch"><?php echo vtranslate('LBL_ADVANCE_SEARCH');?>
</a></span></div></div><div class="notificationMessageHolder span2"><form name="timerform"><font color='red'><strong>Auto logout in <span id="timer"></span></strong></font><input type="hidden" id="ck_open_close" name="ck_open_close" value="close" /><input type="hidden" id="autologout_time_1" name="autologout_time" value="<?php echo $_smarty_tpl->tpl_vars['USER_MODEL']->value->get('autologout_time');?>
" /></form></div><div class="nav quickActions btn-toolbar span2 pull-right marginLeftZero"><div class="pull-right commonActionsButtonContainer"><?php if (!empty($_smarty_tpl->tpl_vars['announcement']->value)){?><div class="btn-group cursorPointer"><img class='alignMiddle' src="<?php echo vimage_path('btnAnnounceOff.png');?>
" alt="<?php echo vtranslate('LBL_ANNOUNCEMENT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" title="<?php echo vtranslate('LBL_ANNOUNCEMENT',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" id="announcementBtn" /></div>&nbsp;<?php }?><div class="btn-group cursorPointer" id="guiderHandler"><?php if (!$_smarty_tpl->tpl_vars['MAIN_PRODUCT_WHITELABEL']->value){?><?php }?></div>&nbsp;<div class="btn-group cursorPointer"><img id="menubar_quickCreate" src="<?php echo vimage_path('btnAdd.png');?>
" class="alignMiddle" alt="<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" title="<?php echo vtranslate('LBL_QUICK_CREATE',$_smarty_tpl->tpl_vars['MODULE']->value);?>
" data-toggle="dropdown" /><ul class="dropdown-menu dropdownStyles commonActionsButtonDropDown"><li class="title"><strong><?php echo vtranslate('Quick Create',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</strong></li><hr/><li id="quickCreateModules"><div class="row-fluid"><div class="span12"><?php  $_smarty_tpl->tpl_vars['moduleModel'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['moduleModel']->_loop = false;
 $_smarty_tpl->tpl_vars['moduleName'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['MENUS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['moduleModel']->key => $_smarty_tpl->tpl_vars['moduleModel']->value){
$_smarty_tpl->tpl_vars['moduleModel']->_loop = true;
 $_smarty_tpl->tpl_vars['moduleName']->value = $_smarty_tpl->tpl_vars['moduleModel']->key;
?><?php if ($_smarty_tpl->tpl_vars['moduleModel']->value->isPermitted('EditView')){?><?php $_smarty_tpl->tpl_vars['quickCreateModule'] = new Smarty_variable($_smarty_tpl->tpl_vars['moduleModel']->value->isQuickCreateSupported(), null, 0);?><?php $_smarty_tpl->tpl_vars['singularLabel'] = new Smarty_variable($_smarty_tpl->tpl_vars['moduleModel']->value->getSingularLabelKey(), null, 0);?><?php if ($_smarty_tpl->tpl_vars['singularLabel']->value=='SINGLE_Calendar'){?><?php $_smarty_tpl->tpl_vars['singularLabel'] = new Smarty_variable('LBL_EVENT_OR_TASK', null, 0);?><?php }?><?php if ($_smarty_tpl->tpl_vars['quickCreateModule']->value=='1'){?><?php if ($_smarty_tpl->tpl_vars['count']->value%3==0){?><div class="row-fluid"><?php }?><div class="span4"><a id="menubar_quickCreate_<?php echo $_smarty_tpl->tpl_vars['moduleModel']->value->getName();?>
" class="quickCreateModule" data-name="<?php echo $_smarty_tpl->tpl_vars['moduleModel']->value->getName();?>
"data-url="<?php echo $_smarty_tpl->tpl_vars['moduleModel']->value->getQuickCreateUrl();?>
" href="javascript:void(0)"><?php echo vtranslate($_smarty_tpl->tpl_vars['singularLabel']->value,$_smarty_tpl->tpl_vars['moduleName']->value);?>
</a></div><?php if ($_smarty_tpl->tpl_vars['count']->value%3==2){?></div><?php }?><?php $_smarty_tpl->tpl_vars['count'] = new Smarty_variable($_smarty_tpl->tpl_vars['count']->value+1, null, 0);?><?php }?><?php }?><?php } ?></div></div></li></ul></div>&nbsp;</div></div></div></div></div></div><!--Auto logout universal, Dev: Anjaneya, Date: 25th Oct'2107 --><script src="timeout/jquery.storageapi.min.js" type="text/javascript"></script><link href="timeout/jquery-idleTimeout-plus.css" rel="stylesheet" type="text/css" /><script src="timeout/jquery-idleTimeout-plus.js" type="text/javascript"></script><!--End--><script type='text/javascript'>
//Added By sri For auto logout in 15 mins end

    var mu_val = jQuery('#autologout_time_1').val();

if(mu_val == '15 mins') { 
	mu_val = 900;
} else if(mu_val == '30 mins') {
	mu_val = 1800;
} else if (mu_val == '45 mins') {
	mu_val = 2700;
} else if (mu_val == '60 mins') {
	mu_val = 3600;
}
   // mu_val = 36;
var vtrcount=mu_val;

var vtrcounter=setInterval(timer, 1000);
function timer()
{
  vtrcount=vtrcount-1;
  if (vtrcount <= 0)
  {
     clearInterval(vtrcounter);
     <!-- Auto logout universal, Dev: Anjaneya, Date: 25th Oct'2107 -->
		/* var cURL = window.location.href;
		var url = cURL.split("?");
		var redURL = url[0]+"?module=Users&action=Logout";		 
		window.location.href = redURL */
	/* END */
		
  }

 document.getElementById("timer").innerHTML=vtrcount + " secs"; // watch for spelling
}
function updateMe( data ) {
   // alert( data );
    window.clearInterval(vtrcounter);
   
 vtrcount=mu_val;

  vtrcounter=setInterval(timer, 1000);
}
document.onkeypress = function (e) {
    e = e || window.event;
     window.clearInterval(vtrcounter);
   
 vtrcount=mu_val;

  vtrcounter=setInterval(timer, 1000);
	
};
window.ununload = function (e) {
    e = e || window.event;
     window.clearInterval(vtrcounter);
   
 vtrcount=mu_val;

  vtrcounter=setInterval(timer, 1000);
	
};

document.onmousedown = function (e) {
    e = e || window.event;
    
    console.log(e.currentTarget);
	//console.log(e.target.attr('id'));
	//console.log(jQuery(e.currentTarget).closest('[id]'));
vtrcount=mu_val;
	var targetid = e.target.id;
	if(targetid == 'Leads_editView_fieldName_cf_876_select'){
		console.log(e.target.id);
		return false;
	}else{
		window.clearInterval(vtrcounter);
		vtrcounter=setInterval(timer, 1000);
	}
	  	
};
<!-- Auto logout universal, Dev: Anjaneya, Date: 25th Oct'2107 -->
jQuery(document).scroll(function(){ 	 
	window.clearInterval(vtrcounter);
	vtrcount=mu_val;
	vtrcounter=setInterval(timer, 1000);
	
});
/* END */
jQuery(document).ready(function () {  
	if(typeof(CKEDITOR)!=='undefined'){
		CKEDITOR.on('instanceCreated', function(e) {

		e.editor.on('contentDom', function() {
		e.editor.document.on('keydown', function(event) {
		window.clearInterval(vtrcounter);
		vtrcount=mu_val;

		vtrcounter=setInterval(timer, 1000);
		});
		e.editor.document.on('mousedown', function(event) {
		window.clearInterval(vtrcounter);
		vtrcount=mu_val;

		vtrcounter=setInterval(timer, 1000);
					});
			});
		});
	}
	<!-- Auto logout universal, Dev: Anjaneya, Date: 25th Oct'2107 -->
	IdleTimeoutPlus.start({
		idleTimeLimit: mu_val,
		bootstrap : false,
		warnTimeLimit : 30,
		warnMessage : 'session is about to expire!',
		redirectUrl : 'index.php?module=Users&action=Logout',
		logoutUrl : 'index.php?module=Users&action=Logout',
		logoutautourl : 'index.php?module=Users&action=Logout',
		warnLogoutButton : null,
		multiWindowSupport : true
	}); 
	/* END */
});
//Added By sri For auto logout in 15 mins end 

//ganesh is adding for ossmail time 
function osmailclicked(){

    var srurl = $("#roundcube_interface").attr('src');
  var attachpdf = $("#attachpdf").val();
    var emailid = $("#senderemail").val();
     var senderid = $("#senderid").val();
     
     if(emailid != ''){
         //var srurl = $("#roundcube_interface").attr('src');
        $("#roundcube_interface").contents().find("#_to").val(emailid);
        $("#roundcube_interface").contents().find("#selectedcontact").val(senderid);
          
     }
     else{
         $("#roundcube_interface").contents().find("#selectedcontact").val(0);
     }
     if(attachpdf != ''){
        $("#roundcube_interface").contents().find("#attachpdf").val(attachpdf);
        var myData = window.roundcube_interface.pdfattach(attachpdf);
     }
     else{
         $("#roundcube_interface").contents().find("#attachpdf").val(0);
     }
     $("#roundcube_interface").contents().find(".send").click(function(){
         $("#senderemail").val('');
         $("#senderid").val('');
         $("#attachpdf").val('');
     });
     $("#roundcube_interface").contents().find(".savedraftSel").click(function(){
         $("#senderemail").val('');
         $("#senderid").val('');
         $("#attachpdf").val('');
     });
      $("#roundcube_interface").contents().find(".savedraft").click(function(){
         $("#senderemail").val('');
         $("#senderid").val('');
         $("#attachpdf").val('');
     });
     $("#roundcube_interface").contents().find(".back").click(function(){
         $("#senderemail").val('');
         $("#senderid").val('');
         $("#attachpdf").val('');
     });
    $("#roundcube_interface").contents().find("body").mousedown(function(cursor){
        window.clearInterval(vtrcounter);
        vtrcount=mu_val;
        vtrcounter=setInterval(timer, 1000); 
    });
    $("#roundcube_interface").contents().find("body").keydown(function(cursor){
        window.clearInterval(vtrcounter);
        vtrcount=mu_val;
        vtrcounter=setInterval(timer, 1000); 
    });

    $("#roundcube_interface").contents().find("body").click(function(cursor){
        window.clearInterval(vtrcounter);
        vtrcount=mu_val;
        vtrcounter=setInterval(timer, 1000);
    });
 
    //composebody_ifr
     window.clearInterval(vtrcounter);
        vtrcount=mu_val;
        vtrcounter=setInterval(timer, 1000);
}
/*jQuery(document).ready(function(){ 
	var rc_sessio = $("#roundcube_interface").contents().find("rc_sessio").val();
	if(rc_sessio != ''){
		alert(rc_sessio);
	}		
});*/
//Added By sri For auto logout in 15 mins end
</script>
<?php }} ?>