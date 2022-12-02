<?php
$uid = $_POST['uid'];
$file = $_POST['file'];

unlink("../../pdf/".$file);
// include 'pdfconn.php';

// $sql = "DELETE FROM `p$uid` WHERE date  ";
echo 1;
return 1;
?>