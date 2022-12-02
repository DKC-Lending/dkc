<?php
include_once('connect_contact.php');


$name = $_POST['name'];
$email = $_POST['email'];
$msg = $_POST['msg'];
$user = $_POST['user'];
$date = (string)date("d/m/Y");

$sql = "INSERT INTO `contact`(`name`, `email`, `msg`, `user`,`date`,`status`) VALUES ('$name','$email','$msg','$user','$date',0)";
$res = mysqli_query($cus_conn, $sql);
if($res){
	echo '1';
}else{
	echo '0';
}

?>