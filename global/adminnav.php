<?php
session_start();
include_once('../backend/contact/getContactmsg.php');
$res = getLatestContact($cus_conn);
?>
<div id="navigation" align="center">

    <ul>
        <li title="Loan Summary"><a href="../admin/summary.php"><i class="fa-solid fa-border-all"></i></a></li>
        <?php
        if ($_SESSION['auser'] == 'david') {
        ?>
            <li title="Loan Approve"><a href="../admin/approve.php"><i class="fa-solid fa-thumbs-up"></i></a></li>

        <?php
        }

        ?>
        <li title="Investors/Participants"><a href="../admin/borrower.php"><i class="fa-solid fa-user-group"></i></a></li>
        <li title="Users"><a href="../admin/users.php"><i class="fa-solid fa-plus"></i></a></li>
        <li title="Investment Opportunity"><a href="../admin/investment.php"><i class="fa-solid fa-file"></i></a></li>
        <li title="Borrower"><a href="../admin/invoices.php"><i class="fa-solid fa-file-invoice-dollar"></i></a></li>
        <li title="Contact Us">
            <a href="../admin/contact.php" class="contact"><i class="fa-solid fa-headset"></i></a>
            <?php

            if ($res['status'] == 0 && strlen($res['status']) > 0) {
            ?>
                <span id="noti-alert"></span>
            <?php
            }
            ?>
        </li>
        <li title="Paidoff History"><a href="../admin/paidoffhistory.php"><i class="fa-solid fa-rectangle-xmark"></i></a>
    </ul>

    <a href="../admin/settings.php" class="setting"><i class="fa-solid fa-gear"></i></a>
</div>