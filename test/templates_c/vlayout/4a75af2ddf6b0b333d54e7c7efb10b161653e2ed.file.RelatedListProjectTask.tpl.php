<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 21:33:08
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/RelatedListProjectTask.tpl" */ ?>
<?php /*%%SmartyHeaderCode:18316680305b734a94722c83-12146656%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '4a75af2ddf6b0b333d54e7c7efb10b161653e2ed' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/RelatedListProjectTask.tpl',
      1 => 1500377964,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '18316680305b734a94722c83-12146656',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RELATED_MODULE' => 0,
    'PAGING' => 0,
    'ORDER_BY' => 0,
    'SORT_ORDER' => 0,
    'RELATED_ENTIRES_COUNT' => 0,
    'TOTAL_ENTRIES' => 0,
    'RELATED_LIST_LINKS' => 0,
    'RELATED_LINK' => 0,
    'IS_SELECT_BUTTON' => 0,
    'RELATION_FIELD' => 0,
    'USER_MODEL' => 0,
    'FOLDERS_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b734a94793f0',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b734a94793f0')) {function content_5b734a94793f0($_smarty_tpl) {?>
<link rel='stylesheet' href='libraries/jstree/themes/default/style.min.css' /><style>.jstree-grid-wrapper {border:1px solid #ddd;}.jstree-grid-midwrapper  {background-color:white;}.jstree-grid-header-cell {text-align:left;font-size:11px;border:1px solid #ddd;padding:5px;white-space:nowrap;color:#333;background: #fff;background: -webkit-gradient(linear, left top, left bottom, from(#fff), to(#ededed));background: -moz-linear-gradient(top,  #fff,  #ededed);filter:  progid:DXImageTransform.Microsoft.gradient(startColorstr='#ffffff', endColorstr='#ededed');}.jstree-grid-separator {display:none;}.jstree-anchor,.jstree-grid-cell {text-overflow:ellipsis !important;white-space:nowrap !important;overflow:hidden !important;}</style><div class="relatedContainer"><?php $_smarty_tpl->tpl_vars['RELATED_MODULE_NAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['RELATED_MODULE']->value->get('name'), null, 0);?><input type="hidden" name="currentPageNum" value="<?php echo $_smarty_tpl->tpl_vars['PAGING']->value->getCurrentPage();?>
" /><input type="hidden" name="relatedModuleName" class="relatedModuleName" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_MODULE']->value->get('name');?>
" /><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['ORDER_BY']->value;?>
" id="orderBy"><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['SORT_ORDER']->value;?>
" id="sortOrder"><input type="hidden" value="<?php echo $_smarty_tpl->tpl_vars['RELATED_ENTIRES_COUNT']->value;?>
" id="noOfEntries"><input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['PAGING']->value->getPageLimit();?>
" id='pageLimit'><input type='hidden' value="<?php echo $_smarty_tpl->tpl_vars['TOTAL_ENTRIES']->value;?>
" id='totalCount'><div class="relatedHeader "><div class="btn-toolbar row-fluid"><div class="span6"><?php  $_smarty_tpl->tpl_vars['RELATED_LINK'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RELATED_LINK']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_LIST_LINKS']->value['LISTVIEWBASIC']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RELATED_LINK']->key => $_smarty_tpl->tpl_vars['RELATED_LINK']->value){
$_smarty_tpl->tpl_vars['RELATED_LINK']->_loop = true;
?><div class="btn-group"><?php ob_start();?><?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->get('_selectRelation');?>
<?php $_tmp1=ob_get_clean();?><?php $_smarty_tpl->tpl_vars['IS_SELECT_BUTTON'] = new Smarty_variable($_tmp1, null, 0);?><button type="button" class="btn addButton<?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value==true){?> selectRelation <?php }?> "<?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value==true){?> data-moduleName=<?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->get('_module')->get('name');?>
 <?php }?><?php if (($_smarty_tpl->tpl_vars['RELATED_LINK']->value->isPageLoadLink())){?><?php if ($_smarty_tpl->tpl_vars['RELATION_FIELD']->value){?> data-name="<?php echo $_smarty_tpl->tpl_vars['RELATION_FIELD']->value->getName();?>
" <?php }?>data-url="<?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->getUrl();?>
"<?php }?><?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value!=true){?>name="addButton"<?php }?>><?php if ($_smarty_tpl->tpl_vars['IS_SELECT_BUTTON']->value==false){?><i class="icon-plus icon-white"></i><?php }?>&nbsp;<strong><?php echo $_smarty_tpl->tpl_vars['RELATED_LINK']->value->getLabel();?>
</strong></button></div><?php } ?>&nbsp;</div><div class="span6"><div class="pull-right"></div></div></div></div><div class="contents-topscroll"><div class="topscroll-div">&nbsp;</div></div><div class="relatedContents contents-bottomscroll"><div class="bottomscroll-div"><?php $_smarty_tpl->tpl_vars['WIDTHTYPE'] = new Smarty_variable($_smarty_tpl->tpl_vars['USER_MODEL']->value->get('rowheight'), null, 0);?><div class='row-fluid'><div><input class="search-input form-control" placeholder='Search'></input></div><div id='folder_tree' class=''></div></div></div></div></div><!---------------Start CO Model----------------><div id="tokenPandaDocModal" class="modal fade" role="dialog" style='border-radius: 0px;'><div class="modal-dialog modal-lg"><!-- Modal content--><div class="modal-content modelContainer"><div class="modal-header contentsBackground"><button type="button" class="close" data-dismiss="modal">&times;</button><h3 class="modal-title" id='idTaskName'>Task</h3></div><div class="modal-body" id="idMBodyCoLinks"></div><div class="modal-footer quickCreateActions"><button type="button" class="btn btn-default" data-dismiss="modal">Close</button></div></div></div></div><!---------------End CO Model----------------><script src="https://code.jquery.com/jquery-1.8.0.js"   integrity="sha256-00Fh8tkPAe+EmVaHFpD+HovxWk7b97qwqVi7nLvjdgs="  crossorigin="anonymous"></script><script src='libraries/jquery/jquery.dataAttr.min.js?v=6.4.0'></script><script src='libraries/jstree/jstree.js?v=6.4.0'></script><script src='libraries/jstree/jstreegrid_new.js?v=6.4.0'></script><script>$j = jQuery.noConflict(true);$j(document).ready(function(){/* Search$j(".search-input").keyup(function() {var searchString = $j(this).val();$j('#folder_tree').jstree('search', searchString);}); */var taskjsondata = <?php echo $_smarty_tpl->tpl_vars['FOLDERS_DATA']->value;?>
;$j('#folder_tree').jstree({'plugins' : [   'types', 'state', 'grid','sort','themes','contextmenu','search','json_data' ],'core' : {'data' :  taskjsondata},"search" : { "show_only_matches" : false},'grid': {'columns': [{ 'width':'15%','header': "Project Task Name" },{ 'width':'10%','header': "Type",'value': "type" },{ 'width':'7%','header': "Assigned To",'value': "user" },{ 'width':'10%','header': "Budget",'value': "Budget" },{ 'width':'5%','header': "Task Hours",'value': "Task_Hours" },{ 'width':'5%','header': "Pro.H",'value': "Progress_in_Hours" },{ 'width':'5%','header': "Pro.A D",'value': "Progress_Allotted_Dollars" },{ 'width':'10%','header': "Start Date",'value': "startdate" },{ 'width':'10%','header': "End Date",'value': "enddate" },{ 'width':'5%','header': "Delay",'value': "delay" },{ 'width':'15%','header': "Tools",'value': "tools"  }],resizable:true}});var to = false;$j('.search-input').keyup(function () {if(to) { clearTimeout(to); }to = setTimeout(function () {var searchString = $j('.search-input').val();console.log(searchString);$j('#folder_tree').jstree(true).search(searchString);}, 250);});/* After jsTree has been loaded, set valid widths in percents *//* $j(".jstree-grid-header th:nth-child(1)").css( "width","30%" );*//* Anjaneya Date:20-06-2017*/});function co(crmid,task){var data = '<a href="index.php?module=Changes&view=Edit&taskid='+crmid+'&mode=Schedule">Schedule without changing deliverables</a></br>'+'<a href="index.php?module=Changes&view=Edit&taskid='+crmid+'&mode=Budget">Budget without changing schedule or deliverables</a></br>'+'<a href="index.php?module=Changes&view=Edit&taskid='+crmid+'&mode=Scope">Scope (changes both sched and budget)</a>';/*var task = jQuery('#create_co_'+crmid).dataAttr('task').value();*/$('#idTaskName').html('Chnage Order :: '+task);$('#idMBodyCoLinks').html(data);$('#tokenPandaDocModal').modal('show');}</script>
<?php }} ?>