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

    // Get old data from doanvien
    $stmt_old_doanvien = $conn->prepare("SELECT * FROM doanvien WHERE id = ?");
    $stmt_old_doanvien->bind_param("s", $userData['id']);
    $stmt_old_doanvien->execute();
    $old_doanvien = $stmt_old_doanvien->get_result()->fetch_assoc();
    $stmt_old_doanvien->close();

    if (!$old_doanvien) {
        throw new Exception('Đoàn viên không tồn tại');
    }

    // Get old data from hoso
    $stmt_old_hoso = $conn->prepare("SELECT * FROM hoso WHERE doanvien_id = ?");
    $stmt_old_hoso->bind_param("s", $userData['id']);
    $stmt_old_hoso->execute();
    $old_hoso = $stmt_old_hoso->get_result()->fetch_assoc();
    $stmt_old_hoso->close();

    // Compare and build change message
    $changes_doanvien = [];
    $changes_hoso = [];
    
    // Compare doanvien fields
    if (isset($userData['ho_ten']) && $old_doanvien['ho_ten'] != $userData['ho_ten']) {
        $changes_doanvien[] = "Họ tên: " . $old_doanvien['ho_ten'] . " -> " . $userData['ho_ten'];
    }
    
    if (isset($userData['gioi_tinh']) && $old_doanvien['gioi_tinh'] != $userData['gioi_tinh']) {
        $changes_doanvien[] = "Giới tính: " . $old_doanvien['gioi_tinh'] . " -> " . $userData['gioi_tinh'];
    }
    
    if (isset($userData['ngay_sinh']) && $old_doanvien['ngay_sinh'] != $userData['ngay_sinh']) {
        $changes_doanvien[] = "Ngày sinh: " . $old_doanvien['ngay_sinh'] . " -> " . $userData['ngay_sinh'];
    }
    
    if (isset($userData['lop_id']) && $old_doanvien['lop_id'] != $userData['lop_id']) {
        $changes_doanvien[] = "Lớp: " . $old_doanvien['lop_id'] . " -> " . $userData['lop_id'];
    }
    
    if (isset($userData['chidoan_id']) && $old_doanvien['chidoan_id'] != $userData['chidoan_id']) {
        $changes_doanvien[] = "Chi đoàn: " . $old_doanvien['chidoan_id'] . " -> " . $userData['chidoan_id'];
    }
    
    if (isset($userData['khoa']) && $old_doanvien['khoa'] != $userData['khoa']) {
        $changes_doanvien[] = "Khoa: " . $old_doanvien['khoa'] . " -> " . $userData['khoa'];
    }
    
    if (isset($userData['email']) && $old_doanvien['email'] != $userData['email']) {
        $changes_doanvien[] = "Email: " . $old_doanvien['email'] . " -> " . $userData['email'];
    }
    
    if (isset($userData['sdt']) && $old_doanvien['sdt'] != $userData['sdt']) {
        $changes_doanvien[] = "Số điện thoại: " . $old_doanvien['sdt'] . " -> " . $userData['sdt'];
    }
    
    if (isset($userData['chuc_vu']) && $old_doanvien['chuc_vu'] != $userData['chuc_vu']) {
        $changes_doanvien[] = "Chức vụ: " . $old_doanvien['chuc_vu'] . " -> " . $userData['chuc_vu'];
    }
    
    if (isset($userData['nienkhoa']) && $old_doanvien['nienkhoa'] != $userData['nienkhoa']) {
        $changes_doanvien[] = "Niên khóa: " . $old_doanvien['nienkhoa'] . " -> " . $userData['nienkhoa'];
    }

    // Compare hoso fields if data exists
    if ($old_hoso) {
        if (isset($userData['ngay_vao_doan']) && $old_hoso['ngay_vao_doan'] != $userData['ngay_vao_doan']) {
            $changes_hoso[] = "Ngày vào đoàn: " . $old_hoso['ngay_vao_doan'] . " -> " . $userData['ngay_vao_doan'];
        }
        
        if (isset($userData['noi_ket_nap']) && $old_hoso['noi_ket_nap'] != $userData['noi_ket_nap']) {
            $changes_hoso[] = "Nơi kết nạp: " . $old_hoso['noi_ket_nap'] . " -> " . $userData['noi_ket_nap'];
        }
        
        if (isset($userData['file_scan']) && $old_hoso['file_scan'] != $userData['file_scan']) {
            $changes_hoso[] = "File scan: " . $old_hoso['file_scan'] . " -> " . $userData['file_scan'];
        }
        
        if (isset($userData['noi_sinh_hoat_thanh_pho']) && $old_hoso['noi_sinh_hoat_thanh_pho'] != $userData['noi_sinh_hoat_thanh_pho']) {
            $changes_hoso[] = "Nơi sinh hoạt (Thành phố): " . $old_hoso['noi_sinh_hoat_thanh_pho'] . " -> " . $userData['noi_sinh_hoat_thanh_pho'];
        }
        
        if (isset($userData['noi_sinh_hoat_quan_huyen']) && $old_hoso['noi_sinh_hoat_quan_huyen'] != $userData['noi_sinh_hoat_quan_huyen']) {
            $changes_hoso[] = "Nơi sinh hoạt (Quận huyện): " . $old_hoso['noi_sinh_hoat_quan_huyen'] . " -> " . $userData['noi_sinh_hoat_quan_huyen'];
        }
    }

    // Build notification content
    $doanvien_changes = !empty($changes_doanvien) ? "(doanvien) [" . implode(", ", $changes_doanvien) . "]" : "";
    $hoso_changes = !empty($changes_hoso) ? "(hoso) [" . implode(", ", $changes_hoso) . "]" : "";
    $noidung = "sửa thông tin đoàn viên " . $userData['id'] . " " . $doanvien_changes . " " . $hoso_changes;
    $noidung = trim($noidung); // Loại bỏ khoảng trắng thừa

    // Cập nhật thông tin trong bảng doanvien
    $sql_doanvien = "UPDATE doanvien SET 
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

    $stmt_doanvien = $conn->prepare($sql_doanvien);
    $stmt_doanvien->bind_param(
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

    if (!$stmt_doanvien->execute()) {
        throw new Exception("Lỗi khi cập nhật thông tin đoàn viên");
    }

    // Cập nhật hoặc chèn thông tin trong bảng hoso
    if ($old_hoso || isset($userData['ngay_vao_doan']) || isset($userData['noi_ket_nap']) || isset($userData['file_scan']) || isset($userData['noi_sinh_hoat_thanh_pho']) || isset($userData['noi_sinh_hoat_quan_huyen'])) {
        // Biến trung gian để truyền vào bind_param
        $ngayVaoDoan = isset($userData['ngay_vao_doan']) ? $userData['ngay_vao_doan'] : null;
        $noiKetNap = isset($userData['noi_ket_nap']) ? $userData['noi_ket_nap'] : null;
        $fileScan = isset($userData['file_scan']) ? $userData['file_scan'] : null;
        $trangThai = isset($old_hoso['trang_thai']) ? $old_hoso['trang_thai'] : 'Đầy đủ'; // Giá trị mặc định nếu không có
        $noiSinhHoatThanhPho = isset($userData['noi_sinh_hoat_thanh_pho']) ? $userData['noi_sinh_hoat_thanh_pho'] : null;
        $noiSinhHoatQuanHuyen = isset($userData['noi_sinh_hoat_quan_huyen']) ? $userData['noi_sinh_hoat_quan_huyen'] : null;

        if (!$old_hoso) {
            // Chèn bản ghi mới nếu không tồn tại
            $sql_hoso = "INSERT INTO hoso (doanvien_id, ngay_vao_doan, noi_ket_nap, file_scan, trang_thai, noi_sinh_hoat_thanh_pho, noi_sinh_hoat_quan_huyen) VALUES (?, ?, ?, ?, ?, ?, ?)";
            $stmt_hoso = $conn->prepare($sql_hoso);
            $stmt_hoso->bind_param(
                "issssss",
                $userData['id'],
                $ngayVaoDoan,
                $noiKetNap,
                $fileScan,
                $trangThai,
                $noiSinhHoatThanhPho,
                $noiSinhHoatQuanHuyen
            );
        } else {
            // Cập nhật nếu đã tồn tại
            $sql_hoso = "UPDATE hoso SET ngay_vao_doan = ?, noi_ket_nap = ?, file_scan = ?, trang_thai = ?, noi_sinh_hoat_thanh_pho = ?, noi_sinh_hoat_quan_huyen = ? WHERE doanvien_id = ?";
            $stmt_hoso = $conn->prepare($sql_hoso);
            $stmt_hoso->bind_param(
                "ssssssi",
                $ngayVaoDoan,
                $noiKetNap,
                $fileScan,
                $trangThai,
                $noiSinhHoatThanhPho,
                $noiSinhHoatQuanHuyen,
                $userData['id']
            );
        }

        if (!$stmt_hoso->execute()) {
            throw new Exception("Lỗi khi cập nhật thông tin hồ sơ");
        }
        $stmt_hoso->close();
    }

    // Xử lý ảnh hồ sơ nếu có
    if (isset($_FILES['profile_image']) && $_FILES['profile_image']['error'] === UPLOAD_ERR_OK) {
        $file = $_FILES['profile_image'];
        $allowedTypes = ['image/jpeg', 'image/png', 'application/pdf'];
        
        if (!in_array($file['type'], $allowedTypes)) {
            throw new Exception('Loại file không hợp lệ. Chỉ chấp nhận JPG, PNG hoặc PDF');
        }

        $extension = pathinfo($file['name'], PATHINFO_EXTENSION);
        $newFileName = $userData['id'] . '_' . time() . '.' . $extension;
        $uploadPath = 'uploads/profiles/' . $newFileName;

        if (!file_exists('uploads/profiles')) {
            mkdir('uploads/profiles', 0777, true);
        }

        if (!move_uploaded_file($file['tmp_name'], $uploadPath)) {
            throw new Exception('Lỗi khi lưu file');
        }

        // Cập nhật đường dẫn file trong doanvien
        $sql = "UPDATE doanvien SET anh_ho_so = ? WHERE id = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $uploadPath, $userData['id']);
        
        if (!$stmt->execute()) {
            throw new Exception("Lỗi khi cập nhật ảnh hồ sơ");
        }
    }

    // Commit transaction nếu mọi thứ thành công
    $conn->commit();

    // Insert notification with loai = 'change'
    if (!empty($changes_doanvien) || !empty($changes_hoso)) {
        $tacgia_id = $userData['actor_id'];
        $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'change', ?, ?)");
        $stmt_notify->bind_param("isi", $tacgia_id, $noidung, $userData['id']);
        $stmt_notify->execute();
        $stmt_notify->close();
    }
    
    echo json_encode([
        'success' => true,
        'message' => 'Cập nhật thông tin thành công',
        'notification' => $noidung
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