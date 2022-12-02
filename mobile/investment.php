<?php
include_once('i_conn.php');

$result=[];
$sql = "SELECT * FROM posts ORDER BY pid DESC";
$rslt = mysqli_query($iconn,$sql);
while($datas = mysqli_fetch_assoc($rslt)){
	array_push($result,$datas);
}
header('Content-Type: application/json');
echo json_encode($result);

?>