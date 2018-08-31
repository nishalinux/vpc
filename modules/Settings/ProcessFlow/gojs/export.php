<?php 
include_once('Processflow.php');                     
$Processflow = new Processflow();
if(isset($_GET['action']))
{
    if($_GET['action'] == "exportdata")
    {
        ob_start();
        $id = $_GET['id'];
        $Processflow->getExport($id);
        ob_flush();
        header("location:index.php");
    }
}
?>