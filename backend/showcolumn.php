<?php
include_once('connect.php');
$head=$_POST["head"];
$user = $_POST["uid"];

$sql = "SELECT cell FROM investors WHERE username='$user'";
$res = mysqli_query($conn,$sql);
$res = mysqli_fetch_assoc($res);
$arr = explode(",",$res["cell"]);

if (in_array($head,$arr)){
	$arr = array_diff($arr,["$head"]);
	$final ='';
	foreach($arr as $d){
		$final.="$d,";
	}
	$final = substr($final,0,strlen($final)-1);
	
	$sql = "UPDATE investors SET  cell='$final' WHERE username='$user'";
	mysqli_query($conn,$sql);
}else{
	array_push($arr,$head);
	
	$final ='';
	$arr = array_diff($arr,[""]);
	foreach($arr as $d){
		$final.="$d,";
	}
	$final = substr($final,0,strlen($final)-1);
	
	$sql = "UPDATE investors SET  cell='$final' WHERE username='$user'";
	mysqli_query($conn,$sql);
}



?>