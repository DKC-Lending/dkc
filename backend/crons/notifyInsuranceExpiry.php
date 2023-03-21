
<?php
include '../summary/summary_connect.php';
include '../summary/summaryControl.php';
include '../message/email.php';
error_reporting(1);
$summaryControl = new Summary();
$summary = $summaryControl->get_multiple_collateral($sum_conn);
// echo json_encode($summary);


function getDaysUntilDate($dateString)
{
    if ($dateString == "00-00-0000") {
        return "Nope";
    }
    // Parse the date string and create a DateTime object.
    $dateTime = DateTime::createFromFormat('m-d-Y', $dateString);

    // Get the Unix timestamp for the DateTime object.
    $timestamp = $dateTime->getTimestamp();

    // Calculate the difference between the date and the current time in seconds.
    $difference = $timestamp - time();

    // If the difference is negative, the date has already passed.
    if ($difference < 0) {
        return "0";
    }

    // Convert the difference to days.
    $days = floor($difference / 86400);

    // Check if the date is within 7, 15, or 30 days.
    if ($days <= 7) {
        return "7";
    } else if ($days <= 15) {
        return "15";
    } else if ($days <= 30) {
        return "30";
    }

    // If the date is more than 30 days away, return an empty string.
    return "Nope";
}

function email_template($collateral, $days, $type, $borrower)
{
    $message = "
    <b>RE : Regarding the expiry of $collateral</b><br><br>
    
    Dear $borrower, <br><br>
    Your $collateral collateral $type date is going to expire in $days days. Please renew it as soon as possible.<br><br>

    Regards,<br>
    DKC Lending LLC<br>
    ";


    $subject = "Regarding the expiry of $collateral";

    echo $message;

    return array($message, $subject);
}

function compareandSendEmail($phone, $email, $type, $days, $collateral, $sid, $sum_conn, $bllc)
{
    $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = '$type' AND `alert` = '$days'";
    $qry = mysqli_query($sum_conn, $sql);
    $data = mysqli_fetch_assoc($qry);
    if ($data == null) {
        //Deleting the previous entry
        $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `type` = '$type' AND `collateral`='$collateral'";
        $qry = mysqli_query($sum_conn, $remove_sql);

        //Inserting new entry
        $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','$type', '$days')";
        $qry = mysqli_query($sum_conn, $sql);
        echo "Inserting new entry" . $sid . " " . $collateral . " " . $type . " " . $days . "<br>";
        // send_email();
        $template =  email_template($collateral, $days, $type, $bllc);
        $message = $template[0];
        $subject = $template[1];
        send_email($email, $message, $subject);
    } else {
        echo "Entry already exists" . $sid . " " . $collateral . " " . $type . " " . $days . "<br>";
    }
    if ($days == "0") {
        $template =  email_template($collateral, $days, $type, $bllc);
        $message = $template[0];
        $subject = $template[1];
        send_email($email, $message, $subject);
    }
}

foreach ($summary as $sum) {
    foreach ($sum as $s) {
        $sid = $s['sid'];
        $collateral = $s['bcoll'];
        $maturity = $s['mdate'];
        $insurance = $s['iexpiry'];
        $mulcol = $s['collateral'];
        $expiry  = $s['expiry'];
        $phone = $s['bphone'];
        $email = $s['bemail'];
        $borrower = $s['bllc'];
        $daysUntilMaturity = getDaysUntilDate($maturity);
        $daysUntilInsurance = getDaysUntilDate($insurance);

        if ($mulcol != "" || $mulcol != null) {
            $daysUntilExpiry = getDaysUntilDate($expiry);
        }

        switch ($daysUntilMaturity) {
            case "0":
                compareandSendEmail($phone, $email, "maturity", "0", $collateral, $sid, $sum_conn, $borrower);
                break;
            case "7":
                compareandSendEmail($phone, $email, "maturity", "7", $collateral, $sid, $sum_conn, $borrower);
                break;
            case "15":
                compareandSendEmail($phone, $email, "maturity", "15", $collateral, $sid, $sum_conn, $borrower);
                break;
            case "30":
                compareandSendEmail($phone, $email, "maturity", "30", $collateral, $sid, $sum_conn, $borrower);
                break;
            default:
                break;
        }

        switch ($daysUntilInsurance) {
            case "0":
                compareandSendEmail($phone, $email, "insurance", "0", $collateral, $sid, $sum_conn, $borrower);
                break;
            case "7":
                compareandSendEmail($phone, $email, "insurance", "7", $collateral, $sid, $sum_conn, $borrower);
                break;
            case "15":
                compareandSendEmail($phone, $email, "insurance", "15", $collateral, $sid, $sum_conn, $borrower);
                break;
            case "30":
                compareandSendEmail($phone, $email, "insurance", "30", $collateral, $sid, $sum_conn, $borrower);
                break;
            default:
                break;
        }

        if ($mulcol != "" || $mulcol != null) {
            switch ($daysUntilExpiry) {
                case "0":
                    compareandSendEmail($phone, $email, "insurance", "0", $mulcol, $sid, $sum_conn, $borrower);
                    break;
                case "7":
                    compareandSendEmail($phone, $email, "insurance", "7", $mulcol, $sid, $sum_conn, $borrower);
                    break;
                case "15":
                    compareandSendEmail($phone, $email, "insurance", "15", $mulcol, $sid, $sum_conn, $borrower);
                    break;
                case "30":
                    compareandSendEmail($phone, $email, "insurance", "30", $mulcol, $sid, $sum_conn, $borrower);
                    break;
                default:
                    break;
            }
        }









        // echo $daysUntilMaturity . " " . $daysUntilInsurance . " " . $daysUntilExpiry;
        // if ($daysUntilMaturity == "30") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'maturity' AND `alert` = '30'";
        //     echo $sql;
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `type` = 'maturity'";
        //         $qry = mysqli_query($sum_conn, $sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','maturity', '30')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "null";
        //     } else {
        //         echo "not null";
        //     }
        // } else if ($daysUntilMaturity == "15") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'maturity' AND `alert` = '15'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `type` = 'maturity'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','maturity', '15')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "null";
        //     } else {
        //         echo "not null";
        //     }
        // } else if ($daysUntilMaturity == "7") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'maturity' AND `alert` = '7'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `type` = 'maturity'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','maturity', '7')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "null";
        //     } else {
        //         echo "not null";
        //     }
        // } else if ($daysUntilMaturity == "0") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'maturity' AND `alert` = '0'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `type` = 'maturity'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','maturity', '0')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "null";
        //     } else {
        //         echo "not null";
        //     }
        // }
        // if ($daysUntilInsurance == "30") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '30'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '30')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "insurance null";
        //     } else {
        //         echo "not insurance null";
        //     }
        // } else if ($daysUntilInsurance == "15") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '15'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '15')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "insurance null";
        //     } else {
        //         echo "not insurance  null";
        //     }
        // } else if ($daysUntilInsurance == "7") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '7'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '7')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "insurance null";
        //     } else {
        //         echo "not insurance null";
        //     }
        // } else if ($daysUntilInsurance == "0") {
        //     $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '0'";
        //     $qry = mysqli_query($sum_conn, $sql);
        //     $data = mysqli_fetch_assoc($qry);
        //     if ($data == null) {
        //         //Deleting the previous entry
        //         $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance'";
        //         $qry = mysqli_query($sum_conn, $remove_sql);

        //         //Inserting new entry
        //         $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '0')";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         echo "insurance null";
        //     } else {
        //         echo "not insurance null";
        //     }
        // }
        // if ($mulcol != "" || $mulcol != null) {
        //     echo $daysUntilExpiry."<br>";
        //     if ($daysUntilExpiry == "30") {
        //         $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '30'";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         $data = mysqli_fetch_assoc($qry);
        //         if ($data == null) {
        //             //Deleting the previous entry
        //             $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance'";
        //             $qry = mysqli_query($sum_conn, $sql);

        //             //Inserting new entry
        //             $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '30')";
        //             $qry = mysqli_query($sum_conn, $sql);
        //             echo "insurance null";
        //         } else {
        //             echo "not insurance null";
        //         }
        //     } else if ($daysUntilExpiry == "15") {
        //         $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '15'";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         $data = mysqli_fetch_assoc($qry);
        //         if ($data == null) {
        //             //Deleting the previous entry
        //             $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance'";
        //             $qry = mysqli_query($sum_conn, $sql);

        //             //Inserting new entry
        //             $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '15')";
        //             $qry = mysqli_query($sum_conn, $sql);
        //             echo "insurance null";
        //         } else {
        //             echo "not insurance  null";
        //         }
        //     } else if ($daysUntilExpiry == "7") {
        //         $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid'AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '7'";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         $data = mysqli_fetch_assoc($qry);
        //         if ($data == null) {
        //             //Deleting the previous entry
        //             $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'insurance'";
        //             $qry = mysqli_query($sum_conn, $sql);

        //             //Inserting new entry
        //             $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '7')";
        //             $qry = mysqli_query($sum_conn, $sql);
        //             echo "insurance null";
        //         } else {
        //             echo "not insurance null";
        //         }
        //     } else if ($daysUntilExpiry == "0") {
        //         $sql = "SELECT * FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'insurance' AND `alert` = '0'";
        //         $qry = mysqli_query($sum_conn, $sql);
        //         $data = mysqli_fetch_assoc($qry);
        //         if ($data == null) {
        //             //Deleting the previous entry
        //             $remove_sql = "DELETE FROM `expiredTable` WHERE `sid` = '$sid' AND `collateral`='$collateral' AND `type` = 'insurance'";
        //             $qry = mysqli_query($sum_conn, $sql);

        //             //Inserting new entry
        //             $sql = "INSERT INTO `expiredTable`(`sid`,`collateral`, `type`, `alert`) VALUES ('$sid',  '$collateral','insurance', '0')";
        //             $qry = mysqli_query($sum_conn, $sql);
        //             echo "insurance null";
        //         } else {
        //             echo "not insurance null";
        //         }
        //     }
        // }
    }
}







?>