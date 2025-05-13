<?php
// Include database connection
require_once 'config.php';

// Set header to return JSON response
header('Content-Type: application/json');

try {
    // Fetch all activities
    $sql_activities = "SELECT * FROM hoatdong";
    $stmt_activities = $conn->prepare($sql_activities);
    $stmt_activities->execute();
    $result_activities = $stmt_activities->get_result();

    $activities = [];
    while ($activity = $result_activities->fetch_assoc()) {
        // Fetch participants for this activity
        $sql_participants = "
            SELECT t.doanvien_id, t.hoatdong_id, t.diem_rieng, d.ho_ten, h.ten_hoat_dong
            FROM thamgia t
            JOIN doanvien d ON t.doanvien_id = d.id
            JOIN hoatdong h ON t.hoatdong_id = h.id
            WHERE t.hoatdong_id = ?
        ";
        $stmt_participants = $conn->prepare($sql_participants);
        $stmt_participants->bind_param("i", $activity['id']);
        $stmt_participants->execute();
        $result_participants = $stmt_participants->get_result();

        $participants = [];
        while ($participant = $result_participants->fetch_assoc()) {
            $participants[] = $participant;
        }

        // Add participants to activity data
        $activity['participants'] = $participants;
        $activities[] = $activity;

        $stmt_participants->close();
    }

    $stmt_activities->close();
    $conn->close();

    // Return activities with participants
    echo json_encode($activities);

} catch (Exception $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>