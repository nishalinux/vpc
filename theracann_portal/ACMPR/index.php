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
$only_mine = (isset($_REQUEST['only_mine'])) ? " checked " : ""; 

@include("../PortalConfig.php");
include("Utils.php");
if(!isset($_SESSION['customer_id']) || $_SESSION['customer_id'] == '')
{
	@header("Location: $Authenticate_Path/login.php");
	exit;
}
include("index.html");
$customerid = $_SESSION['customer_id'];
$sessionid = $_SESSION['customer_sessionid'];
global $result;
if($_REQUEST['id'] != '' && ($_REQUEST['fun'] != 'updateacmprcomment' || $_REQUEST['fun'] != 'uploadfile'))
{	$acmprid=$_REQUEST['id'];
	$block = "ACMPR";
	include("ACMPRDetail.php");
}else if($_REQUEST['fun'] == 'updateacmprcomment' || $_REQUEST['fun'] == 'uploadfile')
{
	
	if($_REQUEST['fun'] == 'updateacmprcomment' && requestValidateWriteAccess())
	{
		$acmprid = UpdateACMPRComment();
	}
	if($_REQUEST['fun'] == 'uploadfile' && requestValidateWriteAccess())
	{
		$upload_status = AddACMPRAttachment();
		if($upload_status != ''){
			echo $upload_status;
			exit(0);
		} 
	}
	?>
	<script>
		var id = <?php echo $_REQUEST['acmprid']; ?>;
		
		window.location.href = "index.php?module=ACMPR&action=index&fun=detail&id="+id;//
	</script>
<?php
}elseif($_REQUEST['id'] == '')
{
	include("ACMPRList.php");

}
	echo '</table> </td></tr></table></td></tr></table>';
	
?>
