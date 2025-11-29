
<?php
session_start();
include 'data/hoa.php';
global $flowers;

// Lưu vào session để duy trì dữ liệu
if (!isset($_SESSION['flowers'])) {
    $_SESSION['flowers'] = $flowers;
}

// Xử lý thêm hoa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'add') {
    $newFlower = [
        'id' => count($_SESSION['flowers']) + 1,
        'name' => $_POST['name'],
        'description' => $_POST['description'],
        'image' => $_POST['image']
    ];
    $_SESSION['flowers'][] = $newFlower;
    header('Location: admin.php');
    exit;
}

// Xử lý xóa hoa
if (isset($_GET['delete'])) {
    $id = (int)$_GET['delete'];
    $_SESSION['flowers'] = array_filter($_SESSION['flowers'], function($flower) use ($id) {
        return $flower['id'] !== $id;
    });
    header('Location: admin.php');
    exit;
}

// Lấy hoa để sửa
$editFlower = null;
if (isset($_GET['edit'])) {
    $id = (int)$_GET['edit'];
    foreach ($_SESSION['flowers'] as $flower) {
        if ($flower['id'] === $id) {
            $editFlower = $flower;
            break;
        }
    }
}

// Xử lý cập nhật hoa
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'update') {
    $id = (int)$_POST['id'];
    foreach ($_SESSION['flowers'] as &$flower) {
        if ($flower['id'] === $id) {
            $flower['name'] = $_POST['name'];
            $flower['description'] = $_POST['description'];
            $flower['image'] = $_POST['image'];
            break;
        }
    }
    header('Location: admin.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quản trị hoa</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; padding: 20px; background-color: #f4f4f4; }
        .container { max-width: 1400px; margin: 0 auto; }
        h1 { text-align: center; margin-bottom: 20px; }
        .btn-back { display: inline-block; margin-bottom: 20px; padding: 10px 20px; background: #2196F3; color: white; text-decoration: none; border-radius: 5px; }
        table { width: 100%; background: white; border-collapse: collapse; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        th, td { padding: 12px; text-align: left; border-bottom: 1px solid #ddd; }
        th { background-color: #4CAF50; color: white; }
        img { max-width: 100px; height: auto; }
        .actions a { margin-right: 10px; padding: 5px 10px; text-decoration: none; color: white; border-radius: 3px; }
        .edit { background-color: #2196F3; }
        .delete { background-color: #f44336; }
        .form-container { background: white; padding: 20px; margin-bottom: 20px; border-radius: 5px; }
        .form-group { margin-bottom: 15px; }
        .form-group label { display: block; margin-bottom: 5px; font-weight: bold; }
        .form-group input, .form-group textarea { width: 100%; padding: 8px; border: 1px solid #ddd; border-radius: 3px; }
        .form-group textarea { min-height: 100px; }
        button { padding: 10px 20px; background: #4CAF50; color: white; border: none; border-radius: 5px; cursor: pointer; }
        button:hover { background: #45a049; }
    </style>
</head>
<body>
    <div class="container">
        <h1>Quản Trị Danh Sách Hoa</h1>
        <a href="index.php" class="btn-back">← Về trang chủ</a>

        <!-- Form thêm/sửa -->
        <div class="form-container">
            <h2><?= $editFlower ? 'Sửa hoa' : 'Thêm hoa mới' ?></h2>
            <form method="POST">
                <input type="hidden" name="action" value="<?= $editFlower ? 'update' : 'add' ?>">
                <?php if ($editFlower): ?>
                    <input type="hidden" name="id" value="<?= $editFlower['id'] ?>">
                <?php endif; ?>

                <div class="form-group">
                    <label>Tên hoa:</label>
                    <input type="text" name="name" value="<?= $editFlower ? htmlspecialchars($editFlower['name']) : '' ?>" required>
                </div>

                <div class="form-group">
                    <label>Mô tả:</label>
                    <textarea name="description" required><?= $editFlower ? htmlspecialchars($editFlower['description']) : '' ?></textarea>
                </div>

                <div class="form-group">
                    <label>Đường dẫn ảnh:</label>
                    <input type="text" name="image" value="<?= $editFlower ? htmlspecialchars($editFlower['image']) : 'hoadep/' ?>" required>
                </div>

                <button type="submit"><?= $editFlower ? 'Cập nhật' : 'Thêm mới' ?></button>
                <?php if ($editFlower): ?>
                    <a href="admin.php" style="margin-left: 10px; padding: 10px 20px; background: #999; color: white; text-decoration: none; border-radius: 5px;">Hủy</a>
                <?php endif; ?>
            </form>
        </div>

        <!-- Bảng danh sách -->
        <table>
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
                <?php foreach ($_SESSION['flowers'] as $flower): ?>
                <tr>
                    <td><?= $flower['id'] ?></td>
                    <td><?= htmlspecialchars($flower['name']) ?></td>
                    <td><?= substr(htmlspecialchars($flower['description']), 0, 100) ?>...</td>
                    <td><img src="<?= htmlspecialchars($flower['image']) ?>" alt="<?= htmlspecialchars($flower['name']) ?>"></td>
                    <td class="actions">
                        <a href="?edit=<?= $flower['id'] ?>" class="edit">Sửa</a>
                        <a href="?delete=<?= $flower['id'] ?>" class="delete" onclick="return confirm('Bạn có chắc muốn xóa?')">Xóa</a>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>