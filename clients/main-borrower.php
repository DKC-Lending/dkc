<?php try { ?>
    <?php
    if (isset($_GET["search_usr"])) {
        $uname =  $_GET["search_usr"];
    } else {
        $uname = $_SESSION["cuser"];
    }


    $c_summary = new Summary();
    $summary = $c_summary->specificData($uname, $sum_conn);
    $monthsHeading = $c_summary->get_heading($sum_conn);
    $monthDatas = $c_summary->getMonthlyData($sum_conn);
    ?>


    <section class="borrower-card" style="padding-bottom:30px;">
        <?php
        $total_l_amount = 0;
        $total_e_amount = 0;
        $total_r_amount = 0;
        $month_amount = [];
        $count = count($summary);
        $amount = 0;
        $sum_month = [];

        ?>
        <div>
            <h4><?php echo $uname; ?></h4>
            <table class="investor-table">
                <tr>
                    <th>Link</th>
                    <th>Collateral Address</th>
                    <th>Total Loan Amount</th>
                    <th>Investor Equity</th>
                    <th>Interest Rate</th>
                    <th>Regular Payment</th>
                    <th>Investment Date</th>
                    <th>Maturity Date</th>
                    <?php
                    foreach ($monthsHeading as $he) {
                        echo "<th>" . $he . "</th>";
                    }

                    ?>
                </tr>
                <?php
                foreach ($summary as $data) {
                    if ($data['p1'] == $uname) {
                        $part = "p1";
                    } elseif ($data['p2'] == $uname) {
                        $part = "p2";
                    } else {
                        $part = "p3";
                    }
                ?>
                    <tr class="<?php echo (floatval($data['tloan']) > 0) ? '' : 'paidoff-red' ?>">
                        <td><a href="<?php echo $data["link"]; ?>" target="_blank" class="dlink"><i class="fa-solid fa-file"></i></a></td>
                        <td><?php echo $data['bcoll'] ?></td>
                        <td><?php echo "$" . number_format($data['tloan'], 2)  ?></td>
                        <td><?php echo "$" . number_format($data["$part" . "amt"], 2); ?></td>
                        <td><?php echo $data["$part" . "rate"] . "%" ?></td>
                        <td><?php echo "$" . number_format(((((float)$data["$part" . "rate"] / 100) * (float)$data["$part" . "amt"])) / 12, 2); ?></td>
                        <td><?php echo $data["odate"] ?></td>
                        <td><?php echo $data["mdate"] ?></td>
                        <?php

                        foreach ($monthsHeading as $t_head) {
                            foreach ($monthDatas as $d) {

                                if ($d['sumid'] == $data['sid'] && $d['investor'] == $uname) {
                                    if ($d[$t_head] != null) {

                                        if (in_array($t_head, array_keys($sum_month))) {
                                            $sum_month[$t_head] += floatval($d[$t_head]);
                                        } else {
                                            $sum_month[$t_head] = floatval($d[$t_head]);
                                        }

                                        echo "<td>" . "$" . $d[$t_head] . "</td>";
                                    } else {
                                        $sum_month[$t_head] = 0;
                                        echo '<td> N/A </td>';
                                    }
                                }
                            }
                        }
                        ?>
                    </tr>
                <?php
                    $total_l_amount += $data['tloan'];
                    $total_e_amount += $data["$part" . "amt"];
                    $total_r_amount += round(((((float)$data["$part" . "rate"] / 100) * (float)$data["$part" . "amt"])) / 12, 2);
                }
                $amount = $total_e_amount;
                ?>

                <tr class="total_tr">
                    <td></td>
                    <td></td>
                    <td class="totalvalue"><?php echo " $" . number_format($total_l_amount, 2); ?></td>
                    <td class="totalvalue"><?php echo " $" . number_format($total_e_amount, 2); ?></td>
                    <td></td>
                    <td class="totalvalue"><?php echo " $" . number_format($total_r_amount, 2); ?></td>
                    <td></td>
                    <td></td>
                    <?php
                    foreach ($sum_month as $month) {
                        echo '<td> $' . number_format($month, 2) . '</td>';
                    }
                    ?>


                </tr>

            </table>
        </div>
    </section>
<?php
} catch (Error $er) {
    ob_clean();
    include('../500.php');
} finally {
    ob_flush();
}
?>