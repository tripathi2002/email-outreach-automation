<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/PHPMailer/src/Exception.php';
require 'mailer/PHPMailer/src/PHPMailer.php';
require 'mailer/PHPMailer/src/SMTP.php';

require 'db.php';
require 'templates/emailTemplates.php';
require 'helpers/logger.php';

$config = require 'config.php';

// 🔹 Step 1: Get 1 pending email
$stmt = $pdo->prepare("SELECT * FROM hr_emails WHERE status = 'pending' LIMIT 1");
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("No pending emails");
}

$mail = new PHPMailer(true);


try {
    // SMTP setup
    $mail->isSMTP();
    $mail->Host = $config['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $config['smtp_user'];
    $mail->Password = $config['smtp_pass'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = $config['smtp_port'];

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
    $mail->Body = getEmailTemplate($user, $user['role'] || 'Full-Stack Developer');

    // 📎 Attach resume
    if (file_exists(__DIR__ . '/assets/Full-Stack_Developer_Vibhu_Tripathi.pdf')) {
        $mail->addAttachment(__DIR__ . '/assets/Full-Stack_Developer_Vibhu_Tripathi.pdf', 'Full-Stack_Developer_Vibhu_Tripathi.pdf');
    }

    
    $mail->send();

    $stmt = $pdo->prepare("
        UPDATE hr_emails 
        SET status = 'sent', subject = ?, message_id = ?, sent_date = NOW()
        WHERE id = ?
    ");


    $stmt->execute([
        $subject,
        $mail->getLastMessageID(),
        $user['id']
    ]);


    $messageId = $mail->getLastMessageID();

    // $response = json_encode([
    //     'message_id' => $messageId,
    //     'to' => $user['email'],
    //     'subject' => $subject,
    //     'timestamp' => date('Y-m-d H:i:s')
    // ]);

    logEmail(
        $pdo,
        $user['id'],
        $user['email'],
        'success',
        $subject,
        $messageId,
        null
    );
    $pdo->prepare("UPDATE hr_emails SET attempt_count = attempt_count + 1 WHERE id = ?")
        ->execute([$user['id']]);

    // // Save data
    // $data[$index]['status'] = 'sent';
    // $data[$index]['sent_date'] = date('Y-m-d H:i:s');
    // $data[$index]['message_id'] = $mail->getLastMessageID();
    // // SAVE subject
    // $data[$index]['subject'] = $subject;

    // file_put_contents($file, json_encode($data, JSON_PRETTY_PRINT));

    // echo "Sent to: " . $user['email'];
    echo "Sent to: " . $user['email'];


} catch (Exception $e) {

    logEmail(
        $pdo,
        $user['id'],
        $user['email'],
        'failed',
        $subject ?? 'UNKNOWN',
        null,
        $e
    );

    $pdo->prepare("UPDATE hr_emails SET attempt_count = attempt_count + 1 WHERE id = ?")
        ->execute([$user['id']]);

    echo "Error: {$mail->ErrorInfo}";
}