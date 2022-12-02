<?php
include "connect.php";

include 'main/borrower_connect.php';
if(isset($_POST["submit"])){
	$uid   = $_POST["uid"];
	$tbl   = $_POST["tbl"];
	$fname = $_POST["fname"];
	$lname = $_POST["lname"];
	$email = $_POST["email"];
	$phone = $_POST["phone"];
	$username = $_POST["uname"];
	$password = $_POST["password"];
	$saddress = $_POST["saddress"];
	$state = $_POST["state"];
	$zip = $_POST["zip"];


	if($tbl=='0'){
		$qry = "UPDATE admin SET fname='$fname', lname='$lname', email='$email', phone='$phone', username='$username', password='$password', saddress='$saddress', state='$state', zip='$zip' WHERE username='$uid'";
	}elseif ($tbl=='1'){
		$qry = "UPDATE borrower SET fname='$fname', lname='$lname', email='$email', phone='$phone', username='$username', password='$password', saddress='$saddress', state='$state', zip='$zip' WHERE username='$uid'";
	}else{
		$qry = "UPDATE investors SET fname='$fname', lname='$lname', email='$email', phone='$phone', username='$username', password='$password', saddress='$saddress', state='$state', zip='$zip' WHERE username='$uid'";
	}
	$conn->query($qry);

	header("Location: ../admin/users.php");
	die();
}else{
	header("Location: ../index.php");
	die();
}



?>