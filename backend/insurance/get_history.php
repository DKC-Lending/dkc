<?php
error_reporting(1);
include 'pdfconn.php';
$uid = $_POST['uid'];

$arr = [];
$sql = "SELECT * from p$uid";
$res = mysqli_query($pdfconn,$sql);
while ($data = mysqli_fetch_array($res)){
	array_push($arr, $data);
}

echo json_encode($arr);





?>