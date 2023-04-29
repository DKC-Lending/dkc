<?php

include('../../library/smtp/PHPMailerAutoload.php');

function send_email($to,$html,$subject){
	$headers = 'From: webmaster@dkclending.com' . "\r\n" .
    'Reply-To: info@dkclending.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();
	$mail = new PHPMailer(); 
	
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "webmaster@dkclending.com";
	$mail->Password = "hyijkhjyaechjffz";
	$mail->SetFrom("info@dkclending.com");
	$mail->Subject = $subject;
	
	$mail->Body =$html;
	$mail->AddAddress($to);
	$mail->addCustomHeader('In-Reply-To', $headers);
	$mail->addCustomHeader('References',  $headers);
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

