<?php  
include_once('db.php');
class Processflow
{
     
    public function __construct() {
        global $link;
        $this->link=$link;
    }

    public function getProcessflowList()
    { 
        $sql = "SELECT p.processmasterid,p.is_draft,p.processmastername,p.date_of_added,p.is_deleted, sr.rolename as supervisor, op.rolename as operator FROM vtiger_processmaster p LEFT JOIN vtiger_role sr ON  p.supervisor_roleid = sr.roleid LEFT JOIN vtiger_role op ON p.operator_roleid = op.roleid  where p.is_deleted = 0 ORDER BY p.processmasterid  DESC " ;
        $result = mysqli_query($this->link, $sql);
        $process_list = array();
        while($row = mysqli_fetch_array($result)){  
           
            $process_list[$row['processmasterid']] = $row;                      
        } 
        return $process_list;
    }   
    public function assignedToUsersList()
    {
        $users_List = array();
        $query = mysqli_query($this->link, "SELECT user_name FROM `vtiger_users` WHERE deleted = 0 and status = 'Active' ");
        if(mysqli_num_rows($query) > 0)
        {
            while($row = mysqli_fetch_array($query))
            {
                $users_List[] = $row['user_name'];
            }
        }
        /*$string = implode(",", $users_List);
        $data = "[".$string."]";*/
        return $users_List;
    }
    function getProcessflowFromId($id){
        $sql = "SELECT * FROM vtiger_processmaster where processmasterid = $id " ;
        $result = mysqli_query($this->link, $sql);        
        $row = mysqli_fetch_assoc($result);
        return $row;
    }

    function getRoles(){
        $q ="SELECT roleid,rolename FROM `vtiger_role`";
        $result = mysqli_query($this->link, $q);        
        $roles_list = array();
        while($row = mysqli_fetch_array($result)){  
           
            $roles_list[$row['roleid']] = $row['rolename'];                      
        } 
        return $roles_list;
    }
    function getProductCategoryList(){
        $q ="SELECT productcategoryid,productcategory FROM vtiger_productcategory ORDER BY sortorderid ASC";
        $result = mysqli_query($this->link, $q);        
        $pc_list = array();
        while($row = mysqli_fetch_array($result)){  
           
            $pc_list[$row['productcategoryid']] = $row['productcategory'];                      
        } 
        return $pc_list;
    }

    function getProducts(){
        
            $q ="SELECT p.productid,p.productname,p.usageunit FROM vtiger_products p left join vtiger_crmentity c on p.productid = c.crmid where c.deleted =0";
            $result = mysqli_query($this->link, $q);        
            $pc_list = array();
            while($row = mysqli_fetch_array($result)){  
               //$pc_list[$row['productid']] = htmlentities($row['productname']);                      
               $pc_list[] =  $row;                    
            } 
            return $pc_list;
    }

    function getAssetsList(){
        $q =" SELECT a.assetname,a.assetsid FROM vtiger_assets a left join vtiger_crmentity c on a.assetsid = c.crmid where c.deleted = 0 ";
        $result = mysqli_query($this->link, $q);        
        $assets_list = array();
        while($row = mysqli_fetch_array($result)){  
           
            $assets_list[$row['assetsid']] = $row['assetname'];                      
        } 
        return $assets_list;
    }

    

    function getExport($id)
    {
        ob_clean();
        global $dbconfig;
        $db_name = $dbconfig['db_name'];
        
        $filename = "processflow_".time().".csv";
        $fp = fopen('php://output', 'w+');

        $query = "SELECT COLUMN_NAME FROM INFORMATION_SCHEMA.COLUMNS WHERE TABLE_SCHEMA='$db_name' AND TABLE_NAME='vtiger_processmaster'";
        $result = mysqli_query($this->link,$query);
        while ($row = mysqli_fetch_row($result)) {
            $header[] = $row[0];
        }	
        fputcsv($fp, $header);
        

        $query = "SELECT * FROM vtiger_processmaster WHERE processmasterid='$id'";
        $result = mysqli_query($this->link, $query);
        while($row = mysqli_fetch_row($result)) {

            $processmasterid = $row[0];
            $processmastername = $row[1];
            $max_concurrent = $row[2];
            $supervisor_roleid = $this->getSupervisiorRole($row[3]);
            $operator_roleid = $this->getSupervisiorRole($row[4]);
            $sound_notifications = $row[5];
            $details = $row[6];

            $materials_json = $row[7];
            $material_id_arr = json_decode(stripslashes(html_entity_decode($materials_json)), true); 
            $materials = "";
            if(!empty($material_id_arr))
            {
                $materials = array();
                for($ms=0; $ms<count($material_id_arr); $ms++)
                {
                    $materialid = $material_id_arr[$ms]['materialid'];
                    $material_name = $this->getMaterials($materialid);
                    $materials[] = array("materialid"=>$material_name, "qty" => $material_id_arr[$ms]['qty']);
                }
                $materials = json_encode($materials); 
            }

            $vessels_json = $row[8];
            $vessels_id_arr = explode(",", $vessels_json);
            $vessels = "";
            if(!empty($vessels_id_arr))
            {
                $vessels = array();
                for($vs=0; $vs<count($vessels_id_arr); $vs++)
                {
                    $vesselsid = $vessels_id_arr[$vs];
                    $vessels_name = $this->getSelectedAssets($vesselsid);
                    $vessels[$vs] = $vessels_name;
                }
                $vessels = implode(",", $vessels);
            }

            $tools_json = $row[9];
            $tools_id_arr = explode(",", $tools_json);
            $tools = "";
            if(!empty($tools_id_arr))
            {
                $tools = array();
                for($ts=0; $ts<count($tools_id_arr); $ts++)
                {
                    $toolsid = $tools_id_arr[$ts];
                    $tools_name = $this->getSelectedAssets($toolsid);
                    $tools[$ts] = $tools_name;
                }
                $tools = implode(",", $tools);
            }

            
            $machinery_json = $row[10];
            $machinery_id_arr = explode(",", $machinery_json);
            $machinery = "";
            if(!empty($machinery_id_arr))
            {
                $machinery = array();
                for($ms=0; $ms<count($machinery_id_arr); $ms++)
                {
                    $machineryid = $machinery_id_arr[$ms];
                    $machinery_name = $this->getSelectedAssets($machineryid);
                    $machinery[$ms] = $machinery_name;
                }
                $machinery = implode(",", $machinery);
            }
            $jsondata = $row[11];
            $diagramid = $row[12];
            $is_deleted = $row[13];
            $date_of_added = $row[14];
            $is_draft = $row[15];

            $row = array($processmasterid, $processmastername, $max_concurrent, $supervisor_roleid, $operator_roleid, $sound_notifications, $details, $materials, $vessels, $tools, $machinery, $jsondata, $diagramid, $is_deleted, $date_of_added, $is_draft);
            //print_r($row);exit;
            fputcsv($fp, $row);

            header("Content-Disposition:attachment;filename=$filename");
            header("Content-Type:application/csv;charset=UTF-8");
            header("Expires: Mon, 31 Dec 2000 00:00:00 GMT" );
            header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT" );
            header("Cache-Control: post-check=0, pre-check=0", false );
        }
        fclose($fp);

        exit;
    }
function getSupervisiorRole($id){
        if($id != "")
        {
            $q ="SELECT roleid,rolename FROM vtiger_role WHERE roleid = '$id'";
            $result = mysqli_query($this->link, $q);        
            $row = mysqli_fetch_array($result);
            return $row['rolename'];
        }
    }
    function getSupervisiorRoleId($name){
        if($name != "")
        {
            $q ="SELECT roleid,rolename FROM vtiger_role WHERE rolename = '$name'";
            $result = mysqli_query($this->link, $q);        
            $row = mysqli_fetch_array($result);
            return $row['roleid'];
        }
    }

    function getMaterials($id)
    {
        if($id != "")
        {
            $q ="SELECT p.productid,p.productname FROM vtiger_products p where p.productid = $id";
            $result = mysqli_query($this->link, $q);        
            $row = mysqli_fetch_array($result);
            return $row['productname'];
        }
    }

    function getSelectedAssets($id){
        if($id != ""){
            $q =" SELECT a.assetname,a.assetsid FROM vtiger_assets a left join vtiger_crmentity c on a.assetsid = c.crmid where c.deleted = 0 and a.assetsid = '$id'";
            $result = mysqli_query($this->link, $q);        
            $row = mysqli_fetch_array($result);
            return $row['assetname'];
        }
    }
	 
} 


 
