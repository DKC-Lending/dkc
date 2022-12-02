<?php
include_once('conn.php');
$user = $_GET["user"];


$sql = "SELECT * FROM users WHERE username='$user'";
$arr = mysqli_fetch_assoc(mysqli_query($conn,$sql));
header('Content-Type: application/json');
echo json_encode($arr);


?>