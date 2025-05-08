<?php
header('Content-Type: application/json');
error_reporting(E_ALL);
ini_set('display_errors', 1);

$host = 'localhost';
$dbname = 'quanlydoanvien';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch chidoan data
    $sql = "SELECT id, ten_chidoan FROM chidoan ORDER BY id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $chidoan = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode($chidoan, JSON_UNESCAPED_UNICODE);

} catch(PDOException $e) {
    // Return error message if something goes wrong
    http_response_code(500);
    echo json_encode([
        'error' => $e->getMessage(),
        'sql' => $sql ?? null,
        'trace' => $e->getTraceAsString()
    ], JSON_UNESCAPED_UNICODE);
}
?> 