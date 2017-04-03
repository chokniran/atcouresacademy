<?php

	require_once('class.phpmailer.php');

	$mail = new PHPMailer();
	$mail->IsHTML(true);
	$mail->IsSMTP();
	$mail->SMTPAuth = true; // enable SMTP authentication
	$mail->SMTPSecure = "tls"; // sets the prefix to the servier
	$mail->Host = "email-smtp.us-east-1.amazonaws.com"; // sets GMAIL as the SMTP server
	$mail->Port = 587; // set the SMTP port for the GMAIL server
	$mail->Username = "AKIAJNKC4INNBC2ITLDQ"; // GMAIL username
	$mail->Password = "Ao8ZDCS/bzZYPN53kgVllkb2BBttWoekDW8SR6ZYOXwi"; // GMAIL password
	$mail->From = "support@thebiz-online.com"; // "name@yourdomain.com";
	//$mail->AddReplyTo = "support@thaicreate.com"; // Reply
	$mail->FromName = "thebiz online";  // set from Name
	$mail->Subject = "Test sending mail."; 
	$mail->Body = "My Body & <b>My Description</b>";

	$mail->AddAddress("chokniran@atcreative.co.th", "Peerapatfc"); // to Address
	$mail->Send(); 

?>
