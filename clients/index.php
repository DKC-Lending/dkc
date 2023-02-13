<?php try { ?>
	<!DOCTYPE html>
	<?php
	include '../backend/config/conifg.php';
	$web = $config->fetch();
	?>
	<html>

	<head>
		<meta charset="utf-8">
		<title>Investor Dashboard | <?php echo $web["name"]; ?></title>
		<link rel="stylesheet" type="text/css" href="../css/global.css">
		<link rel="stylesheet" type="text/css" href="../css/header.css">
		<link rel="stylesheet" type="text/css" href="../css/index.css">
		<link rel="stylesheet" type="text/css" href="../css/nav.css">
		<link rel="stylesheet" type="text/css" href="../css/buttons.css">
		<link rel="stylesheet" type="text/css" href="../css/footer.css">
		<link rel="stylesheet" type="text/css" href="../css/borrower.css">
		<?php include '../global/nav.php'; ?>
		<?php include '../global/links.html'; ?>
	</head>

	<body>

		<?php include '../global/header.php'; ?>

		<div class="content">
			<div id="main-container">
				<div class="top-head-txt">
					<div>
						<p>
							Dashboard<br>
							<lable class="sub-heading">see your all summary from here</lable>
						</p>
					</div>
					<div>
						<button class="border-btn" onclick="window.open('borrower.php','_self')">See my Investment</button>
						<button class="solid-btn" onclick="window.open('investment.php','_self')">See Investment Opportunities</button>
					</div>
				</div>

				<?php include 'dashboard.php'; ?>

			</div>
		</div>
	</body>

	</html>
<?php
} catch (Error $er) {
	// ob_clean();
	// include('../500.php');
} finally {
	// ob_flush();
}
?>