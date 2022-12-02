<?php
include_once('../post/investment_connect.php');
$uid = $_POST['uid'];

$sql = "DELETE FROM `notification` WHERE uid = '$uid'";
$res = mysqli_query($i_conn, $sql);

if($res){
	echo '1';
}else{
	echo '0';
}
	

?>