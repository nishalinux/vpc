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
function UpdateACMPRComment()
{
	global $client,$Server_Path;
	$acmprid = $_REQUEST['acmprid'];
	$ownerid = $_SESSION['customer_id'];
	$comments = $_REQUEST['comments'];
	$customerid = $_SESSION['customer_id'];
	$sessionid = $_SESSION['customer_sessionid'];

	$params = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'acmprid'=>"$acmprid",'ownerid'=>"$customerid",'comments'=>"$comments"));
	$commentresult =  $client->call('update_acmpr_comment', $params, $Server_Path, $Server_Path);
	//return $acmprid;
}

function getACMPRAttachmentsList($acmprid)
{
	global $client;
	
	$customer_name = $_SESSION['customer_name'];
	$customerid = $_SESSION['customer_id'];
	$sessionid = $_SESSION['customer_sessionid'];
	$portaltype = $_SESSION['portaltype'];
	$params = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'acmprid'=>"$acmprid","portaltype"=>"$portaltype"));
	
	$result = $client->call('get_acmpr_attachments',$params);

	return $result;
}

function AddACMPRAttachment()
{
	global $client, $Server_Path;
	$acmprid = $_REQUEST['acmprid'];
	$ownerid = $_SESSION['customer_id'];

	$filename = $_FILES['customerfile']['name'];
	$filetype = $_FILES['customerfile']['type'];
	$filesize = $_FILES['customerfile']['size'];
	$fileerror = $_FILES['customerfile']['error'];
	if (isset($_REQUEST['customerfile_hidden'])) {
		$filename = $_REQUEST['customerfile_hidden'];
	}
	
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
		if(move_uploaded_file($_FILES["customerfile"]["tmp_name"],$upload_dir.'/'.$filename))
		{
			$filecontents = base64_encode(fread(fopen($upload_dir.'/'.$filename, "r"), $filesize));
		}

		$customerid = $_SESSION['customer_id'];
		$sessionid = $_SESSION['customer_sessionid'];

		$params = Array(Array(
				'id'=>"$customerid",
				'sessionid'=>"$sessionid",
				'acmprid'=>"$acmprid",
				'filename'=>"$filename",
				'filetype'=>"$filetype",
				'filesize'=>"$filesize",
				'filecontents'=>"$filecontents"
			));
		if($filecontents != ''){
			$commentresult = $client->call('add_acmpr_attachment', $params, $Server_Path, $Server_Path);
		}else{
			echo getTranslatedString('LBL_FILE_HAS_NO_CONTENTS');
			exit();
		}	
	}
	else
	{
		$upload_error = getTranslatedString('LBL_UPLOAD_VALID_FILE');
	}

	return $upload_error;
}

?>
