<?php
include 'pdfconn.php';
include "../summary/summaryControl.php";
$c_summary = new Summary();
$summary = $c_summary->allDatas($sum_conn);
$monthsHeading = $c_summary->get_heading($sum_conn);
$monthDatas = $c_summary->getMonthlyData($sum_conn);
foreach ($summary as $sum) {
    $pid = $sum['sid'];
    $coll = $sum['bcoll'];
    $borr = $sum['bllc'];  
    // $title = $_POST['title'];
    $title = "December 22";
    $amnt = 0;
    foreach ($monthDatas as $md) {
    
        if ($md['sumid'] == $pid) { 
            // echo $md['sumid']." :: ";
            // echo $md["investor"]." - ".$md[$title]." - ";
            $amnt += floatval($md[$title]);
        }
    }
    // echo $amnt;
    // echo "<br><br><hr><br>";




    $result = mysqli_query($pdfconn, "SHOW COLUMNS FROM `invoices` LIKE '$title'");
    $exists = mysqli_num_rows($result);

    if ($exists == 0) {

        $qry = "ALTER TABLE `invoices` ADD `$title` VARCHAR(50)";
        mysqli_query($pdfconn, $qry);
    }

    $sql = "SELECT * FROM invoices WHERE id LIKE '$pid' LIMIT 1";
    if (mysqli_num_rows(mysqli_query($pdfconn, $sql)) == 0) {
        $sql = "INSERT INTO `invoices`( `id`, `collateral`, `borrower`) VALUES ('$pid', '$coll','$borr')";

        mysqli_query($pdfconn, $sql);
    }


    $sql = "UPDATE `invoices` SET `$title`='$amnt' WHERE id='$pid'";
    mysqli_query($pdfconn, $sql);
}
echo 1;
return 1;
?>