-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 13, 2025 lúc 07:35 AM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `quanlydoanvien`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `chidoan`
--

CREATE TABLE `chidoan` (
  `id` int(11) NOT NULL,
  `ten_chidoan` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `chidoan`
--

INSERT INTO `chidoan` (`id`, `ten_chidoan`) VALUES
(1, 'Khoa Hàng hải'),
(2, 'Khoa Công nghệ thông tin'),
(3, 'Khoa Kinh tế'),
(4, 'Khoa Quản trị - Tài chính'),
(5, 'Khoa Cơ khí - Điện'),
(6, 'Khoa Công trình'),
(7, 'Khoa Môi trường'),
(8, 'Khoa Ngoại ngữ'),
(9, 'Viện Đào tạo Sau đại học');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doanphi`
--

CREATE TABLE `doanphi` (
  `id` int(11) NOT NULL,
  `doanvien_id` int(11) DEFAULT NULL,
  `nam` int(11) DEFAULT NULL,
  `da_dong` tinyint(1) DEFAULT 0,
  `ngay_dong` date DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `doanvien`
--

CREATE TABLE `doanvien` (
  `id` int(11) NOT NULL,
  `ho_ten` varchar(100) NOT NULL,
  `gioi_tinh` enum('Nam','Nữ','Khác') NOT NULL,
  `ngay_sinh` date DEFAULT NULL,
  `lop_id` int(11) DEFAULT NULL,
  `chidoan_id` int(11) DEFAULT NULL,
  `khoa` int(11) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `sdt` varchar(15) DEFAULT NULL,
  `chuc_vu` enum('doanvien','canbodoan','admin') DEFAULT 'doanvien',
  `nienkhoa` int(11) DEFAULT NULL,
  `password` varchar(255) DEFAULT NULL,
  `reset_token` varchar(255) DEFAULT NULL,
  `reset_token_expiry` datetime DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `doanvien`
--

INSERT INTO `doanvien` (`id`, `ho_ten`, `gioi_tinh`, `ngay_sinh`, `lop_id`, `chidoan_id`, `khoa`, `email`, `sdt`, `chuc_vu`, `nienkhoa`, `password`, `reset_token`, `reset_token_expiry`) VALUES
(101, 'Chu Thùy Dương', 'Nữ', '2006-03-02', 801, 8, 8, 'Duong0302@gmail.com', '0928564126', 'canbodoan', 65, '$2y$10$/wGi3yGC2cQt/dzDnnv76OJLN9WePa588v1/CjuduSicVCpJlS03y', NULL, NULL),
(102138, 'Hieu stupid', 'Nam', '2005-11-11', 202, 2, 2, 'khanhnd05@gmail.com', '0928564126', 'doanvien', 64, '$2y$10$TNUkpF9hWuZHPN7lu/rHJe1wNvHI3uIrM15zbTE7HazqXNlG9ay3u', NULL, NULL),
(102151, 'Nguyen Khanh', 'Nam', '2005-11-04', 701, 7, 7, 'khanhnd05@gmail.com', '0928564126', 'admin', 64, '$2y$10$SliYrpPW.G0UM0i5So.0ueKDB4MpgeBBsVH0jjCBrkNP/MKshxwOu', '562387', '2025-05-13 07:55:30');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoatdong`
--

CREATE TABLE `hoatdong` (
  `id` int(11) NOT NULL,
  `ten_hoat_dong` varchar(150) NOT NULL,
  `ngay_to_chuc` date DEFAULT NULL,
  `noi_dung` text DEFAULT NULL,
  `diem` int(11) DEFAULT 0,
  `dia_diem` varchar(255) DEFAULT NULL,
  `loai_hoat_dong` varchar(100) DEFAULT NULL,
  `so_luong_tham_gia` int(11) DEFAULT 0,
  `ngay_tao` datetime DEFAULT current_timestamp(),
  `nguoi_tao` int(11) DEFAULT NULL,
  `trang_thai` enum('chờ duyệt','đã duyệt','đã kết thúc') DEFAULT 'chờ duyệt'
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `hoatdong`
--

INSERT INTO `hoatdong` (`id`, `ten_hoat_dong`, `ngay_to_chuc`, `noi_dung`, `diem`, `dia_diem`, `loai_hoat_dong`, `so_luong_tham_gia`, `ngay_tao`, `nguoi_tao`, `trang_thai`) VALUES
(37, 'Hè xanh 2025', '2025-05-22', 'hehe', 100, 'Đại học Hàng hải Việt Nam', 'Tình nguyện', 100, '2025-05-13 00:46:09', 102151, 'đã duyệt'),
(40, 'Hội khỏe Phù Đổng', '2025-05-28', 'Hội khỏe', 10, 'Đại học Hàng hải Việt Nam', 'Thể thao', 100, '2025-05-13 01:05:49', 102151, 'chờ duyệt'),
(41, 'Văn nghệ Trung thu', '2025-05-23', 'Văn nghệ Đoàn', 10, 'Đại học Hàng hải Việt Nam', 'Văn nghệ', 100, '2025-05-13 10:35:02', 102151, 'đã duyệt');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `hoso`
--

CREATE TABLE `hoso` (
  `id` int(11) NOT NULL,
  `doanvien_id` int(11) DEFAULT NULL,
  `ngay_vao_doan` date DEFAULT NULL,
  `noi_ket_nap` varchar(150) DEFAULT NULL,
  `file_scan` varchar(255) DEFAULT NULL,
  `trang_thai` enum('Đầy đủ','Thiếu','Đang bổ sung') DEFAULT 'Thiếu',
  `noi_sinh_hoat_thanh_pho` varchar(100) DEFAULT NULL,
  `noi_sinh_hoat_quan_huyen` varchar(100) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `lop`
--

CREATE TABLE `lop` (
  `id` int(11) NOT NULL,
  `ten_lop` varchar(50) NOT NULL,
  `chidoan_id` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `lop`
--

INSERT INTO `lop` (`id`, `ten_lop`, `chidoan_id`) VALUES
(101, 'Điều khiển tàu biển', 1),
(102, 'Máy tàu thủy', 1),
(103, 'Vận tải biển', 1),
(104, 'Khai thác máy tàu biển', 1),
(105, 'Khai thác tàu biển', 1),
(201, 'Công nghệ thông tin', 2),
(202, 'Kỹ thuật phần mềm', 2),
(203, 'Hệ thống thông tin', 2),
(204, 'Khoa học máy tính', 2),
(205, 'Mạng máy tính và truyền thông dữ liệu', 2),
(301, 'Kế toán', 3),
(302, 'Kiểm toán', 3),
(303, 'Kinh tế vận tải', 3),
(304, 'Kinh tế ngoại thương', 3),
(305, 'Kinh tế quốc tế', 3),
(401, 'Quản trị kinh doanh', 4),
(402, 'Quản trị khách sạn', 4),
(403, 'Quản trị dịch vụ du lịch và lữ hành', 4),
(404, 'Tài chính - Ngân hàng', 4),
(405, 'Marketing', 4),
(501, 'Công nghệ kỹ thuật cơ khí', 5),
(502, 'Công nghệ kỹ thuật điện - điện tử', 5),
(503, 'Công nghệ kỹ thuật điều khiển và tự động hóa', 5),
(504, 'Công nghệ kỹ thuật ô tô', 5),
(601, 'Kỹ thuật xây dựng', 6),
(602, 'Kỹ thuật công trình thủy', 6),
(603, 'Kỹ thuật cơ sở hạ tầng', 6),
(604, 'Kỹ thuật môi trường', 6),
(701, 'Công nghệ kỹ thuật môi trường', 7),
(702, 'Quản lý tài nguyên và môi trường', 7),
(703, 'Công nghệ kỹ thuật hóa học', 7),
(801, 'Ngôn ngữ Anh', 8),
(802, 'Ngôn ngữ Trung Quốc', 8),
(803, 'Ngôn ngữ Nhật', 8),
(901, 'Thạc sĩ Quản trị kinh doanh', 9),
(902, 'Thạc sĩ Kỹ thuật tàu thủy', 9),
(903, 'Thạc sĩ Kỹ thuật cơ khí', 9),
(904, 'Thạc sĩ Kỹ thuật điện', 9);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thamgia`
--

CREATE TABLE `thamgia` (
  `id` int(11) NOT NULL,
  `doanvien_id` int(11) DEFAULT NULL,
  `hoatdong_id` int(11) DEFAULT NULL,
  `diem_rieng` int(11) DEFAULT 0
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thamgia`
--

INSERT INTO `thamgia` (`id`, `doanvien_id`, `hoatdong_id`, `diem_rieng`) VALUES
(3, 102138, 37, 8),
(4, 102138, 41, 7);

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `id` int(11) NOT NULL,
  `id_actor` int(11) DEFAULT NULL,
  `loai` varchar(50) DEFAULT NULL,
  `noidung` varchar(200) DEFAULT NULL,
  `id_affected` int(11) DEFAULT NULL,
  `thoigian` datetime DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `thongbao`
--

INSERT INTO `thongbao` (`id`, `id_actor`, `loai`, `noidung`, `id_affected`, `thoigian`) VALUES
(77, 102151, 'change', 'sửa thông tin đoàn viên 3 (doanvien) [Lớp: 802 -> 0, Chi đoàn: 8 -> none, Khoa: 8 -> none, Chức vụ: canbodoan -> none, Niên khóa: 64 -> none]', 3, '2025-05-13 11:50:44'),
(78, 102151, 'change', 'sửa thông tin đoàn viên 9 (doanvien) [Họ tên: Đỗ Văn I -> Đỗ Văn Lê]', 9, '2025-05-13 12:00:09'),
(79, 102151, 'change', 'sửa thông tin đoàn viên 5 (doanvien) [Lớp: 203 -> 0, Chi đoàn: 2 -> none, Khoa: 2 -> none, Chức vụ: doanvien -> none, Niên khóa: 65 -> none]', 5, '2025-05-13 12:10:34'),
(80, 102151, 'delete', 'xóa đoàn viên 4', 4, '2025-05-13 12:27:48');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `chidoan`
--
ALTER TABLE `chidoan`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `doanphi`
--
ALTER TABLE `doanphi`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doanvien_id` (`doanvien_id`);

--
-- Chỉ mục cho bảng `doanvien`
--
ALTER TABLE `doanvien`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hoatdong`
--
ALTER TABLE `hoatdong`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `hoso`
--
ALTER TABLE `hoso`
  ADD PRIMARY KEY (`id`),
  ADD KEY `hoso_ibfk_1` (`doanvien_id`);

--
-- Chỉ mục cho bảng `lop`
--
ALTER TABLE `lop`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `thamgia`
--
ALTER TABLE `thamgia`
  ADD PRIMARY KEY (`id`),
  ADD KEY `doanvien_id` (`doanvien_id`),
  ADD KEY `hoatdong_id` (`hoatdong_id`);

--
-- Chỉ mục cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  ADD PRIMARY KEY (`id`),
  ADD KEY `id_tacgia` (`id_affected`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `chidoan`
--
ALTER TABLE `chidoan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT cho bảng `doanphi`
--
ALTER TABLE `doanphi`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `hoatdong`
--
ALTER TABLE `hoatdong`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=42;

--
-- AUTO_INCREMENT cho bảng `hoso`
--
ALTER TABLE `hoso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT cho bảng `lop`
--
ALTER TABLE `lop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=905;

--
-- AUTO_INCREMENT cho bảng `thamgia`
--
ALTER TABLE `thamgia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=81;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `doanphi`
--
ALTER TABLE `doanphi`
  ADD CONSTRAINT `doanphi_ibfk_1` FOREIGN KEY (`doanvien_id`) REFERENCES `doanvien` (`id`);

--
-- Các ràng buộc cho bảng `doanvien`
--
ALTER TABLE `doanvien`
  ADD CONSTRAINT `doanvien_ibfk_2` FOREIGN KEY (`chidoan_id`) REFERENCES `chidoan` (`id`);

--
-- Các ràng buộc cho bảng `hoso`
--
ALTER TABLE `hoso`
  ADD CONSTRAINT `hoso_ibfk_1` FOREIGN KEY (`doanvien_id`) REFERENCES `doanvien` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `thamgia`
--
ALTER TABLE `thamgia`
  ADD CONSTRAINT `thamgia_ibfk_1` FOREIGN KEY (`doanvien_id`) REFERENCES `doanvien` (`id`),
  ADD CONSTRAINT `thamgia_ibfk_2` FOREIGN KEY (`hoatdong_id`) REFERENCES `hoatdong` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
