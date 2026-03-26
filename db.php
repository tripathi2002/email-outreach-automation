<?php

// $host = "82.25.121.84";
// $dbname = "u935874385_server";
// $username = "u935874385_vibhu";
// $password = "0uw2;RX/";

$host = "localhost";
$dbname = "vibhu-portfolio-sql";
$username = "root";
$password = "";

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8mb4", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("DB Connection failed: " . $e->getMessage());
}