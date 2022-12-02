<?php
 include_once('i_conn.php');
 $user = $_GET["user"];


	$result=[];
	$pids=[];
	$sql = "SELECT pid FROM posts ORDER BY pid DESC";
	$rslt = mysqli_query($iconn,$sql);
	while($datas = mysqli_fetch_array($rslt)){
		$pid = $datas["pid"];				
		array_push($pids,$pid);
	}
	foreach($pids as $pid){
		$in_sql = "SELECT * FROM p$pid";
		$in_rslt = mysqli_query($iconn,$in_sql);
		$in_datas_temp = mysqli_fetch_array($in_rslt);		
		if (!empty($in_datas_temp)){
		$in_rslt = mysqli_query($iconn,$in_sql);
		while($in_datas = mysqli_fetch_array($in_rslt)){
				if($user==$in_datas["username"]){
				
						array_push($result,(int)$in_datas["offer"]);
				}else{
					
						array_push($result,5);
				}
			}
		}else{
					
			array_push($result,5);
	}
	}
header('Content-Type: application/json');
echo json_encode($result);


?>