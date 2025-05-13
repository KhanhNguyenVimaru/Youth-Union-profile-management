    <?php
    session_start();

    // Check if user is not logged in
    if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
        header("Location: Login.php");
        exit();
    }

    // Check if user has required role
    // if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'canbodoan')) {
    //     echo "<script>
    //         alert('Bạn không có quyền truy cập trang này!');
    //         window.location.href = 'dashboard.php';
    //     </script>";
    //     exit();
    // }
    ?>
    <!DOCTYPE html>
    <html lang="vi">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Quản lý thông báo</title>
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
            integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
        <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/vi/0/09/Huy_Hi%E1%BB%87u_%C4%90o%C3%A0n.png">
        <link rel="stylesheet" href="nav.css">
        <link rel="stylesheet" href="Manage.css">
        <style>
            body {
                font-family: Bahnschrift;
                background-color: #f1f3f5;
            }

            .notify-wrapper {
                width: 90%;
                max-width: 1600px;
                margin: 20px auto;
            }

            .notify-bar {
                background-color: #f8f9fa;
                padding: 10px 50px;
                border-radius: 8px;
                font-weight: normal;
                font-size: 1rem;
                height: auto;
            }

            #database-handle {
                display: flex;
                justify-content: space-between;
                align-items: center;
            }

            #users-data-container {
                background: #fff;
                padding: 20px;
                border-radius: 8px;
            }

            .table-col {
                background-color: #f8f9fa;
            }

            .container {
                display: flex;
                justify-content: center;
                margin-top: 20px;
            }
        </style>
    </head>

    <body>
        <?php include "Navbar.php" ?>
        <div class="notify-wrapper">
            <div class="notify-bar">
                <div id="database-handle">
                    <h5>DANH SÁCH THÔNG BÁO</h5>
                    <div style="display: flex; width: auto;margin-left: auto;">
                        <input type="text" class="form-control" style="width: 200px; margin-right: 10px;" placeholder="Tìm kiếm thông báo...">
                        <button type="button" class="btn btn-secondary" id="reset-list-btn" onclick="resetPage()">
                            <i class="bi bi-arrow-clockwise"></i>
                            Reset
                        </button>
                        <button type="button" class="btn btn-secondary" style="margin-left: 10px;" id="filter-list-btn">
                            <i class="bi bi-filter"></i>
                            Filter
                        </button>
                    </div>
                </div>

                <div id="users-data-container">
                    <table class="table table-hover" id="users-data-board">
                        <thead>
                            <tr class="table-col">
                                <th scope="col" style="width: 10%;">Mã thông báo</th>
                                <th scope="col" style="width: 10%;">Người tạo</th>
                                <th scope="col" style="width: 15%;">Loại hoạt động</th>
                                <th scope="col" style="width: 45%;">Nội dung</th>
                                <th scope="col" style="width: 20%;">Thời gian</th>
                            </tr>
                        </thead>
                        <tbody id="show-history-data-here">
                            <!-- Kết quả sẽ được chèn vào đây bởi AJAX -->
                        </tbody>
                    </table>
                </div>
                <!-- Add pagination controls -->
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center" id="pagination-controls">
                        <li class="page-item">
                            <a class="page-link" href="#" id="prev-page" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <!-- Page numbers will be inserted here -->
                        <li class="page-item">
                            <a class="page-link" href="#" id="next-page" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>

        <!-- Add Filter Modal -->
        <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="filterModalLabel">BỘ LỌC THÔNG BÁO</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Từ ngày:</label>
                            <input type="date" class="form-control" id="startDate">
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">Đến ngày:</label>
                            <input type="date" class="form-control" id="endDate">
                        </div>
                        <div class="mb-3">
                            <label for="activityType" class="form-label">Loại hoạt động:</label>
                            <select class="form-select" id="activityType">
                                <option value="all">Tất cả</option>
                                <option value="insert">Thêm mới</option>
                                <option value="change">Cập nhật</option>
                                <option value="delete">Xóa</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="searchContent" class="form-label">Tìm kiếm nội dung:</label>
                            <input type="text" class="form-control" id="searchContent" placeholder="Nhập từ khóa...">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                        <button type="button" class="btn btn-primary" id="applyFilter">Áp dụng</button>
                    </div>
                    // ... existing code ...
                    </table>
                </div>
                <!-- Add pagination controls -->
                <nav aria-label="Page navigation" class="mt-3">
                    <ul class="pagination justify-content-center" id="pagination-controls">
                        <li class="page-item">
                            <a class="page-link" href="#" id="prev-page" aria-label="Previous">
                                <span aria-hidden="true">&laquo;</span>
                            </a>
                        </li>
                        <!-- Page numbers will be inserted here -->
                        <li class="page-item">
                            <a class="page-link" href="#" id="next-page" aria-label="Next">
                                <span aria-hidden="true">&raquo;</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </div>
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
        <script src="index.js"></script>
        <script src="load_notify.js"></script>
        <script>
            function resetPage() {
                window.location.reload();
            }
        </script>
    </body>

    </html>