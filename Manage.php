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
                            <th scope="col">Email</th>
                        </tr>
                    </thead>
                    <tbody id="show-data-here">
                        <!-- Kết quả sẽ được chèn vào đây bởi AJAX -->
                    </tbody>
                </table>
                <div style="align-self: end">
                    <nav aria-label="Page navigation" id="page-div">
                        <ul class="pagination" style="margin: 0;">
                            <!-- Phân trang sẽ được chèn vào đây bởi AJAX -->
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
<script>
    document.getElementById('get-depart').addEventListener('change', function() {
        const selectedKhoa = this.value;
        const classSelect = document.getElementById('get-class-list');
        const optgroups = classSelect.querySelectorAll('optgroup');

        if (selectedKhoa === "none") {
            optgroups.forEach(group => group.style.display = 'block');
        } else {
            const khoaMap = {
                "1": "Khoa Công nghệ thông tin",
                "2": "Khoa Hàng hải",
                "3": "Khoa Kinh tế",
                "4": "Khoa Quản trị - Tài chính"
            };

            optgroups.forEach(group => {
                if (group.label === khoaMap[selectedKhoa]) {
                    group.style.display = 'block';
                } else {
                    group.style.display = 'none';
                }
            });

            classSelect.selectedIndex = 0;
        }
    });
</script>
<script>
    window.addEventListener('scroll', function() {
        var div = document.getElementById('floatingDiv');
        var scrollTop = window.scrollY || window.pageYOffset;
        div.style.top = (100 + scrollTop) + 'px'; // giữ khoảng cách 100px với đầu trang
    });
</script>
<script>
    function resetPage() {
        window.location.reload();
    }
</script>
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const signUp = document.getElementById("SignUp");
        const filter = document.getElementById("filter");

        if (signUp) {
            signUpModal = new bootstrap.Modal(signUp);
        }
        if (filter) {
            filterModal = new bootstrap.Modal(filter);
        }

    });

    function loadSignUpModal() {
        if (signUpModal) signUpModal.show();
    }

    function loadFilter() {
        if (filterModal) filterModal.show();
    }
</script>

</html>