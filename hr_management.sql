-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Máy chủ: 127.0.0.1
-- Thời gian đã tạo: Th4 08, 2025 lúc 06:38 PM
-- Phiên bản máy phục vụ: 10.4.32-MariaDB
-- Phiên bản PHP: 8.0.30

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Cơ sở dữ liệu: `hr_management`
--

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `attendance`
--

CREATE TABLE `attendance` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `check_in` datetime NOT NULL,
  `check_out` datetime DEFAULT NULL,
  `total_hours` decimal(5,2) DEFAULT NULL,
  `date` date NOT NULL,
  `status` enum('present','absent','late','half_day') DEFAULT 'present',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `attendance`
--

INSERT INTO `attendance` (`id`, `user_id`, `check_in`, `check_out`, `total_hours`, `date`, `status`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-04-01 08:00:00', '2025-04-01 17:00:00', 8.00, '2025-04-01', 'present', '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(2, 2, '2025-04-01 08:15:00', '2025-04-01 17:00:00', 7.75, '2025-04-01', 'late', '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(3, 3, '2025-04-01 08:00:00', '2025-04-01 17:00:00', 8.00, '2025-04-01', 'present', '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(4, 4, '2025-04-01 08:00:00', '2025-04-01 12:00:00', 4.00, '2025-04-01', 'half_day', '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(5, 2, '2025-04-02 08:00:00', '2025-04-02 17:00:00', 8.00, '2025-04-02', 'present', '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(6, 3, '2025-04-06 08:47:51', '2025-04-06 08:48:46', 0.00, '2025-04-06', 'half_day', '2025-04-06 01:47:51', '2025-04-06 01:48:46'),
(7, 3, '2025-04-08 03:36:01', '2025-04-08 03:36:08', 0.00, '2025-04-08', 'half_day', '2025-04-07 20:36:01', '2025-04-07 20:36:08'),
(8, 4, '2025-04-08 16:00:19', '2025-04-08 16:00:26', 0.00, '2025-04-08', 'half_day', '2025-04-08 09:00:19', '2025-04-08 09:00:26');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `leave_requests`
--

CREATE TABLE `leave_requests` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `start_date` date NOT NULL,
  `end_date` date NOT NULL,
  `leave_type` enum('annual','sick','unpaid','other') NOT NULL,
  `reason` text NOT NULL,
  `status` enum('pending','approved','rejected') NOT NULL DEFAULT 'pending',
  `manager_comment` text DEFAULT NULL,
  `approved_by` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `leave_requests`
--

INSERT INTO `leave_requests` (`id`, `user_id`, `start_date`, `end_date`, `leave_type`, `reason`, `status`, `manager_comment`, `approved_by`, `created_at`, `updated_at`) VALUES
(1, 2, '2025-04-10', '2025-04-12', 'annual', 'Nghỉ phép năm', 'approved', NULL, 1, '2025-04-07 17:00:00', '2025-04-08 15:47:44'),
(2, 3, '2025-04-15', '2025-04-15', 'sick', 'Nghỉ ốm', 'pending', NULL, NULL, '2025-04-07 17:00:00', '2025-04-08 15:47:44'),
(3, 4, '2025-04-20', '2025-04-22', 'unpaid', 'Việc gia đình', 'rejected', NULL, 1, '2025-04-07 17:00:00', '2025-04-08 15:47:44');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `migrations`
--

CREATE TABLE `migrations` (
  `id` int(10) UNSIGNED NOT NULL,
  `migration` varchar(255) NOT NULL,
  `batch` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `positions`
--

CREATE TABLE `positions` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `base_salary` decimal(10,2) NOT NULL,
  `description` text DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `positions`
--

INSERT INTO `positions` (`id`, `name`, `base_salary`, `description`, `created_at`, `updated_at`) VALUES
(1, 'Giám đốc', 30000000.00, 'Quản lý toàn bộ công ty', '2025-04-06 02:50:27', '2025-04-07 23:27:15'),
(2, 'Trưởng phòng', 20000000.00, 'Quản lý phòng ban', '2025-04-06 02:50:27', '2025-04-06 02:50:27'),
(3, 'Nhân viên', 10000000.00, 'Nhân viên thực hiện công việc', '2025-04-06 02:50:27', '2025-04-06 02:50:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `rewards_disciplines`
--

CREATE TABLE `rewards_disciplines` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `type` enum('reward','discipline') NOT NULL,
  `amount` decimal(10,2) NOT NULL,
  `reason` text NOT NULL,
  `date` date NOT NULL,
  `issued_by` int(11) NOT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `rewards_disciplines`
--

INSERT INTO `rewards_disciplines` (`id`, `user_id`, `type`, `amount`, `reason`, `date`, `issued_by`, `created_at`, `updated_at`) VALUES
(1, 1, 'reward', 1000000.00, 'Thưởng cho Giám đốc vì thành tích xuất sắc', '2025-04-06', 3, '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(2, 2, 'discipline', 500000.00, 'Khiển trách vì đi làm muộn', '2025-04-06', 1, '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(3, 3, 'reward', 500000.00, 'Thưởng vì có sáng kiến cải tiến quy trình', '2025-04-06', 1, '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(4, 4, 'discipline', 300000.00, 'Cảnh cáo vì vi phạm nội quy công ty', '2025-04-06', 2, '2025-04-05 19:50:27', '2025-04-05 19:50:27'),
(5, 2, 'reward', 2000000.00, 'Thưởng cho nhân viên vì đạt hiệu suất xuất sắc', '2025-04-06', 1, '2025-04-05 19:50:27', '2025-04-05 19:50:27');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `salary`
--

CREATE TABLE `salary` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `month` char(7) NOT NULL,
  `base_salary` decimal(10,2) NOT NULL,
  `bonus` decimal(10,2) DEFAULT 0.00,
  `deduction` decimal(10,2) DEFAULT 0.00,
  `total_hours` decimal(10,2) NOT NULL,
  `total_salary` decimal(10,2) NOT NULL,
  `status` enum('pending','paid') DEFAULT 'pending',
  `payment_date` date DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `salary`
--

INSERT INTO `salary` (`id`, `user_id`, `month`, `base_salary`, `bonus`, `deduction`, `total_hours`, `total_salary`, `status`, `payment_date`, `created_at`, `updated_at`) VALUES
(1, 1, '2025-04', 30000000.00, 1000000.00, 0.00, 176.00, 31000000.00, 'paid', '2025-04-30', '2025-03-31 17:00:00', '2025-04-29 17:00:00'),
(2, 2, '2025-04', 10000000.00, 2000000.00, 500000.00, 168.00, 11500000.00, 'paid', '2025-04-30', '2025-03-31 17:00:00', '2025-04-29 17:00:00'),
(3, 3, '2025-04', 10000000.00, 500000.00, 0.00, 160.00, 10500000.00, 'paid', '2025-04-30', '2025-03-31 17:00:00', '2025-04-29 17:00:00'),
(4, 4, '2025-04', 10000000.00, 0.00, 300000.00, 80.00, 9700000.00, 'pending', NULL, '2025-03-31 17:00:00', '2025-03-31 17:00:00'),
(5, 1, '2025-03', 30000000.00, 1500000.00, 0.00, 176.00, 31500000.00, 'paid', '2025-03-31', '2025-02-28 17:00:00', '2025-03-30 17:00:00'),
(6, 2, '2025-03', 10000000.00, 1000000.00, 0.00, 168.00, 11000000.00, 'paid', '2025-03-31', '2025-02-28 17:00:00', '2025-03-30 17:00:00'),
(7, 3, '2025-03', 10000000.00, 800000.00, 0.00, 160.00, 10800000.00, 'paid', '2025-03-31', '2025-02-28 17:00:00', '2025-03-30 17:00:00'),
(8, 4, '2025-03', 10000000.00, 0.00, 200000.00, 120.00, 9800000.00, 'paid', '2025-03-31', '2025-02-28 17:00:00', '2025-03-30 17:00:00');

-- --------------------------------------------------------

--
-- Cấu trúc bảng cho bảng `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `username` varchar(50) NOT NULL,
  `password` varchar(255) NOT NULL,
  `full_name` varchar(100) NOT NULL,
  `email` varchar(100) NOT NULL,
  `role` enum('admin','employee') NOT NULL DEFAULT 'employee',
  `position_id` int(11) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp(),
  `updated_at` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Đang đổ dữ liệu cho bảng `users`
--

INSERT INTO `users` (`id`, `username`, `password`, `full_name`, `email`, `role`, `position_id`, `created_at`, `updated_at`) VALUES
(1, 'admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Admin System', 'admin@hr.com', 'admin', 1, '2025-04-06 02:50:27', '2025-04-06 02:50:27'),
(2, 'employee1', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', 'employee1@hr.com', 'employee', 3, '2025-04-06 02:50:27', '2025-04-06 02:50:27'),
(3, 'adminvy', '$2y$10$Z/EsMAm4z687yqdcIXp7PObHxQtf8LNIF.58sTN7dU8SpUPvD6sIG', 'Nguyễn Trần Hạnh Vy', 'adminvy@gmail.com', 'admin', 1, '2025-04-05 23:09:45', '2025-04-08 16:10:49'),
(4, 'vy123', '$2y$10$vVunRGL6JeRqm3g0qK5Si.jtskPvjlQEJcU8.5EGC/6uFJlj8Tm.C', 'Nguyễn Trần Hạnh Vy', 'nguyenvy01052005@gmail.com', 'employee', 3, '2025-04-06 01:12:28', '2025-04-08 06:16:00'),
(5, 'employee2', '123456789', 'Nguyễn Văn B', 'employee2@gmail.com', 'employee', 3, '2025-04-08 16:05:13', '2025-04-08 16:05:13');

--
-- Chỉ mục cho các bảng đã đổ
--

--
-- Chỉ mục cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `approved_by` (`approved_by`);

--
-- Chỉ mục cho bảng `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `positions`
--
ALTER TABLE `positions`
  ADD PRIMARY KEY (`id`);

--
-- Chỉ mục cho bảng `rewards_disciplines`
--
ALTER TABLE `rewards_disciplines`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`),
  ADD KEY `issued_by` (`issued_by`);

--
-- Chỉ mục cho bảng `salary`
--
ALTER TABLE `salary`
  ADD PRIMARY KEY (`id`),
  ADD KEY `user_id` (`user_id`);

--
-- Chỉ mục cho bảng `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `username` (`username`),
  ADD UNIQUE KEY `email` (`email`),
  ADD KEY `fk_user_position` (`position_id`);

--
-- AUTO_INCREMENT cho các bảng đã đổ
--

--
-- AUTO_INCREMENT cho bảng `attendance`
--
ALTER TABLE `attendance`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `leave_requests`
--
ALTER TABLE `leave_requests`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT cho bảng `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT cho bảng `positions`
--
ALTER TABLE `positions`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT cho bảng `rewards_disciplines`
--
ALTER TABLE `rewards_disciplines`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT cho bảng `salary`
--
ALTER TABLE `salary`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=9;

--
-- AUTO_INCREMENT cho bảng `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- Các ràng buộc cho các bảng đã đổ
--

--
-- Các ràng buộc cho bảng `attendance`
--
ALTER TABLE `attendance`
  ADD CONSTRAINT `attendance_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `leave_requests`
--
ALTER TABLE `leave_requests`
  ADD CONSTRAINT `leave_requests_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `leave_requests_ibfk_2` FOREIGN KEY (`approved_by`) REFERENCES `users` (`id`) ON DELETE SET NULL;

--
-- Các ràng buộc cho bảng `rewards_disciplines`
--
ALTER TABLE `rewards_disciplines`
  ADD CONSTRAINT `rewards_disciplines_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE,
  ADD CONSTRAINT `rewards_disciplines_ibfk_2` FOREIGN KEY (`issued_by`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `salary`
--
ALTER TABLE `salary`
  ADD CONSTRAINT `salary_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `users` (`id`) ON DELETE CASCADE;

--
-- Các ràng buộc cho bảng `users`
--
ALTER TABLE `users`
  ADD CONSTRAINT `fk_user_position` FOREIGN KEY (`position_id`) REFERENCES `positions` (`id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
