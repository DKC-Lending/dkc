<?php
include 'pdfconn.php';
$uid = $_POST['uid'];
$sql = "SELECT date from p$uid ORDER  BY uid DESC LIMIT 1";
$res = mysqli_query($pdfconn,$sql);
if ($res){
	echo json_encode(mysqli_fetch_array($res));
}else{
	echo '0';
}

?>