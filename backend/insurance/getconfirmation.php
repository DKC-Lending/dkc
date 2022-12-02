<?php
include 'pdfconn.php';
function getconf($pdfconn)
{
    $arr = [];
    $year = date('Y');
    $month = date('F');
    $title =  $month . " " . substr($year, -2);
    $sql = "SELECT * FROM `confirm`";
    $rslt = mysqli_query($pdfconn, $sql);
    while ($datas = mysqli_fetch_assoc($rslt)) {
        $datas[$title] = explode("::", $datas[$title]);
        array_push($arr,$datas);
    }
    return $arr; 
}

