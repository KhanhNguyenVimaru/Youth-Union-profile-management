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
$user_id = isset($_POST['user_id']) ? (int)$_POST['user_id'] : 0;
$event_id = isset($_POST['event_id']) ? (int)$_POST['event_id'] : 0;

// Check if data is valid
if ($user_id <= 0 || $event_id <= 0) {
    echo json_encode(['status' => 'error', 'message' => 'ID không hợp lệ']);
    exit;
}

try {
    // Check if user has joined the event
    $sql = "SELECT doanvien_id  FROM thamgia WHERE doanvien_id  = ? AND hoatdong_id  = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $user_id, $event_id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo json_encode(['status' => 'joined']);
    } else {
        echo json_encode(['status' => 'not_joined']);
    }

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Close statement and connection
if ($stmt) {
    $stmt->close();
}
$conn->close();
?>