<?php

include 'borrower_connect.php';
if (isset($_POST["uid"])){
	$uname = $_POST["uid"];
	$qry = "INSERT into ".$uname."(link, bcaddress, loanamount, iequity, irate,rpayment, idate, mdate) VALUES ('','', '', '','','','', '')";
	$res = mysqli_query($b_conn,$qry);
	$lastid = mysqli_insert_id($b_conn);
	if ($res){
		echo $lastid;
		
	}
}else{
	header("Location: ../index.php");
	die();
}


?>