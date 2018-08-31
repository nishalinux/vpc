<?php
/*
 * Created on Feb 10, 2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
 $id = $_REQUEST['file_id'];
 global $client;
 $res = $client->call('updateCount',array($id),$Server_Path,$Server_Path);
 
//added by jyothi
//  function getTicketAttachmentsList($ticketid)
// {
// 	global $client;
	
// 	$customer_name = $_SESSION['customer_name'];
// 	$customerid = $_SESSION['customer_id'];
// 	$sessionid = $_SESSION['customer_sessionid'];
// 	$portaltype = $_SESSION['portaltype'];
// 	$params = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'ticketid'=>"$ticketid","portaltype"=>"$portaltype"));
// 	//$params = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'ticketid'=>"$ticketid"));
// 	$result = $client->call('get_ticket_attachments',$params);

// 	return $result;
// }

// function AddDocAttachment()
// {
// 	global $client, $Server_Path;
// 	$docid = $_REQUEST['id'];
// 	$ownerid = $_SESSION['customer_id'];

// 	$filename = $_FILES['customerfile']['name'];
// 	$filetype = $_FILES['customerfile']['type'];
// 	$filesize = $_FILES['customerfile']['size'];
// 	$fileerror = $_FILES['customerfile']['error'];
// 	if (isset($_REQUEST['customerfile_hidden'])) {
// 		$filename = $_REQUEST['customerfile_hidden'];
// 	}
// 	print_r($_REQUEST);print_r($_FILES);echo $filesize;echo $filename;
// 	$upload_error = '';
// 	if($fileerror == 4)
// 	{
// 		$upload_error = getTranslatedString('LBL_GIVE_VALID_FILE');
// 	}
// 	elseif($fileerror == 2)
// 	{
// 		$upload_error = getTranslatedString('LBL_UPLOAD_FILE_LARGE');
// 	}
// 	elseif($fileerror == 3)
// 	{
// 		$upload_error = getTranslatedString('LBL_PROBLEM_UPLOAD');
// 	}

// 	//Copy the file in temp and then read and pass the contents of the file as a string to db
// 	global	$upload_dir;
// 	if(!is_dir($upload_dir)) {
// 		echo getTranslatedString('LBL_NOTSET_UPLOAD_DIR');
// 		exit;
// 	}
// 	if($filesize > 0)
// 	{
// 		if(move_uploaded_file($_FILES["customerfile"]["tmp_name"],$upload_dir.'/'.$filename))
// 		{
// 			$filecontents = base64_encode(fread(fopen($upload_dir.'/'.$filename, "r"), $filesize));
// 		}
// 		$customerid = $_SESSION['customer_id'];
// 		$sessionid = $_SESSION['customer_sessionid'];

// 		$params = Array(Array(
// 				'id'=>"$customerid",
// 				'sessionid'=>"$sessionid",
// 				'documentid'=>"$docid",
// 				'filename'=>"$filename",
// 				'filetype'=>"$filetype",
// 				'filesize'=>"$filesize",
// 				'filecontents'=>"$filecontents"
// 			));
// 		print_r($params);
// 		if($filecontents != ''){
// 			echo "CP";
// 			$commentresult = $client->call('add_document_attachment', $params, $Server_Path, $Server_Path);
// 		}else{
// 			echo getTranslatedString('LBL_FILE_HAS_NO_CONTENTS');
// 			exit();
// 		}	
// 	}
// 	else
// 	{
// 		echo "hii";
// 		$upload_error = getTranslatedString('LBL_UPLOAD_VALID_FILE');
// 	}

// 	return $upload_error;
// }
//ended here

?>
