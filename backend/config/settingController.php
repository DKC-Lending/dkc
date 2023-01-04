<?php
$conn =  mysqli_connect("localhost", "riazhwtz_trialdkc", "9816084512Ab@", "riazhwtz_dkc");

$month = $_POST['month'];
$type = $_POST['type'];


$sql = ($type == 'on') ? "INSERT INTO `mtable`(`month`) VALUES ('$month')" : $sql = "DELETE FROM `mtable` WHERE `month`='$month'";
$res = mysqli_query($conn, $sql);

if ($res) {
    echo "complete";
} else {
    echo "error";
}
?>