<?php
include_once('../connect.php');

function get_insurance_users($conn){
	$sql = "SELECT * FROM borrower";
	$res = mysqli_query($conn,$sql);

	$result = [];

	while($datas = mysqli_fetch_array($res)){
		array_push($result,$datas);
	}
	return $result;
}

?>