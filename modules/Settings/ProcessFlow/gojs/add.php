<?php 
  include_once('Processflow.php');                     
  $Processflow = new Processflow();
  if(isset($_REQUEST['id']) && $_REQUEST['id'] > 0){
    $processflow_data = $Processflow->getProcessflowFromId($_REQUEST['id']);  
    $is_vessels = $processflow_data['is_vessels'];
    $is_tools = $processflow_data['is_tools'];
    $is_machinery = $processflow_data['is_machinery'];
    $id_end_product_category = $processflow_data['id_end_product_category'];
  }else{
    $is_vessels = 0;
    $is_tools = 0;
    $is_machinery = 0;
    $id_end_product_category ="";
  }
  $assignedto = (object) $Processflow->assignedToUsersList();
  $rolesdata = $Processflow->getRoles();  
  $pc = $Processflow->getProducts(); 
  $assects = $Processflow->getAssetsList();
  $getProductCategoryList =  $Processflow->getProductCategoryList();
   
?> 
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">
    <title>Process Flow</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link href="assets/css/chosen.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <link href="assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">-->

    <!-- Custom styles for this template -->
    <link href="assets/css/offcanvas.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]><script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]
    <script src="assets/js/ie-emulation-modes-warning.js"></script>-->

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
      <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
  </head> 
  <style>
    .chosen-container{
      width:350px!importent;
    }
    .fa-plus-circle{
      float:right;
    }
    .panel-title > a, .panel-title > small, .panel-title > .small, .panel-title > small > a, .panel-title > .small > a {
          color: inherit;
          display:block;
      }
      .modal-dialog {
        display: inline-block;
        text-align: center;
        vertical-align: middle;
      }
      .btn-success{
        background:#5bb75b !important;
      }
      .btn{
        border-radius : 0px !important;
      }
      @media screen and (min-width: 768px) { 
        .modal:before {
          display: inline-block;
          vertical-align: middle;
          content: " ";
          height: 100%;
        }
      }
      @media print
      {    
          .panel-group, .panel-group *
          {
              display: none !important;
          }
      }
      .modal {
        text-align: center;
      }
      .panel{
        box-shadow: 0px 2px 10px #292828 !important;
        margin-bottom :5px !important;
      }
      #myDiagramDiv, #myPaletteDiv{
        border : 1px solid #ccc !important;
        box-shadow: 0px 2px 10px #292828 !important;
      }
      .displaynone{
        display:none !important;
      }
      .note{
        list-style-type: none;
	      color : red;
        text-align: left;
      }
  </style>
  <body style="background-color:#fafafb;">
    <div class="container-fluid"    >
      <div class="col-sm-12 col-md-12">
        <div class="row"> 
        
        <form class="form-horizontal" id='frmProcessForm' method="post" > 

          <div class="form-group">
            <div class="col-sm-12 text-right"> 
              <a href="index.php"><button type="button" class="btn btn-link" >Close</button></a>
              <?php if(isset($_GET['draft']) && $_GET['draft'] == 0){?>
              <button type="button" id="SaveButton" onclick="saveas()" class="btn btn-success" >Save As</button>
              <?php }else{ ?>
              <button type="button" id="SaveDraftButton" onclick="savedraft()" class="btn btn-info" >Save Draft</button>
              <button type="button" id="SaveButton" onclick="save()" class="btn btn-success" >Set Live</button>
              <?php } ?>
              <button type="button" id="openSVG" class="btn btn-info" >Print</button>
              <!--<button type="button" id="openImg" class="btn btn-info" >Print</button>-->
            </div>
          </div>

        <div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                  Process Flow
                  <i class="more-less glyphicon glyphicon-plus" style="float:right;"></i>
                </a>
              </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
              <div class="panel-body">
              
                  
                  <div class="col-md-6">              
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="forProcessFlowName">Process Master Name</label>
                        <div class="col-sm-8">
                        <input type="text" class="form-control input-sm" id="idProcessFlowName" name="processFlowName" required value="<?php echo $processflow_data['processmastername'];?>">
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="forSupervisorRole">Supervisor Role</label>               
                        <div class="col-sm-8">
                          <select class="form-control input-sm" id="idSupervisorRole" name='supervisorRole' required> 
                            <option value=''>Select</option>
                            <?php foreach($rolesdata as $roleid=>$rolename){ 
                              if(isset($processflow_data['supervisor_roleid']) && $processflow_data['supervisor_roleid'] == $roleid ){ $sel = 'selected'; }else{$sel =''; }?>
                              <option value='<?php echo $roleid;?>' <?php echo $sel;?>><?php echo $rolename;?></option>
                          <?php }?>  
                          </select>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="col-sm-4 control-label " for="forOperatorRole">Operator Role</label>
                        <div class="col-sm-8">
                          <select class="form-control input-sm" id="idOperatorRole" name='operatorRole' required>
                            <option value=''>Select</option> 
                            <?php foreach($rolesdata as $roleid=>$rolename){ 
                              if(isset($processflow_data['operator_roleid']) && $processflow_data['operator_roleid'] == $roleid ){ $sel = 'selected'; }else{$sel =''; }?>
                              <option value='<?php echo $roleid;?>' <?php echo $sel;?>><?php echo $rolename;?></option>
                          <?php }?>               
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-4 control-label " for="forOperatorRole">End Product Category</label>
                        <div class="col-sm-8">
                          <select class="form-control input-sm" id="id_end_product_category" name='id_end_product_category' required>
                            <option value=''>Select</option> 
                            <?php foreach($getProductCategoryList as $productcategoryid=>$productcategory){?>
                              <option value='<?php echo $productcategoryid;?>' <?php if($id_end_product_category == $productcategoryid){?> selected="selected"<?php }?>><?php echo $productcategory;?></option>
                          <?php }?>               
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-4 control-label " for="forOperatorRole">Sound Notifications</label>
                        <div class="col-sm-8 control-label" style="text-align:left;">                
                          <input type="checkbox" name="sound_notifications" id="idSoundNotifications" class="" value='1' <?php if($processflow_data['sound_notifications'] == '1'){ echo 'checked'; } ?> >
                        </div>
                      </div> 
                    </div>

                  <div class="col-md-6"> 
                      
                      <!--<div class="form-group">
                        <label class="col-sm-4 control-label " for="forMaterials">Materials</label>
                        <div class="col-sm-8">
                          <input type="hidden" id="idInpMaterials" name="materials" value="<?php //echo $processflow_data['materials'];?>">
                          <select class="form-control input-sm chosen" id="idMaterials"  multiple required>                      
                            <?php 
                            //$m = explode(',',$processflow_data['materials']);
                              //foreach($pc as $pcid=>$pcname){                       
                             /// if(isset($processflow_data['materials']) && in_array($pcid,$m) ){ $sel = 'selected'; }else{$sel =''; }?>
                              <option value='<?php //echo $pcid;?>' <?php //echo $sel;?>><?php //echo $pcname;?></option>
                          <?php //}?>               
                          </select>
                        </div>
                      </div> -->
                      <div class="form-group">
                        <label class="col-sm-4 control-label " for="forVessels">Vessels <input type="checkbox"  <?php if($is_vessels == 1){?>checked="checked"<?php }?> name="is_vessels" id="is_vessels" value="0"></label>
                        <div class="col-sm-8 <?php if($is_vessels == 0){?>displaynone<?php }?>">
                          <input type="hidden" id="idInpVessels" name="vessels" value="<?php echo $processflow_data['vessels'];?>">
                          <select class="form-control input-sm chosen" id="idVessels"  multiple >                     
                            <?php 
                              $v = explode(',',$processflow_data['vessels']);
                              foreach($assects as $aid=>$aname){ 
                              if(isset($processflow_data['vessels']) && in_array($aid,$v) ){ $sel = 'selected'; }else{$sel =''; }?>
                              <option value='<?php echo $aid;?>' <?php echo $sel;?>><?php echo $aname;?></option>
                          <?php }?>               
                          </select>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="col-sm-4 control-label " for="forTools">Tools <input type="checkbox" <?php if($is_tools == 1){?>checked="checked"<?php }?> name="is_tools" id="is_tools" value="0"></label>
                        <div class="col-sm-8 <?php if($is_tools == 0){?>displaynone<?php }?>">                
                        <input type="hidden" id="idInptools" name="tools" value="<?php echo $processflow_data['tools'];?>">
                          <select class="form-control input-sm chosen" id="idTools"  multiple>                  
                            <?php $t = explode(',',$processflow_data['tools']);
                              foreach($assects as $aid=>$aname){ 
                                if(isset($processflow_data['tools']) && in_array($aid,$t) ){ $sel = 'selected'; }else{$sel =''; }?>
                              <option value='<?php echo $aid;?>' <?php echo $sel;?>><?php echo $aname;?></option>
                          <?php }?>               
                          </select>
                        </div>
                      </div>
            
                      <div class="form-group">
                        <label class="col-sm-4 control-label" for="forMachinery">Machinery <input type="checkbox" name="is_machinery" id="is_machinery" <?php if($is_machinery == 1){?>checked="checked"<?php }?> value="0"></label>
                        <div class="col-sm-8 <?php if($is_machinery == 0){?>displaynone<?php }?>">
                          <input type="hidden" id="idInpMachinery" name="machinery" value="<?php echo $processflow_data['machinery'];?>">
                          <select class="form-control input-sm chosen" id="idMachinery"   multiple >                    
                            <?php $am = explode(',',$processflow_data['machinery']);
                              foreach($assects as $aid=>$aname){ 
                                if(isset($processflow_data['machinery']) && in_array($aid,$am) ){ $sel = 'selected'; }else{$sel =''; }?>
                              <option value='<?php echo $aid;?>' <?php echo $sel;?>><?php echo $aname;?></option>
                          <?php }?>               
                          </select>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="col-sm-4 control-label " for="forOperatorRole">Details <input type="checkbox" name="details" id="idDetails" class="" value='1' <?php if($processflow_data['details'] == '1'){ echo 'checked'; } ?> ></label>
                        <div class="col-sm-8">                
                          
                        </div>
                      </div>

                    </div>
                    <div class="col-md-12" ><button class="btn btn-info pull-right" style="margin-bottom:10px;" type="button" id="idBtnAddMaterial"><span class='glyphicon glyphicon-plus' aria-hidden='true'></span> Add Material</button><br></div>
                    <div class="col-md-12">
                      <input type="hidden" value="0" name="hdnSeqMetNum" id="idHdnSeqMetNum">
                      <table class="table" id="idTblMList">
                        <tr>
                          <th></th>
                          <th>Material</th>
                          <th>Quantity</th>
                        </tr>
                      <?php
                      if($processflow_data['materials'] != NULL){ 
                          $mdata = json_decode($processflow_data['materials'],true); $i=0;
                            foreach($mdata as $m){ ?>
                              <tr id='tr_<?php echo $i;?>'>
                                <td><a href='#' class='clsTrDelete' data-id='<?php echo $i;?>' id='idADelete_<?php echo $i;?>' onclick='deleteMaterialTr("<?php echo $i;?>")' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>
                              
                                <td><select onchange="getUsageUnit(this)" class="form-control input-sm chosen clsMaterials" id="idMaterials_<?php echo $i;?>" name="material[<?php echo $i;?>][materialid]" required>
                                    <option value="">-Select-</option>                  
                                   <?php foreach($pc as $k=>$pdata){  
                                      $pcid = $pdata['productid'];
                                      $pcname = htmlentities($pdata['productname']);
                                      $usageunit = $pdata['usageunit'];
                                     ?>   
                                    <option value='<?php echo $pcid;?>' data-usageunit='<?php echo $usageunit;?>' <?php if($pcid == $m['materialid']){ echo 'selected';}?> ><?php echo $pcname;?></option>
                                      <?php } ?>               
                                    </select>
                                </td>
                                <td><input type="number" value="<?php echo $m['qty']; ?>" class="form-control" name="material[<?php echo $i;?>][qty]"></td></tr>
                          <?php $i++;} }?>
                          </table>
                    </div>
                  </form>
              </div>
            </div>
          </div>
        </div> 
      </div>  
    </div>
          
       
      <div class="row"> 
        <div class="col-md-12" >
	
          <div class="panel panel-default">  
            <div class="panel-heading"  >
              
              <div class="panel-title pull-left">
              Core Objects
              </div>
              <div class="panel-title pull-right">Grid <input type="checkbox" id="idChkGraphToggle" value="1" name="graphtoggle"></div>
              <div class="clearfix"></div>
            </div>
               <div class="panel-body" id="myPaletteDiv" style="height:161px;border: solid 1px black;border-bottom:none;overflow-Y: hidden !important;"></div>
            </div> 
          </div>
      </div> 
      <div class="row" style="margin-left:0px;margin-right:0px;margin-bottom: 20px;" >            
        <div class="col-md-12" id="myDiagramDiv" style="flex-grow: 1; height: 620px; border: solid 1px black"></div>
        <?php if(isset($_REQUEST['id']) && $_REQUEST['id'] > 0){ ?>
            <input type="hidden" name='processid' id="processid" value="<?php echo $processflow_data['processmasterid'];?>">
            <input type="hidden" id="mySavedModel" value='<?php echo $processflow_data['jsondata'];?>'>
          <?php }else{ ?>
            <input type="hidden" name='processid' id="processid" value="0">
            <input type="hidden" id="mySavedModel" value='
              { "class": "go.GraphLinksModel",
              "linkFromPortIdProperty": "fromPort",
              "linkToPortIdProperty": "toPort",
              "nodeDataArray": [],
              "linkDataArray": []}'>
           <?php } ?>
      </div>
      <div class="row" ></div>
          
          <!--<button onclick="makeSVG()">Render as SVG</button>
          <div id="SVGArea"></div>-->

     
    </div><!--/.container-->
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="assets/js/jquery.js"></script>
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>    
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/offcanvas.js"></script>
    <script src="assets/js/chosen.jquery.js"></script>
    <script src="assets/js/bootbox.min.js"></script>
    <script>
      $(document).ready(function(){
        // Add minus icon for collapse element which is open by default
        $(".collapse.in").each(function(){
        	$(this).siblings(".panel-heading").find(".glyphicon").addClass("glyphicon-minus").removeClass("glyphicon-plus");
        });
        
        // Toggle plus minus icon on show hide of collapse element
        $(".collapse").on('show.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("glyphicon-plus").addClass("glyphicon-minus");
        }).on('hide.bs.collapse', function(){
        	$(this).parent().find(".glyphicon").removeClass("glyphicon-minus").addClass("glyphicon-plus");
        });

        $("#is_vessels").click(function(){
          var is_checked = $(this).is(':checked');
          if(is_checked == true)
          {
              //var parent = $("#idVessels").parent();
              $("#idVessels").parent().removeClass("displaynone");
          }
          if(is_checked == false)
          {
            $("#idVessels").parent().addClass("displaynone");
          }
        });

        $("#is_tools").click(function(){
          var is_checked = $(this).is(':checked');
          if(is_checked == true)
          {
              //var parent = $("#idVessels").parent();
              $("#idInptools").parent().removeClass("displaynone");
          }
          if(is_checked == false)
          {
            $("#idInptools").parent().addClass("displaynone");
          }
        });

        $("#is_machinery").click(function(){
          var is_checked = $(this).is(':checked');
          if(is_checked == true)
          {
              //var parent = $("#idVessels").parent();
              $("#idMachinery").parent().removeClass("displaynone");
          }
          if(is_checked == false)
          {
            $("#idMachinery").parent().addClass("displaynone");
          }
        });
    });
    </script>          
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
    <script src="assets/js/goSamples.js"></script>
    <script src="release/go.js"></script>
    <!--<script src="release/go-debug.js"></script>-->
    <link rel='stylesheet' href='extensions/DataInspector.css' />
    <script src="extensions/DataInspector.js"></script>
    <!-- Modal -->

    <div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
            <h4 class="modal-title" id="myModalLabel">Object Properties</h4>
          </div>
          <div class="modal-body">
          <form id="myform" enctype= "multipart/form-data">
          
            <div class="col-md-4" id="myInspector"> </div>
            <ul class="note">Note
              <li>1 - Timer's processTime should be in minutes.</li>
              <li>2 - Don't use single Quotes (' '), or Double quotes (" ").</li>
              <li>3 - Use Comma separated text for multiple Checkboxed and Fields.</li>
            </ul>
          </form>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    

    <script>
    $(document).ready(function(){ 

      $('.chosen').chosen();
      /*$("#idMaterials").chosen().change(function(e, params){
        values = $("#idMaterials").chosen().val();
        $('#idInpMaterials').val(values);
      });*/
      $("#idVessels").chosen().change(function(e, params){
        values = $("#idVessels").chosen().val();
        $('#idInpVessels').val(values);
      });

      $("#idTools").chosen().change(function(e, params){
        values = $("#idTools").chosen().val();
        $('#idInptools').val(values);
      });
      $("#idMachinery").chosen().change(function(e, params){
        values = $("#idMachinery").chosen().val();
        $('#idInpMachinery').val(values);
      });
     
     /** add Material  */
     $("#idBtnAddMaterial").click(function () {

       var sid = $('#idHdnSeqMetNum').val();

       var html="<tr id='tr_"+sid+"'><td><a href='#' class='clsTrDelete' data-id='"+sid+"' id='idADelete_"+sid+"' onclick='deleteMaterialTr("+sid+")' ><span class='glyphicon glyphicon-trash' aria-hidden='true'></span></a></td>";
       html += '<td><select onchange="getUsageUnit(this)" class="form-control input-sm chosen clsMaterials" id="idMaterials_'+sid+'" name="material['+sid+'][materialid]" required><option value="">-Select-</option>';                    
                  <?php 
                  $m = explode(',',$processflow_data['materials']);
                  foreach($pc as $k=>$pdata){  
                    $pcid = $pdata['productid'];
                    $pcname = htmlentities($pdata['productname']);
                    $usageunit = $pdata['usageunit'];      ?>                
                     
                     html += "<option value='<?php echo $pcid;?>' data-usageunit='<?php echo $usageunit;?>' ><?php echo $pcname;?></option>";
                <?php } ?>               
                html += "</select></td>";
            html += '<td><input type="number" value="" class="form-control" name="material['+sid+'][qty]"></td></tr>';
       $("#idTblMList").append(html);
        $('#idHdnSeqMetNum').val(parseInt(sid)+1);
      }); 
 
      $("td .form-control").change(function(e){
        var ingnore_key_codes = [34, 39];
        console.log(ingnore_key_codes);
        if ($.inArray(e.which, ingnore_key_codes) >= 0) {
            e.preventDefault();
        }
      });

      var finaldata = {'mode': 'user_list'}; 
      var fdata = $.param(finaldata);
       
        $.ajax({        
            url : 'ajax.php',
            type : 'POST',         
            data : fdata,
            success : function(userdatainfo) {
              init();
              var userdatainfo = JSON.parse(userdatainfo);
              var inspector = new Inspector('myInspector', myDiagram,
                {
                  properties: {              
                    "key": { show: false },
                    "loc": { show: false },
                    "category": { show: false },
                    "figure": { show: false },
                    
                    "Product" : { show: Inspector.showIfPresent,
                                  type: "select",
                                  choices: function(node, propName) {
                                    if (Array.isArray(node.data.choices)) return node.data.choices;
                                    return ["Yes", "No"];
                                  }     
                                },
                    "AssignedTo" : { show: true,
                      type: "select",
                      choices: function(node, propName) {
                        if (Array.isArray(node.data.choices)) return node.data.choices;
                        return userdatainfo;
                      }     
                    },
                    "IsFinalResult" : { show: Inspector.showIfPresent,
                                  type: "select",
                                  choices: function(node, propName) {
                                    if (Array.isArray(node.data.choices)) return node.data.choices;
                                    return ["Yes", "No"];
                                }     
                    },
                    "LearnerModeDetails" : { show: true },
                    "CheckboxFields" : { show: true }
                  }

                });   
            },
            error : function(request,error)
            {
              console.log(error);
            }
        });
        
      /* checkbox for graph view toggle */
      $('#idChkGraphToggle').change(function() {
            if(this.checked) {  
              myDiagram.grid.visible = true;
              myDiagram.grid.gridCellSize = new go.Size(40, 40);
              myDiagram.toolManager.draggingTool.isGridSnapEnabled = true;
              myDiagram.toolManager.resizingTool.isGridSnapEnabled = true;
            }else{ 
              myDiagram.grid.visible = false;
              myDiagram.grid.gridCellSize = new go.Size(40, 40);
              myDiagram.toolManager.draggingTool.isGridSnapEnabled = true;
              myDiagram.toolManager.resizingTool.isGridSnapEnabled = true;
            }    
        });
        var k = 0;
       
    });

    function getUsageUnit(selectObject) {
        var value = selectObject.value;  
        console.log(value);
        console.log(selectObject); 

        var option = selectObject.find("[value='" + value + "']");
        if (option.length > 0) {
          var id = option.data("usageunit"); 
          console.log(id); 
        }

        console.log(selectObject.find(':selected').data('usageunit'));
    }


    function deleteMaterialTr(trid){
       
      bootbox.confirm({
            message: "Are you sure you want to delete?",
            buttons: {
                confirm: {
                    label: 'Yes',
                    className: 'btn-success'
                },
                cancel: {
                    label: 'No',
                    className: 'btn-danger'
                }
            },
            callback: function (result) {
                if(result){
                  $('#tr_'+trid).remove();
                }
            }
        });
    }
    
    </script>


<!--<script src="assets/js/goSamples.js"></script> --> <!-- this is only for the GoJS Samples framework -->
<script id="code">
    function init() {  


      var $ = go.GraphObject.make;  // for conciseness in defining templates
      myDiagram =
      $(go.Diagram, "myDiagramDiv",  // must name or refer to the DIV HTML element
        {
          initialContentAlignment: go.Spot.Center,
          allowDrop: true,  // must be true to accept drops from the Palette
          "LinkDrawn": showLinkLabel,  // this DiagramEvent listener is defined below
          "LinkRelinked": showLinkLabel,
          scrollsPageOnFocus: false,
          "undoManager.isEnabled": true  // enable undo & redo
        });
        
        
  
      // when the document is modified, add a "*" to the title and enable the "Save" button
      myDiagram.addDiagramListener("Modified", function(e) {
        var button = document.getElementById("SaveButton");
        var draftbutton = document.getElementById("SaveDraftButton");
        if (button) button.disabled = !myDiagram.isModified;
        if (draftbutton) draftbutton.disabled = !myDiagram.isModified;
        var idx = document.title.indexOf("*");
        if (myDiagram.isModified) {
          if (idx < 0) document.title += "*";
        } else {
          if (idx >= 0) document.title = document.title.substr(0, idx);
        }
      });
  
  
      // helper definitions for node templates
  
      function nodeStyle() {
        return [
          // The Node.location comes from the "loc" property of the node data,
          // converted by the Point.parse static method.
          // If the Node.location is changed, it updates the "loc" property of the node data,
          // converting back using the Point.stringify static method.
          new go.Binding("location", "loc", go.Point.parse).makeTwoWay(go.Point.stringify),
          {
            // the Node.location is at the center of each node
            locationSpot: go.Spot.Center,
            //isShadowed: true,
            //shadowColor: "#888",
            // handle mouse enter/leave events to show/hide the ports
            mouseEnter: function (e, obj) { showPorts(obj.part, true); },
            mouseLeave: function (e, obj) { showPorts(obj.part, false); }
          }
        ];
      }
  
      // Define a function for creating a "port" that is normally transparent.
      // The "name" is used as the GraphObject.portId, the "spot" is used to control how links connect
      // and where the port is positioned on the node, and the boolean "output" and "input" arguments
      // control whether the user can draw links from or to the port.
      function makePort(name, spot, output, input) { 
        // the port is basically just a small circle that has a white stroke when it is made visible
        return $(go.Shape, "Circle",
                 {
                    fill: "transparent",
                    stroke: null,  // this is changed to "white" in the showPorts function
                    desiredSize: new go.Size(8, 8),
                    alignment: spot, alignmentFocus: spot,  // align the port on the main Shape
                    portId: name,  // declare this object to be a "port"
                    fromSpot: spot, toSpot: spot,  // declare where links may connect at this port
                    fromLinkable: output, toLinkable: input,  // declare whether the user may draw links to/from here
                    cursor: "pointer"  // show a different cursor to indicate potential link point
                 });
      }
  
      // define the Node templates for regular nodes
  
      var lightText = 'whitesmoke';
  
      myDiagram.nodeTemplateMap.add("",  // the default category
        $(go.Node, "Spot",{ resizable: true }, nodeStyle(),
          // the main object is a Panel that surrounds a TextBlock with a rectangular Shape
          $(go.Panel, "Auto",
            $(go.Shape, "Rectangle",
              { fill: "#00A9C9", stroke: null },
              new go.Binding("figure", "figure")),
            $(go.TextBlock,
              {
                font: "bold 11pt Helvetica, Arial, sans-serif",               
                margin: 8,
                maxSize: new go.Size(160, NaN),
                wrap: go.TextBlock.WrapFit,
                editable: true,
                stroke: '#454545'
              },
              new go.Binding("text").makeTwoWay())
          ),
          // four named ports, one on each side:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
  
        myDiagram.nodeTemplateMap.add("Action",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 40), fill: "#00308f", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
              $(go.TextBlock, "Action",
              { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
              new go.Binding("text")),
              $(go.TextBlock, textStyle(),
              { row: 1, column: 0 },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
             
        myDiagram.nodeTemplateMap.add("MultiAction",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 40), fill: "#8ae429", stroke: null }),
            $(go.Panel, "Horizontal",
	    
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
              $(go.TextBlock, "MultiAction",
              { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
              new go.Binding("text")),
              $(go.TextBlock, textStyle(),
              { row: 1, column: 0 },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
  
        myDiagram.nodeTemplateMap.add("Start",
      $(go.Node, "Spot", nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
            { minSize: new go.Size(40, 40), fill: "#4D7F17", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
            
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
            $(go.TextBlock, "Start",
            { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text")),
            $(go.TextBlock, textStyle(),
              { row: 1, column: 0 },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
        // three named ports, one on each side except the top, all output only:
        makePort("L", go.Spot.Left, true, false),
        makePort("R", go.Spot.Right, true, false),
        makePort("B", go.Spot.Bottom, true, false)
      ));
  
  
      myDiagram.nodeTemplateMap.add("Terminal",
      $(go.Node, "Spot", nodeStyle(),
      $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 40), fill: "#ff0000", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
            $(go.TextBlock, "End",
            { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
            new go.Binding("text")),
            $(go.TextBlock, textStyle(),
              { row: 1, column: 0,stroke: lightText },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
        // three named ports, one on each side except the bottom, all input only:
        makePort("T", go.Spot.Top, false, true),
        makePort("L", go.Spot.Left, false, true),
        makePort("R", go.Spot.Right, false, true)
        ));

  
        myDiagram.nodeTemplateMap.add("Branching",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(45, 45), fill: "#DE548B", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
            $(go.TextBlock, "Branching",
              { font: "bold 11pt Helvetica, Arial, sans-serif",  stroke: lightText },
              new go.Binding("text")),
            $(go.TextBlock, textStyle(),
              { row: 1, column: 0,  stroke: lightText },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
            
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
  
        
        myDiagram.nodeTemplateMap.add("Decision",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 40), fill: "#5A555C", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
              $(go.TextBlock, "Decision",
              { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
              new go.Binding("text")),
              $(go.TextBlock, textStyle(),
              { row: 1, column: 0 },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
  
        myDiagram.nodeTemplateMap.add("Approval",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 50), fill: "#0073e5", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
              $(go.TextBlock, "Approval",
              { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText },
              new go.Binding("text")),
              $(go.TextBlock, textStyle(),
              { row: 1, column: 0 },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14), stroke: lightText
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
  
        myDiagram.nodeTemplateMap.add("Notification",
        $(go.Node, "Spot",{ resizable: true }, nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 40), fill: "#FF8000", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
           
              $(go.TextBlock, "Notification",
              {   margin: 5,
                  maxSize: new go.Size(200, NaN),
                  wrap: go.TextBlock.WrapFit,
                  textAlign: "center",
                  editable: true,
                  font: "bold 12pt Helvetica, Arial, sans-serif",
                  stroke: lightText },
              new go.Binding("text")),
            $(go.TextBlock, textStyle(),
              { row: 1, column: 0,stroke: lightText },
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;})),
            
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        ));
  
        myDiagram.nodeTemplateMap.add("Timer",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(50, 50), fill: "#a200ff", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
            $(go.TextBlock, textStyle(),
              {
                row: 1, column: 1, columnSpan: 4,
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 14),
                margin: new go.Margin(0, 0, 0, 3)
              },
              new go.Binding("text", "title").makeTwoWay()),
              $(go.TextBlock, "Timer",
              { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText},
              new go.Binding("text")),
            $(go.TextBlock, textStyle(),
              { row: 1, column: 0, stroke: lightText },
              new go.Binding("text", "LearnerModeDetails", function(v) {return v;})),
            $(go.TextBlock, textStyle(),  // the comments
              {
                row: 3, column: 0, columnSpan: 5,
                font: "italic 9pt sans-serif",
                wrap: go.TextBlock.WrapFit,
                editable: true,  // by default newlines are allowed
                minSize: new go.Size(10, 14)
              },
              new go.Binding("text", "comments").makeTwoWay())
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        )); 

        myDiagram.nodeTemplateMap.add("Document",
        $(go.Node, "Spot", { resizable: true },nodeStyle(),
        $(go.Panel, "Auto",
          // for sorting, have the Node.text be the data.name
          new go.Binding("text", "name"),
          // bind the Part.layerName to control the Node's layer depending on whether it isSelected
          new go.Binding("layerName", "isSelected", function(sel) { return sel ? "Foreground" : ""; }).ofObject(),
          $(go.Shape, "Rectangle",
          { minSize: new go.Size(40, 40), fill: "#419873", stroke: null }),
            $(go.Panel, "Horizontal",
          $(go.Picture,
            {
              name: "Picture",
              desiredSize: new go.Size(39, 39),
              margin: new go.Margin(6, 8, 6, 10),
            },
            new go.Binding("source", "category", findHeadShot)),
          // define the panel where the text will appear
          $(go.Panel, "Table",
            {
              maxSize: new go.Size(150, 999),
              margin: new go.Margin(6, 10, 0, 3),
              defaultAlignment: go.Spot.Left
            },
            $(go.RowColumnDefinition, { column: 2, width: 4 }),
            $(go.TextBlock, textStyle(),  // the name
              {
                row: 0, column: 0, columnSpan: 5,
                font: "12pt Segoe UI,sans-serif",
                editable: true, isMultiline: false,
                minSize: new go.Size(10, 16)
              },
              new go.Binding("text", "name").makeTwoWay()),
             
 
              $(go.TextBlock, "Document",
              { font: "bold 11pt Helvetica, Arial, sans-serif", stroke: lightText, verticalAlignment: go.Spot.Bottom,margin: 10 },
              new go.Binding("text")),
              $(go.TextBlock, textStyle(),
              { row: 1, column: 0, stroke: lightText},
              new go.Binding("text", "LearnerModeDetails", function(v) {return  v;}))
          )  // end Table Panel
        ) // end Horizontal Pane
        ),
          // three named ports, one on each side except the bottom, all input only:
          makePort("T", go.Spot.Top, false, true),
          makePort("L", go.Spot.Left, true, true),
          makePort("R", go.Spot.Right, true, true),
          makePort("B", go.Spot.Bottom, true, false)
        )); 
  
  
      // replace the default Link template in the linkTemplateMap
      myDiagram.linkTemplate =
        $(go.Link,  // the whole link panel
          {
            routing: go.Link.AvoidsNodes,
            curve: go.Link.JumpOver,
            corner: 5, toShortLength: 4,
            relinkableFrom: true,
            relinkableTo: true,
            reshapable: true,
            resegmentable: true,
            // mouse-overs subtly highlight links:
            mouseEnter: function(e, link) { link.findObject("HIGHLIGHT").stroke = "rgba(30,144,255,0.2)"; },
            mouseLeave: function(e, link) { link.findObject("HIGHLIGHT").stroke = "transparent"; }
          },
          new go.Binding("points").makeTwoWay(),
          $(go.Shape,  // the highlight shape, normally transparent
            { isPanelMain: true, strokeWidth: 8, stroke: "transparent", name: "HIGHLIGHT" }),
          $(go.Shape,  // the link path shape
            { isPanelMain: true, stroke: "gray", strokeWidth: 2 }),
          $(go.Shape,  // the arrowhead
            { toArrow: "standard", stroke: null, fill: "gray"}),
          $(go.Panel, "Auto",  // the link label, normally not visible
            { visible: false, name: "LABEL", segmentIndex: 2, segmentFraction: 0.5},
            new go.Binding("visible", "visible").makeTwoWay(),
            $(go.Shape, "RoundedRectangle",  // the label shape
              { fill: "#F8F8F8", stroke: null }),
            $(go.TextBlock, "Yes",  // the label
              {
                textAlign: "center",
                font: "10pt helvetica, arial, sans-serif",
                stroke: "#333333",
                editable: true
              },
              new go.Binding("text").makeTwoWay())
          )
        );
  
      // Make link labels visible if coming out of a "conditional" node.
      // This listener is called by the "LinkDrawn" and "LinkRelinked" DiagramEvents.
      function showLinkLabel(e) {
        var label = e.subject.findObject("LABEL");
        if (label !== null) label.visible = (e.subject.fromNode.data.figure === "Diamond");
      }
  
      // temporary links used by LinkingTool and RelinkingTool are also orthogonal:
      myDiagram.toolManager.linkingTool.temporaryLink.routing = go.Link.Orthogonal;
      myDiagram.toolManager.relinkingTool.temporaryLink.routing = go.Link.Orthogonal;
  
      load();  // load an initial diagram from some JSON text
  
      // initialize the Palette that is on the right side of the page
      myPalette =
        $(go.Palette, "myPaletteDiv",  // must name or refer to the DIV HTML element
          {
            scrollsPageOnFocus: false,
            nodeTemplateMap: myDiagram.nodeTemplateMap,  // share the templates used by myDiagram
            model: new go.GraphLinksModel([  // specify the contents of the Palette
              { category: "Start", text: "Start",processTime:'',LearnerModeDetails:'' },
              { category: "Action",text: "Action",Product :'',AssignedTo :'', Fields: '',CheckboxFields:'',processTime:'',IsFinalResult:'',LearnerModeDetails:''},
              { category: "MultiAction",text: "Multi Action",AssignedTo :'',processTime:'',LearnerModeDetails:''},
              { category: "Branching",text: "Branching",AssignedTo :'',processTime:'',LearnerModeDetails:''},
              { category: "Decision",text: "Decision", AssignedTo :'',processTime:'',LearnerModeDetails:''},
              { category: "Approval",text: "Approval",AssignedTo :'', processTime:'',LearnerModeDetails:''},
              { category: "Notification",text: "Notification",AssignedTo :'',  processTime:'',LearnerModeDetails:''},
              { category: "Timer",text: "Timer", processTime:'',AssignedTo :'',snoozeInterval:'',LearnerModeDetails:''},
              { category: "Document", text: "Document",AssignedTo :'',processTime:'',LearnerModeDetails:''},
              { category: "Terminal", text: "End",Fields: '',CheckboxFields:'',processTime:'',IsFinalResult:'',LearnerModeDetails:''}          
                         
            ])
          });
          
    
    } // end init
  
    var button = document.getElementById('openSVG');
      button.addEventListener('click', function() {
        var newWindow = window.open("","newWindow");
        if (!newWindow) return;
        var newDocument = newWindow.document;
        var svg = myDiagram.makeSvg({
          document: newDocument,  // create SVG DOM in new document context
          scale: 1
        });
        newDocument.body.appendChild(svg);
        $('#myDiagramDiv').printElement();
      }, false);
  
      
    
  
    // Make all ports on a node visible when the mouse is over the node
    function showPorts(node, show) {
      var diagram = node.diagram;
      if (!diagram || diagram.isReadOnly || !diagram.allowLink) return;
      node.ports.each(function(port) {
          port.stroke = (show ? "white" : null);
        });
    }
  
  
    // Show the diagram's model in JSON format that the user may edit
    function savedraft()
    {
      savefinal('draft');
    }
  
    function save() 
    {
      savefinal('save');
    }

    function saveas(){
      savefinal('saveas')
    }

    

    function check_array_special_char_cleaner(data){


      if($.type(data) == 'array' || $.type(data) == 'object'){
        var res = 0;

      $.each(data, function(i, item) { 
        if($.type(item) == 'array' || $.type(item) == 'object'){

          check_array_special_char_cleaner(item);

        }else{

          if(/[\'\"]/.test(item) == true) { 

            bootbox.alert('Objects Content('+ item +') have Special characters, please check and try again.');
            res++;
            //alert(res);
          }else{
            if(res > 0)
            {
              res--;
              return res;
            }
          }
        }
      });
      }
    }

  function savefinal(savemode){
    var fdata = $('#frmProcessForm').serialize();

    var final_process_json = myDiagram.model.toJson()
    $("#mySavedModel").val(final_process_json);
    myDiagram.isModified = false;
    var processid = $('#processid').val();
    var processFlowName = $('#idProcessFlowName').val();
    var operatorRole = $('#idOperatorRole').val();
    var supervisorRole = $('#idSupervisorRole').val();     
    /* var materials = $('#idInpMaterials').val(); */  
    
    var tools = '';
    tools = $('#idInptools').val();     
    
    var machinery = '';
    machinery = $('#idInpMachinery').val();
    var id_end_product_category = $("#id_end_product_category").val();
        
      
    if($('#is_vessels').is(':checked')) {
      var is_vessels = 1;
      var vessels = $('#idInpVessels').val();  
    }else{
      var is_vessels = 0; 
      var vessels = "";
    }

    var is_tools = 0;     
    if($('#is_tools').is(':checked')) {
      is_tools = 1;
    }else{
      tools = "";
    }
    var is_machinery = 0;
    if($('#is_machinery').is(':checked')) {
      is_machinery = 1;
    }else{
      machinery="";
    }
    var sound_notifications = 0;    
    if($('#idSoundNotifications').is(':checked')) {
      sound_notifications = 1;
    }
    var details = 0;
    if($("#idDetails").is(':checked'))
    {
      details = 1;
    }     
      
    if(processFlowName == ''){     
      return false;
    }
      var finaldata = {                
        'process_data':final_process_json,
        'mode': 'save',
        'savetype': savemode,
        'processid':processid,             
        'supervisorRole':supervisorRole,             
        'operatorRole':operatorRole,               
        'processFlowName':processFlowName,                         
        'vessels':vessels,              
        'tools':tools,
        'machinery':machinery,
        'is_vessels':is_vessels,              
        'is_tools':is_tools,              
        'is_machinery':is_machinery, 
        'id_end_product_category' : id_end_product_category,        
        'sound_notifications':sound_notifications,
        'details':details,
        'other_data' :fdata       
      }; 
      var data = $.param(finaldata);
    
      $.ajax({ url : 'ajax.php',type : 'POST',data : data,success : function(data) { 
            var fdata = $.parseJSON(data);
            console.log(data);
            if(fdata.status === 1){
              bootbox.alert({
                  message: fdata.message,
                  callback: function () {
                    $('#processid').val(data.processid);
                    window.location.href = "index.php";
                  }
              });
            }else{
              bootbox.alert(fdata.message);
              return false;
            }
          },
          error : function(request,error)
          {
            console.log(request);
            console.log(error);
            return false;
          }
      });
  }
    
    function textStyle() {
      return { font: "9pt  Segoe UI,sans-serif", stroke: "white" };
    }
    function findHeadShot(category) {
        if (category != ""){
          
          //return "samples/images/HSnopic.png"; // There are only 16 images on the server
          return "samples/images/" + category + ".png"
        }else{
          return "samples/images/" + category + ".png"
        }
        
      }
  
    function load() {
      myDiagram.model = go.Model.fromJson(document.getElementById("mySavedModel").value);
      $('#myPaletteDiv').next('div').css('overflow','hidden');  
    }
  
    // add an SVG rendering of the diagram at the end of this page
    function makeSVG() {
      var svg = myDiagram.makeSvg({
          scale: 1
        });
      svg.style.border = "1px solid black";
      obj = document.getElementById("SVGArea");
      obj.appendChild(svg);
      if (obj.children.length > 0) {
        obj.replaceChild(svg, obj.children[0]);
      }
    }
  
    function makeImage(){
      var img =  myDiagram.makeImage({
        scale: 1
      });
      img.style.border = "1px solid black";
      obj = document.getElementById("SVGArea");
      obj.appendChild(img);
      if (obj.children.length > 0) {
        obj.replaceChild(img, obj.children[0]);
      }
  
    }
    function performLinkValidation(fromNode, fromGraphObject, toNode, toGraphObject, link, maxOutboundLinks){
    var childrenLinks = fromNode.findTreeChildrenLinks();
        if (childrenLinks.count>maxOutboundLinks-1){
          return false;
        } else {
          return true;
        }
    }
    function commonNodeStyle() {
      return [
        {
          locationSpot: go.Spot.Center,
          selectionAdornmentTemplate: commandsAdornment  // shared selection Adornment
        },
        new go.Binding("location", "location", go.Point.parse).makeTwoWay(go.Point.stringify),
      ];
    }
    
  </script>


  </body>
</html>
