<?php try { ?>
	<?php include_once('../backend/adminsession.php'); ?>
	<?php
	include '../backend/config/conifg.php';
	include '../backend/post/postControl.php';
	$web = $config->fetch();
	$pid = $_GET["pid"];
	$data = $posts->get_posts_from_pid($i_conn, $pid);

	?>
	<!DOCTYPE html>
	<html lang="en">

	<head>
		<title>Admin Edit Post | <?php echo $web["name"]; ?></title>

	</head>
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../css/admin/editpost.css">

	<body>
		<center>
			<div class="main-body">
				<h3>Edit Investment Opportunity</h3>
				<br>
				<form action="../backend/post/update_post.php" method="POST" enctype="multipart/form-data">
					<input type="hidden" name="pid" value="<?php echo $data['pid']; ?>">
					<div>
						<input type="text" name="title" class="input" placeholder="Enter Post Title" value="<?php echo $data["ptitle"]; ?>" required="true">
					</div>


					<div>
						<input type="text" name="fileurl" class="input" placeholder="Enter File URL" value="<?php echo $data["furl"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="collateral" class="input" placeholder="Enter Investment Collateral" value="<?php echo $data["icollateral"]; ?>" required="true">
					</div>
					<div>
						<input type="text" name="borrower" class="input" placeholder="Enter Investment Borrower" value="<?php echo $data["iborrower"]; ?>" required="true">
					</div>

					<div>
						<textarea name="brief" placeholder="Enter Investment Brief Paragraph (Limit 2000 char)" required="true"><?php echo $data["ibrief"]; ?></textarea>
					</div>

					<p class="sub-title">Loan Details</p>

					<div>
						<input type="text" name="asset" class="input" placeholder="Enter Asset Value" value="<?php echo $data["assetvalue"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="loan" class="input" placeholder="Enter Loan Amount" value="<?php echo $data["loanmaount"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="loantovalue" class="input" placeholder="Enter Loan to Value" value="<?php echo $data["loantovalue"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="term" class="input" placeholder="Enter Loan Term" value="<?php echo $data["term"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="type" class="input" placeholder="Enter Loan Type" value="<?php echo $data["type"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="penalty" class="input" placeholder="Enter Investment Permanent Penalty" value="<?php echo $data["ppenalty"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="interestoffer" class="input" placeholder="Enter Investment Monthly Intrested Offered to Participant" value="<?php echo $data["monthlyp"]; ?>" required="true">
					</div>

					<p class="sub-title">Participation Opportunities</p>

					<div>
						<input type="text" name="99p" class="input" placeholder="99%" value="<?php echo $data["99p"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="75p" class="input" placeholder="75%" value="<?php echo $data["75p"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="50p" class="input" placeholder="50%" value="<?php echo $data["50p"]; ?>" required="true">
					</div>

					<p class="sub-title">Notes on the Borrower</p>

					<div>
						<input type="text" name="iborrower" class="input" placeholder="Enter Investment Borrower" value="<?php echo $data["borrower"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="rborrower" class="input" placeholder="Enter DKC Repeat Borrower" value="<?php echo $data["dkcborrower"]; ?>" required="true">
					</div>

					<div>
						<input type="text" name="borrowerbg" class="input" placeholder="Enter Investment Borrower Background" value="<?php echo $data["borrowerbg"]; ?>" required="true">
					</div>

					<p class="sub-title">Additional Documents</p>

					<div>
						<textarea name="adocument" placeholder="Enter Investment Additional Documents" required="true"><?php echo $data["additional"]; ?></textarea>
					</div>


					<br>
					<div style="background:transparent;border:none;padding:0;">
						<button class="solid-btn" name="post">Update Investment</button>
					</div>
				</form>
			</div>
		</center>
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