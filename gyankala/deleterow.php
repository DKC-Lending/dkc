<?php
include_once('conn.php');

$user = $_GET['user'];
$id = $_GET['id'];

$sql = "DELETE FROM $user WHERE uid='$id'";
$res = mysqli_query($conn,$sql);

if($res){
    echo 1;
}else{
    echo 0;
}

?>