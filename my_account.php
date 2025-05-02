<?php
$servername = "localhost";
$username = "root";
$password_db = "";
$dbname = "quanlydoanvien";

$conn = new mysqli($servername, $username, $password_db, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

$id = $data['id'];
$password = $data['password'];

// Câu truy vấn với chuẩn bị tránh SQL injection (khuyến khích)
$stmt = $conn->prepare("SELECT password,chuc_vu FROM doanvien WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();

if($result && $result->num_rows > 0){
    $row = $result->fetch_assoc();
    $hashed_password = $row['password'];
    $role = $row['chuc_vu'];

    if (password_verify($password, $hashed_password)) {
        session_start();
        $_SESSION["id"] = $id;
        echo json_encode([
            "error" => false,
            "success" => true,
            "id" => $id,
            "role" => $role
        ]);
    } else {
        echo json_encode([
            "error" => true,
            "success" => false,
            "message" => "Incorrect password."
        ]);
    }
} else {
    echo json_encode([
        "error" => true,
        "success" => false,
        "message" => "Account not found."
    ]);
}

$conn->close();
?>
