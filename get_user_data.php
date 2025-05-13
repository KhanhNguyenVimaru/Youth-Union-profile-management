<?php
header('Content-Type: application/json');

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

if (empty($id)) {
    echo json_encode([
        "error" => true,
        "success" => false,
        "message" => "Thiếu ID đoàn viên"
    ]);
    $conn->close();
    exit;
}

try {
    // Sử dụng prepared statement để tránh SQL injection
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
            doanvien.lop_id,
            hoso.ngay_vao_doan,
            hoso.noi_ket_nap,
            hoso.noi_sinh_hoat_thanh_pho,
            hoso.noi_sinh_hoat_quan_huyen
            FROM doanvien
            INNER JOIN chidoan ON doanvien.chidoan_id = chidoan.id
            INNER JOIN lop ON doanvien.lop_id = lop.id
            LEFT JOIN hoso ON doanvien.id = hoso.doanvien_id
            WHERE doanvien.id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

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

    $stmt->close();
} catch (Exception $e) {
    echo json_encode([
        "error" => true,
        "success" => false,
        "message" => "Lỗi truy vấn: " . $e->getMessage()
    ]);
}

$conn->close();
?>