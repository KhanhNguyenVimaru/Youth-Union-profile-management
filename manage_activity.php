<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hoạt động</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="icon" type="image/x-icon" href="https://upload.wikimedia.org/wikipedia/vi/0/09/Huy_Hi%E1%BB%87u_%C4%90o%C3%A0n.png">
    <link rel="stylesheet" href="nav.css">
    <style>
        :root {
            --mainBlue: #2832c2;
            --baseFont: bahnschrift;
            --fontGray: #6a6a6a;
            --backGroundGray: #dddddd;
            --whiteGray: #f2f3f5;
            --footer: #27304D;
        }

        body {
            font-family: var(--baseFont);
            font-size: 16px;
        }

        .container{
            margin: 0;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        #main-container {
            padding: 20px;
            margin-top: 0px;
            font-family: var(--baseFont);
            width: 90%;
            margin: 0 auto;
        }

        .activity-card {
            margin-bottom: 20px;
            transition: transform 0.2s;
            border: 1px solid #dee2e6;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
            border-radius: 8px;
        }

        .activity-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .status-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            font-size: 0.8rem;
            padding: 5px 10px;
            border-radius: 20px;
        }

        .activity-info {
            margin-top: 10px;
            color: #6c757d;
        }

        .activity-info p {
            margin-bottom: 8px;
            font-size: 0.9rem;
        }

        .activity-info i {
            width: 20px;
            margin-right: 8px;
            color: #3498db;
        }

        .participants-list {
            max-height: 150px;
            overflow-y: auto;
            padding: 10px;
            background-color: #f8f9fa;
            border-radius: 4px;
            font-size: 0.9rem;
        }

        .filter-section {
            background-color: #fff;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            margin-bottom: 20px;
            padding: 20px;
        }

        .page-title {
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: 600;
            font-size: 1.8rem;
        }

        .form-label {
            font-weight: 500;
            color: #2c3e50;
            margin-bottom: 8px;
        }

        .form-control,
        .form-select {
            border-radius: 6px;
            border: 1px solid #dee2e6;
            padding: 8px 12px;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .modal-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid #dee2e6;
        }

        .modal-title {
            font-weight: 600;
            color: #2c3e50;
        }

        .card-title {
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 15px;
        }

        .page-title {
            font-family: var(--baseFont);
            font-size: 16px;
            color: #2832c2;
        }
        .handle-button button{
            font-family: var(--baseFont);
            font-size: 16px;
        }
        .form-select{
            font-family: var(--baseFont);
            font-size: 16px;
        }
        #handle-event-container input{
            height: 40px !important;
            font-family: var(--baseFont);
            font-size: 16px;
        }
        .table {
            font-family: var(--baseFont);
            color: var(--fontGray);
        }   
        .table thead th {
            background-color: #f8f9fa;
            border-bottom: 2px solid #dee2e6;
            font-family: var(--baseFont);
            font-size: 15px;
            font-weight: bold;
            color: #6a6a6a;
            padding: 12px;
            text-align: center;
            vertical-align: middle;
        }
        .table td {
            vertical-align: middle;
            font-family: var(--baseFont);
            font-size: 15px;
            color: var(--fontGray);
            padding: 12px;
            text-align: center;
        }
        .table tbody tr {
            cursor: default;
            transition: background-color 0.2s;
        }
        .table tbody tr:hover {
            background-color: var(--whiteGray);
        }
        .table tbody tr td:first-child {
            text-align: center;
        }
        .table tbody tr td:nth-child(2) {
            text-align: center;
        }
        .table tbody tr td:nth-child(3) {
            text-align: center;
        }
        .table tbody tr td:nth-child(4) {
            text-align: center;
        }
        .table tbody tr td:nth-child(5) {
            text-align: center;
        }
        .table tbody tr td:nth-child(6) {
            text-align: center;
        }
        .table tbody tr td:nth-child(7) {
            text-align: center;
        }
        .table tbody tr td:nth-child(8) {
            text-align: center;
        }
        .table tbody tr td:nth-child(9) {
            text-align: center;
        }
        .status-badge {
            padding: 5px 10px;
            border-radius: 15px;
            font-size: 0.85em;
            font-family: var(--baseFont);
        }
        .status-pending {
            background-color: #ffc107;
            color: #000;
        }
        .status-approved {
            background-color: #28a745;
            color: #fff;
        }
        .status-completed {
            background-color: #6c757d;
            color: #fff;
        }
        .action-buttons {
            display: flex;
            gap: 5px;
            justify-content: center;
        }
        .action-buttons .btn {
            padding: 0.25rem 0.5rem;
            font-family: var(--baseFont);
            font-size: 15px;
            border-width: 1px;
        }
        .action-buttons .btn-outline-primary {
            color: var(--mainBlue);
            border-color: var(--mainBlue);
        }
        .action-buttons .btn-outline-primary:hover {
            background-color: var(--mainBlue);
            color: white;
        }
        .action-buttons .btn-outline-danger {
            color: #dc3545;
            border-color: #dc3545;
        }
        .action-buttons .btn-outline-danger:hover {
            background-color: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <!-- Navbar -->
    <?php include "Navbar.php" ?>

    <div id="main-container">
        <div class="container">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Quản lý hoạt động</h2>
                <button class="btn btn-primary" onclick="loadAddActivityModal()">
                    <i class="bi bi-plus-lg"></i> Thêm hoạt động mới
                </button>
            </div>

            <div class="card mb-4">
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <select class="form-select" id="status-filter" onchange="filterActivities()">
                                <option value="">Tất cả trạng thái</option>
                                <option value="chờ duyệt">Chờ duyệt</option>
                                <option value="đã duyệt">Đã duyệt</option>
                                <option value="đã kết thúc">Đã kết thúc</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <select class="form-select" id="type-filter" onchange="filterActivities()">
                                <option value="">Tất cả loại hoạt động</option>
                                <option value="hocTap">Học tập</option>
                                <option value="vanNghe">Văn nghệ</option>
                                <option value="theThao">Thể thao</option>
                                <option value="tinhNguyen">Tình nguyện</option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <div class="input-group">
                                <input type="text" class="form-control" id="search-input" placeholder="Tìm kiếm hoạt động..." onkeyup="filterActivities()">
                                <button class="btn btn-outline-secondary" type="button">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>STT</th>
                            <th>Tên hoạt động</th>
                            <th>Ngày tổ chức</th>
                            <th>Địa điểm</th>
                            <th>Loại hoạt động</th>
                            <th>Số lượng tham gia</th>
                            <th>Điểm</th>
                            <th>Trạng thái</th>
                            <th>Thao tác</th>
                        </tr>
                    </thead>
                    <tbody id="activities-container">
                        <!-- Activities will be loaded here -->
                    </tbody>
                </table>
        </div>
    </div>

    <!-- Add Activity Modal -->
    <div class="modal fade" id="addActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Thêm hoạt động mới</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="addActivityForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tên hoạt động</label>
                                <input type="text" class="form-control" id="activity-name" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày tổ chức</label>
                                <input type="datetime-local" class="form-control" id="activity-date" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa điểm</label>
                                <input type="text" class="form-control" id="activity-location" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Loại hoạt động</label>
                                <select class="form-select" id="activity-type" required>
                                    <option value="">Chọn loại hoạt động</option>
                                    <option value="hocTap">Học tập</option>
                                    <option value="vanNghe">Văn nghệ</option>
                                    <option value="theThao">Thể thao</option>
                                    <option value="tinhNguyen">Tình nguyện</option>
                                </select>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số lượng tối đa</label>
                                <input type="number" class="form-control" id="activity-capacity" required>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Điểm</label>
                                <input type="number" class="form-control" id="activity-points" required>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" id="activity-content" rows="4" required></textarea>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                    <button type="button" class="btn btn-primary" onclick="saveActivity()">Lưu</button>
                </div>
            </div>
        </div>
    </div>

    <!-- View Activity Modal -->
    <div class="modal fade" id="viewActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết hoạt động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <div id="activity-details"></div>
                    <hr>
                    <h6>Danh sách tham gia</h6>
                    <div id="participants-list"></div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Detail Activity Modal -->
    <div class="modal fade" id="detailActivityModal" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Chi tiết hoạt động</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="detailActivityForm">
                        <div class="row g-3">
                            <div class="col-md-6">
                                <label class="form-label">Tên hoạt động</label>
                                <input type="text" class="form-control" id="detail-activity-name" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày tổ chức</label>
                                <input type="text" class="form-control" id="detail-activity-date" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Địa điểm</label>
                                <input type="text" class="form-control" id="detail-activity-location" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Loại hoạt động</label>
                                <input type="text" class="form-control" id="detail-activity-type" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Số lượng tham gia</label>
                                <input type="text" class="form-control" id="detail-activity-capacity" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Điểm</label>
                                <input type="text" class="form-control" id="detail-activity-points" readonly>
                            </div>
                            <div class="col-12">
                                <label class="form-label">Nội dung</label>
                                <textarea class="form-control" id="detail-activity-content" rows="4" readonly></textarea>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Trạng thái</label>
                                <input type="text" class="form-control" id="detail-activity-status" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Ngày tạo</label>
                                <input type="text" class="form-control" id="detail-activity-created" readonly>
                            </div>
                            <div class="col-md-6">
                                <label class="form-label">Người tạo</label>
                                <input type="text" class="form-control" id="detail-activity-creator" readonly>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Đóng</button>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="index.js"></script>
    <script src="activity.js"></script>
    <script>
        // Function to validate form data
        function validateActivityForm() {
            const name = document.getElementById('activity-name').value.trim();
            const date = document.getElementById('activity-date').value;
            const content = document.getElementById('activity-content').value.trim();
            const points = parseInt(document.getElementById('activity-points').value);
            const location = document.getElementById('activity-location').value.trim();
            const type = document.getElementById('activity-type').value;
            const capacity = parseInt(document.getElementById('activity-capacity').value);

            const errors = [];

            if (!name) errors.push('Tên hoạt động không được để trống');
            if (!date) errors.push('Ngày tổ chức không được để trống');
            if (!content) errors.push('Nội dung không được để trống');
            if (!location) errors.push('Địa điểm không được để trống');
            if (!type) errors.push('Loại hoạt động không được để trống');
            if (points < 0) errors.push('Điểm không được âm');
            if (capacity <= 0) errors.push('Số lượng tham gia phải lớn hơn 0');

            // Validate date is not in the past
            const selectedDate = new Date(date);
            const now = new Date();
            if (selectedDate < now) {
                errors.push('Ngày tổ chức không được trong quá khứ');
            }

            return errors;
        }

        // Function to save activity
        function saveActivity() {
            // Validate form data
            const errors = validateActivityForm();
            if (errors.length > 0) {
                alert(errors.join('\n'));
                return;
            }

            const formData = new FormData();
            
            // Get form values
            formData.append('ten_hoat_dong', document.getElementById('activity-name').value.trim());
            formData.append('ngay_to_chuc', document.getElementById('activity-date').value);
            formData.append('noi_dung', document.getElementById('activity-content').value.trim());
            formData.append('diem', document.getElementById('activity-points').value);
            formData.append('dia_diem', document.getElementById('activity-location').value.trim());
            formData.append('loai_hoat_dong', document.getElementById('activity-type').value);
            formData.append('so_luong_tham_gia', document.getElementById('activity-capacity').value);
            
            // Add user ID if available (you might want to get this from your session)
            const userId = 1; // Replace with actual user ID from session
            formData.append('nguoi_tao', userId);

            // Send request to save activity
            fetch('save_activity.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    // Close modal and reload page
                    const modal = bootstrap.Modal.getInstance(document.getElementById('addActivityModal'));
                    modal.hide();
                    location.reload();
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi lưu hoạt động');
            });
        }

        // Helper function to format date for datetime-local input
        function formatDateForInput(dateStr) {
            // Parse the date string (assuming format: DD/MM/YYYY HH:mm)
            const [datePart, timePart] = dateStr.split(' ');
            const [day, month, year] = datePart.split('/');
            const [hours, minutes] = timePart ? timePart.split(':') : ['00', '00'];
            
            // Create date object with local timezone
            const date = new Date(year, month - 1, day, hours, minutes);
            
            // Format to YYYY-MM-DDThh:mm
            const year2 = date.getFullYear();
            const month2 = String(date.getMonth() + 1).padStart(2, '0');
            const day2 = String(date.getDate()).padStart(2, '0');
            const hours2 = String(date.getHours()).padStart(2, '0');
            const minutes2 = String(date.getMinutes()).padStart(2, '0');
            
            return `${year2}-${month2}-${day2}T${hours2}:${minutes2}`;
        }

        // Remove the table click event listener
        document.addEventListener('DOMContentLoaded', function() {
            const table = document.querySelector('table');
            if (table) {
                table.removeEventListener('click', function(e) {
                    const row = e.target.closest('tr');
                    if (row && !row.querySelector('.action-buttons')) {
                        const id = row.dataset.id;
                        if (id) {
                            viewActivity(id);
                        }
                    }
                });
            }
        });

        // Function to delete activity
        function deleteActivity(activityId) {
            const formData = new FormData();
            formData.append('activity_id', activityId);

            fetch('delete_activity.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    alert(data.message);
                    location.reload(); // Reload page to update table
                } else {
                    alert(data.message);
                }
            })
            .catch(error => {
                console.error('Error:', error);
                alert('Có lỗi xảy ra khi xóa hoạt động');
            });
        }

        // Function to load activity details
        function loadActivityDetail(activityId) {
            fetch(`get_activity_detail.php?id=${activityId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const activity = data.data;
                        
                        // Populate modal with activity data
                        document.getElementById('detail-activity-name').value = activity.ten_hoat_dong;
                        document.getElementById('detail-activity-date').value = activity.ngay_to_chuc;
                        document.getElementById('detail-activity-location').value = activity.dia_diem;
                        document.getElementById('detail-activity-type').value = activity.loai_hoat_dong;
                        document.getElementById('detail-activity-capacity').value = activity.so_luong_tham_gia;
                        document.getElementById('detail-activity-points').value = activity.diem;
                        document.getElementById('detail-activity-content').value = activity.noi_dung;
                        document.getElementById('detail-activity-status').value = activity.trang_thai;
                        document.getElementById('detail-activity-created').value = activity.ngay_tao;
                        document.getElementById('detail-activity-creator').value = activity.nguoi_tao;
                        
                        // Show the modal
                        const detailModal = new bootstrap.Modal(document.getElementById('detailActivityModal'));
                        detailModal.show();
                    } else {
                        alert(data.message);
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    alert('Có lỗi xảy ra khi tải thông tin hoạt động');
                });
        }
    </script>
</body>

</html>