<?php
 
//Array ( [college] => 4 [batch] => 6 [date] => 02/01/2018 [students] => Array ( [5] => 1 ) )
 ini_set('error_reporting', E_ALL); 
  include_once('Medha.php');                     
  $medha = new Medha();
  $result = $medha->saveAttendance($_POST); 
  
header("Location:Home.php?attendance_taken=$result");
 
	
 



