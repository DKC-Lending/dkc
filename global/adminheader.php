<?php include_once('../backend/adminsession.php'); ?>
<?php
include_once('../backend/post/investment_connect.php');
include_once('../backend/notification/notificationHandler.php');
error_reporting(1);
$noti = new Notification();
$notif = $noti->getLatestnotification($i_conn)['status'];
$isTrue = ($notif == 0 && $notif != '') ? true : false;
?>


<div id="header">

	<!-- <input type="search" id="search" placeholder=" &#xF002;  Search...." style="font-family: Arial, 'Font Awesome 5 Free'">
				 -->
	<a href="borrower.php"><img src="../img/logo/<?php echo $web['adminimg']; ?>" class="web-logo" alt="image"></a>

	<div class="profile">
		<div>
			<p>Welcome back, <?php echo $_SESSION["auser"]; ?><br><label>Admin</label></p>
		</div>
		<img class="avatar" src="../img/misc/avatar.png" alt="image">
	</div>


	<div class="notification-icon-holder">
		<div><a href="notification.php" class="header-icon"><?php if ($isTrue) { ?><i class="noti-alert"></i><?php } ?><i class="fa-solid fa-bell"></i></a>

			<a href="../backend/logout.php" name="logout" class="header-icon"><i class="fa-solid fa-right-from-bracket"></i></a>
		</div>
	</div>


</div>
<?php


?>