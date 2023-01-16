<?php

function send_email($to,$html,$subject){
	
	
	$mail = new PHPMailer(); 
	
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "webmaster@dkclending.com";
	$mail->Password = "woqqrxresxsomckh";
	$mail->SetFrom("webmaster@dkclending.com");
	$mail->Subject = $subject;
	$mail->Body =$html;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if($mail->Send()){
		echo "true";
	}else{
		echo "false";
	}
	
}
if(isset($_POST['email'])){
	
	include('../../library/smtp/PHPMailerAutoload.php');
	$to = $_POST['email'];
	$subject = $_POST['sub'];
	$html = $_POST['body'];
	send_email($to,$html,$subject);
}
?>

