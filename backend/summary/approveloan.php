<?php
session_start();
if ($_SESSION['auser'] == 'david') {
    $id = $_POST['sids'];
    echo $sid;
    include_once("summary_connect.php");


    $sql = "UPDATE `summary` SET `status`='1' WHERE `sid`='$id'";
    echo $sql;

    $res = mysqli_query($sum_conn, $sql);

    header('Location: ../../admin/approve.php');
    exit();
}
