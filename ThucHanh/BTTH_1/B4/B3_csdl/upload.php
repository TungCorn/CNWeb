<?php
require_once 'config/database.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['csv_file'])) {
    $file = $_FILES['csv_file'];

    if ($file['error'] == 0 && pathinfo($file['name'], PATHINFO_EXTENSION) == 'csv') {
        $database = new Database();
        $conn = $database->getConnection();

        try {
            $conn->beginTransaction();

            $handle = fopen($file['tmp_name'], 'r');
            $header = fgetcsv($handle, 1000, ','); // Bỏ qua dòng tiêu đề

            $stmt = $conn->prepare("INSERT INTO students (username, password, lastname, firstname, city, email, course) VALUES (?, ?, ?, ?, ?, ?, ?)");

            $count = 0;
            while (($data = fgetcsv($handle, 1000, ',')) !== FALSE) {
                if (count($data) >= 7) {
                    $stmt->execute([
                        $data[0], // username
                        password_hash($data[1], PASSWORD_DEFAULT), // password (mã hóa)
                        $data[2], // lastname
                        $data[3], // firstname
                        $data[4], // city
                        $data[5], // email
                        $data[6]  // course
                    ]);
                    $count++;
                }
            }

            fclose($handle);
            $conn->commit();
            $message = "Upload thành công " . $count . " sinh viên!";
        } catch (Exception $e) {
            $conn->rollBack();
            $message = "Lỗi: " . $e->getMessage();
        }
    } else {
        $message = "Vui lòng chọn file CSV!";
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload Danh Sách Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Upload Danh Sách Sinh Viên</h1>

    <?php if ($message): ?>
        <div class="alert <?php echo strpos($message, 'thành công') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Chọn file CSV:</label>
                    <input type="file" name="csv_file" accept=".csv" class="form-control" required>
                    <small class="text-muted">File phải có định dạng: username, password, lastname, firstname, city, email, course</small>
                </div>
                <button type="submit" class="btn btn-primary">Upload và Lưu vào CSDL</button>
            </form>
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Xem danh sách sinh viên</a>
    </div>
</div>
</body>
</html>
