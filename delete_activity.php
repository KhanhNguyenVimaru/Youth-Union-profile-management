<?php
// Include database connection
require_once 'config.php';

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

// Get activity ID from POST data
$activity_id = isset($_POST['activity_id']) ? intval($_POST['activity_id']) : 0;

// Validate activity ID
if ($activity_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid activity ID'
    ]);
    exit;
}

try {
    // Start transaction
    $conn->begin_transaction();

    // First, delete related records from thamgia table
    $delete_thamgia = $conn->prepare("DELETE FROM thamgia WHERE hoatdong_id = ?");
    $delete_thamgia->bind_param("i", $activity_id);
    $delete_thamgia->execute();

    // Then delete the activity
    $delete_activity = $conn->prepare("DELETE FROM hoatdong WHERE id = ?");
    $delete_activity->bind_param("i", $activity_id);
    $delete_activity->execute();

    // Check if any rows were affected
    if ($delete_activity->affected_rows > 0) {
        // Commit transaction
        $conn->commit();
        
        echo json_encode([
            'status' => 'success',
            'message' => 'Hoạt động đã được xóa thành công'
        ]);
    } else {
        // Rollback transaction
        $conn->rollback();
        
        echo json_encode([
            'status' => 'error',
            'message' => 'Không tìm thấy hoạt động để xóa'
        ]);
    }

} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi khi xóa hoạt động: ' . $e->getMessage()
    ]);
}

// Close prepared statements
$delete_thamgia->close();
$delete_activity->close();

// Close database connection
$conn->close();
?> 