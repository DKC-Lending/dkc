<?php
ob_start();
try {
?>
    <?php include_once('../backend/adminsession.php'); ?>
    <?php
    include '../backend/config/conifg.php';
    include '../backend/summary/get_multi_coll.php';
    error_reporting(0);
    $web = $config->fetch();
    ?>
    <?php

    include '../backend/summary/getDraw.php';
    $due = $due_drawn;
    $curDate = date("m-d-Y");

    function get_diff($d1, $d2)
    {
        $m = explode("-", $d1);
        $m1 = explode("-", $d2);
        $nd = $m[2] . "/" . $m[0] . "/" . $m[1];
        $nd2 = $m1[2] . "/" . $m1[0] . "/" . $m1[1];
        $day = ((strtotime($nd) - strtotime($nd2)) / 86400);
        if ($day > 0) {
            return "expired";
        } else if (-30 <= ((strtotime($nd) - strtotime($nd2)) / 86400)) {
            return "expire-soon";
        } else {
            return "";
        }
    }
    ?>

    <!DOCTYPE html>
    <html lang="en">

    <head>
        <title>Admin Summary | <?php echo $web["name"]; ?></title>
    </head>
    <?php include "../global/links.html"; ?>
    <meta name="description" content="DKC Lending Admin Summary">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../css/global.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/nav.css">
    <link rel="stylesheet" type="text/css" href="../css/buttons.css">
    <link rel="stylesheet" type="text/css" href="../css/footer.css">
    <link rel="stylesheet" type="text/css" href="../css/admin/summary.css">
    <link rel="stylesheet" type="text/css" href="../css/topheader.css">
    <link rel="stylesheet" type="text/css" href="../css/alert.css">
    <?php include "../global/alert.html"; ?>
    <script type="text/javascript" src="../js/alert.js"></script>
    <script type="text/javascript" src="../js/summary.js"></script>

    <script src="../js/html2pdf.bundle.js"></script>

    <body>

        <?php include "../global/adminnav.php" ?>
        <?php include "../global/adminheader.php" ?>
        <?php include "../backend/usercontrol.php"; ?>
        <?php include "../backend/summary/summaryControl.php"; ?>
        <?php include "../backend/summary/participant/fetch.php"; ?>

        <?php include "../admin/paidoffsample.php"; ?>
        <?php
        $cUser = new Users();
        $allInvestor = $cUser->category_users($conn, 2);

        $c_summary = new Summary();
        $summary = $c_summary->allDatas($sum_conn);
        $pre_summary = $c_summary->preapprove($sum_conn);
        $sumdatas = $c_summary->getSum($sum_conn, $summary);


        ?>
        <section id="whole-body-wrapper">
            <section class="top-text">
                <div class="top-head-txt">
                    <div>
                        <p>Loan Summary <br>
                            <label class="sub-heading">
                                You can add, update or delete users from here
                            </label>
                        </p>
                    </div>
                </div>
            </section>
            <form method="get" action="../backend/summary/add_summary.php" id="main-form">
                <section class="form-holder" id="main-main-data-table">
                    <div class="left-form">
                        <div class="coll-info">
                            <input type="hidden" name="sum-id" id="sum-id" />
                            <p class="card-title">Add Participant Summary</p>
                            <input type="text" placeholder="Borrower LLC" name="bllc" id="bllc" required />
                            <div>
                                <input type="text" placeholder="First Name" name="fname" id="fname" required />
                                <input type="text" placeholder="Last Name" name="lname" id="lname" required />
                            </div>
                            <input type="text" placeholder="Collateral Address" name="caddress" id="caddress" required />
                            <input type="text" placeholder="Collateral Link (GDrive)" name="clink" id="clink" required />
                            <div>
                                <input type="number" step=".01" placeholder="Total Loan Amount" name="tloan" id="tloan" required />
                                <input type="number" step=".01" placeholder="Interest Rate" name="irate" id="irate" required />
                            </div>
                            <div>
                                <input type="text" placeholder="Origination Date (mm-dd-YYYY)" name="odate" id="odate" required />
                                <input type="text" placeholder="Maturity Date (mm-dd-YYYY)" name="mdate" id="mdate" required />
                            </div>
                        </div>
                        <div class="borrower-info">
                            <p class="card-title">Borrower Information</p>
                            <div>
                                <input type="text" placeholder="Borrower phone number" name="bnum" id="bnum" required />
                                <input type="email" placeholder="Borrower email address" name="bemail" id="bemail" required />
                            </div>
                            <div>
                                <input type="text" placeholder="Insurance Expiry (mm-dd-YYYY)" name="bexpiry" id="bexpiry" required />
                                <input type="text" placeholder="Tax URL" name="taxurl" id="taxurl" required />
                            </div>
                            <div>
                                <div>
                                    <label>ACH</label>
                                    <input type="checkbox" name="ach" id="ach" />
                                </div>
                                <select name="business" id="business">
                                    <option value="Fix and Flip">Fix and Flip</option>
                                    <option value="New Construction">New Construction</option>
                                    <option value="Refinance">Refinance</option>
                                    <option value="Non Recourse">Non Recourse</option>
                                    <option value="Fix and Lease">Fix and Lease</option>
                                    <option value="Manufactured Mobile Home">Manufactured Mobile Home</option>
                                    <option value="Transactional Funding">Transactional Funding</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="right-form">
                        <div class="multiple-collateral">
                            <div class="col-head">
                                <label>Multiple Collateral</label>
                                <button id="multi-col-btn" onclick="add_multi_collateral(event)">+</button>
                            </div>
                            <div class="mul-body" id="multi-coll">

                            </div>
                        </div>

                        <div class="investor-info">
                            <table>
                                <thead>
                                    <tr>
                                        <th>Lender</th>
                                        <th>Amount</th>
                                        <th>Rate</th>
                                        <th>Prorated</th>
                                        <th>Regular</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>
                                            <select name="dkc" id="dkc">
                                                <option value="None">None</option>
                                                <option value="DKC">DKC Lending LLC</option>
                                                <option value="DKCFL">DKC Lending FL</option>
                                                <option value="DKCCL">DKC Lending CFL</option>
                                                <option value="FCT1">First Capital Trusts</option>
                                                <option value="DKCIV">DKC Lending IV</option>
                                                <option value="DKCL">DKC Lending CL</option>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" value='0' step=".01" name="dkcamnt" id="dkcamnt" onchange="calculateTotal()" onkeyup="calculateTotal()"">
                                </td>
                                <td>
                                    <input type=" number" value='0' step=".01" name="dkcrate" id="dkcrate" onchange="calculatePayment(this,'dkc')" onkeyup="calculatePayment(this,'dkc')">
                                        </td>
                                        <td>
                                            <input type="number" value='0.00' step=".01" name="dkcprorated" id="dkcprorated" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" value='0.00' step=".01" name="dkcregular" id="dkcregular" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="p1" id="p1">
                                                <option value="None">None</option>
                                                <?php
                                                foreach ($allInvestor as $investor) {
                                                    $ovalue = $investor['fname'] . " " . $investor["lname"];
                                                    if ($investor['username'] == 'EFisherLewis') $ovalue = "Elizabeth E Fisher (Trust 2)";
                                                    if ($investor['username'] == 'ElizabethFisher') $ovalue = "Elizabeth E Fisher (Trust 1)";

                                                ?>
                                                    <option value="<?php echo $investor['username']; ?>"><?php echo $ovalue; ?></option>
                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p1amnt" id="p1amnt" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p1rate" id="p1rate" onchange="calculatePayment(this,'p1')" onkeyup="calculatePayment(this,'p1')">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p1prorated" id="p1prorated" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p1regular" id="p1regular" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="p2" id="p2">
                                                <option value="None">None</option>
                                                <?php
                                                foreach ($allInvestor as $investor) {
                                                    $ovalue = $investor['fname'] . " " . $investor["lname"];
                                                    if ($investor['username'] == 'EFisherLewis') $ovalue = "Elizabeth E Fisher (Trust 2)";
                                                    if ($investor['username'] == 'ElizabethFisher') $ovalue = "Elizabeth E Fisher (Trust 1)";

                                                ?>
                                                    <option value="<?php echo $investor['username']; ?>"><?php echo  $ovalue; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p2amnt" id="p2amnt" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p2rate" id="p2rate" onchange="calculatePayment(this,'p2')" onkeyup="calculatePayment(this,'p2')">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p2prorated" id="p2prorated" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p2regular" id="p2regular" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="p3" id="p3">
                                                <option value="None">None</option>
                                                <?php
                                                foreach ($allInvestor as $investor) {
                                                    $ovalue = $investor['fname'] . " " . $investor["lname"];
                                                    if ($investor['username'] == 'EFisherLewis') $ovalue = "Elizabeth E Fisher (Trust 2)";
                                                    if ($investor['username'] == 'ElizabethFisher') $ovalue = "Elizabeth E Fisher (Trust 1)";

                                                ?>
                                                    <option value="<?php echo $investor['username']; ?>"><?php echo  $ovalue; ?></option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p3amnt" id="p3amnt" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p3rate" id="p3rate" onchange="calculatePayment(this,'p3')" onkeyup="calculatePayment(this,'p3')">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p3prorated" id="p3prorated" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p3regular" id="p3regular" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <select name="p4" id="p4">
                                                <option value="None">None</option>
                                                <?php
                                                foreach ($allInvestor as $investor) {
                                                    $ovalue = $investor['fname'] . " " . $investor["lname"];
                                                    if ($investor['username'] == 'EFisherLewis') $ovalue = "Elizabeth E Fisher (Trust 2)";
                                                    if ($investor['username'] == 'ElizabethFisher') $ovalue = "Elizabeth E Fisher (Trust 1)";

                                                ?>
                                                    <option value="<?php echo $investor['username']; ?>"><?php echo  $ovalue; ?></option>
                                                <?php
                                                }
                                                ?>

                                            </select>
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p4amnt" id="p4amnt" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p4rate" id="p4rate" onchange="calculatePayment(this,'p4')" onkeyup="calculatePayment(this,'p4')">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p4prorated" id="p4prorated" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="p4regular" id="p4regular" onchange="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td>
                                            <p>DKC Servicing Fee Income</p>
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="servicingamnt" id="servicingamnt">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="servicingrate" id="servicingrate" onchange="calculatePayment(this,'servicing')" onkeyup="calculatePayment(this,'servicing')">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="servicingprorated" id="servicingprorated" onfocus="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="servicingregular" id="servicingregular" onfocus="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr>
                                        <td onclick="calculateYield()">
                                            <p> Yield Spread</p>
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="yieldamnt" id="yieldamnt">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="yieldrate" id="yieldrate" onchange="calculatePayment(this,'yield')">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="yieldprorated" id="yieldprorated" onfocus="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                        <td>
                                            <input type="number" step=".01" name="yieldregular" id="yieldregular" onfocus="calculateTotal()" onkeyup="calculateTotal()">
                                        </td>
                                    </tr>
                                    <tr style="background-color:rgba(196, 196, 196, 0.3); color:white; font-weight:bold; text-align:center;">
                                        <td>Total</td>
                                        <td>
                                            <p id="total_amount_add"></p>
                                        </td>
                                        <td></td>
                                        <td>
                                            <p id="total_prorated_add"></p>
                                        </td>
                                        <td>
                                            <p id="total_regular_add"></p>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                            <div>
                                <label>Zero Loan :</label>
                                <select id="iszero" name="iszero">
                                    <option value="0">no</option>
                                    <option value="1">yes</option>
                                </select>
                            </div>

                            <input type="hidden" name="check" id="check" />
                            <!-- <div>
                        <label>Servicing: </label><input type="number" step=".01" name="servicing" id="servicing" required />
                    </div>
                    <div>
                        <label>Yield: </label><input type="number" step=".01" name="yield" id="yield" required />
                    </div> -->
                            <!-- <div>
                        <label>Check/ Balance: </label>
                    </div> -->
                            <button>Save Summary</button>
                        </div>

                    </div>

                </section>
            </form>
            <div id="mail-holder" style="display: none;">

                <div style="display:flex;"><label></label> <button onclick="reload()">X</button> </div>
                <center style="display: flex;align-items:center;">
                    <h4>Mail to : </h4> &nbsp;<label id="mailto"></label>
                </center>
                <input type="text" placeholder="Enter subject" class="subject-box" id="subject" />
                <textarea class="message-box" placeholder="Enter your body" id="message-box">
            </textarea>
                <button class="sent-btn" onclick="sentEmail()">Send Email</button>
            </div>


            <section class="data-table">
                <button class="pending-btn">Pending Loan - <?php echo count($pre_summary); ?></button>
            </section>

            <section class="data-table">
                <?php
                foreach ($summary as $sums) {
                    $temploan = $sums['loan'];
                    $diff_loans[$temploan][] = $sums;
                }
                $cc = 0;
                $temp_loans = [];
                array_push($temp_loans, $diff_loans['DKC Lending LLC']);
                array_push($temp_loans, $diff_loans['DKC Lending FL']);
                array_push($temp_loans, $diff_loans['First Capital Trusts LLC']);
                array_push($temp_loans, $diff_loans['DKC Lending CL']);
                array_push($temp_loans, $diff_loans['DKC Lending IV']);

                $diff_loans = $temp_loans;
                $grand_total = 0;
                $grand_p1 = 0;
                $grand_p2 = 0;
                $grand_p3 = 0;
                $grand_p4 = 0;
                $grand_dkc = 0;
                foreach ($diff_loans as $diff) {
                    if ($diff != null) {
                ?>
                        <br>
                        <br>
                        <strong><?php echo  $diff[0]['loan']; ?></strong>
                        <br>
                        <br>
                        <!-- Start the main table of the page  -->
                        <table class="data-table-tbl" id="main-sum-tbl<?php echo  $diff[0]['loan']; ?>">
                            <thead>
                                <tr>
                                    <td class="freeze">
                                        Action
                                    </td>

                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',1)" class="freeze">
                                        Borrower LLC
                                    </td>
                                    <td class="freeze" onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',2)">
                                        Collateral Address
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',3)" class="freeze">
                                        Total Loan
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',4)">
                                        Lender
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',5)">
                                        Part #1
                                    </td>
                                    <td>
                                        Part #1 Rate
                                    </td>

                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',7)">
                                        Part #2
                                    </td>

                                    <td>
                                        Part #2 Rate
                                    </td>

                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',9)">
                                        Part #3
                                    </td>
                                    <td>
                                        Part #3 Rate
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',11)">
                                        Part #4
                                    </td>
                                    <td>
                                        Part #4 Rate
                                    </td>

                                    <td>
                                        Total Rate
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',14)">
                                        Total Payment
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',15)">
                                        DKC Payment
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',16)">
                                        Part #1 Payment
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',17)">
                                        Part #2 Payment
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',  18)">
                                        Part #3 Payment
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',19)">
                                        Part #4 Payment
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',20)">
                                        Servicing(1%)
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',21)">
                                        Yield Spread
                                    </td>
                                    <td onclick="sortTable('main-sum-tbl<?php echo  $diff[0]['loan']; ?>',22)">
                                        Check/ Balance
                                    </td>

                                </tr>
                            </thead>
                            <!-- Start the body of the table -->
                            <tbody>
                                <?php
                                $total_total_loan = 0;
                                $total_dkc = 0;
                                $total_p1 = 0;
                                $total_p2 = 0;
                                $total_p3 = 0;
                                $total_p4 = 0;
                                $total_payment = 0;
                                $total_dkc_payment = 0;
                                $total_p1_payment = 0;
                                $total_p2_payment = 0;
                                $total_p3_payment = 0;
                                $total_p4_payment = 0;
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
                                    $grand_total += $tloan;

                                    $dkc = ($sum['dkcamt'] == 0) ? 0 :  $sum['dkcamt'];

                                    $total_dkc += $sum['dkcamt'];
                                    $grand_dkc += ($sum['dkc'] == 'DKC') ? $sum['dkcamt'] : 0;

                                    $p1amt = ($sum['p1amt'] == 0) ? 0 : $sum['p1amt'];
                                    $total_p1 += $sum['p1amt'];
                                    $grand_p1 += ($sum['dkc'] != 'DKC') ? $sum['dkcamt'] : 0;
                                    $grand_p1 += $sum['p1amt'];
                                    $p1rate = ($sum['p1rate'] == 0) ? "N/A" : $sum['p1rate'] . "%";

                                    $p2amt = ($sum['p2amt'] == 0) ? 0 : $sum['p2amt'];
                                    $total_p2 += $sum['p2amt'];
                                    $grand_p2 += $sum['p2amt'];
                                    $p2rate = ($sum['p2rate'] == 0) ? "N/A" : $sum['p2rate'] . "%";

                                    $p3amt = ($sum['p3amt'] == 0) ? 0 : $sum['p3amt'];
                                    $total_p3 += $sum['p3amt'];
                                    $grand_p3 += $sum['p3amt'];
                                    $p3rate = ceil($sum['p3rate'] == 0) ? "N/A" : $sum['p3rate'] . "%";

                                    $p4amt = ($sum['p4amt'] == 0) ? 0 : $sum['p4amt'];
                                    $total_p4 += $sum['p4amt'];
                                    $grand_p4 += $sum['p4amt'];
                                    $p4rate = ceil($sum['p4rate'] == 0) ? "N/A" : $sum['p4rate'] . "%";

                                    $trate = $sum['irate'];
                                    $dkcpayment = $sum['dkcregular'];

                                    $total_dkc_payment += $sum['dkcregular'];
                                    $p1payment = $sum['p1regular'];
                                    $total_p1_payment = $sum['p1regular'];
                                    $p2payment = $sum['p2regular'];
                                    $total_p2_payment += $sum['p2regular'];
                                    $p3payment = $sum['p3regular'];
                                    $total_p3_payment += $sum['p3regular'];
                                    $p4payment = $sum['p4regular'];
                                    $total_p4_payment += $sum['p4regular'];

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

                                    <?php
                                    $exp = "";
                                    $class = get_diff(date("m-d-Y"), $sum['mdate']);
                                    ?>

                                    <tr class="tablerow <?php echo ($sum['tloan'] > 0) ? '' : 'paidoff-red'; ?>">

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
                                            <button class="edit-btn payoff-btn" title="Paidoff Btn" onclick='cutloan(<?php echo json_encode($sum); ?>)'><i class="fa-solid fa-money-bill"></i></button>
                                            <button class="edit-btn" title="Edit Btn" onclick='editSummary(<?php echo json_encode($sum); ?>,<?php echo json_encode($temp_mul); ?>,<?php echo json_encode($temp_expiry); ?>)'><i class="fa-solid fa-pen-to-square"></i></button>
                                            <button class="del-btn" title="Delete Btn" onclick="deleteSummary(<?php echo $sum['sid']; ?>)"><i class="fa-solid fa-trash"></i></button>
                                            <button class="call-btn" title="Message Btn" onclick="messageBorrower(`<?php echo $sum['bphone']; ?>`, `<?php echo $sum['bllc']; ?>`)"><i class="fa-solid fa-phone"></i></button>
                                            <button class="mail-btn" title="Email Btn" onclick="mailBorrower(`<?php echo $sum['bemail']; ?>`)"><i class="fa-solid fa-envelope"></i></button>
                                            <a href="<?php echo $url; ?>" title="Link" target="_blank" style="color:skyblue;"><button class="link-btn"><i class="fa-solid fa-file"></i></button></a>
                                        </td>

                                        <td><?php echo ($sum['bllc']); ?></td>

                                        <?php if (count($temp_mul) > 0) { ?>
                                            <td onmouseout='deleteconfirm()' title="<?php foreach ($temp_mul as $ctemp) {
                                                                                        echo $ctemp . "\n";
                                                                                    } ?>" onmouseover='hoverconfirm(<?php echo json_encode($temp_mul); ?>)'> <label title="<?php foreach ($temp_mul as $ctemp) {
                                                                                                                                                                            echo $ctemp . "\n";
                                                                                                                                                                        } ?>"><?php echo ($caddress); ?></label>
                                                <div class="col-count"><?php echo count($temp_mul); ?></div>
                                            </td>

                                        <?php } else { ?>
                                            <td><?php echo ($caddress); ?></td>
                                        <?php  } ?>


                                        <td><?php echo  "$" . number_format($tloan, 2); ?></td>
                                        <td class="dragok" onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($dkc, 2); ?><p><?php echo ($sum['dkc']); ?></p>
                                        </td>
                                        <td class="dragok" onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p1amt, 2); ?><p><?php echo ($sum['p1']); ?></p>
                                        </td>
                                        <td><?php echo $p1rate; ?></td>

                                        <td class="dragok" onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p2amt, 2); ?><p><?php echo ($sum['p2']); ?></p>
                                        </td>
                                        <td><?php echo $p2rate; ?></td>

                                        <td class="dragok" onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p3amt, 2); ?><p><?php echo ($sum['p3']); ?></p>
                                        </td>
                                        <td><?php echo $p3rate; ?></td>
                                        <td class="dragok" onmouseover="cardhover(this)" onmouseout="cardout(this)"><?php echo  "$" . number_format($p4amt, 2); ?><p><?php echo ($sum['p4']); ?></p>
                                        </td>
                                        <td><?php echo $p4rate; ?></td>

                                        <td><?php echo floor($trate) . "%"; ?></td>
                                        <td><?php echo  "$" . number_format($tpayment, 2); ?></td>
                                        <td><?php echo  "$" . number_format($dkcpayment, 2); ?></td>
                                        <td><?php echo  "$" . number_format($p1payment, 2); ?></td>
                                        <td><?php echo  "$" . number_format($p2payment, 2); ?></td>
                                        <td><?php echo  "$" . number_format($p3payment, 2); ?></td>
                                        <td><?php echo  "$" . number_format($p4payment, 2); ?></td>

                                        <td><?php echo  "$" . number_format($servicing, 2); ?></td>
                                        <td><?php echo  "$" . number_format($yield, 2); ?></td>
                                        <td><?php echo  "$" . number_format($balance, 2); ?></td>

                                    </tr>

                                <?php
                                }
                                ?>
                                <tr>

                                    <td colspan="2" style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;position:sticky;left:79px;" class="freeze"></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;position:sticky;left:395px;" class="freeze"> Total : <?php echo count($diff); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;position:sticky;left:562px;" class="freeze"><?php echo "$" . number_format($total_total_loan, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_dkc, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p1, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p2, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p3, 2); ?></td>

                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p4, 2); ?></td>

                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_total_payment, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_dkc_payment, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p1_payment, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p2_payment, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p3_payment, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_p4_payment, 2); ?></td>

                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_servicing, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_yield, 2); ?></td>
                                    <td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format($total_balance, 2); ?></td>

                                </tr>
                            </tbody>
                        </table>
                <?php
                        $cc++;
                    }
                }
                ?>

            </section>
            <!-- start the green table -->

            <section class="green-table">

                <div class="total-first">
                    <h2><span style="color: grey;">Total Loan Overview: </h2>

                </div>

                <div class="total-first">
                    <div><span>Total Loan : </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_total, 2); ?></p>
                    </div>
                    <div><span>Due to Draws : </span>
                        <pre>   </pre>
                        <p><input type="number" value="<?php echo $due; ?>" step=".01" id="duedrawn" onchange="updateDrawn(this)" class="due"></p>
                    </div>
                </div>
                <div class="total-first">
                    <div><span>Total Loan Drawn Down: </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_total - $due, 2); ?></p>
                    </div>
                </div>
                <div class="total-first" style="display:flex; flex-direction:column">
                    <div><span>Part #1 : </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_p1, 2); ?></p>
                    </div>
                    <div><span>Part #2 : </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_p2, 2); ?></p>
                    </div>
                    <div><span>Part #3 : </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_p3, 2); ?></p>
                    </div>
                    <div><span>Part #4 : </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_p4, 2); ?></p>
                    </div>
                    <div><span>Lender : </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format($grand_dkc, 2); ?></p>
                    </div>
                </div>

                <div class="total-first">
                    <div><span>DKC + Participants: </span>
                        <pre>   </pre>
                        <p><?php echo "$" . number_format(($grand_p1 + $grand_p2 + $grand_p3 + $grand_p4 + $grand_dkc), 2); ?></p>
                    </div>
                </div>
            </section>
            <br>
            <br>
            <section class="total-second">
                <div class="form">

                    <form method="post" action="../backend/summary/participant/add.php">
                        <h2><b>Add Investor</b></h2>
                        <p></p>
                        <select name="green-investor" id="green-investor">
                            <option value="DKC">DKC Lending LLC</option>

                            <?php
                            foreach ($allInvestor as $investor) {

                                $ovalue = $investor['fname'] . " " . $investor["lname"];
                                if ($investor['username'] == 'EFisherLewis') $ovalue = "Elizabeth E Fisher (Trust 2)";
                                if ($investor['username'] == 'ElizabethFisher') $ovalue = "Elizabeth E Fisher (Trust 1)";

                            ?>
                                <option value="<?php echo $investor['username']; ?>"><?php echo  $ovalue; ?></option>
                            <?php
                            }
                            ?>
                        </select>
                        <input type="number" step=".01" placeholder="Trust-Unallocated" name="trustunallocated" required>
                        <input type="number" step=".01" placeholder="Trust-Draw Allocated" name="trustallocated" required>
                        <input type="number" step=".01" placeholder="Due to Draws" name="duedraws2" required>

                        <input type="submit" value="ADD">
                    </form>
                </div>



                </div>
                <div class="inv-green-table">
                    <table>
                        <tr>
                            <th>S.n. </th>
                            <th>Participant</th>
                            <th>Total Loan</th>
                            <th>Total Drawn To Date</th>
                            <th>Trust-Unallocated</th>
                            <th>Trust-Draw Allocated</th>
                            <th>Due to Draws</th>
                            <th>Total Funds</th>
                        </tr>
                        <?php
                        $investors = array(["username" => "DKC", "fname" => "DKC Lending", "lname" => "LLC"]);
                        $rawinvestors = $Users->category_users($conn, 2);
                        foreach ($rawinvestors as $temp) {
                            array_push($investors, $temp);
                        }

                        // $investors += $Users->category_users($conn, 2);
                        $total_funds = 0;
                        $total_loan = 0;
                        $total_drawn = 0;
                        $total_unalloc = 0;
                        $total_alloc = 0;
                        $total_due = 0;
                        $k = 1;
                        foreach ($investors as  $parti) {

                            $temp1 = $sumdatas[$parti['username']];
                            $total_funds += $temp1;
                            $temp2 = $participant_datas[$parti['username']]['draw'];
                            $total_due += $temp2;
                            $temp3 = $participant_datas[$parti['username']]['alloc'];
                            $total_alloc += $temp3;
                            $temp4 = $participant_datas[$parti['username']]['unalloc'];
                            $total_unalloc += $temp4;
                            $temp5 = $temp1;
                            $total_loan += $temp5;
                            $temp6 = $temp5 - $temp2;
                            $total_drawn += $temp6;
                            echo "<tr>";
                            echo "<td>" . ($k++) . "</td>";
                            echo "<td>" . ($parti['fname'] . " " . $parti['lname']) . "</td>";
                            echo "<td>$" . number_format($temp5, 2) . "</td>";
                            echo "<td>$" . number_format($temp6, 2) . "</td>";
                            echo "<td>$" . number_format($temp4, 2) . "</td>";
                            echo "<td>$" . number_format($temp3, 2) . "</td>";
                            echo "<td>$" . number_format($temp2, 2) . "</td>";
                            echo "<td>$" . number_format($temp1, 2) . "</td>";

                            echo "</tr>";
                        }
                        ?>
                        <tr>
                            <td colspan="2">Total</td>

                            <td><?php echo "$" . number_format($total_loan, 2); ?></td>
                            <td><?php echo "$" . number_format($total_drawn, 2); ?></td>
                            <td><?php echo "$" . number_format($total_unalloc, 2); ?></td>
                            <td><?php echo "$" . number_format($total_alloc, 2); ?></td>
                            <td><?php echo "$" . number_format($total_due, 2); ?></td>
                            <td><?php echo "$" . number_format($total_funds, 2); ?></td>
                        </tr>
                    </table>
                    <center style="padding: 10px;">
                        <span><strong>Total Trust Account : </strong></span>
                        &nbsp;
                        <span>
                            <strong>
                                <?php echo "$" . number_format(($total_alloc + $total_unalloc), 2); ?>
                            </strong>
                        </span>
                    </center>

                </div>
            </section>

            <div class="payoff-holder hide" id="main-payoff-holder">
                <div class="payoff-top">
                    <label>PAY OFF</label>
                    <div>
                        <button onclick="location.reload();return false" id="cross-btn"><i class="fa-solid fa-arrow-right"></i></button>

                    </div>

                </div>

                <form method="post" action="../backend/summary/paidoff.php" id="payForm">
                    <div class="payoff-form">
                        <input type="hidden" name="pdfuri" id="pdfuri">
                        <input type="hidden" name="paidsid" id="paidsid">
                        <input type="hidden" name="hiddenrate" id="hiddenrate">
                        <input type="hidden" name="llcname" id="llcname">
                        <input type="hidden" name="totalpaidoff" id="totalpaidoff">
                        <input type="hidden" name="dkcpaidoff" id="dkcpaidoff">
                        <input type="hidden" name="p1paidoff" id="p1paidoff">
                        <input type="hidden" name="p2paidoff" id="p2paidoff">
                        <input type="hidden" name="p3paidoff" id="p3paidoff">
                        <input type="hidden" name="p4paidoff" id="p4paidoff">

                        <input type="hidden" name="servicingpaidoff" id="servicingpaidoff">
                        <input type="hidden" name="yieldpaidoff" id="yieldpaidoff">
                        <div>
                            <div>
                                <label>Collateral Adderess:</label>
                                <input type="text" id="payoff-coll" name="coll" placeholder="Collateral Address" required />

                            </div>
                            <div>
                                <label>Principal Paid</label>
                                <input type="text" id="payoff-pbalance" name="pbalance" placeholder="Principal Balance" onchange="payoffprorated()" required />
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Date Paid</label>
                                <input type="text" id="payoff-exdate" name="exdate" placeholder="Extension Date" onchange="reupdatepaidoff()" required />
                            </div>
                            <div>
                                <label>Accured Interest</label>
                                <input type="text" id="payoff-ainterest" name="ainterest" placeholder="Accured Interest" onchange="payoffprorated()" required />
                            </div>
                            <div>
                                <label>Per Diem</label>
                                <input type="text" id="payoff-perdiem" name="perdiem" placeholder="Per Diem" onchange="payoffprorated()" required />
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Lender Admin fee</label>
                                <input type="text" id="payoff-adminfee" name="adminfee" placeholder="Lender Admin Fee" onchange="payoffprorated()" required />
                            </div>
                            <div>
                                <label>Recording fee</label>
                                <input type="text" id="payoff-rfee" name="rfee" placeholder="Recording Fee" onchange="payoffprorated()" required />
                            </div>
                            <div>
                                <label>Attorney's fee</label>
                                <input type="text" id="payoff-afee" name="afee" placeholder="Attorney's Fee" onchange="payoffprorated()" required />
                            </div>
                        </div>
                        <div>
                            <div>
                                <label>Late fee</label>
                                <input type="text" id="payoff-latefee" name="latefee" placeholder="Late Fee" value="0.00" onchange="payoffprorated()" required />
                            </div>
                            <div>
                                <label>Loan Extension fee</label>
                                <input type="text" id="payoff-lxtension" name="lextension" placeholder="Loan Extension Fee" onchange="payoffprorated()" required />
                            </div>
                            <div>
                                <label>Prepayment penalty</label>
                                <input type="text" id="payoff-extra" name="extra" placeholder="Extra Fee" onchange="payoffprorated()" value="0.00" required />
                            </div>

                        </div>
                        <div>
                            <div>
                                <label>Send/Receive Details</label>
                                <select id="bankdetails">
                                    <option value="dkc">DKC LENDING LLC</option>
                                    <option value="dkcfl">DKC LENDING FL LLC</option>
                                    <option value="austamerica">AustAmerica LLC</option>
                                    <option value="fct">First Capital Trusts LLC</option>
                                </select>
                            </div>
                        </div>
                        <br>
                        <div class="investor-paidoff-table">
                            <section>
                                <div>
                                    <label><strong>Lender</strong></label>
                                </div>
                                <div>
                                    <label><strong>p#1</strong></label>
                                </div>
                                <div>
                                    <label><strong>p#2</strong></label>
                                </div>
                                <div>
                                    <label><strong>p#3</strong></label>
                                </div>
                                <div>
                                    <label><strong>p#4</strong></label>
                                </div>
                                <div>
                                    <label><strong>Service</strong></label>
                                </div>
                                <div>
                                    <label><strong>Yield</strong></label>
                                </div>
                            </section>
                            <section>
                                <div>
                                    <label id="paid_lender">Lender</strong></label>
                                </div>
                                <div>
                                    <label id="paid_p1">p#1</label>
                                </div>
                                <div>
                                    <label id="paid_p2">p#2</label>
                                </div>
                                <div>
                                    <label id="paid_p3">p#3</label>
                                </div>
                                <div>
                                    <label id="paid_p4">p#4</label>
                                </div>
                                <div>
                                    <label>None</label>
                                </div>
                                <div>
                                    <label>None</label>
                                </div>
                            </section>
                            <section style="color: red;">
                                <div>
                                    <label id="beforedkcpaidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="beforep1paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="beforep2paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="beforep3paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="beforep4paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="beforeservicingpaidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="beforeyieldpaidoff_">$0.00</label>
                                </div>
                            </section>

                            <section style="color: green; border-bottom:solid 1px grey;">
                                <div>
                                    <label id="dkcpaidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="p1paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="p2paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="p3paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="p4paidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="servicingpaidoff_">$0.00</label>
                                </div>
                                <div>
                                    <label id="yieldpaidoff_">$0.00</label>
                                </div>
                            </section>



                        </div>
                        <div>
                            <div>
                                <label>Notes</label>
                                <textarea class="payoff-notes" name="paidnote"></textarea>
                            </div>

                        </div>

                        <button id="update-payoff"> Paid Off</button>

                    </div>
                </form>

            </div>
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
    // ob_clean();
    echo $er;
    // include('../500.php');
} finally {
    ob_flush();
}
?>