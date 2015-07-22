<?php 
require_once 'vendor/autoload.php';
require("libs/PHPMailer/class.phpmailer.php");


$m = new PHPMailer;

$m->isSMTP();
$m->SMTPAuth = true;
$m->SMTPDebug = 2;

$m->Host = 'smtp.gmail.com';
$m->Username = "convoportal@gmail.com";
$m->Password = "ConvoPortal#1!";
$m->SMTPSecure = 'ssl';
$m->Port = 465;

$m->From ='jja4740@rit.edu';
$m->FromName = 'Joshua Aziz';
$m->addAddress('jja4740@rit.edu', 'Joshua Aziz');
$m->AddAttachment('files/DriverLicense.jpg', 'DriverLicesnse.jpg');
$m->AddAttachment('files/ssn.jpg', 'ssn.jpg');

$m->Subject = 'Here is an email';
$m->Body = 'This is the body of an email!';
$m->AltBody = 'This is the body of an email!';

var_dump($m->send());

