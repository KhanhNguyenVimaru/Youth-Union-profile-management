<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "quanlydoanvien";

// Kết nối tới cơ sở dữ liệu
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$data = json_decode(file_get_contents("php://input"), true);

// Lấy giá trị từ dữ liệu JSON gửi lên
$search = isset($data['search']) ? $data['search'] : '';
$class = isset($data['class']) ? $data['class'] : 'none';
$year = isset($data['year']) ? $data['year'] : 'none';
$branch = isset($data['branch']) ? $data['branch'] : 'none';
$sortOn = isset($data['sortOn']) ? $data['sortOn'] : 'none';
$sortSide = isset($data['sortSide']) ? $data['sortSide'] : 'none';

// Xây dựng câu truy vấn SQL với các điều kiện lọc
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
        WHERE 1";

$param_values = [];
$param_types = '';

// Bảo mật: chuẩn bị câu truy vấn với Prepared Statements
if ($search) {
    $sql .= " AND (doanvien.ho_ten LIKE ? OR doanvien.email LIKE ?)";
    $param_values[] = "%$search%";
    $param_values[] = "%$search%";
    $param_types .= 's'; // Thêm kiểu dữ liệu cho các biến tìm kiếm
}
if ($class != 'none') {
    $sql .= " AND lop.ten_lop = ?";
    $param_values[] = $class;
    $param_types .= 's';
}
if ($year != 'none') {
    $sql .= " AND doanvien.nienkhoa = ?";
    $param_values[] = $year;
    $param_types .= 's';
}
if ($branch != 'none') {
    $sql .= " AND chidoan.ten_chidoan = ?";
    $param_values[] = $branch;
    $param_types .= 's';
}

// Sắp xếp
if ($sortOn != 'none') {
    $sql .= " ORDER BY $sortOn";
    if ($sortSide != 'none') {
        $sql .= " $sortSide";
    }
}

// Chuẩn bị câu truy vấn
$stmt = $conn->prepare($sql);

// Kiểm tra xem có tham số nào cần truyền không
if ($param_types) {
    // Bind các tham số nếu có
    $stmt->bind_param($param_types, ...$param_values);
}

// Thực thi câu truy vấn
$stmt->execute();

// Lấy kết quả
$result = $stmt->get_result();

$users = [];
while ($row = $result->fetch_assoc()) {
    $users[] = $row;
}

// Trả về kết quả dưới dạng JSON
echo json_encode([
    'users' => $users
]);

// Đóng kết nối
$stmt->close();
$conn->close();
?>
