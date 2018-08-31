<?php
include_once('db.php');
error_reporting(E_ALL);

if($_REQUEST){
    
    $mode = $_REQUEST['mode'];
    
    switch ($mode) {

        case "user_list":
                $users_List = array();
                $query = mysqli_query($link, "SELECT id,user_name,concat(first_name,' ',last_name,' (',user_name,')') as name FROM `vtiger_users` WHERE deleted = 0 and status = 'Active' order by first_name ASC ");
                if(mysqli_num_rows($query) > 0)
                {
                    while($row = mysqli_fetch_array($query))
                    {
                        //$users_List[] = "'".$row['user_name']."'";
                        $users_List[] = trim($row['name']);
                    }
                }
                echo json_encode($users_List);
                //$string = implode(",", $users_List);
                //$data = "[".$string."]";
                //echo $data;
        break;
        case 'updateSortData':
            $processid = $_REQUEST['processid'];
            $sortData = $_REQUEST['sortData'];
            #sortid starts with 0
            foreach($sortData as $sortid=>$pid){                  
                 $q = "UPDATE vtiger_processflow_unitprocess SET  sequence =  $sortid +1 WHERE  unitprocessid = $pid";
                mysqli_query($link, $q);
            }
            echo json_encode(array('status'=>1, 'message'=>'Sortorder Updated Successfully')); 
            break;
        case 'get_process_details_for_sorting':
            $processid = $_REQUEST['processid'];
            $q = "SELECT pu.unitprocessid, concat(pb.processblocktypename,' - ',pu.description ) as title FROM vtiger_processflow_unitprocess pu left join vtiger_process_block_types pb on pu.blocktype = pb.processblocktypeid where pu.processmasterid = $processid ORDER BY pu.sequence ASC ";
            $result = mysqli_query($link, $q);
            $html = '';
            while($bdata = mysqli_fetch_assoc($result)){                      
                $html .= '<li class="ui-state-highlight" id="'.$bdata['unitprocessid'].'">'.$bdata['title'].'</li>';
            } 
           
            echo $html;
            break;
        
        case "upload":
            if(!empty($_FILES))
            {
                $filename = $_FILES['file']['name'];
                $type = $_FILES['file']['type'];
                $tmp_name = $_FILES['file']['tmp_name'];
                $size = $_FILES['file']['size'];

                $filename_arr = explode(".", $filename);
                $filename_name = $filename_arr[0]."-".time();
                $newfilename = $filename_name.".".end($filename_arr);
                $uploaddir = __DIR__.'/assets/objectimages/';
                $uploadfile = $uploaddir . basename($newfilename);

                if(move_uploaded_file($_FILES['file']['tmp_name'], $uploadfile)) {
                    echo $newfilename;
                } else {
                   echo 0;
                }
            }    
        break;

        case 'save':
            #materials
            $params = array();
            parse_str($_REQUEST['other_data'], $params); 
            $materials = json_encode($params['material']);
            
            #get Blocks data
            $q ="SELECT processblocktypeid,processblocktypename FROM vtiger_process_block_types";
            $result = mysqli_query($link, $q);
            $blocks = array();
            while($bdata = mysqli_fetch_assoc($result)){            
                $blocks[$bdata['processblocktypename']] = $bdata['processblocktypeid'];
            } 
            #end 

            $save_type = $_POST['savetype'];
            $process_data_json = $_POST['process_data'];

            $process_data = json_decode($process_data_json);
            $process_data = (array)$process_data;
            #if json data have special character return false
            /* $r = check_array_special_char_cleaner($process_data);
             
            if($r['status'] == 0){
                echo json_encode(array('status'=>0,'message'=>'Objects Content('.$r['content'].') have Special characters, please check and try again.'));
            }else{ */

                $processid = $_POST['processid'];
                $tasks = $process_data['nodeDataArray'];
                $process_links = $process_data['linkDataArray'];
                
                #insert Master process data 
                $title = $_POST['processFlowName'];
                $supervisor_roleid = $_POST['supervisorRole'];
                $operator_roleid = $_POST['operatorRole'];
                $sound_notifications = $_POST['sound_notifications'];
                $details = $_POST['details'];
                $machinery = $_POST['machinery'];
                $tools = $_POST['tools'];
                $vessels = $_POST['vessels'];
                $is_machinery = $_POST['is_machinery'];
                $is_tools = $_POST['is_tools'];
                $is_vessels = $_POST['is_vessels'];
                $id_end_product_category = $_POST['id_end_product_category'];
                #$materials = $_POST['materials'];
             
                    if($save_type == 'draft' && $processid == 0){
                        #is_draft :: 1 - draft , 0 - live
                        $sql = "INSERT INTO  vtiger_processmaster ( processmastername, max_concurrent, supervisor_roleid, operator_roleid, jsondata,date_of_added,is_draft,materials,vessels,tools,machinery,sound_notifications,details, is_vessels, is_tools, is_machinery, id_end_product_category) VALUES ('$title', '1', '$supervisor_roleid', '$operator_roleid', '$process_data_json',NOW(),1,'$materials','$vessels','$tools','$machinery','$sound_notifications','$details','$is_machinery','$is_vessels','$is_tools','$id_end_product_category')";
                        $result = mysqli_query($link, $sql);
                        $pm_id = mysqli_insert_id($link);

                    }elseif($save_type == 'draft' && $processid > 0){
                        #is_draft :: 1 - draft , 0 - live
                        $sql = "update vtiger_processmaster set processmastername = '$title',  supervisor_roleid = '$supervisor_roleid', operator_roleid = '$operator_roleid', jsondata='$process_data_json',is_draft=1,materials='$materials',vessels='$vessels',tools='$tools',machinery='$machinery', sound_notifications='$sound_notifications', details='$details', is_vessels='$is_vessels', is_tools='$is_tools',is_machinery='$is_machinery', id_end_product_category='$id_end_product_category' where processmasterid = $processid";
                        $result = mysqli_query($link, $sql);
                        $pm_id = $processid;

                        
                    }elseif($save_type == 'save' || $save_type == 'saveas'){
                        if( $processid == 0 || $save_type == 'saveas'){ 
                            $sql = "INSERT INTO  vtiger_processmaster ( processmastername, max_concurrent, supervisor_roleid, operator_roleid, jsondata,date_of_added,is_draft,materials,vessels,tools,machinery,sound_notifications,details, is_vessels, is_tools, is_machinery, id_end_product_category) VALUES ('$title', '1', '$supervisor_roleid', '$operator_roleid', '$process_data_json',NOW(),0,'$materials','$vessels','$tools','$machinery','$sound_notifications','$details','$is_machinery','$is_vessels','$is_tools','$id_end_product_category')";
                            $result = mysqli_query($link, $sql);
                            $pm_id = mysqli_insert_id($link);

                        }elseif( $processid > 0 && $save_type == 'save'){  
                            #is_draft :: 1 - draft , 0 - live
                            $sql = "update vtiger_processmaster set processmastername = '$title',  supervisor_roleid = '$supervisor_roleid', operator_roleid = '$operator_roleid', jsondata='$process_data_json',is_draft=0,materials='$materials',vessels='$vessels',tools='$tools',machinery='$machinery',sound_notifications='$sound_notifications',details='$details',is_vessels='$is_vessels',is_tools='$is_tools',is_machinery='$is_machinery',id_end_product_category='$id_end_product_category' where processmasterid = $processid";
                            $result = mysqli_query($link, $sql);
                            $pm_id = $processid;
                        }
                        $sequence = 0;
                        $diagram_crm_ids = array();
                    
                        foreach($tasks as $task)
                        { 

                            $task = (array)$task;
                            //if(array_key_exists("category",$task)){ /*Start,End */ }else{  $category = null;}
                            $category = $task['category'];
                            $text = $task['text'];
                            $key = $task['key'];             
                            if(array_key_exists("figure",$task)){ $figure = $task['figure'];/*Diamond */ }else{ $figure = null;}
                            $text = $task['text'];
                            $LearnerModeDetails = $task['LearnerModeDetails'];
                                
                            $blocktype = $blocks[$category]; 

                            $sequence++;
                            
                            $branching = '1'; 
                            $unitprocess_time = $task['processTime'];
                            
                            $customform = '';                   
                            
                            $snoozeInterval = 0;
                            if(isset($task['snoozeInterval'])){
                                $snoozeInterval = $task['snoozeInterval'];
                            }
                            $subblocktype = '';
                            if(isset($task['Product']) && strtolower($task['Product']) == 'yes'  ){
                                $subblocktype = 1;
                            }
                            $is_final_result = 0;
                            if(isset($task['IsFinalResult']) && strtolower($task['IsFinalResult']) == 'yes'  ){
                                $is_final_result = 1;
                            }
                            
                            $assignedto = NULL;
                            if(isset($task['AssignedTo'])){
                                $assignedto = explode("(",$task['AssignedTo']);
                                $assignedto = substr($assignedto[1], 0, -1);
                                #$assignedto = $task['AssignedTo'];
                            }

                            #custom form 
                            $fielddata = array(); 
                            $fielddata['html'] = array();
                            $fielddata['method'] = 'POST';
                            $fielddata['enctype'] = 'multipart/form-data';

                            if(isset($task['Fields']) && $task['Fields'] != ''){

                                $fielddata['html'][] = array('type'=>'p','html'=>'Enter the exact Data');                 
                            }
                            $i = 1;
                            if(isset($task['Fields']) && $task['Fields'] != ''){
                                #export string with comma separated fields
                                $fileds = explode(',',$task['Fields']);
                                foreach($fileds as $field){
                                    if(trim($field) != ''){
                                        $name = strtolower(str_replace(" ","_",$field)); 
                                        $fielddata['html'][] = array(
                                                                    "type"=>"div",
                                                                    "html" => array(
                                                                                'name'          => $name,
                                                                                'id'            => $name,
                                                                                'caption'       => $field,
                                                                                'type'          => 'text',
                                                                                'validate'      => array('required'=>true,'minlength'=>'2','messages'=> array('required'=>'Required input')),
                                                                                'placeholder'   => 'Enter value')
                                                                );
                                        $i++;
                                    }
                                } 
                            }
                            
                            if(isset($task['CheckboxFields']) && $task['CheckboxFields'] != ''){
                                #export string with comma separated fields
                                $CheckboxFields = explode(',',$task['CheckboxFields']);
                                foreach($CheckboxFields as $field){
                                    if(trim($field) != ''){
                                        $name = strtolower(str_replace(" ","_",$field)); 
                                        $fielddata['html'][] = array(
                                                                    "type"=>"div",
                                                                    "html" => array(
                                                                                'name'          => $name,
                                                                                'id'            => $name,
                                                                                'caption'       => $field,
                                                                                'type'          => 'checkbox'
                                                                            )
                                                                    );    
                                    }
                                } 
                            }
                            if($category == 'Document'){
                                $fielddata['html'][] = array(
                                    "type"=>"div",
                                    "html" => array(
                                                'name'          => 'upload_documents',
                                                'id'            => 'upload_documents',
                                                'caption'       => 'Upload Documents',
                                                'type'          => 'file'
                                            )
                                    );
                            } 

                            $customform = json_encode($fielddata); 
                            #end 
                            
                            $sql = "INSERT INTO  vtiger_processflow_unitprocess (               
                                processmasterid,prior_unitprocess,post_unitprocess,description,blocktype,subblocktype,branching,unitprocess_time,snoozeInterval,unitprocess_datablock,sequence,next_process,customicon,customform, is_final_result,diagramo_id,LearnerModeDetails,assignedto
                                )
                            VALUES (
                                '$pm_id',  '',  '',  '$text',  '$blocktype', '$subblocktype', '$branching',  '$unitprocess_time', '$snoozeInterval',  '0',  '$sequence', '0' ,  '',  '$customform','$is_final_result','$key','$LearnerModeDetails','$assignedto')"; 
                            $result = mysqli_query($link, $sql);
                            $lastid = mysqli_insert_id($link);
                            #array(diagram id => crm process id )
                            $diagram_crm_ids[$key] = array('crm_process_id'=>$lastid, 'type'=>$blocktype);

                        }  
                    
                        foreach($process_links as $process_link){ 
                            $process_link =(array)$process_link; 
                            $from = $process_link['from'];
                            $to = $process_link['to'];
                            
                            $previous_process =$diagram_crm_ids[$from]['crm_process_id'];
                            $next_process =$diagram_crm_ids[$to]['crm_process_id'];
                            #based on object type update next process for each  
                            switch($diagram_crm_ids[$from]['type']){ 
                                    
                                case '9': 
                                case '2': 
                                    #$q = "UPDATE  vtiger_processflow_unitprocess SET post_unitprocess = concat(ifnull(post_unitprocess,''),'') WHERE diagramo_id = $from and processmasterid = $pm_id";
                                    #mysqli_query($link, $q);
                                    $q = "UPDATE  vtiger_processflow_unitprocess SET post_unitprocess = concat(post_unitprocess, concat(',',$next_process))  WHERE diagramo_id = $from and processmasterid = $pm_id";
                                    mysqli_query($link, $q); 
                                    break;
                                default:
                                        $q = "UPDATE  vtiger_processflow_unitprocess SET next_process = $next_process  WHERE diagramo_id = $from and processmasterid = $pm_id";
                                    mysqli_query($link, $q);                             
                                        
                                break;

                            } 
                            #for Multi Action Block
                            if($diagram_crm_ids[$to]['type'] == 11){
                                $q = "UPDATE  vtiger_processflow_unitprocess SET post_unitprocess = concat(post_unitprocess, concat(',',$previous_process))  WHERE diagramo_id = $to and processmasterid = $pm_id";
                                mysqli_query($link, $q); 
                            }
                        }

                        #update order
                        $pfdataarray = json_decode(stripslashes(html_entity_decode($process_data_json)), true);
                        $pfdataarray = json_decode($process_data_json, true);
                        $nodearray = $pfdataarray['nodeDataArray'];
                        $nodekeyarray = Array();
                        foreach($nodearray as $key=>$val){
                            $nodekeyarray[$val['key']] = Array($val['category'],$val['text']);
                        }
                        $linkarray = $pfdataarray['linkDataArray'];

                        $id=0;
                        $unitprocessarray=Array();
                        buildunitprocess($unitprocessarray,  $nodekeyarray, $linkarray, $id, -1, 0);
                        uasort($unitprocessarray, function ($a, $b) { return $a['id'] - $b['id'];});
                        $blocktypes = Array('Action', 'Decision', 'Document', 'Notification', 'Approval', 'Timer', 'Start', 'Terminal', 'Branching', 'Counter', 'MultiAction');

                        $seq = 0;
                        foreach($unitprocessarray as $key=>$val){
                            $inward_links = pf_arraySearch($linkarray, 'to', $val['node']);
                            $outward_links = pf_arraySearch($linkarray, 'from', $val['node']);
                            $inward_ll = $outward_ll = Array();

                            foreach($inward_links as $ikey=>$ival){$inward_ll[]=$unitprocessarray[$ival['from']]['id'];}
                            foreach($outward_links as $okey=>$oval){$outward_ll[]=$unitprocessarray[$oval['to']]['id'];} 

                            //$unitprocessid	Auto increment
                            //$processmasterid	Set in earlier query
                            /*$prior_unitprocess = implode(',', $inward_ll); 
                            $post_unitprocess = implode(',', $outward_ll); 
                            $description = $val['text']; 
                            $blocktype = array_search ($val['category'],$blocktypes) + 1; 
                            $subblocktype = 0; 
                            $branching = count($outward_ll);
                            $unitprocess_time = 30; //
                            $snooze = 5; //
                            $unitprocess_datablock = null; //
                            $sequence = $val['id']; 
                            $next_process = 0; //
                            $customicon = null; //
                            $customform = null; //
                            $is_final_result = 0; //
                            $diagramo_id = $val['node']; 
                            $LearnerModeDetails = null; //
                            */
                            // $query="INSERT vtiger_processflow_unitprocess SET (processmasterid, prior_unitprocess, post_unitprocess, description, blocktype, subblocktype, branching, unitprocess_time, snooze, unitprocess_datablock, sequence, next_process, customicon, customform, is_final_result, diagramo_id, LearnerModeDetails) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
                            //$params=Array($processmasterid, $prior_unitprocess, $post_unitprocess, $description, $blocktype, $subblocktype, $branching, $unitprocess_time, $snooze, $unitprocess_datablock, $sequence, $next_process, $customicon, $customform, $is_final_result, $diagramo_id, $LearnerModeDetails);
                            $diagramo_id = $val['node'];
                            $q = "UPDATE  vtiger_processflow_unitprocess SET sequence = $seq  WHERE diagramo_id = '$diagramo_id' and processmasterid = $pm_id";
                        
                            mysqli_query($link, $q);
                            $seq++;
                        }

                    }else{
                        #update Process 
                        $pm_id = $processid;
                    }				  
                    echo json_encode(array('status'=>1,'processid'=>$pm_id,'message'=>'Updated Successfully'));
                
                
                
        break;       
    case 'deletePrcoess':
            $processid = $_REQUEST['processid'];
            $isactive = $_REQUEST['isactive'];
            $q = "UPDATE vtiger_processmaster SET is_deleted = $isactive WHERE processmasterid = $processid";
            mysqli_query($link, $q);        
            echo json_encode(array('status'=>1, 'message'=>'Process deleted Successfully.')); 
        break;
    }      
} 


function pf_arraySearch($array, $key, $value) {
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subarray) {
            $results = array_merge($results, pf_arraySearch($subarray, $key, $value));
        }
    }
    return $results;
}

function buildunitprocess(&$unitprocessarray, $nodes, $links,  &$rid, $nkey, $fkey){
    $currentnode = $nodes[$nkey];
    $lnode = pf_arraySearch($links, 'from', $nkey);
    switch($currentnode[0]){
        case "MultiAction":
            $mac_array[$nkey] = pf_arraySearch($links, 'to', $nkey);
            if (isset ($unitprocessarray[$nkey]['ma_from'])) {
                $ma_from = $unitprocessarray[$nkey]['ma_from'];
                $ma_from[] = $fkey;
            }else{
                $ma_from = Array($fkey);
            }
            $unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1], 'next'=>$lnode[0]['to'], 'ma_from'=>$ma_from);
            $allconnected = count($mac_array[$nkey]) == count($ma_from);
            if($allconnected){
                $rid++;
                $unitprocessarray[$nkey]['id'] = $rid;
                //echo "Unit Process# ".$rid." ($nkey)(".$lnode[0]['to'].") ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." next node ".$lnode[0]['to']." ma from ".implode(',',$unitprocessarray[$nkey]['ma_from'])."<br/>";
                buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lnode[0]['to'], $lnode[0]['from']);
            }
            break;

        case "Branching":
        case "Decision":
            foreach($lnode as $lkey=>$lval){
                if(!isset($unitprocessarray[$nkey])){
                    $rid++;
                    $unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1], 'next'=>$lval['to'], 'ma_from'=>Array());
                    //echo "Unit Process# ".$rid." ($nkey)(".$lval['to'].") ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." next node ".$lval['to']."<br/>";
                }
                $intable = pf_arraySearch($unitprocessarray, 'node', $lval['to']);
                if(count($intable)==0){
                    buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lval['to'], $lval['from']);
                } else {
                    if(in_array($intable[0]['category'], ['MultiAction', 'Terminal'])){
                        buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lval['to'], $lval['from']);
                    }
                }
            }
            break;

        case "Terminal":
            $term_array[$nkey] = pf_arraySearch($links, 'to', $nkey);
            if (isset ($unitprocessarray[$nkey]['ma_from'])) {
            $ma_from = $unitprocessarray[$nkey]['ma_from'];
            $ma_from[] = $fkey;
            }else{
            $ma_from = Array($fkey);
            }
            $unitprocessarray[$nkey] = array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1],  'ma_from'=>$ma_from);
            $allconnected = count($term_array[$nkey]) == count($ma_from);
            if($allconnected){
                $rid++;
                //echo "Unit Process# ".$rid." ($nkey) ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." ma from ".implode(',',$unitprocessarray[$nkey]['ma_from'])."<br/>";
                $unitprocessarray[$nkey] = array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1],  'ma_from'=>$ma_from);
            }
            break;

        default:
            $rid++;
            $unitprocessarray[$nkey] = array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1], 'next'=>$lnode[0]['to'], 'ma_from'=>array());
            //echo "Unit Process# ".$rid." ($nkey)(".$lnode[0]['to'].") ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." next node ".$lnode[0]['to']."<br/>";
            buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lnode[0]['to'], $lnode[0]['from']);
            break;
    }
}

function check_array_special_char_cleaner($data){
    $result = array('status'=>1,'content'=>'');
    if(is_array($data)|| is_object($data)){
        foreach($data as $key=>$value){
             
            if(is_array($value) || is_object($value)){ 
                $value = (array)$value;
                check_array_special_char_cleaner($value);
            }else{
                if(preg_match('/[\'\"]/', $value))
                {
                    $result = array('status'=>0,'content'=>$value);
                    break;
                }
            }
        }
    }
    return $result;
    
}