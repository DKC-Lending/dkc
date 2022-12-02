<?php
include_once('i_conn.php');
$user = $_GET["user"];
$pid = $_GET["pid"];
$sql = "DELETE FROM p$pid WHERE username='$user'";
		mysqli_query($iconn,$sql);

if($sql){
	echo json_encode(1);
	return true;
}else{
	echo json_encode(0);
	return false;
}
?>