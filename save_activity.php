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
$loai_hoat_dong = $_POST['loai_hoat_dong'];
$so_luong_tham_gia = isset($_POST['so_luong_tham_gia']) ? $_POST['so_luong_tham_gia'] : 0;
$id_actor = isset($_POST['id_actor']) ? intval($_POST['id_actor']) : 0;

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
        "sssissii",
        $ten_hoat_dong,    // varchar(150)
        $ngay_to_chuc,     // date
        $noi_dung,         // text
        $diem,             // int(11)
        $dia_diem,         // varchar(255)
        $loai_hoat_dong,   // varchar(100)
        $so_luong_tham_gia,// int(11)
        $id_actor          // int(11) - sử dụng id_actor làm nguoi_tao
    );

    // Execute the statement
    if ($stmt->execute()) {
        $activity_id = $conn->insert_id;
        
        // Insert notification
        $noidung = "thêm hoạt động " . $activity_id;
        $stmt_notify = $conn->prepare("INSERT INTO thongbao (id_actor, loai, noidung, id_affected) VALUES (?, 'insert', ?, ?)");
        $stmt_notify->bind_param("isi", $id_actor, $noidung, $activity_id);
        $stmt_notify->execute();
        $stmt_notify->close();

        $conn->commit();

        echo json_encode([
            'status' => 'success',
            'message' => 'Hoạt động đã được thêm thành công',
            'activity_id' => $activity_id
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

// Close prepared statements
if (isset($stmt)) {
    $stmt->close();
}

// Close database connection
$conn->close();
?>
