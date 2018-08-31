<?php
/*********************************************************************************
** The contents of this file are subject to the vtiger CRM Public License Version 1.0
 * ("License"); You may not use this file except in compliance with the License
 * The Original Code is:  vtiger CRM Open Source
 * The Initial Developer of the Original Code is vtiger.
 * Portions created by vtiger are Copyright (C) vtiger.
 * All Rights Reserved.
*
 ********************************************************************************/
$only_mine = (isset($_REQUEST['only_mine'])? " checked " : "");
@include("../PortalConfig.php");
if(!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == '')
{
	@header("Location: $Authenticate_Path/login.php");
	exit;
}
	include("index.html");
	global $result;
	$sessionid = $_SESSION['customer_sessionid'];
	$customerid = $_SESSION['customer_id'];
	$note_id =$_REQUEST['id'];
	$block= 'Documents';

		if( $note_id == ''){
			include("DocumentsList.php");
		}
		else{
			include("DocumentDetail.php");
		}

	if($_REQUEST['folderid'] !=''){
		include("DownloadFile.php");
	}


		// print_r($_REQUEST);print_r($_FILES);
	if($_REQUEST['mode'] == 'uploadfile' && requestValidateWriteAccess())
	{
		// echo "getting";
		$upload_status = AddDocAttachment();
		// echo "got";
		if($upload_status != ''){
			echo $upload_status;
			exit(0);
		} 
	}
	echo '</table></td></tr></table></td></tr></table>';


function AddDocAttachment()
{
	global $client, $Server_Path;
	$docid = $_REQUEST['id'];
	$ownerid = $_SESSION['customer_id'];
// echo $docid;
	$filename = $_FILES['customerdocfile']['name'];
	$filetype = $_FILES['customerdocfile']['type'];
	$filesize = $_FILES['customerdocfile']['size'];
	$fileerror = $_FILES['customerdocfile']['error'];
	if (isset($_REQUEST['customerdocfile_hidden'])) {
		$filename = $_REQUEST['customerdocfile_hidden'];
	}
	// print_r($_REQUEST);print_r($_FILES);echo $filesize;echo $filename;

	$upload_error = '';
	if($fileerror == 4)
	{
		$upload_error = getTranslatedString('LBL_GIVE_VALID_FILE');
	}
	elseif($fileerror == 2)
	{
		$upload_error = getTranslatedString('LBL_UPLOAD_FILE_LARGE');
	}
	elseif($fileerror == 3)
	{
		$upload_error = getTranslatedString('LBL_PROBLEM_UPLOAD');
	}

	//Copy the file in temp and then read and pass the contents of the file as a string to db
	global	$upload_dir;
	if(!is_dir($upload_dir)) {
		echo getTranslatedString('LBL_NOTSET_UPLOAD_DIR');
		exit;
	}
	if($filesize > 0)
	{
		if(move_uploaded_file($_FILES["customerdocfile"]["tmp_name"],$upload_dir.'/'.$filename))
		{
			$filecontents = base64_encode(fread(fopen($upload_dir.'/'.$filename, "r"), $filesize));
		}
		$customerid = $_SESSION['customer_id'];
		$sessionid = $_SESSION['customer_sessionid'];

		$params = Array(Array(
				'id'=>"$customerid",
				'sessionid'=>"$sessionid",
				'documentid'=>"$docid",
				'filename'=>"$filename",
				'filetype'=>"$filetype",
				'filesize'=>"$filesize",
				'filecontents'=>"$filecontents"
			));
		// print_r($params);
		if($filecontents != ''){
			// echo "CP";
			$commentresult = $client->call('add_document_attachment', $params, $Server_Path, $Server_Path);
		}else{
			echo getTranslatedString('LBL_FILE_HAS_NO_CONTENTS');
			exit();
		}	
	}
	else
	{
		// echo "hii";
		$upload_error = getTranslatedString('LBL_UPLOAD_VALID_FILE');
	}

	return $upload_error;
}

// function getDocumentAttachmentsList($docid)
// {
// 	global $client;
	
// 	$customer_name = $_SESSION['customer_name'];
// 	$customerid = $_SESSION['customer_id'];
// 	$sessionid = $_SESSION['customer_sessionid'];
// 	$portaltype = $_SESSION['portaltype'];
// 	$params = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'docid'=>"$docid","portaltype"=>"$portaltype"));
// 	//$params = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'ticketid'=>"$ticketid"));
// 	$result = $client->call('get_document_attachments',$params);

// 	return $result;
// }
?>
