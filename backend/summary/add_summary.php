<?php
session_start();
error_reporting(-1);
include_once("summary_connect.php");
include '../insurance/pdfconn.php';

$bllc = $_GET['bllc'];
$bllc = str_replace("'", "", $bllc);
$fname = $_GET['fname'];
$fname = str_replace("'", "", $fname);
$lname = $_GET['lname'];
$lname = str_replace("'", "", $lname);
$link = $_GET['clink'];
$cadd = $_GET['caddress'];
$tloan = $_GET['tloan'];
$trate = $_GET['irate'];
$odate = $_GET['odate'];
$mdate = $_GET['mdate'];
if ($_GET['dkc'] == 'FCT1') {
    $loan = "First Capital Trusts LLC";
} elseif ($_GET['dkc'] == 'DKCFL') {
    $loan = "DKC Lending FL";
} elseif ($_GET['dkc'] == 'DKCCFL') {
    $loan = "DKC Lending CL";
} else {
    $loan = "DKC Lending LLC";
}
// $loan = $_GET['loans'];


$bphone = $_GET['bnum'];
$bemail = $_GET['bemail'];
$iexpiry = $_GET['bexpiry'];
$taxurl = $_GET['taxurl'];
$ach = ($_GET['ach'] == "") ? "off" : "on";
$business = $_GET['business'];

$dkc = $_GET['dkc'];
$dkcamt = $_GET['dkcamnt'];
$dkcrate = $_GET['dkcrate'];
$dkcprorated = $_GET['dkcprorated'];
$dkcregular = $_GET['dkcregular'];


$p1 = $_GET['p1'];
$p1amt = $_GET['p1amnt'];
$p1rate = $_GET['p1rate'];
$p1prorated = $_GET['p1prorated'];
$p1regular = $_GET['p1regular'];


$p2 = $_GET['p2'];
$p2amt = $_GET['p2amnt'];
$p2rate = $_GET['p2rate'];
$p2prorated = $_GET['p2prorated'];
$p2regular = $_GET['p2regular'];

$p3 = $_GET['p3'];
$p3amt = $_GET['p3amnt'];
$p3rate = $_GET['p3rate'];
$p3prorated = $_GET['p3prorated'];
$p3regular = $_GET['p3regular'];

$p4 = $_GET['p4'];
$p4amt = $_GET['p4amnt'];
$p4rate = $_GET['p4rate'];
$p4prorated = $_GET['p4prorated'];
$p4regular = $_GET['p4regular'];


$servicing = $_GET['servicingamnt'];
$servicingrate = $_GET['servicingrate'];
$servicingprorated = $_GET['servicingprorated'];
$servicingregular = $_GET['servicingregular'];
$yield = $_GET['yieldamnt'];
$yieldrate = $_GET['yieldrate'];
$yieldprorated = $_GET['yieldprorated'];
$yieldregular = $_GET['yieldregular'];
$balance = $_GET['check'];
$status = 0;
$iszero = $_GET['iszero'];
if ($_SESSION['auser'] == 'david') {
    $status = 1;
}

$sql = "INSERT INTO `summary`( `bllc`, `fname`, `lname`, `bcoll`, `link`, `tloan`, `irate`, `odate`, `mdate`, `bphone`, `bemail`, `iexpiry`, `taxurl`, `ach`, `service`,`dkc`,  `dkcamt`, `dkcrate`, `dkcprorated`, `dkcregular`, `p1`, `p1amt`, `p1rate`, `p1prorated`, `p1regular`, `p2`, `p2amt`, `p2rate`, `p2prorated`, `p2regular`, `p3`, `p3amt`, `p3rate`, `p3prorated`, `p3regular`,`p4`, `p4amt`, `p4rate`, `p4prorated`, `p4regular`, `balance`,  `servicingamt`, `yieldamt`,`servicingrate`, `yieldrate`, `servicingprorated`, `yieldprorated`, `servicingregular`, `yieldregular`,`loan`, `status`, `iszero`) VALUES ('$bllc','$fname','$lname','$cadd','$link','$tloan','$trate','$odate','$mdate','$bphone','$bemail','$iexpiry','$taxurl','$ach','$business','$dkc','$dkcamt', '$dkcrate','$dkcprorated', '$dkcregular', '$p1', '$p1amt','$p1rate', '$p1prorated', '$p1regular','$p2', '$p2amt','$p2rate', '$p2prorated', '$p2regular','$p3', '$p3amt','$p3rate', '$p3prorated', '$p3regular','$p4', '$p4amt','$p4rate', '$p4prorated', '$p4regular','$balance', '$servicing', '$yield', '$servicingrate', '$yieldrate', '$servicingprorated', '$yieldprorated', '$servicingregular', '$yieldregular','$loan','$status', '$iszero')";
echo $sql;
$result = mysqli_query($sum_conn, $sql);
$insertId = $sum_conn->insert_id;

if ($result) {
    $table_sql = "CREATE TABLE `riazhwtz_pdf`.`p$insertId` ( `uid` INT NOT NULL AUTO_INCREMENT , `date` VARCHAR(500) NOT NULL , `desc` VARCHAR(500) NOT NULL , `minterest` VARCHAR(500) NOT NULL , `latefees` VARCHAR(500) NOT NULL , `adue` VARCHAR(500) NOT NULL , `apaid` VARCHAR(500) NOT NULL , PRIMARY KEY (`uid`)) ENGINE = InnoDB";
    mysqli_query($pdfconn, $table_sql);
}

for ($i = 0; $i < 5; $i++) {
    if ($_GET['mcoll' . $i] != null || $_GET['mcoll' . $i] != "") {
        $mcollarr = $_GET['mcoll' . $i];
        $mexpiryarr = $_GET['mexpiry' . $i];
        $sql = "INSERT INTO `multiple`(`sid`, `collateral`, `expiry`) VALUES ('$insertId,'$mcollarr','$mexpiryarr')";
        echo $sql;
        mysqli_query($sum_conn, $sql);
    }
}


header('Location: ../../admin/summary.php');
exit();
