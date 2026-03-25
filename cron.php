<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/PHPMailer/src/Exception.php';
require 'mailer/PHPMailer/src/PHPMailer.php';
require 'mailer/PHPMailer/src/SMTP.php';
require 'templates/emailTemplates.php';

$config = require 'config.php';

// Load email list
$file = 'emails.json';
$data = json_decode(file_get_contents($file), true);

if (!$data) {
    die("No data found");
}

// Find first pending email
$index = -1;
foreach ($data as $i => $row) {
    if ($row['status'] === 'pending') {
        $index = $i;
        break;
    }
}

if ($index === -1) {
    die("No pending emails");
}

$user = $data[$index];

$mail = new PHPMailer(true);

try {
    // SMTP setup
    $mail->isSMTP();
    $mail->Host       = $config['smtp_host'];
    $mail->SMTPAuth   = true;
    $mail->Username   = $config['smtp_user'];
    $mail->Password   = $config['smtp_pass'];
    $mail->SMTPSecure = 'tls';
    $mail->Port       = $config['smtp_port'];

    // Email setup
    $mail->setFrom($config['from_email'], $config['from_name']);
    $mail->addAddress($user['email'], $user['name']);

    // $mail->Subject = "Application for Node.js Developer";
    // $mail->Subject = getSubject($user, 'fullstack');
    
    $subject = getSubject($user, 'fullstack');
    $mail->Subject = $subject;
    // Personalization
    // $body = "Hi {$user['name']},\n\n";
    // $body .= "I hope you're doing well. I came across {$user['company']} and wanted to apply for Node.js Developer role.\n\n";
    // $body .= "I have experience in Node.js, Angular, and full-stack development.\n\n";
    // $body .= "Looking forward to your response.\n\nRegards,\nVibhu";

    // $mail->Body = $body;

    // $mail->Body = getEmailTemplate($user, 'fullstack');
    $mail->Body = getEmailTemplate($user, $user['role']);

    $mail->send();

    // Save data
    $data[$index]['status'] = 'sent';
    $data[$index]['sent_date'] = date('Y-m-d H:i:s');
    $data[$index]['message_id'] = $mail->getLastMessageID();
    // SAVE subject
    $data[$index]['subject'] = $subject;

    file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    echo "Sent to: " . $user['email'];

} catch (Exception $e) {
    echo "Error: {$mail->ErrorInfo}";
}