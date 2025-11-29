<?php global $flowers;
include 'data/hoa.php'; ?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>14 loại hoa tuyệt đẹp</title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body { font-family: Arial, sans-serif; line-height: 1.6; background-color: #f4f4f4; }
        .container { max-width: 1200px; margin: 0 auto; padding: 20px; }
        h1 { text-align: center; color: #333; margin-bottom: 30px; padding: 20px; background: white; border-radius: 5px; }
        .flower-item { background: white; margin-bottom: 30px; padding: 20px; border-radius: 5px; box-shadow: 0 2px 5px rgba(0,0,0,0.1); }
        .flower-item h2 { color: #e91e63; margin-bottom: 15px; }
        .flower-item img { width: 100%; max-width: 600px; height: auto; margin: 15px 0; border-radius: 5px; }
        .flower-item p { color: #666; text-align: justify; }
        .admin-link { text-align: center; margin: 20px 0; }
        .admin-link a { background: #4CAF50; color: white; padding: 10px 20px; text-decoration: none; border-radius: 5px; }
    </style>
</head>
<body>
    <div class="container">
        <h1>14 loại hoa tuyệt đẹp thích hợp trồng để khoe hương sắc dịp xuân hè</h1>

        <div class="admin-link">
            <a href="admin.php">Trang quản trị</a>
        </div>

        <?php foreach ($flowers as $flower): ?>
        <div class="flower-item">
            <h2><?= htmlspecialchars($flower['name']) ?></h2>
            <p><?= htmlspecialchars($flower['description']) ?></p>
            <img src="<?= htmlspecialchars($flower['image']) ?>" alt="<?= htmlspecialchars($flower['name']) ?>">
            <?php if (!empty($flower['image2'])): ?>
                <img src="<?= htmlspecialchars($flower['image2']) ?>" alt="<?= htmlspecialchars($flower['name']) ?>">
            <?php endif; ?>


        </div>
        <?php endforeach; ?>
    </div>
</body>
</html>