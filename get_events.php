<?php
session_start(); // Start the session
include 'config.php';
header('Content-Type: application/json');

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);

// Xây dựng câu lệnh SQL cơ bản
$sql = "SELECT * FROM hoatdong WHERE 1=1";
$params = [];
$types = "";

// Kiểm tra role từ session
if (isset($_SESSION['role']) && $_SESSION['role'] === 'doanvien') {
    $sql .= " AND trang_thai = ?";
    $params[] = 'Đã duyệt';
    $types .= "s";
}

// Thêm điều kiện lọc theo khoảng thời gian
if (!empty($data['startDate'])) {
    $sql .= " AND DATE(ngay_to_chuc) >= ?";
    $params[] = $data['startDate'];
    $types .= "s";
}

if (!empty($data['endDate'])) {
    $sql .= " AND DATE(ngay_to_chuc) <= ?";
    $params[] = $data['endDate'];
    $types .= "s";
}

// Thêm điều kiện lọc theo loại hoạt động
if (!empty($data['eventType'])) {
    $sql .= " AND loai_hoat_dong = ?";
    $params[] = $data['eventType'];
    $types .= "s";
}

// Thêm điều kiện lọc theo trạng thái
if (!empty($data['eventStatus'])) {
    $sql .= " AND trang_thai = ?";
    $params[] = $data['eventStatus'];
    $types .= "s";
}

// Thêm điều kiện tìm kiếm
if (!empty($data['search'])) {
    $searchTerm = "%" . $data['search'] . "%";
    $sql .= " AND (ten_hoat_dong LIKE ? OR noi_dung LIKE ? OR dia_diem LIKE ?)";
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $params[] = $searchTerm;
    $types .= "sss";
}

// Sắp xếp theo thời gian giảm dần
$sql .= " ORDER BY ngay_to_chuc DESC";

// Chuẩn bị và thực thi câu lệnh SQL
$stmt = $conn->prepare($sql);

// Bind parameters nếu có
if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Kiểm tra nếu có dữ liệu
if ($result->num_rows > 0) {
    $events = [];

    // Lấy tất cả dữ liệu
    while ($row = $result->fetch_assoc()) {
        $events[] = $row;
    }

    // Trả về dữ liệu dưới dạng JSON
    echo json_encode(['success' => true, 'data' => $events]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu']);
}

$stmt->close();
$conn->close();
?>