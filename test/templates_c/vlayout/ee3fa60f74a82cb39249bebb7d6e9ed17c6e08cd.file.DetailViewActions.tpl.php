<?php /* Smarty version Smarty-3.1.7, created on 2018-08-22 16:07:28
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailViewActions.tpl" */ ?>
<?php /*%%SmartyHeaderCode:21298565415b73a53a2dd041-84816867%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'ee3fa60f74a82cb39249bebb7d6e9ed17c6e08cd' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OS2LoginHistory/DetailViewActions.tpl',
      1 => 1534922051,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '21298565415b73a53a2dd041-84816867',
  'function' => 
  array (
  ),
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b73a53a2f445',
  'variables' => 
  array (
    'ISSUES_LIST' => 0,
    'RECORD_ID' => 0,
    'SELECTED_MODULE_NAME' => 0,
  ),
  'has_nocache_code' => false,
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b73a53a2f445')) {function content_5b73a53a2f445($_smarty_tpl) {?>	<span class="span btn-toolbar pull-right">
			<div class="row-fluid">

		<div class="listViewActions pull-right">
		  <div class="pageNumbers alignTop ">
			<span>
			  <span style="padding-right:1px" class="pageNumbersText" id="pageNumbersText"><?php echo $_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['range']['start'];?>
 to <?php echo $_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['range']['end'];?>

			  <!--<span class="icon-refresh pull-right totalNumberOfRecords cursorPointer"></span>-->
			  </span>
			  <span class="totalNumberOfRecords" id="totalNumberOfRecords">
			   of <?php echo $_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['totalcount'];?>

			  </span>
			</span>
		  </div>
		  <div class="btn-group alignTop margin0px">
			<span class="pull-right">
			  <span class="btn-group">
				<button type="button"  id="listViewPreviousPageButton" <?php if ($_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['prevPageExists']){?><?php }else{ ?> disabled="disabled"<?php }?>class="btn">
				  <span class="icon-chevron-left">
				  </span>
				</button>
				<button data-toggle="dropdown" id="listViewPageJump" type="button" class="btn dropdown-toggle">
				  <i title="Page Jump" class="vtGlyph vticon-pageJump">
				  </i>
				</button>
				<ul id="listViewPageJumpDropDown" class="listViewBasicAction dropdown-menu">
				  <li>
					<span class="row-fluid">
					  <span class="span3 pushUpandDown2per">
						<span class="pull-right">
						  Page
						</span>
					  </span>
					  <span class="span4">
						<input type="text" value="1" class="listViewPagingInput" id="pageToJump">
					  </span>
					  <span class="span2 textAlignCenter pushUpandDown2per">
						of&nbsp;
					  </span>
					  <span id="totalPageCount" class="span2 pushUpandDown2per">
					  <?php echo $_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['pageCount'];?>

					  </span>
					</span>
				  </li>
				</ul>
				<button type="button" <?php if ($_smarty_tpl->tpl_vars['ISSUES_LIST']->value['pagination']['nextPageExists']){?><?php }else{ ?> disabled="disabled"<?php }?> id="listViewNextPageButton" class="btn">
				  <span class="icon-chevron-right">
				  </span>
				</button>
			  </span>
			</span>
		  </div>
		</div>
		<div class="clearfix">
		</div>
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RECORD_ID']->value;?>
" id="recordid">
		<input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_NAME']->value;?>
" id="submodule">
	    <input type="hidden" name="excludedIds" id="excludedIds">

	</div>
		</span>
		
		
		
<?php }} ?>