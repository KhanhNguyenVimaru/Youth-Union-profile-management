<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlydoanvien";

$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die(json_encode([
        "error" => true,
        "success" => false,
        "message" => "Kết nối thất bại: " . $conn->connect_error
    ]));
}

// Nhận dữ liệu từ fetch
$data = json_decode(file_get_contents("php://input"), true);
$id = isset($data['id']) ? $data['id'] : '';

$sql = "SELECT
            doanvien.id AS doanvien_id,
            doanvien.ho_ten,
            doanvien.gioi_tinh,
            doanvien.ngay_sinh,
            doanvien.khoa,
            doanvien.email,
            doanvien.sdt,
            doanvien.chuc_vu,
            doanvien.nienkhoa,
            lop.ten_lop,
            lop.id AS lop_id,
            chidoan.ten_chidoan
        FROM doanvien
        INNER JOIN chidoan ON doanvien.chidoan_id = chidoan.id
        INNER JOIN lop ON doanvien.lop_id = lop.id
        WHERE doanvien.id = '$id'";

$result = $conn->query($sql);

if ($result && $result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode([
        "error" => false,
        "success" => true,
        "data" => $row
    ]);
} else {
    echo json_encode([
        "error" => true,
        "success" => false,
        "message" => "Không tìm thấy dữ liệu với ID đã cung cấp"
    ]);
}

$conn->close();
