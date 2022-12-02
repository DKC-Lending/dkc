<?php

	if(isset($_POST['uid']))
	{	
		
		include 'connect.php';
		include 'main/borrower_connect.php';

		$uname = $_POST["uid"];
		$tbl = $_POST["tbl"];


		if($tbl=='0'){
			$qry = "DELETE FROM admin WHERE username='$uname'";
		}elseif ($tbl=='1'){
			$qry = "DELETE FROM borrower WHERE username='$uname'";
		}else{
			$qry = "DELETE FROM investors WHERE username='$uname'";
			$b_sql = "DROP TABLE ".$uname."";
			mysqli_query($b_conn,$b_sql);
		}
		$rslt= mysqli_query($conn,$qry);
		if($rslt){
			echo 1;
		}else{
			echo 0;
		}
			
	}else{
		header("Location: ../global/login.php");
		die();
	}

?>