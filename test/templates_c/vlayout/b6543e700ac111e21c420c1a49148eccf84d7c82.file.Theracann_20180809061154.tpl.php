<?php /* Smarty version Smarty-3.1.7, created on 2018-08-30 03:49:25
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/Theracann_20180809061154.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18380295875b730ef246b835-61054198%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'b6543e700ac111e21c420c1a49148eccf84d7c82' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/Theracann_20180809061154.tpl',
      1 => 1535600965,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18380295875b730ef246b835-61054198',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b730ef24826f',
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b730ef24826f')) {function content_5b730ef24826f($_smarty_tpl) {?><!DOCTYPE html>
<html>
   <head>
      <title></title>
      <meta name="viewport" content="width=device-width, initial-scale=1.0">
      <!-- for Login page we are added -->
      <link href="libraries/bootstrap/css/bootstrap.min.css" rel="stylesheet">
      <link href="libraries/bootstrap/css/bootstrap-responsive.min.css" rel="stylesheet">
      <link href="libraries/bootstrap/css/jqueryBxslider.css" rel="stylesheet" />
      <link href="layouts/vlayout/modules/Settings/LoginPage/resources/LoginPage.css" rel="stylesheet" />
      <link href="layouts/vlayout/modules/Settings/LoginPage/resources/LoginPagemain.css" rel="stylesheet" />	  
      <script src="libraries/jquery/jquery.min.js"></script><script src="libraries/jquery/boxslider/jqueryBxslider.js"></script>
	 
	  <script src="libraries/jquery/boxslider/respond.min.js"></script>

	   <script>
		jQuery(document).ready(function () {
			  scrollx = jQuery(window).outerWidth();
			  window.scrollTo(scrollx, 0);
			  slider = jQuery('.bxslider').bxSlider({
				  mode: 'horizontal',
				  auto: true,
				  randomStart: false,
				  autoHover: false,
				  controls: false,
				  pager: false,
				  speed: 5000,
				  easing: 'linear',
				  onSliderLoad: function () {}
			  });
		  });
		</script></head><body><div class="vte-login-container"><div class="logo"><img src="loginimages/TheraCann_SYSTEM Logo_1517844048_1533795114.png" /></div><div class="row-fluid"><div class="span6 slideshow" style="margin-left:0;">
						<div class="carousal-container">
							<ul class="bxslider"><li> <div id="slide0" class="slide"><img class="pull-left" src="loginimages/DESIGN_1517839005_1533795114.jpg"></div></li><li> <div id="slide1" class="slide"><img class="pull-left" src="loginimages/IMPLEMENT_1517839005_1533795114.jpg"></div></li><li> <div id="slide2" class="slide"><img class="pull-left" src="loginimages/PLAN_1517839005_1533795114.jpg"></div></li><li> <div id="slide3" class="slide"><img class="pull-left" src="loginimages/SUPPORT_1517839005_1533795114.jpg"></div></li></ul>
				</div>
			</div><style> .login-header, .subtitle { color:#fd9a00; } .signin-button .btn { border-color:#fd9a00; background-color:#fd9a00; } .login-more-info .copy-right small{  color: #fd9a00 } h3.forgot-password {  color: #fd9a00  !important;  }</style>
				<div class="span6 login-area">
				<div class="span12 site-info">
				<h1 class="login-header">TheraCannSYSTEM ERP</h1>
				<p class="subtitle">One SYSTEM One SOLUTION</p>
				</div>
				<div class="span12 login-box" id="loginDiv">
				<form class="form-horizontal login-form" action="index.php?module=Users&action=Login" method="POST">
					 <?php if (isset($_REQUEST['error'])){?>
                            <div class="row alert alert-error">
                                <p>Invalid username or password.</p>
                            </div>
                        <?php }?>
                        <?php if (isset($_REQUEST['fpError'])){?>
                            <div class="row alert alert-error">
                                <p>Invalid Username or Email address.</p>
                            </div>
                        <?php }?>
                        <?php if (isset($_REQUEST['status'])){?>
                            <div class="row alert alert-success">
                                <p>Mail has been sent to your inbox, please check your e-mail.</p>
                            </div>
                        <?php }?>
                        <?php if (isset($_REQUEST['statusError'])){?>
                            <div class="row alert alert-error">
                                <p>Outgoing mail server was not configured.</p>
                            </div>
                        <?php }?>
					<div class="row">
						<div class="span6 username"><input type="text" id="username" name="username" placeholder="Username" value=""></div>
						<div class="span6 password"><input type="password" id="password" name="password" placeholder="Password" value=""></div>
					</div>
					<div class="row control-group signin-button pull-right">
						<div class="span12" id="forgotPassword"><a>Forgot Password ?</a>&nbsp;&nbsp;&nbsp;<button type="submit" class="btn btn-primary sbutton">Sign in</button></div>
					</div>
				</form>
				</div>
				<div class="span12 login-box hide" id="forgotPasswordDiv">
				<form class="form-horizontal login-form" action="forgotPassword.php" method="POST">
					 
					<div class="row">
						<h3 class="forgot-password">Forgot Password</h3>
					</div>
					<div class="row">
						<div class="span6 username"><input type="text" id="user_name" name="user_name" placeholder="Username"></div>
						<div class="span6 password"><input type="text" id="emailId" name="emailId"  placeholder="Email"></div>
					</div>
					<div class="row control-group signin-button">
						<div class="" id="backButton"><input type="button" class="btn btn-back sbutton pull-left" value="Back" style="color:white;"><input type="submit" class="btn btn-primary sbutton pull-right" value="Submit" name="retrievePassword"></div>
					</div>
				</form>
				</div>
				<div class="span12 login-more-info vte-user-login">
				<div class="row"><div class="span4 social" >
						<a class="social" target="_blank" href="@theracanncorp"><i class="icon-social-twitter icons"></i></a>
						<a class="social" target="_blank" href="https://www.linkedin.com/company-beta/10331273/"><i class="icon-social-linkedin icons"></i></a>
						<a class="social" target="_blank" href="https://www.facebook.com/TheraCannInternational/"><i class="icon-social-facebook icons"></i></a>
								</div><div class="span6 copy-right" ><small>TheraCann International Benchmark Corporation 2017. All rights reserved. www.theracanncorp.com</small></div></div>
				</div>
			</div></div>
      </div>
      
   </body>
  <!-- <script type="text/javascript">CsrfMagic.end();</script>-->
   <script>jQuery(document).ready(function () {
	jQuery("#forgotPassword a").click(function () {
		jQuery("#loginDiv").hide();
		jQuery("#forgotPasswordDiv").show();
	});
	jQuery("#backButton .btn-back").click(function () {
		jQuery("#loginDiv").show();
		jQuery("#forgotPasswordDiv").hide();
	});
	jQuery("input[name='retrievePassword']").click(function () {
		var username = jQuery('#user_name').val();
		var email = jQuery('#emailId').val();
		var email1 = email.replace(/^\s+/, '').replace(/\s+$/, '');
		var emailFilter = /^[^@]+@[^@.]+\.[^@]*\w\w$/;
		var illegalChars = /[\(\)\<\>\,\;\:\\\"\[\]]/;
		if (username == '') {
			alert('Please enter valid username');
			return false;
		} else if (!emailFilter.test(email1) || email == '') {
			alert('Please enater valid email address');
			return false;
		} else if (email.match(illegalChars)) {
			alert("The email address contains illegal characters.");
			return false;
		} else {
			return true;
		}
	});
});
</script>
</html><?php }} ?>