<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 18:34:16
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtWidgetDZinerSettings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:2041669385b7320a8067121-14310559%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '8f3c0ee615078cd257cf7aeba110284c70b44e0f' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/vtDZiner/vtWidgetDZinerSettings.tpl',
      1 => 1517809141,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '2041669385b7320a8067121-14310559',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'SELECTED_MODULE_MODEL' => 0,
    'MODULEWIDGETS' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7320a807f57',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7320a807f57')) {function content_5b7320a807f57($_smarty_tpl) {?><div class="addWidgetForm hide">
	<div>
		<table class="table">
			<tr>
				<td id="vtWidgetFormTitle">
				</td>
				<td>
				<span class="pull-right"><button class="btn btn-success" onclick="saveWidget();" ><strong>Save</strong></button><a onclick="showWidgetListView();" type="reset" class="cancelLink">Cancel</a></span>
				</td>
			</tr>
		</table>
	</div>
	<hr/>
	<form class="widgetProperties">
		<table class="table table-bordered blockContainer showInlineTable equalSplit">
		  <thead>
			<tr>
			  <th colspan="4" class="blockHeader">
				Widget Information
			  </th>
			</tr>
		  </thead>
		  <tbody>
			<tr>
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Widget Name
				</label>
			  </td>
			  <td class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="hidden" name="linkid">
					<input type="hidden" name="tabid" value="<?php echo $_smarty_tpl->tpl_vars['SELECTED_MODULE_MODEL']->value->id;?>
">
					<input type="hidden" name="sequence">
					<input type="hidden" name="vtwidgettableid">
					<input type="hidden" name="vtwidgetaction" value="INSERT">
					<input type="text" name="linklabel">
				  </span>
				</div>
			  </td>
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Link type
				</label>
			  </td>
			  <td class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
				  <select name="linktype" id="linktype" class="" onchange="showLinkDescription(this);">
				
				  </select>
				  </span>
				</div>
			  </td>
			</tr>
			<tr>
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  Link Icon
				</label>
			  </td>
			  <td class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="text" name="linkicon" class="input-large validate[custom[url]]" id="Settings:Webforms_editView_fieldName_returnurl">
				  </span>
				</div>
			  </td>
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  Link Description
				</label>
			  </td>
			  <td class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
						<textarea name ="linkdescription" disabled></textarea>
				  </span>
				</div>
			  </td>
			</tr>
			<tr>
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Link Method				  
				</label>
			  </td>
			  <td colspan="3" class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="radio" name="linkmethod" value="url" onclick="toggleWidgetLinkMode('url');" checked>&nbsp;<span class="alignMiddle">URL</span>&nbsp;
					<input type="radio" name="linkmethod" value="handler" onclick="toggleWidgetLinkMode('handler');" >&nbsp;<span class="alignMiddle">Handler</span>
				  </span>
				</div>
			  </td>
			</tr>
			<tr class="modeURLAttributes">
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Link Url
				</label>
			  </td>
			  <td colspan="3" class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="text" name="linkurl" class="span11 " id="Settings:Webforms_editView_fieldName_returnurl">
				  </span>
				</div>
			  </td>
			</tr>
			<tr class="modeURLAttributes">
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  Url Setup Tips
				</label>
			  </td>
			  <td colspan="3" class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
						<div id="helpinfoarea" ></div>
				  </span>
				</div>
			  </td>
			</tr>
			<tr class="modeHandlerAttributes hide">
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Handler path
				</label>
			  </td>
			  <td colspan="3" class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="text" name="handler_path" class="span11 " id="Settings:Webforms_editView_fieldName_description">
				  </span>
				</div>
			  </td>
			</tr>
			<tr class="modeHandlerAttributes hide">
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Handler class
				</label>
			  </td>
			  <td class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="text" name="handler_class" class="input-large validate[custom[url]]" id="Settings:Webforms_editView_fieldName_returnurl">
				  </span>
				</div>
			  </td>
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  <span class="redColor">
					*
				  </span>
				  Handler
				</label>
			  </td>
			  <td class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
					<input type="text" name="handler" class="input-large validate[custom[url]]" id="Settings:Webforms_editView_fieldName_returnurl">
				  </span>
				</div>
			  </td>
			</tr>
			<tr class="modeHandlerAttributes hide">
			  <td class="fieldLabel medium">
				<label class="muted pull-right marginRight10px">
				  Handler Setup Tips
				</label>
			  </td>
			  <td colspan="3" class="fieldValue medium">
				<div class="row-fluid">
				  <span class="span10">
						<textarea disabled>Using a handler type method requires three mandatory parameters</textarea>
				  </span>
				</div>
			  </td>
			</tr>
		  </tbody>
		</table>
	</form>
</div>
<div class="WidgetList">
	<div class="row-fluid">
	  <span class="span8 btn-toolbar">
		<button onclick="addWidget();" class="btn addButton">
		  <i class="icon-plus">
		  </i>
		  &nbsp;
		  <strong>
			Add Widget
		  </strong>
		</button>
	  </span>
	  <span class="span4 btn-toolbar">
		<div class="listViewActions pull-right">
		  <div class="pageNumbers alignTop ">
			<span>
			  <span style="padding-right:1px" class="pageNumbersText" id="pageNumbersText"><?php echo $_smarty_tpl->tpl_vars['MODULEWIDGETS']->value['pagination']['range']['start'];?>
 
			  to <?php echo $_smarty_tpl->tpl_vars['MODULEWIDGETS']->value['pagination']['range']['end'];?>

			  </span>
			  <span class="totalNumberOfRecords" id="totalNumberOfRecords">
			   of <?php echo $_smarty_tpl->tpl_vars['MODULEWIDGETS']->value['pagination']['totalcount'];?>

			  </span>
			</span>
		  </div>
		  <div class="btn-group alignTop margin0px">
			<span class="pull-right">
			  <span class="btn-group">
				<button type="button"  id="listViewvtdzinerPreviousPageButton" <?php if ($_smarty_tpl->tpl_vars['MODULEWIDGETS']->value['pagination']['prevPageExists']){?><?php }else{ ?> disabled="disabled"<?php }?>class="btn">
				  <span class="icon-chevron-left">
				  </span>
				</button>
				<button data-toggle="dropdown" id="listViewvtdzinerPageJump" type="button" class="btn dropdown-toggle">
				  <i title="Page Jump" class="vtGlyph vticon-pageJump">
				  </i>
				</button>
				<ul id="listViewvtdzinerPageJumpDropDown" class="listViewBasicAction dropdown-menu">
				  <li>
					<span class="row-fluid">
					  <span class="span3 pushUpandDown2per">
						<span class="pull-right">
						  Page
						</span>
					  </span>
					  <span class="span4">
						<input type="text" value="1" class="listViewPagingInput" id="pageToJumpvtdziner">
					  </span>
					  <span class="span2 textAlignCenter pushUpandDown2per">
						of&nbsp;
					  </span>
					  <span id="totalPageCount" class="span2 pushUpandDown2per">
					  <?php echo $_smarty_tpl->tpl_vars['MODULEWIDGETS']->value['pagination']['pageCount'];?>

					  </span>
					</span>
				  </li>
				</ul>
				<button type="button" <?php if ($_smarty_tpl->tpl_vars['MODULEWIDGETS']->value['pagination']['nextPageExists']){?><?php }else{ ?> disabled="disabled"<?php }?> id="listViewvtdzinerNextPageButton" class="btn">
				  <span class="icon-chevron-right">
				  </span>
				</button>
			  </span>
			</span>
		  </div>
		</div>
		<div class="clearfix">
		</div>
		<input type="hidden" value="" id="recordsCount">
		<input type="hidden" name="selectedIds" id="selectedIds">
		<input type="hidden" name="excludedIds" id="excludedIds">
	  </span>
	</div>
	<hr/>
	<table class="table widgetlist">
		<thead>
			<tr>
				<th>
					Widget Label
				</th>
				<th>
					Widget Type
				</th>
				<th>
					Widget Action
				</th>
				<th>
				<span class="pull-right">
					Actions
				</th>
			</tr>
		</thead>
		<tbody>
		</tbody>
	</table>
</div><?php }} ?>