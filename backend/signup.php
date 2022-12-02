<?php
include 'connect.php';
include 'main/borrower_connect.php';

		if (isset($_POST["type"])){
			$type = $_POST["type"];
			$fname = $_POST["fname"];
			$lname = $_POST["lname"];
			$email = $_POST["email"];
			$phone = $_POST["phone"];
			$username = $_POST["uname"];
			$password = $_POST["password"];
			$saddress = $_POST["saddress"];
			$state = $_POST["state"];
			$zip = $_POST["zip"];


			if ($type == "Admin"){
				$qry = "INSERT into admin(fname, lname, email, phone, username, password, saddress, state, zip,type) VALUES ('$fname', '$lname','$email', '$phone', '$username','$password','$saddress',' $state', '$zip',0)";
	
			}elseif ($type == "Investor"){
				$qry = "INSERT into investors(fname, lname, email, phone, username, password, saddress, state, zip,type,nemail,nphone) VALUES ('$fname', '$lname','$email', '$phone', '$username','$password','$saddress','$state', '$zip',2,0,0)";
				$table_sql = "CREATE TABLE ".$username." (
					uid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					sid VARCHAR(50000),
					link VARCHAR(500),
					bcoll VARCHAR(500),
					bcaddress VARCHAR(500),
					loanamount VARCHAR(500),
					iequity VARCHAR(500),
					irate VARCHAR(500),
					rpayment VARCHAR(500),
					ppayment VARCHAR(500),
					idate VARCHAR(500),
					mdate VARCHAR(500)
					)";
					$b_conn->query($table_sql);
				//	$bqry = "INSERT into ".$username."(link, bcaddress, loanamount, iequity, irate, rpayment, idate, mdate) VALUES ('','', '', '','','','', '')";
				//	mysqli_query($b_conn,$bqry);
			}else{
				$qry = "INSERT into borrower(fname, lname, email, phone, username, password, saddress, state, zip,type) VALUES ('$fname', '$lname','$email', '$phone', '$username','$password','$saddress','$state', '$zip',1)";
			}
		
			$conn->query($qry);
		}else{
			header("Location: ../index.html");
			die();
		}
		

?>

