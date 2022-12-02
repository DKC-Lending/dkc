<?php
include_once('../backend/adminsession.php');
include '../backend/contact/connect_contact.php';
?>
<?php
error_reporting(1);
include_once('../backend/contact/getContactmsg.php');

$contact = getResponse($cus_conn);

include '../backend/config/conifg.php';
$web = $config->fetch();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<title>Admin Contact | <?php echo $web["name"]; ?></title>

</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include "../global/links.html"; ?>
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link rel="stylesheet" type="text/css" href="../css/nav.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<link rel="stylesheet" type="text/css" href="../css/topheader.css">
<link rel="stylesheet" type="text/css" href="../css/admin/contact.css">


<body>
	<?php include "../global/adminnav.php"; ?>
	<?php include "../global/adminheader.php"; ?>
	<?php include "../backend/usercontrol.php"; ?>


	<br>
	<br>
	<div class="top-head-txt">
		<p> Client Support </p>
	</div>
	<div class="history-frame">

		<section class="content">
			<?php
			if (count($contact) > 0) {
			?>
				<table id="response-table">
					<tr>
						<th>Username</th>
						<th>Full Name</th>
						<th>Email</th>
						<th>Message</th>
						<th>Date</th>
						<th>Action</th>
					</tr>
					<?php

					foreach ($contact as $n) {
					?>
						<tr>
							<td><a href="search.php?search_usr=<?php echo $n['user']; ?>"><?php echo $n['user']; ?></a></td>
							<td><?php echo $n['name']; ?></td>
							<td><?php echo $n['email']; ?></td>
							<td style="text-align: left; "><?php echo $n['msg']; ?></td>
							<td><?php echo $n['date']; ?></td>
							<td><button class="close-btn" onclick="deleteResponse('<?php echo $n['uid']; ?>')"><i class="fa-regular fa-circle-xmark"></i></button></td>

						</tr>
					<?php
					}

					?>

				</table>
			<?php
			} else {
			?>
				<div class="empty">
					<img src="../img/misc/cloudman_drbl.gif">
				</div>
			<?php
			} ?>
		</section>
	</div>



	<br>
	<br>

	<script src="../js/contact.js"></script>

	<?php
	seenContact($cus_conn);
	?>
	<script>
		$("#noti-alert").remove();
	</script>
	<?php include "../global/footer.php"; ?>

</body>

</html>