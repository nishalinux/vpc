<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 15:47:56
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/CreatePassword.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6262658555b76ee2c92fa43-10103697%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'a5adcdd79d8ecf497fc89555f5c04107a5ef5baa' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Users/CreatePassword.tpl',
      1 => 1533805035,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6262658555b76ee2c92fa43-10103697',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'LOGOURL' => 0,
    'TITLE' => 0,
    'LINK_EXPIRED' => 0,
    'TRACKURL' => 0,
    'USERNAME' => 0,
    'SHORTURL_ID' => 0,
    'SECRET_HASH' => 0,
    'MODULE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b76ee2c97a2b',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b76ee2c97a2b')) {function content_5b76ee2c97a2b($_smarty_tpl) {?><!--/* +********************************************************************************
 * The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
 * ******************************************************************************* */-->

<!DOCTYPE html>
<html>
    <head>
        <style type="text/css">
            body{
               font-family: Tahoma, "Trebuchet MS","Lucida Grande",Verdana !important;
				background: #F5FAEE !important;/*#f1f6e8;*/
				color : #555 !important;
				font-size: 85% !important;
				height: 98% !important;
            }
			hr{
				border: 1px solid #ddd;
				margin: 13px 0;
			}
            #container{
                min-width:280px;
                width:50%;
                margin-top:2%;
            }
            #content{
                padding:8px 20px;
                border:1px solid #ddd;
                background:#fff;
                border-radius:5px;
            }
            #footer{
                float:right;
            }
            #footer p{
                text-align:right;
                margin-right:20px;
            }
			.button-container a{
				text-decoration: none;
			}
			.button-container{
				float: right;
			}
			.button-container .btn{
				margin-left: 15px;
				min-width: 100px;
				font-weight: bold;
			}
			.logo{
				padding: 15px 0 ;
			}
        </style>
		<script language='JavaScript'>
			function checkPassword () {
				var password = document.getElementById('password').value;
				var confirmPassword = document.getElementById('confirmPassword').value;
				if(password == '' && confirmPassword == ''){
					alert('Please enter new Password');
					return false;
				} else if(password != confirmPassword) {
					alert('Password and Confirm Password should be same');
					return false;
				}else{
					return true;
				}
			}
		</script>
    </head>
    <body>
        <div id="container">
            <div class="logo">
				<img  src="<?php echo $_smarty_tpl->tpl_vars['LOGOURL']->value;?>
" alt="<?php echo $_smarty_tpl->tpl_vars['TITLE']->value;?>
" style="height: 4em;width: 12em;"><br><br><br>
			</div>
			<div>
                            <?php if ($_smarty_tpl->tpl_vars['LINK_EXPIRED']->value!='true'){?>   
				<div id="content">
					<span><b>Create Password</b></span>
					<hr>
					<div id="changePasswordBlock" align='left'>
						<form name="changePassword" id="changePassword" action="<?php echo $_smarty_tpl->tpl_vars['TRACKURL']->value;?>
" method="post" accept-charset="utf-8">
							<input type="hidden" name="username" value="<?php echo $_smarty_tpl->tpl_vars['USERNAME']->value;?>
">
                                                        <input type="hidden" name="shorturl_id" value="<?php echo $_smarty_tpl->tpl_vars['SHORTURL_ID']->value;?>
"> 
                                                        <input type="hidden" name="secret_hash" value="<?php echo $_smarty_tpl->tpl_vars['SECRET_HASH']->value;?>
"> 
							<table align='center'>
								<tr>
									<td><label class="control-label" for="password">Password</label></td>
									<td><input type="password" id="password" name="password" placeholder="Password"></td>
								</tr>
								<tr><td></td></tr>
								<tr>
									<td><label class="control-label" for="confirm_password"><?php echo vtranslate('LBL_CONFIRM_PASSWORD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
</label></td>
									<td><input type="password" id="confirmPassword" name="confirmPassword"  placeholder="Confirm Password"></td>
								</tr>
								<tr><td></td></tr>
								<tr>
									<td></td>
									<td><input type="submit" id="btn" value=<?php echo vtranslate('Submit',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 onclick="return checkPassword();"/></td>
								</tr>
							</table>
						</form>
					</div>
					<?php }else{ ?> 
                                            <div id="content"> 
                                                <?php echo vtranslate('LBL_PASSWORD_LINK_EXPIRED_OR_INVALID_PASSWORD',$_smarty_tpl->tpl_vars['MODULE']->value);?>
 
                                            </div>
                                         <?php }?>
				</div>
			</div>
            
        </div>
	</div>
</div>
</body>
</html>
<?php }} ?>