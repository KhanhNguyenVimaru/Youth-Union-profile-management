<?php
header('Content-Type: application/json');

$servername = "localhost";
$user = "root";
$password = "";
$db_name = "quanlydoanvien";

$conn = new mysqli($servername, $user, $password, $db_name);
if ($conn->connect_error) {
    echo json_encode(["success" => false, "message" => "Lỗi kết nối với server"]);
    exit;
}
$data = json_decode(file_get_contents("php://input"), true);
if (!$data || !isset($data['ten'], $data['id'], $data['password'])) {
    echo json_encode(["success" => false, "message" => "Dữ liệu không hợp lệ hoặc thiếu"]);
    exit;
}

$name = $data['ten'];
$id = $data['id'];
$pass = $data['password'];
$hash_pass = password_hash($pass, PASSWORD_DEFAULT);

if (available($conn, $id)) {
    $username = account_name($name, $id);
    $stmt = $conn->prepare("INSERT INTO users (id, username, password, ho_ten) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("isss", $id, $username, $hash_pass, $name);

    if ($stmt->execute()) {
        echo json_encode(["success" => true, "message" => "Thêm tài khoản thành công"]);
    } else {
        echo json_encode(["success" => false, "message" => "Thêm tài khoản không thành công: " . $stmt->error]);
    }

    $stmt->close();
}

function account_name($name, $id)
{
    $name_arr = explode(" ", $name);
    $last_name = end($name_arr);
    return strtolower($last_name . $id);
}

function available($conn, $id)
{
    $sql_selectid = "SELECT * FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql_selectid);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    return $check_available = $stmt->get_result();
}