<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}

// Check if user has required role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin')) {
    echo "<script>
        alert('Bạn không có quyền truy cập trang này!');
        window.location.href = 'dashboard.php';
    </script>";
    exit();
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
    <link rel="stylesheet" href="nav.css">
    <link rel="stylesheet" href="Manage.css">
    <link rel="stylesheet" href="manage_modal.css">
    <title>Hồ sơ Đoàn viên</title>
</head>

<body>
    <!-- nav bar here -->
    <?php include "Navbar.php" ?>
    <?php include "manage_modal.php" ?>
    <div class="container-fluid" id="user-management">

        <div class="user-management-div" id="show-users-list">
            <div id="database-handle">
                <h5>DANH SÁCH TÀI KHOẢN</h5>
                <div style="margin-left: auto;">
                    <button type="button" class="btn btn-primary" onclick="loadSignUpModal()" id="call-modal-signin">
                        <i class="bi bi-person-plus"></i>
                        Thêm thành viên
                    </button>
                    <button type="button" class="btn btn-secondary" id="reset-list-btn" onclick="resetPage()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>
                    <button type="button" class="btn btn-secondary" style="margin-left: 10px;" id="filter-list-btn" onclick="loadFilter()">
                        <i class="bi bi-filter"></i>
                        Filter
                    </button>
                </div>
            </div>
            <div id="users-data-container">
                <table class="table table-hover" id="users-data-board">
                    <thead>
                        <tr class="table-col">
                            <th scope="col">MSV</th>
                            <th scope="col">Họ tên</th>
                            <th scope="col">Ngày sinh</th>
                            <th scope="col">Lớp</th>
                            <th scope="col">Chi đoàn</th>
                            <th scope="col">Số điện thoại</th>
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody id="show-data-here">
                        <!-- Kết quả sẽ được chèn vào đây bởi AJAX -->
                    </tbody>
                </table>
                <div class="pagination-container" style="display: flex; justify-content: center; margin-top: 20px;">
                    <nav aria-label="Page navigation">
                        <ul class="pagination" id="pagination-controls">
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Previous" id="prev-page">
                                    <span aria-hidden="true">&laquo;</span>
                                </a>
                            </li>
                            <li class="page-item">
                                <a class="page-link" href="#" aria-label="Next" id="next-page">
                                    <span aria-hidden="true">&raquo;</span>
                                </a>
                            </li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="index.js"></script>
<script src="manage_user.js"></script>
<script src="modal_handlers.js"></script>
<script>
    function resetPage() {
        window.location.reload();
    }
</script>

</html>