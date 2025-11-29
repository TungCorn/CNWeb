<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

// Lấy danh sách hoa từ CSDL
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
    <title>Danh sách các loại hoa</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè</h1>

    <div class="admin-link" style="text-align: center; margin-bottom: 20px;">
        <a href="admin.php">Trang quản trị</a>
    </div>

    <?php foreach($danhSachHoa as $hoa): ?>
        <div class="row mb-4 p-3 bg-white rounded shadow-sm">
            <div class="col-12">
                <h3><?php echo htmlspecialchars($hoa['id']) . '. ' . htmlspecialchars($hoa['ten_hoa']); ?></h3>
                <p><?php echo htmlspecialchars($hoa['mo_ta']); ?></p>
                <div class="mt-3">
                    <?php
                    $image_src = (strpos($hoa['hinh_anh'], 'http') === 0)
                            ? htmlspecialchars($hoa['hinh_anh'])
                            : 'hoadep/' . htmlspecialchars($hoa['hinh_anh']);
                    ?>
                    <img src="<?php echo $image_src; ?>"
                         class="img-fluid rounded"
                         alt="<?php echo htmlspecialchars($hoa['ten_hoa']); ?>"
                         style="max-width: 600px; height: auto;">
                </div>
            </div>


        </div>
    <?php endforeach; ?>
</div>
</body>
</html>
