<?php
include 'summary_connect.php';

    $sql = "SELECT due from `due`";
    $res = mysqli_query($sum_conn, $sql);

    $due_drawn = mysqli_fetch_assoc($res)['due'];
  
    

?>