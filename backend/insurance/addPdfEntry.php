<?php
	include 'pdfconn.php';
	$uid = $_POST['uid'];
	$date = $_POST['date'];
	$desc = $_POST['desc'];
	$fee = $_POST['fee'];
	$rate = $_POST['rate'];
	$pamount = $_POST['pamount'];
	$amount = $_POST['amount'];

	$sql = "INSERT INTO p$uid (`date`, `desc`, `minterest`, `latefees`, `adue`, `apaid`) VALUES ('$date','$desc','$rate','$fee','$pamount','$amount')";
	mysqli_query($pdfconn,$sql);
?>