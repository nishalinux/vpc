<?php /* Smarty version Smarty-3.1.7, created on 2018-08-17 05:56:48
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/POProductsDetails.tpl" */ ?>
<?php /*%%SmartyHeaderCode:20603994115b7663a0d2ad03-60801292%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '5e8e4f868c8fec4728b27c09fa29c502bcc0b742' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/Project/POProductsDetails.tpl',
      1 => 1513060231,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '20603994115b7663a0d2ad03-60801292',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'PRODUCTDETAILS' => 0,
    'i' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7663a0d7156',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7663a0d7156')) {function content_5b7663a0d7156($_smarty_tpl) {?>	<link rel="stylesheet" type="text/css" href="libraries/jquery.dataTables.css">
	
	<script type="text/javascript" language="javascript" src="libraries/jquery.dataTables.js">
	</script>
	</script>
	<script type="text/javascript" language="javascript" class="init">
	
$(document).ready(function() {
	$('#products').DataTable( {
		"pagingType": "full_numbers"
	});
	//Allocate Qty Edit Purpose
	$("#products").on('click','.quantity',function(e){
		var target =$(e.currentTarget).closest('td');
		target.find('.quantityval').addClass('hide');
		target.find('.quantity').addClass('hide');
		target.find('.quantityedit').removeClass('hide');
	});
	$("#products").on('click','.qtysave',function(e){
		var projectid=$("input[name='projectid']").val();
		var target =$(e.currentTarget).closest('tr');
		var productid = target.find("input[name='productid']").val();
		var productqty = target.find("input[name='productqty']").val();
		var qty = target.find("input[name='allocatedtqty']").val();
		var price = target.find("input[name='totalprice']").val();
		if(parseInt(productqty) < parseInt(qty)){
			bootbox.alert("Products Quantity in Stock is "+productqty+".So,Please give proper qty.");
			return false;
		}
		var params = {};
		params['projectid'] = projectid;
		params['productid'] = productid;
		params['qty'] = qty;
		params['module'] = "Project";
		params['action'] = "ProductQtyUpdate";
		
		AppConnector.request(params).then(
			function(data) {
				if(data.success == true) {
					target.find('.quantityval').html(qty);
					var totalprice = (qty*price).toFixed(2);
					target.find('.remainingqty').html(qty);
					target.find('.totalpricedisplay').html(totalprice);
					target.find('.quantityval').removeClass('hide');
					target.find('.quantityedit').addClass('hide');
				}
			}
		);
		
	});
	$("#products").on('click','.qtycancel',function(e){
		var target =$(e.currentTarget).closest('tr');
		target.find('.quantityval').removeClass('hide');
		target.find('.quantityedit').addClass('hide');
		target.find('.quantity').removeClass('hide');
	});
	//Used Qty Purpose
	$("#products").on('click','.usedqty',function(e){
		var target =$(e.currentTarget).closest('td');
		target.find('.usedqtyval').addClass('hide');
		target.find('.usedqty').addClass('hide');
		target.find('.usedqtyedit').removeClass('hide');
	});
	$("#products").on('click','.dtsave',function(e){
		var projectid=$("input[name='projectid']").val();
		var target =$(e.currentTarget).closest('tr');
		var productid = target.find("input[name='productid']").val();
		var productqty = target.find(".quantityval").text();
		var qty = target.find("input[name='usedqtyallow']").val();
		if(!productqty.length){
			bootbox.alert("Please allocate some products qty first.");
			return false;
		}

		var remainingqty = productqty-qty;
		if(parseInt(productqty) < parseInt(qty)){
			bootbox.alert("Products Quantity allocated for this project is "+productqty+".So,Please give proper qty.");
			return false;
		}
		var params = {};
		params['projectid'] = projectid;
		params['productid'] = productid;
		params['qty'] = qty;
		params['module'] = "Project";
		params['action'] = "ProductUsedQtyUpdate";
		
		AppConnector.request(params).then(
			function(data) {
				if(data.success == true) {
					target.find('.usedqtyval').html(qty);
					target.find('.remainingqty').html(remainingqty);
					target.find('.usedqtyval').removeClass('hide');
					target.find('.usedqtyedit').addClass('hide');
					target.find('.usedqty').removeClass('hide');
				}
			}
		);
		
	});
	$("#products").on('click','.dtcancel',function(e){
		var target =$(e.currentTarget).closest('tr');
		target.find('.usedqtyval').removeClass('hide');
		target.find('.usedqtyedit').addClass('hide');
		target.find('.usedqty').removeClass('hide');
	});
	//Add Stock to Products module again
	$("#products").on('click','.addstock',function(e){
		var stockstatus = $(this).is( ":checked" );
		var projectid=$("input[name='projectid']").val();
		var target =$(e.currentTarget).closest('tr');
		var productid = target.find("input[name='productid']").val();
		var params = {};
		params['projectid'] = projectid;
		params['productid'] = productid;
		params['module'] = "Project";
		params['action'] = "ProductRemaingStockUpdate";
		if(stockstatus == true){
			bootbox.confirm("Product will lock once you checked. You can't edit this product quantity again.", function(result){ 
				if(result == false){
					target.find("input[name='addstock']").prop('checked',false);
					
				}else{
					AppConnector.request(params).then(
						function(data) {
							if(data.success == true) {
								target.find("input[name='addstock']").prop('disabled',true);
								target.find('.usedqty').addClass('hide');
								target.find('.quantity').addClass('hide');
							}
						}
					);
				}
			});
		}
	});
});
	</script>

	<div class="contents">
		<section>
			<table id="products" class="display" cellspacing="0" width="90%">
				<thead>
					<tr>
						<th>Product Number</th>
						<th>Product Name</th>
						<th>Price</th>
						<th>Quantity</th>
						<th>Total Price</th>
						<th>Used Quantity</th>
						<th>Remaining Quantity</th>
						<th>Stock add to Products</th>
					</tr>
				</thead>
				
				<tbody>
				
				<?php  $_smarty_tpl->tpl_vars['i'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['i']->_loop = false;
 $_smarty_tpl->tpl_vars['k'] = new Smarty_Variable;
 $_from = $_smarty_tpl->tpl_vars['PRODUCTDETAILS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['i']->key => $_smarty_tpl->tpl_vars['i']->value){
$_smarty_tpl->tpl_vars['i']->_loop = true;
 $_smarty_tpl->tpl_vars['k']->value = $_smarty_tpl->tpl_vars['i']->key;
?>
					<tr>
						<td align="center"><?php echo $_smarty_tpl->tpl_vars['i']->value['productnumber'];?>

						<input type="hidden" name="productid" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['productid'];?>
" />
						<input type="hidden" name="projectid" value="<?php echo $_REQUEST['record'];?>
" />
						<input type="hidden" name="productqty" class="productqty" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['productqty'];?>
" />
						<input type="hidden" name="totalprice"  value="<?php echo $_smarty_tpl->tpl_vars['i']->value['price'];?>
" />
						</td>
						<td align="center"><?php echo $_smarty_tpl->tpl_vars['i']->value['productname'];?>
</td>
						<td align="center"><?php echo $_smarty_tpl->tpl_vars['i']->value['price'];?>
</td>
						<td align="center" class="qtyclick">
							<span class="quantityval"><?php echo $_smarty_tpl->tpl_vars['i']->value['allocatedtqty'];?>
</span>&nbsp;&nbsp;
								<?php if ($_smarty_tpl->tpl_vars['i']->value['is_edit']!=1&&$_smarty_tpl->tpl_vars['i']->value['is_checked']!=1){?>
								<i class="icon-edit quantity"></i>
									<span class="hide quantityedit">
										<input  type="text" name="allocatedtqty" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['allocatedtqty'];?>
" class="input-small"/>
										<br/>
										<i class="icon-ok-sign qtysave"></i>
										<i class="icon-remove-sign qtycancel"></i>
									</span>
								<?php }?>
						</td>
						<td align="center" class='totalpricedisplay'>
							<?php echo $_smarty_tpl->tpl_vars['i']->value['totalprice'];?>

						</td>
						<td align="center" class="usedqtyclick">
							<span class="usedqtyval" style='color:blue;font-weight:bold;'><?php echo $_smarty_tpl->tpl_vars['i']->value['usedqty'];?>
						
							</span>
							<?php if ($_smarty_tpl->tpl_vars['i']->value['is_checked']!=1){?>
							&nbsp;<i class="icon-edit usedqty"></i>
							<span class="hide usedqtyedit">
								<input  type="text" name="usedqtyallow" value="<?php echo $_smarty_tpl->tpl_vars['i']->value['usedqty'];?>
" class="input-small"/>
								<br/>
								<i class="icon-ok-sign dtsave"></i>
								<i class="icon-remove-sign dtcancel"></i>
							</span>
							<?php }?>
						</td>
						<td align="center">
							<span class="remainingqty">
							<?php echo $_smarty_tpl->tpl_vars['i']->value['remainingqty'];?>

							</span>
						</td>
						<td align="center">
							<input type="checkbox" name="addstock" class="addstock" value="<?php if ($_smarty_tpl->tpl_vars['i']->value['is_checked']==1){?>1<?php }else{ ?>0<?php }?>" <?php if ($_smarty_tpl->tpl_vars['i']->value['is_checked']==1){?>checked disabled<?php }?>/>
						</td>
					</tr>
					<?php } ?>
				</tbody>
			</table>
	</div>
	</section>
<?php }} ?>