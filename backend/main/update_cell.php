<?php
use UI\Key;

include 'borrower_connect.php';
if (isset($_POST["uid"])){
	$uname = $_POST["uid"];
	$tdatas = $_POST["datas"];
	$i=0;
	$temp_qry = "";
	
	$uids =[];
	$sql = "SELECT * FROM $uname";
	$resid = $b_conn->query($sql);
	while($ids = mysqli_fetch_assoc($resid)){
		array_push($uids,$ids['uid']);
	}
	print_r($uids);
	foreach($tdatas as $k=>$datas){
	
		
		foreach($datas as $key=>$data){
			$temp_qry .="`$key`='$data', ";
		}
		
		$temp_qry = substr_replace($temp_qry ,"",-2);
		
		$qry = "UPDATE `".$uname."` SET ".$temp_qry." WHERE uid='".$uids[$i]."'";
		echo $qry;
		mysqli_query($b_conn,$qry);	
		$temp_qry = "";
		$i++;
		
	}
	echo "Success";
}else{
	header("Location: ../index.php");
	die();
}


?>