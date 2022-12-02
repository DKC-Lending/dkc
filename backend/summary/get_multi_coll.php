<?php
include_once("summary_connect.php");
    
    $sql = "SELECT * FROM `multiple`";
    $qry =mysqli_query($sum_conn,$sql);
    $datas = [];
    while($data  = mysqli_fetch_assoc($qry)){
        array_push($datas,$data);
    }
    $multi_arr = $datas;
?>