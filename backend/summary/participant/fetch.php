<?php
include '../summary_connect.php';

$sql = "SELECT * FROM  `participant`";
$res = mysqli_query($sum_conn, $sql);
$result = [];
while ($data = mysqli_fetch_assoc($res)) {
   $result[$data['investor']] = $data;
}

$participant_datas = $result;
?>