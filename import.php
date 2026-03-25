<?php

$csvFile = 'data/contacts.csv';

// Load existing data
$jsonFile = 'emails.json';
// $existingData = [];

// if (file_exists($jsonFile)) {
//     $existingData = json_decode(file_get_contents($jsonFile), true) ?? [];
// }

// // Create email lookup (to avoid duplicates)
// $existingEmails = array_column($existingData, 'email');

$rows = array_map('str_getcsv', file($csvFile));
$header = array_map('trim', array_shift($rows));

// $newCount = 0;

$data = [];

// echo "<pre>";
// print_r($rows);
// exit;

foreach ($rows as $row) {

    // Skip empty rows
    if (empty(array_filter($row)))
        continue;

    $row = array_map('trim', $row);

    // Fix column mismatch
    if (count($row) !== count($header))
        continue;

    $item = array_combine($header, $row);

    $data[] = [
        "name" => $item['Name'] ?? '',
        "email" => $item['Email'] ?? '',
        "company" => $item['Company'] ?? '',
        "title" => $item['Title'] ?? '',
        "status" => "pending",
        "subject" => "",
        "message_id" => "",
        "sent_date" => "",
        "followup_sent" => false
    ];
}

file_put_contents($jsonFile, json_encode($data, JSON_PRETTY_PRINT));

echo "Imported " . count($data) . " contacts successfully!";