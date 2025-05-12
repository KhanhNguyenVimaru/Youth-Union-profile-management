<?php
// Include database connection
require_once 'config.php';

// Start session
session_start();

// Set header to return JSON response with UTF-8 encoding
header('Content-Type: application/json; charset=utf-8');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'success' => false,
        'message' => 'Phương thức yêu cầu không hợp lệ'
    ]);
    exit;
}

// Get activity ID from JSON input
$input = json_decode(file_get_contents('php://input'), true);
$activity_id = isset($input['id']) ? (int)$input['id'] : 0;

// Get the actor ID from session
$id_actor = isset($_SESSION['id']) ? (int)$_SESSION['id'] : 0;

// Check if session 'id_actor' is not set
if ($id_actor == 0) {
    echo json_encode([
        'success' => false,
        'message' => 'Người dùng chưa đăng nhập'
    ]);
    exit;
}

// Check if activity ID is valid
if ($activity_id <= 0) {
    echo json_encode([
        'success' => false,
        'message' => 'ID hoạt động không hợp lệ'
    ]);
    exit;
}

$stmt = null;
$stmt_check = null;
$stmt_notify = null;

try {
    // Start transaction
    $conn->begin_transaction();

    // Check if the activity exists and is in "chờ duyệt" status
    $sql_check = "SELECT trang_thai FROM hoatdong WHERE id = ?";
    $stmt_check = $conn->prepare($sql_check);
    $stmt_check->bind_param("i", $activity_id);
    $stmt_check->execute();
    $result = $stmt_check->get_result();

    if ($result->num_rows === 0) {
        throw new Exception("Hoạt động không tồn tại.");
    }

    $row = $result->fetch_assoc();
    if ($row['trang_thai'] !== 'chờ duyệt') {
        throw new Exception("Hoạt động không ở trạng thái chờ duyệt.");
    }

    // Free result set
    $result->free();
    $stmt_check->close();
    $stmt_check = null;

    // Prepare the SQL statement to update the activity status
    $sql = "UPDATE hoatdong SET trang_thai = 'đã duyệt' WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $activity_id);

    // Execute the statement
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        $stmt->close();
        $stmt = null;

        // Prepare the notification message
        $noidung = "Duyệt hoạt động " . $activity_id;

        // Insert notification for this action
        $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'approve', ?, ?)");
        $stmt_notify->bind_param("isi", $id_actor, $noidung, $activity_id);
        $stmt_notify->execute();
        $stmt_notify->close();
        $stmt_notify = null;

        // Commit transaction
        $conn->commit();

        echo json_encode([
            'success' => true,
            'message' => 'Hoạt động đã được duyệt thành công'
        ]);
    } else {
        throw new Exception("Không thể duyệt hoạt động. Vui lòng kiểm tra lại.");
    }

} catch (Exception $e) {
    // Rollback transaction
    $conn->rollback();

    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} catch (mysqli_sql_exception $e) {
    // Rollback transaction
    $conn->rollback();

    echo json_encode([
        'success' => false,
        'message' => 'Lỗi cơ sở dữ liệu: ' . $e->getMessage()
    ]);
} finally {
    // Close prepared statements if they exist
    if ($stmt_check) {
        $stmt_check->close();
    }
    if ($stmt) {
        $stmt->close();
    }
    if ($stmt_notify) {
        $stmt_notify->close();
    }

    // Close database connection
    if ($conn) {
        $conn->close();
    }
}
?>