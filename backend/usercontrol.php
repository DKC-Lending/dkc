<?php

include 'connect.php';

class Users{

	function all_users($conn){
		
			$res = [];

			//fetching datas from admin table
			$qry = "SELECT * FROM admin";
			$rslt= mysqli_query($conn,$qry);
			while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
				array_push($res,$data);
			}


			
			//fetching data from investors table
			$qry = "SELECT * FROM investors";
			$rslt= mysqli_query($conn,$qry);
			while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
				array_push($res,$data);
			}



			// //fetching data from borrowers table
			// $qry = "SELECT * FROM borrower";
			// $rslt= mysqli_query($conn,$qry);
			// while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
			// 	array_push($res,$data);
			// }

			
			return $res;
	}

	function category_users($conn, $tbl){
		$res = [];

			//fetching data from admins table
			if($tbl==0 || $tbl==3){
				$qry = "SELECT * FROM admin";
				$rslt= mysqli_query($conn,$qry);
				while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
					array_push($res,$data);
				}
			}
			
			//fetching data from investors table
			if($tbl==2 || $tbl==3){
				$qry = "SELECT * FROM investors ORDER BY `sort` ASC";
				$rslt= mysqli_query($conn,$qry);
				while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
					array_push($res,$data);
				}
			}

			//fetching data from borrowers table
			if($tbl==1 || $tbl==3){
				$qry = "SELECT * FROM borrower";
				$rslt= mysqli_query($conn,$qry);
				while($data = mysqli_fetch_array($rslt,MYSQLI_ASSOC)){
				array_push($res,$data);
			}
			}
			return $res;

	}

	function toogle_notification($conn,$user,$value,$type){
		if($type==0){
			$sql = "UPDATE investors SET  nemail='$value' WHERE username='$user'";
		}else{
			$sql = "UPDATE investors SET  nphone='$value' WHERE username='$user'";
		}

		mysqli_query($conn,$sql);
	}

	function get_notification_status($conn,$user){
		$sql = "SELECT nemail,nphone FROM investors WHERE username='$user'";
		return mysqli_fetch_array(mysqli_query($conn,$sql),MYSQLI_ASSOC);
	}

	function get_details_from_username($conn,$username){
		$sql = "SELECT * FROM investors WHERE username='$username'";
		return mysqli_fetch_array(mysqli_query($conn,$sql),MYSQLI_ASSOC);
	}
	
	function get_phone_email($conn){
		$results= [];
		
		$sql = "SELECT fname,email,phone,nphone,nemail FROM investors";
		$res = mysqli_query($conn,$sql);
		while($data =  mysqli_fetch_array($res,MYSQLI_ASSOC)){
			array_push($results,$data);
		}	
		return $results;
	}

}

$Users= new Users();
if(isset($_POST["value"]) && isset($_POST["type"])){
	$user = $_POST["user"];
	$value = $_POST["value"];
	$type = $_POST["type"];
	$Users->toogle_notification($conn,$user,$value,$type);
}

?>