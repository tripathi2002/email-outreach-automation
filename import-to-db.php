<?php

require 'db.php';

$jsonFile = 'emails.json';

if (!file_exists($jsonFile)) {
    die("JSON file not found");
}

$data = json_decode(file_get_contents($jsonFile), true);

if (!$data) {
    die("Invalid JSON data");
}

$inserted = 0;

foreach ($data as $row) {

    // Skip if email empty
    if (empty($row['email'])) continue;

    // Check duplicate
    $stmt = $pdo->prepare("SELECT id FROM emails WHERE email = ?");
    $stmt->execute([$row['email']]);

    if ($stmt->fetch()) {

        continue; // already exists
    }

    // Insert
    $stmt = $pdo->prepare("
        INSERT INTO hr_emails 
        (name, email, company, title, status, subject, message_id, sent_date, followup_sent)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->execute([
        $row['name'] ?? '',
        $row['email'],
        $row['company'] ?? '',
        $row['title'] ?? '',
        $row['status'] ?? 'pending',
        $row['subject'] ?? '',
        $row['message_id'] ?? '',
        !empty($row['sent_date']) ? $row['sent_date'] : null,
        $row['followup_sent'] ?? 0
    ]);

    $inserted++;
}

echo "Inserted {$inserted} records into DB";