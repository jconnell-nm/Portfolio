<?php

require_once __DIR__ . '/config.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

require_once __DIR__ . '/../vendor/autoload.php';

function createMailer(): PHPMailer {
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->Host = 'live.smtp.mailtrap.io';
    $mail->SMTPAuth = true;
    $mail->Username = 'api';
    $mail->Password = 'ee15111a7d647b6d99010d56bd92d2c5';
    $mail->Port = (int) 587;
    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;

    $mail->setFrom('contact@jonathan-connell.netmatters-scs.co.uk', 'Jonathan Connell');
    $mail->addAddress('jonathanconnell321@gmail.com');

    $mail->isHTML(TRUE);

    return $mail;
}