<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'mailer/PHPMailer/src/Exception.php';
require 'mailer/PHPMailer/src/PHPMailer.php';
require 'mailer/PHPMailer/src/SMTP.php';

require 'config/db.php';
require 'templates/main-template.php';
require 'helpers/logger.php';

$email_credentials = require 'config/email.php';

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
    $mail->Host = $email_credentials['smtp_host'];
    $mail->SMTPAuth = true;
    $mail->Username = $email_credentials['smtp_user'];
    $mail->Password = $email_credentials['smtp_pass'];
    $mail->SMTPSecure = 'tls';
    $mail->Port = $email_credentials['smtp_port'];

    // Email setup
    $mail->setFrom($email_credentials['from_email'], $email_credentials['from_name']);
    $mail->addAddress($user['email'], $user['name']);

    $subject = getSubject($user);
    $mail->Subject = $subject;
    // Personalization

    $mail->Body = buildEmail($user);

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

    $pdo->prepare("UPDATE hr_emails SET attempt_count = attempt_count + 1, status = 'fail' WHERE id = ?")
        ->execute([$user['id']]);

    echo "Error: {$mail->ErrorInfo}";
}