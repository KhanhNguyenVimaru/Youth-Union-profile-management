<?php
include "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id = $_POST["get-login-id"];
    $password = $_POST["get-login-password"];

    if (!$id || !$password) {
        echo "<script>
                alert('Hãy điền tất cả các trường');
            </script>";
        exit();
    }

    $stmt = $conn->prepare("SELECT id, password, chuc_vu FROM doanvien WHERE id = ?");
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows === 1) {
        $row = $result->fetch_assoc();

        if (password_verify($password, $row["password"])) {
            session_start();
            $_SESSION["id"] = $id;
            $_SESSION["role"] = $row["chuc_vu"];
            header("Location: Dashboard.php");
            exit();
        } else {
            header("Location: login.php");
            exit();
        }
    } else {
        header("Location: login.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/vi/0/09/Huy_Hi%E1%BB%87u_%C4%90o%C3%A0n.png">
    <title>Hồ sơ Đoàn viên</title>
    <link rel="stylesheet" href="login.css">
</head>

<body>
    <div id="main-container">
        <form id="fill-field" method="post" action="">
            <div>
                <img src="https://upload.wikimedia.org/wikipedia/vi/thumb/1/11/Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg/1200px-Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg.png" alt="" style="height: 120px; width: 120px; margin-bottom: 30px">
            </div>
            <span for="get-login-id">ĐĂNG NHẬP</span>
            <input type="text" name="get-login-id" placeholder="Nhập mã tài khoản" id="get-login-id" required>
            <input type="password" name="get-login-password" placeholder="Nhập mật khẩu" id="get-login-password" required>
            <p>Quên mật khẩu, thực hiện <a href="">tại đây</a></p>
            <button type="submit" class="btn btn-primary" id="sign-in-btn">Đăng nhập</button>
        </form>
    </div>
</body>
</html>