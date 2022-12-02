<?php
include_once("i_conn.php");
$user = $_GET["user"];
$arr = [];
$result=0;
			$pids=[];
			$sql = "SELECT pid FROM posts";
			$rslt = mysqli_query($iconn,$sql);
			while($datas = mysqli_fetch_array($rslt)){
				$pid = $datas["pid"];				
				array_push($pids,$pid);
			}
			$arr["Total Opportunities"]=count($pids);
			foreach($pids as $pid){
				$in_sql = "SELECT * FROM p$pid";
				$in_rslt = mysqli_query($iconn,$in_sql);
				$in_datas_temp = mysqli_fetch_array($in_rslt);		
				if (!empty($in_datas_temp)){
				$in_rslt = mysqli_query($iconn,$in_sql);
				while($in_datas = mysqli_fetch_array($in_rslt)){
						if($user==$in_datas["username"]){
						
								$result+=1;
						}
					}
				}
			}
			$arr["Interested on"]=(double)$result;

			header('Content-Type: application/json');
echo json_encode($arr);
?>