<?php

	global $result;
	global $client;
	
	$onlymine=$_REQUEST['onlymine'];
	$portaltype = $_SESSION['portaltype'];
	if($onlymine == 'true') {
	    $mine_selected = 'selected';
	    $all_selected = '';
	} else {
	    $mine_selected = '';
	    $all_selected = 'selected';
	}
	 
	echo '<aside class="right-side">';
	echo '<section class="content-header" style="box-shadow:none;"><div class="row-pad">';
	echo '<div class="col-sm-11"><b style="font-size:20px;">'.getTranslatedString("LBL_NOTES_INFORMATION").'</b></div>';    
	$allow_all = $client->call('show_all',array('Documents'),$Server_Path, $Server_Path);
	
    if($allow_all == 'true'){
    	echo '<div class="col-sm-1 search-form"><div class="btn-group">
      			<button type="button" class="btn btn-default dropdown-toggle document_owner_btn" data-toggle="dropdown">
	 				'.getTranslatedString('SHOW').'<span class="caret"></span>
	 			</button>
	 			<ul class="dropdown-menu document_owner">
 				<li><a href="#">'.getTranslatedString('MINE').'</a></li>
				<li><a href="#">'.getTranslatedString('ALL').'</a></li>
				</ul>
			</div></div></div><section>';
    }
      		
	echo '<section class="content"><div class="row">';
    echo '<div class="col-xs-12">';
    echo '<div class="box-body table-responsive no-padding"><table class="table table-hover">';
	    		
	if ($customerid != '' )
	{
		$block = "Documents";
		$statusrel_data = array();
		$params = array('id' => "$customerid", 'block'=>"$block",'sessionid'=>$sessionid,'portaltype'=>$portaltype,'onlymine'=>$onlymine);
		$result = $client->call('get_list_values', $params, $Server_Path, $Server_Path);

		// $data_arr=$result[1][$block]['data'];
		// $header_arr =$result[0][$block]['head'][0];	
		// $nooffields=count($header_arr);
		// $noofdata=count($data_arr);
		// for($j=0;$j<$noofdata;$j++)
		// {	
		// 	for($i=0;$i<$nooffields;$i++)
		// 	{
		// 		$statusrel_data = $data_arr[$j][$i]['fielddata'];
		// 		// $status = $data_arr[$j][0]['fielddata'];
		// 		print_r($statusrel_data);exit();
		// 		// $qry = "SELECT status_flag FROM vtiger_notes WHERE title = ? AND filename = ?";
		// 		// $res = $adb->pquery($qry,array($title,$filename));
		// 		// if($adb->num_rows($res)>0){
		// 		// 	// for($i=0;$i<$adb->num_rows($res);$i++){
		// 		// 		$status = $adb->query_result($res,0,'status_flag');
		// 		// 	// }
					
		// 		}
		// 	}
		// }
		// print_r($statusrel_data);exit();
		$status = array(0 => 'Approved',1 => 'Declined',2 => 'Approved');
		echo getblock_fieldlistview($result,$block,$status);
	}
?>
