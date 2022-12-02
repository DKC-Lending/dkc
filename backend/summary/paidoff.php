<?php
include "summary_connect.php";
$sid = $_POST["paidsid"];
$date = $_POST["exdate"];
$loanexfee = $_POST["lextension"];
$lenderadmin = $_POST["adminfee"];
$recordingfee = $_POST["rfee"];
$attorney = $_POST["afee"];
$latefee = $_POST['latefee'];
$extrafee = $_POST['extra'];
$senderdetail = $_POST['senderdetail'];
$receiverdetail = $_POST['receiverdetail'];

$notes = $_POST["paidnote"];
$amt = $_POST["totalpaidoff"];
$dkc = $_POST["dkcpaidoff"];
$p1 = $_POST["p1paidoff"];
$p2 = $_POST["p2paidoff"];
$p3 = $_POST["p3paidoff"];
$p4 = $_POST['p4paidoff'];
$servicing = $_POST["servicingpaidoff"];
$yield = $_POST["yieldpaidoff"];
$month = "MM";
$total = floatval($dkc) + floatval($p1) + floatval($p2) + floatval($p3) + floatval($p4) + floatval($servicing) + floatval($yield);
$sqli = "UPDATE `summary` SET  `tloan`='0',`dkcamt`='0',`p1amt`='0',`p2amt`='0',`p3amt`='0',`p4amt`='0',`servicingamt`='0',`yieldamt`='0',`dkcprorated`='$dkc',`dkcregular`='$dkc',`p1prorated`='$p1',`p1regular`='$p1',`p2prorated`='$p2',`p2regular`='$p2',`p3prorated`='$p3',`p3regular`='$p3',`p4prorated`='$p4',`p4regular`='$p4',`servicingprorated`='$servicing',`yieldprorated`='$yield',`servicingregular`='$servicing',`yieldregular`='$yield', `balance`='$total', `status`='2'  WHERE `sid`='$sid'";
mysqli_query($sum_conn, $sqli);

$sql = "INSERT INTO `paidoff`(`sid`, `date`, `loanfee`, `lenderfee`, `recordfee`, `attorneyfee`, `notes`, `amount`, `month`) VALUES('$sid', '$date', '$loanexfee', '$lenderadmin', '$recordingfee', '$attorney', '$notes','$amt','$month')";
mysqli_query($sum_conn, $sql);

function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    return ($path !== false AND is_dir($path)) ? $path : false;
}

$pdfdoc = $_POST['pdfuri'];
$decoded_pdf = substr($pdfdoc, strlen('data:application/pdf;filename=generated.pdf;base64,'));


if (folder_exist("../../paidoff/$sid")) {
    echo "gds";
    $pdf = fopen("../../paidoff/$sid/" . 'paidoff.pdf', 'w');
    fwrite($pdf, base64_decode($decoded_pdf));
} else {
    echo"sfs";
    mkdir("../../paidoff/$sid");
    $pdf = fopen("../../paidoff/$sid/" . 'paidoff.pdf', 'w');
    fwrite($pdf, base64_decode($decoded_pdf));
}

header('Location: ../../admin/summary.php');
exit();
