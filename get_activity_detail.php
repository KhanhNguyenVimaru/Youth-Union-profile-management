<?php
require_once 'config.php';

header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] !== 'GET') {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid request method'
    ]);
    exit;
}

$activity_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($activity_id <= 0) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Invalid activity ID'
    ]);
    exit;
}

try {
    $sql = "SELECT * FROM hoatdong WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $activity_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($activity = $result->fetch_assoc()) {
        // Format date for display
        $activity['ngay_to_chuc'] = date('d/m/Y H:i', strtotime($activity['ngay_to_chuc']));
        $activity['ngay_tao'] = date('d/m/Y H:i', strtotime($activity['ngay_tao']));
        
        echo json_encode([
            'status' => 'success',
            'data' => $activity
        ]);
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Không tìm thấy hoạt động'
        ]);
    }
} catch (Exception $e) {
    echo json_encode([
        'status' => 'error',
        'message' => 'Lỗi khi lấy thông tin hoạt động: ' . $e->getMessage()
    ]);
}

$stmt->close();
$conn->close();
?> 