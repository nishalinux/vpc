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
 
global $result;
global $client;
global $Server_Path;
global $adb;

$customerid = $_SESSION['customer_id'];
$sessionid = $_SESSION['customer_sessionid'];
$portaltype = $_SESSION['portaltype'];
echo '<!--Get Document Details Information -->';
if($note_id != '')
{
	$params = array('id' => "$note_id", 'block'=>"$block",'contactid'=>$customerid,'sessionid'=>"$sessionid",'portaltype'=>$portaltype);
	$result = $client->call('get_details', $params, $Server_Path, $Server_Path);
	// Check for Authorization
	if (count($result) == 1 && $result[0] == "#NOT AUTHORIZED#") {
		echo '<aside class="right-side">';
		echo '<section class="content-header" style="box-shadow:none;"><div class="alert"><b>'.getTranslatedString('LBL_NOT_AUTHORISED').'</b></div></section></aside>';
		include("footer.html");
		die();
	}
	$noteinfo = $result[0][$block];
	
    echo '<aside class="right-side">';
	echo '<section class="content-header" style="box-shadow:none;">
			<div class="row-pad"><div class="col-sm-10">
				<input class="btn btn-primary btn-flat" type="button" value="'.getTranslatedString('LBL_BACK_BUTTON').'" onclick="window.history.back();"/>
			</div></div></section></form>';
	echo getblock_fieldlist($noteinfo);

	echo '</table></td></tr>';	
	echo '</table></td></tr></table></td></tr></table>';
	echo '<!-- --End--  -->';	

	?>
<div class="widget-box">
	<div class = "widget-header">
	 	<h5 class = "widget-title">Attachments</h5>
	</div>
	<div class = "widget-body">
	<div class="widget-main no-padding single-entity-view">
		<div style="width:auto;padding:12px;display:block;" id="tblLeadInformation">
						<div class="row">
							<form id='idfrmAttch' name="nameFrmAttach" method="post"  action="index.php" enctype="multipart/form-data">
							<input type="hidden" name="module" value="Documents">
							<input type="hidden" name="action" value="index">
							<input type="hidden" name="mode" value="uploadfile">
							<input type="hidden" name="id" value="<?php echo $_REQUEST['id'];?>">
						
								<div class="form-group col-sm-6">
								    <label class="col-sm-3 control-label no-padding-right">
										Attach file
									</label>
									<div class="col-sm-9 dvtCellInfo" align="left" valign="top">
										<input type="file" name="customerdocfile" class="detailedViewTextBox" onchange="validateFilename(this)" />
										<input type="hidden" name="customerdocfile_hidden"/>
											<br/><br/>
										<input class="tn btn-minier btn-success" name="Attach" type="submit" value="Attach">
									</div>
								</div>
										
								<div class="form-group col-sm-6">
									<label class="col-sm-3 control-label no-padding-right">
											&nbsp;	
									</label>
								</div>
							</form>
						</div>
						</div>
					</div>
				</div>
			</div>
<?php
}

$filevalidation_script = <<<JSFILEVALIDATION
<script type="text/javascript">
                
function getFileNameOnly(filename) {
	var onlyfilename = filename;
  	// Normalize the path (to make sure we use the same path separator)
 	var filename_normalized = filename.replace(/\\\\/g, '/');
  	if(filename_normalized.lastIndexOf("/") != -1) {
    	onlyfilename = filename_normalized.substring(filename_normalized.lastIndexOf("/") + 1);
  	}
  	return onlyfilename;
}
/* Function to validate the filename */
function validateFilename(form_ele) {
if (form_ele.value == '') return true;
	var value = getFileNameOnly(form_ele.value);
	// Color highlighting logic
	var err_bg_color = "#FFAA22";
	if (typeof(form_ele.bgcolor) == "undefined") {
		form_ele.bgcolor = form_ele.style.backgroundColor;
	}
	// Validation starts here
	var valid = true;
	/* Filename length is constrained to 255 at database level */
	if (value.length > 255) {
		alert(alert_arr.LBL_FILENAME_LENGTH_EXCEED_ERR);
		valid = false;
	}
	if (!valid) {
		form_ele.style.backgroundColor = err_bg_color;
		return false;
	}
	form_ele.style.backgroundColor = form_ele.bgcolor;
	form_ele.form[form_ele.name + '_hidden'].value = value;
	return true;
}
</script>
JSFILEVALIDATION;

echo $filevalidation_script;
?>
