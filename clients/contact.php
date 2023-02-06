<?php try{ ?>
<?php include_once('../backend/session.php');?>
<?php

error_reporting(1);
 include '../backend/config/conifg.php';
 $web = $config->fetch();
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Contact us | <?php echo $web["name"];?></title>

</head>
<?php include "../global/links.html";?>
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link rel="stylesheet" type="text/css" href="../css/nav.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<link rel="stylesheet" type="text/css" href="../css/client/contact.css">
<link rel="stylesheet" type="text/css" href="../css/topheader.css">
<link rel="stylesheet" type="text/css" href="../css/alert.css">
<script type="text/javascript" src="../js/alert.js"></script>
<script  src="../js/changeimg.js"></script>
<script type="text/javascript" src="../js/webconfig.js"></script>
<body>
	<?php include "../global/nav.php"?>
	<?php include "../global/header.php"?>
<div class="content">
	<div class="main-container">
		<div class="top-head-txt">
					<div>
						<p>
							Contact us<br>
						<lable class="sub-heading">Contact with support team from this page</lable></p>
					</div>
				</div>
				<div class="body-holder">
					<div class="container">
						<div class="content">
						<div class="left-side">
							<div class="address details">
							<i class="fas fa-map-marker-alt"></i>
							<div class="topic">Address</div>
							<div class="text-one">Richmond, VA | Tampa, FL</div>
					
							</div>
							<div class="phone details">
							<i class="fas fa-phone-alt"></i>
							<div class="topic">Phone</div>
							<div class="text-one">+1 804-214-6879</div>
						
							</div>
							<div class="email details">
							<i class="fas fa-envelope"></i>
							<div class="topic">Email</div>
							<div class="text-one">webmail@dkclending.com</div>
						
							</div>
						</div>
						<div class="right-side">
							<div class="topic-text">Send us a message</div>
							<p>If you have any query or problem with business or found any bug on the sites. Feel free to report us.</p>
						<form action="#"  id="contactform">
							<input type="hidden" id="sessionuser" value="<?php echo $_SESSION['cuser'];?>">
							<div class="input-box">
							<input type="text" id="name" placeholder="Enter your name" required> 
							</div>
							<div class="input-box">
							<input type="email" id="email" placeholder="Enter your email" required>
							</div>
							<div class="input-box message-box">
							<textarea id="message" placeholder="Enter your message" required></textarea>
							</div>
							<div class="button">
							<input type="submit" value="Send Now" >
							</div>
						</form>
						</div>
						</div>
					</div>


				</div>
		</div>
	
	<br>
	<script src="../js/contact.js"></script>
	<?php include "../global/footer.php";?>
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