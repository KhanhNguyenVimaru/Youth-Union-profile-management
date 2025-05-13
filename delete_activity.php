<?php
// Include database connection
require_once 'config.php';

// Start session
session_start();

// Set header to return JSON response
header('Content-Type: application/json');

// Check if request method is POST
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}

// Get activity ID to delete
$activity_id = isset($_POST['activity_id']) ? $_POST['activity_id'] : 0;

// Get the actor ID from session
$id_actor = isset($_SESSION['id']) ? $_SESSION['id'] : 0; // Assuming the session stores 'id_actor'

// Check if session 'id_actor' is not set
if ($id_actor == 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'User not logged in'
    ]);
    exit;
}

try {
    // Start transaction
    $conn->begin_transaction();

    // Prepare the SQL statement to delete the activity
    $sql = "DELETE FROM hoatdong WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $activity_id);

    // Execute the statement
    if ($stmt->execute() && $stmt->affected_rows > 0) {
        // Prepare the notification message
        $noidung = "Đã xóa hoạt động ". $activity_id;
        
        // Insert notification for this action
        $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'delete_event', ?, ?)");
        $stmt_notify->bind_param("isi", $id_actor, $noidung, $activity_id);
        $stmt_notify->execute();
        $stmt_notify->close();

        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Hoạt động đã được xóa thành công',
            'activity_id' => $activity_id
        ]);
    } else {
        throw new Exception("Không thể xóa hoạt động. Vui lòng kiểm tra lại ID hoạt động.");
    }

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}

// Close prepared statements
if (isset($stmt)) {
    $stmt->close();
}

// Close database connection
$conn->close();
?>
