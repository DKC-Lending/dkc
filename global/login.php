
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Login</title>
</head>
<?php include '../global/links.html';?>
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/login.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit"
    async defer>
</script>

<script type="text/javascript">
      var onloadCallback = function() {
        grecaptcha.render('captcha', {
          'sitekey' : '6LcxRZwcAAAAAJERjlq2BEgCkvJwBLKlN2V-j3ve'
        });
      };
    </script>

<body>
	<div class="header">
		<div class="header-content">
			<img src="../img/logo/logo1.png">

			<p><a href="" target="_self">Go to Main Website</a></p>
		</div>
	</div>
		
	<main>
		<div class="image-holder">

		<div class="login-box">
			<div class="login-content">
				<p class="head" align="center">Welcome Back,</p>
				<p class="subhead" align="center">Login to your Dashboard</p>

				<form action="../backend/login.php" method="POST">
					<div class="input-holder">
						<input type="text" name="username" id="username" placeholder="Enter your Username" class="input" required>
					</div>
					<div class="input-holder">
						<input type="password" name="password" id="password" placeholder="Enter your Password" class="input" required> 
					</div>
					<div id="captcha" name="captcha" required></div>
      					<br>
      				<div class="btn-holder">
      					<input type="submit" name="submit" value='Login' class="solid-btn" style="font-family: Arial, 'Font Awesome 5 Free'">
      					<a href=""><button class="border-btn">Get your account &#160; <i class="fa-solid fa-pencil"></i></button></a>
      				</div>
					<p style="text-align: center;color:red;font-size:0.8rem;"><?php if(isset($_GET['code'])){ $c = $_GET['code']; echo ($c == 1)? "Captcha Auth Fail": "Incorrect login details";unset($_GET['code']);} ?></p>
				</form>
			</div>

		</div>
		</div>

	</main>
	<?php include '../global/footer.php'; ?>

</body>

</html>