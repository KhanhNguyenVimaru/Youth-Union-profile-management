<nav class="navbar navbar-expand-lg navbar-light bg-light" id="navbar-container">
<a class="navbar-brand" href="#" id="nav-logo" onclick="loadPage('Dashboard.php')">HỒ SƠ ĐOÀN TRƯỜNG</a>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" onclick="loadPage('Dashboard.php')">Dashboard</a>
            </li>

            <!-- Sửa phần Quản lý tại đây -->
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button"
                   data-bs-toggle="dropdown" aria-expanded="false">
                    Quản lý
                </a>
                <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                    <li><a class="dropdown-item" onclick="loadPage('Manage.php')">Quản lý Đoàn viên</a></li>
                    <li><a class="dropdown-item" onclick="loadPage('manage_activity.php')">Quản lý hoạt động</a></li>
                    <!-- <li><a class="dropdown-item" href="#">Thống kê & Báo cáo</a></li> -->
                </ul>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="#">Hoạt động</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Thông báo</a>
            </li>
        </ul>

        <form class="form-inline my-2 my-lg-0" id="seach-container">
            <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
        </form>

        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" onclick="loadPage('account.php')">Tài khoản</a>
            </li>
        </ul>
    </div>
</nav>  