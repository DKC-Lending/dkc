<?php
 include_once('i_conn.php');
 $user = $_GET["user"];
 $pid = $_GET["pid"];


	$sql = "SELECT * FROM p$pid ";
	$rslt = mysqli_query($iconn,$sql);
	while($datas = mysqli_fetch_assoc($rslt)){
		if($user==$datas["username"]){
		   
				
			header('Content-Type: application/json');
			echo json_encode((int)$datas["offer"]);
			return true;
		}
	}
		
	
header('Content-Type: application/json');
echo json_encode(5);
return false;


?>