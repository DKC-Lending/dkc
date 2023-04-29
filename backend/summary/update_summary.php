<?php
error_reporting(1);
include_once("summary_connect.php");
$uid = $_GET['sum-id'];
$bllc = $_GET['bllc'];
$fname = $_GET['fname'];
$lname = $_GET['lname'];
$link = $_GET['clink'];
$cadd = $_GET['caddress'];
$tloan = $_GET['tloan'];

/*

    <option value="DKC">DKC Lending LLC</option>
    <option value="DKCFL">DKC Lending FL</option>
    <option value="DKCCL">DKC Lending CFL</option>
    <option value="FCT1">First Capital Trusts</option>
    <option value="DKCIV">DKC Lending IV</option>
    <option value="DKCL">DKC Lending CL</option>

*/
if ($_GET['dkc'] == 'FCT1') {
    $loan = "First Capital Trusts LLC";
} elseif ($_GET['dkc'] == 'DKCFL') {
    $loan = "DKC Lending FL";
} elseif ($_GET['dkc'] == 'DKCL') {
    $loan = "DKC Lending CL";
} elseif ($_GET['dkc'] == 'DKCCL') {
    $loan = "DKC Lending CFL";
}elseif ($_GET['dkc'] == 'DKCIV') {
    $loan = "DKC Lending IV";
} else {
    $loan = "DKC Lending LLC";
}
$trate = $_GET['irate'];
$odate = $_GET['odate'];
$mdate = $_GET['mdate'];

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
$iszero = $_GET['iszero'];



$sql = "UPDATE `summary` SET `bllc`='$bllc',`fname`='$fname',`lname`='$lname',`bcoll`='$cadd',`link`='$link',`tloan`='$tloan',`irate`='$trate',`odate`='$odate',`mdate`='$mdate',`bphone`='$bphone',`bemail`='$bemail',`iexpiry`='$iexpiry',`taxurl`='$taxurl',`ach`='$ach',`service`='$business',`dkc`='$dkc', `dkcamt`='$dkcamt',`dkcrate`='$dkcrate',`dkcprorated`='$dkcprorated',`dkcregular`='$dkcregular',`p1`='$p1',`p1amt`='$p1amt',`p1rate`='$p1rate',`p1prorated`='$p1prorated',`p1regular`='$p1regular',`p2`='$p2',`p2amt`='$p2amt',`p2rate`='$p2rate',`p2prorated`='$p2prorated',`p2regular`='$p2regular',`p3`='$p3',`p3amt`='$p3amt',`p3rate`='$p3rate',`p3prorated`='$p3prorated',`p3regular`='$p3regular', `p4`='$p4',`p4amt`='$p4amt',`p4rate`='$p4rate',`p4prorated`='$p4prorated',`p4regular`='$p4regular',`balance`='$balance',`servicingamt`='$servicing',`yieldamt`='$yield',`servicingrate`='$servicingrate',`yieldrate`='$yieldrate',`servicingprorated`='$servicingprorated',`yieldprorated`='$yieldprorated',`servicingregular`='$servicingregular',`yieldregular`='$yieldregular',`loan`='$loan' ,`iszero`='$iszero' WHERE `sid`='$uid'";
$res = mysqli_query($sum_conn, $sql);


$sql = "DELETE FROM `multiple` WHERE `sid`='$uid'";
mysqli_query($sum_conn, $sql);


for ($i = 0; $i < 5; $i++) {
    if ($_GET['mcoll' . $i] != null || $_GET['mcoll' . $i] != "") {
        $mcollarr = $_GET['mcoll' . $i];
        $mexpiryarr = $_GET['mexpiry' . $i];
        $sql = "INSERT INTO `multiple`(`sid`, `collateral`, `expiry`) VALUES ('$uid','$mcollarr','$mexpiryarr')";
        mysqli_query($sum_conn, $sql);
    }
}



header('Location: ../../admin/summary.php');
exit();
