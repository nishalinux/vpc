<?php /* Smarty version Smarty-3.1.7, created on 2018-08-24 17:18:32
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Documents/ListFolders.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14083162795b803de892d2c1-47100971%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3273c3ee6386565ea6d4e22fef599fe98c1230a8' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Documents/ListFolders.tpl',
      1 => 1518021040,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14083162795b803de892d2c1-47100971',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'FOLDERS_DATA' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b803de8979ef',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b803de8979ef')) {function content_5b803de8979ef($_smarty_tpl) {?>

 
<link rel='stylesheet' href='libraries/jstree/themes/default/style.min.css' /> 
 
 
<div id='folder_tree'  style='max-height:300px;overflow: scroll; float:left;overflow-y: scroll;'></div>		
<script type="text/javascript" src="libraries/jquery/jquery.min.js"></script><script src='libraries/jstree/jstree.js'></script><script>$j = jQuery.noConflict(true);$j(document).ready(function(){var jsondata = <?php echo $_smarty_tpl->tpl_vars['FOLDERS_DATA']->value;?>
;$j('#folder_tree').jstree({'plugins' : [ 'types','themes'],'themes' : {'theme' : "classic",'dots' : true,'icons' : true},'core' : {'data' :  jsondata},'types' : {'#' : {},'root' : {'icon' : 'jstree-file','valid_children' : ['default']},'default' : { 'valid_children' : ['default','file'] },'file' : { 'icon' : 'jstree-file' }}});});</script>
<?php }} ?>