<?php /* Smarty version Smarty-3.1.7, created on 2018-08-18 06:13:38
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ChecklistItems/Widget.tpl" */ ?>
<?php /*%%SmartyHeaderCode:6732487805b77b9126adf72-82786170%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    'bdc2b27dab39d452c5fda2767e5a7c9aca24e1cb' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ChecklistItems/Widget.tpl',
      1 => 1507143463,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '6732487805b77b9126adf72-82786170',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'CHECKLISTS' => 0,
    'CHECKLIST' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b77b9126d570',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b77b9126d570')) {function content_5b77b9126d570($_smarty_tpl) {?>
<script type="text/javascript" src="layouts/vlayout/modules/ChecklistItems/resources/ChecklistItems.js" />
<link href="layouts/vlayout/modules/ChecklistItems/resources/ChecklistItems.css" type="text/css" />
<div class="container-fluid" id="vte-checklist">
    <ul class="nav nav-list">
    <?php  $_smarty_tpl->tpl_vars['CHECKLIST'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['CHECKLIST']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['CHECKLISTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['CHECKLIST']->key => $_smarty_tpl->tpl_vars['CHECKLIST']->value){
$_smarty_tpl->tpl_vars['CHECKLIST']->_loop = true;
?>
        <li>
            <a href="javascript:void(0);" class="checklist-name" data-record="<?php echo $_smarty_tpl->tpl_vars['CHECKLIST']->value['checklistid'];?>
">
                <?php echo $_smarty_tpl->tpl_vars['CHECKLIST']->value['checklistname'];?>

            </a>
        </li>
    <?php } ?>
    </ul>
</div>

<?php }} ?>