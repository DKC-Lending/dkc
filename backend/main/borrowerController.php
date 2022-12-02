<?php
include 'borrower_connect.php';

function get_table_data($b_conn,$uname)
{
	$res=[];
	$sql = "SELECT * FROM ".$uname."";
	$rslt = mysqli_query($b_conn,$sql);
	while($datas = mysqli_fetch_array($rslt)){
		array_push($res,$datas);
	}
	return $res;
}

function get_table_heading($b_conn,$uname)
{
	error_reporting(1);
	$res=[];
	$sql = "SHOW COLUMNS FROM ".$uname."";
	$rslt = mysqli_query($b_conn,$sql);
	while($datas = mysqli_fetch_array($rslt)){
		array_push($res,$datas["Field"]);
	}
	return $res;
}



?>