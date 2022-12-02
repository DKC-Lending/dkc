<?php include_once('../backend/adminsession.php'); ?>
<?php
error_reporting(1);
include '../backend/insurance/invoiceController.php';
include_once('../backend/insurance/get_borrower.php');
include '../backend/config/conifg.php';
$web = $config->fetch();
$pdf = get_data_from_id($pdfconn, $_GET['uid']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Users | <?php echo $web["name"]; ?></title>

</head>
<?php include "../global/links.html"; ?>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link rel="stylesheet" type="text/css" href="../css/nav.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<link rel="stylesheet" type="text/css" href="../css/admin/history.css">
<link rel="stylesheet" type="text/css" href="../css/topheader.css">

<body>
	<?php include "../global/adminnav.php"; ?>
	<?php include "../global/adminheader.php"; ?>
	<?php include "../backend/usercontrol.php"; ?>

	<?php
	$uid = $_GET['uid'];
	$name = $_GET['name'];
	$mydir = "../pdf/$uid";
	if (scandir($mydir)) {
		$myfiles = array_diff(scandir($mydir), array('.', '..'));
	}

	?>
	<br>
	<br>
	<center>
		<h1><?php echo $name; ?> Invoice history</h1>


		<div class="table-month">
			<table id="month">
				<tr>
					<?php
					foreach (array_keys($pdf) as $head) {
						if ($head != "invid") {
							echo "<th>" . $head . "</th>";
						}
					}

					?>
				</tr>
				<tr>
					<?php
					foreach ($pdf as $head) {
						if ($pdf['invid'] != $head) {
							echo "<td>" . $head . "</td>";
						}
					}

					?>
				</tr>
			</table>
		</div>
	</center>
	<div class="history-frame">


		<section>

			<?php
			foreach ($myfiles as $f) {
			?>

				<div>
					<a href="<?php echo $mydir . '/' . $f; ?>" target="_blank"><?php echo $f; ?></a>
					<button onclick="delete_pdf('<?php echo $uid . '/' . $f; ?>')">Delete</button>
				</div>

			<?php
			}

			?>
		</section>
	</div>


	<br>
	<br>
	<br>
	<script src="../js/users.js"></script>
	<script src="../js/invoices.js"></script>
	<?php include "../global/footer.php"; ?>
	</div>
</body>

</html>