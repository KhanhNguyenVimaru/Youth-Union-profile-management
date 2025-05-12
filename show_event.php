<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh sách hoạt động</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css">
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/vi/0/09/Huy_Hi%E1%BB%87u_%C4%90o%C3%A0n.png">
    <link rel="stylesheet" href="nav.css">
    <style>
        body {
            font-family: Bahnschrift;
            background-color: #f1f3f5;
        }

        .event-wrapper {
            width: 90%;
            max-width: 1600px;
            margin: 20px auto;
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            padding: 20px;
            padding-top: 0px;
        }

        .event-header {
            display: flex;
            justify-content: center;
            align-items: center;
            margin-bottom: 20px;
        }

        .header-content {
            width: 100%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background-color: white;
        }

        .event-container {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 20px;
            padding: 20px 0;
        }

        .event-card {
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
            transition: transform 0.2s;
        }

        .event-card:hover {
            transform: translateY(-5px);
        }

        .event-card .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 8px 8px 0 0;
        }

        .event-card .card-body {
            padding: 15px;
        }

        .event-card .card-footer {
            background-color: #f8f9fa;
            border-top: 1px solid #dee2e6;
            padding: 15px;
            border-radius: 0 0 8px 8px;
        }

        .event-status {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.9em;
            font-weight: 500;
        }

        .status-pending {
            background-color: #ffeeba;
            color: #856404;
        }

        .status-approved {
            background-color: #d4edda;
            color: #155724;
        }

        .status-completed {
            background-color: #cce5ff;
            color: #004085;
        }

        .search-container {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            margin-left: auto;
        }

        .filter-btn {
            display: flex;
            align-items: center;
            gap: 5px;
            width: 120px;
        }
        #resetListBtn{
            width: 160px;
        }
        #filterBtn{
            width:  160px;
        }

        .btn-sm {
            font-size: 16px !important;
            width: 120px;
        }
    </style>
</head>

<body>
    <?php include "Navbar.php" ?>

    <div class="event-wrapper">
        <div class="event-header">
            <div class="header-content">
                <h5 class="mb-0">DANH SÁCH HOẠT ĐỘNG</h5>
                <div class="search-container" style = "margin-top: 20px">
                    <input type="text" class="form-control" id="searchEvent" placeholder="Tìm kiếm hoạt động...">
                    <button type="button" class="btn btn-secondary" id="resetListBtn" onclick="resetPage()">
                        <i class="bi bi-arrow-clockwise"></i>
                        Reset
                    </button>
                    <button type="button" class="btn btn-secondary filter-btn" id="filterBtn">
                        <i class="bi bi-filter"></i>
                        Filter
                    </button>
                </div>
            </div>
        </div>

        <div class="event-container" id="eventContainer">
            <!-- Event cards will be loaded here -->
        </div>
    </div>

    <!-- Filter Modal -->
    <div class="modal fade" id="filterModal" tabindex="-1" aria-labelledby="filterModalLabel">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="filterModalLabel">BỘ LỌC HOẠT ĐỘNG</h5>
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
                        <label for="eventType" class="form-label">Loại hoạt động:</label>
                        <select class="form-select" id="eventType">
                            <option value="all">Tất cả</option>
                            <option value="Văn nghệ">Văn nghệ</option>
                            <option value="Thể thao">Thể thao</option>
                            <option value="Tình nguyện">Tình nguyện</option>
                            <option value="Học thuật">Học thuật</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="eventStatus" class="form-label">Trạng thái:</label>
                        <select class="form-select" id="eventStatus">
                            <option value="all">Tất cả</option>
                            <option value="chờ duyệt">Chờ duyệt</option>
                            <option value="đã duyệt">Đã duyệt</option>
                            <option value="đã kết thúc">Đã kết thúc</option>
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" id="applyFilter">Áp dụng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Modal -->
    <div class="modal fade" id="detailModal" tabindex="-1" aria-labelledby="detailModalLabel">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="detailModalLabel">CHI TIẾT HOẠT ĐỘNG</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-md-6">
                            <p><strong>Tên hoạt động:</strong> <span id="detail-name"></span></p>
                            <p><strong>Loại hoạt động:</strong> <span id="detail-type"></span></p>
                            <p><strong>Thời gian:</strong> <span id="detail-date"></span></p>
                            <p><strong>Địa điểm:</strong> <span id="detail-location"></span></p>
                        </div>
                        <div class="col-md-6">
                            <p><strong>Người tổ chức:</strong> <span id="detail-organizer"></span></p>
                            <p><strong>Số lượng tham gia:</strong> <span id="detail-capacity"></span></p>
                            <p><strong>Điểm:</strong> <span id="detail-points"></span></p>
                            <p><strong>Trạng thái:</strong> <span id="detail-status"></span></p>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <p><strong>Nội dung:</strong></p>
                            <p id="detail-content" class="border rounded p-3 bg-light"></p>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
    <script src="load_events.js"></script>
    <script>
        function resetPage() {
            window.location.reload();
        }
    </script>
</body>

</html> 