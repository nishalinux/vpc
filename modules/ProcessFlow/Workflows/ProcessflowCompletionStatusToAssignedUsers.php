<?php

include_once 'modules/Users/Users.php';
require_once 'modules/Emails/class.phpmailer.php';
require_once 'modules/Emails/mail.php';

function ProcessflowCompletionStatusToAssignedUsers($entity){

    global $adb;
    //$adb->setDebug(true);
    //ini_set('display_errors','on'); version_compare(PHP_VERSION, '5.5.0') <= 0 ? error_reporting(E_WARNING & ~E_NOTICE & ~E_DEPRECATED) : error_reporting(E_ALL & ~E_NOTICE & ~E_DEPRECATED & ~E_STRICT);   // DEBUGGING
	$vtiger_data = $entity->data;   
    $vtiger_data = (array)$vtiger_data; 
    
	$id = $vtiger_data['id'];
	$id = explode('x',$id);
	$pfid = $id[1];
	$CreatedTime = $vtiger_data['CreatedTime'];
    $process_master_id = $vtiger_data['processmasterid'];
	$assigned_user_id = explode('x',$vtiger_data['assigned_user_id']);
    $userid = $assigned_user_id[1];
    
    
    //username, get emailid and fullname from users table using username

    
    $i=0;
    $assigned_arr = array();
    global $HELPDESK_SUPPORT_EMAIL_ID, $site_URL;

    #ger From email things 
    $query = "select from_email_field,server_username from vtiger_systems where server_type=?";
    $params = array('email');
    $result = $adb->pquery($query,$params);
    $from = $adb->query_result($result,0,'from_email_field');
    if($from == '') {$from =$adb->query_result($result,0,'server_username'); }
    #end 

    # get all assignee (AssignedTo) from vtiger_processflow_unitprocess using processmasterid
    $q = "select  distinct u.email1 as email from vtiger_processflow_unitprocess  pfu  left join vtiger_users u on u.user_name =pfu.assignedto where pfu.processmasterid= ? ";
    $emailresult = $adb->pquery($q,array($process_master_id));
    while($email_data = $adb->FetchByAssoc($emailresult))
    {
        $email[] = $email_data['email'];
    }  
    #process information of table
    $process_data = "SELECT p.processflowid, p.processflowname, pm.processmastername, pm.materials,b.blocktype_icon,pui.start_time,pui.end_time,pui.process_status, pui.process_instanceid,pu.description as process_title, pu.blocktype,pu.unitprocess_time,pui.unit_instance_data as process_values, usb.user_name as started_by, ueb.user_name as ended_by, r.rolename FROM vtiger_processflow_unitprocess_instance pui left join vtiger_processflow_unitprocess pu on pui.unitprocessid = pu.unitprocessid left join vtiger_process_block_types b on b.processblocktypeid = pu.blocktype left join vtiger_processmaster pm on pm.processmasterid = pu.processmasterid left join vtiger_processflow p on p.processflowid = pui.process_instanceid left join vtiger_users usb on pui.started_by = usb.id left join vtiger_users ueb on pui.ended_by = ueb.id left join vtiger_role r on pm.supervisor_roleid = r.roleid where pui.process_instanceid = ? order by pu.sequence";
    $processresult = $adb->pquery($process_data,array($pfid));
    #----------------------------

    #used products details information for table
    $products_query = "SELECT pg.gridtype, pg.prasentqty, pg.issuedqty, pg.issuedby, prd.productname, CONCAT(first_name,' ',last_name) as fullname FROM `vtiger_processflow_grids` pg left join vtiger_products prd ON prd.productid = pg.productid left join vtiger_users us on pg.issuedby = us.id WHERE pg.processflowid = ? ORDER BY pg.productid DESC ";
    $productsresult = $adb->pquery($products_query,array($pfid));
    $used_products = "<table style='font-family: arial, sans-serif;border-collapse: collapse;width: 100%;'><tr style='background-color: #ea6153;color:#fff;'><th style='border: 1px solid #ea6153;text-align: left;padding: 8px;'>Grid</th><th style='border: 1px solid #ea6153;text-align: left;padding: 8px;'>Product Name</th><th style='border: 1px solid #ea6153;text-align: left;padding: 8px;'>Present Qty</th><th style='border: 1px solid #ea6153;text-align: left;padding: 8px;'>Issued Qty</th><th style='border: 1px solid #ea6153;text-align: left;padding: 8px;'>Issued By</th></tr>";
    while($product_arr = $adb->FetchByAssoc($productsresult))
    { 
        if($product_arr['productname'] != "")
        {
            $used_products .= " <tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>".$product_arr['gridtype']."</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>".$product_arr['productname']."</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>".$product_arr['prasentqty']."</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>".$product_arr['issuedqty']."</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>".$product_arr['fullname']."</td></tr>";
        }
    }
    $used_products .= "</table>";
    #-----------------------------------------

    #processflow header information query
    $process_info_query = "SELECT p.processflowname, pui.end_time, usb.user_name as started_by,r.rolename FROM vtiger_processflow_unitprocess_instance pui left join vtiger_processflow_unitprocess pu on pui.unitprocessid = pu.unitprocessid left join vtiger_process_block_types b on b.processblocktypeid = pu.blocktype left join vtiger_processmaster pm on pm.processmasterid = pu.processmasterid left join vtiger_processflow p on p.processflowid = pui.process_instanceid left join vtiger_users usb on pui.started_by = usb.id left join vtiger_role r on pm.supervisor_roleid = r.roleid where pui.process_instanceid = ? order by pu.sequence";
    $process_info_result = $adb->pquery($process_info_query,array($pfid));
    $process_info_arr = $adb->fetch_array($process_info_result);
    #------------------------------

    #created products information query.
    $product_crtd_info_query = "SELECT prd.productname, pph.product_quantity FROM vtiger_processflow_unitprocess pui left join vtiger_processflow_product_history pph on pui.unitprocessid = pph.unitprocessid left join vtiger_products prd ON prd.productid = pph.productid where pui.unitprocessid = ?";
    $product_crtd_info_query_result = $adb->pquery($product_crtd_info_query,array($pfid));
    $product_crtd_info_query_result_arr = $adb->fetch_array($product_crtd_info_query_result);
    $created_products = "";
    if(!empty($product_crtd_info_query_result_arr))
    {
        $created_products .="<h3>created Product : ".$product_crtd_info_query_result_arr['productname']." </h3><h3>Qty : ".$product_crtd_info_query_result_arr['product_quantity']."</h3> ";
    }
    #-----------------------------------
    

    $message = "<html><body><div style='margin-left: 15px;padding: 10px 0px;'><h3 style=''>Hi ".$process_info_arr['processflowname']." Team</h3><h3 style=''>".$process_info_arr['processflowname']." is completed with ".$process_info_arr['end_time']."</h3><h3 style=''>used :</h3>$used_products<div>$created_products</div><h3>Supervise Name : ".$process_info_arr['rolename']."</h3></div>";
    $i=0;
    while($process_arr = $adb->FetchByAssoc($processresult))
    {
        $processflowid = $process_arr['processflowid'];
        $process_title = $process_arr['process_title'];
        //$blocktype_icon = $site_URL.'/assets/icons/'.$process_arr['blocktype_icon'];
        $blocktype_icon = "https://system.theracanncorp.com/assets/icons/".$process_arr['blocktype_icon'];
        $start_time = $process_arr['start_time'];
        $end_time = $process_arr['end_time'];
        $process_status = $process_arr['process_status'];
        $processflowname = $process_arr['processflowname'];
        $processmastername = $process_arr['processmastername'];
        $rolename = $process_arr['rolename'];
        switch($process_status){
            case '0' : 
                $process_status = "Not started";
                $style = "font-size: 20px;color: #000;border: 4px solid #dddddd;border-radius: 5px;";
            break;
            case '1' : 
                $process_status = "started";
                $style = "font-size: 20px;color: #f89406;border: 4px solid #f89406;border-radius: 5px;";
            break;
            case '2' : 
                $process_status = "Completed";
                $style = "font-size: 20px;color: #356635;border: 4px solid #356635;border-radius: 5px;";
            break;
            case '3' : 
                $process_status = "Interupted";
                $style = "font-size: 20px;color: #49afcd;border: 4px solid #49afcd;border-radius: 5px;";
            break;
            case '4' : 
                $process_status = "Waiting for Branch Process";
                $style = "font-size: 20px;color: #0088cc;border: 4px solid #0088cc;border-radius: 5px;";
            break;
            case '5' : 
                $process_status = "Aborted";
                $style = "font-size: 20px;color: #f44336;border: 4px solid #f44336;border-radius: 5px;";
            break;
        }

        $started_by = $process_arr['started_by'];
        $ended_by = $process_arr['ended_by'];
        $process_values = $process_arr['process_values'];
        $blocktype = $process_arr['blocktype'];
        $unitprocess_time = $process_arr['unitprocess_time'];

        

        				 
        $message .= "<div style=''><table style='font-family: arial, sans-serif;border-collapse: collapse;width: 100%;'><tr style='$style'><th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Process Title</th><th style='border: 1px solid #dddddd;text-align: left;padding: 8px;'><img src='".$blocktype_icon."' style='margin-right: 15px;margin-bottom: -6px;'>".$process_arr['process_title']."</th></tr><tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Start Time</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>$start_time</td></tr><tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>End Time</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>$end_time</td></tr><tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Process Status</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>$process_status</td></tr><tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Started By</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>$started_by</td></tr><tr><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>Ended By</td><td style='border: 1px solid #dddddd;text-align: left;padding: 8px;'>$ended_by</td></tr></table></div><br>";

        $i++;
    }
    $message .= "</body></html>";
    //echo $message;//exit;
        # use below code
            $subject ='Tasks to Review';
            $headers = "From:  ". $from ."\r\n";
            $headers .= "Reply-To: ". $from ."\r\n";
            $headers .= "CC: viratv@vtigress.com\r\n";
            $headers .= "MIME-Version: 1.0\r\n";
            $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
            	 		
            
            $mail = new PHPMailer();
            setMailerProperties($mail,$subject, $message, $from, $PF_name.' Team', $email); 
            $status = MailSend($mail);
            //echo $message;echo $status;exit;
            #end
    #prepare mail contane : Process flow name,  process master name , all process names along with start and end date and time  process formdata 
    #send email  to each user 
}
?>