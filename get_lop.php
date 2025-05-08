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

    // Fetch lớp data with chidoan information
    $sql = "SELECT l.id, l.ten_lop, c.id as chidoan_id, c.ten_chidoan 
            FROM lop l 
            LEFT JOIN chidoan c ON l.chidoan_id = c.id 
            ORDER BY c.id ASC, l.id ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $lop = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode($lop, JSON_UNESCAPED_UNICODE);

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