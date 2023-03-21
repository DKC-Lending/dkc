<?php
// use only once

include '../summary/summary_connect.php';
include '../summary/get_multi_coll.php';

$different_mul_collateral = [];
    foreach ($multi_arr as $mul) {
            $temp_mul_raw = explode(":", $mul["collateral"]);
            $temp_expiry_raw = explode(":", $mul["expiry"]);

            for ($i = 0; $i < count($temp_mul_raw); $i++) {
                if ($temp_mul_raw[$i] == "" || $temp_expiry_raw[$i] == " ") {
                    continue;
                }
                $temp_mul = array($mul["sid"]=>[
                    "expiry" => $temp_expiry_raw[$i],
                    "collateral" => $temp_mul_raw[$i],
                ]);
                array_push($different_mul_collateral, $temp_mul);
            }
            
    }

$emptyTable = "TRUNCATE TABLE `multiple`";
mysqli_query($sum_conn, $emptyTable);

foreach($different_mul_collateral as $dmc){
    foreach($dmc as $key => $value){
        $sid = $key;
        $expiry = $value["expiry"];
        $collateral = $value["collateral"];
        $sql = "INSERT INTO `multiple`(`sid`, `expiry`, `collateral`) VALUES ('$sid','$expiry','$collateral')";

        mysqli_query($sum_conn, $sql);
    }
}


?>