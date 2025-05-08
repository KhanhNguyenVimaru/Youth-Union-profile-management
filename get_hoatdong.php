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

    // Fetch hoạt động data with tham gia information
    $sql = "SELECT 
            h.id,
            h.ten_hoat_dong,
            h.ngay_to_chuc,
            h.noi_dung,
            h.diem,
            h.dia_diem,
            h.loai_hoat_dong,
            h.so_luong_tham_gia,
            h.ngay_tao,
            h.nguoi_tao,
            h.trang_thai,
            COUNT(t.id) as so_nguoi_tham_gia,
            GROUP_CONCAT(DISTINCT CONCAT(d.ho_ten, ' (', t.diem_rieng, ' điểm)') SEPARATOR '; ') as danh_sach_tham_gia
            FROM hoatdong h
            LEFT JOIN thamgia t ON h.id = t.hoatdong_id
            LEFT JOIN doanvien d ON t.doanvien_id = d.id
            GROUP BY h.id
            ORDER BY h.ngay_to_chuc DESC";
            
    $stmt = $conn->prepare($sql);
    $stmt->execute();
    $hoatdong = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // Return the data as JSON
    echo json_encode($hoatdong, JSON_UNESCAPED_UNICODE);

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