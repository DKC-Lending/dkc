<?php
include 'investment_connect.php';
include '../usercontrol.php';



if(isset($_POST['post']))
{
	//handaling thumbnail path and unique name
	$path = '../../img/posts/';
	$banner= $_FILES['thumbnail']['name']; 
	$expbanner= explode('.',$banner);
	$bannerexptype= $expbanner[1];
	$date = date('m/d/Yh:i:sa', time());
	$rand=rand(10000,99999);
	$encname= $date.$rand;
	$bannername= md5($encname).'.'.$bannerexptype;
	$bannerpath= $path.$bannername;
	$fname = $_FILES["thumbnail"]["tmp_name"];


	$title = $_POST['title'];
	$img = $bannername;
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
	$pdate = (string)date("d/m/Y");
	$sms = $_POST['sms-box'] ?? 'off';
	$email = $_POST["email-box"] ?? 'off';
	echo $sms." ".$email;
	$sql = "INSERT INTO posts(ptitle, thumbnail, furl, icollateral,	iborrower, ibrief, assetvalue, loanmaount, loantovalue,	term, type, ppenalty, monthlyp,	99p, 75p, 50p, borrower, dkcborrower, borrowerbg, additional, pdate, status) VALUES ('$title','$img','$url', '$collateral',' $borrower', '$brief', '$asset', '$loan', '$loantovalue', '$term', '$type', '$penalty', '$interestoffer', '$p9', '$p7', '$p5', '$iborrower','$rborrower','$borrowerbg', '$adocument','$pdate','1')";
	if(mysqli_query($i_conn, $sql)){
		move_uploaded_file($fname, $bannerpath); //upload image
		$last_id = mysqli_insert_id($i_conn);
		$table_sql = "CREATE TABLE p$last_id (".
			"id INT(6) UNSIGNED AUTO_INCREMENT PRIMARY KEY,".
			"username VARCHAR(500),".
			"offer int(10))";
		$i_conn->query($table_sql);
		
		$datas = $Users->get_phone_email($conn);
		foreach($datas as $data){
			try{
				if ($data["nphone"]==1){
					if ($sms == "on"){
						require_once '../../library/twilio-php-main/src/Twilio/autoload.php';
						include '../message/sms.php';
						$name = $data["fname"];
						$msg = "Hi $name ,\n
						DKC lending now has a new investment opportunity available for your review. \n
						Please log into your portal to review, and email david@dkclending.com for more details. \n
						\n
						Offer Link : $url \n
						\n
						Thank you! \n
						DKC lending team";
						
						send_sms($data["phone"],$msg);	
					}
				}
				if ($data["nemail"]==1){
					if ($email == "on"){
						include('../../library/smtp/PHPMailerAutoload.php');
						include '../message/email.php';
						$name = $data["fname"];
						$html="<p>Hi $name,<br>".
        "DKC lending now has a <b>new investment opportunity</b> available for your review.<br>".
        "Please <a href='https://portal.dkclending.com'><b>signin</b></a> into your portal to review, and email <b>david@dkclending.com</b> for more details.".
        "".
        "<br>".
        "Offer Link : $url</p>".
        "<br>".
        "<p>Thank you!</p>".
        "<p>DKC lending team</p>";
						send_email($data["email"],$html,'New Investment Opportunity');
					}
				}
			}catch (Exception $e){
				echo $e;
			}
			
		}
		header("Location: ../../admin/investment.php");
		die();
	}
}else{
	header("Location: ../../index.php");
		die();
}
?>