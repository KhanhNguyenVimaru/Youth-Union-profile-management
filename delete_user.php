<?php
header('Content-Type: application/json');

// Kết nối database
require_once 'config.php';

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit;
}

// Lấy dữ liệu từ request
$data = json_decode(file_get_contents('php://input'), true);
$userId = $data['id'] ?? null;
$id_actor = $data['id_actor'] ?? null;
// Kiểm tra dữ liệu đầu vào
if (!$userId) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin người dùng']);
    exit;
}

try {
    // Bắt đầu transaction
    $conn->begin_transaction();

    // Xóa các bản ghi liên quan trong bảng đoàn viên
    $sql = "DELETE FROM doanvien WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi xóa đoàn viên");
    }

    // Xóa các bản ghi liên quan trong bảng tài khoản
    $sql = "DELETE FROM hoso WHERE doanvien_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $userId);
    
    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi xóa tài khoản");
    }

    // Commit transaction nếu mọi thứ thành công
    $conn->commit();
    
    // Insert notification
    $noidung = "xóa đoàn viên " . $userId;
    $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'delete', ?, ?)");
    $stmt_notify->bind_param("isi", $id_actor, $noidung, $userId);
    $stmt_notify->execute();
    $stmt_notify->close();
    
    echo json_encode([
        'success' => true,
        'message' => 'Xóa người dùng thành công'
    ]);

} catch (Exception $e) {
    // Rollback transaction nếu có lỗi
    $conn->rollback();
    
    echo json_encode([
        'success' => false,
        'message' => $e->getMessage()
    ]);
} finally {
    // Đóng kết nối
    if (isset($stmt)) {
        $stmt->close();
    }
    $conn->close();
}
?> 