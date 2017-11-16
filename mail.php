<?php 
require_once "vendor/autoload.php";
/*
function notifyByMail($to, $to_name, $subject, $msg) {
	$mail = new PHPMailer;

	//Enable SMTP debugging. 
	$mail->SMTPDebug = false;                               
	//Set PHPMailer to use SMTP.
	$mail->isSMTP();            
	//Set SMTP host name                          
	$mail->Host = "smtp.gmail.com";
	//Set this to true if SMTP host requires authentication to send email
	$mail->SMTPAuth = true;                          
	//Provide username and password     
	$mail->Username = "mnnitcloud@gmail.com";                 
	$mail->Password = "admin@mnnit";                           
	//If SMTP requires TLS encryption then set it
	$mail->SMTPSecure = "tls";                           
	//Set TCP port to connect to 
	$mail->Port = 587;                                   

	$mail->From = "";
	$mail->FromName = "";

	$mail->addAddress($to, $to_name);

	$mail->isHTML(true);

	$mail->Subject = $subject;
	$mail->Body = $msg;
	$mail->AltBody = "This is the plain text version of the email content";

	if(!$mail->send()) 
	{
	    echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	    echo "Message has been sent successfully";
	}

}

// testing 

notifyByMail("241096raj@gmail.com","Raj kumar","hello","hi how are you ?");
*/
function notifyByMail($to, $to_name, $subject, $msg) {
	$req = array(
			"REQUEST_TYPE"=>"mail",
			"REQUEST_DATA"=>array(
					"TO"=>$to,
					"TO_NAME"=>$to_name,
					"SUBJECT"=>$subject,
					"MESSAGE"=>$msg
				)
		);

		$jsondata = json_encode($req);
		requestServer($jsondata);
}

function requestServer($jsondata){
		/* Create a TCP/IP socket. */
		$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);
		if ($socket === false) {
		    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
		} else {
		    //echo "OK.\n";
		}

		$address = "127.0.0.1";
		$service_port = 1234;
		//echo "Attempting to connect to '$address' on port '$service_port'...";
		$result = socket_connect($socket, $address, $service_port);
		if ($result === false) {
		    echo "socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n";
		} else {
		    //echo "OK.\n";
		}
		socket_write($socket, $jsondata, strlen($jsondata));
}
?>