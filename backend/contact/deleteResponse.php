<?php
include_once('connect_contact.php');
$uid = $_POST['uid'];

$sql = "DELETE FROM `contact` WHERE uid = '$uid'";
$res = mysqli_query($cus_conn, $sql);

if($res){
	echo '1';
}else{
	echo '0';
}
	

?>