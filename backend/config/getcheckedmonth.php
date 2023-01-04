<?php
$conn =  mysqli_connect("localhost", "riazhwtz_trialdkc", "9816084512Ab@", "riazhwtz_dkc");

$sql = "SELECT `month` FROM `mtable`";
$res = mysqli_query($conn, $sql);
$table = [];
while($data = mysqli_fetch_assoc($res)){
    array_push($table, $data['month']);
}
echo json_encode($table);

?>