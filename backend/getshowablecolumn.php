<?php
	include_once('connect.php');
class ShowCell{
	function  getShowablecell($user,$conn){
	
		$sql = "SELECT cell FROM investors WHERE username='$user'";
		$res = mysqli_query($conn,$sql);
		$res = mysqli_fetch_assoc($res);
		$arr = explode(",",$res["cell"]);
		$arr = array_diff($arr,[""]);
		$arr = array_values($arr);
		return $arr;	
	}

}










?>