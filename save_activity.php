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

// Get fields without validation
$ten_hoat_dong = isset($_POST['ten_hoat_dong']) ? $_POST['ten_hoat_dong'] : '';
$ngay_to_chuc = isset($_POST['ngay_to_chuc']) ? $_POST['ngay_to_chuc'] : null;
$noi_dung = isset($_POST['noi_dung']) ? $_POST['noi_dung'] : null;
$diem = isset($_POST['diem']) ? $_POST['diem'] : 0;
$dia_diem = isset($_POST['dia_diem']) ? $_POST['dia_diem'] : null;
$loai_hoat_dong = isset($_POST['loai_hoat_dong']) ? $_POST['loai_hoat_dong'] : '';
$so_luong_tham_gia = isset($_POST['so_luong_tham_gia']) ? $_POST['so_luong_tham_gia'] : 0;
$nguoi_tao = isset($_POST['nguoi_tao']) ? $_POST['nguoi_tao'] : null;

try {
    // Start transaction
    $conn->begin_transaction();

    // Prepare the SQL statement
    $sql = "INSERT INTO hoatdong (
        ten_hoat_dong,
        ngay_to_chuc,
        noi_dung,
        diem,
        dia_diem,
        loai_hoat_dong,
        so_luong_tham_gia,
        nguoi_tao,
        trang_thai,
        ngay_tao
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, 'chờ duyệt', NOW())";

    $stmt = $conn->prepare($sql);

    // Bind parameters with correct types
    $stmt->bind_param(
        "sssisisi",
        $ten_hoat_dong,    // varchar(150)
        $ngay_to_chuc,     // date
        $noi_dung,         // text
        $diem,             // int(11)
        $dia_diem,         // varchar(255)
        $loai_hoat_dong,   // varchar(100)
        $so_luong_tham_gia,// int(11)
        $nguoi_tao         // int(11)
    );

    // Execute the statement
    if ($stmt->execute()) {
        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Hoạt động đã được thêm thành công',
            'activity_id' => $conn->insert_id
        ]);
    } else {
        throw new Exception($stmt->error);
    }

} catch (Exception $e) {
    $conn->rollback();

    echo json_encode([
        'status' => 'error',
        'message' => $e->getMessage()
    ]);
}
