<?php
include_once('connect_contact.php');

function getResponse($conn){
	$result = [];
	$sql = "SELECT * FROM `contact` ORDER BY uid DESC";
	$res = mysqli_query($conn,$sql);
	while($data = mysqli_fetch_assoc($res)){
		array_push($result,$data);
	}
	return $result;
}

function getLatestContact($cus_conn){
	$sql = "SELECT `status` FROM `contact` ORDER BY uid DESC LIMIT 1";
	$res = mysqli_query($cus_conn, $sql);
	return mysqli_fetch_assoc($res);
}

function seenContact($cus_conn){
	$sql = "SELECT `uid` FROM `contact` WHERE status=0";
	$res = mysqli_query($cus_conn, $sql);
	while($data = mysqli_fetch_assoc($res)){
	
		$key = $data['uid'];
		$sql = "UPDATE `contact` SET `status`='1' WHERE uid = '$key'";
		mysqli_query($cus_conn,$sql);
	}

}

?>