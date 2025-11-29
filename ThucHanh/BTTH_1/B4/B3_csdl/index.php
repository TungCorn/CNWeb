<?php
$csvFile = '65HTTT_Danh_sach_diem_danh.csv';
$data = [];

if (file_exists($csvFile)) {
    $file = fopen($csvFile, 'r');
    $headers = fgetcsv($file, 0, ',', '"', '');

    while (($row = fgetcsv($file, 0, ',', '"', '')) !== false) {
        $data[] = $row;
    }

    fclose($file);
}
?>

<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Danh Sách Điểm Danh</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            padding: 20px;
            background-color: #f5f5f5;
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        h1 {
            color: #333;
            margin-bottom: 20px;
            text-align: center;
        }

        .stats {
            margin-bottom: 20px;
            padding: 10px;
            background: #e3f2fd;
            border-radius: 4px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background-color: #2196F3;
            color: white;
            font-weight: bold;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        tr:hover {
            background-color: #f0f0f0;
        }

        .no-data {
            text-align: center;
            padding: 20px;
            color: #999;
        }
    </style>
</head>
<body>
<div class="container">
    <h1>Danh Sách Điểm Danh Lớp 65HTTT</h1>

    <?php if (!empty($data)): ?>
        <div class="stats">
            <strong>Tổng số sinh viên:</strong> <?= count($data) ?>
        </div>

        <table>
            <thead>
            <tr>
                <th>STT</th>
                <th>Username</th>
                <th>Password</th>
                <th>Họ</th>
                <th>Tên</th>
                <th>Lớp</th>
                <th>Email</th>
                <th>Khóa học</th>
            </tr>
            </thead>
            <tbody>
            <?php foreach ($data as $index => $row): ?>
                <tr>
                    <td><?= $index + 1 ?></td>
                    <td><?= htmlspecialchars($row[0]) ?></td>
                    <td><?= htmlspecialchars($row[1]) ?></td>
                    <td><?= htmlspecialchars($row[2]) ?></td>
                    <td><?= htmlspecialchars($row[3]) ?></td>
                    <td><?= htmlspecialchars($row[4]) ?></td>
                    <td><?= htmlspecialchars($row[5]) ?></td>
                    <td><?= htmlspecialchars($row[6]) ?></td>
                </tr>
            <?php endforeach; ?>
            </tbody>
        </table>
    <?php else: ?>
        <div class="no-data">Không có dữ liệu hoặc file không tồn tại</div>
    <?php endif; ?>
</div>
</body>
</html>
