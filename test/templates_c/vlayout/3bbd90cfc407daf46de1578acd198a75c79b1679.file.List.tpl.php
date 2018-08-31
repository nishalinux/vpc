<?php /* Smarty version Smarty-3.1.7, created on 2018-08-21 12:26:42
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/VGSGanttCharts/List.tpl" */ ?>
<?php /*%%SmartyHeaderCode:14743460815b7c0502365b52-67734379%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '3bbd90cfc407daf46de1578acd198a75c79b1679' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/VGSGanttCharts/List.tpl',
      1 => 1467869304,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '14743460815b7c0502365b52-67734379',
  'function' => 
  array (
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7c050237c67',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7c050237c67')) {function content_5b7c050237c67($_smarty_tpl) {?><script>
    
        jQuery(document).ready(function() {
            jQuery('#leftPanel').addClass('hide');
            jQuery('#rightPanel').removeClass('span10').addClass('span12');
            jQuery('#tButtonImage').removeClass('icon-chevron-left').addClass('icon-chevron-right');
        });

     
</script> 
<script type="text/javascript" src="layouts/vlayout/modules/VGSGanttCharts/resources/VGSGanttCharts.js"></script>
<div style="width: 80%;margin: auto;margin-top: 2em;padding: 2em;">
    <h3 style="padding-bottom: 1em;">VGS Gantt Charts Module</h3>
    <p>This an extension module. Please go to Project Module or Tasks Module and click on the view gantt button</p>
    <img src="layouts/vlayout/modules/VGSGanttCharts/gantt.png" style="margin-top: 2%;width: 50%;margin-bottom: 2%">
    <p><b>Important Notice:</b> All you taks must have a start and date defined. Otherwise you wont see the gantt chart</p>
    
</div>
    <div style="height: 250px"></div>
    <div><a href="index.php?module=VGSGanttCharts&view=VGSLicenseSettings&parent=Settings" >Module License</a></div>



<?php }} ?>