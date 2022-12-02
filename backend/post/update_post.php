<?php
include 'investment_connect.php';
include '../usercontrol.php';

error_reporting(1);

if(isset($_POST['post']))
{

	$pid = $_POST['pid'];
	$title = $_POST['title'];
	
	$url = $_POST['fileurl'];
	$collateral = $_POST['collateral'];
	$borrower = $_POST['borrower'];
	$brief = $_POST['brief'];
	$asset = $_POST['asset'];
	$loan = $_POST['loan'];
	$loantovalue = $_POST['loantovalue'];
	$term = $_POST['term'];
	$type = $_POST['type'];
	$penalty = $_POST['penalty'];
	$interestoffer = $_POST['interestoffer'];
	$p9 = $_POST['99p'];
	$p7 = $_POST['75p'];
	$p5 = $_POST['50p'];
	$iborrower = $_POST['iborrower'];
	$rborrower = $_POST['rborrower'];
	$borrowerbg = $_POST['borrowerbg'];
	$adocument = $_POST['adocument'];

	
	$sql = "UPDATE posts SET ptitle='$title', furl='$url', icollateral='$collateral', iborrower='$borrower', ibrief='$brief', assetvalue='$asset', loanmaount='$loan', loantovalue='$loantovalue',	term='$term', type='$type', ppenalty='$penalty', monthlyp='$interestoffer',	99p='$p9', 75p='$p7', 50p='$p5', borrower='$iborrower', dkcborrower='$rborrower', borrowerbg='$borrowerbg', additional='$adocument' WHERE pid = '$pid'";
	if(mysqli_query($i_conn, $sql)){
	
		header("Location: ../../admin/investment.php");
		die();
	
				}else{
					echo "error";
				}
			
			
		}
		
	

?>