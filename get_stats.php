<?php
// Include database connection
require_once 'config.php';

// Set header to return JSON response
header('Content-Type: application/json');

try {
    // Total participants
    $sql_total = "SELECT COUNT(DISTINCT doanvien_id) as total FROM thamgia";
    $stmt_total = $conn->prepare($sql_total);
    $stmt_total->execute();
    $total = $stmt_total->get_result()->fetch_assoc()['total'];

    // Average scores by activity
    $sql_avg = "SELECT h.ten_hoat_dong, AVG(t.diem_rieng) as avg_score 
                FROM thamgia t 
                JOIN hoatdong h ON t.hoatdong_id = h.id 
                GROUP BY h.ten_hoat_dong";
    $stmt_avg = $conn->prepare($sql_avg);
    $stmt_avg->execute();
    $avg_result = $stmt_avg->get_result();
    $avg_scores = ['labels' => [], 'data' => []];
    while ($row = $avg_result->fetch_assoc()) {
        $avg_scores['labels'][] = $row['ten_hoat_dong'];
        $avg_scores['data'][] = round($row['avg_score'], 2);
    }

    // Status counts
    $sql_status = "SELECT trang_thai, COUNT(*) as count FROM hoatdong GROUP BY trang_thai";
    $stmt_status = $conn->prepare($sql_status);
    $stmt_status->execute();
    $status_result = $stmt_status->get_result();
    $status_counts = ['labels' => [], 'data' => []];
    while ($row = $status_result->fetch_assoc()) {
        $status_counts['labels'][] = $row['trang_thai'];
        $status_counts['data'][] = $row['count'];
    }

    // Monthly participation (assuming ngay_tham_gia column or using ngay_tao)
    $sql_monthly = "SELECT DATE_FORMAT(ngay_tao, '%m/%Y') as month, COUNT(*) as count 
                    FROM thamgia t 
                    JOIN hoatdong h ON t.hoatdong_id = h.id 
                    GROUP BY DATE_FORMAT(ngay_tao, '%m/%Y')";
    $stmt_monthly = $conn->prepare($sql_monthly);
    $stmt_monthly->execute();
    $monthly_result = $stmt_monthly->get_result();
    $monthly_participation = ['labels' => [], 'data' => []];
    while ($row = $monthly_result->fetch_assoc()) {
        $monthly_participation['labels'][] = 'Th' . $row['month'];
        $monthly_participation['data'][] = $row['count'];
    }

    $data = [
        'totalParticipants' => $total,
        'avgScores' => $avg_scores,
        'statusCounts' => $status_counts,
        'monthlyParticipation' => $monthly_participation
    ];

    echo json_encode($data);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}

// Close statements and connection
if (isset($stmt_total)) $stmt_total->close();
if (isset($stmt_avg)) $stmt_avg->close();
if (isset($stmt_status)) $stmt_status->close();
if (isset($stmt_monthly)) $stmt_monthly->close();
$conn->close();
?>