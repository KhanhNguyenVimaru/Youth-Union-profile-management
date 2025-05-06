<?php
session_start(); // ⚠️ BẮT BUỘC PHẢI CÓ

// Kiểm tra đăng nhập
if (!isset($_SESSION["id"]) || !isset($_SESSION["role"])) {
    header("Location: login.php");
    exit();
}

// Kết nối database
require_once 'config.php';

// Lấy thông tin người dùng
$userId = $_SESSION["id"];
$userRole = $_SESSION["role"];

$sql = "SELECT 
        doanvien.id AS doanvien_id,
        doanvien.ho_ten,
        doanvien.gioi_tinh,
        doanvien.ngay_sinh,
        doanvien.khoa,
        doanvien.email,
        doanvien.sdt,
        doanvien.chuc_vu,
        doanvien.nienkhoa,
        chidoan.ten_chidoan,
        lop.ten_lop
        FROM doanvien
        INNER JOIN chidoan ON doanvien.chidoan_id = chidoan.id
        INNER JOIN lop ON doanvien.lop_id = lop.id
        WHERE doanvien.id = ?";

$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $userId);
$stmt->execute();
$result = $stmt->get_result();
$userInfo = $result->fetch_assoc();
$stmt->close();
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
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="Dashboard.css">
    <title>Hồ sơ Đoàn viên</title>
</head>

<body>
    <!-- Nav rời ở đây -->
    <?php include "Navbar.php" ?>
    <?php include "contact.php" ?>


    <div class="container-fluid" id="Web-Introduce" style="padding-left: 0px; padding-right: 0px">
        <div id="carouselExampleIndicators" class="carousel slide" data-bs-ride="carousel">
            <!-- Chấm tròn chỉ báo -->
            <div class="carousel-indicators">
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="0" class="active"></button>
                <button type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide-to="1"></button>
            </div>

            <!-- Ảnh chuyển động -->
            <div class="carousel-inner" id="picture-container">
                <!-- tỉ lệ ảnh 1:0.36 -->
                <div class="carousel-item active" data-bs-ride="false">
                    <img src="DashBoardIMG/pic1.png" class="d-block w-100" alt="Banner 1">
                </div>
                <div class="carousel-item" data-bs-ride="false">
                    <img src="DashBoardIMG/pic2.jpg" class="d-block w-100" alt="Banner 2">
                </div>
            </div>

            <!-- Mũi tên điều hướng -->
            <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="prev">
                <span class="carousel-control-prev-icon"></span>
            </button>
            <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleIndicators" data-bs-slide="next">
                <span class="carousel-control-next-icon"></span>
            </button>
        </div>

    </div>
    <div class="container-fluid" id="info-container">
        <div id="Introduce">
            <hr style="width: 80%">
            <h4>GIỚI THIỆU</h4>
            <p>Đoàn Thanh niên Cộng sản Hồ Chí Minh Trường Đại học Hàng hải Việt Nam là tổ chức chính trị – xã hội của sinh viên, trực thuộc Thành đoàn Hải Phòng. Với cơ cấu gồm 4 cấp, Đoàn trường giữ vai trò nòng cốt trong công tác giáo dục chính trị và tổ chức phong trào sinh viên.</p>
            <p>Đoàn trường nhiều năm liền được Trung ương Đoàn và Thành đoàn Hải Phòng công nhận là đơn vị xuất sắc. Các hoạt động nổi bật gồm "Sinh viên 5 tốt", chiến dịch tình nguyện, hiến máu, hội thao và các cuộc thi truyền thống. Tại Đại hội lần thứ 41 (2024–2027), Đoàn tiếp tục nhận cờ thi đua xuất sắc từ Thành đoàn.</p>
            <p>Với khẩu hiệu "Tuổi trẻ Đại học Hàng hải thi đua học tập, rèn luyện", Đoàn trường luôn đổi mới nội dung, phương thức hoạt động, góp phần xây dựng môi trường học tập năng động và sáng tạo cho sinh viên.</p>
            <hr style="width: 80%; margin-top: 40px">
            <h4>VỀ QUẢN LÝ</h4>
            <p>Quản lý đoàn viên là nhiệm vụ trọng tâm của Đoàn Thanh niên Trường Đại học Hàng hải Việt Nam, nhằm xây dựng tổ chức vững mạnh và phát huy vai trò xung kích của sinh viên.Các chi đoàn được tổ chức theo lớp, việc quản lý thực hiện qua phần mềm đồng bộ, giúp cập nhật thông tin, đánh giá và triển khai hoạt động hiệu quả.</p>
            <p>Công tác phân loại đoàn viên cuối năm được thực hiện minh bạch, là cơ sở xét khen thưởng và giới thiệu kết nạp Đảng, góp phần xây dựng hình ảnh sinh viên năng động, trách nhiệm.</p>
        </div>
        <div id="info-pic-container">
            <hr width="80%">
            <h4>HÌNH ẢNH</h4>
            <div id="YouthUnionPics" class="carousel slide" data-bs-ride="carousel">
                <!-- Chấm tròn chỉ báo -->
                <div class="carousel-indicators">
                    <button type="button" data-bs-target="#YouthUnionPics" data-bs-slide-to="0" class="active"></button>
                    <button type="button" data-bs-target="#YouthUnionPics" data-bs-slide-to="1"></button>
                    <button type="button" data-bs-target="#YouthUnionPics" data-bs-slide-to="2"></button>+
                </div>
                <div class="carousel-inner" id="picture-container-info">
                    <!-- tỉ lệ ảnh 1:0.36 -->
                    <div class="carousel-item active info-pic1">
                        <img src="IntroIMG/pic1.jpg" class="d-block w-100 intro_pic" alt="Banner 1">
                    </div>
                    <div class="carousel-item info-pic1">
                        <img src="IntroIMG/pic2.jpg" class="d-block w-100 intro_pic" alt="Banner 2">
                    </div>
                    <div class="carousel-item info-pic1">
                        <img src="IntroIMG/pic3.jpg" class="d-block w-100 intro_pic" alt="Banner 3">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div id="selection-container">
        <div class="row" id="option">
            <div id="selection-title">
                <h3 style="font-weight: bold;">QUẢN LÝ HOẠT ĐỘNG VÀ THÔNG TIN ĐOÀN VIÊN THANH NIÊN</h3>
            </div>
            <div class="col-md-3">
                <a style="text-decoration: none;">
                    <div class="option-selection" id="option-personal"><i class="bi bi-person" onclick="loadPage('account.php')"></i>TÀI KHOẢN</div>
                </a>
            </div>
            <?php if ($userRole === 'admin'): ?>
            <div class="col-md-3">
                <a style="text-decoration: none;">
                    <div class="option-selection" id="option-personal"><i class="bi bi-list-check" onclick="loadPage('Manage.php')"></i>QUẢN LÝ</div>
                </a>
            </div>
            <?php endif; ?>
            <div class="col-md-3">
                <a style="text-decoration: none;">
                    <div class="option-selection" id="option-group"><i class="bi bi-list-task"></i>HOẠT ĐỘNG</div>
                </a>
            </div>
            <div class="col-md-3">
                <a style="text-decoration: none;">
                    <div class="option-selection" id="option-note"><i class="bi bi-chat-left"></i>THÔNG BÁO</div>
                </a>
            </div>

        </div>
    </div>
    <div class="container-fluid" id="footer">
        <div class="footer-container">
            <h5>Đoàn thanh niên trường Đại học Hàng hải Việt Nam</h5>
            <hr style="width: 80%">
            <p>Địa chỉ: Nhà A9 – ĐH Hàng hải Việt Nam Số 484 Lạch Tray, Ngô Quyền, Hải Phòng.</p>
            <p>Số điện thoại: 031 350 1346</p>
            <p>Email: info@vimaru.edu.vn</p>
            <a href="">
                <i class="bi bi-facebook"></i> Trang Facebook chính thức của Đoàn thanh niên trường Đại học Hàng hải Việt Nam
            </a>
        </div>
        <div class="footer-container" id = "footer-role-intro">
            <h5>Trang web này dành cho</h5>
            <hr style="width: 80%">
            <ul>
                <li>Đoàn viên trường Đại học Hàng hải Việt Nam</li>
                <li>Quản lý đoàn viên</li>
                <li>Cán bộ Đoàn</li>
            </ul>

            <h5 style="margin-top: 40px;">Chức năng</h5>
            <hr style="width: 80%">
            <ul>
                <li><a onclick="loadPage('Manage.php')">Quản lý hồ sơ Đoàn viên</a></li>
                <li><a href="">Thông báo tin tức</a></li>
                <li><a href="">Hoạt động Đoàn</a></li>
            </ul>
        </div>
        <div class="footer-container" id = "footer-list-container">
            <h5>Các liên chi Đoàn thanh niên</h5>
            <hr style="width: 80%">
            <ul>
                <li>Liên chi đoàn Khoa Hàng hải</li>
                <li>Liên chi đoàn Khoa Máy tàu biển</li>
                <li>Liên chi đoàn Khoa Điện - Điện tử</li>
                <li>Liên chi đoàn Khoa Đóng tàu</li>
                <li>Liên chi đoàn Viện Cơ khí</li>
                <li>Liên chi đoàn Khoa Công trình</li>
                <li>Liên chi đoàn Viện Môi trường</li>
                <li>Liên chi đoàn Khoa Kinh tế</li>
                <li>Liên chi đoàn Khoa Công nghệ thông tin</li>
                <li>Liên chi đoàn Khoa Ngoại ngữ</li>
                <li>Liên chi đoàn Viện Đào tạo quốc tế</li>
                <li>Liên chi đoàn Viện Đào tạo chất lượng cao</li>
                <li>Liên chi đoàn Khoa Quản trị Tài chính</li>
            </ul>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="index.js"></script>

<script>
    // Gán session PHP vào localStorage
    localStorage.setItem("myID", "<?php echo htmlspecialchars($_SESSION['id'], ENT_QUOTES); ?>");
    localStorage.setItem("myRole", "<?php echo htmlspecialchars($_SESSION['role'], ENT_QUOTES); ?>");
    localStorage.setItem("userInfo", JSON.stringify(<?php echo json_encode($userInfo); ?>));

    // Kiểm tra giá trị trong console
    console.log({
        myID: localStorage.getItem("myID"),
        myRole: localStorage.getItem("myRole"),
        userInfo: JSON.parse(localStorage.getItem("userInfo"))
    });
</script>

</html>