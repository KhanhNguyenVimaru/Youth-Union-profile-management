<?php
header('Content-Type: application/json');
require_once 'config.php';

// Check if user is logged in
session_start();
if (!isset($_SESSION['id'])) {
    echo json_encode(['success' => false, 'message' => 'Người dùng chưa đăng nhập']);
    exit;
}

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['current_password']) || !isset($data['new_password']) || !isset($data['confirm_password'])) {
    echo json_encode(['success' => false, 'message' => 'Thiếu thông tin cần thiết']);
    exit;
}

$current_password = $data['current_password'];
$new_password = $data['new_password'];
$confirm_password = $data['confirm_password'];
$user_id = $_SESSION['id'];

// Validate new password
if (strlen($new_password) < 6) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu mới phải có ít nhất 6 ký tự']);
    exit;
}

if ($new_password !== $confirm_password) {
    echo json_encode(['success' => false, 'message' => 'Mật khẩu xác nhận không khớp']);
    exit;
}

try {
    // Get current password hash
    $stmt = $conn->prepare("SELECT password FROM doanvien WHERE id = ?");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (!$user) {
        echo json_encode(['success' => false, 'message' => 'Không tìm thấy người dùng']);
        exit;
    }

    // Verify current password
    if (!password_verify($current_password, $user['password'])) {
        echo json_encode(['success' => false, 'message' => 'Mật khẩu hiện tại không đúng']);
        exit;
    }

    // Hash new password
    $new_password_hash = password_hash($new_password, PASSWORD_DEFAULT);

    // Update password
    $stmt = $conn->prepare("UPDATE doanvien SET password = ? WHERE id = ?");
    $stmt->bind_param("si", $new_password_hash, $user_id);
    
    if ($stmt->execute()) {
        // Add notification
        $noidung = "thay đổi mật khẩu";
        $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'change', ?, ?)");
        $stmt_notify->bind_param("isi", $user_id, $noidung, $user_id);
        $stmt_notify->execute();
        
        echo json_encode([
            'success' => true, 
            'message' => 'Đổi mật khẩu thành công',
            'script' => '<script>alert("Đổi mật khẩu thành công!"); window.location.href = "notify_page.php";</script>'
        ]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Lỗi khi cập nhật mật khẩu']);
    }

} catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'Lỗi: ' . $e->getMessage()]);
}

$conn->close();
?> 