<?php
include_once('../backend/adminsession.php');
include '../backend/post/investment_connect.php';
?>
<?php
error_reporting(1);
include_once('../backend/insurance/get_borrower.php');
include_once('../backend/notification/notificationHandler.php');
$noticlass = new Notification();
$noti = $noticlass->getAllNotification($i_conn);
$ndatas = $noti;
include '../backend/config/conifg.php';
$web = $config->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Notification | <?php echo $web["name"]; ?></title>

</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include "../global/links.html"; ?>
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link rel="stylesheet" type="text/css" href="../css/nav.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<link rel="stylesheet" type="text/css" href="../css/topheader.css">
<link rel="stylesheet" type="text/css" href="../css/admin/notification.css">

<script src="../js/notification.js"></script>

<body>
	<?php include "../global/adminnav.php"; ?>
	<?php include "../global/adminheader.php"; ?>
	<?php include "../backend/usercontrol.php"; ?>


	<br>
	<br>
	<div class="top-head-txt">
		<p> Notification </p>
	</div>
	<div class="history-frame">
		<?php
		if (count($ndatas) > 0) {
		?>

			<section class="content">
				<?php

				foreach ($ndatas as $n) {

				?>
					<div class="notification-card">
						<p><label><?php echo $n['username']; ?></label> is interested on the <label><?php echo $n['title']; ?></label> at <label><?php echo $n['type']; ?></label></p>
						<div class="action-holder">
							<a href="search.php?search_usr=<?php echo $n['username']; ?>">Email Now</a>
							<button class="close-btn" onclick="deleteNotification('<?php echo $n['uid']; ?>')"><i class="fa-regular fa-circle-xmark"></i></button>
						</div>
					</div>

				<?php
				}

				?>


			</section>
		<?php
		} else {
		?>
			<div class="empty">
				<img src="../img/misc/cloudman_drbl.gif">
			</div>
		<?php
		} ?>
	</div>



	<br>
	<br>

	<?php include "../global/footer.php"; ?>

	<?php
	$noticlass->seenNotification($i_conn);
	?>
	<script>
		$(".noti-alert").remove();
	</script>
</body>

</html>