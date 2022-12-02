<!DOCTYPE html>
<?php
error_reporting(1);
 include '../backend/config/conifg.php';
 $web = $config->fetch();
?>
<html>
<head>
	<meta charset="utf-8">
	<title>Investor Dashboard | <?php echo $web["name"];?></title>
	<link rel="stylesheet" type="text/css" href="../css/global.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<link rel="stylesheet" type="text/css" href="../css/buttons.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/investpost.css">
	<link rel="stylesheet" type="text/css" href="../css/topheader.css">
	<link rel="stylesheet" type="text/css" href="../css/alert.css">
	<?php include '../global/links.html';?>
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.css">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-confirm/3.3.2/jquery-confirm.min.js"></script>
	<link rel="stylesheet" type="text/css" href="../css/client/investment.css">

	<?php include '../global/alert.html'; ?>
	<?php include '../global/nav.php'; ?>
	
	<script type="text/javascript" src="../js/alert.js"></script>
	<script type="text/javascript" src="../js/investment.js"></script>
	
	<?php include '../global/header.php';?>
	<?php
		include '../backend/usercontrol.php';

		$user=$_SESSION["cuser"];
		$interested_offers = $posts->get_interested_user($i_conn,$user);
	
		$toogle_status = $Users->get_notification_status($conn,$user);
	 ?>
</head>
<body>
	<div class="content">
			<div class="main-container">
				<div class="top-head-txt">
							<div>
								<p>Investment Opportunities <br> <label class="sub-heading">You can select Interested opportunity</label> </p>
							</div>
				</div>
			</div>
			<div class="select">
				
				<center>
				<div class="noti-holder">
					SMS &nbsp;
							<label class="switch">
								<input type="checkbox" name="sms-switch" id="sms-start" value="<?php echo $toogle_status['nphone'];?>" onchange="email_sms_toogle(this,'<?php echo $user;?>')">
								<span class="slider"></span>
							</label>
						&nbsp;&nbsp;&nbsp;
					EMAIL &nbsp;
							<label class="switch">
								<input type="checkbox" name="email-switch" id="email-start" value="<?php echo $toogle_status['nemail'];?>" onchange="email_sms_toogle(this,'<?php echo $user;?>')">
								<span class="slider"></span>
							</label>

					</div>

				</center>
			</div>

			<section class="post-tab">
				<center>
				<?php
					$datas_post = $posts->get_posts($i_conn);
					foreach($datas_post as $ind=>$post){
					error_reporting(1);
				?>
						<div class="preview-holder" id="<?php echo "prev-hold".$post['pid'];?>">
						<div id="<?php echo "holder-".$post['pid'];?>"> <?php if($post["status"]=="0"){?><div class="sold-watermark" id="<?php echo "watermark-".$post['pid'];?>"></div><?php }?></div>
						
								<section  id="<?php echo "prev-main".$post['pid'];?>">
							
									<div class="img-holder" id="<?php echo "img-holder".$post['pid'];?>">
										<img src="<?php echo "../img/posts/".$post["thumbnail"];?>" id="thumbnail">
										<a id="fileurl" href="<?php echo $post['furl'];?>" target="_blank"><button class="solid-btn">Read More</button></a>
										<?php
										if ($post["status"]=='1'){
								
										if($interested_offers[$ind]==5)
											{
												
										?>
										<div class="ibutton-holder" id="<?php echo "ibutton-holder".$post['pid'];?>" align="center">
											<button class="interest-btn" onclick="add_offer('<?php echo $post['pid'];?>','<?php echo $user;?>',0)">50%</button>
											<button class="interest-btn" onclick="add_offer('<?php echo $post['pid'];?>','<?php echo $user;?>',1)">75%</button>
											<button class="interest-btn" onclick="add_offer('<?php echo $post['pid'];?>','<?php echo $user;?>',2)">99%</button>
										</div>
										<?php
											}else{
										
												$ioffs = $interested_offers[$ind];
											
												$ioff = $ioffs==0?"50%":($ioffs==1?"75%":"99%");

											?>
											<div align="center" id="<?php echo "iselected-holder".$post['pid'];?>" class="iselected-holder">
												<label>You have selected <?php echo $ioff;?></label>
												<button class="cross-btn" onclick="remove_offer('<?php echo $post['pid'];?>','<?php echo $user?>')">
													<i class="fa-solid fa-x"></i>
												</button>
											</div>
											<?php

											}
										}
											?>
									</div>

									<div class="txt-holder">
										<label class="htitle" id="title"><?php echo $post['ptitle'];?></label>
										<br>
										<br>
										<p><b>Collateral: </b><label id="collateral"><?php echo $post['icollateral'];?></label></p>
										<p><b>Borrower : </b><label id="borrower"><?php echo $post['iborrower'];?></label></p>
										<p><b>Brief Paragraph : </b><label id="brief"><?php echo $post['ibrief'];?></label></p>

										<p class="title">Loan Details</p>
										
										<p><b>Asset Value : </b><label id="asset"><?php echo $post['assetvalue'];?></label></p>
										<p><b>Loan Amount : </b><label id="loan"><?php echo $post['loanmaount'];?></label></p>
										<p><b>Loan to Value : </b><label id="loantovalue"><?php echo $post['loantovalue'];?></label></p>
										<p><b>Term : </b><label id="term"><?php echo $post['term'];?></label></p>
										<p><b>Type : </b><label id="type"><?php echo $post['type'];?></label></p>
										<p><b>Permanent Penalty : </b><label id="penalty"><?php echo $post['ppenalty'];?></label></p>
										<p><b>Monthly Interested Offered to Participant : </b><label id="interestoffer"><?php echo $post['monthlyp'];?></label></p>

										<p class="title">Participation Opportunities</p>
									
										<p><b>99% : </b><label id="99p"><?php echo $post['99p'];?></label></p>
										<p><b>75% : </b><label id="75p"><?php echo $post['75p'];?></label></p>
										<p><b>50% : </b><label id="50p"><?php echo $post['50p'];?></label></p>	

										<p class="title">Note on the Borrower</p>

										<p><b>Borrower : </b><label id="iborrower"><?php echo $post['borrower'];?></label></p>
										<p><b>DKC Repeat Borrower : </b><label id="rborrower"><?php echo $post['dkcborrower'];?></label></p>
										<p><b>Borrower Background : </b> <label id="borrowerbg"><?php echo $post['borrowerbg'];?> </label></p>
										
										<p class="title">Additional Documents</p>

											<pre id="adocument"><?php echo $post['additional'];?></pre>
										

									</div>

								</section>
								<center>
										<button class="togglebtn" onclick=minmax('<?php echo "prev-hold".$post["pid"];?>','<?php echo "prev-main".$post["pid"];?>')><i class="fa-solid fa-up-down"></i></button>
								</center>
						</div>
						
				<?php
					}
				?>
				</center>
			
			</section>
	
			<br>
			<?php include "../global/footer.php";?>
	</div>

</body>
</html>