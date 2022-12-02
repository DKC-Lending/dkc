<?php include_once('../backend/adminsession.php');?>
<?php
 include '../backend/config/conifg.php';
 $web = $config->fetch();
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title>Admin Users | <?php echo $web["name"];?></title>

</head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php include "../global/links.html";?>
<link rel="stylesheet" type="text/css" href="../css/global.css">
<link rel="stylesheet" type="text/css" href="../css/header.css">
<link rel="stylesheet" type="text/css" href="../css/nav.css">
<link rel="stylesheet" type="text/css" href="../css/buttons.css">
<link rel="stylesheet" type="text/css" href="../css/footer.css">
<link rel="stylesheet" type="text/css" href="../css/admin/users.css">
<link rel="stylesheet" type="text/css" href="../css/topheader.css">
<link rel="stylesheet" type="text/css" href="../css/alert.css">
<script src="../js/alert.js"></script>
<body>
	<?php include "../global/adminnav.php";?>
	<?php include "../global/adminheader.php";?>
	<?php include "../backend/usercontrol.php";?>
	

	<div class="content">
		<div class="main-container">
			<div class="top-head-txt-center">
						<div>
							<p>Users <br> <label class="sub-heading">You can add, update or delete users from here</label> </p>
						</div>
			</div>
			<center>
				<div class="body-holder">
					<section>
						<p class="title">Add new user</p>
						<form id="signupform" action="../backend/signup.php" method="post">
							<div class="usercard">
								<p>First name*     <input type="text" id="fname" class="user-input" required="true"></p>
								<p>Last name*      <input type="text" id="lname" class="user-input" required="true"></p>
								<p>Email*          <input type="email" id="email" class="user-input" required="true"></p>
								<p>Phone*          <input type="text" id="phone" class="user-input" required="true"></p>
								<p>Username*       <input type="text" id="uname" class="user-input" required="true"></p>
								<p>Password*       <input type="password" id="password" class="user-input" required="true"></p>
								<p>Street Address* <input type="text" id="saddress" class="user-input" required="true"></p>
								<p>State* 		   <input type="text" id="state" class="user-input" required="true"></p>
								<p>ZIP* 		   <input type="text" id="zip" class="user-input" required="true"></p>
								<p>Type* 		   <select id="role"  class="user-input">
														<option id="0">Admin</option>
														
														<option id="2">Investor</option>
													</select></p>
							</div>
							<input type="submit" name="submit" class="solid-btn" value="add">
						</form>
					</section>
				</div>
				
				<div class="search-bar">
				
					<form method="get" action="search.php" autocomplete="false">
						<input  class="search-box" autocomplete="false" list="investors-data" placeholder="  Investor Search.." name="search_usr">
						<input type="submit" value="Search" class="search-btn">
					</form>
				</div>

				<datalist id="investors-data">
					<?php
						$searchData = $Users->category_users($conn,2);
						foreach($searchData as $sdata){
					?>
					<option value="<?php echo $sdata["username"];?>">
					<?php } ?>
				</datalist>
				<div class="top-head-txt-center">
						<div>
							<p>Users Details </p>
						</div>
			</div>
				<table class="user-table" id="utable" cellspacing="0" cellpadding="0">

					<tr>
							<th>S.N.</th>
							<th>Username</th>
							<th>Fullname</th>
							<th>Password</th>
							<th>Email</th>
							<th>Phone</th>
							<th>Street</th>
							<th>State</th>
							<th>Zip</th>
							<th>Type</th>
							<th>Action</th>
					</tr>
						
					<?php
					$arr = $Users->all_users($conn);
					for($i=0;$i<count($arr);$i++){
						?>
						<tr>
							<td><?php echo $i+1;?></td>
							<?php
								if($arr[$i]["type"]!="0"){
							?>
							<td><a href="search.php?search_usr=<?php echo $arr[$i]["username"];?>"><?php echo $arr[$i]["username"];?></a></td>
							<?php
								}else{
									?>
									<td><?php echo $arr[$i]["username"];?></td>
							
									<?php
								}
							?>
							<td><?php echo $arr[$i]["fname"]." ".$arr[$i]["lname"];?></td>
							<td><?php echo $arr[$i]["password"];?></td>
							<td><?php echo $arr[$i]["email"];?></td>
							<td><?php echo $arr[$i]["phone"];?></td>
							<td><?php echo $arr[$i]["saddress"];?></td>
							<td><?php echo $arr[$i]["state"];?></td>
							<td><?php echo $arr[$i]["zip"];?></td>
							<td><?php echo $arr[$i]["type"]=="0"?"Admin":($arr[$i]["type"]=="1"?"Borrower":"Investor");?></td>
							<td><a href="#" id="<?php echo $arr[$i]["username"].$arr[$i]["type"].'e';?>" class="edit-btn" onclick="userEditor(this,'<?php echo $arr[$i]["fname"];?>','<?php echo $arr[$i]["lname"];?>','<?php echo $arr[$i]["email"];?>','<?php echo $arr[$i]["phone"];?>','<?php echo $arr[$i]["username"];?>','<?php echo $arr[$i]["password"];?>','<?php echo $arr[$i]["saddress"];?>','<?php echo $arr[$i]["state"];?>','<?php echo $arr[$i]["zip"];?>')"><i class="fa-solid fa-pen"></i></a>
							    <a onclick="delUser(this)" id="<?php echo $arr[$i]["username"].$arr[$i]["type"].'d';?>" style="color:red;!important" class="del-btn"><i class="fa-solid fa-trash"></i></a></td>
						</tr>

						<?php
					}


					?>
					
					
					
				</table>

			</center>
		</div>
	</div>
	
    <script src="../js/users.js"></script>
	<?php include "../global/footer.php";?>
</div>
</body>
</html>