<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:18:14
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/Reports.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17408402615b7339069fd240-37028221%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '70a5fd475aeb09d9bbdeca5805e9fe58bcf7aeda' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/ProcessFlow/Reports.tpl',
      1 => 1532585234,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17408402615b7339069fd240-37028221',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PROCESS_MASTER_LIST' => 0,
    'pmid' => 0,
    'pmname' => 0,
    'PROCESS_STATUS_DATA' => 0,
    'pstatus' => 0,
    'PROCESSFLOW_FIELDS' => 0,
    'k' => 0,
    'pffields' => 0,
    'CUSTOMFIELDS' => 0,
    'ck' => 0,
    'cl' => 0,
    'PROCESS_RECORDS_DATA' => 0,
    'headers_data' => 0,
    'trdata' => 0,
    'tddata' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b733906a4a16',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b733906a4a16')) {function content_5b733906a4a16($_smarty_tpl) {?><div class="listViewPageDiv" width="80%"><h2>PF Report</h2><form class="form-horizontal" autocomplete="off" name="frmSearch" method="post" action="index.php?module=ProcessFlow&view=Reports" enctype="multipart/form-data"><input type="hidden" name="module" value="ProcessFlow"><input type="hidden" name="view" value="Reports"><table class="table table-bordered" width="100%"><tbody><tr><td class="medium">Process Master</td><td class="medium"><select name="processmasterid" id="processmasterid"><option value=''>Select Process Master</option><?php  $_smarty_tpl->tpl_vars['pmname'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pmname']->_loop = false;
 $_smarty_tpl->tpl_vars['pmid'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROCESS_MASTER_LIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pmname']->key => $_smarty_tpl->tpl_vars['pmname']->value){
$_smarty_tpl->tpl_vars['pmname']->_loop = true;
 $_smarty_tpl->tpl_vars['pmid']->value = $_smarty_tpl->tpl_vars['pmname']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['pmid']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['pmid']->value==$_POST['processmasterid']){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['pmname']->value;?>
</option><?php } ?></select></td><td class="medium">Status</td><td class="medium"><select name="pf_process_status"><option value=''>All</option><?php  $_smarty_tpl->tpl_vars['pstatus'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pstatus']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PROCESS_STATUS_DATA']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pstatus']->key => $_smarty_tpl->tpl_vars['pstatus']->value){
$_smarty_tpl->tpl_vars['pstatus']->_loop = true;
?><option value="<?php echo $_smarty_tpl->tpl_vars['pstatus']->value;?>
" <?php if ($_smarty_tpl->tpl_vars['pstatus']->value==$_POST['pf_process_status']){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['pstatus']->value;?>
</option><?php } ?></select></td></tr><tr><td class="medium" width="10%" >Default Fields</td><td class="medium" width="50%" ><select name="fields[]" id="idFields" multiple  class="chzn-select" style="width:90%"><?php  $_smarty_tpl->tpl_vars['pffields'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['pffields']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROCESSFLOW_FIELDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['pffields']->key => $_smarty_tpl->tpl_vars['pffields']->value){
$_smarty_tpl->tpl_vars['pffields']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['pffields']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['k']->value,$_POST['fields'])){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['pffields']->value;?>
</option><?php } ?></select></td><td class="medium" width="10%" >Custom Form Fields </td><td class="medium" width="50%" ><select name="customformfields[]" id="customformfields" multiple  class="chzn-select" style="width:90%"><?php  $_smarty_tpl->tpl_vars['cl'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['cl']->_loop = false;
 $_smarty_tpl->tpl_vars['ck'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['CUSTOMFIELDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['cl']->key => $_smarty_tpl->tpl_vars['cl']->value){
$_smarty_tpl->tpl_vars['cl']->_loop = true;
 $_smarty_tpl->tpl_vars['ck']->value = $_smarty_tpl->tpl_vars['cl']->key;
?><option value="<?php echo $_smarty_tpl->tpl_vars['ck']->value;?>
" <?php if (in_array($_smarty_tpl->tpl_vars['ck']->value,$_POST['customformfields'])){?> selected <?php }?>><?php echo $_smarty_tpl->tpl_vars['cl']->value;?>
</option><?php } ?></select></td></tr><tr><td class="medium" width="10%" >Date Range</td><td class="medium" width="30%" ><input id="date_start" type="text" class="dateField" name="date_start" placeholder="dd-mm-yyyy" value="<?php echo $_POST['date_start'];?>
"> to <input id="date_end" type="text" class="dateField" name="date_end" placeholder="dd-mm-yyyy" value="<?php echo $_POST['date_end'];?>
"></td><td class="medium" width="10%" > </td><td class="medium" width="50%" > </td></tr><tr><td colspan="4" align='center' ><input class="btn btn-success" type="submit" name="submit" value="Search"></td></tr></tbody></table></form><br><table class="table table-bordered listViewEntriesTable" id="tblData"><thead><tr class="listViewHeaders"><th><?php echo '#';?>
</th><?php  $_smarty_tpl->tpl_vars['headers_data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['headers_data']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['PROCESS_RECORDS_DATA']->value['headers']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['headers_data']->key => $_smarty_tpl->tpl_vars['headers_data']->value){
$_smarty_tpl->tpl_vars['headers_data']->_loop = true;
?><th><?php echo $_smarty_tpl->tpl_vars['headers_data']->value;?>
</th><?php } ?></tr></thead><tbody><?php  $_smarty_tpl->tpl_vars['trdata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['trdata']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROCESS_RECORDS_DATA']->value['data']; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['trdata']->key => $_smarty_tpl->tpl_vars['trdata']->value){
$_smarty_tpl->tpl_vars['trdata']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['trdata']->key;
?><tr class="listViewEntries"  ><td class="medium"><?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
</td><?php  $_smarty_tpl->tpl_vars['tddata'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['tddata']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['trdata']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['tddata']->key => $_smarty_tpl->tpl_vars['tddata']->value){
$_smarty_tpl->tpl_vars['tddata']->_loop = true;
?><td nowrap="" class="medium"><?php echo $_smarty_tpl->tpl_vars['tddata']->value;?>
</td><?php } ?></tr><?php } ?></tbody></table></div></div></div></div><link href="https://cdn.datatables.net/1.10.19/css/jquery.dataTables.min.css" rel="stylesheet"></link><link href="https://cdn.datatables.net/buttons/1.5.2/css/buttons.dataTables.min.css" rel="stylesheet"></link><script type="text/javascript" src="https://cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script><script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/dataTables.buttons.min.js"></script><script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.flash.min.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script><script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script><script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.html5.min.js"></script><script type="text/javascript" src="https://cdn.datatables.net/buttons/1.5.2/js/buttons.print.min.js"></script><script>$(document).ready(function() {$('#customformfields').chosen();$('#tblData').DataTable( {dom: 'Bfrtip',buttons: ['copy', 'csv', 'excel', 'print',{extend: 'pdfHtml5',orientation: 'landscape',pageSize: 'LEGAL'}]});var dateFormat = "mm/dd/yy",from = $( "#date_start" ).datepicker({defaultDate: "+1w",changeMonth: true,numberOfMonths: 1}).on( "change", function() {to.datepicker( "option", "minDate", getDate( this ) );}),to = $( "#date_end" ).datepicker({defaultDate: "+1w",changeMonth: true,numberOfMonths: 1}).on( "change", function() {from.datepicker( "option", "maxDate", getDate( this ) );});function getDate( element ) {var date;try {date = $.datepicker.parseDate( dateFormat, element.value );} catch( error ) {date = null;}return date;}$("#processmasterid").change(function(){var processmasterid = $(this).val();var sentdata ={};sentdata.module ='ProcessFlow';sentdata.action = 'AjaxValidations';sentdata.mode = 'getCustomFormInfo';sentdata.processmasterid = processmasterid;AppConnector.request(sentdata).then(function(data){console.log(data.result.response);/* */var d = $.parseJSON(data.result.response);var htmls = '';$.each(d, function(i, item) {htmls += "<option value='"+i+"'>"+item+"</option>";});$('#customformfields').empty();$('#customformfields').append(htmls);$('#customformfields').trigger("liszt:updated");});});});</script>
 <?php }} ?>