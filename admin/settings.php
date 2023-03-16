<?php try { ?>
	<?php include_once('../backend/adminsession.php'); ?>
	<?php
	include '../backend/config/conifg.php';
	include '../backend/connect.php';
	include '../backend/LoginHistory.php';

	$loginHistory = new LoginHistory();
	$web = $config->fetch();
	?>

	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Admin Setting | <?php echo $web["name"]; ?></title>

	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include "../global/links.html"; ?>
	<link rel="stylesheet" type="text/css" href="../css/global.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<link rel="stylesheet" type="text/css" href="../css/buttons.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/admin/settings.css">
	<link rel="stylesheet" type="text/css" href="../css/topheader.css">
	<script type="text/javascript" src="../js/changeimg.js"></script>
	<script type="text/javascript" src="../js/webconfig.js"></script>
	<?php
	include '../backend/summary/summaryControl.php';

	$summary = new Summary();
	$monthHeading = $summary->get_heading_setting($sum_conn);
	?>

	<body>
		<?php include "../global/adminnav.php" ?>
		<?php include "../global/adminheader.php" ?>
		<div class="content">
			<div class="main-container">
				<div class="top-head-txt">
					<div>
						<p>
							Settings<br>
							<lable class="sub-heading">change your website settings from here</lable>
						</p>
					</div>
				</div>
				<div class="month-setting">
					<h3>Month Column Setting</h3>
					<div class="month-holder">
						<?php foreach ($monthHeading as $m) { ?>

							<div class="month">
								<label for="<?php echo $m; ?>"><?php echo $m; ?></label>
								<input type="checkbox" class="monthBox" name="<?php echo $m; ?>" id="<?php echo $m; ?>" onchange="monthController(this)">
							</div>
						<?php } ?>


					</div>
				</div>

				<div class="loginHistoryHolder">
					<p class="login-history-title">Login History</p>
					<?php
					$loginhistroygroup = $loginHistory->getLoginHistoryByGroup($conn);
					foreach ($loginhistroygroup as $history) {

					?>
						<p><?php echo $history[0]['username']; ?></p>

						<table class="login-history-table">
							<tr>
								<th>IP Address</th>
								<th>Time</th>
							</tr>
							<?php
							foreach ($history as $h) {
							?>
								<tr>
									<td><?php echo $h['device']; ?></td>
									<td><?php echo $h['time']; ?></td>
								</tr>
							<?php
							}
							?>
						</table>
					<?php

					}
					?>

				</div>

				<div class="body-holder">
					<div class="portal-title">
						<div class="portal-card">
							<div class="icon-holder"><i class="fa-solid fa-pencil"></i></div>
							<div>
								<label>Portal Title</label>
								<br>
								<div class="input-holder">
									<input type="text" name="title" class="setting-input" placeholder="Portal Title" value="<?php echo $web['name']; ?>">
								</div>
							</div>
							<div>
								<label></label>
								<br>
								<input type="submit" name="submit" value='Save &#8250;' class="solid-btn">
							</div>
						</div>
					</div>
					<div class="portal-tagline">
						<div class="portal-card">
							<div class="icon-holder"><i class="fa-solid fa-pencil"></i></div>
							<div>
								<label>Portal Tagline</label>
								<br>
								<div class="input-holder">
									<input type="text" name="title" class="setting-input" placeholder="Portal Tagline" value="<?php echo $web['tagline']; ?>">
								</div>
							</div>
							<div>
								<label></label>
								<br>
								<input type="submit" name="submit" value='Save &#8250;' class="solid-btn">
							</div>
						</div>
					</div>
					<div class="portal-logo">
						<div class="portal-card">
							<div class="icon-holder"><i class="fa-solid fa-pencil"></i></div>
							<div class="mid">
								<label>Logo</label>
								<br>
								<section>
									<img id="web-logo" src="../img/logo/<?php echo $web['clientimg']; ?>" alt="image">
									<div class="file-holder">
										<i class="fa fa-upload" aria-hidden="true"></i>
										Select New Logo
									</div>
									<input type="file" name="logo" class="upload-btn" onchange="changeimg(event,'web-logo')">

								</section>

							</div>
							<div>
								<label></label>
								<br>
								<input type="submit" name="submit" value='Save &#8250;' class="solid-btn">
							</div>
						</div>
					</div>
					<div class="portal-adminlogo">
						<div class="portal-card">
							<div class="icon-holder"><i class="fa-solid fa-pencil"></i></div>
							<div class="mid">
								<label>Admin Logo</label>
								<br>
								<section>
									<img id="admin-logo" src="../img/logo/<?php echo $web['adminimg']; ?>" alt="image">
									<div class="file-holder"><i class="fa fa-upload" aria-hidden="true"></i>
										Select New Logo</div>
									<input type="file" name="logo" class="upload-btn" onchange="changeimg(event,'admin-logo')">

								</section>
							</div>
							<div>
								<label></label>
								<br>
								<input type="submit" name="submit" value='Save &#8250;' class="solid-btn">
							</div>
						</div>
					</div>
					<div class="help">
						<div>
							<p class="help-title">Help <i class="fa-solid fa-pencil"></i></p>
							<hr>
							<ol type="1">
								<li>Introduction to portal</li>
								<li>Adding mew borrowers</li>
								<li>Adding new investors</li>
								<li>Mapping investors and borrowers</li>
								<li>Changing frontend logo</li>
								<li>Changing dashboard logo</li>
								<li>Changing portal title</li>
								<li>Changing portal tagline</li>
								<li>Adding new investment opportunities</li>
								<li>Getting email notifications</li>
								<li>Sending SMS & Email notifications</li>
								<li>Developers documentations</li>
							</ol>

						</div>
					</div>
				</div>
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