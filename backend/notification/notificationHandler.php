<?php


class Notification{
	function getAllNotification($i_conn){
		$results = [];
		$sql = "SELECT * FROM `notification` ORDER BY uid DESC";
		$res = mysqli_query($i_conn, $sql);
		while($datas = mysqli_fetch_assoc($res)){
			array_push($results,$datas);
		}
		return $results;
	}

	function getLatestnotification($i_conn){
		$sql = "SELECT `status` FROM `notification` ORDER BY uid DESC LIMIT 1";
		$res = mysqli_query($i_conn, $sql);
		return mysqli_fetch_assoc($res);
	}

	function seenNotification($i_conn){
		$sql = "SELECT `uid` FROM `notification` WHERE status=0";
		$res = mysqli_query($i_conn, $sql);
		while($data = mysqli_fetch_assoc($res)){
		
			$key = $data['uid'];
			$sql = "UPDATE `notification` SET `status`='1' WHERE uid = '$key'";
			mysqli_query($i_conn,$sql);
		}
	
	}


	function addNotification($username, $postid, $date, $type, $title, $i_conn){
		$sql = "INSERT INTO `notification`( `username`, `postid`, `date`, `type`, `title`, `status`) VALUES ('$username','$postid','$date','$type','$title',0)";
		$res = mysqli_query($i_conn, $sql);
		if($res){
			return true;
		}else{
			return false;
		}
	}
}
?>