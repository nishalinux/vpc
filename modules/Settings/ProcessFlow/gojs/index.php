<?php 
  include_once('Processflow.php');                     
  $Processflow = new Processflow();
  $processflow_list = $Processflow->getProcessflowList();  
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
    <title>Process flow list</title>
    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.css" rel="stylesheet">
    <link href="assets/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
    <!--<link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css">-->
    <link rel="stylesheet" href="//cdn.datatables.net/1.10.16/css/dataTables.bootstrap.min.css">
    <style>
      #sortable { list-style-type: none; margin: 0; padding: 0; width: 100%; }
      #sortable li { margin: 0 5px 5px 5px; padding: 5px; font-size: 1.2em; height: 1.5em; }
      #sortable li { height: 2em; line-height: 1.2em; }
      .ui-state-highlight { height: 1.5em; line-height: 1.2em; }
      .a-btn{
        margin: 0 6px;
      }
      .pull-right {
          float: right !important;
          margin: 3px;
      }
      </style>
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
  <body style="background-color:#fafafb;"> 
    <div class="container-fluid" >
      <div class="row">
      
        <div class="col-xs-12 col-lg-12 col-sm-12" >
        <div class="form-group" style="margin-bottom:40px;">
        <a class="a-btn" href="add.php"><button type="button" class="btn btn-sm btn-primary pull-right">Add Process</button></a>
        <button type="button" class="btn btn-default pull-right btn-sm" data-toggle="modal" data-target="#exampleModal">Import Process</button>
        </div>
        <!-- Modal -->
        <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
          <div class="modal-dialog" role="document">
            <div class="modal-content">
              <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Import Process Flow</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                  <span aria-hidden="true">&times;</span>
                </button>
              </div>
              <form action="" id="importform" class="form-horizontal" method="POST"  enctype="multipart/form-data">
                <div id="fileuploadform">
                  <div class="modal-body">
                    <div class="panel-body">
                        <div class="col-md-12">              
                          <div class="form-group">
                              <label class="col-sm-4 control-label" for="importfile">Import CSV</label>
                            <div class="col-sm-8">
                              <input type="file" class="form-control input-sm" id="importfile" name="importfile" value="">
                            </div>
                          </div>
                        </div>
                    </div> 
                  </div>
                </div>

                <div class="container" id="materialform">
                
                </div>

                <input type="hidden" name="mode" id="mode" value="importfilemode">
                  <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal" id="importback">Close</button>
                    
                    <button type="button" name="submit" value="submit" id="filesubmit" class="btn btn-primary">Upload</button>
                  </div>
              </form>
            </div>
          </div>
        </div>
        <?php 
        
        
        if(isset($_POST['submit']))
        {
          if($_POST['submit'] == "submit" && !empty($_FILES['importfile']))
          {
            $Processflow->putImport($id);
          }
        } 

        ?>
        <table class="table table-bordered" id="idTblPList" style="background-color:#ffffff;">
          <thead>
              <tr>
                <th>#</th>
                <th>Process Master</th>
                <th>Status</th>
                <th>Date</th>
                <th>Supervisor</th>
                <th>Operator</th>
                <th>Actions</th>
              </tr>
          </thead>
          <tbody>
            
            <?php $i=1;foreach($processflow_list as $pid => $pdata){ ?>
              <tr>
                <th scope="row"><?php echo $i;?></th>
                <td><?php echo $pdata['processmastername'];?></td>
                <td><?php echo ($pdata['is_draft'] ==1)?'Draft':'Live';?></td>
                <td><?php echo $pdata['date_of_added'];?></td>
                <td><?php echo $pdata['supervisor'];?></td>
                <td><?php echo $pdata['operator'];?></td>
                <td>
                    <?php if($pdata['is_draft'] ==1){ ?>
                    <a title="Edit Process"  href="add.php?id=<?php echo $pid;?>&draft=<?php echo $pdata['is_draft'];?>"><span class="glyphicon glyphicon-pencil" aria-hidden="true"></span></a>
                    
                    <?php }elseif($pdata['is_draft'] == 0){ ?> 

                      <a title="Sort Process" href="#"><span class="glyphicon glyphicon-tasks openBtn" data-id="<?php echo $pdata['processmasterid'];?>" aria-hidden="true"></span></a> 
                      <a title="View Process"  href="add.php?id=<?php echo $pid;?>&draft=<?php echo $pdata['is_draft'];?>"><span class="glyphicon glyphicon-eye-open" aria-hidden="true"></span></a>
                      
                    <?php }  
                      if($pdata['is_deleted'] == 0 && $pdata['is_draft'] == 0)
                      {
                        ?>
                        <a title="Make it In-active"  href="#"><span class="deleteProcess" data-isactive="1" data-id="<?php echo $pdata['processmasterid'];?>"  data-pname="<?php echo $pdata['processmastername'];?>" aria-hidden="true">Active</span></a>
                        <?php
                      }
                      if($pdata['is_deleted'] == 1 && $pdata['is_draft'] == 0)
                      {
                        ?>
                        <a title="Make it Active"  href="#"><span class="deleteProcess" style="color:red;"  data-isactive="0" data-id="<?php echo $pdata['processmasterid'];?>"  data-pname="<?php echo $pdata['processmastername'];?>" aria-hidden="true">InActive</span></a>
                        <?php
                      }
                      ?>
                      <a title="Export Process" href="export.php?action=exportdata&id=<?php echo $pdata['processmasterid'];?>"><span class="" aria-hidden="true"><span class="glyphicon glyphicon-cloud-download"></span></span></a>
                    </td>
              </tr>
            <?php $i++;} ?>
          </tbody>
        </table> 

              <!-- Modal -->
              <div class="modal fade" id="myModal" role="dialog">
                  <div class="modal-dialog">
                      <!-- Modal content-->
                      <div class="modal-content">
                          <div class="modal-header">
                              <button type="button" class="close" data-dismiss="modal">&times;</button>
                              <h4 class="modal-title" id="idModelTitle">Processes Sorting</h4>
                          </div>
                          <div class="modal-body" id="idModelBody">
                            <ul id="sortable" class="connectedSortable ui-sortable">
                            </ul>
                          </div>
                          <div class="modal-footer">
                              <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button>
                              <button type="button" class="btn btn-success saveSortOrder">Save changes</button>
                          </div>
                      </div>
                  </div>
              </div>
        </div>                
      </div><!--/row--> 
    </div><!--/.container-->
    

    <!-- Bootstrap core JavaScript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster 
    <script src="assets/js/jquery.js"></script>-->
    <script src="//code.jquery.com/jquery-1.9.1.js"></script> 
    <script src="//cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> 
    <script src="//cdn.datatables.net/1.10.16/js/dataTables.bootstrap.min.js"></script> 
   
    <script src="assets/js/bootstrap.min.js"></script>
    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug 
    <script src="assets/js/ie10-viewport-bug-workaround.js"></script>-->
    <script src="assets/js/offcanvas.js"></script>
    
    <script src="//code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    
    <script src="assets/js/bootbox.min.js"></script>
    

    <script>
    $(document).ready(function(){
       
    $('#idTblPList').DataTable({ "pageLength": 25 });

      //Sorting
      $('.openBtn').on('click',function(){
        var processid = $(this).data('id');
        var grpdata = {
              'processid':processid,
              'mode':'get_process_details_for_sorting'               
            }; 
        var data = $.param(grpdata);
          $.ajax({        
              url : 'ajax.php',
              type : 'POST',
              dataType: "html",
              data : data,
              success : function(data) {
                  $('#sortable').html(data);
                  $('#myModal').modal({show:true});
              },
              error : function(request,error)
              {
                  console.log(error);
              }
          });   
    });

    /* Active/in-active Process */    
    $('.deleteProcess').on('click',function(){
        var isactive = $(this).data('isactive');
        var processid = $(this).data('id');
        var processname = $(this).data('pname');
        if(isactive == 1){var ptype = 'In-Active'; }else{ var ptype = 'Active'; } 
        bootbox.confirm({
            message: "Are you sure u want to Make it "+ ptype +" '"+ processname +"!' Process",
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
                var grpdata = {
                      'processid':processid,
                      'isactive':isactive,
                      'mode':'deletePrcoess'               
                    }; 
                var data = $.param(grpdata);
                  $.ajax({        
                      url : 'ajax.php',
                      type : 'POST',
                      dataType: "html",
                      data : data,
                      success : function(data) {
                        if(isactive == 1){var ptype = 'inactivated'; }else{ var ptype = 'activated'; } 
                        bootbox.alert("Successfully  '"+ processname +"!' Process "+ ptype);
                          location.reload();
                      },
                      error : function(request,error)
                      {
                          console.log(error);
                      }
                  }); 
              }
            }
        }); 
         
    });

    $('.saveSortOrder').on('click', function (e) {
        var processSortOrder = $("#sortable").sortable("toArray");
         
        var processid = $(this).data('id');
        var grpdata = {
              'processid':processid,
              'mode':'updateSortData',
              'sortData' : processSortOrder              
            }; 
        var data = $.param(grpdata);
          $.ajax({        
              url : 'ajax.php',
              type : 'POST',
              dataType: "html",
              data : data,
              success : function(data) {
                bootbox.alert('Sortorder Updated Successfully');
                $('#myModal').modal('hide')
              },
              error : function(request,error)
              {
                  console.log(error);
              }
          });   

        
     })
    $( "#sortable" ).sortable({
      connectWith: ".connectedSortable"
    }).disableSelection();

      $('#idDate').datepicker({
        maxDate: '0',
        dateFormat : 'dd/mm/yy'
      });
      $('#idDate').datepicker().datepicker('setDate','today');

      
            
      $( "#idBatch, #idDate, #idCollege" ).change(function(){
          var batch = $('#idBatch').val();
          var date =  $('#idDate').val();
          var college =  $('#idCollege').val(); 

          if(batch != '' && date != '' && college != ''){
            var grpdata = {
                'training_batch' : batch,
                'date': date,
                'college_id':college,
                'mode':'getStudentListHtmls'               
            }; 
            var data = $.param(grpdata);
              $.ajax({        
                  url : 'ajax.php',
                  type : 'POST',
                  dataType: "html",
                  data : data,
                  success : function(data) {
                      $('#idDivStudentData').html(data);
                  },
                  error : function(request,error)
                  {
                      console.log(error);
                  }
              });          
          }
      });

     
      $("#filesubmit").click(function(){
        var myform = document.getElementById("importform");
        var importfile = $("#importfile").val();
        if(importfile == "")
        {
          bootbox.alert("Please select File csv");
          return false;
        }
        var data = new FormData(myform);

        
          $.ajax({        
            url : 'importajax.php',
            type : 'POST',
            dataType: "html",
            data : data,
            processData: false,
            contentType: false,
            success : function(data) {
                 
                $("#materialform").html(data);
                $("#mode").val("importmapdata");
                $('#materialform').show();
                $("#fileuploadform").hide();
            },
            error : function(request,error)
            {
                console.log(error);
            }
          });
        
        $("#importback").click(function(){
          $("#materialform").hide();
          $("#mode").val("importfilemode");
          $("#fileuploadform").show();
        });
      });
    });
    </script>
  </body>
</html>
