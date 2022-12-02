<?php
include_once('conn.php');


$username = $_GET["user"];
$password = $_GET["password"];

$sql = "select * from users";
$res = mysqli_query($conn,$sql);

while($data=mysqli_fetch_assoc($res)){
    if($data["username"]==$username && $data["password"]==$password){
        echo 1;
        return true;
    }
}
echo 0;
        return false;
?>