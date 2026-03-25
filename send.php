<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/PHPMailer/src/Exception.php';
require 'mailer/PHPMailer/src/PHPMailer.php';
require 'mailer/PHPMailer/src/SMTP.php';

$config = require 'config.php';

$mail = new PHPMailer(true);

try {
    $mail->isSMTP();
    $mail->Host       = $config['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['smtp_user'];
    $mail->Password   = $config['smtp_pass'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = $config['smtp_port'];

    $mail->setFrom($config['from_email'], $config['from_name']);
    $mail->addAddress('amitri2030@gmail.com', 'Test User');

    $mail->Subject = 'Application for Node.js Developer';

    $mail->Body = "Hi,\n\nI am Vibhu, a Node.js developer...\n\nRegards,\nVibhu";

    // $mail->send();

    // capture message ID (IMPORTANT for follow-up)
    // $messageId = $mail->getLastMessageID();

    echo "Sent! Message ID: " . $messageId;
    echo "Sent! Message ID: ...";

} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}