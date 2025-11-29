<?php
require_once 'config/database.php';

$database = new Database();
$conn = $database->getConnection();

$stmt = $conn->query("SELECT * FROM students ORDER BY id");
$students = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Danh Sách Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Danh Sách Sinh Viên</h1>
    <div class="text-end mb-3">
        <a href="upload.php" class="btn btn-primary">Upload CSV</a>
    </div>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>Username</th>
            <th>Họ</th>
            <th>Tên</th>
            <th>Thành phố</th>
            <th>Email</th>
            <th>Khóa học</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($students as $student): ?>
            <tr>
                <td><?php echo htmlspecialchars($student['username']); ?></td>
                <td><?php echo htmlspecialchars($student['lastname']); ?></td>
                <td><?php echo htmlspecialchars($student['firstname']); ?></td>
                <td><?php echo htmlspecialchars($student['city']); ?></td>
                <td><?php echo htmlspecialchars($student['email']); ?></td>
                <td><?php echo htmlspecialchars($student['course']); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
</body>
</html>
