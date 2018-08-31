<?php 
error_reporting(-1);
include_once 'includes/main/WebUI.php';

function pp_array($array){
	print('<pre>');	print_r($array); print('</pre>');
}

function pf_arraySearch($array, $key, $value) {
    $results = array();
    if (is_array($array)) {
        if (isset($array[$key]) && $array[$key] == $value) {
            $results[] = $array;
        }
        foreach ($array as $subarray) {
            $results = array_merge($results, pf_arraySearch($subarray, $key, $value));
        }
    }
    return $results;
}

function buildunitprocess(&$unitprocessarray, $nodes, $links,  &$rid, $nkey, $fkey){
	$currentnode = $nodes[$nkey];
	$lnode = pf_arraySearch($links, 'from', $nkey);
	switch($currentnode[0]){
		case "MultiAction":
			$mac_array[$nkey] = pf_arraySearch($links, 'to', $nkey);
			if (isset ($unitprocessarray[$nkey]['ma_from'])) {
				$ma_from = $unitprocessarray[$nkey]['ma_from'];
				$ma_from[] = $fkey;
			}else{
				$ma_from = Array($fkey);
			}
			$unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1], 'next'=>$lnode[0]['to'], 'ma_from'=>$ma_from);
			$allconnected = count($mac_array[$nkey]) == count($ma_from);
			if($allconnected){
				$rid++;
				$unitprocessarray[$nkey]['id'] = $rid;
				//echo "Unit Process# ".$rid." ($nkey)(".$lnode[0]['to'].") ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." next node ".$lnode[0]['to']." ma from ".implode(',',$unitprocessarray[$nkey]['ma_from'])."<br/>";
				buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lnode[0]['to'], $lnode[0]['from']);
			}
			break;

		case "Branching":
		case "Decision":
			foreach($lnode as $lkey=>$lval){
				if(!isset($unitprocessarray[$nkey])){
					$rid++;
					$unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1], 'next'=>$lval['to'], 'ma_from'=>Array());
					//echo "Unit Process# ".$rid." ($nkey)(".$lval['to'].") ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." next node ".$lval['to']."<br/>";
				}
				$intable = pf_arraySearch($unitprocessarray, 'node', $lval['to']);
				if(count($intable)==0){
					buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lval['to'], $lval['from']);
				} else {
					if(in_array($intable[0]['category'], ['MultiAction', 'Terminal'])){
						buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lval['to'], $lval['from']);
					}
				}
			}
			break;

		case "Terminal":
			$term_array[$nkey] = pf_arraySearch($links, 'to', $nkey);
			if (isset ($unitprocessarray[$nkey]['ma_from'])) {
			$ma_from = $unitprocessarray[$nkey]['ma_from'];
			$ma_from[] = $fkey;
			}else{
			$ma_from = Array($fkey);
			}
			$unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1],  'ma_from'=>$ma_from);
			$allconnected = count($term_array[$nkey]) == count($ma_from);
			if($allconnected){
				$rid++;
				//echo "Unit Process# ".$rid." ($nkey) ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." ma from ".implode(',',$unitprocessarray[$nkey]['ma_from'])."<br/>";
				$unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1],  'ma_from'=>$ma_from);
			}
			break;

		default:
			$rid++;
			$unitprocessarray[$nkey] = Array('id'=>$rid, 'node'=>$nkey, 'category'=>$currentnode[0], 'text'=>$currentnode[1], 'next'=>$lnode[0]['to'], 'ma_from'=>Array());
			//echo "Unit Process# ".$rid." ($nkey)(".$lnode[0]['to'].") ".$currentnode[0]." ".$currentnode[1]." this node ".$nkey." next node ".$lnode[0]['to']."<br/>";
			buildunitprocess($unitprocessarray,  $nodes, $links,  $rid, $lnode[0]['to'], $lnode[0]['from']);
			break;
	}
}

global $adb;
$processmasterid = $_GET['pfid'];
$result = $adb->pquery("SELECT * from vtiger_processmaster where processmasterid=?", Array($processmasterid));
$pfjsondata = $adb->query_result($result,0,'jsondata');
$processmastername = $adb->query_result($result,0,'processmastername');

$pfdataarray = json_decode(stripslashes(html_entity_decode($pfjsondata)), true);
$nodearray = $pfdataarray['nodeDataArray'];
$nodekeyarray = Array();
foreach($nodearray as $key=>$val){
	$nodekeyarray[$val['key']] = Array($val['category'],$val['text']);
}
$linkarray = $pfdataarray['linkDataArray'];

$id=0;
$unitprocessarray=Array();
buildunitprocess($unitprocessarray,  $nodekeyarray, $linkarray, $id, -1, 0);
uasort($unitprocessarray, function ($a, $b) { return $a['id'] - $b['id'];});
$blocktypes = Array('Action', 'Decision', 'Document', 'Notification', 'Approval', 'Timer', 'Start', 'Terminal', 'Branching', 'Counter', 'MultiAction');

echo "Template output for $processmastername<hr>";
foreach($unitprocessarray as $key=>$val){
	$inward_links = pf_arraySearch($linkarray, 'to', $val['node']);
	$outward_links = pf_arraySearch($linkarray, 'from', $val['node']);
	$inward_ll = $outward_ll = Array();

	foreach($inward_links as $ikey=>$ival){$inward_ll[]=$unitprocessarray[$ival['from']]['id'];}
	foreach($outward_links as $okey=>$oval){$outward_ll[]=$unitprocessarray[$oval['to']]['id'];} 

	//$unitprocessid	Auto increment
	//$processmasterid	Set in earlier query
	$prior_unitprocess = implode(',', $inward_ll); 
	$post_unitprocess = implode(',', $outward_ll); 
	$description = $val['text']; 
	$blocktype = array_search ($val['category'],$blocktypes) + 1; 
	$subblocktype = 0; 
	$branching = count($outward_ll);
	$unitprocess_time = 30; //
	$snooze = 5; //
	$unitprocess_datablock = null; //
	$sequence = $val['id']; 
	$next_process = 0; //
	$customicon = null; //
	$customform = null; //
	$is_final_result = 0; //
	$diagramo_id = $val['node']; 
	$LearnerModeDetails = null; //

	$query="INSERT vtiger_processflow_unitprocess SET (processmasterid, prior_unitprocess, post_unitprocess, description, blocktype, subblocktype, branching, unitprocess_time, snooze, unitprocess_datablock, sequence, next_process, customicon, customform, is_final_result, diagramo_id, LearnerModeDetails) VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
	$params=Array($processmasterid, $prior_unitprocess, $post_unitprocess, $description, $blocktype, $subblocktype, $branching, $unitprocess_time, $snooze, $unitprocess_datablock, $sequence, $next_process, $customicon, $customform, $is_final_result, $diagramo_id, $LearnerModeDetails);

	pp_array($params);
	echo $query."<hr/>";
}



