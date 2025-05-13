<?php
include 'config.php';
header('Content-Type: application/json');
session_start();

// Lấy thông tin từ session
$myId = $_SESSION['id'] ?? null;
$myRole = $_SESSION['role'] ?? null;

// Lấy dữ liệu từ POST
$data = json_decode(file_get_contents('php://input'), true);

// Kiểm tra dữ liệu đầu vào
if (!$data) {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu']);
    exit;
}

// Xây dựng câu lệnh SQL cơ bản
$sql = "SELECT * FROM thongbao WHERE 1=1";
$params = [];
$types = "";

// Lọc theo khoảng thời gian
if (!empty($data['startDate'])) {
    $sql .= " AND DATE(thoigian) >= ?";
    $params[] = $data['startDate'];
    $types .= "s";
}
if (!empty($data['endDate'])) {
    $sql .= " AND DATE(thoigian) <= ?";
    $params[] = $data['endDate'];
    $types .= "s";
}

// Lọc theo loại hoạt động cụ thể
if (!empty($data['activityType']) && $data['activityType'] !== 'all') {
    $sql .= " AND loai = ?";
    $params[] = $data['activityType'];
    $types .= "s";
}

// Tìm kiếm nội dung
if (!empty($data['searchContent'])) {
    $sql .= " AND noidung LIKE ?";
    $params[] = "%" . $data['searchContent'] . "%";
    $types .= "s";
}

// Thêm điều kiện theo vai trò người dùng
if ($myRole === 'canbodoan' && $myId) {
    $sql .= " AND loai IN (?, ?, ?, ?, ?, ?) AND (id_actor = ? OR id_affected = ?)";
    $params = array_merge($params, ['approve', 'insert', 'change', 'delete', 'insert_event', 'delete_event', $myId, $myId]);
    $types .= "ssssssii"; // 6 string, 2 integer
}

if ($myRole === 'doanvien' && $myId) {
    $sql .= " AND loai IN (?, ?, ?, ?) AND (id_actor = ? OR id_affected = ?)";
    $params = array_merge($params, ['approve', 'insert', 'delete', 'change', $myId, $myId]);
    $types .= "ssssii"; // 4 string, 2 integer
}

// Sắp xếp theo thời gian giảm dần
$sql .= " ORDER BY thoigian DESC";

// Chuẩn bị và thực thi
$stmt = $conn->prepare($sql);

if (!empty($params)) {
    $stmt->bind_param($types, ...$params);
}

$stmt->execute();
$result = $stmt->get_result();

// Trả về kết quả
if ($result->num_rows > 0) {
    $notifications = [];
    while ($row = $result->fetch_assoc()) {
        $notifications[] = $row;
    }
    echo json_encode(['success' => true, 'data' => $notifications]);
} else {
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu']);
}

$stmt->close();
$conn->close();
