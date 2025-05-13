<?php
include "config.php";
include "send-mail.php";
session_start();

function generateResetToken($length = 6)
{
    return substr(str_shuffle("0123456789"), 0, $length);
}

// Stage 1: Request reset
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["request-reset"])) {
    $id = $_POST["reset-id"];

    if (!$id) {
        echo "<script>alert('Vui lòng nhập mã tài khoản');</script>";
    } else {
        // Check if ID exists
        $stmt = $conn->prepare("SELECT id, email FROM doanvien WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $email = $row["email"];

            if (!$email) {
                echo "<script>alert('Tài khoản này không có email được đăng ký');</script>";
            } else {
                // Generate reset token
                $reset_token = generateResetToken();
                $expiry_time = date('Y-m-d H:i:s', strtotime('+1 hour'));

                // Store token in database
                $stmt = $conn->prepare("UPDATE doanvien SET reset_token = ?, reset_token_expiry = ? WHERE id = ?");
                $stmt->bind_param("sss", $reset_token, $expiry_time, $id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    // Send email with reset token using PHPMailer
                    $subject = "Đặt lại mật khẩu";
                    $message = "
                    <html>
                    <head>
                        <title>Đặt lại mật khẩu</title>
                    </head>
                    <body>
                        <h2>Đặt lại mật khẩu - Hệ thống Quản lý Hồ sơ Đoàn</h2>
                        <p>Mã xác nhận của bạn là: <strong>{$reset_token}</strong></p>
                        <p>Mã có hiệu lực trong 1 giờ.</p>
                    </body>
                    </html>
                    ";

                    if (sendEmail($email, $subject, $message)) {
                        $_SESSION["reset_id"] = $id;
                        echo "<script>alert('Đã gửi mã xác nhận đến email của bạn');</script>";
                        echo "<script>window.location.href = 'reset-password.php?stage=verify';</script>";
                    } else {
                        echo "<script>alert('Không thể gửi email. Vui lòng thử lại sau');</script>";
                    }
                } else {
                    echo "<script>alert('Đã xảy ra lỗi. Vui lòng thử lại sau');</script>";
                }
            }
        } else {
            echo "<script>alert('Mã tài khoản không tồn tại');</script>";
        }
    }
}

// Stage 2: Verify token and reset password
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["verify-reset"])) {
    $token = $_POST["reset-token"];
    $new_password = $_POST["new-password"];
    $confirm_password = $_POST["confirm-password"];
    $id = $_SESSION["reset_id"] ?? "";

    if (!$token || !$new_password || !$confirm_password || !$id) {
        echo "<script>alert('Vui lòng điền đầy đủ thông tin');</script>";
    } else if ($new_password !== $confirm_password) {
        echo "<script>alert('Mật khẩu không khớp');</script>";
    } else {
        // Check token validity
        $stmt = $conn->prepare("SELECT reset_token, reset_token_expiry FROM doanvien WHERE id = ?");
        $stmt->bind_param("s", $id);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result && $result->num_rows === 1) {
            $row = $result->fetch_assoc();
            $db_token = $row["reset_token"];
            $expiry_time = $row["reset_token_expiry"];

            if ($db_token && $db_token === $token && strtotime($expiry_time) > time()) {
                // Token is valid, update password
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);

                $stmt = $conn->prepare("UPDATE doanvien SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE id = ?");
                $stmt->bind_param("ss", $hashed_password, $id);
                $stmt->execute();

                if ($stmt->affected_rows > 0) {
                    unset($_SESSION["reset_id"]);
                    echo "<script>
                        alert('Mật khẩu đã được cập nhật thành công');
                        window.location.href = 'login.php';
                    </script>";
                } else {
                    echo "<script>alert('Đã xảy ra lỗi khi cập nhật mật khẩu');</script>";
                }
            } else {
                echo "<script>alert('Mã xác nhận không hợp lệ hoặc đã hết hạn');</script>";
            }
        } else {
            echo "<script>alert('Đã xảy ra lỗi. Vui lòng thử lại');</script>";
        }
    }
}

$stage = $_GET["stage"] ?? "request";
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
    <title>Đặt lại mật khẩu</title>
    <link rel="stylesheet" href="login.css">
    <style>
        :root {
            --mainBlue: #2832c2;
            --baseFont: bahnschrift;
            --fontGray: #6a6a6a;
            --backGroundGray: #dddddd;
            --whiteGray: #f2f3f5;
        }
        body{
            font-family: var(--baseFont) !important;
        }

        #reset-id {
            height: 40px;
            padding: 10px;
            margin: 20px;
            margin-top: 5px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid var(--fontGray);
        }
        input {
            height: 40px;
            padding: 10px;
            margin: 20px;
            margin-top: 5px;
            margin-bottom: 5px;
            width: 300px;
            border-radius: 5px;
            border: 1px solid var(--fontGray);

        }
    </style>
</head>

<body>
    <div id="main-container">
        <?php if ($stage === "request"): ?>
            <form id="fill-field" method="post" action="">
                <div>
                    <img src="https://upload.wikimedia.org/wikipedia/vi/thumb/1/11/Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg/1200px-Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg.png" alt="" style="height: 120px; width: 120px; margin-bottom: 30px">
                </div>
                <span>QUÊN MẬT KHẨU</span>
                <p>Nhập mã tài khoản của bạn để nhận mã xác nhận</p>
                <input type="text" name="reset-id" id="reset-id" placeholder="Nhập mã tài khoản" required>
                <button type="submit" name="request-reset" class="btn btn-primary">Gửi mã xác nhận</button>
                <p><a href="login.php">Quay lại đăng nhập</a></p>
            </form>
        <?php else: ?>
            <form id="fill-field" method="post" action="">
                <div>
                    <img src="https://upload.wikimedia.org/wikipedia/vi/thumb/1/11/Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg/1200px-Bi%E1%BB%83u_tr%C6%B0ng_Tr%C6%B0%E1%BB%9Dng_%C4%91%E1%BA%A1i_h%E1%BB%8Dc_H%C3%A0ng_h%E1%BA%A3i_Vi%E1%BB%87t_Nam.svg.png" alt="" style="height: 120px; width: 120px; margin-bottom: 30px">
                </div>
                <span>ĐẶT LẠI MẬT KHẨU</span>
                <input type="text" name="reset-token" placeholder="Nhập mã xác nhận" required>
                <input type="password" name="new-password" placeholder="Mật khẩu mới" required>
                <input type="password" name="confirm-password" placeholder="Xác nhận mật khẩu mới" required>
                <button type="submit" name="verify-reset" class="btn btn-primary" style="margin-top: 15px;width:200px">Đặt lại mật khẩu</button>
                <p><a href="login.php">Quay lại đăng nhập</a></p>
            </form>
        <?php endif; ?>
    </div>
</body>

</html>