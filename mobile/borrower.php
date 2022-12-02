<?php
include "b_conn.php";
$user = $_GET["user"];
$res = [];
 $sql = "SELECT * FROM `summary`";
        $qry = mysqli_query($bconn, $sql);
       
        while ($datas = mysqli_fetch_assoc($qry)) {



            if ($datas['p1'] != "None" && $datas['p1'] == $user) {
                array_push($res, $datas);
            }

            if ($datas['p2'] != "None" && $datas['p2'] == $user) {
                array_push($res, $datas);
            }

            if ($datas['p3'] != "None" && $datas['p3'] == $user) {
                array_push($res, $datas);
            }
}


header('Content-Type: application/json');
echo json_encode($res);
return 0;
       
?>