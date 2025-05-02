<?php
header('Content-Type: application/json');

// Kết nối database
require_once 'config.php';

// Kiểm tra phương thức request
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    echo json_encode(['success' => false, 'message' => 'Phương thức không hợp lệ']);
    exit;
}

try {
    // Lấy dữ liệu từ request
    $userData = json_decode($_POST['userData'], true);
    
    // Kiểm tra dữ liệu đầu vào
    if (!$userData || !isset($userData['id'])) {
        throw new Exception('Thiếu thông tin người dùng');
    }

    // Bắt đầu transaction
    $conn->begin_transaction();

    // Cập nhật thông tin trong bảng đoàn viên
    $sql = "UPDATE doanvien SET 
            ho_ten = ?,
            gioi_tinh = ?,
            ngay_sinh = ?,
            lop_id = ?,
            chidoan_id = ?,
            khoa = ?,
            email = ?,
            sdt = ?,
            chuc_vu = ?,
            nienkhoa = ?
            WHERE id = ?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
        "sssiiissssi",
        $userData['ho_ten'],
        $userData['gioi_tinh'],
        $userData['ngay_sinh'],
        $userData['lop_id'],
        $userData['chidoan_id'],
        $userData['khoa'],
        $userData['email'],
        $userData['sdt'],
        $userData['chuc_vu'],
        $userData['nienkhoa'],
        $userData['id']
    );

    if (!$stmt->execute()) {
        throw new Exception("Lỗi khi cập nhật thông tin đoàn viên");
    }

    // Xử lý ảnh hồ sơ nếu có
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        
        // Kiểm tra loại file
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Loại file không hợp lệ. Chỉ chấp nhận JPG, PNG hoặc PDF');
        }

        // Tạo tên file mới
        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = $userData['id'] . '_' . time() . '.' . $extension;
        $uploadPath = 'uploads/profiles/' . $newFileName;

        // Tạo thư mục nếu chưa tồn tại
        if (!file_exists('uploads/profiles')) {
            mkdir('uploads/profiles', 0777, true);
        }

        // Di chuyển file
        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Lỗi khi lưu file');
        }

        // Cập nhật đường dẫn file trong database
        $sql = "UPDATE doanvien SET anh_ho_so = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $uploadPath, $userData['id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi cập nhật ảnh hồ sơ");
        }
    }

    // Commit transaction nếu mọi thứ thành công
    $conn->commit();
    
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật thông tin thành công'
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