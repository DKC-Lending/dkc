<?php try { ?>
    <?php include_once('../backend/adminsession.php'); ?>
    <?php
    include '../backend/config/conifg.php';
    include '../backend/summary/get_multi_coll.php';
    error_reporting(0);
    $web = $config->fetch();
    ?>


    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin Paidoff | <?php echo $web["name"]; ?></title>
    </head>
    <?php include "../global/links.html"; ?>
    <meta name="description" content="DKC Lending Admin Paidoff History">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/global.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/buttons.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/admin/paidoff.css">
    <link rel="stylesheet" type="text/css" href="../css/topheader.css">
    <link rel="stylesheet" type="text/css" href="../css/alert.css">
    <script type="text/javascript" src="../js/summary.js"></script>

    <body>
        <?php include "../global/adminnav.php" ?>
        <?php include "../global/adminheader.php" ?>
        <?php include "../backend/usercontrol.php"; ?>
        <?php include "../backend/summary/summaryControl.php"; ?>
        <?php include "../backend/summary/participant/fetch.php"; ?>


        <?php
        $cUser = new Users();
        $allInvestor = $cUser->category_users($conn, 2);

        $c_summary = new Summary();
        $summary = $c_summary->paidoffLoan($sum_conn);
        $sumdatas = $c_summary->getSum($sum_conn, $summary);


        ?>
        <section class="top-text">
            <div class="top-head-txt">
                <div>
                    <p>Paidoff History<br>
                        <label class="sub-heading">
                            You can view all the closed Loan
                        </label>
                    </p>
                </div>
            </div>
        </section>


        <section class="main-wrapper">
            <div class="data-table">
                <?php
                foreach ($summary as $sums) {
                    $temploan = $sums['loan'];

                    $diff_loans[$temploan][] = $sums;
                }
                foreach ($diff_loans as $key => $diff) {

                ?>
                    <br>
                    <br>
                    <strong><?php echo  $key; ?></strong>
                    <br>
                    <br>
                    <table class="data-table-tbl" id="main-sum-tbl">
                        <thead>
                            <tr>
                                <td>
                                    PDF
                                </td>
                                <td>
                                    Notes
                                </td>
                                <td>
                                    Link
                                </td>
                                <td onclick="sortTable('main-sum-tbl',3)">
                                    Borrower LLC
                                </td>
                                <td>
                                    Collateral Address
                                </td>
                                <td onclick="sortTable('main-sum-tbl',7)">
                                    Total Loan
                                </td>
                                <td>
                                    DKC #0
                                </td>
                                <td>
                                    Part #1
                                </td>
                                <td>
                                    Part #1 Rate
                                </td>

                                <td>
                                    Part #2
                                </td>

                                <td>
                                    Part #2 Rate
                                </td>

                                <td>
                                    Part #3
                                </td>
                                <td>
                                    Part #3 Rate
                                </td>

                                <td>
                                    Total Rate
                                </td>
                                <td onclick="sortTable('main-sum-tbl',16)">
                                    Total Payment
                                </td>
                                <td>
                                    DKC Payment
                                </td>
                                <td>
                                    Part #1 Payment
                                </td>
                                <td>
                                    Part #2 Payment
                                </td>
                                <td>
                                    Part #3 Payment
                                </td>
                                <td>
                                    Servicing(1%)
                                </td>
                                <td>
                                    Yield Spread
                                </td>
                                <td onclick="sortTable('main-sum-tbl',23)">
                                    Check/ Balance
                                </td>

                            </tr>
                        </thead>

                        <tbody>
                            <?php
                            $total_total_loan = 0;
                            $total_dkc = 0;
                            $total_p1 = 0;
                            $total_p2 = 0;
                            $total_p3 = 0;
                            $total_payment = 0;
                            $total_dkc_payment = 0;
                            $total_p1_payment = 0;
                            $total_p2_payment = 0;
                            $total_p3_payment = 0;
                            $total_total_payment = 0;
                            $total_servicing = 0;
                            $total_yield = 0;
                            $total_balance = 0;
                            $sn = 0;
                            foreach ($diff as $sum) {

                                $url = $sum['link'];
                                $caddress = $sum['bcoll'];
                                $tloan = $sum['tloan'];
                                $total_total_loan += $sum['tloan'];

                                $dkc = ($sum['dkcamt'] == 0) ? 0 :  $sum['dkcamt'];
                                $total_dkc += $sum['dkcamt'];

                                $p1amt = ($sum['p1amt'] == 0) ? 0 : $sum['p1amt'];
                                $total_p1 += $sum['p1amt'];
                                $p1rate = ($sum['p1rate'] == 0) ? "N/A" : $sum['p1rate'] . "%";

                                $p2amt = ($sum['p2amt'] == 0) ? 0 : $sum['p2amt'];
                                $total_p2 += $sum['p2amt'];
                                $p2rate = ($sum['p2rate'] == 0) ? "N/A" : $sum['p2rate'] . "%";

                                $p3amt = ($sum['p3amt'] == 0) ? 0 : $sum['p3amt'];
                                $total_p3 += $sum['p3amt'];
                                $p3rate = ceil($sum['p3rate'] == 0) ? "N/A" : $sum['p3rate'] . "%";

                                $trate = $sum['irate'];

                                $dkcpayment = $sum['dkcregular'];

                                $total_dkc_payment += $sum['dkcregular'];
                                $p1payment = $sum['p1regular'];
                                $total_p1_payment = $sum['p1regular'];
                                $p2payment = $sum['p2regular'];
                                $total_p2_payment += $sum['p2regular'];
                                $p3payment = $sum['p3regular'];
                                $total_p3_payment += $sum['p3regular'];

                                $tpayment = $sum['balance'];
                                $total_total_payment  += $sum['balance'];
                                $servicing = ($sum['servicingregular'] == 0) ? 0 : $sum['servicingregular'];
                                $total_servicing += $sum['servicingregular'];
                                $yield = ($sum['yieldregular'] == 0) ? 0 :  $sum['yieldregular'];
                                $total_yield += $sum['yieldregular'];
                                $balance =   $sum['balance'];
                                $total_balance += $sum['balance'];

                                $sn++;

                            ?>



                                <tr class="tablerow">
                                    <td>
                                        <a style="text-decoration:none;color:red" href="../paidoff/<?php echo $sum['sid']; ?>/paidoff.pdf" target="blank">download</a>
                                    </td>

                                    <?php
                                    $temp_mul = [];
                                    $temp_expiry = [];
                                    if (count($multi_arr) > 0) {
                                        foreach ($multi_arr as $mul) {
                                            if ($sum['sid'] == $mul['sid']) {
                                                $temp_mul = explode(":", $mul["collateral"]);
                                                $temp_expiry = explode(":", $mul["expiry"]);
                                                break;
                                            } else {
                                                $temp_mul = [];
                                                $temp_expiry = [];
                                            }
                                        }
                                    }
                                    ?>
                                    <td class="action-holder">
                                        <label><?php echo $c_summary->paidoffNotes($sum_conn, $sum['sid'])[0]['notes']; ?></label>
                                    </td>

                                    <td><a href="<?php echo $url; ?>" target="_blank" style="color:skyblue;"><i class="fa-solid fa-file"></a></td>
                                    <td><?php echo ($sum['bllc']); ?></td>



                                    <?php

                                    if (count($temp_mul) > 0) {
                                    ?>
                                        <td onmouseout='deleteconfirm()' onmouseover='hoverconfirm(<?php echo json_encode($temp_mul); ?>)'> <?php echo ($caddress); ?></td>

                                    <?php
                                    } else {
                                    ?>
                                        <td> <?php echo ($caddress); ?></td>
                                    <?php
                                    }
                                    ?>


                                    <td><?php echo  "$" . number_format($tloan, 2); ?></td>
                                    <td onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($dkc, 2); ?><p><?php echo ($sum['dkc']); ?></p>
                                    </td>
                                    <td onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p1amt, 2); ?><p><?php echo ($sum['p1']); ?></p>
                                    </td>
                                    <td><?php echo $p1rate; ?></td>

                                    <td onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p2amt, 2); ?><p><?php echo ($sum['p2']); ?></p>
                                    </td>
                                    <td><?php echo $p2rate; ?></td>

                                    <td onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p3amt, 2); ?><p><?php echo ($sum['p3']); ?></p>
                                    </td>
                                    <td><?php echo $p3rate; ?></td>

                                    <td><?php echo floor($trate) . "%"; ?></td>
                                    <td><?php echo  "$" . number_format($tpayment, 2); ?></td>
                                    <td><?php echo  "$" . number_format($dkcpayment, 2); ?></td>
                                    <td><?php echo  "$" . number_format($p1payment, 2); ?></td>
                                    <td><?php echo  "$" . number_format($p2payment, 2); ?></td>
                                    <td><?php echo  "$" . number_format($p3payment, 2); ?></td>
                                    <td><?php echo  "$" . number_format($servicing, 2); ?></td>
                                    <td><?php echo  "$" . number_format($yield, 2); ?></td>
                                    <td><?php echo  "$" . number_format($balance, 2); ?></td>

                                </tr>

                            <?php
                            }
                            ?>
                            <tr>
                                <td colspan="5" style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>

                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_total_loan, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_dkc, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p1, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p2, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p3, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_total_payment, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_dkc_payment, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p1_payment, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p2_payment, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p3_payment, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_servicing, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_yield, 2); ?></td>
                                <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_balance, 2); ?></td>

                            </tr>
                        </tbody>
                    </table>
                <?php
                }
                ?>

            </div>
        </section>




        <script>
            $(".dragok").children($("p")).hide();
        </script>



        <?php include "../global/footer.php"; ?>

    </body>

    </html>

<?php
} catch (Error $er) {
    ob_clean();
    include('../500.php');
} finally {
    ob_flush();
}
?>