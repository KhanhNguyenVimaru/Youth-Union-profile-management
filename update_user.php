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

    // Get old data before update
    $stmt_old = $conn->prepare("SELECT * FROM doanvien WHERE id = ?");
    $stmt_old->bind_param("s", $userData['id']);
    $stmt_old->execute();
    $old_data = $stmt_old->get_result()->fetch_assoc();
    $stmt_old->close();

    // Compare and build change message
    $changes = [];
    
    // Compare each field manually
    if (isset($userData['ho_ten']) && $old_data['ho_ten'] != $userData['ho_ten']) {
        $changes[] = "Họ tên: " . $old_data['ho_ten'] . " -> " . $userData['ho_ten'];
    }
    
    if (isset($userData['gioi_tinh']) && $old_data['gioi_tinh'] != $userData['gioi_tinh']) {
        $changes[] = "Giới tính: " . $old_data['gioi_tinh'] . " -> " . $userData['gioi_tinh'];
    }
    
    if (isset($userData['ngay_sinh']) && $old_data['ngay_sinh'] != $userData['ngay_sinh']) {
        $changes[] = "Ngày sinh: " . $old_data['ngay_sinh'] . " -> " . $userData['ngay_sinh'];
    }
    
    if (isset($userData['lop_id']) && $old_data['lop_id'] != $userData['lop_id']) {
        $changes[] = "Lớp: " . $old_data['lop_id'] . " -> " . $userData['lop_id'];
    }
    
    if (isset($userData['chidoan_id']) && $old_data['chidoan_id'] != $userData['chidoan_id']) {
        $changes[] = "Chi đoàn: " . $old_data['chidoan_id'] . " -> " . $userData['chidoan_id'];
    }
    
    if (isset($userData['khoa']) && $old_data['khoa'] != $userData['khoa']) {
        $changes[] = "Khoa: " . $old_data['khoa'] . " -> " . $userData['khoa'];
    }
    
    if (isset($userData['email']) && $old_data['email'] != $userData['email']) {
        $changes[] = "Email: " . $old_data['email'] . " -> " . $userData['email'];
    }
    
    if (isset($userData['sdt']) && $old_data['sdt'] != $userData['sdt']) {
        $changes[] = "Số điện thoại: " . $old_data['sdt'] . " -> " . $userData['sdt'];
    }
    
    if (isset($userData['chuc_vu']) && $old_data['chuc_vu'] != $userData['chuc_vu']) {
        $changes[] = "Chức vụ: " . $old_data['chuc_vu'] . " -> " . $userData['chuc_vu'];
    }
    
    if (isset($userData['nienkhoa']) && $old_data['nienkhoa'] != $userData['nienkhoa']) {
        $changes[] = "Niên khóa: " . $old_data['nienkhoa'] . " -> " . $userData['nienkhoa'];
    }

    // Build notification content
    $noidung = "sửa thông tin đoàn viên " . $userData['id'] . " (doanvien) [" . implode(", ", $changes) . "]";

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

    // Insert notification
    $tacgia_id = $userData['actor_id'];
    $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'change', ?, ?)");
    $stmt_notify->bind_param("isi", $tacgia_id, $noidung, $userData['id']);
    $stmt_notify->execute();
    $stmt_notify->close();
    
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