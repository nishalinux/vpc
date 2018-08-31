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

$customerid = $_SESSION['customer_id'];
$sessionid = $_SESSION['customer_sessionid'];
$portaltype = $_SESSION['portaltype'];
if($acmprid != '')
{
	$attachmentnames = array('Document signed and dated by the proposed quality assurance person attached',
						'Description of Record Keeping Attached',
						'Example of Record Keeping Attached',	
						'Security Measures Attached',	
						'Site Plan Attached',	
						'Foot Plans Attached',	
						'Storage Areas Attached',	
						'Notices Attached',
						'Appendix A attached'
	);
	
	$params = array('id' => "$acmprid", 'block'=>"$block",'contactid'=>$customerid,'sessionid'=>"$sessionid",'portaltype'=>$portaltype);
	
	$result = $client->call('get_details', $params, $Server_Path, $Server_Path);
	$commentparams = Array(Array('id'=>"$customerid", 'sessionid'=>"$sessionid", 'ticketid' => "$acmprid"));
	$commentresult = $client->call('get_ticket_comments', $commentparams, $Server_Path, $Server_Path);
	$commentscount = count($commentresult);
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
				</div></div></section>';
	echo getblock_fieldlist($noteinfo);

	echo '</table></td></tr>';	
	echo '</table></td></tr></table></td></tr></table>';
	echo '<!-- --End--  -->';
	/*Comments section*/
	$list .=  '<div class="widget-box">
								<div class = "widget-header">
									<h5 class = "widget-title">'.getTranslatedString('LBL_TICKET_COMMENTS').'</h5>
								</div>
								<div class = "widget-body">
									<div class="widget-main no-padding single-entity-view">
										<div style="width:auto;padding:12px;display:block;" id="tblLeadInformation">';
				
				if($commentscount >= 1 && is_array($commentresult)){
					
					$list .= '<div id="scrollTab2">
							<table width="100%"  border="0" cellspacing="5" cellpadding="5">';
							for($j=0;$j<$commentscount;$j++){
								$list .= '
									   <tr>
											<td width="5%" valign="top">'.($commentscount-$j).'</td>
											<td width="95%">'.$commentresult[$j]['comments'].'<br><span class="hdr">'.getTranslatedString('LBL_COMMENT_BY').' : '.$commentresult[$j]['owner'].' '.getTranslatedString('LBL_ON').' '.$commentresult[$j]['createdtime'].'</span></td>
									   </tr>';
							}
							$list .= '</table></div>';
				}
	$list .= '<div class="row">
			<form name="comments" action="index.php" method="post">
				<input type="hidden" name="module" value="ACMPR">
				<input type="hidden" name="action" value="index">
				<input type="hidden" name="fun" value="updateacmprcomment">
				<input type="hidden" name="acmprid" value="'.$acmprid.'">
				<div class="form-group col-sm-12 no-padding">
					<label class="col-sm-2 control-label no-padding-right">
						Add Comment
					</label>
					<div class="col-sm-10 dvtCellInfo" align="left" style = "background-color:none;">
						<textarea name="comments" style = "width:100%;"></textarea><br/><br/>
						<input class="btn btn-minier btn-success" title="'.getTranslatedString('LBL_SUBMIT').'" accesskey="S" class="small"  name="submit" value="'.getTranslatedString('LBL_SUBMIT').'" style="width: 70px;" type="submit" onclick="this.form.module.value=\'ACMPR\';this.form.action.value=\'index\';this.form.fun.value=\'updateacmprcomment\';if(trim(this.form.comments.value) != \'\')return true; else return false;"/>
					</div>
				</div>
			</form>
		</div>';
	$list .= '</div></div></div></div>';
	/*Attachments purpose*/
	$files_array = getACMPRAttachmentsList($acmprid);
	
	if($files_array[0] != "#MODULE INACTIVE#"){
		$list .= '<div class="widget-box">
					<div class = "widget-header">
						<h5 class = "widget-title">'.getTranslatedString('LBL_ATTACHMENTS').'</h5>
					</div>
					<div class = "widget-body">
						<div class="widget-main no-padding single-entity-view">
							<div style="width:auto;padding:12px;display:block;" id="tblLeadInformation">';
	
		$attachments_count = count($files_array);
		$z = 0;
		if(is_array($files_array)){
			for($j=0;$j<$attachments_count;$j++,$z++){
				$filename = $files_array[$j]['filename'];
				$filetype = $files_array[$j]['filetype'];
				$filesize = $files_array[$j]['filesize'];
				$fileid = $files_array[$j]['fileid'];
				$filelocationtype = $files_array[$j]['filelocationtype'];
				$attachments_title = '';
				
				if($j == 0)
					$attachments_title = getTranslatedString('LBL_ATTACHMENTS');
				
				if($filelocationtype == 'I'){
					if($z==0 || $z%2==0) {
						$list = '<div class = "row">';
					}
					$list .= '
							<div class="form-group col-sm-6">
								<label class="col-sm-3 control-label no-padding-right">
									'.$attachments_title.
								'</label>
								<div class="col-sm-9 dvtCellInfo" align="left" valign="top">
									<a href="index.php?downloadfile=true&fileid='.$fileid.'&filename='.$filename.'&filetype='.$filetype.'&filesize='.$filesize.'&ticketid='.$ticketid.'">'.ltrim($filename,$ticketid.'_').'</a>
								</div>
							</div>';
					
					if($z%2 == 1 ||($j == ($attachments_count-1) ))
						$list .= '</div>';
						
					} else {
						$list .= '<div class = "row">
							<div class="form-group col-sm-6">
								<label class="col-sm-3 control-label no-padding-right">
									'.$attachments_title.
								'</label>
								<div class="col-sm-9 dvtCellInfo" align="left" valign="top">
								&nbsp;
									<a target="blank" href='.$filename.'>'.$filename.'</a>
								</div>
							</div>
						</div>';
					}
				}
		} else{
			$list .= '<div class = "row">'.getTranslatedString('NO_ATTACHMENTS').'</div>';
		}
	}
	
	//To display the file upload error
	if($upload_status != ''){
		$list .= '<div class = "row">
				<b>'.getTranslatedString('LBL_FILE_UPLOADERROR').'</b>
				<font color="red">'.$upload_status.'</font>
			   </div>';
	}
	
for($kl=0;$kl<count($attachmentnames);$kl++){	
	$list .= '<div class="row">
							<form name="fileattachment" method="post" enctype="multipart/form-data" action="index.php">
							<input type="hidden" name="module" value="ACMPR">
							<input type="hidden" name="action" value="index">
							<input type="hidden" name="fun" value="uploadfile">
							<input type="hidden" name="acmprid" value="'.$acmprid.'">
						
									<div class="form-group col-sm-12">
											<label class="col-sm-5 control-label no-padding-right">
												'.$attachmentnames[$kl].
											'</label>
											<div class="col-sm-6 dvtCellInfo" align="left" valign="top">
												<input type="file" size="50" name="customerfile" class="detailedViewTextBox" onchange="validateFilename(this)" />
											<input type="hidden" name="customerfile_hidden"/>
											<br/>
											<input class="tn btn-minier btn-success" name="Attach" type="submit" value="'.getTranslatedString('LBL_ATTACH').'">
										</div>
										</div>
										
										<div class="form-group col-sm-6">
											<label class="col-sm-3 control-label no-padding-right">
											&nbsp;	
											</label>
										</div>
									</form>
			</div>';
}
	echo $list;
	
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
}


?>
