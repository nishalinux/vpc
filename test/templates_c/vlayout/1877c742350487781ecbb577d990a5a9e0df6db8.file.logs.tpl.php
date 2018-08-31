<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 04:19:30
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OSSMailScanner/logs.tpl" */ ?>
<?php /*%%SmartyHeaderCode:1535083505b764cd2e147e5-39547175%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '1877c742350487781ecbb577d990a5a9e0df6db8' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Settings/OSSMailScanner/logs.tpl',
      1 => 1472497498,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '1535083505b764cd2e147e5-39547175',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'MODULE' => 0,
    'STOP_BUTTON_STATUS' => 0,
    'WIDGET_CFG' => 0,
    'QUALIFIED_MODULE' => 0,
    'HISTORYACTIONLIST_NUM' => 0,
    'i' => 0,
    'HISTORYACTIONLIST' => 0,
    'item' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b764cd2ece99',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b764cd2ece99')) {function content_5b764cd2ece99($_smarty_tpl) {?>
<script type="text/javascript" src="libraries/bootstrap/js/bootstrap-tab.js"></script>
<style>
    .table tbody tr.error > td {
        background-color: #f2dede;
    }
    .table th, .table td {
        padding: 3px;
    }
</style>
    <div class='editViewContainer ' id="tab_cron">
		<div class="widget_header row">
		<div class="col-xs-12">
			<?php echo $_smarty_tpl->getSubTemplate (vtemplate_path('BreadCrumbs.tpl',$_smarty_tpl->tpl_vars['MODULE']->value), $_smarty_tpl->cache_id, $_smarty_tpl->compile_id, null, null, array(), 0);?>

		</div>
	</div>
        <table class="">
            <tr>
                <td><button class="btn btn-success" id="run_cron" type="button" <?php if ($_smarty_tpl->tpl_vars['STOP_BUTTON_STATUS']->value!='false'){?>disabled<?php }?>><?php echo vtranslate('RunCron','OSSMailScanner');?>
</button></td>
            </tr>
            </table><br />   
		<div class="row col-xs-12">
			<div  class="row col-sm-10 col-md-8 col-lg-7 marginBottom10px" >
				<div class="row col-sm-4"><?php echo vtranslate('email_to_notify','OSSMailScanner');?>
: &nbsp;</div>
				<div class="col-sm-7"><input type="text" class="form-control" title="<?php echo vtranslate('email_to_notify','OSSMailScanner');?>
" name="email_to_notify" value="<?php echo $_smarty_tpl->tpl_vars['WIDGET_CFG']->value['cron']['email'];?>
" /></div>
			</div>
			<div class='row col-sm-10 col-md-8 col-lg-7 marginBottom10px'>
				<div class="row col-sm-4"><?php echo vtranslate('time_to_notify','OSSMailScanner');?>
: &nbsp;</div>
				<div class="col-sm-7"><input type="text" name="time_to_notify" title="<?php echo vtranslate('time_to_notify','OSSMailScanner');?>
" class="form-control" value="<?php echo $_smarty_tpl->tpl_vars['WIDGET_CFG']->value['cron']['time'];?>
" /></div>
			</div>
		</div>
		<div class="pull-right">
		<select class="col-md-1 form-control" name="page_num" title="<?php echo vtranslate('LBL_PAGE_NUMBER',$_smarty_tpl->tpl_vars['QUALIFIED_MODULE']->value);?>
">
						<?php if ($_smarty_tpl->tpl_vars['HISTORYACTIONLIST_NUM']->value==0){?><option vlaue="1">1</option><?php }?>
			<?php $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable;$_smarty_tpl->tpl_vars['i']->step = 1;$_smarty_tpl->tpl_vars['i']->total = (int)ceil(($_smarty_tpl->tpl_vars['i']->step > 0 ? $_smarty_tpl->tpl_vars['HISTORYACTIONLIST_NUM']->value+1 - (1) : 1-($_smarty_tpl->tpl_vars['HISTORYACTIONLIST_NUM']->value)+1)/abs($_smarty_tpl->tpl_vars['i']->step));
if ($_smarty_tpl->tpl_vars['i']->total > 0){
for ($_smarty_tpl->tpl_vars['i']->value = 1, $_smarty_tpl->tpl_vars['i']->iteration = 1;$_smarty_tpl->tpl_vars['i']->iteration <= $_smarty_tpl->tpl_vars['i']->total;$_smarty_tpl->tpl_vars['i']->value += $_smarty_tpl->tpl_vars['i']->step, $_smarty_tpl->tpl_vars['i']->iteration++){
$_smarty_tpl->tpl_vars['i']->first = $_smarty_tpl->tpl_vars['i']->iteration == 1;$_smarty_tpl->tpl_vars['i']->last = $_smarty_tpl->tpl_vars['i']->iteration == $_smarty_tpl->tpl_vars['i']->total;?>
			<option vlaue="<?php echo $_smarty_tpl->tpl_vars['i']->value;?>
"><?php echo $_smarty_tpl->tpl_vars['i']->value;?>
</option>
			<?php }} ?>
		</select>
		</div>
			<table class="table tableRWD table-bordered log-list">
				<thead>
					<tr class="listViewHeaders">
						<th><?php echo vtranslate('No','OSSMailScanner');?>
.</th>
						<th><?php echo vtranslate('startTime','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('endTime','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('status','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('who','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('count','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('stop_user','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('Action','OSSMailScanner');?>
</th>
						<th><?php echo vtranslate('Desc','OSSMailScanner');?>
</th>
						<th></th>
					</tr>
				</thead>
				<?php  $_smarty_tpl->tpl_vars['item'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['item']->_loop = false;
 $_smarty_tpl->tpl_vars['key'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['HISTORYACTIONLIST']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['item']->key => $_smarty_tpl->tpl_vars['item']->value){
$_smarty_tpl->tpl_vars['item']->_loop = true;
 $_smarty_tpl->tpl_vars['key']->value = $_smarty_tpl->tpl_vars['item']->key;
?>
					<tr>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['id'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['start_time'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['end_time'];?>
</td>
						<td><?php echo vtranslate($_smarty_tpl->tpl_vars['item']->value['status'],'OSSMailScanner');?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['user'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['count'];?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['stop_user'];?>
</td>
						<td><?php echo vtranslate($_smarty_tpl->tpl_vars['item']->value['action'],'OSSMailScanner');?>
</td>
						<td><?php echo $_smarty_tpl->tpl_vars['item']->value['info'];?>
</td>
						<td>
							<?php if ($_smarty_tpl->tpl_vars['item']->value['status']=='In progress'){?>
							<button type="button" class="btn btn-danger" id="manula_stop_cron" <?php if ($_smarty_tpl->tpl_vars['STOP_BUTTON_STATUS']->value=='false'){?>disabled<?php }?>><?php echo vtranslate('StopCron','OSSMailScanner');?>
</button>
							<?php }?>
						</td>
					</tr>
				<?php } ?>
			</table>
		
    </div>
</div>

<script>
    jQuery(function() {
        jQuery('select[name="page_num"]').on('change', function(){
            reloadLogTable(jQuery(this).val() - 1);
        });

        jQuery('[name="time_to_notify"]').on('blur', function() {
            var value = jQuery(this).val();
            if (!!number_validate(value)) {
                saveWidgetConfig('time', jQuery(this).val(), 'cron');
            } else {
                var params = {
                    text: app.vtranslate('JS_time_error'),
                    type: 'error',
                    animation: 'show'
                };
                                        
                Vtiger_Helper_Js.showPnotify(params);
            }
        });
        jQuery('[name="email_to_notify"]').on('blur', function() {
            var value = jQuery(this).val();
            if (!!email_validate(value)) {
                saveWidgetConfig('email', value, 'cron');
            }
            else {
                var params = {
                    text: app.vtranslate('JS_mail_error'),
                    type: 'error',
                    animation: 'show'
                };
                                        
                Vtiger_Helper_Js.showPnotify(params);
            }
        });
		jQuery('#run_cron').on('click', function(){
			var paramsInfo = {
				text: app.vtranslate('start_cron'),
				type: 'info',
				animation: 'show'
			};
			Vtiger_Helper_Js.showPnotify(paramsInfo);
			jQuery('#run_cron').attr('disabled', true);
			var ajaxParams = {};
			ajaxParams.data = { module: 'OSSMailScanner', action: "cron" },
			ajaxParams.async = true;
			AppConnector.request(ajaxParams).then(
				function(data) {
					var params = {};
					if(data.success && data.result == 'ok'){
						params = {
							text: app.vtranslate('end_cron_ok'),
							type: 'info',
							animation: 'show'
						};
					} else{
						params = {
							title : app.vtranslate('end_cron_error'),
							text: data.result,
							type: 'error',
							animation: 'show'
						};
					}
					Vtiger_Helper_Js.showPnotify(params);
					jQuery('#run_cron').attr('disabled', false);
					reloadLogTable(jQuery('[name="page_num"]').val() - 1);
				},
				function(data, err) {

				}
			);	
			});
			jQuery('#manula_stop_cron').on('click', function(){
                     var ajaxParams = {};
                     ajaxParams.data = { module: 'OSSMailScanner', action: "restartCron" },
                     ajaxParams.async = true;
                    
			AppConnector.request(ajaxParams).then(
				function(data) {
                                    if(data.success){
                                        var params = {
                                                text: data.result.data,
                                                type: 'info',
                                                animation: 'show'
                                        }
                                        
                                        Vtiger_Helper_Js.showPnotify(params);
                                        jQuery('#run_cron').attr('disabled', false);
                                    }
				},
				function(data, err) {

				}
			);
reloadLogTable(jQuery('[name="page_num"]').val() - 1);            
                })    				
    });
    function isEmpty(val){
        if (!!val) {
            return val;
        }
        
        return '';
    }
    function number_validate(value){
      var valid = !/^\s*$/.test(value) && !isNaN(value);
        return valid;
    }
    
    function reloadLogTable(page){
                var limit = 30,
                ajaxParams = { module: 'OSSMailScanner', action: "GetLog", start_number: page * limit};

                AppConnector.request(ajaxParams).then(
                        function(data) {
                            if (data.success) {
                                var tab = jQuery('table.log-list');
								tab.find('tbody tr').remove();
                                for (i = 0; i < data.result.length; i++) {
                                    
                                    var html = '<tr>' 
                                            + '<td>' + isEmpty(data.result[i]['id']) + '</td>' 
                                            + '<td>' + isEmpty(data.result[i]['start_time']) + '</td>' 
                                            + '<td>' + isEmpty(data.result[i]['end_time']) + '</td>' 
                                            + '<td>' + isEmpty(app.vtranslate(data.result[i]['status'])) + '</td>' 
                                            + '<td>' + isEmpty(data.result[i]['user']) + '</td>' 
                                            + '<td>' + isEmpty(data.result[i]['count']) + '</td>' 
                                            + '<td>' + isEmpty(data.result[i]['stop_user']) + '</td>' 
											+ '<td>' + isEmpty(data.result[i]['action']) + '</td>' 
											+ '<td>' + isEmpty(data.result[i]['info']) + '</td>' 
                                            + '<td>';
                                    
                                    if (data.result[i]['status'] == 'In progress') {
                                        html += '<button type="button" class="btn btn-danger" id="manula_stop_cron"'; 
                                        
                                        if(!<?php echo $_smarty_tpl->tpl_vars['STOP_BUTTON_STATUS']->value;?>
){
                                            html += 'disabled';
                                        }
                                        
                                        html += '>' + app.vtranslate('JS_StopCron') + '</button></td>';
                                    }
                                    
                                    html += '</tr>';
                                    
                                    tab.append(html);
                                }
                            }
                        },
                        function(data, err) {

                        }
                );
    }
    function email_validate(src){
      var regex = /^[a-zA-Z0-9._-]+@([a-zA-Z0-9.-]+\.)+[a-zA-Z0-9.-]{2,63}$/;
      return regex.test(src);
    }
    function saveWidgetConfig(name, value, type) {
        var params = {
            'module': 'OSSMailScanner',
            'action': "SaveWidgetConfig",
            'conf_type': type,
            'name': name,
            'value': value
        }
        AppConnector.request(params).then(
			function(data) {
				var response = data['result'];
				if (response['success']) {
					var params = {
						text: response['data'],
						type: 'info',
						animation: 'show'
					};
					Vtiger_Helper_Js.showPnotify(params);
				} else {
					var params = {
						text: response['data'],
						animation: 'show'
					};
					Vtiger_Helper_Js.showPnotify(params);
				}
			},
			function(data, err) {

			}
        );
    }
</script>

<?php }} ?>