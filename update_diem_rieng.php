<?php
// Include database connection
require_once 'config.php';

// Set header to return JSON response
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ']);
    exit;
}

// Get data from FormData
$doanvien_id = isset($_POST['doanvien_id']) ? (int)$_POST['doanvien_id'] : 0;
$hoatdong_id = isset($_POST['hoatdong_id']) ? (int)$_POST['hoatdong_id'] : 0;
$diem_rieng = isset($_POST['diem_rieng']) ? (int)$_POST['diem_rieng'] : 0;

// Check if data is valid
if ($doanvien_id <= 0 || $hoatdong_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
    exit;
}

$stmt = null;

try {
    // Start transaction
    $conn->begin_transaction();

    // Update diem_rieng in thamgia table
    $sql = "UPDATE thamgia SET diem_rieng = ? WHERE doanvien_id = ? AND hoatdong_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iii", $diem_rieng, $doanvien_id, $hoatdong_id);

    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Cập nhật điểm riêng thành công']);
    } else {
        throw new Exception("Không thể cập nhật điểm riêng. Có thể bản ghi không tồn tại.");
    }

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Close statement and connection
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>