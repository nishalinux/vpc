<?php /* Smarty version Smarty-3.1.7, created on 2018-08-24 19:44:36
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/KanbanView/Settings.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14743502505b80602499da83-73481619%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '2a9eb393792e3f869b366fd1b6e4f5e1cbdcc166' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/KanbanView/Settings.tpl',
      1 => 1507911071,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14743502505b80602499da83-73481619',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'ENABLE' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b8060249d472',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b8060249d472')) {function content_5b8060249d472($_smarty_tpl) {?>
<div class="container-fluid">
    <div class="widget_header row-fluid">
        <h3><?php echo vtranslate('KanbanView','KanbanView');?>
</h3>
    </div>
    <hr>
    <div class="clearfix"></div>
    <div class="summaryWidgetContainer">
        <div class="row-fluid">
            <span class="span2"><h4><?php echo vtranslate('LBL_ENABLE_MODULE','KanbanView');?>
</h4></span>
            <input type="checkbox" name="enable_module" id="enable_module" value="1" <?php if ($_smarty_tpl->tpl_vars['ENABLE']->value=='1'){?>checked="" <?php }?>/>
        </div>
    </div>
</div><?php }} ?>