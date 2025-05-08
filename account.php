<?php
session_start();

// Kiểm tra đăng nhập
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

$host = 'localhost';
$dbname = 'quanlydoanvien';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

$message = '';
$error = '';

// Xử lý form cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_info'])) {
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $doanvien_id = $_SESSION["id"];

    try {
        $sql = "UPDATE doanvien SET email = :email, sdt = :phone WHERE id = :id";
        $stmt = $conn->prepare($sql);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':id', $doanvien_id);
        $stmt->execute();

        $message = "Cập nhật thông tin thành công!";
    } catch (PDOException $e) {
        $error = "Lỗi khi cập nhật: " . $e->getMessage();
    }
}

// Xử lý form đổi mật khẩu
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['change_password'])) {
    $current_password = $_POST['current_password'] ?? '';
    $new_password = $_POST['new_password'] ?? '';
    $confirm_password = $_POST['confirm_password'] ?? '';
    $doanvien_id = $_SESSION["id"];

    if ($new_password !== $confirm_password) {
        $error = "Mật khẩu mới không khớp!";
    } else {
        try {
            // Kiểm tra mật khẩu hiện tại
            $sql = "SELECT password FROM doanvien WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $stmt->bindParam(':id', $doanvien_id);
            $stmt->execute();
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            if (!password_verify($current_password, $user['password'])) {
                $error = "Mật khẩu hiện tại không đúng!";
            } else {
                // Cập nhật mật khẩu mới
                $sql = "UPDATE doanvien SET password = :password WHERE id = :id";
                $stmt = $conn->prepare($sql);
                $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt->bindParam(':password', $hashed_password);
                $stmt->bindParam(':id', $doanvien_id);
                $stmt->execute();

                $message = "Đổi mật khẩu thành công!";
            }
        } catch (PDOException $e) {
            $error = "Lỗi khi đổi mật khẩu: " . $e->getMessage();
        }
    }
}

// Lấy thông tin đoàn viên
$doanvien_id = $_SESSION["id"];
$sql = "SELECT dv.*, l.ten_lop, cd.ten_chidoan 
        FROM doanvien dv
        JOIN lop l ON dv.lop_id = l.id
        JOIN chidoan cd ON dv.chidoan_id = cd.id
        WHERE dv.id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $doanvien_id);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Không tìm thấy thông tin đoàn viên");
}

// Lấy lịch sử hoạt động
$sql_activity = "SELECT hd.ten_hoat_dong, hd.ngay_to_chuc, tg.diem_rieng 
                FROM thamgia tg
                JOIN hoatdong hd ON tg.hoatdong_id = hd.id
                WHERE tg.doanvien_id = :id
                ORDER BY hd.ngay_to_chuc DESC";
$stmt_activity = $conn->prepare($sql_activity);
$stmt_activity->bindParam(':id', $doanvien_id);
$stmt_activity->execute();
$activities = $stmt_activity->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/vi/0/09/Huy_Hi%E1%BB%87u_%C4%90o%C3%A0n.png">
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="manage_modal.css">
    <title>Hồ sơ Đoàn viên</title>
    <style>
        :root {
            --primary-color: #2832c2;
            --secondary-color: #1a237e;
            --accent-color: #3949ab;
            --text-color: #333;
            --light-gray: #f5f5f5;
            --border-color: #e0e0e0;
        }

        .narrow-row {
            width: 80%;
            margin: 0 auto;
        }

        @media (max-width: 768px) {
            .narrow-row {
                width: 90%;
            }
        }

        body {
            font-family: 'Bahnschrift', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: var(--light-gray);
            color: var(--text-color);
        }

        .account-container {
            max-width: 1200px;
            margin: 2rem auto;
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            overflow: hidden;
        }

        .account-sidebar {
            background: var(--primary-color);
            color: white;
            padding: 2rem;
            min-height: 100vh;
        }

        .account-sidebar h1 {
            font-size: 1.5rem;
            margin-bottom: 2rem;
            padding-bottom: 1rem;
            border-bottom: 1px solid rgba(255, 255, 255, 0.2);
        }

        .menu-section {
            margin-bottom: 2rem;
        }

        .menu-section h2 {
            font-size: 1rem;
            color: rgba(255, 255, 255, 0.8);
            margin-bottom: 1rem;
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .menu-item {
            padding: 0.8rem 1rem;
            margin-bottom: 0.5rem;
            border-radius: 5px;
            cursor: pointer;
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .menu-item:hover {
            background: rgba(255, 255, 255, 0.1);
        }

        .menu-item.active {
            background: rgba(255, 255, 255, 0.2);
            font-weight: 600;
        }

        .menu-item i {
            width: 20px;
            text-align: center;
        }

        .account-content {
            padding: 2rem;
        }

        .section {
            background: white;
            padding: 1.5rem;
            border-radius: 8px;
            margin-bottom: 2rem;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        .section h2 {
            color: var(--primary-color);
            font-size: 1.25rem;
            margin-bottom: 1.5rem;
            padding-bottom: 0.5rem;
            border-bottom: 2px solid var(--border-color);
        }

        .info-row {
            display: flex;
            margin-bottom: 1rem;
            align-items: center;
        }

        .info-label {
            width: 150px;
            font-weight: 600;
            color: var(--text-color);
        }

        .info-value {
            flex: 1;
        }

        .form-control {
            border: 1px solid var(--border-color);
            border-radius: 5px;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }

        .form-control:focus {
            border-color: var(--accent-color);
            box-shadow: 0 0 0 0.2rem rgba(40, 50, 194, 0.25);
        }

        .btn-primary {
            background-color: var(--primary-color);
            border: none;
            padding: 0.75rem 1.5rem;
            border-radius: 5px;
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            background-color: var(--secondary-color);
            transform: translateY(-1px);
        }

        .alert {
            border-radius: 5px;
            padding: 1rem;
            margin-bottom: 1.5rem;
        }

        .alert-success {
            background-color: #d4edda;
            border-color: #c3e6cb;
            color: #155724;
        }

        .alert-danger {
            background-color: #f8d7da;
            border-color: #f5c6cb;
            color: #721c24;
        }

        @media (max-width: 768px) {
            .account-container {
                margin: 1rem;
            }

            .account-sidebar {
                min-height: auto;
            }

            .info-row {
                flex-direction: column;
                align-items: flex-start;
            }

            .info-label {
                width: 100%;
                margin-bottom: 0.5rem;
            }
        }
    </style>
</head>

<body>
    <?php include "Navbar.php" ?>
    <?php include "manage_modal.php" ?>
    <div class="container-fluid account-container">
        <div class="row narrow-row">
            <div class="col-12">
                <div class="account-content">
                    <!-- Thêm nút logout ở đầu trang -->

                    <!-- Thông tin cá nhân -->
                    <div id="account-info" class="account-section">
                        <form method="POST">
                            <div class="section">
                                <h2><i class="fas fa-id-card me-2"></i>Thông tin cá nhân</h2>
                                <div class="info-row">
                                    <div class="info-label">Họ và tên:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($user['ho_ten']); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Lớp:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($user['ten_lop']); ?></div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Chi đoàn:</div>
                                    <div class="info-value"><?php echo htmlspecialchars($user['ten_chidoan']); ?></div>
                                </div>
                            </div>

                            <div class="section">
                                <h2><i class="fas fa-address-book me-2"></i>Thông tin liên hệ</h2>
                                <div class="info-row">
                                    <div class="info-label">Email:</div>
                                    <div class="info-value">
                                        <input type="email" name="email" class="form-control" value="<?php echo htmlspecialchars($user['email']); ?>">
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Số điện thoại:</div>
                                    <div class="info-value">
                                        <input type="tel" name="phone" class="form-control" value="<?php echo htmlspecialchars($user['sdt']); ?>">
                                    </div>
                                </div>
                                <div style="display: flex; justify-content:end">
                                    <button type="submit" name="update_info" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Lưu thay đổi
                                    </button>
                                </div>
                            </div>

                            <!-- <div class="text-center">
                                <button type="submit" name="update_info" class="btn btn-primary">
                                    <i class="fas fa-save me-2"></i>Lưu thay đổi
                                </button>
                            </div> -->
                        </form>
                    </div>

                    <!-- Đổi mật khẩu -->
                    <div id="change-password" class="account-section hidden">
                        <form method="POST">
                            <div class="section">
                                <h2><i class="fas fa-key me-2"></i>Đổi mật khẩu</h2>
                                <div class="info-row">
                                    <div class="info-label">Mật khẩu hiện tại:</div>
                                    <div class="info-value">
                                        <input type="password" name="current_password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Mật khẩu mới:</div>
                                    <div class="info-value">
                                        <input type="password" name="new_password" class="form-control" required>
                                    </div>
                                </div>
                                <div class="info-row">
                                    <div class="info-label">Xác nhận mật khẩu:</div>
                                    <div class="info-value">
                                        <input type="password" name="confirm_password" class="form-control" required>
                                    </div>
                                </div>
                                <div div style="display: flex; justify-content:end">
                                    <button type="submit" name="change_password" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Đổi mật khẩu
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>

                    <!-- Lịch sử hoạt động -->
                    <div id="activity-history" class="account-section hidden">
                        <div class="section">
                            <h2><i class="fas fa-history me-2"></i>Lịch sử hoạt động</h2>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Tên hoạt động</th>
                                            <th>Ngày tổ chức</th>
                                            <th>Điểm riêng</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($activities as $activity): ?>
                                            <tr>
                                                <td><?php echo htmlspecialchars($activity['ten_hoat_dong']); ?></td>
                                                <td><?php echo htmlspecialchars($activity['ngay_to_chuc']); ?></td>
                                                <td><?php echo htmlspecialchars($activity['diem_rieng']); ?></td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex justify-content-end mb-4">
                    <button onclick="logout()" class="btn btn-danger" style="height: 40px;">
                        <i class="bi bi-box-arrow-right me-2"></i>Đăng xuất
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function loadPage(page) {
            if (localStorage.getItem("myID" == null)) {
                window.location.href = "Login.php";
            } else {
                window.location.href = page;
            }
        }
    </script>
    <script>
        // Thêm hàm logout
        function logout() {
            // Xóa localStorage
            localStorage.clear();

            // Chuyển hướng đến trang logout
            window.location.href = 'logout.php';
        }

        function showSection(sectionId) {
            // Ẩn tất cả các section
            document.querySelectorAll('.account-section').forEach(section => {
                section.classList.add('hidden');
            });

            // Hiển thị section được chọn
            document.getElementById(sectionId).classList.remove('hidden');

            // Cập nhật active button
            document.querySelectorAll('.btn-group .btn').forEach(btn => {
                btn.classList.remove('active');
            });

            // Thêm class active cho button tương ứng
            const buttons = document.querySelectorAll('.btn-group .btn');
            if (sectionId === 'account-info') {
                buttons[0].classList.add('active');
            } else if (sectionId === 'change-password') {
                buttons[1].classList.add('active');
            } else if (sectionId === 'activity-history') {
                buttons[2].classList.add('active');
            }
        }
    </script>
</body>
<script src="index.js"></script>

</html>