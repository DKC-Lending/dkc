<?php
include_once('i_conn.php');
include_once('u_conn.php');
include_once('../backend/usercontrol.php');
include('../library/smtp/PHPMailerAutoload.php');
include '../backend/message/email.php';


$user= $_GET["user"];
$offer = $_GET["offer"];
$pid = $_GET["pid"];
$link = $_GET["link"];

		$detail = $Users->get_details_from_username($conn,$user);
		$sql = "INSERT INTO p$pid (username,offer) VALUES ('$user', '$offer')";
				mysqli_query($iconn,$sql);
		$ioff = $offer==0?"50%":($offer==1?"75%":"99%");
		
		$phone = $detail['phone'];
		$email = $detail['email'];
		$html = "<p>Hi David,<br>".
		"$user is interested in investing opportunity.".
		"<br></p>".
		"Here are the details: ".
		"".
		"<br>".
		"<b>Interested in $ioff of :</b> <a href='$link'>$link</a>".
		"<br>".
		"<b>Username :</b> $user".
		"<br>".
		"<b>Contact :</b> $phone".
		"<br>".
		"<b>Email :</b> $email".
		"<br>".
		"<p>Thank You!</p>";
		send_email('webmaster@dkclending.com',$html,"$user is intrested in Investment Opportunity");
	if($sql){
		echo json_encode(1);
		return true;
	}else{
		echo json_encode(0);
		return false;
	}

?>