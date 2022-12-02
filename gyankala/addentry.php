<?php
include_once('conn.php');

$user= $_GET["user"];
$date = $_GET["date"];
$cname = $_GET["name"];
$sector = $_GET["sector"];
$province = $_GET["province"];
$address = $_GET["address"];
$ward = $_GET["ward"];
$sale = $_GET["sale"];
$tdisc =  $_GET["tdisc"];
$muni = $_GET["muni"];
$total =  $_GET["total"];
$pay = $_GET["pay"];
$remark = $_GET["remark"];


$sql = "INSERT INTO $user ( `date`, `name`, `province`, `address`,`muni`,`ward`, `sector`, `sale`, `tdiscount`, `total`, `source`, `remark`) VALUES ('$date','$cname','$province','$address','$muni','$ward', '$sector','$sale','$tdisc','$total','$pay','$remark')";


$res = mysqli_query($conn,$sql);

if($res){
    echo 1;
}else{
    echo 0;
}
?>