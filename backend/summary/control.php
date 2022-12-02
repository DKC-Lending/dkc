<?php

function update_all_data()
{
    include 'summary_connect.php';
    include '../main/borrower_connect.php';

    $res = [];
    $sql = "show TABLES";

    $listdbtables = array_column($b_conn->query('SHOW TABLES')->fetch_all(), 0);
    foreach ($listdbtables as $tbl) {
        $sql = "TRUNCATE TABLE $tbl";
        mysqli_query($b_conn, $sql);
    }

    $sql = "SELECT * FROM `summary`";
    $qry = mysqli_query($sum_conn, $sql);
    while ($data = mysqli_fetch_assoc($qry)) {

        $sid = $data['sid'];
        $link = $data['link'];
        $bcoll = $data['bllc'];
        $bcaddress = $data['bcoll'];
        $lamnt = $data['tloan'];

        $idate = $data['odate'];
        $mdate = $data['mdate'];

        for ($i = 1; $i < 4; $i++) {
            $iequity = 0;
            $irate = 0;
            $prorated = 0;
            $rpayment = 0;

            if ("p$i" != 'None') {
                $uname = $data["p$i"];
                $iequity = $data["p$i" . "amt"];
                $irate = $data["p$i" . 'rate'];
                $rpayment = $data["p$i" . 'prorated'];
                $prorated = $data["p$i" . 'regular'];
                $sql = "INSERT INTO $uname ( sid, link, bcoll, bcaddress, loanamount, iequity, irate, rpayment, ppayment, idate, mdate) VALUES ('$sid', '$link', '$bcoll', '$bcaddress', '$lamnt', '$iequity', '$irate', '$rpayment', '$prorated','$idate', '$mdate') ";
                mysqli_query($b_conn, $sql);
            }
        }
    }
}
?>