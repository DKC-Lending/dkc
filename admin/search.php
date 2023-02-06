<?php try { ?>
	<?php
	include "../backend/summary/summaryControl.php";

	error_reporting(1);
	if (isset($_GET["search_usr"])) {
		$uname = $_GET["search_usr"];
		include '../backend/config/conifg.php';
		$web = $config->fetch();
	?>

		<html lang="en">

		<head>
			<title>Search | <?php echo $web["name"]; ?></title>
		</head>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<?php include "../global/links.html"; ?>
		<link rel="stylesheet" type="text/css" href="../css/global.css">
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/nav.css">
		<link rel="stylesheet" type="text/css" href="../css/buttons.css">
		<link rel="stylesheet" type="text/css" href="../css/footer.css">
		<link rel="stylesheet" type="text/css" href="../css/admin/search.css">
		<link rel="stylesheet" type="text/css" href="../css/borrower.css">
		<link rel="stylesheet" type="text/css" href="../css/index.css">
		<link rel="stylesheet" type="text/css" href="../css/topheader.css">
		<link rel="stylesheet" type="text/css" href="../css/alert.css">
		<?php include "../global/alert.html"; ?>
		<script type="text/javascript" src="../js/alert.js"></script>
		<script type="text/javascript" src="../js/search.js"></script>

		<body>
			<?php include "../global/adminnav.php" ?>
			<?php include "../global/adminheader.php" ?>
			<?php
			include '../backend/usercontrol.php';
			$investors = $Users->get_details_from_username($conn, $uname);
			include_once('../backend/post/postControl.php');
			?>

			<?php
			// include '../backend/main/borrowerController.php';
			// include '../backend/getshowablecolumn.php';
			// $classCell = new ShowCell();
			// $showCell = $classCell->getShowablecell($uname, $conn);

			$c_summary = new Summary();
			$summary = $c_summary->specificData($uname, $sum_conn);
			?>

			<div class="content">
				<div class="main-container">
					<div class="top-head-txt">
						<div>
							<p>Search <br> <label class="sub-heading">You can view investors details here.</label> </p>
						</div>
					</div>
					<div style="margin-left:90px;padding-right:10px;">
						<?php include "../clients/main-borrower.php"; ?>


					</div>
					<br>
					<br>



					<!-- <div class="cellChecker">
					<h4>Visible Column</h4>
					<div>
						<?php

						if (1 == 2) {
							for ($i = 9; $i != count($tbl_heading); $i++) {

						?>
								<div>

									<p><?php echo $tbl_heading[$i]; ?></p>
									<input type="checkbox" onchange="changeColumn(this,'<?php echo $uname; ?>')" name="check" id="check" value="<?php echo $tbl_heading[$i]; ?>" <?php echo (in_array($tbl_heading[$i], $showCell) ? "checked" : ""); ?>>
								</div>
							<?php
							}
						} else {
							?>
							<center style="color:red;"> No Showable Column</center>
						<?php
						}

						?>

					</div>
				</div> -->



					<br>
					<br>
					<div class="user-card">
						<div>
							<img src="../img/misc/avatar.png" class="profile-img" alt="image">
							<div>
								<table class="investor-table">
									<tr>
										<th>First Name</th>
										<th>Last Name</th>
										<th>Email</th>
										<th>Phone</th>
										<th>Street Address</th>
										<th>State</th>
										<th>Zip</th>
									</tr>
									<tr>
										<td><?php echo $investors["fname"]; ?></td>
										<td><?php echo $investors["lname"]; ?></td>
										<td><?php echo $investors["email"]; ?></td>
										<td><?php echo $investors["phone"]; ?></td>
										<td><?php echo $investors["saddress"]; ?></td>
										<td><?php echo $investors["state"]; ?></td>
										<td><?php echo $investors["zip"]; ?></td>
									</tr>

								</table>
								<div>
									<button onclick="email_popup('<?php echo $investors['email']; ?>')">Send Email</button>
									<button onclick="sms_popup('<?php echo $investors['phone']; ?>')">Send SMS</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
			<div class="dashboard-holder">
				<?php
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

					if ($sumdata['p1'] == $uname) {
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

				$avg_rate = $avg_rate / count($summData);

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
							<label id="tinvest-money"><?php echo number_format($avg_rate, 2) . "%"; ?></label><br>
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
			</div>
		</body>

		</html>
	<?php

	} else {
		header("Location: ../admin/users.php");
	}
	?>
<?php
} catch (Error $er) {
	ob_clean();
	include('../500.php');
} finally {
	ob_flush();
}
?>