<?php
    require 'assets/php/class.phpmailer.php';
    require 'assets/php/autoload.php';
    require 'assets/php/class.smtp.php';

    $mail = new PHPMailer;
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPDebug = 2;

    $mail->Host = "localhost";
    $mail->Username = "smtpmailer";
    $mail->Password = '$endEma1l';
    $mail->SMTPSecure = "ssl";
    $mail->Port = 25;

    $mail->From = "pxy9548@rit.edu";
    $mail->FromName = "Peter Yeung";
    $mail->addReplyTo("pxy9548@rit.edu", "Reply Address");
    $mail->addAddress("pxy9548@gmail.com", "Peter Yeung");

    $mail->Subject = "Here is an email!";
    $mail->Body = "HELLO WORLD.  This is the body of an email";
    $mail->AltBody = "HELLO WORLD";

    var_dump($mail->send()); 
?>