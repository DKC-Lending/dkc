<?php
include '../summary_connect.php';
$inv = $_POST['green-investor'];
$tunalloc = $_POST['trustunallocated'];
$talloc = $_POST['trustallocated'];
$draw = $_POST['duedraws2'];
$sql = "SELECT `investor` FROM  `participant`";
$res = mysqli_query($sum_conn, $sql);
$result = [];
while ($data = mysqli_fetch_assoc($res)) {
    array_push($result, $data['investor']);
}
if (in_array($inv, $result)) {
    $sql = "UPDATE `participant` SET `unalloc`='$tunalloc',`alloc`='$talloc',`draw`='$draw' WHERE investor = '$inv'";
} else {
    $sql = "INSERT INTO `participant`(`investor`, `unalloc`, `alloc`, `draw`) VALUES ('$inv', '$tunalloc', '$talloc', '$draw')";
}

mysqli_query($sum_conn, $sql);
header('Location: ../../../admin/summary.php');
?>