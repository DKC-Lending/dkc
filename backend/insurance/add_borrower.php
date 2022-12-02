<?php
include_once('../connect.php');
include 'pdfconn.php';



$borrower = $_POST['bor'];
$total = $_POST['total'];
$address = $_POST['address'];
$rate = $_POST["rate"];
$mdate = $_POST["mdate"];
$mpayment = $_POST['mpayment'];
$odate = $_POST["odate"];
$insurance = $_POST["insurance"];
$phone = $_POST['phone'];
$email = $_POST["email"];
$sql = "INSERT INTO borrower(borrower,address,total,rate,mdate,mpayment,odate,insurance,phone,email) VALUES ('$borrower','$address','$total','$rate','$mdate','$mpayment','$odate','$insurance','$phone','$email')";
$res = mysqli_query($conn,$sql);
$table_sql = "CREATE TABLE `riazhwtz_pdf`.`p$conn->insert_id` ( `uid` INT NOT NULL AUTO_INCREMENT , `date` VARCHAR(500) NOT NULL , `desc` VARCHAR(500) NOT NULL , `minterest` VARCHAR(500) NOT NULL , `latefees` VARCHAR(500) NOT NULL , `adue` VARCHAR(500) NOT NULL , `apaid` VARCHAR(500) NOT NULL , PRIMARY KEY (`uid`)) ENGINE = InnoDB";
mysqli_query($pdfconn, $table_sql);
echo "done";

?>