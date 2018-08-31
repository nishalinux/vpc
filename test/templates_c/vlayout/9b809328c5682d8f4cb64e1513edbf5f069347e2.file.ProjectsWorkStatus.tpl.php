<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 15:58:41
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/PCMReports/ProjectsWorkStatus.tpl" */ ?>
<?php /*%%SmartyHeaderCode:5035955105b76f0b1dc2516-51389367%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '9b809328c5682d8f4cb64e1513edbf5f069347e2' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/PCMReports/ProjectsWorkStatus.tpl',
      1 => 1499924091,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '5035955105b76f0b1dc2516-51389367',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PROJECTS' => 0,
    'k' => 0,
    'sel' => 0,
    'project' => 0,
    'fromdate' => 0,
    'todate' => 0,
    'PROJECT_DATA' => 0,
    'data' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b76f0b1e58cd',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b76f0b1e58cd')) {function content_5b76f0b1e58cd($_smarty_tpl) {?><?php if (!is_callable('smarty_function_math')) include '/var/www/html/BMLGDEMO65/libraries/Smarty/libs/plugins/function.math.php';
?><div class="listViewPageDiv" width="100%">
	 <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/css/bootstrap-datepicker.min.css" rel="stylesheet">
	 <link href="https://cdn.datatables.net/1.10.13/css/jquery.dataTables.min.css" rel="stylesheet">
	 <link href="https://cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css" rel="stylesheet">
	 <style>
		table.dataTable > thead > tr > th { padding: 3px; 	}
		table.dataTable > tbody > tr > td { padding: 5px; 	}
		table.dataTable > tfoot > tr > td { padding: 5px; 	}
		
		.idThNameRow { white-space: nowrap;	}
		.text-right{ text-align: right !important; }
		ul.breadcrumb_custom{ font-size:20px; }
		ul.breadcrumb_custom li.active{ font-size:18px; }
		ul.breadcrumb_custom li { display: inline; } 
		ul.breadcrumb_custom li+li:before { padding: 10px; color: black; content: ">>\00a0";	 }
		div.datepicker{ height:180px;}
		div.datepicker table td { text-align:center; }
	</style>
	<ul class="breadcrumb_custom"><li><a href="index.php?module=PCMReports&view=DashBoard" title="KPI Reports List">PCM Reports</a></li><li class="active">Projects Work Status</li></ul><form class="form-inline" method="post" action=""><input name="module" type="hidden" value="PCMReports" /><input name="view" type="hidden" value="DashBoard" /><input name="mode" type="hidden" value="ProjectsWorkStatus" /><table class=""><tbody><tr><td><label for="project">Project</label>&nbsp;<select id="idProject" name="project" class="form-control" ><option value="">All</option><?php  $_smarty_tpl->tpl_vars['project'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['project']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROJECTS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['project']->key => $_smarty_tpl->tpl_vars['project']->value){
$_smarty_tpl->tpl_vars['project']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['project']->key;
?><?php if (isset($_POST['branch'])){?><?php if ($_POST['branch']==$_smarty_tpl->tpl_vars['k']->value){?><?php $_smarty_tpl->tpl_vars["sel"] = new Smarty_variable("selected", null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars["sel"] = new Smarty_variable('', null, 0);?><?php }?><?php }?><option value="<?php echo $_smarty_tpl->tpl_vars['k']->value;?>
" <?php echo $_smarty_tpl->tpl_vars['sel']->value;?>
 > <?php echo $_smarty_tpl->tpl_vars['project']->value;?>
</option><?php } ?></select> &nbsp;</td><td><label for="branch">Assignee</label>&nbsp;<select id="idAssignee" name="assignee" class="form-control" ><option value="">All</option></select> &nbsp;</td><!--<td><label for="from_date">Start Date</label>&nbsp;<?php if (isset($_POST['from_date'])){?><?php $_smarty_tpl->tpl_vars["fromdate"] = new Smarty_variable(($_POST['from_date']), null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars["fromdate"] = new Smarty_variable('', null, 0);?><?php }?><input type="text" class="form-control" id="idFrom" name="from_date" value="<?php echo $_smarty_tpl->tpl_vars['fromdate']->value;?>
" autocomplete="off">&nbsp;</td><td><label for="from_date">End Date</label>&nbsp;<?php if (isset($_POST['from_date'])){?><?php $_smarty_tpl->tpl_vars["todate"] = new Smarty_variable(($_POST['to_date']), null, 0);?><?php }else{ ?><?php $_smarty_tpl->tpl_vars["todate"] = new Smarty_variable('', null, 0);?><?php }?><input type="text" class="form-control" id="idTo" name="to_date" value="<?php echo $_smarty_tpl->tpl_vars['todate']->value;?>
" autocomplete="off">&nbsp;</td> --><td><button type="submit" name="submit" value="submit" class="btn btn-success">Submit</button></td></tr><tbody></table></form></div><hr/><!--<input type="text" class="form-control" id="testing" name="" value="">&nbsp; --><table class="table table-bordered display dataTable" id="idReportDataTable"   ><thead><tr><th>#</th><th class="idThNameRow">Project Name</th><th>Project Tasks</th><th>Task Budget</th><th>Allotted Dollars</th><th>Total Task Hours</th><th>Worked Hours</th><th>Progress(%)</th><th>Start Date</th><th>End date</th><th>Action</th></tr></thead><tbody><?php if (count($_smarty_tpl->tpl_vars['PROJECT_DATA']->value)>0){?><?php  $_smarty_tpl->tpl_vars['data'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['data']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PROJECT_DATA']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['data']->key => $_smarty_tpl->tpl_vars['data']->value){
$_smarty_tpl->tpl_vars['data']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['data']->key;
?><tr><td><?php echo $_smarty_tpl->tpl_vars['k']->value+1;?>
</td><td class="text-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['projectname'];?>
</td><td class="text-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['task'];?>
</td><td class="text-right"><?php echo sprintf("%d",$_smarty_tpl->tpl_vars['data']->value['taskbudget']);?>
</td><td class="text-right"><?php echo sprintf("%d",$_smarty_tpl->tpl_vars['data']->value['allotteddollars']);?>
</td><td class="text-right"><?php echo sprintf("%.2f",$_smarty_tpl->tpl_vars['data']->value['taskhours']);?>
</td><td class="text-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['workedhours'];?>
</td><td class="text-right"> <?php if ($_smarty_tpl->tpl_vars['data']->value['taskhours']>0){?> <?php echo smarty_function_math(array('equation'=>"(x / y) * 100",'x'=>$_smarty_tpl->tpl_vars['data']->value['workedhours'],'y'=>$_smarty_tpl->tpl_vars['data']->value['taskhours'],'format'=>"%.2f"),$_smarty_tpl);?>
<?php }else{ ?> 0.00 <?php }?> </td><td class="text-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['startdate'];?>
</td><td class="text-right"><?php echo $_smarty_tpl->tpl_vars['data']->value['targetenddate'];?>
</td><td class="text-right"><a href="index.php?module=PCMReports&view=DashBoard&mode=ProjectDetails&projectid=<?php echo $_smarty_tpl->tpl_vars['data']->value['projectid'];?>
">Details</a></td></tr><?php } ?><?php }else{ ?><tr><td colspan="9" align="middle">No Data</td></tr><?php }?></tbody></table><table><tr><td><h4>Notes :</h4></td></tr><tr><td id="idNote" style="font-weight: bold;"></td></tr></table></div>
	
 
<script type="text/javascript" src="https://cdn.datatables.net/1.10.13/js/jquery.dataTables.min.js" ></script>
<script type="text/javascript" src="https://cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js" ></script>
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js" ></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js" ></script>
<script type="text/javascript" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js" ></script>
<script type="text/javascript" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js" ></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.6.4/js/bootstrap-datepicker.js" ></script>

<script>
$(document).ready(function() {
	getAssignee();
	 /* on chnage projects list */
	$('#idProject').on('change', function() {
		getAssignee(this.value);
	});

	 
	 
	var nowTemp = new Date();
	var now = new Date(nowTemp.getFullYear(), nowTemp.getMonth(), nowTemp.getDate(), 0, 0, 0, 0);
	 
	var checkin = jQuery('#idFrom').datepicker({
	  format: 'dd-mm-yyyy',
	  onRender: function(date) {
		return date.valueOf() < now.valueOf() ? 'disabled' : '';
	  }
	}).on('changeDate', function(ev) {
	  if (ev.date.valueOf() > checkout.date.valueOf()) {
		var newDate = new Date(ev.date)
		newDate.setDate(newDate.getDate() + 1);
		checkout.setValue(newDate);
	  }
	  checkin.hide();
	  jQuery('#idTo')[0].focus();
	}).data('datepicker');
	var checkout = jQuery('#idTo').datepicker({
	  format: 'dd-mm-yyyy',
	  onRender: function(date) {
		return date.valueOf() <= checkin.date.valueOf() ? 'disabled' : '';
	  }
	}).on('changeDate', function(ev) {
	  checkout.hide();
	}).data('datepicker');
 
	//data table
    $('#idReportDataTable').DataTable( { "sDom": 'Rfrtlip' });
	
	

});

</script>

<script>
function addCommas(x)
    {
       //var x=12345652457.557;
		x=x.toString();
		var afterPoint = '';
		if(x.indexOf('.') > 0)
		   afterPoint = x.substring(x.indexOf('.'),x.length);
		x = Math.floor(x);
		x=x.toString();
		var lastThree = x.substring(x.length-3);
		var otherNumbers = x.substring(0,x.length-3);
		if(otherNumbers != '')
			lastThree = ',' + lastThree;
		var res = otherNumbers.replace(/\B(?=(\d{2})+(?!\d))/g, ",") + lastThree + afterPoint;
       return res;
    }
	
function removeCommas(x)
	{
		var res = x.replace(/,/g, '');
		return res;
	}
 
function getAssignee(id = ''){ 
	
	var params = {};
	params['module'] = 'PCMReports';     
	params['action'] = 'IndexAjax';
	params['mode'] = 'getAssigneeFromProjectId';
	params['projectid'] = id;
	AppConnector.request(params).then(
		function(data) { 
			if (data.success)
			{ 
				$('#idAssignee').html(data.result.message);
			}			},
		function(error) {

		}
	);
}
	
</script>
 
 
<?php }} ?>