<?php
$host = 'localhost';
$dbname = 'quanlydoanvien';
$username = 'root';
$password = '';

try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname;charset=utf8", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Kết nối thất bại: " . $e->getMessage());
}

// Xử lý form cập nhật thông tin
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_info'])) {
    $email = $_POST['email'] ?? '';
    $phone = $_POST['phone'] ?? '';
    $doanvien_id = 2; // Trong thực tế lấy từ session
    
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
    $doanvien_id = 2; // Trong thực tế lấy từ session
    
    if ($new_password !== $confirm_password) {
        $error = "Mật khẩu mới không khớp!";
    } else {
        try {
            // Trong thực tế cần kiểm tra mật khẩu hiện tại và mã hóa mật khẩu mới
            $sql = "UPDATE doanvien SET password = :password WHERE id = :id";
            $stmt = $conn->prepare($sql);
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt->bindParam(':password', $hashed_password);
            $stmt->bindParam(':id', $doanvien_id);
            $stmt->execute();
            
            $message = "Đổi mật khẩu thành công!";
        } catch (PDOException $e) {
            $error = "Lỗi khi đổi mật khẩu: " . $e->getMessage();
        }
    }
}

// Lấy thông tin đoàn viên
$doanvien_id = 2; // Trong thực tế lấy từ session
$sql = "SELECT dv.ho_ten, dv.email, dv.sdt, l.ten_lop, cd.ten_chidoan 
        FROM doanvien dv
        JOIN lop l ON dv.lop_id = l.id
        JOIN chidoan cd ON dv.chidoan_id = cd.id
        WHERE dv.id = :id";

$stmt = $conn->prepare($sql);
$stmt->bindParam(':id', $doanvien_id, PDO::PARAM_INT);
$stmt->execute();
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    die("Không tìm thấy thông tin đoàn viên");
}

// Lấy lịch sử hoạt động
$sql_activity = "SELECT hd.ten_hoat_dong, hd.ngay_to_chuc, tg.diem_rieng 
                FROM thamgia tg
                JOIN hoatdong hd ON tg.hoatdong_id = hd.id
                WHERE tg.doanvien_id = :id";
$stmt_activity = $conn->prepare($sql_activity);
$stmt_activity->bindParam(':id', $doanvien_id, PDO::PARAM_INT);
$stmt_activity->execute();
$activities = $stmt_activity->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tài khoản cá nhân</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
            color: #333;
        }
        
        .container {
            display: flex;
            max-width: 1200px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            overflow: hidden;
        }
        
        .sidebar {
            width: 250px;
            background-color: #0000FF;
            color: white;
            padding: 20px;
        }
        
        .sidebar h1 {
            font-size: 20px;
            margin-bottom: 30px;
            padding-bottom: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.2);
        }
        
        .menu-section {
            margin-bottom: 30px;
        }
        
        .menu-section h2 {
            font-size: 16px;
            margin-bottom: 15px;
            color: #ffcdd2;
        }
        
        .menu-item {
            padding: 10px 15px;
            cursor: pointer;
            border-radius: 4px;
            margin-bottom: 5px;
            transition: background-color 0.3s;
        }
        
        .menu-item:hover {
            background-color: rgba(255,255,255,0.1);
        }
        
        .menu-item.active {
            background-color: rgba(255,255,255,0.2);
            font-weight: bold;
        }
        
        .main-content {
            flex: 1;
            padding: 30px;
        }
        
        .section {
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 1px solid #eee;
        }
        
        .section h2 {
            font-size: 18px;
            margin-bottom: 20px;
            color: #0000FF;
        }
        
        .info-row {
            display: flex;
            margin-bottom: 15px;
            align-items: center;
        }
        
        .info-label {
            width: 150px;
            font-weight: bold;
        }
        
        .info-value {
            flex: 1;
        }
        
        input[type="text"],
        input[type="email"],
        input[type="tel"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 14px;
        }
        
        button {
            background-color: #d32f2f;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
            margin-top: 10px;
        }
        
        button:hover {
            background-color: #b71c1c;
        }
        
        .hidden {
            display: none;
        }
        
        .message {
            padding: 10px;
            margin-bottom: 20px;
            border-radius: 4px;
        }
        
        .success {
            background-color: #dff0d8;
            color: #3c763d;
            border: 1px solid #d6e9c6;
        }
        
        .error {
            background-color: #f2dede;
            color: #a94442;
            border: 1px solid #ebccd1;
        }
        
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }
        
        th {
            background-color: #f5f5f5;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="sidebar">
            <h1><?php echo htmlspecialchars($user['ho_ten']); ?></h1>
            
            <div class="menu-section">
                <h2>Thông tin tài khoản</h2>
                <div class="menu-item active" onclick="showSection('account-info')">Thông tin cá nhân</div>
                <div class="menu-item" onclick="showSection('change-password')">Đổi mật khẩu</div>
                <div class="menu-item" onclick="showSection('purchase-history')">Lịch sử hoạt động</div>
            </div>
        </div>
        
        <div class="main-content">
            <?php if (isset($message)): ?>
                <div class="message success"><?php echo $message; ?></div>
            <?php endif; ?>
            
            <?php if (isset($error)): ?>
                <div class="message error"><?php echo $error; ?></div>
            <?php endif; ?>
            
            <!-- Thông tin cá nhân -->
            <div id="account-info" class="account-section">
                <form method="POST">
                    <div class="section">
                        <h2>Thông tin cá nhân</h2>
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
                        <h2>Thông tin liên hệ</h2>
                        <div class="info-row">
                            <div class="info-label">Email:</div>
                            <div class="info-value">
                                <input type="email" name="email" value="<?php echo htmlspecialchars($user['email']); ?>">
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Số điện thoại:</div>
                            <div class="info-value">
                                <input type="tel" name="phone" value="<?php echo htmlspecialchars($user['sdt'] ?? ''); ?>">
                            </div>
                        </div>
                    </div>
                    
                    <button type="submit" name="update_info">Lưu thay đổi</button>
                </form>
            </div>
            
            <!-- Đổi mật khẩu -->
            <div id="change-password" class="account-section hidden">
                
                <form method="POST">
                    <div class="section">
                        <h2>Đổi mật khẩu</h2>
                        <div class="info-row">
                            <div class="info-label">Mật khẩu hiện tại:</div>
                            <div class="info-value">
                                <input type="password" name="current_password" required>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Mật khẩu mới:</div>
                            <div class="info-value">
                                <input type="password" name="new_password" required>
                            </div>
                        </div>
                        <div class="info-row">
                            <div class="info-label">Xác nhận mật khẩu:</div>
                            <div class="info-value">
                                <input type="password" name="confirm_password" required>
                            </div>
                        </div>
                        <button type="submit" name="change_password">Đổi mật khẩu</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function showSection(sectionId) {
            // Ẩn tất cả các section
            document.querySelectorAll('.account-section').forEach(section => {
                section.classList.add('hidden');
            });
            
            // Hiển thị section được chọn
            document.getElementById(sectionId).classList.remove('hidden');
            
            // Cập nhật active menu
            document.querySelectorAll('.menu-item').forEach(item => {
                item.classList.remove('active');
            });
            
            // Thêm class active cho menu item tương ứng
            if (sectionId === 'account-info') {
                document.querySelectorAll('.menu-item')[0].classList.add('active');
            } else if (sectionId === 'change-password') {
                document.querySelectorAll('.menu-item')[1].classList.add('active');
            } else if (sectionId === 'purchase-history') {
                document.querySelectorAll('.menu-item')[2].classList.add('active');
            }
        }
    </script>
</body>
</html>