<?php try { ?>
<?php include_once('../backend/session.php'); ?>
<?php
include '../backend/config/conifg.php';
$web = $config->fetch();
include_once('../backend/main/borrowerController.php');
include "../backend/summary/summaryControl.php";

?>
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>Investor Dashboard | <?php echo $web["name"]; ?></title>
	<link rel="stylesheet" type="text/css" href="../css/global.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/borrower.css">
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<link rel="stylesheet" type="text/css" href="../css/buttons.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/topheader.css">
	
	<?php include '../global/nav.php'; ?>
	<?php include '../global/links.html'; ?>
	

</head>

<body>

	<?php include '../global/header.php'; ?>

	<div class="content">
		<div class="main-container">
			<div class="top-head-txt">
				<div>
					<p>Investor Borrower Panel <br> <label class="sub-heading">You can add, update or delete users from here</label> </p>
				</div>
			</div>
		</div>
		<?php include 'main-borrower.php'; ?>

		<section class="overview-card">
			<h4>Total Investment</h4>
			<div><label><b>No. of Borrower</b></label> <label><?php echo $count; ?></label></div>
			<div><label><b>Amount Invested</b></label> <label><?php echo '$' . $amount; ?></label></div>
		</section>

		<?php include "../global/footer.php"; ?>
	</div>

</body>

</html>
<?php
} catch (Error $er) {
    ob_clean();
    include('../500.php');
}finally{
    ob_flush();
}
?>