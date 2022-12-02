<?php
include 'summary_connect.php';
$id = $_POST['uid'];
$data = $_POST['data'];

$sql = "UPDATE `due` SET `due`='$data' WHERE id='$id'";
mysqli_query($sum_conn, $sql);
?>