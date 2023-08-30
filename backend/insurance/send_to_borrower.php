<?php
include('../../library/smtp/PHPMailerAutoload.php');

function folder_exist($folder)
{
    // Get canonicalized absolute pathname
    $path = realpath($folder);

    // If it exist, check if it's a directory
    return ($path !== false AND is_dir($path)) ? $path : false;
}

$to 			= $_POST['email'];
$subject 		= $_POST['subject'];
$uid 			= $_POST['uid'];
$html 			= "Invoice of this month.";
$pdfdoc         = $_POST['fileDataURI'];

$decoded_pdf    = substr($pdfdoc, strlen('data:application/pdf;filename=generated.pdf;base64,'));


$mail = new PHPMailer();
$mail->IsSMTP(); 
$mail->SMTPAuth = true; 
$mail->SMTPSecure = 'tls'; 
$mail->Host = "smtp.gmail.com";
$mail->Port = 587; 
$mail->Username = "mason@dkclending.com";
$mail->Password = "eahhkqbwpbcvoisn";
$mail->SetFrom("mason@dkclending.com");
$mail->AddAddress($to);
$mail->Subject  = $subject;
$mail->Body     = $html;
$mail->addStringAttachment(base64_decode($decoded_pdf), "invoices.pdf");
$mail->isHTML( true );


	if(!$mail->Send()){
		echo 'false';
	}else{
		if (folder_exist("../../pdf/$uid")){
			$pdf = fopen ("../../pdf/$uid/".date("d.m.Y..h.i.s").'.pdf','w');
			fwrite ($pdf,base64_decode($decoded_pdf));
		}else{
			mkdir("../../pdf/$uid");
			$pdf = fopen ("../../pdf/$uid/".date("d.m.Y..h.i.s").'.pdf','w');
			fwrite ($pdf,base64_decode($decoded_pdf));
		}
	
		echo 'true';
	}



?>