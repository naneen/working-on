<?php

session_start();

$people = $_SESSION["people"];
$senderId = $_SESSION['ez_wko_id'];
$receiverId = $_POST["id"];

for($i=0; $i < count($people); $i++)
{
  if ($senderId == $people[$i]["id"])
  {
  	$nameFrom = $people[$i]["firstname"];
  	$emailFrom = $people[$i]["email"];
  }

  if ($receiverId == $people[$i]["id"])
  {
  	$nameTo = $people[$i]["firstname"];
  	$emailTo = $people[$i]["email"];
  } 
}

//echo $people[0]['email'];

/**
 * This example shows settings to use when sending via Google's Gmail servers.
 */
//SMTP needs accurate times, and the PHP time zone MUST be set
//This should be done in your php.ini, but this is how to do it if you don't have access to that
date_default_timezone_set('Etc/UTC');
require './PHPMailerAutoload.php';

//Create a new PHPMailer instance
$mail = new PHPMailer;
//Tell PHPMailer to use SMTP
$mail->isSMTP();
//Enable SMTP debugging
// 0 = off (for production use)
// 1 = client messages
// 2 = client and server messages
$mail->SMTPDebug = 0;
//Ask for HTML-friendly debug output
//$mail->Debugoutput = 'html';
//Set the hostname of the mail server
$mail->Host = 'smtp.gmail.com';
// use
// $mail->Host = gethostbyname('smtp.gmail.com');
// if your network does not support SMTP over IPv6
//Set the SMTP port number - 587 for authenticated TLS, a.k.a. RFC4409 SMTP submission
$mail->Port = 587;
//Set the encryption system to use - ssl (deprecated) or tls
$mail->SMTPSecure = 'tls';
//Whether to use SMTP authentication
$mail->SMTPAuth = true;
//Username to use for SMTP authentication - use full email address for gmail
$mail->Username = "exzyworkingon@gmail.com";
//Password to use for SMTP authentication
$mail->Password = "w0rking0n";
//Set who the message is to be sent from
$mail->setFrom('exzyworkingon@gmail.com', 'Exzy Bot');
//Set an alternative reply-to address
//$mail->addReplyTo('replyto@example.com', 'First Last');
//Set who the message is to be sent to
$mail->addAddress($emailTo, $nameTo);
//Set the subject line
$mail->Subject = 'Do you forget to log in to Exzy Bot ?';
//Read an HTML message body from an external file, convert referenced images to embedded,
//convert HTML into a basic plain-text alternative body
//$mail->msgHTML(file_get_contents('contents.html'), dirname(__FILE__));
//Replace the plain text body with one created manually
$mail->Body    = 'Hey '.$nameTo.',<br><br>You have been poked by <b>'.$nameFrom.'</b>!<br>Please log in to Exzy Bot at http://exzy.me/workingon<br><br>Hope to see you soon!<br>Bot';
//$mail->AltBody = 'You have been poked by Nenin' + ;
//Attach an image file
//$mail->addAttachment('images/phpmailer_mini.png');
$mail->isHTML(true); 

//send the message, check for errors
if (!$mail->send()) {
    echo "Mailer Error: " . $mail->ErrorInfo;
} else {
    echo "Message sent!";
}