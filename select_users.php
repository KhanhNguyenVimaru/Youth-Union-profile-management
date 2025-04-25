<?php
$severname = "localhost";
$username = "root";
$password = "";
$db_name = "quanlydoanvien";

$conn = new mysqli($severname, $username, $password, $db_name);
if ($conn->error) {
    echo json_encode(["success" => false, "message" => "lỗi kết nối server"]);
}

$sql = ('SELECT
        doanvien.id AS doanvien_id,
        doanvien.ho_ten,
        doanvien.nienkhoa,
        doanvien.email,
        chidoan.ten_chidoan,
        doanvien.khoa,
        lop.ten_lop
    FROM doanvien
    INNER JOIN chidoan ON doanvien.chidoan_id = chidoan.id
    INNER JOIN lop ON doanvien.lop_id = lop.id;
');

$list = $conn->query($sql);

while ($row = $list->fetch_assoc()) {
    echo '<tr class = "st-data">
      <th scope="row">' . $row['doanvien_id'] . '</th>
      <td>' . $row['ho_ten'] . '</td>
      <td>' . $row['ten_lop'] . $row['nienkhoa'] . '</td>
      <td>' . $row['ten_chidoan'] . '</td>
      <td>' . $row['email'] . '</td>
    </tr>';
}


// class doanvien{
//     public $id;
//     public $ho_ten;
//     public $gioitinh;
//     public $ngay_sinh;
//     public $lop_id;
//     public $chidoan;
//     public $khoa;
//     public $email;
//     public $sdt;    
//     private $chuc_vu;
// }
