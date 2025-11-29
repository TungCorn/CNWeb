<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

// Xử lý thêm hoa
if(isset($_POST['them_hoa'])) {
    $ten_hoa = $_POST['ten_hoa'];
    $mo_ta = $_POST['mo_ta'];
    $hinh_anh = $_POST['hinh_anh']; // Nhận URL thay vì upload file

    $sql = "INSERT INTO hoa (ten_hoa, mo_ta, hinh_anh) VALUES (?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$ten_hoa, $mo_ta, $hinh_anh]);

    header('Location: admin.php');
    exit;
}


// Xử lý xóa hoa
if(isset($_GET['xoa'])) {
    $id = $_GET['xoa'];

    $sql = "SELECT hinh_anh FROM hoa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);
    $hoa = $stmt->fetch(PDO::FETCH_ASSOC);

    // Chỉ xóa file nếu là ảnh local (không phải URL)
    if($hoa && strpos($hoa['hinh_anh'], 'http') !== 0) {
        $file_path = "hoadep/" . $hoa['hinh_anh'];
        if(file_exists($file_path)) {
            unlink($file_path);
        }
    }

    $sql = "DELETE FROM hoa WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->execute([$id]);

    header('Location: admin.php');
    exit;
}


// Lấy danh sách hoa
$sql = "SELECT * FROM hoa ORDER BY id ASC";
$stmt = $conn->prepare($sql);
$stmt->execute();
$danhSachHoa = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản lý hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h2>Quản lý danh sách hoa</h2>

    <a href="index.php" class="btn-back">← Về trang chủ</a>

    <!-- Form thêm hoa -->
    <div class="card mb-4">
        <div class="card-body">
            <h5 class="card-title">Thêm hoa mới</h5>
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Tên hoa</label>
                    <input type="text" class="form-control" name="ten_hoa" required>
                </div>
                <div class="mb-3">
                    <label class="form-label">Mô tả</label>
                    <textarea class="form-control" name="mo_ta" rows="3" required></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Link hình ảnh</label>
                    <input type="url" class="form-control" name="hinh_anh"
                           placeholder="https://example.com/image.jpg" required>
                </div>

                <button type="submit" name="them_hoa" class="btn btn-primary">Thêm</button>
            </form>
        </div>
    </div>

    <!-- Bảng danh sách -->
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Tên hoa</th>
            <th>Mô tả</th>
            <th>Hình ảnh</th>
            <th>Thao tác</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach($danhSachHoa as $hoa): ?>
            <tr>
                <td><?php echo $hoa['id']; ?></td>
                <td><?php echo htmlspecialchars($hoa['ten_hoa']); ?></td>
                <td><?php echo substr(htmlspecialchars($hoa['mo_ta']), 0, 100) . '...'; ?></td>
                <td>
                    <?php
                    $image_src = (strpos($hoa['hinh_anh'], 'http') === 0)
                            ? htmlspecialchars($hoa['hinh_anh'])
                            : 'hoadep/' . htmlspecialchars($hoa['hinh_anh']);
                    ?>
                    <img src="<?php echo $image_src; ?>" width="50" alt="<?php echo htmlspecialchars($hoa['ten_hoa']); ?>">
                </td>

                <td>
                    <a href="?xoa=<?php echo $hoa['id']; ?>"
                       class="btn btn-danger btn-sm"
                       onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
