<?php
include_once('../connect.php');

$uid = $_POST['uid'];
$borrower = $_POST['bor'];
$total = $_POST['total'];
$address = $_POST['address'];
$rate = $_POST["rate"];
$mdate = $_POST["mdate"];
$mpayment = $_POST['mpayment'];
$odate = $_POST["odate"];
$insurance = $_POST["insurance"];
$phone = $_POST['phone'];
$email = $_POST["email"];

$sql = "UPDATE `borrower` SET `borrower`='$borrower',`address`='$address',`total`='$total',`rate`='$rate',`mdate`='$mdate',`mpayment`='$mpayment',`odate`='$odate',`insurance`='$insurance',`email`='$email',`phone`='$phone' WHERE uid='$uid'";
$res = mysqli_query($conn,$sql);

if($res){
	echo 1;
}else{
	echo 0;
}

?>