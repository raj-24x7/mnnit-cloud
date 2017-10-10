<?php 
require_once "vendor/autoload.php";

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
	$mail->Username = "";                 
	$mail->Password = "";                           
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
	    //echo "Mailer Error: " . $mail->ErrorInfo;
	} 
	else 
	{
	   // echo "Message has been sent successfully";
	}

}
?>