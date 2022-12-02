<?php

include 'borrower_connect.php';
include '../connect.php';
	$tbl = $_POST["tbl"];
	$usr = $_POST["user"];
	
	error_reporting(1);
	$qry = "ALTER TABLE `$usr` DROP `$tbl`;";
	
	if(mysqli_query($b_conn,$qry)){
		
	
			$head=$tbl;
			$user = $usr;
			
			$sql = "SELECT cell FROM investors WHERE username='$user'";
			$res = mysqli_query($conn,$sql);
			$res = mysqli_fetch_assoc($res);
			print_r($res);
			$arr = explode(",",$res["cell"]);
			
			if (in_array($head,$arr)){
				echo "hey";
				$arr = array_diff($arr,["$head"]);
				$final ='';
				foreach($arr as $d){
					$final.="$d,";
				}
				$final = substr($final,0,strlen($final)-1);
				
				$sql = "UPDATE investors SET  cell='$final' WHERE username='$user'";
				mysqli_query($conn,$sql);
			}else{
				echo "No";
				array_push($arr,$head);
				
				$final ='';
				$arr = array_diff($arr,[""]);
				foreach($arr as $d){
					$final.="$d,";
				}
				$final = substr($final,0,strlen($final)-1);
				
				$sql = "UPDATE investors SET  cell='$final' WHERE username='$user'";
				mysqli_query($conn,$sql);
			}
			echo "success";
	

	}else{
		echo "error";
	}

?>