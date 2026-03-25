<?php 
function logEmail($pdo, $emailId, $email, $status, $subject, $messageId = null, $error = null) {

    $stmt = $pdo->prepare("
        INSERT INTO hr_email_logs (email_id, email, status, subject, message_id, error)
        VALUES (?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $emailId,
        $email,
        $status,
        $subject,
        $messageId,
        $error
    ]);
}