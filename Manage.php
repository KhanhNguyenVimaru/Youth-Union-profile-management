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
        <div class="user-management-div" id="show-user-data">
            <h5>QUẢN LÝ ĐOÀN VIÊN</h5>

            <div class="search-container" style="display: flex; flex-direction:column;" id="input-filter">
                <input type="text" name="search" id="search-user" placeholder="Nhập thông tin">
                <select name="class-list" id="class-list">
                    <option value="none">Chọn lớp</option>
                    <optgroup label="Khoa Công nghệ thông tin">
                        <option value="cnt">CNT</option>
                        <option value="kpm">KPM</option>
                        <option value="ttm">TTM</option>
                    </optgroup>

                    <optgroup label="Khoa Hàng hải">
                        <option value="hh">HH</option>
                    </optgroup>

                    <optgroup label="Khoa Kinh tế">
                        <option value="ktb">KTB</option>
                        <option value="ktn">KTN</option>
                        <option value="ktl">KTL</option>
                        <option value="ktc">KTC</option>
                        <option value="kth">KTH</option>
                    </optgroup>

                    <optgroup label="Khoa Quản trị - Tài chính">
                        <option value="qkt">QKT</option>
                        <option value="qkd">QKD</option>
                        <option value="qtc">QTC</option>
                    </optgroup>

                </select>
                <select name="aca-year" id="aca-year">
                    <option value="none">Chọn khóa</option>
                    <option value="63">63</option>
                    <option value="64">64</option>
                    <option value="65">65</option>
                </select>
                <select name="uni-branch" id="uni-branch">
                    <option value="none">Chi đoàn</option>
                    <option value="hanghai">Khoa Hàng hải</option>
                    <option value="kinhte">Khoa Kinh tế</option>
                    <option value="cntt">Khoa Công nghệ thông tin</option>
                    <option value="qt_taichinh">Khoa Quản trị - Tài chính</option>
                </select>
                <div style="display: flex; width: 100%; justify-content:space-between">
                    <select name="search-filter" id="search-filter">
                        <option value="" class="opt-filter">
                            <i class="bi bi-filter"></i>
                            Filter
                        </option>
                        <option value="class_name" class="opt-filter">Theo lớp</option>
                        <option value="year-in" class="opt-filter">Theo khóa</option>
                        <option value="group" class="opt-filter">Theo chi đoàn</option>
                        <option value="class_name" class="opt-filter">Theo thời gian</option>
                        <option value="year-in" class="opt-filter">Theo vai trò</option>
                    </select>
                </div>
                <hr style="width: 96%; margin: 10px auto; margin-top:20px">
                <button id="search-btn">
                    <i class="bi bi-search"></i>
                    Tìm kiếm
                </button>

            </div>
        </div>
        <div class="user-management-div" id="show-users-list">
            <div id="database-handle">
                <h5>DANH SÁCH TÀI KHOẢN</h5>
                <div style="margin-left: auto;">
                    <button type="button" class="btn btn-primary" onclick="loadSignUpModal()" id="insert-user-btn">
                        <i class="bi bi-person-plus"></i>
                        Thêm thành viên
                    </button>
                    <button type="button" class="btn btn-secondary" id="reset-list-btn">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>
                </div>
            </div>
        </div>
    </div>
</body>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.5/dist/js/bootstrap.bundle.min.js" integrity="sha384-k6d4wzSIapyDyv1kpU366/PK5hCdSbCRGRCMv+eplOQJWyd1fbcAu9OCUj5zNLiq" crossorigin="anonymous"></script>
<script src="index.js"></script>
<script src="call_modal.js"></script>
<script src="manage_user.js"></script>

</html>