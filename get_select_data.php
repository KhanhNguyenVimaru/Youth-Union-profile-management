<?php
header('Content-Type: application/json');

$host = 'localhost';
$dbname = 'quanlydoanvien';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    // Fetch all data
    $data = [
        'chidoan' => [],
        'lop' => [],
        'nienkhoa' => [],
        'chucvu' => []
    ];

    // Fetch chi đoàn data
    $sql = "SELECT id, ten_chidoan FROM chidoan ORDER BY ten_chidoan ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data['chidoan'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch lớp data
    $sql = "SELECT id, ten_lop, chidoan_id FROM lop ORDER BY ten_lop ASC";
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $data['lop'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch niên khóa data (từ 61 đến 67)
    $data['nienkhoa'] = array_map(function($year) {
        return ['id' => $year, 'ten_nienkhoa' => $year];
    }, range(61, 67));

    // Fetch chức vụ data
    $data['chucvu'] = [
        ['id' => 'admin', 'ten_chucvu' => 'Quản trị viên'],
        ['id' => 'doanvien', 'ten_chucvu' => 'Đoàn viên'],
        ['id' => 'canbodoan', 'ten_chucvu' => 'Cán bộ Đoàn'],
    ];

    // Return the data as JSON
    echo json_encode($data);

} catch(PDOException $e) {
    // Return error message if something goes wrong
    http_response_code(500);
    echo json_encode(['error' => $e->getMessage()]);
}
?> 