<?php
session_start();

// Check if user is not logged in
if (!isset($_SESSION['id']) || empty($_SESSION['id'])) {
    header("Location: Login.php");
    exit();
}

// Check if user has required role
if (!isset($_SESSION['role']) || ($_SESSION['role'] !== 'admin' && $_SESSION['role'] !== 'canbodoan')) {
    echo "<script>
        alert('Bạn không có quyền truy cập trang này!');
        window.location.href = 'dashboard.php';
    </script>";
    exit();
}
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
    <title>Hồ sơ Đoàn viên</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="index.js"></script>
    <style>
        body {
            margin: 0;
            padding: 0;
            font-family: Bahnschrift, sans-serif;
        }
        .stats-container {
            height: 90vh;
            overflow-y: auto;
            padding: 20px;
            background-color: #f8f9fa;
        }
        .chart-card {
            background: white;
            border-radius: 10px;
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
            padding: 20px;
            margin-bottom: 20px;
        }
        .stat-number {
            font-size: 2rem;
            font-weight: bold;
            color: #007bff;
        }
        canvas {
            max-height: 300px;
        }
    </style>
</head>
<body>
    <?php include "Navbar.php" ?>
    <div class="container-fluid stats-container">
        <h2 class="text-center mb-4" style="font-family: Bahnschrift;">Thống Kê Hoạt Động Đoàn</h2>
        <div class="row">
            <!-- Tổng số đoàn viên tham gia -->
            <div class="col-md-4">
                <div class="chart-card text-center">
                    <h5>Tổng số đoàn viên tham gia</h5>
                    <p class="stat-number" id="totalParticipants">0</p>
                </div>
            </div>
            <!-- Trung bình điểm riêng theo hoạt động -->
            <div class="col-md-4">
                <div class="chart-card">
                    <h5>Trung bình điểm riêng theo hoạt động</h5>
                    <canvas id="avgScoreChart"></canvas>
                </div>
            </div>
            <!-- Số lượng hoạt động theo trạng thái -->
            <div class="col-md-4">
                <div class="chart-card">
                    <h5>Số lượng hoạt động theo trạng thái</h5>
                    <canvas id="statusChart"></canvas>
                </div>
            </div>
            <!-- Số lượng tham gia theo tháng -->
            <div class="col-md-12">
                <div class="chart-card">
                    <h5>Số lượng tham gia theo tháng</h5>
                    <canvas id="monthlyParticipationChart"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Dữ liệu mẫu (thay bằng dữ liệu từ API/database)
        const statsData = {
            totalParticipants: 150,
            avgScores: {
                labels: ['Hè xanh 2025', 'Hội khỏe Phù Đổng', 'Tình nguyện Xanh'],
                data: [85, 65, 90]
            },
            statusCounts: {
                labels: ['Chờ duyệt', 'Đã duyệt', 'Đã kết thúc'],
                data: [5, 10, 3]
            },
            monthlyParticipation: {
                labels: ['Th5 2025', 'Th6 2025', 'Th7 2025'],
                data: [50, 70, 30]
            }
        };

        // Hiển thị tổng số đoàn viên
        document.getElementById('totalParticipants').textContent = statsData.totalParticipants;

        // Biểu đồ trung bình điểm riêng
        const avgScoreChart = new Chart(document.getElementById('avgScoreChart'), {
            type: 'bar',
            data: {
                labels: statsData.avgScores.labels,
                datasets: [{
                    label: 'Điểm trung bình',
                    data: statsData.avgScores.data,
                    backgroundColor: 'rgba(54, 162, 235, 0.6)',
                    borderColor: 'rgba(54, 162, 235, 1)',
                    borderWidth: 1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Biểu đồ số lượng hoạt động theo trạng thái
        const statusChart = new Chart(document.getElementById('statusChart'), {
            type: 'pie',
            data: {
                labels: statsData.statusCounts.labels,
                datasets: [{
                    data: statsData.statusCounts.data,
                    backgroundColor: ['#ff6384', '#36a2eb', '#ffcd56']
                }]
            }
        });

        // Biểu đồ số lượng tham gia theo tháng
        const monthlyParticipationChart = new Chart(document.getElementById('monthlyParticipationChart'), {
            type: 'line',
            data: {
                labels: statsData.monthlyParticipation.labels,
                datasets: [{
                    label: 'Số lượng tham gia',
                    data: statsData.monthlyParticipation.data,
                    fill: false,
                    borderColor: '#4bc0c0',
                    tension: 0.1
                }]
            },
            options: {
                scales: {
                    y: { beginAtZero: true }
                }
            }
        });

        // Hàm để fetch dữ liệu từ server (thay thế dữ liệu mẫu)
        async function loadStats() {
            try {
                const response = await fetch('get_stats.php'); // Giả định endpoint
                if (!response.ok) throw new Error('Network response was not ok');
                const data = await response.json();
                statsData.totalParticipants = data.totalParticipants || 0;
                statsData.avgScores = data.avgScores || statsData.avgScores;
                statsData.statusCounts = data.statusCounts || statsData.statusCounts;
                statsData.monthlyParticipation = data.monthlyParticipation || statsData.monthlyParticipation;

                // Cập nhật giao diện
                document.getElementById('totalParticipants').textContent = statsData.totalParticipants;
                avgScoreChart.data.labels = statsData.avgScores.labels;
                avgScoreChart.data.datasets[0].data = statsData.avgScores.data;
                avgScoreChart.update();
                statusChart.data.labels = statsData.statusCounts.labels;
                statusChart.data.datasets[0].data = statsData.statusCounts.data;
                statusChart.update();
                monthlyParticipationChart.data.labels = statsData.monthlyParticipation.labels;
                monthlyParticipationChart.data.datasets[0].data = statsData.monthlyParticipation.data;
                monthlyParticipationChart.update();
            } catch (error) {
                console.error('Error loading stats:', error);
                alert('Có lỗi xảy ra khi tải thống kê');
            }
        }

        // Load stats when page loads
        document.addEventListener('DOMContentLoaded', loadStats);
    </script>
</body>
</html>