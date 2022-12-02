<?php
session_start();
include 'pdfconn.php';
$pid = $_GET['confirmsid'];
$year = date('Y');
$month = date('F'); 
$title =  $month." ".substr($year,-2);
$bllc = $_GET['confirmbllc'];
$bcoll = $_GET['confirmbcoll'];
$date = $_GET['confirmdate'];
$schedule = $_GET['schedule'];
$paid = $_GET['confirmpaid'];
$notes = $_GET['confirmnotes'];




$result = mysqli_query($pdfconn, "SHOW COLUMNS FROM `confirm` LIKE '$title'");
$exists = mysqli_num_rows($result);

if ($exists == 0) {

    $qry = "ALTER TABLE `confirm` ADD `$title` VARCHAR(50)";
    mysqli_query($pdfconn, $qry);
}

$sql = "SELECT * FROM confirm WHERE `sid` LIKE '$pid' LIMIT 1";
if (mysqli_num_rows(mysqli_query($pdfconn, $sql)) == 0) {
    $sql = "INSERT INTO `confirm`( `sid`, `bllc`, `bcoll`, `$title`) VALUES ('$pid', '$bllc','$bcoll', '')";
echo $sql;
    mysqli_query($pdfconn, $sql);
}

$values = "$date::$schedule::$paid::$notes";
echo $values;

$sql = "UPDATE `confirm` SET `$title`='$values' WHERE `sid`='$pid'";
mysqli_query($pdfconn, $sql);
header('Location: ../../admin/invoices.php');
exit();


?>