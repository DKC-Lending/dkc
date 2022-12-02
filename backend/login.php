<?php
	error_reporting(1);
	session_start();
	if(isset($_POST['submit']))
	{	
		
		$skey = '6LcxRZwcAAAAAGJjiChijXFX0wFeFIeThgsjESjh';
		$verify = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=".$skey."&response=".$_POST['g-recaptcha-response']);
		$response = json_decode($verify);
		if ($response->success){
			include 'connect.php';
			$uname = $_POST["username"];
			$password = $_POST["password"];
			$qry = "SELECT username, password  FROM investors";
			$rslt= mysqli_query($conn,$qry);
			while($datas = mysqli_fetch_array($rslt)){
				//print_r($datas);
				//echo $datas['username']."+".$datas['password'];
				if ($datas['username'] == $uname && $datas['password']== $password){
					
					$_SESSION["cuser"] = $uname;
					header("Location: ../clients/index.php");
					die();
				}
			}	
			
			$qry = "SELECT username, password  FROM admin";
			$rslt= mysqli_query($conn,$qry);
			while($datas = mysqli_fetch_array($rslt)){
				
				if ($datas['username'] == $uname && $datas['password']== $password){
					$_SESSION['auser'] = $uname;
					header("Location: ../admin/borrower.php");
					die();	
				}
			}
			//echo $uname.'f'.$password ;
			header("Location: ../global/login.php");
			die();	
		}else{
			header("Location: ../global/login.php");
			die();
		}	

	}else{
		
		header("Location: ../global/login.php");
		die();
	}

?>