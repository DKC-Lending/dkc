<?php

include 'borrower_connect.php';

	$uid = $_POST["uid"];
	$usr = $_POST["user"];
	
	error_reporting(1);
	$qry = "DELETE FROM $usr WHERE uid='$uid';";

	if(mysqli_query($b_conn,$qry)){
		echo "success";
	}else{
		echo "not success";
	}



?>