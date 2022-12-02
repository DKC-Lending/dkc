<?php
include 'pdfconn.php';
function get_heading($pdfconn)
{
    error_reporting(1);
    $res = [];
    $sql = "DESCRIBE `invoices`";
    $rslt = mysqli_query($pdfconn, $sql);
    while ($datas = mysqli_fetch_array($rslt)) {
        if ($datas['Field'] != "invid" && $datas['Field'] != "collateral" && $datas['Field'] != "borrower" && $datas['Field'] != "id") {
            array_push($res, $datas['Field']);
        }
    }

    return (count($res) >= 3) ? array_slice($res, -3, 3, true) : $res;;
}

function get_heading_datas($pdfconn)
{
    error_reporting(1);
    $res = [];
    $sql = "SELECT * FROM `invoices`";
    $rslt = mysqli_query($pdfconn, $sql);
    while ($datas = mysqli_fetch_array($rslt)) {
        array_push($res, $datas);
    }
    return $res;
}
function get_data_from_id($pdfconn, $id)
{
    $sql = "SELECT * FROM invoices WHERE id = '$id'";
    $rslt = mysqli_query($pdfconn, $sql);
    $datas = mysqli_fetch_assoc($rslt);
    

    return  $datas;
}
?>