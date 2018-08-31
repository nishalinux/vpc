<?php /* Smarty version Smarty-3.1.7, created on 2018-08-14 20:21:21
         compiled from "/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/TimeTracker/ActivitiesView.tpl" */ ?>
<?php /*%%SmartyHeaderCode:17901570265b7339c1b6a637-42088075%%*/if(!defined('SMARTY_DIR')) exit('no direct access allowed');
$_valid = $_smarty_tpl->decodeProperties(array (
  'file_dependency' => 
  array (
    '478e97c550f16b7a03824188e496e21b0e15c766' => 
    array (
      0 => '/var/www/html/BMLGDEMO65/includes/runtime/../../layouts/vlayout/modules/TimeTracker/ActivitiesView.tpl',
      1 => 1507143471,
      2 => 'file',
    ),
  ),
  'nocache_hash' => '17901570265b7339c1b6a637-42088075',
  'function' => 
  array (
  ),
  'variables' => 
  array (
    'RELATED_HEADERS' => 0,
    'HEADER_FIELD' => 0,
    'RELATED_RECORDS' => 0,
    'RELATED_RECORD' => 0,
    'RELATED_MODULE_NAME' => 0,
    'RELATED_MODULE' => 0,
    'DETAILVIEWPERMITTED' => 0,
    'WIDTHTYPE' => 0,
    'RELATED_HEADERNAME' => 0,
    'PARENT_RECORD' => 0,
  ),
  'has_nocache_code' => false,
  'version' => 'Smarty-3.1.7',
  'unifunc' => 'content_5b7339c1be8ce',
),false); /*/%%SmartyHeaderCode%%*/?>
<?php if ($_valid && !is_callable('content_5b7339c1be8ce')) {function content_5b7339c1be8ce($_smarty_tpl) {?><table class="table table-bordered listViewEntriesTable">
    <thead>
    <tr class="listViewHeaders">
        <?php  $_smarty_tpl->tpl_vars['HEADER_FIELD'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['HEADER_FIELD']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_HEADERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['HEADER_FIELD']->key => $_smarty_tpl->tpl_vars['HEADER_FIELD']->value){
$_smarty_tpl->tpl_vars['HEADER_FIELD']->_loop = true;
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->iteration++;
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->last = $_smarty_tpl->tpl_vars['HEADER_FIELD']->iteration === $_smarty_tpl->tpl_vars['HEADER_FIELD']->total;
?>
            <th <?php if ($_smarty_tpl->tpl_vars['HEADER_FIELD']->last){?> colspan="2" <?php }?> nowrap>
                <?php if ($_smarty_tpl->tpl_vars['HEADER_FIELD']->value->get('column')=='time_start'){?>
                <?php }else{ ?>
                    <a href="javascript:void(0);" class="relatedListHeaderValues"  data-fieldname="<?php echo $_smarty_tpl->tpl_vars['HEADER_FIELD']->value->get('column');?>
">
                        <?php echo vtranslate($_smarty_tpl->tpl_vars['HEADER_FIELD']->value->get('label'),'TimeTracker');?>

                    </a>
                <?php }?>
            </th>
        <?php } ?>
    </tr>
    </thead>
    <?php  $_smarty_tpl->tpl_vars['RELATED_RECORD'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['RELATED_RECORD']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_RECORDS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
foreach ($_from as $_smarty_tpl->tpl_vars['RELATED_RECORD']->key => $_smarty_tpl->tpl_vars['RELATED_RECORD']->value){
$_smarty_tpl->tpl_vars['RELATED_RECORD']->_loop = true;
?>
        <tr class="listViewEntries" data-id='<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getId();?>
'
                <?php if ($_smarty_tpl->tpl_vars['RELATED_MODULE_NAME']->value=='Calendar'){?>
                <?php $_smarty_tpl->tpl_vars['DETAILVIEWPERMITTED'] = new Smarty_variable(isPermitted($_smarty_tpl->tpl_vars['RELATED_MODULE']->value->get('name'),'DetailView',$_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getId()), null, 0);?>
            <?php if ($_smarty_tpl->tpl_vars['DETAILVIEWPERMITTED']->value=='yes'){?>
                data-recordUrl='<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDetailViewUrl();?>
'
            <?php }?>
                <?php }else{ ?>
            data-recordUrl='<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDetailViewUrl();?>
'
                <?php }?>>
            <?php  $_smarty_tpl->tpl_vars['HEADER_FIELD'] = new Smarty_Variable; $_smarty_tpl->tpl_vars['HEADER_FIELD']->_loop = false;
 $_from = $_smarty_tpl->tpl_vars['RELATED_HEADERS']->value; if (!is_array($_from) && !is_object($_from)) { settype($_from, 'array');}
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->total= $_smarty_tpl->_count($_from);
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->iteration=0;
foreach ($_from as $_smarty_tpl->tpl_vars['HEADER_FIELD']->key => $_smarty_tpl->tpl_vars['HEADER_FIELD']->value){
$_smarty_tpl->tpl_vars['HEADER_FIELD']->_loop = true;
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->iteration++;
 $_smarty_tpl->tpl_vars['HEADER_FIELD']->last = $_smarty_tpl->tpl_vars['HEADER_FIELD']->iteration === $_smarty_tpl->tpl_vars['HEADER_FIELD']->total;
?>
                <?php $_smarty_tpl->tpl_vars['RELATED_HEADERNAME'] = new Smarty_variable($_smarty_tpl->tpl_vars['HEADER_FIELD']->value->get('name'), null, 0);?>
                <td class="<?php echo $_smarty_tpl->tpl_vars['WIDTHTYPE']->value;?>
" data-field-type="<?php echo $_smarty_tpl->tpl_vars['HEADER_FIELD']->value->getFieldDataType();?>
" nowrap>
                    <?php if ($_smarty_tpl->tpl_vars['HEADER_FIELD']->value->isNameField()==true||$_smarty_tpl->tpl_vars['HEADER_FIELD']->value->get('uitype')=='4'){?>
                        <a href="<?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDetailViewUrl();?>
"><?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value);?>
</a>
                    <?php }elseif($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value=='access_count'){?>
                        <?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getAccessCountValue($_smarty_tpl->tpl_vars['PARENT_RECORD']->value->getId());?>

                    <?php }elseif($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value=='time_start'){?>
                    <?php }elseif($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value=='listprice'||$_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value=='unit_price'){?>
                        <?php echo CurrencyField::convertToUserFormat($_smarty_tpl->tpl_vars['RELATED_RECORD']->value->get($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value),null,true);?>

                        <?php if ($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value=='listprice'){?>
                            <?php $_smarty_tpl->tpl_vars["LISTPRICE"] = new Smarty_variable(CurrencyField::convertToUserFormat($_smarty_tpl->tpl_vars['RELATED_RECORD']->value->get($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value),null,true), null, 0);?>
                        <?php }?>
                    <?php }elseif($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value=='filename'){?>
                         <?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->get($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value);?>

                         <?php }else{ ?>
                            <?php echo $_smarty_tpl->tpl_vars['RELATED_RECORD']->value->getDisplayValue($_smarty_tpl->tpl_vars['RELATED_HEADERNAME']->value);?>

                    <?php }?>
                </td>
            <?php } ?>
        </tr>
    <?php } ?>

</table><?php }} ?>