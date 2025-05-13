<?php
// Include database connection
require_once 'config.php';

// Start session
session_start();

// Set header to return JSON response
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['status' => 'error', 'message' => 'Phương thức yêu cầu không hợp lệ']);
    exit;
}

// Get data from FormData
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

// Check if data is valid
if ($user_id <= 0 || $event_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
    exit;
}

$stmt_check = null;
$stmt_insert = null;

try {
    // Start transaction
    $conn->begin_transaction();

    // Check if the user and event exist (optional)
    $sql_check = "SELECT id FROM hoatdong WHERE id = ? AND trang_thai = 'đã duyệt'";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $event_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Hoạt động không tồn tại hoặc chưa được duyệt.");
    }

    // Check if the user has already joined the event to avoid duplicates
    $sql_check_join = "SELECT doanvien_id FROM thamgia WHERE doanvien_id = ? AND hoatdong_id	 = ?";
    $stmt_check_join = $conn->prepare($sql_check_join);
    $stmt_check_join->bind_param("ii", $user_id, $event_id);
    $stmt_check_join->execute();
    $join_result = $stmt_check_join->get_result();

    if ($join_result->num_rows > 0) {
        throw new Exception("Bạn đã tham gia hoạt động này rồi.");
    }
    $stmt_check_join->close();

    // Insert into thamgia table with correct column names
    $sql_insert = "INSERT INTO thamgia (doanvien_id, hoatdong_id) VALUES (?, ?)";
    $stmt_insert = $conn->prepare($sql_insert);
    $stmt_insert->bind_param("ii", $user_id, $event_id);

    if ($stmt_insert->execute()) {
        $conn->commit();
        echo json_encode(['status' => 'success', 'message' => 'Tham gia hoạt động thành công']);
    } else {
        throw new Exception("Không thể tham gia hoạt động.");
    }

} catch (Exception $e) {
    $conn->rollback();
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Close statements
if ($stmt_check) {
    $stmt_check->close();
}
if ($stmt_insert) {
    $stmt_insert->close();
}
$conn->close();
?>