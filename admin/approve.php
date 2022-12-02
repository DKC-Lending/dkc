<?php
session_start();
if ($_SESSION['auser'] != 'david') {
    header('Location: ../');
    exit();
}
?>
<?php include_once('../backend/adminsession.php'); ?>
<?php
include '../backend/config/conifg.php';
error_reporting(0);
$web = $config->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <title>Loan Approve - Admin| <?php echo $web["name"]; ?></title>
</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include "../global/links.html"; ?>
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link rel="stylesheet" type="text/css" href="../css/nav.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<link rel="stylesheet" type="text/css" href="../css/admin/approve.css">
<link rel="stylesheet" type="text/css" href="../css/topheader.css">
<script type="text/javascript" src="../js/changeimg.js"></script>
<script type="text/javascript" src="../js/webconfig.js"></script>
<?php include "../backend/summary/summaryControl.php"; ?>
<?php

$c_summary = new Summary();
$summary = $c_summary->preapprove($sum_conn);


?>

<body>
    <?php include "../global/adminnav.php" ?>
    <?php include "../global/adminheader.php" ?>
    <section class="main-container">
        <?php
        if (count($summary) > 0) {
        ?>
            <div class="scroll-container">
                <?php
                foreach ($summary as $summ) {

                ?>
                    <div class="card">
                        <table>
                            <tr>
                                <th colspan="4"><?php echo $summ['fname'] . " " . $summ['lname']; ?></th>
                                <th>
                                    <form method="post" action="../backend/summary/approveloan.php"><input type="hidden" name="sids" value="<?php echo $summ['sid']; ?>"> <button class="approve-btn approve"></button></form><button class="approve-btn reject"></button>
                                </th>
                            </tr>
                            <tr>
                                <td colspan="5" style="text-align: left;"><?php echo $summ['bcoll']; ?></td>

                            </tr>
                            <tr>
                                <td colspan="2"><?php echo $summ['bemail']; ?></td>
                                <td colspan="3"><?php echo $summ['bllc']; ?></td>
                            </tr>
                            <tr>
                                <td> <b><?php echo "$" . number_format($summ['tloan'], 2); ?></b></td>
                                <td colspan="2"></td>
                                <td colspan="2"><b><?php echo number_format($summ['irate']) . "%"; ?></b></td>

                            </tr>
                            <tr>
                                <td><?php echo $summ['bphone']; ?></td>
                                <td colspan="2"></td>
                                <td colspan="2"><?php echo "ACH " . $summ['ach']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $summ['service']; ?></td>
                                <td colspan="2"></td>
                                <td colspan="2"><?php echo $summ['iexpiry']; ?></td>
                            </tr>
                            <tr>
                                <td><?php echo $summ['odate']; ?></td>
                                <td colspan="2"></td>
                                <td colspan="2"><?php echo $summ['mdate']; ?></td>
                            </tr>
                            <tr>
                                <td><a href="<?php echo $summ['link']; ?>" target="_blank"><button>COLLATERAL URL</button></a></td>

                                <td colspan="1"><a href="<?php echo $summ['taxurl']; ?>" target="_blank"><button>TAX URL</button></a></td>
                                <td colspan="3"></td>
                            </tr>
                            <tr>
                                <td colspan="5">
                                    <hr>
                                </td>
                            </tr>
                            <tr>
                                <th>Investor</th>
                                <th>Amount</th>
                                <th>rate</th>
                                <th>regular</th>
                                <th>prorated</th>
                            </tr>
                            <tr>
                                <th>DKC</th>
                                <td><?php echo "$" . number_format($summ['dkcamt'], 2); ?></td>
                                <td><?php echo $summ['dkcrate'] . "%"; ?></td>
                                <td><?php echo "$" . number_format($summ['dkcregular'], 2); ?></td>
                                <td><?php echo "$" . number_format($summ['dkcprorated'], 2); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $summ['p1']; ?></th>
                                <td><?php echo "$" . number_format($summ['p1amt'], 2); ?></td>
                                <td><?php echo $summ['p1rate'] . "%"; ?></td>
                                <td><?php echo "$" . number_format($summ['p1regular'], 2); ?></td>
                                <td><?php echo "$" . number_format($summ['p1prorated'], 2); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $summ['p2']; ?></th>
                                <td><?php echo "$" . number_format($summ['p2amt'], 2); ?></td>
                                <td><?php echo $summ['p2rate'] . "%"; ?></td>
                                <td><?php echo "$" . number_format($summ['p2regular'], 2); ?></td>
                                <td><?php echo "$" . number_format($summ['p2prorated'], 2); ?></td>
                            </tr>
                            <tr>
                                <th><?php echo $summ['p3']; ?></th>
                                <td><?php echo "$" . number_format($summ['p3amt'], 2); ?></td>
                                <td><?php echo $summ['p3rate'] . "%"; ?></td>
                                <td><?php echo "$" . number_format($summ['p3regular'], 2); ?></td>
                                <td><?php echo "$" . number_format($summ['p3prorated'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Servicing</th>
                                <td><?php echo "$" . number_format($summ['servicingamt'], 2); ?></td>
                                <td><?php echo $summ['servicingrate'] . "%"; ?></td>
                                <td><?php echo "$" . number_format($summ['servicingregular'], 2); ?></td>
                                <td><?php echo "$" . number_format($summ['servicingprorated'], 2); ?></td>
                            </tr>
                            <tr>
                                <th>Yield</th>
                                <td><?php echo "$" . number_format($summ['yieldamt'], 2); ?></td>
                                <td><?php echo $summ['yieldrate'] . "%"; ?></td>
                                <td><?php echo "$" . number_format($summ['yieldregular'], 2); ?></td>
                                <td><?php echo "$" . number_format($summ['yieldprorated'], 2); ?></td>
                            </tr>
                            <?php
                            $samt =  "$" . number_format(floatval($summ['dkcamt']) + floatval($summ['p1amt']) + floatval($summ['p2amt']) + floatval($summ['p3amt']), 2);
                            $ramt =  "$" . number_format(floatval($summ['dkcregular']) + floatval($summ['p1regular']) + floatval($summ['p2regular']) + floatval($summ['p3regular']), 2);
                            $pamt =  "$" . number_format(floatval($summ['dkcprorated']) + floatval($summ['p1prorated']) + floatval($summ['p2prorated']) + floatval($summ['p3prorated']), 2);


                            ?>
                            <tr>
                                <th>Total</th>
                                <th><?php echo $samt; ?></th>
                                <td></td>
                                <th><?php echo $ramt; ?></th>
                                <th><?php echo $pamt; ?></th>
                            </tr>
                        </table>
                    </div>

                <?php
                }
                ?>
            </div>
        <?php
        } else { ?>
            <div class="empty">
            <img src="../img/misc/cloudman_drbl.gif" alt="">
            </div>
        <?php
        } ?>
    </section>
</body>

</html>