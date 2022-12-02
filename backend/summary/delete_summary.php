<?php
error_reporting(1);
include_once("summary_connect.php");
$uid = $_POST['sid'];


$sql = "DELETE FROM `summary` WHERE `sid`='$uid'";
$res = mysqli_query($sum_conn, $sql);

?>