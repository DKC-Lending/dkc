<?php include_once('../backend/session.php');?>
<?php
include_once('../backend/post/postControl.php');
error_reporting(1);
$date = $posts->latest_post_date($i_conn);
$nowDate = (string)date("d/m/Y");
$isTrue = $date["pdate"]==$nowDate?true:false;
?>

<div id="header">
		
			<!-- <input type="search" id="search" placeholder=" &#xF002;  Search...." style="font-family: Arial, 'Font Awesome 5 Free'">
				 -->
				<a href="index.php"> <img src="../img/logo/<?php echo $web['clientimg'];?>" class="web-logo"></a>
				<div class="profile">
						<div>
							<p>Welcome back, <?php echo $_SESSION["cuser"];?><br><label>Investor</label></p>
						</div>
						<img class="avatar" src="../img/misc/avatar.png">
					</div>
				
					
				<div class="notification-icon-holder"><div><a href="investment.php" class="header-icon"><?php if($isTrue){?><i class="noti-alert"></i><?php } ?><i class="fa-solid fa-bell"></i></a>
				<a href="../backend/logout.php" name="logout" class="header-icon"><i class="fa-solid fa-right-from-bracket"></i></a></div></div>
				
		
	</div>
	<?php

	
?>