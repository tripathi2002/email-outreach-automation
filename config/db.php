<?php
/**
 * Database connection.
 * Credentials come from environment variables (DB_HOST, DB_NAME, DB_USER, DB_PASS)
 * or from config/db.local.php (gitignored; copy from config/db.example.php).
 */
$dbConfig = [
    'host'     => getenv('DB_HOST') ?: 'localhost',
    'dbname'   => getenv('DB_NAME') ?: '',
    'username' => getenv('DB_USER') ?: 'root',
    'password' => getenv('DB_PASS') ?: '',
];

$localConfig = __DIR__ . '/db.local.php';
if (file_exists($localConfig)) {
    $dbConfig = array_merge($dbConfig, require $localConfig);
}

try {
    $pdo = new PDO(
        "mysql:host={$dbConfig['host']};dbname={$dbConfig['dbname']};charset=utf8mb4",
        $dbConfig['username'],
        $dbConfig['password']
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    error_log('DB Connection failed: ' . $e->getMessage());
    die('DB Connection failed.');
}
