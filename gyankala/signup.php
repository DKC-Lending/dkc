<?php
include_once('conn.php');

$fname = $_GET["fname"];
$phone = $_GET["phone"];
$username = $_GET["user"];
$password = $_GET["password"];

$sql = "INSERT INTO `users`( `fullname`, `phone`, `username`, `password`) VALUES ('$fname','$phone','$username','$password') ";
$res = mysqli_query($conn,$sql);

if($res){
    	$table_sql = "CREATE TABLE ".$username." (
					uid INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,
					date VARCHAR(500),
					name VARCHAR(500),
					province VARCHAR(500),
					address VARCHAR(500),
					muni VARCHAR(5000),
					ward VARCHAR(500),
					sector VARCHAR(500),
					sale VARCHAR(500),
					tdiscount VARCHAR(500),
					total VARCHAR(500),
					source VARCHAR(500),
					remark VARCHAR(5000)
					)";
					$conn->query($table_sql);
				
    echo 1;
}else{
    echo 0;
}
?>