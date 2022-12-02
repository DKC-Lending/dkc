<?php
include_once('../connect.php');

$uid = $_POST['uid'];

$sql = "DELETE FROM `borrower` WHERE uid='$uid'";
$res = mysqli_query($conn,$sql);

if($res){
	echo 1;
}else{
	echo 0;
}

?>