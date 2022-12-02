<?php
include_once("u_conn.php");
$uname = $_GET["uname"];
$pw = $_GET["pw"];



$qry = "SELECT username, password,cell FROM investors";
$res = mysqli_query($uconn,$qry);
$arr = [];
while($data = mysqli_fetch_array($res)){
 
	if($data["username"]==$uname && $data["password"]==$pw){
	  
			$cell = explode(",",$data["cell"]);
			
			$cell = array_diff($cell,[""]);
			$cell = array_values($cell);
			array_push($arr,1,$cell);
		    header('Content-Type: application/json');
		    echo json_encode($arr);
			return $arr;
	}
}

array_push($arr,0);
header('Content-Type: application/json');
echo json_encode($arr);

?>