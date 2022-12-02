<?php

include 'borrower_connect.php';

	$tbl = $_POST["tbl"];
	$usr = $_POST["user"];
	
	error_reporting(1);
	$qry = "ALTER TABLE `$usr` DROP `$tbl`;";

	if(mysqli_query($b_conn,$qry)){
		echo "success";
	}else{
		echo "not success";
	}



?>