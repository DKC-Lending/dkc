<?php

use Twilio\Rest\Api\V2010\Account\Usage\Record\MonthlyList;

try { ?>
    <?php

    if (isset($_GET["search_usr"])) {
        $uname =  $_GET["search_usr"];
    } else {
        $uname = $_SESSION["cuser"];
    }

    // include_once('../backend/main/borrowerController.php');
    include '../backend/summary/summaryControl.php';
    include_once('../backend/post/postControl.php');
    $invpost = $posts->get_posts($i_conn);

    $total_interest = $posts->get_total_user_interest_post($i_conn, $uname);
    // $pdata = get_table_data($b_conn, $uname);
    $total_equity = 0;
    $avg_rate = 0;
    $monthly_interest = 0;
    $cout = 0;
    $date_holder = [];
    $total_equity_holder = [];

    $date_value_holder = [];
    $date_monthly_holder = [];
    $sumData = new Summary();
    $sumMonths = 0;
    $summData = $sumData->specificData($uname, $sum_conn);
    $heading =  $sumData->get_heading($sum_conn);
    $monthlly = $sumData->getMonthlyData($sum_conn);


    foreach ($heading as $head) {
        $cc = 0;
        foreach ($monthlly as $m) {
            if ($m['investor'] == $uname) {
                $sumMonths += floatval($m[$head]);
                $cc  += floatval($m[$head]);
            }
        }
        array_push($date_value_holder, $cc);
        array_push($date_monthly_holder, $sumMonths);
    }
    foreach ($summData as $sumdata) {
        if ($sumdata['dkc'] == $uname) {
            $part = "dkc";
        } elseif ($sumdata['p1'] == $uname) {
            $part = "p1";
        } elseif ($sumdata['p2'] == $uname) {
            $part = "p2";
        } elseif ($sumdata['p3'] == $uname) {
            $part = "p3";
        }
        // echo $part;

        $total_equity += $sumdata["$part" . "amt"];
        // echo $total_equity;
        array_push($total_equity_holder, $sumdata["$part" . "amt"]);
        $monthly_interest += ((((float)$sumdata["$part" . "rate"] / 100) * (float)$sumdata["$part" . "amt"])) / 12;
        $avg_rate += $sumdata["$part" . "rate"];
    }
    if (count($summData) > 0) {
        $avg_rate = $avg_rate / count($summData);
    } else {
        $avg_rate = 0;
    }

    $avg_rate = round($avg_rate, 2);

    for ($i = 0; $i < count($date_monthly_holder); $i++) {
        $total_equity_holder[$i] = $total_equity;
    }

    ?>


    <div class="grid-container" align="center">
        <div class="card">
            <div class="icon" id="cmonth"><i class="fa-solid fa-chart-pie"></i></div>
            <div class="total">
                <label id="cmonth-money"><?php echo "$" . number_format($sumMonths, 2); ?></label><br>
                <label>Total collected</label>
            </div>
        </div>

        <div class="card1">
            <div class="icon" id="tgain"><i class="fa-solid fa-chart-pie"></i></div>
            <div class="total">
                <label id="tgain-money"><?php echo "$" . number_format($total_equity, 2); ?></label><br>
                <label>Total Investor Equity</label>
            </div>
        </div>

        <div class="card2">
            <div class="icon" id="tinvest"><i class="fa-solid fa-chart-pie"></i></div>
            <div class="total">
                <label id="tinvest-money"><?php echo $avg_rate . "%"; ?></label><br>
                <label>Average Rate</label>
            </div>
        </div>

        <div class="card3">
            <div class="icon" id="rate"><i class="fa-solid fa-chart-pie"></i></div>
            <div class="total">
                <label id="rate-money"><?php echo "$" . number_format($monthly_interest, 2); ?></label><br>
                <label>Monthly Interest</label>
            </div>
        </div>

        <?php include 'main-borrower.php'; ?>

        <div class="card4">
            <section>
                <canvas id="myChart"></canvas>
            </section>
        </div>

        <div class="card5">
            <div class="top-txt">
                <label>Last 12 months Investment Opportunities</label>
            </div>
            <hr>
            <canvas id="dough-chart"> </canvas>

            <div class="chart-list">
                <ul>
                    <li>
                        <div class="label-holder">
                            <div class="total-chart"></div>
                            <label>Total Opportunities</label>
                        </div>
                        <p><b><?php echo count($invpost); ?></b>
                            <label> </label>
                        </p>
                    </li>
                    <li>
                        <div class="label-holder">
                            <div class="interest-chart"></div>
                            <label>Interested on</label>
                        </div>
                        <p><b> <?php echo $total_interest; ?></b>
                            <label> </label>
                        </p>
                    </li>

                </ul>
            </div>
        </div>


    </div>

    <?php include '../global/footer.php'; ?>

    <script>
        var ctx = document.getElementById('myChart').getContext('2d');
        var myChart = new Chart(ctx, {

            type: 'line',
            data: {
                labels: <?php echo json_encode($heading); ?>,

                datasets: [{
                        data: <?php echo json_encode($total_equity_holder); ?>,
                        label: "Invested",
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "#FFB133",
                        borderColor: "#FFB133",
                    },
                    {
                        data: <?php echo json_encode($date_value_holder); ?>,
                        label: "Monthly",
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "rgb(75, 192, 192)",
                        borderColor: "rgb(75, 192, 192)",
                    },
                    {
                        data: <?php echo json_encode($date_monthly_holder); ?>,
                        label: "Gains",
                        fill: false,
                        lineTension: 0,
                        backgroundColor: "#33A7FF",
                        borderColor: "#33A7FF",
                    }
                ]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,

                plugins: {
                    legend: {
                        labels: {
                            usePointStyle: true,
                            pointStyle: 'circle',
                        }
                    },
                    title: {
                        display: true,
                        text: 'Investment History',
                        align: 'start',
                        color: 'black',
                        font: {
                            size: 14
                        }
                    },
                }
            }
        });

        const data = {
            labels: [
                'Total Opportunities',
                'Interested on'
            ],
            datasets: [{
                label: 'My First Dataset',
                data: [<?php echo count($invpost); ?>, <?php echo $total_interest; ?>],
                borderWidth: 0,
                backgroundColor: [
                    '#6F52ED',
                    '#33D69F'
                ],
                hoverOffset: 4
            }]
        };
        var dctx = document.getElementById('dough-chart').getContext('2d');
        var doughnutchart = new Chart(dctx, {
            type: 'doughnut',
            data: data,
            options: {
                aspectRatio: 2,
                cutout: 50,
                plugins: {
                    legend: {
                        display: false
                    }
                }
            }
        });
    </script>
<?php
} catch (Error $er) {
    echo $er;
    // ob_clean();
    // include('../500.php');
} finally {
    // ob_flush();
}
?>