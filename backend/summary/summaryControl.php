<?php
include "summary_connect.php";

class Summary
{
    function allDatas($sum_conn)
    {
        $res = [];
        $sql = "SELECT * FROM `summary` WHERE `status`='1' OR `status`='2'";
        $qry = mysqli_query($sum_conn, $sql);
        while ($data = mysqli_fetch_assoc($qry)) {
            array_push($res, $data);
        }
        usort($res, function ($a, $b) {
            $ad =  explode("-", $a['odate']);
            $bd = explode("-", $b['odate']);
            $ad;
            $a =  $ad[2] . "-" . $ad[0] . "-" . $ad[1];
            $b =  $bd[2] . "-" . $bd[0] . "-" . $bd[1];

            return ((($a > $b))) ? 1 : -1;
        });

        return $res;
    }

    function closePaidOff($sid, $sum_conn)
    {
        $sql = "UPDATE `summary` SET `status`='3' WHERE `sid`='$sid'";
        if (mysqli_query($sum_conn, $sql)) {
            return true;
        } else {
            return false;
        }
    }

    function preapprove($sum_conn)
    {
        $res = [];
        $sql = "SELECT * FROM `summary` WHERE `status`='0'";
        $qry = mysqli_query($sum_conn, $sql);
        while ($data = mysqli_fetch_assoc($qry)) {
            array_push($res, $data);
        }
        usort($res, function ($a, $b) {
            $ad =  explode("-", $a['odate']);
            $bd = explode("-", $b['odate']);
            $ad;
            $a =  $ad[2] . "-" . $ad[0] . "-" . $ad[1];
            $b =  $bd[2] . "-" . $bd[0] . "-" . $bd[1];

            return ((($a > $b))) ? 1 : -1;
        });
        return $res;
    }
    function paidoffLoan($sum_conn)
    {
        $res = [];
        $sql = "SELECT * FROM `summary` WHERE `status`='2' OR `status`='3'";
        $qry = mysqli_query($sum_conn, $sql);
        while ($data = mysqli_fetch_assoc($qry)) {
            array_push($res, $data);
        }
        usort($res, function ($a, $b) {
            $ad =  explode("-", $a['odate']);
            $bd = explode("-", $b['odate']);
            $ad;
            $a =  $ad[2] . "-" . $ad[0] . "-" . $ad[1];
            $b =  $bd[2] . "-" . $bd[0] . "-" . $bd[1];

            return ((($a > $b))) ? 1 : -1;
        });
        return $res;
    }
    function paidoffNotes($sum_conn, $sid)
    {
        $res = [];
        $sql = "SELECT * FROM `paidoff` WHERE `sid`='$sid'";
        $qry = mysqli_query($sum_conn, $sql);
        while ($data = mysqli_fetch_assoc($qry)) {
            array_push($res, $data);
        }
        return $res;
    }

    function specificData($user, $sum_conn)
    {
        $res = [];
        $sql = "SELECT * FROM `summary` WHERE `status`='1' OR `status`='2'";
        $qry = mysqli_query($sum_conn, $sql);
        while ($datas = mysqli_fetch_assoc($qry)) {

            if ($datas['dkc'] != "None" && $datas['dkc'] == $user) {
                array_push($res, $datas);
            }

            if ($datas['p1'] != "None" && $datas['p1'] == $user) {
                array_push($res, $datas);
            }

            if ($datas['p2'] != "None" && $datas['p2'] == $user) {
                array_push($res, $datas);
            }

            if ($datas['p3'] != "None" && $datas['p3'] == $user) {
                array_push($res, $datas);
            }
            if ($datas['p4'] != "None" && $datas['p4'] == $user) {
                array_push($res, $datas);
            }
        }

        return $res;
    }

    function getMonthlyData($sum_conn)
    {
        $res = [];
        $sql = "SELECT * FROM `months`";
        $data = mysqli_query($sum_conn, $sql);
        while ($d = mysqli_fetch_assoc($data)) {
            array_push($res, $d);
        }
        return $res;
    }

    function getLastMonthData($sid, $sum_conn)
    {
        $s = new Summary();
        $months = $s->get_heading($sum_conn);
        $month = $months[count($months) - 1];
        $sql = "SELECT `$month` FROM `months` WHERE `sumid`='$sid'";
        $total = 0;
        $rslt = mysqli_query($sum_conn, $sql);
        while ($datas = mysqli_fetch_array($rslt)) {

            $total += floatval($datas[$month]);
        }
        return $total;
    }

    function get_heading($sum_conn)
    {
        $s = new Summary();
        $enable = $s->get_enable_month();
        $res = [];
        $sql = "DESCRIBE `months`";
        $rslt = mysqli_query($sum_conn, $sql);
        while ($datas = mysqli_fetch_array($rslt)) {
            if ($datas['Field'] != "mid" && $datas['Field'] != "sumid" && $datas['Field'] != "investor") {
                if (in_array($datas['Field'], $enable)) {
                    array_push($res, $datas['Field']);
                }
            }
        }
        return $res;
    }

    function get_enable_month()
    {
        $conn =  mysqli_connect("localhost", "riazhwtz_trialdkc", "9816084512Ab@", "riazhwtz_dkc");
        $sql = "SELECT `month` FROM `mtable`";
        $res = mysqli_query($conn, $sql);
        $table = [];
        while ($data = mysqli_fetch_assoc($res)) {
            array_push($table, $data['month']);
        }
        return $table;
    }

    function get_heading_setting($sum_conn)
    {
        $res = [];
        $sql = "DESCRIBE `months`";
        $rslt = mysqli_query($sum_conn, $sql);
        while ($datas = mysqli_fetch_array($rslt)) {
            if ($datas['Field'] != "mid" && $datas['Field'] != "sumid" && $datas['Field'] != "investor") {
                array_push($res, $datas['Field']);
            }
        }
        return $res;
    }

    function getSum($sum_conn, $sumdatas)
    {
        $inv_holder = [];
        foreach ($sumdatas as $sum) {
            $temp = [];
            if ($sum['dkcamt'] != 0 || $sum['dkcamt'] != '') {
                array_push($temp, $sum['dkcamt']);
                if (in_array($sum['dkc'], array_keys($inv_holder))) {
                    $inv_holder[$sum['dkc']] += $temp[0];
                } else {
                    $inv_holder[$sum['dkc']] = $temp[0];
                }
            }
            $temp = [];


            if ($sum['p1'] != 'None') {
                array_push($temp, $sum['p1amt']);
                if (in_array($sum['p1'], array_keys($inv_holder))) {
                    $inv_holder[$sum['p1']] += $temp[0];
                } else {
                    $inv_holder[$sum['p1']] = $temp[0];
                }
            }
            $temp = [];


            if ($sum['p2'] != 'None') {
                array_push($temp, $sum['p2amt']);
                if (in_array($sum['p2'], array_keys($inv_holder))) {
                    $inv_holder[$sum['p2']] += $temp[0];
                } else {
                    $inv_holder[$sum['p2']] = $temp[0];
                }
            }
            $temp = [];

            if ($sum['p3'] != 'None') {
                array_push($temp, $sum['p3amt']);
                if (in_array($sum['p3'], array_keys($inv_holder))) {
                    $inv_holder[$sum['p3']] += $temp[0];
                } else {
                    $inv_holder[$sum['p3']] = $temp[0];
                }
            }
            $temp = [];

            if ($sum['p4'] != 'None') {
                array_push($temp, $sum['p4amt']);
                if (in_array($sum['p4'], array_keys($inv_holder))) {
                    $inv_holder[$sum['p4']] += $temp[0];
                } else {
                    $inv_holder[$sum['p4']] = $temp[0];
                }
            }
        }
        return $inv_holder;
    }

    function get_multiple_collateral($sum_conn)
    {
        $res = [];
        $query = "SELECT summary.sid, summary.bllc, summary.bcoll,summary.bphone, summary.bemail, summary.mdate, summary.iexpiry, multiple.collateral, multiple.expiry FROM summary LEFT JOIN multiple ON summary.sid = multiple.sid ORDER by sid ASC";
        $qry = mysqli_query($sum_conn, $query);
        while ($data = mysqli_fetch_assoc($qry)) {
            $res[$data['sid']][] = $data;
        }
        return $res;
    }
}
