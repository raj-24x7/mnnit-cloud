<?php
	$to = "241096raj@gmail.com";
	$subject = "My subject";
	$txt = "Hello world!";
	$from = 'guptapankaj5872@gmail.com';
	$header = 'From:'.$from;

	if (mail($to,$subject,$txt,$header))
		echo "Mail Sent";
	else
		echo "Error";

	
// // The message
// $message = "Line 1\r\nLine 2\r\nLine 3";

// // In case any of our lines are larger than 70 characters, we should use wordwrap()
// $message = wordwrap($message, 70, "\r\n");

// // Send
// if(mail('chawla.roby@gmail.com', 'My Subject', $message)){
// 	echo "f*****k";
// }
// else{
// 			echo "kuch panga hai";
// 		}




?>