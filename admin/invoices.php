<?php try { ?>
	<?php include_once('../backend/adminsession.php'); ?>
	<?php
	error_reporting(1);
	include '../backend/config/conifg.php';
	include '../backend/insurance/invoiceController.php';
	$web = $config->fetch();
	$sid_collections = [];
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
		<title>Admin Users | <?php echo $web["name"]; ?></title>
		<link rel="icon" type="image/x-icon" href="../img/misc/favicon.ico" />

	</head>

	<?php include "../backend/summary/summaryControl.php"; ?>
	<?php
	include "../backend/insurance/getconfirmation.php";
	$confirmation = getconf($pdfconn);
	$c_summary = new Summary();
	$summary = $c_summary->allDatas($sum_conn);
	?>
	<?php include "../global/links.html"; ?>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../css/global.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<link rel="stylesheet" type="text/css" href="../css/buttons.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/admin/invoices.css">
	<link rel="stylesheet" type="text/css" href="../css/topheader.css">
	<script src="https://code.jquery.com/jquery-3.6.0.js"></script>
	<script src="https://code.jquery.com/ui/1.13.0/jquery-ui.js"></script>
	<script src="../js/alert.js"></script>
	<script src="../js/invoices.js"></script>
	<script src="../js/html2pdf.bundle.js"></script>

	<body>
		<?php include "../global/adminnav.php"; ?>
		<?php include "../global/adminheader.php"; ?>

		<div class="content">

			<div class="add-form" id="preview-form">
				<div class="form-box">

					<div class="form-title">
						<div>
						</div>

						<div id="preview-form-title-label">
							<label id="current-invoice-date">Send Invoice for: 01/04/2022 (April)</label>
							<label id="last-invoice-date">(Last Sent on: 01/03/2021 )</label>
						</div>
						<div class="close-invoice">
							<a href="./invoices.php"><i class="fa-solid fa-circle-xmark"></i></a>
						</div>
					</div>
					<div>
					</div>

					<section class="invoice-form-holder">
						<div class="form-holder">
							<input type="hidden" id="bid" value="">
							<div><label>Borrower Name</label><input type="text" id="pbname" class="insurance-input" placeholder="  Enter Borrower Name" required></div>
							<div><label>Coll. Address</label><input type="text" id="pbaddress" class="insurance-input" placeholder="  Enter Borrower Name" required></div>
							<div><label>I. Rate (%)</label><input type="text" id="pbrate" class="insurance-input" placeholder="  Enter Interest Rate" required></div>
							<div><label>Total Loan</label><input type="text" id="pbtloan" class="insurance-input" placeholder="  Enter Borrower Name" required></div>
							<div><label>Origination Date</label><input type="text" id="pbodate" class="insurance-input" placeholder="  MM/DD/YYYY" required></div>
							<div><label>Maturity Date</label><input type="text" id="pbmdate" class="insurance-input" placeholder="  MM/DD/YYYY" required></div>
							<div><label>Borrower Phone</label><input type="text" id="pbphone" class="insurance-input" placeholder="  Enter Borrower Phone" required></div>
							<div><label>Monthly Payment </label><input type="text" id="pbmpayment" class="insurance-input" placeholder="  Monthly Payment" required></div>
						</div>
						<div class="form-holder">

							<div><label>Borrower Email</label><input type="email" id="pbemail" class="insurance-input" placeholder="  Enter Borrower Phone" required></div>
							<div><label>Insurance Expiry </label><input type="text" id="pfiexpire" class="insurance-input" placeholder="    MM/DD/YYYY" required></div>
							<hr style="border:rgba(0,0,0,0.2) 1px dotted; margin:15px 0px;">
							<div><label>Late Fees</label><input type="text" id="plfee" class="insurance-input" placeholder="  Late fee" required></div>
							<div><label>Late Fees Note</label><input type="email" id="plfeenote" class="insurance-input" placeholder="  Late fee note" required></div>
							<div><label>Additional Fees</label><input type="text" id="pafee" class="insurance-input" placeholder="  Additional fee" required></div>
							<div><label>Additional Fees Note</label><input type="text" id="pafeenote" class="insurance-input" placeholder="  Additional fee note" required></div>
						</div>



					</section>


					<section class="invoice-btn-holder">
						<button class="save-invoice" id="save-invoice" onclick="showPdfPreviewer()">Preview & Send</button>
					</section>

				</div>

			</div>

			<div class="add-form" id="pdf-preview-holder">
				<div class="form-box">
					<div class="form-title">
						<div>
						</div>
						<div id="preview-form-title-label">
							<label>
								<h3>Invoice Preview</h3>
							</label>
						</div>
						<div class="close-invoice">
							<a href="./invoices.php"><i class="fa-solid fa-circle-xmark"></i></a>
						</div>
					</div>

					<div>
					</div>

					<section class="invoice-form-holder">
						<section class="pdf-frame">
							<div class="pdf-preview" id="pdf-preview">
								<img src="../img/logo/newlogo.png" id="dkc-logo" alt="image">
								<label class="pdf-title">Borrower Invoice Summary</label>
								<p>Thank you for choosing DKC Lending for your private financing needs! We are happy to be your loan servicing company, please read the following for further interest payment instrunctions for the duration of the loan.</p>
								<br>
								<div><b><label>Borrower :</label></b><label id="pdfborrower"></label></div>
								<div><b><label>Address : </label></b><label id="pdfaddress"></label></div>
								<div><b><label>Origination Date : </label></b><label id="pdfodate"></label></div>
								<div><b><label>Maturity Date : </label></b><label id="pdfmdate"></label></div>
								<div><b><label>Loan Amount : </label></b><label id="pdflamount"></label></div>
								<div><b><label>Loan % : </label></b><label id="pdflpercent"></label></div>
								<div><b><label>Interest Payment : </label></b><label id="pdfpayment"></label></div>

								<br>

								<table class="pdf-month-table" id="pdf-table">
									<tr>
										<th>Date</th>
										<th>Description</th>
										<th>Monthly Interest</th>
										<th>Late Fees</th>
										<th>Amount Due</th>
										<th>Amount Paid</th>
									</tr>
								</table>
								<br>
								<br>


							</div>
						</section>
					</section>


					<section class="invoice-btn-holder">
						<input type="button" class="save-invoice" id="save-invoice2" onclick="createPDF()" value="send">
					</section>

				</div>

			</div>

			<div id="batch-preview">
				<div class="form-title">
					<div>
						<label id="current-page"></label>
					</div>
					<div id="preview-form-title-label">
						<label>
							<h3>Invoice Preview</h3>
						</label>
					</div>
					<div class="close-invoice">
						<a href="./invoices.php"><i class="fa-solid fa-circle-xmark"></i></a>
					</div>
				</div>

				<div class="mass-preview">
					<button onclick="change_pdf(-1)">
						< </button>
							<div class="mass-renderer">
								<div>
								</div>

								<section class="invoice-form-holder">
									<section class="pdf-frame">
										<div class="pdf-preview" id="mpdf-preview">
											<img src="../img/logo/newlogo.png" id="dkc-logo" alt="image">
											<label class="pdf-title">Borrower Invoice Summary</label>
											<p>Thank you for choosing DKC Lending for your private financing needs! We are happy to be your loan servicing company, please read the following for further interest payment instrunctions for the duration of the loan.</p>
											<br>
											<div><b><label>Borrower :</label></b><label id="mpdfborrower"></label></div>
											<div><b><label>Address : </label></b><label id="mpdfaddress"></label></div>
											<div><b><label>Origination Date : </label></b><label id="mpdfodate"></label></div>
											<div><b><label>Maturity Date : </label></b><label id="mpdfmdate"></label></div>
											<div><b><label>Loan Amount : </label></b><label id="mpdflamount"></label></div>
											<div><b><label>Loan % : </label></b><label id="mpdflpercent"></label></div>
											<div><b><label>Interest Payment : </label></b><label id="mpdfpayment"></label></div>

											<br>

											<table class="pdf-month-table" id="mpdf-table">
												<thead>
													<tr>
														<th>Date</th>
														<th>Description</th>
														<th>Monthly Interest</th>
														<th>Late Fees</th>
														<th>Amount Due</th>
														<th>Amount Paid</th>
													</tr>
												</thead>

												<tbody id="mtbody">

												</tbody>
											</table>
											<br>
											<br>


										</div>
									</section>
								</section>


								<section class="invoice-btn-holder">
									<input type="button" class="save-invoice" id="save-invoice2" onclick="batchPDFSend()" value="send">
								</section>
							</div>
							<button onclick="change_pdf(1)">></button>
				</div>
			</div>
		</div>
		<div class="mass-sending-alert" id="mass-sending-alert">
			<div id="send-detail">
				<p id="send-result">
					(0/10)
				</p>
				<div class="loader"></div>
				<label>Sending..</label>
			</div>
		</div>
		<div class="main-container" id="main-main-container">

			<div class="top-head-txt-center">
				<div>
					<p>Borrower <br> <label class="sub-heading">You can add, update or delete users from here</label> </p>
				</div>
			</div>

			<div class="send-all">
				<div>
					<button class="refresh-month-btn" onclick='refresh_month( <?php echo json_encode($summary); ?>)'><i class="fa-solid fa-rotate"></i></button>
					<button class="add-month-btn" onclick='add_month( <?php echo json_encode($summary); ?>)'>Add Month</button>
					<button class="refresh-month-btn" title="Expand Button" onclick="$('#expand').show()"><i class="fa-solid fa-expand"></i></button>
				</div>
				<button class="send-all-btn " onclick='batch_send( <?php echo json_encode($summary); ?>)'>BATCH SEND</button>
			</div>

			<?php
			foreach ($summary as $sums) {
				$temploan = $sums['loan'];
				$diff_loans[$temploan][] = $sums;
			}
			?>
			<section class="main-table-wrapper">
				<?php
				$count = 0;
				$temp_loans = [];
				array_push($temp_loans, $diff_loans['First Capital Trusts LLC']);
				array_push($temp_loans, $diff_loans['DKC Lending LLC']);
				array_push($temp_loans, $diff_loans['DKC Lending FL']);
				array_push($temp_loans, $diff_loans['DKC Lending CL']);
				array_push($temp_loans, $diff_loans['DKC Lending IV']);

				$diff_loans = $temp_loans;
				$heads = get_heading($pdfconn);
				foreach ($diff_loans as $loans) {
				?>
					<div class="table-wrapper">
						<table class="user-table" id="utable<?php echo $count ?>" cellspacing="0" cellpadding="0">
							<tr>
								<th colspan="<?php echo (11 + count($heads)); ?>"><label class="table-username"><?php echo $loans[0]['loan']; ?></label></th>
							</tr>
							<tr>
								<th>Action</th>
								<th onclick="sortTable('utable<?php echo $count ?>',1)">Borrower</th>
								<th onclick="sortTable('utable<?php echo $count ?>',2)">Collateral Address</th>
								<th onclick="sortTable('utable<?php echo $count ?>',3)">Total Loan</th>
								<th>Rate</th>
								<th onclick="sortTable('utable<?php echo $count ?>',5)">Monthly Payment</th>
								<th onclick="sortTable('utable<?php echo $count ?>',6)">Orign. Date</th>
								<th onclick="sortTable('utable<?php echo $count ?>',7)">Maturity Date</th>
								<th>Phone</th>
								<th>Email</th>
								<th onclick="sortTable('utable<?php echo $count ?>',10)">Insurance Exp. Date</th>
								<?php

								$xcount = 11;
								$ccount = 1;
								foreach ($heads as $head) {
									echo '<th onclick=sortTable("utable' . $count . '",' . $xcount . ')>' . $head . '</th>';
									$xcount++;
								}
								?>
							</tr>
							<?php
							$heads_datas = get_heading_datas($pdfconn);
							$sum_month = [];
							$total_loan = 0;
							$total_regular = 0;

							foreach ($loans as $sum) {
								array_push($sid_collections, $sum["sid"]);
								$total_loan += $sum['tloan'];
								$total_regular += $sum['balance'];

							?>
								<?php

								$class = get_diff(date("m-d-Y"), $sum['mdate']);
								$exp = get_diff(date("m-d-Y"), $sum['iexpiry']);
								?>
								<tr class=<?php echo ($sum['tloan'] > 0) ? '' : 'paidoff-red'; ?>>
									<td style="text-align:center">
										<button class="send-invoice-btn confirm" id='<?php echo $sum["sid"]; ?>' title="Payment Confirm Btn" onclick='payment_confirm("utable<?php echo $count; ?>",<?php echo $ccount ?>,<?php echo $sum["sid"]; ?>)'><i class="fa-solid fa-clipboard-check"></i></button>
										<button class="send-invoice-btn" id='<?php echo $sum["sid"]; ?>' title="Send Invoice Btn" onclick='preview_form(<?php echo json_encode($sum); ?>)'><i class="fa-solid fa-share"></i></button>
									</td>
									<td><a href="<?php echo "pdfhistory.php?uid=" . $sum['sid'] . "&name=" . $sum["bllc"] . "" ?>"><?php echo $sum["bllc"]; ?></a></td>
									<td><?php echo $sum['bcoll']; ?></td>
									<td><?php echo "$" . number_format(floatval($sum["tloan"]), 2); ?></td>
									<td><?php echo $sum["irate"] . "%"; ?></td>
									<td><?php echo  "$" . number_format(floatval($sum["balance"]), 2); ?></td>
									<td><?php echo $sum["odate"]; ?></td>
									<td class="<?php echo $class; ?>"><?php echo $sum["mdate"]; ?></td>
									<td><?php echo $sum["bphone"]; ?></td>
									<td><?php echo $sum["bemail"]; ?></td>
									<td class="<?php echo $exp; ?>"><?php echo $sum["iexpiry"]; ?></td>
									<?php
									foreach ($heads_datas as $datas) {
										if ($datas['id'] == $sum['sid']) {
											if (in_array(key($datas), array_keys($datas))) {
												foreach ($heads as $head) {
													if (in_array($head, array_keys($datas))) {

														if ($datas[$head] != null) {

															if (in_array($head, array_keys($sum_month))) {

																$sum_month[$head] += floatval($datas[$head]);
															} else {

																$sum_month[$head] = floatval($datas[$head]);
															}
															$isthere = false;
															$isconfirm = "";
															foreach ($confirmation as $conf) {
																if ($sum['sid'] == $conf['sid']) {
																	if (in_array($head, array_keys($conf))) {
																		if ($conf[$head][2] == $datas[$head]) {
																			$isconfirm = " isconfirm";
																		}
																		$isthere = true;
																		break;
																	}
																}
															}
															if (number_format(floatval($sum["balance"]), 2) ==  number_format(floatval($datas[$head]), 2)) {
																if ($isthere == true) {
																	$pd = "$" . number_format($conf[$head][2], 2);
																	$note = $conf[$head][3];
																	$ddte = $conf[$head][0];
																	echo "<td class= '$isconfirm' onmouseout='deleteconfirm()' onmouseover='hoverconfirm(this,`$ddte`,`$pd`,`$note`)'>" .  "$" . number_format(floatval($datas[$head]), 2) . '</td>';
																} else {
																	echo '<td class="' . $isconfirm . '">' .  "$" . number_format(floatval($datas[$head]), 2) . '</td>';
																}
															} else {
																if ($isthere == true) {
																	$pd = "$" . number_format($conf[$head][2], 2);
																	$note = $conf[$head][3];
																	$ddte = $conf[$head][0];
																	echo `<td class='pro-data $isconfirm' onmouseout='deleteconfirm()'  onmouseover='hoverconfirm(this,"$ddte","$pd","$note")>` .  "$" . number_format(floatval($datas[$head]), 2) . '</td>';
																} else {
																	echo '<td class="pro-data' . $isconfirm . '">' .  "$" . number_format(floatval($datas[$head]), 2) . '</td>';
																}
															}
														} else {
															$sum_month[$head] += 0;
															echo '<td> $0.00 </td>';
														}
													}
												}
											}
										}
									}
									?>
								</tr>
							<?php
								$ccount++;
							}
							?>
							<tfoot>
								<tr class="total_tr">
									<td colspan="3" style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
									<td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format(floatval($total_loan), 2); ?></td>
									<td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
									<td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"><?php echo "$" . number_format(floatval($total_regular), 2); ?></td>
									<td colspan="5" style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"></td>
									<?php
									foreach ($sum_month as $month) {
										echo '<td style="background-color: var(--secondary); color:white; font-weight:bold; text-align:center;"> $' . number_format(floatval($month), 2) . '</td>';
									}
									?>
								</tr>
							</tfoot>
						</table>
					</div>
				<?php
					$count++;
				}
				?>
			</section>

			<div class="payment-received" id="payment-received">
				<section>
					<label>Payment Received</label>
					<button onclick="reload()"></button>
					<form method="get" action="../backend/insurance/confirmpayment.php">
						<input type="hidden" name="confirmsid" id="confirmsid">
						<div>
							<input type="text" id="confirmbllc" name="confirmbllc" placeholder="Borrower LLC..">
						</div>
						<div>
							<input type="text" id="confirmbcoll" name="confirmbcoll" placeholder="Collateral Address..">
						</div>
						<div>
							<input type="date" id="confirmdate" name="confirmdate">
						</div>
						<div>
							<div>
								<input type="text" id="schedule" name="schedule" placeholder="Scheduled Payment">
								<input type="text" placeholder="Amount Paid" id="confirmpaid" name="confirmpaid" onchange="check_confirm_balance(this)">
							</div>

						</div>
						<div>
							<input type="text" id="conf_balance" placeholder="Balance">
						</div>
						<div>
							<textarea id="confirmnotes" name="confirmnotes" placeholder="Enter Notes.."></textarea>
						</div>
						<div>
							<button class="submit">Confirm</button>
						</div>
					</form>
				</section>
			</div>

			<table class="summary-table">
				<?php
				$tservice = [];
				$tyield = [];
				$tpayable = [];
				$tcollect = [];
				// $sql = "show columns from months";
				// $rslt = mysqli_query($sum_conn, $sql);
				// while ($row = $rslt->fetch_assoc()) {
				// 	if (!in_array($row['Field'], ["mid", "sumid", "investor"])) {
				// 		$columns[] = $row['Field'];
				// 	}
				// }
				$columns = $c_summary->get_heading($sum_conn);
				$sql = "SELECT * FROM months";
				$rslt = mysqli_query($sum_conn, $sql);
				while ($datas = mysqli_fetch_array($rslt)) {
					if (in_array($datas["sumid"], $sid_collections)) {
						foreach ($columns as $title) {
							if ($datas['investor'] != 'service' && $datas['investor'] != 'yield') {

								$tpayable[$title] += $datas[$title];
							} else {
								if ($datas['investor'] == "service") {
									$tservice[$title] += $datas[$title];
								}
								if ($datas['investor'] == "yield") {
									$tyield[$title] += $datas[$title];
								}
							}
							$tcollect[$title] += $datas[$title];
						}
					}
				}

				?>
			</table>
			<div id="expand" class="expand">
                <?php
                $total_loan = 0;
                $lender = 0;
                $lender_pro = 0;
                $lender_reg = 0;
                $p1 = 0;
                $p1_pro = 0;
                $p1_reg = 0;
                $p2 = 0;
                $p2_pro = 0;
                $p2_reg = 0;
                $p3 = 0;
                $p3_pro = 0;
                $p3_reg = 0;
                $p4 = 0;
                $p4_pro = 0;
                $p4_reg = 0;
                $servicing = 0;
                $servicing_pro = 0;
                $servicing_reg = 0;
                $yield = 0;
                $yield_pro = 0;
                $yield_reg = 0;
                $balance = 0;

                ?>
                <table border="1" id="expand-table">
                    <tr>
                        <th onclick="sortTable('expand-table',0)">sn</th>
                        <th onclick="sortTable('expand-table',1)">Borrower LLC</th>
                        <th onclick="sortTable('expand-table',2)">Full Name</th>
                        <th onclick="sortTable('expand-table',3)">Collateral Address</th>
                        <th onclick="sortTable('expand-table',4)">Total Loan</th>
                        <th>Interest %</th>
                        <th onclick="sortTable('expand-table',6)">Origin. Date</th>
                        <th onclick="sortTable('expand-table',7)">Maturity Date</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th onclick="sortTable('expand-table',10)">Insurance Exp.</th>
                        <th onclick="sortTable('expand-table',11)">ACH</th>
                        <th>Service</th>
                        <th onclick="sortTable('expand-table',13)">Lender</th>
                        <th onclick="sortTable('expand-table',14)">Lender. equity</th>
                        <th>Lender Rate</th>
                        <th onclick="sortTable('expand-table',16)">Lender Prorated</th>
                        <th onclick="sortTable('expand-table',17)">Lender Regular</th>
                        <th onclick="sortTable('expand-table',18)">P1</th>
                        <th onclick="sortTable('expand-table',19)">P1. equity</th>
                        <th>P1 Rate</th>
                        <th onclick="sortTable('expand-table',21)">P1 Prorated</th>
                        <th onclick="sortTable('expand-table',22)">P1 Regular</th>
                        <th onclick="sortTable('expand-table',23)">p2</th>
                        <th onclick="sortTable('expand-table',24)">p2. equity</th>
                        <th>p2 Rate</th>
                        <th onclick="sortTable('expand-table',26)">p2 Prorated</th>
                        <th onclick="sortTable('expand-table',27)">p2 Regular</th>
                        <th onclick="sortTable('expand-table',28)">P3</th>
                        <th onclick="sortTable('expand-table',29)">P3. equity</th>
                        <th>P3 Rate</th>
                        <th onclick="sortTable('expand-table',31)">P3 Prorated</th>
                        <th onclick="sortTable('expand-table',32)">P3 Regular</th>
                        <th onclick="sortTable('expand-table',33)">P4</th>
                        <th onclick="sortTable('expand-table',34)">P4. equity</th>
                        <th>P4 Rate</th>
                        <th onclick="sortTable('expand-table',36)">P4 Prorated</th>
                        <th onclick="sortTable('expand-table',37)">P4 Regular</th>
                        <th onclick="sortTable('expand-table',38)">Service</th>
                        <th onclick="sortTable('expand-table',39)">Service. equity</th>
                        <th>Service Rate</th>
                        <th onclick="sortTable('expand-table',41)">Service Prorated</th>
                        <th onclick="sortTable('expand-table',42)">Service Regular</th>
                        <th onclick="sortTable('expand-table',43)">Yield</th>
                        <th onclick="sortTable('expand-table',44)">Yield. equity</th>
                        <th>Yield Rate</th>
                        <th onclick="sortTable('expand-table',46)">Yield Prorated</th>
                        <th onclick="sortTable('expand-table',47)">Yield Regular</th>
                        <th onclick="sortTable('expand-table',48)">Balance</th>
                    </tr>

                    <?php
                    $sn = 1;
                    foreach ($summary as $s) {
                        $total_loan += floatval($s['tloan']);
                        $lender += floatval($s['dkcamt']);
                        $lender_pro += floatval($s['dkcprorated']);
                        $lender_reg += floatval($s['dkcregular']);
                        $p1 += floatval($s['p1amt']);
                        $p1_pro += floatval($s['p1prorated']);
                        $p1_reg += floatval($s['p1regular']);
                        $p2 += floatval($s['p2amt']);
                        $p2_pro += floatval($s['p2prorated']);
                        $p2_reg += floatval($s['p2regular']);
                        $p3 += floatval($s['p3amt']);
                        $p3_pro += floatval($s['p3prorated']);
                        $p3_reg += floatval($s['p3regular']);
                        $p4 += floatval($s['p4amt']);
                        $p4_pro += floatval($s['p4prorated']);
                        $p4_reg += floatval($s['p4regular']);
                        $servicing += floatval($s['servicingamt']);
                        $servicing_pro += floatval($s['servicingprorated']);
                        $servicing_reg += floatval($s['servicingregular']);
                        $yield += floatval($s['yieldamt']);
                        $yield_pro += floatval($s['yieldprorated']);
                        $yield_reg += floatval($s['yieldregular']);
                        $balance += floatval($s['balance']);
                    ?>
                        <tr <?php echo (intval($s['status'])  != 1) ? 'class="paidoff-tr"' : '' ?>>
                            <td><?php echo $sn; ?></td>
                            <td><?php echo $s['bllc']; ?></td>
                            <td><?php echo $s['fname'] . " " . $s['lname']; ?></td>
                            <td><a href="<?php echo $s['link']; ?>" target="_blank"><?php echo $s['bcoll']; ?></a></td>
                            <td value="<?php echo floatval($s['tloan']) ?>"><?php echo "$" . number_format(floatval($s['tloan']), 2); ?></td>
                            <td><?php echo $s['irate'] . "%"; ?></td>
                            <td><?php echo $s['odate']; ?></td>
                            <td><?php echo $s['mdate']; ?></td>
                            <td><?php echo $s['bphone']; ?></td>
                            <td><?php echo $s['bemail']; ?></td>
                            <td><a href="<?php echo $s['taxurl'] ?>" target="_blank"><?php echo $s['iexpiry']; ?></a></td>
                            <td><?php echo $s['ach']; ?></td>
                            <td><?php echo $s['service']; ?></td>

                            <td><?php echo $s['dkc']; ?></td>
                            <td value="<?php echo floatval($s['dkcamt']); ?>"><?php echo "$" . number_format(floatval($s['dkcamt']), 2); ?></td>
                            <td><?php echo $s['dkcrate']."%"; ?></td>
                            <td value="<?php echo floatval($s['dkcprorated']); ?>"><?php echo "$" . number_format(floatval($s['dkcprorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['dkcregular']); ?>"><?php echo "$" . number_format(floatval($s['dkcregular']), 2); ?></td>

                            <td><?php echo $s['p1']; ?></td>
                            <td value="<?php echo floatval($s['p1amt']); ?>"><?php echo "$" . number_format(floatval($s['p1amt']), 2); ?></td>
                            <td><?php echo $s['p1rate']."%"; ?></td>
                            <td value="<?php echo floatval($s['p1prorated']); ?>"><?php echo "$" . number_format(floatval($s['p1prorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['p1regular']); ?>"><?php echo "$" . number_format(floatval($s['p1regular']), 2); ?></td>

                            <td><?php echo $s['p2']; ?></td>
                            <td value="<?php echo floatval($s['p2amt']); ?>"><?php echo "$" . number_format(floatval($s['p2amt']), 2); ?></td>
                            <td><?php echo $s['p2rate']."%"; ?></td>
                            <td value="<?php echo floatval($s['p2prorated']); ?>"><?php echo "$" . number_format(floatval($s['p2prorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['p2regular']); ?>"><?php echo "$" . number_format(floatval($s['p2regular']), 2); ?></td>

                            <td><?php echo $s['p3']; ?></td>
                            <td value="<?php echo floatval($s['p3amt']); ?>"><?php echo "$" . number_format(floatval($s['p3amt']), 2); ?></td>
                            <td><?php echo $s['p3rate']."%"; ?></td>
                            <td value="<?php echo floatval($s['p3prorated']); ?>"><?php echo "$" . number_format(floatval($s['p3prorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['p3regular']); ?>"><?php echo "$" . number_format(floatval($s['p3regular']), 2); ?></td>

                            <td><?php echo $s['p4']; ?></td>
                            <td value="<?php echo floatval($s['p4amt']); ?>"><?php echo "$" . number_format(floatval($s['p4amt']), 2); ?></td>
                            <td><?php echo $s['p4rate']."%"; ?></td>
                            <td value="<?php echo floatval($s['p4prorated']); ?>"><?php echo "$" . number_format(floatval($s['p4prorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['p4regular']); ?>"><?php echo "$" . number_format(floatval($s['p4regular']), 2); ?></td>
                            <td>Service</td>
                            <td value="<?php echo floatval($s['servicingamt']); ?>"><?php echo "$" . number_format(floatval($s['servicingamt']), 2); ?></td>
                            <td><?php echo $s['servicingrate']."%"; ?></td>
                            <td value="<?php echo floatval($s['servicingprorated']); ?>"><?php echo "$" . number_format(floatval($s['servicingprorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['servicingregular']); ?>"><?php echo "$" . number_format(floatval($s['servicingregular']), 2); ?></td>
                            <td>Yield</td>
                            <td value="<?php echo floatval($s['yieldamt']); ?>"><?php echo "$" . number_format(floatval($s['yieldamt']), 2); ?></td>
                            <td><?php echo $s['yieldrate']."%"; ?></td>
                            <td value="<?php echo floatval($s['yieldregular']); ?>"><?php echo "$" . number_format(floatval($s['yieldregular']), 2); ?></td>
                            <td value="<?php echo floatval($s['yieldprorated']); ?>"><?php echo "$" . number_format(floatval($s['yieldprorated']), 2); ?></td>
                            <td value="<?php echo floatval($s['balance']); ?>"><?php echo "$" . number_format(floatval($s['balance']), 2); ?></td>

                        <?php
                        $sn++;
                    }
                        ?>
                        <tr>
                            <td>Total</td>
                            <td colspan="3"></td>
                            <td><?php echo "$".number_format($total_loan,2)?></td>
                            <td colspan="9"></td>
                            <td><?php echo "$".number_format($lender,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($lender_pro,2)?></td>
                            <td><?php echo "$".number_format($lender_reg,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p1,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p1_pro,2)?></td>
                            <td><?php echo "$".number_format($p1_reg,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p2,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p2_pro,2)?></td>
                            <td><?php echo "$".number_format($p2_reg,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p3,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p3_pro,2)?></td>
                            <td><?php echo "$".number_format($p3_reg,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p4,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($p4_pro,2)?></td>
                            <td><?php echo "$".number_format($p4_reg,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($servicing,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($servicing_pro,2)?></td>
                            <td><?php echo "$".number_format($servicing_reg,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($yield,2)?></td>
                            <td></td>
                            <td><?php echo "$".number_format($yield_reg,2)?></td>
                            <td><?php echo "$".number_format($yield_pro,2)?></td>
                            <td><?php echo "$".number_format($balance,2)?></td>
                        </tr>
                </table>

            </div>

			<table class="main-total">
				<tr>
					<th></th>
					<?php
					foreach ($columns as $head) {
						echo '<th>' . $head . '</th>';
					}
					?>

				</tr>
				<tr>


					<td><label style="margin-right:20px;">Total Participants Payable :</label> </td>
					<?php
					foreach ($tpayable as $tp) {
					?>
						<td><?php echo "$" . number_format($tp, 2); ?></td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td><label style="margin-right:20px;">Total Collectable :</label> </td>
					<?php
					foreach ($tcollect as $tp) {
					?>
						<td><?php echo "$" . number_format($tp, 2); ?></td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td><label style="margin-right:20px;">Balance :</label> </td>
					<?php
					foreach ($columns as $title) {

					?>
						<td><?php echo "$" . number_format(floatval($tcollect[$title]) - floatval($tpayable[$title]), 2); ?></td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td><label style="margin-right:20px;">Servicing Fee :</label> </td>
					<?php
					foreach ($tservice as $tp) {
					?>
						<td><?php echo "$" . number_format($tp, 2); ?></td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td><label style="margin-right:20px;">Yield Spread :</label> </td>
					<?php
					foreach ($tyield as $tp) {
					?>
						<td><?php echo "$" . number_format($tp, 2); ?></td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td><label style="margin-right:20px;">Check/Balance :</label> </td>
					<?php
					foreach ($columns as $title) {

					?>
						<td style="background-color: #33CAFF !important"><?php echo "$" . number_format((floatval($tcollect[$title]) - floatval($tpayable[$title])) - (floatval($tservice[$title]) + floatval($tyield[$title])), 2); ?></td>
					<?php
					}
					?>
				</tr>
			</table>

		</div>


		<br>
		<script>
			$("#batch-preview").hide();
			$("#mass-sending-alert").hide();
		</script>
		<script src="../js/users.js"></script>
		<?php include "../global/footer.php"; ?>
		</div>
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