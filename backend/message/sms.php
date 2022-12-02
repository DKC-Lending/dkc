<?php

use Twilio\Rest\Client;

function send_sms($num,$msg){
	$sid = "ACc223629e4fb6d694a6c9242283f2d8c6"; // Your Account SID from www.twilio.com/user/account
	$token = "5876bdad3e0df1c3e4645a8ec30a50d9"; // Your Auth Token from www.twilio.com/user/account
	$twilio_number = '+14243756793';
	$client = new Client($sid,$token);
    $msg = str_replace("-", "", $msg);
	$msg = str_replace("(", "", $msg);
	$msg = str_replace(")", "", $msg);
	$msg = str_replace(" ", "", $msg);
	$client->messages->create(
		$num,  
		[
			'from' => $twilio_number,
			'body' => $msg
		] 
	);

}

if(isset($_POST['phone'])){
	
	require_once '../../library/twilio-php-main/src/Twilio/autoload.php';
	$to = $_POST['phone'];
	$html = $_POST['body'];
	send_sms($to,$html);
}

?>
