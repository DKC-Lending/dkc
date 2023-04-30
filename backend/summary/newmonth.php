<?php
include 'summary_connect.php';
include 'summaryControl.php';
// $title = $_POST['date'];
$title = "May 23";

$summary = new Summary();
$sumdatas = $summary->allDatas($sum_conn);
$monthsCollection = ["January", "February", "March", "April", "May", "June", "July", "August", "September", "October", "November", "December"];
$inv_holder = [];
$titleSplit = explode(" ", $title);
$fakeTitle = sprintf("%02d", (array_search($titleSplit[0], $monthsCollection) + 1)) . "-01-20" . $titleSplit[1];



foreach ($sumdatas as $sum) {

    if ($sum['status'] == '2' || $sum['status'] == 2) {
        //move loans that are paid off and have $0 last payment to Paid Off page
        $t = $summary->getLastMonthData($sum['sid'], $sum_conn);
        if ($t == 0) {
            $summary->closePaidOff($sum['sid'], $sum_conn);
            continue;
        }
    }
    $temp = [];  //clearing the temp file to hold the new data
    if ($sum['dkc'] != 'None') {
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['dkcregular']);
        array_push($temp, $sum['dkcprorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder[$sum['dkc']][] = $temp; //adding lenders to the array inv_holder
    }

    $temp = []; //clearing the temp file to hold the new data
    if ($sum['p1'] != 'None') {
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['p1regular']);
        array_push($temp, $sum['p1prorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder[$sum['p1']][] = $temp; //adding lenders to the array inv_holder
    }

    $temp = []; //clearing the temp file to hold the new data
    if ($sum['p2'] != 'None') {
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['p2regular']);
        array_push($temp, $sum['p2prorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder[$sum['p2']][] = $temp;  //adding lenders to the array inv_holder
    }

    $temp = []; //clearing the temp file to hold the new data
    if ($sum['p3'] != 'None') {
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['p3regular']);
        array_push($temp, $sum['p3prorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder[$sum['p3']][] = $temp; //adding lenders to the array inv_holder
    }

    $temp = []; //clearing the temp file to hold the new data
    if ($sum['p4'] != 'None') {
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['p4regular']);
        array_push($temp, $sum['p4prorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder[$sum['p4']][] = $temp; //adding lenders to the array inv_holder
    }

    $temp = []; //clearing the temp file to hold the new data
    if (true) { //servicing data
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['servicingregular']);
        array_push($temp, $sum['servicingprorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder['service'][] = $temp;
    }

    $temp = []; //clearing the temp file to hold the new data
    if (true) { //yield data
        array_push($temp, $sum['sid']);
        array_push($temp, $sum['odate']);
        array_push($temp, $sum['yieldregular']);
        array_push($temp, $sum['yieldprorated']);
        array_push($temp, $sum['iszero']);
        $inv_holder['yield'][] = $temp;
    }
    $temp = [];
}


$result = mysqli_query($sum_conn, "SHOW COLUMNS FROM `months` LIKE '$title'"); //check if new month exists
$exists = mysqli_num_rows($result);

if ($exists == 0) {  //if new month does not exist, create new month
    $qry = "ALTER TABLE `months` ADD `$title` VARCHAR(50)";
    mysqli_query($sum_conn, $qry);
}

//error in this page
foreach ($inv_holder as $key => $inv) {
    foreach ($inv as $i) {
        $sumid = $i[0];
        $sql = "SELECT * FROM months WHERE sumid = '$sumid' AND investor='$key' LIMIT 1";
        if (mysqli_num_rows(mysqli_query($sum_conn, $sql)) == 0) {
            $sql = "INSERT INTO `months`(`sumid`,`investor`) VALUES ('$sumid','$key')";

            mysqli_query($sum_conn, $sql);
        }

        $dar = explode("-", $i[1]);
        $mar = explode("-", $fakeTitle);

        $loanDay = intval($dar[1]);
        $currentDay = intval($mar[1]);
        $loanMonth = intval($dar[0]);
        $currentMonth = intval($mar[0]);
        $loanYear = intval($dar[2]);
        $currentYear = intval($mar[2]);


        $loanTimeString = $loanYear . "-" . $loanMonth . "-" . $loanDay;
        $currentTimeString = $currentYear . "-" . $currentMonth . "-" . $currentDay;

        $lDate = new DateTime($loanTimeString);
        $cDate = new DateTime($currentTimeString);

        $dayDiff = abs(intval($lDate->diff($cDate)->format("%r%a")));


        if ($loanDay == 31 && $loanMonth == 3) {
            echo "<br>" . $dayDiff . " " . $i[0] . " : " . $i[1] . "<br>";
        }
        // if (($loanMonth == $currentMonth && $loanYear == $currentYear) || ($loanMonth + 1 == $currentMonth && $loanYear == $currentYear)) {

        if ($i[4] == 0 || $i[4] == '0') {

            if ($loanMonth == $currentMonth && $loanYear == $currentYear) {
                $value = 0;
            } else {
                $proMonth = $loanMonth + 1;
                if ($proMonth == $currentMonth && $loanYear == $currentYear) {
                    $value = $i[3];
                } else {
                    if ($loanYear <= $currentYear) {
                        $value = $i[2];
                    }
                    // else {
                    //     $value = 0;
                    // }
                }
            }
        } else {

            $value = 0;
        }
        //    $mr = explode("-",$i[1]);
        //    if($mr[0]>6 && $mr[2]==2022){
        //                echo "<br>".$i[1]." : ".$value."<br>";

        //    }

        $sql = "UPDATE `months` SET `$title`='$value' WHERE sumid = '$sumid' AND investor='$key'";
        mysqli_query($sum_conn, $sql);
        // }
    }
}
echo "complete";
