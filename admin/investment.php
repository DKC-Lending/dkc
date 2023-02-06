<?php try { ?>
	<?php include_once('../backend/adminsession.php'); ?>
	<?php
	include '../backend/config/conifg.php';
	$web = $config->fetch();
	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<meta charset="utf-8">
		<title>Admin Investment Opportunity | <?php echo $web["name"]; ?></title>
	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<?php include "../global/links.html"; ?>
	<link rel="stylesheet" type="text/css" href="../css/global.css">
	<link rel="stylesheet" type="text/css" href="../css/header.css">
	<link rel="stylesheet" type="text/css" href="../css/nav.css">
	<link rel="stylesheet" type="text/css" href="../css/buttons.css">
	<link rel="stylesheet" type="text/css" href="../css/footer.css">
	<link rel="stylesheet" type="text/css" href="../css/admin/investment.css">
	<link rel="stylesheet" type="text/css" href="../css/investpost.css">
	<link rel="stylesheet" type="text/css" href="../css/topheader.css">
	<link rel="stylesheet" type="text/css" href="../css/alert.css">
	<?php include '../global/alert.html'; ?>
	<script type="text/javascript" src="../js/changeimg.js"></script>
	<script type="text/javascript" src="../js/alert.js"></script>
	<script type="text/javascript" src="../js/investment.js"></script>

	<body>
		<?php include "../global/adminnav.php" ?>
		<?php include "../global/adminheader.php" ?>
		<?php include '../backend/post/postControl.php'; ?>

		<div class="content">
			<div class="main-container">
				<div class="top-head-txt">
					<div>
						<p>
							Investment Opportunity<br>
							<lable class="sub-heading">Add new Investment Opportunity from here</lable>
						</p>
					</div>
					<div class="toggle">
						<button class="edit" onclick="changepage(this,'edit')"><i class="fa-solid fa-pencil"></i></button>
						<button class="preview" onclick="changepage(this,'preview')"><i class="fa-solid fa-image"></i></button>
					</div>
				</div>
			</div>

			<div class="body-holder" id="invest-editor">
				<div class="input-holder">
					<section>
						<form action="../backend/post/add_post.php" method="POST" enctype="multipart/form-data">
							<div>
								<input type="text" name="title" class="input" placeholder="Enter Post Title" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="file" name="thumbnail" accept="image/*" class="input-file" onchange="changeimg(event,'pthumbnail')" placeholder="Select Investment Thumbnail" required="true">
							</div>

							<div>
								<input type="text" name="fileurl" class="input" placeholder="Enter File URL" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="collateral" class="input" placeholder="Enter Investment Collateral" onchange="updatetxtlive(this)" required="true">
							</div>
							<div>
								<input type="text" name="borrower" class="input" placeholder="Enter Investment Borrower" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<textarea name="brief" placeholder="Enter Investment Brief Paragraph (Limit 2000 char)" onchange="updatetxtlive(this)" required="true"></textarea>
							</div>

							<p class="sub-title">Loan Details</p>

							<div>
								<input type="text" name="asset" class="input" placeholder="Enter Asset Value" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="loan" class="input" placeholder="Enter Loan Amount" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="loantovalue" class="input" placeholder="Enter Loan to Value" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="term" class="input" placeholder="Enter Loan Term" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="type" class="input" placeholder="Enter Loan Type" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="penalty" class="input" placeholder="Enter Investment Permanent Penalty" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="interestoffer" class="input" placeholder="Enter Investment Monthly Intrested Offered to Participant" onchange="updatetxtlive(this)" required="true">
							</div>

							<p class="sub-title">Participation Opportunities</p>

							<div>
								<input type="text" name="99p" class="input" placeholder="99%" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="75p" class="input" placeholder="75%" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="50p" class="input" placeholder="50%" onchange="updatetxtlive(this)" required="true">
							</div>

							<p class="sub-title">Notes on the Borrower</p>

							<div>
								<input type="text" name="iborrower" class="input" placeholder="Enter Investment Borrower" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="rborrower" class="input" placeholder="Enter DKC Repeat Borrower" onchange="updatetxtlive(this)" required="true">
							</div>

							<div>
								<input type="text" name="borrowerbg" class="input" placeholder="Enter Investment Borrower Background" onchange="updatetxtlive(this)" required="true">
							</div>

							<p class="sub-title">Additional Documents</p>

							<div>
								<textarea name="adocument" placeholder="Enter Investment Additional Documents" onchange="updatetxtlive(this)" required="true"></textarea>
							</div>
							<p class="title">Alert</p>
							<section class="alert-section">
								<label class="container">SMS
									<input type="checkbox" name="sms-box">
									<span class="checkmark"></span>
								</label>
								<label class="container">EMAIL
									<input type="checkbox" name="email-box">
									<span class="checkmark"></span>
								</label>
							</section>

							<br>
							<div style="background:transparent;border:none;padding:0;">
								<button class="solid-btn" name="post">Post Investment</button>
							</div>
						</form>
					</section>
				</div>

				<div class="preview-holder" id="prev-hold">
					<section id="prev-main">
						<div class="img-holder">
							<img src="../img/misc/temp.jpg" id="pthumbnail" alt="image">
							<a id="fileurl" href="" target="_blank"><button class="solid-btn">Read More</button></a>
						</div>

						<div class="txt-holder">
							<label class="htitle" id="title">xxxxxxx xxxxxxxx xxxxxxx</label>
							<br>
							<br>
							<p><b>Collateral: </b><label id="collateral">xxxxxxx xxxxxxxx xxxxxxx</label></p>
							<p><b>Borrower : </b><label id="borrower">xxxxxxx xxxxxxxx</label></p>
							<p><b>Brief Paragraph : </b><label id="brief">xxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxx</label></p>

							<p class="title">Loan Details</p>

							<p><b>Asset Value : </b><label id="asset">$xxxx</label></p>
							<p><b>Loan Amount : </b><label id="loan">$xxxxx</label></p>
							<p><b>Loan to Value : </b><label id="loantovalue">xx%</label></p>
							<p><b>Term : </b><label id="term">x Year</label></p>
							<p><b>Type : </b><label id="type">Fix and Flip</label></p>
							<p><b>Permanent Penalty : </b><label id="penalty">xxxx</label></p>
							<p><b>Monthly Interested Offered to Participant : </b><label id="interestoffer">xx%</label></p>

							<p class="title">Participation Opportunities</p>

							<p><b>99% : </b><label id="99p">$xxxxxx</label></p>
							<p><b>75% : </b><label id="75p">$xxxxx</label></p>
							<p><b>50% : </b><label id="50p">$xxxx</label></p>

							<p class="title">Note on the Borrower</p>

							<p><b>Borrower : </b><label id="iborrower">xxx</label></p>
							<p><b>DKC Repeat Borrower : </b><label id="rborrower">xx</label></p>
							<p><b>Borrower Background : </b> <label id="borrowerbg">xxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxxxxxxxxx xxxxxxxx xxxxxxx</label></p>

							<p class="title">Additional Documents</p>

							<pre id="adocument">-xxx <br>-xxx <br>-xxx</pre>
						</div>

					</section>
					<center>
						<button class="togglebtn" onclick="minmax('prev-hold','prev-main')"><i class="fa-solid fa-up-down"></i></button>
					</center>
				</div>
			</div>

			<div class="body-preview" id="invest-viewor">

				<?php
				$datas = $posts->get_posts($i_conn);
				foreach ($datas as $post) {

				?>
					<div class="preview-holder" id="<?php echo "prev-hold" . $post['pid']; ?>">
						<a class="edit-btn" href="editpost.php?pid=<?php echo $post['pid']; ?>"><i class="fa-solid fa-pen-to-square"></i></a>
						<button class="sold-btn" id="<?php echo $post['pid']; ?>" onclick="soldPost(this)"><i class="fa-solid fa-stamp"></i></button>
						<button class="trash-btn" id="<?php echo $post['pid']; ?>" onclick="deletePost(this)"><i class="fa-solid fa-trash"></i></button>
						<div id="<?php echo "holder-" . $post['pid']; ?>"> <?php if ($post["status"] == "0") { ?><div class="sold-watermark" id="<?php echo "watermark-" . $post['pid']; ?>"></div><?php } ?></div>

						<section id="<?php echo "prev-main" . $post['pid']; ?>">
							<div class="img-holder">
								<img src="<?php echo "../img/posts/" . $post["thumbnail"]; ?>" id="thumbnail" alt="image">
								<a id="fileurl" href="<?php echo $post['furl']; ?>" target="_blank"><button class="solid-btn">Read More</button></a>
							</div>

							<div class="txt-holder">
								<label class="htitle" id="title"><?php echo $post['ptitle']; ?></label>
								<br>
								<br>
								<p><b>Collateral: </b><label id="collateral"><?php echo $post['icollateral']; ?></label></p>
								<p><b>Borrower : </b><label id="borrower"><?php echo $post['iborrower']; ?></label></p>
								<p><b>Brief Paragraph : </b><label id="brief"><?php echo $post['ibrief']; ?></label></p>

								<p class="title">Loan Details</p>

								<p><b>Asset Value : </b><label id="asset"><?php echo $post['assetvalue']; ?></label></p>
								<p><b>Loan Amount : </b><label id="loan"><?php echo $post['loanmaount']; ?></label></p>
								<p><b>Loan to Value : </b><label id="loantovalue"><?php echo $post['loantovalue']; ?></label></p>
								<p><b>Term : </b><label id="term"><?php echo $post['term']; ?></label></p>
								<p><b>Type : </b><label id="type"><?php echo $post['type']; ?></label></p>
								<p><b>Permanent Penalty : </b><label id="penalty"><?php echo $post['ppenalty']; ?></label></p>
								<p><b>Monthly Interested Offered to Participant : </b><label id="interestoffer"><?php echo $post['monthlyp']; ?></label></p>

								<p class="title">Participation Opportunities</p>

								<p><b>99% : </b><label id="99p"><?php echo $post['99p']; ?></label></p>
								<p><b>75% : </b><label id="75p"><?php echo $post['75p']; ?></label></p>
								<p><b>50% : </b><label id="50p"><?php echo $post['50p']; ?></label></p>

								<p class="title">Note on the Borrower</p>

								<p><b>Borrower : </b><label id="iborrower"><?php echo $post['borrower']; ?></label></p>
								<p><b>DKC Repeat Borrower : </b><label id="rborrower"><?php echo $post['dkcborrower']; ?></label></p>
								<p><b>Borrower Background : </b> <label id="borrowerbg"><?php echo $post['borrowerbg']; ?> </label></p>

								<p class="title">Additional Documents</p>

								<pre id="adocument"><?php echo $post['additional']; ?></pre>
							</div>

						</section>
						<center>
							<button class="togglebtn" onclick=minmax('<?php echo "prev-hold" . $post["pid"]; ?>','<?php echo "prev-main" . $post["pid"]; ?>')><i class="fa-solid fa-up-down"></i></button>
						</center>
					</div>
				<?php
				}
				?>
			</div>
			<br>

			<?php include '../global/footer.php'; ?>
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