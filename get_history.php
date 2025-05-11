<?php
include 'config.php';
header('Content-Type: application/json');

$data = json_encode(file_get_contents('php://input'), true);
if(!$data){
    echo json_encode(['success' => false, 'message' => 'Không có dữ liệu']);
    exit;
}else{
    if($data['role'] == 'admin'){
        $sql = "SELECT * FROM thongbao";
    }else if($data['role'] == 'canbodoan'){
        $sql = "SELECT * FROM thongbao WHERE id_user = ?";
    }else{
        $sql = "SELECT * FROM thongbao WHERE id_user = ?";
    }
}

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $data['id']);
    $stmt->execute();
    $result = $stmt->get_result();
?>
