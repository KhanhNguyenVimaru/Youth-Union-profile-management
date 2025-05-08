<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'quanlydoanvien';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all khoa data
    $sql = "SELECT id, ten_khoa FROM khoa ORDER BY ten_khoa ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $khoa = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode($khoa);

} catch(PDOException $e) {
    // Return error message if something goes wrong
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?> 