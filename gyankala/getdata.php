<?php
include_once("conn.php");
$uname = $_GET["user"];
$arr = [];
$qry = "SELECT * FROM $uname";
$res = mysqli_query($conn,$qry);
while($data = mysqli_fetch_assoc($res)){
	array_push($arr,$data);
}
header('Content-Type: application/json');
echo json_encode($arr);
?>