<?php


class Config{
	
	function update($name,$tag,$cimg,$aimg){
		$conn =  mysqli_connect("localhost", "riazhwtz_trialdkc", "9816084512Ab@", "riazhwtz_dkc");
		$sql = "UPDATE website SET name='$name', tagline='$tag', clientimg='$cimg', adminimg='$aimg' WHERE id='1'";
		mysqli_query($conn,$sql);
	}

	function fetch(){
		$conn =  mysqli_connect("localhost", "riazhwtz_trialdkc", "9816084512Ab@", "riazhwtz_dkc");
		$sql = "SELECT * FROM website";
		return mysqli_fetch_array(mysqli_query($conn,$sql),MYSQLI_ASSOC);
	}
}

$config = new Config();

?>