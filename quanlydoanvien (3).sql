-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th5 11, 2025 lúc 08:49 PM
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
  `password` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `doanvien`
--

INSERT INTO `doanvien` (`id`, `ho_ten`, `gioi_tinh`, `ngay_sinh`, `lop_id`, `chidoan_id`, `khoa`, `email`, `sdt`, `chuc_vu`, `nienkhoa`, `password`) VALUES
(1, 'Nguyễn Văn A', 'Nam', '2002-05-14', 902, 9, 9, 'nguyenvana@example.com', '0912345678', 'doanvien', 63, 'pass123'),
(2, 'Trần Thị B', 'Nữ', '2001-08-20', 0, 2, 2, 'tranthib@example.com', '0912345679', 'doanvien', 64, 'pass123'),
(3, 'Lê Văn C', 'Nam', '2002-11-02', 201, 2, 2, 'levanc@example.com', '0912345680', 'canbodoan', 65, 'pass123'),
(4, 'Phạm Thị D', 'Nữ', '2001-06-30', 202, 2, 2, 'phamthid@example.com', '0912345681', 'doanvien', 62, 'pass123'),
(5, 'Hoàng Văn E', 'Nam', '2003-03-25', 203, 2, 2, 'hoangvane@example.com', '0912345682', 'doanvien', 65, 'pass123'),
(6, 'Đặng Thị F', 'Nữ', '2000-12-12', 201, 2, 2, 'dangthif@example.com', '0912345683', 'doanvien', 64, 'pass123'),
(7, 'Bùi Văn G', 'Nam', '2002-01-10', 201, 2, 2, 'buivang@example.com', '0912345684', 'doanvien', 65, 'pass123'),
(8, 'Vũ Thị H', 'Nữ', '2001-07-18', 303, 3, 3, 'vuthih@example.com', '0912345685', 'doanvien', 62, 'pass123'),
(9, 'Đỗ Văn I', 'Nam', '2002-09-15', 401, 4, 4, 'dovani@example.com', '0912345686', 'canbodoan', 65, 'pass123'),
(10, 'Ngô Thị J', 'Nữ', '2000-10-21', 402, 4, 4, 'ngothij@example.com', '0912345687', 'doanvien', 64, 'pass123'),
(11, 'Phan Văn K', 'Nam', '2002-05-01', 501, 5, 5, 'phanvank@example.com', '0912345688', 'doanvien', 65, 'pass123'),
(12, 'Mai Thị L', 'Nữ', '2001-09-12', 502, 5, 5, 'maithil@example.com', '0912345689', 'admin', 62, 'pass123'),
(13, 'Trịnh Văn M', 'Nam', '2003-04-17', 601, 6, 6, 'trinhvanm@example.com', '0912345690', 'doanvien', 63, 'pass123'),
(14, 'Cao Thị N', 'Nữ', '2001-11-11', 602, 6, 6, 'caothin@example.com', '0912345691', 'doanvien', 64, 'pass123'),
(15, 'Hồ Văn O', 'Nam', '2000-06-06', 701, 7, 7, 'hovano@example.com', '0912345692', 'canbodoan', 65, 'pass123'),
(16, 'Tạ Thị P', 'Nữ', '2002-02-02', 702, 7, 7, 'tathip@example.com', '0912345693', 'doanvien', 62, 'pass123'),
(17, 'Đinh Văn Q', 'Nam', '2003-08-08', 801, 8, 8, 'dinhvanq@example.com', '0912345694', 'doanvien', 63, 'pass123'),
(18, 'Châu Thị R', 'Nữ', '2001-03-03', 802, 8, 8, 'chauthir@example.com', '0912345695', 'doanvien', 64, 'pass123'),
(19, 'Lâm Văn S', 'Nam', '2002-07-07', 901, 9, 9, 'lamvans@example.com', '0912345696', 'admin', 65, 'pass123'),
(20, 'Đoàn Thị T', 'Nữ', '2000-01-01', 902, 9, 9, 'doanthit@example.com', '0912345697', 'doanvien', 62, 'pass123'),
(21, 'Nguyễn Thị U', 'Nữ', '2001-12-24', 105, 1, 1, 'nguyenthiu@example.com', '0912345698', 'doanvien', 63, 'pass123'),
(22, 'Trần Văn V', 'Nam', '2002-06-15', 104, 1, 1, 'tranvanv@example.com', '0912345699', 'doanvien', 64, 'pass123'),
(23, 'Lê Thị W', 'Nữ', '2000-09-30', 204, 2, 2, 'lethiw@example.com', '0912345700', 'canbodoan', 65, 'pass123'),
(24, 'Phạm Văn X', 'Nam', '2003-05-19', 205, 2, 2, 'phamvanx@example.com', '0912345701', 'doanvien', 62, 'pass123'),
(25, 'Hoàng Thị Y', 'Nữ', '2001-08-01', 304, 3, 3, 'hoangthiy@example.com', '0912345702', 'doanvien', 63, 'pass123'),
(26, 'Đặng Văn Z', 'Nam', '2002-10-20', 305, 3, 3, 'dangvanz@example.com', '0912345703', 'doanvien', 64, 'pass123'),
(27, 'Bùi Thị AA', 'Nữ', '2001-04-04', 403, 4, 4, 'buithiaa@example.com', '0912345704', 'doanvien', 65, 'pass123'),
(28, 'Vũ Văn AB', 'Nam', '2003-03-03', 404, 4, 4, 'vuvanab@example.com', '0912345705', 'canbodoan', 62, 'pass123'),
(29, 'Đỗ Thị AC', 'Nữ', '2000-07-07', 405, 4, 4, 'dothiac@example.com', '0912345706', 'doanvien', 63, 'pass123'),
(30, 'Ngô Văn AD', 'Nam', '2002-02-14', 503, 5, 5, 'ngovanad@example.com', '0912345707', 'doanvien', 64, 'pass123'),
(31, 'Phan Thị AE', 'Nữ', '2001-01-01', 504, 5, 5, 'phanthiae@example.com', '0912345708', 'doanvien', 65, 'pass123'),
(32, 'Mai Văn AF', 'Nam', '2003-10-10', 603, 6, 6, 'maivanaf@example.com', '0912345709', 'doanvien', 62, 'pass123'),
(33, 'Trịnh Thị AG', 'Nữ', '2000-05-05', 604, 6, 6, 'trinhthiag@example.com', '0912345710', 'admin', 63, 'pass123'),
(34, 'Cao Văn AH', 'Nam', '2001-07-07', 703, 7, 7, 'caovanah@example.com', '0912345711', 'doanvien', 64, 'pass123'),
(35, 'Hồ Thị AI', 'Nữ', '2002-12-12', 701, 7, 7, 'hothiai@example.com', '0912345712', 'doanvien', 65, 'pass123'),
(36, 'Tạ Văn AJ', 'Nam', '2000-03-03', 803, 8, 8, 'tavananj@example.com', '0912345713', 'canbodoan', 62, 'pass123'),
(37, 'Đinh Thị AK', 'Nữ', '2001-06-06', 801, 8, 8, 'dinhthiak@example.com', '0912345714', 'doanvien', 63, 'pass123'),
(38, 'Châu Văn AL', 'Nam', '2002-01-01', 904, 9, 9, 'chauvanal@example.com', '0912345715', 'doanvien', 64, 'pass123'),
(39, 'Lâm Thị AM', 'Nữ', '2003-11-11', 903, 9, 9, 'lamthiam@example.com', '0912345716', 'admin', 65, 'pass123'),
(40, 'Đoàn Văn AN', 'Nam', '2001-09-09', 902, 9, 9, 'doanvanan@example.com', '0912345717', 'doanvien', 62, 'pass123'),
(101, 'Chu Thùy Dương', 'Nữ', '2006-03-02', 801, 8, 8, 'Duong0302@gmail.com', '0928564126', 'canbodoan', 65, '$2y$10$/wGi3yGC2cQt/dzDnnv76OJLN9WePa588v1/CjuduSicVCpJlS03y'),
(102138, 'Hieu Ngu', 'Nam', '0000-00-00', 501, 5, 5, 'khanhnd05@gmail.com', '0928564126', 'admin', 63, '$2y$10$wL.SpObDlWa1mQCLq85WAua9DOOfqUjtdiD55fPCXMH1Z5REHtw9C'),
(102151, 'Nguyen Khanh', 'Nam', '2005-11-04', 202, 2, 2, 'khanhnd05@gmail.com', '0928564126', 'admin', 64, '$2y$10$OKltxyFwl2Nj.dFy8AqfLONFtNE5K66Pr5o75LvijDo0kjXuoLycS'),
(102152, 'Nguyen Khanh', 'Nam', '2005-11-04', 201, 2, 2, 'khanhnd05@gmail.com', '0928564126', 'admin', 64, '$2y$10$Q..ZwDWSQB/nelEKnXhFZuZisWW5M.tgtPlRXNtFM1Hj2aJs2wAYq');

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
(25, 'Hè xanh 2025', '2025-05-22', 'hè xanh', 1000, 'Sơn La', 'Văn nghệ', 100, '2025-05-10 22:41:20', 1, 'chờ duyệt');

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
  `trang_thai` enum('Đầy đủ','Thiếu','Đang bổ sung') DEFAULT 'Thiếu'
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
  `diem_rieng` int(11) DEFAULT 0,
  `ghi_chu` varchar(255) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `thongbao`
--

CREATE TABLE `thongbao` (
  `id` int(11) NOT NULL,
  `id_actor` int(11) DEFAULT NULL,
  `loai` varchar(50) DEFAULT NULL,
  `noidung` varchar(200) DEFAULT NULL,
  `id_affected` int(11) DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

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
  ADD KEY `doanvien_id` (`doanvien_id`);

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

--
-- AUTO_INCREMENT cho bảng `hoso`
--
ALTER TABLE `hoso`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `lop`
--
ALTER TABLE `lop`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=905;

--
-- AUTO_INCREMENT cho bảng `thamgia`
--
ALTER TABLE `thamgia`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `thongbao`
--
ALTER TABLE `thongbao`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

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
  ADD CONSTRAINT `hoso_ibfk_1` FOREIGN KEY (`doanvien_id`) REFERENCES `doanvien` (`id`);

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
