<?php
include 'config.php';
header('Content-Type: application/json');

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra dữ liệu đầu vào
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu']);
    exit;
}

// Xử lý câu lệnh SQL
$sql = "SELECT * FROM thongbao ORDER BY thoigian DESC"; // Truy vấn tất cả dữ liệu từ bảng thongbao, sắp xếp theo thời gian tạo (ngay_tao)

// Chuẩn bị và thực thi câu lệnh SQL
$stmt = $conn->prepare($sql);
$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu có dữ liệu
if ($result->num_rows > 0) {
    $notifications = [];

    // Lấy tất cả dữ liệu
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }

    // Trả về dữ liệu dưới dạng JSON
    echo json_encode(['success' => true, 'data' => $notifications]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu']);
}
?>
