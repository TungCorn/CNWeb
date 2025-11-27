<?php
// Bước 1: Gọi file data.php chứa mảng dữ liệu (giả lập CSDL)
require 'data.php';

// Bước 2: Nhận thông báo thành công tạo mới qua phương thức GET (nếu có)
$success = $_GET['success'] ?? "";
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Dashboard Quản lý Đồ án</title>
    <!-- Chèn CSS nếu cần, ví dụ Bootstrap hay style.css -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
</head>
<body>
    <div class="card-header d-flex justify-content-between align-items-center">
        <h5 class="mb-0 fs-1 link-primary ">Quản lý Đồ án Tốt nghiệp</h5>

        <div>
            <a href="index.php" class="btn btn-outline-secondary btn-sm me-2">
                <i class="bi bi-arrow-left"></i> Dashboard
            </a>

            <a href="" class="btn btn-primary btn-sm">
                <i class="bi bi-plus-lg"></i> Thêm đồ án
            </a>
        </div>
    </div>

    <div class="container">
        <h1>Dashboard</h1>
        <p>Dữ liệu trong ví dụ này đang được lưu cố định trong một mảng PHP (chưa dùng CSDL).</p>

        <!-- Bước 3: Hiển thị thông báo nếu có tham số ?success=created -->
        <?php if ($success == "created"): ?>
            <div style="padding: 10px; background:#d1e7dd; color:#0f5132; border-radius:4px; margin-bottom:16px;">
                Giả lập: Thêm đồ án mới thành công! (thông báo thông qua tham số GET trong URL).
            </div>
        <?php endif; ?>

        <!-- Bước 4: Hiển thị bảng dữ liệu -->
        <table class="table">
            <thead>
            <tr>
                <th>#</th>
                <th>Tên đề tài</th>
                <th>Sinh viên</th>
                <th>GV hướng dẫn</th>
                <th>Năm học</th>
                <th>Trạng thái</th>
                <th>Ngày tạo</th>
            </tr>
            </thead>
            <tbody>
            <?php if (!empty($do_an_list)): ?>
                <?php foreach ($do_an_list as $do_an): ?>
                    <tr>
                        <td><?php echo htmlspecialchars($do_an['id']); ?></td>
                        <td><?php echo htmlspecialchars($do_an['ten_de_tai']); ?></td>
                        <td>
                            <?php echo htmlspecialchars($do_an['ten_sinh_vien']); ?><br>
                            <small>MSSV: <?php echo htmlspecialchars($do_an['mssv']); ?></small>
                        </td>
                        <td><?php echo htmlspecialchars($do_an['giang_vien_hd']); ?></td>
                        <td><?php echo htmlspecialchars($do_an['nam_hoc']); ?></td>
                        <td><?php echo htmlspecialchars($do_an['trang_thai']); ?></td>
                        <td><?php echo htmlspecialchars($do_an['created_at']); ?></td>
                    </tr>
                    <!-- Duyệt từng bản ghi trong mảng -->
                    <!--Sinh viên làm phần này -->
                    <!--Sinh viên làm phần này -->
                    <!--Sinh viên làm phần này -->
                    <!--Sinh viên làm phần này -->
                <?php endforeach; ?>
            <?php else: ?>
                <!-- Trường hợp mảng rỗng -->
                <tr>
                    <td colspan="7">Chưa có đồ án nào trong mảng.</td>
                </tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="js/bootstrap.bundle.min.js"></script>
</body>
</html>
