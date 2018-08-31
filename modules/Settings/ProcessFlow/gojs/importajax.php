<?php 
include_once('db.php'); 
include_once('Processflow.php');                     
$Processflow = new Processflow();

$rolesdata = $Processflow->getRoles();  
$pc = $Processflow->getProducts(); 
$assects = $Processflow->getAssetsList();

if($_REQUEST){
    $mode = $_REQUEST['mode'];
    
    switch ($mode) {

        case "importfilemode":

            $filename = $_FILES['importfile']['name'];
            $filetype = $_FILES['importfile']['type'];
            $file_tmp_name = $_FILES['importfile']['tmp_name'];
            $filesize = $_FILES['importfile']['size']; 
            
            $ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
            if($ext==".csv")
            {
            $file = fopen($file_tmp_name, "r");
			$count = 0;
                while (($emapData = fgetcsv($file, 4096)) !== FALSE)
                {
					if($count > 0 && $count < 2)
					{  ?>
                    <div class="col-sm-6">
                        <div class="" id="fieldmapping-form">
                        <table class="table table-striped">
                            <thead>
                            <tr>
                                <th scope="col">Field</th>
                                <th scope="col">Old Values</th>
                                <th scope="col">New Values</th>
                                <th scope="col">Quantity</th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr>
                                <td><b>Supervisor Role</b></td>
                                <td><?php echo $emapData[3];?></td>
                                <td><div class="form-group">
                                <div class="col-sm-12">
                                <select class="form-control input-sm" id="idSupervisorRole" name='supervisorRole' required> 
                                    <option value=''>Select</option>
                                    <?php foreach($rolesdata as $roleid=>$rolename){?>
                                    <option value='<?php echo $roleid;?>' ><?php echo $rolename;?></option>
                                <?php }?>  
                                </select>
                                </div>
                            </div></td>
                            <td></td>
                            </tr>
                            <tr>
                                <td><b>Operator Role</b></td>
                                <td><?php echo $emapData[4];?></td>
                                <td>
                                <div class="form-group">
                                <div class="col-sm-12">
                                    <select class="form-control input-sm" id="idOperatorRole" name='operatorRole' required>
                                    <option value=''>Select</option> 
                                    <?php foreach($rolesdata as $roleid=>$rolename){?>
                                        <option value='<?php echo $roleid;?>' ><?php echo $rolename;?></option>
                                    <?php }?>               
                                    </select>
                                </div>
                                </div>
                                </td>
                                <td></td>
                            </tr>
                            <?php 
                            if(!empty($emapData[7]))
                            {
								$materials = $emapData[7];
								$material_id_arr = json_decode(stripslashes(html_entity_decode($materials)), true);
                                for($i=0; $i<count($material_id_arr); $i++)
                                {
                                    ?>
                                    <tr>
                                        <td><b>Materials</b></td>
                                        <td><?php echo $material_id_arr[$i]['materialid'];?></td>
                                        <td>
                                        <div class="form-group">
                                        <div class="col-sm-12">
                                             <select class="form-control input-sm " id="idMaterials"  name="materials[]" >       
                                            <option value=''>Select</option>               
                                            <?php 
                                            
                                            for($p=0;$p<count($pc); $p++){?>
                                                <option value='<?php echo $pc[$p]['productid'];?>' <?php if($pc[$p]['productid'] == $material_id_arr[$i]['materialid']){?>selected="selected"<?php }?>>

                                                <?php echo $pc[$p]['productname'];?>

                                            </option>
                                            <?php }?>           
                                            </select>
                                        </div>
                                        </div>
                                        </td>
                                        <td><input type="number" name="material_qty[]" class="col-sm-6" value="<?php if(!empty($material_id_arr)){ echo $material_id_arr[$i]['qty']; }?>" placeholder="Please Enter Quantity"></td>
                                    </tr>
                                    <?php
                                }
                            }
                            ?>
                            
                           <?php 
                           if(!empty($emapData[8]))
                           {
                                $vessels = $emapData[8];
								$vessels_id_arr = explode(",", $vessels);
                                for($vs=0; $vs<count($vessels_id_arr); $vs++)
                                {
                                    ?>
                                    <tr>
                                        <td><b>Vessels</b></td>
                                        <td><?php echo $vessels_id_arr[$vs];?></td>
                                        <td>
                                        <div class="form-group">
                                        <div class="col-sm-12">
                                        <select class="form-control input-sm" id="idVessels" name="vessels[]">     
                                        <option value=''>Select</option>                
                                            <?php 
                                            foreach($assects as $aid=>$aname){?>
                                            <option value='<?php echo $aid;?>' ><?php echo $aname;?></option>
                                        <?php }?>               
                                        </select>
                                        </div>
                                    </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php
                                }
                           }
                           ?>
                            
                            <?php 
                           if(!empty($emapData[9]))
                           {
								$tools = $emapData[9];
								$tools_id_arr = explode(",", $tools);
                                for($ts=0; $ts<count($tools_id_arr); $ts++)
                                {
                                    ?>
                                    <tr>
                                        <td><b>Tools</b></td>
                                        <td><?php echo $tools_id_arr[$ts];?></td>
                                        <td>
                                        <div class="form-group">
                                        <div class="col-sm-12">                
                                        <select class="form-control input-sm " id="idTools"  name="tools[]">         
                                        <option value=''>Select</option>         
                                            <?php 
                                            foreach($assects as $aid=>$aname){?>
                                            <option value='<?php echo $aid;?>' ><?php echo $aname;?></option>
                                        <?php }?>               
                                        </select>
                                        </div>
                                    </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php 
                                }
                            }
                            ?>
                            
                            <?php 
                           if(!empty($emapData[10]))
                           {
								$machinery = $emapData[10];
                                $machinery_id_arr = explode(",", $machinery);
                                for($ms=0; $ms<count($machinery_id_arr); $ms++)
                                {
                                    ?>
                                    <tr>
                                        <td><b>Machinery</b></td>
                                        <td><?php echo $machinery_id_arr[$ms];?></td>
                                        <td>
                                        <div class="form-group">
                                            <div class="col-sm-12">
                                            <select class="form-control input-sm " id="idMachinery" name="machinery[]">    
                                            <option value=''>Select</option>                
                                                <?php 
                                                foreach($assects as $aid=>$aname){?>
                                                <option value='<?php echo $aid;?>' ><?php echo $aname;?></option>
                                            <?php }?>               
                                            </select>
                                            </div>
                                        </div>
                                        </td>
                                        <td></td>
                                    </tr>
                                    <?php 
                                }
                            }        
                            ?>

                            </tbody>
                        </table>
                        </div>
                        </div>
                    <?php
					}
					$count++;
                }
            fclose($file);
            //echo "CSV File has been successfully Imported.";
            }   
            else {
                echo "Error: Please Upload only CSV File";
            }

        break;

        case 'importmapdata' :
            if(!empty($_POST) && !empty($_FILES))
            {
                $filename = $_FILES['importfile']['name'];
                $filetype = $_FILES['importfile']['type'];
                $file_tmp_name = $_FILES['importfile']['tmp_name'];
                $filesize = $_FILES['importfile']['size']; 
                
                $ext=substr($filename,strrpos($filename,"."),(strlen($filename)-strrpos($filename,".")));
                if($ext==".csv")
                {
                    $file = fopen($file_tmp_name, "r");
                    $excount = 0;
                    while (($emapData = fgetcsv($file, 4096)) !== FALSE){
                        if($excount > 0 && $excount < 2)
                        {
                            $processmastername = $emapData[1];
                            $max_concurrent = $emapData[2];
                            $supervisor_roleid = $Processflow->getSupervisiorRoleId($emapData[3]);
                            $operator_roleid = $Processflow->getSupervisiorRoleId($emapData[4]);
                            $sound_notifications = $emapData[5];
                            $details = $emapData[6];
                            $process_data_json = $emapData[15];

                            $materials = $_POST['materials'];
                            $material_qty = $_POST['material_qty'];
                            if(!empty($materials))
                            {
                                $materials_arr = array();
                                for($ms=0; $ms<count($materials); $ms++)
                                {
                                    if($materials[$ms] != "")
                                    {
                                        $materials_arr[] = array("materialid" => $materials[$ms], "qty" => $material_qty[$ms]);
                                    }
                                }
                                $materials_json = json_encode($materials_arr);
                            }

                            $vessels = $_POST['vessels'];
                            if(!empty($vessels))
                            {
                                $vessels_arr = array();
                                for($vs=0; $vs<count($vessels); $vs++)
                                {
                                    if($vessels[$vs] != "")
                                    {
                                        $vessels_arr[] = $vessels[$vs];
                                    }
                                }
                                $vessels_json = implode(",", $vessels_arr);
                            }

                            $tools = $_POST['tools'];
                            if(!empty($tools))
                            {
                                $tools_arr = array();
                                for($ts=0; $ts<count($tools); $ts++)
                                {
                                    if($tools[$ts] != "")
                                    {
                                        $tools_arr[] = $tools[$ts];
                                    }
                                }
                                $tools_json = implode(",", $tools_arr);
                            }

                            
                            $machinery = $_POST['machinery'];
                            if(!empty($machinery))
                            {
                                $machinery_arr = array();
                                for($mh=0; $mh<count($machinery); $mh++)
                                {
                                    if($machinery[$mh] != "")
                                    {
                                        $machinery_arr[] = $machinery[$mh];
                                    }
                                }
                                $machinery_json = implode(",", $machinery_arr);
                            }

                            $importsql = "INSERT INTO  vtiger_processmaster ( processmastername, max_concurrent, supervisor_roleid, operator_roleid, jsondata,date_of_added,is_draft,materials,vessels,tools,machinery,sound_notifications,details) VALUES ('$processmastername', '$max_concurrent', '$supervisor_roleid', '$operator_roleid', '$process_data_json',NOW(),1,'$materials_json','$vessels_json','$tools_json','$machinery_json','$sound_notifications','$details')";
                            $importresult = mysqli_query($link, $importsql);
                            $result_id = mysqli_insert_id($link);
                            echo "Imported Successfully click back for List " ?><a href="index.php">back</a><?php 
                        }
                    $excount++;
                    }

                }   
                else {
                     
                }
            
            }    
        
        break;

                
    }      
}

?>