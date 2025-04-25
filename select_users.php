<?php
$severname = "localhost";
$username = "root";
$password = "";
$db_name = "quanlydoanvien";

$conn = new mysqli($severname, $username, $password, $db_name);
if ($conn->error) {
    echo json_encode(["success" => false, "message" => "Lỗi kết nối server"]);
}

// Số dòng mỗi trang
$rowsPerPage = 20;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
if ($page < 1) $page = 1;
$offset = ($page - 1) * $rowsPerPage;

// Query chính
$sql = "SELECT
        doanvien.id AS doanvien_id,
        doanvien.ho_ten,
        doanvien.nienkhoa,
        doanvien.email,
        chidoan.ten_chidoan,
        doanvien.ngay_sinh,
        doanvien.khoa,
        lop.ten_lop
    FROM doanvien
    INNER JOIN chidoan ON doanvien.chidoan_id = chidoan.id
    INNER JOIN lop ON doanvien.lop_id = lop.id
    LIMIT $rowsPerPage OFFSET $offset";

$list = $conn->query($sql);

while ($row = $list->fetch_assoc()) {
    echo '<tr class="st-data">
        <th scope="row">' . $row['doanvien_id'] . '</th>
        <td>' . $row['ho_ten'] . '</td>
        <td>' . $row['ngay_sinh'] . '</td>
        <td>' . $row['ten_lop'] . ' - ' . $row['nienkhoa'] . '</td>
        <td>' . $row['ten_chidoan'] . '</td>
        <td>' . $row['email'] . '</td>
    </tr>';
}

$count_sql = "SELECT COUNT(*) as total FROM doanvien";
$count_result = $conn->query($count_sql);
$total_rows = $count_result->fetch_assoc()['total'];
$total_pages = ceil($total_rows / $rowsPerPage);

$GLOBALS['page'] = $page;
$GLOBALS['total_pages'] = $total_pages;
?>
