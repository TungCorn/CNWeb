<?php
require_once 'config/data.php';

$database = new Database();
$conn = $database->getConnection();

// Lấy câu hỏi từ database
$stmt = $conn->query("SELECT * FROM questions ORDER BY id");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Bài Trắc Nghiệm</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1 class="text-center mb-4">Bài Trắc Nghiệm</h1>
    <div class="text-end mb-3">
        <a href="upload.php" class="btn btn-primary">Upload Quiz Mới</a>
    </div>
    <form method="POST" action="result.php">
        <?php foreach ($questions as $index => $q): ?>
            <div class="card mb-3">
                <div class="card-body">
                    <h5>Câu <?php echo $index + 1; ?>: <?php echo htmlspecialchars($q['question']); ?></h5>
                    <?php if ($q['is_multiple']): ?>
                        <p class="text-danger"><small><strong>Chọn nhiều đáp án</strong></small></p>
                    <?php endif; ?>

                    <?php foreach (['A', 'B', 'C', 'D'] as $opt): ?>
                        <div class="form-check">
                            <?php if ($q['is_multiple']): ?>
                                <input class="form-check-input" type="checkbox"
                                       name="question<?php echo $q['id']; ?>[]"
                                       value="<?php echo $opt; ?>"
                                       id="q<?php echo $q['id'].$opt; ?>">
                            <?php else: ?>
                                <input class="form-check-input" type="radio"
                                       name="question<?php echo $q['id']; ?>"
                                       value="<?php echo $opt; ?>"
                                       id="q<?php echo $q['id'].$opt; ?>">
                            <?php endif; ?>
                            <label class="form-check-label" for="q<?php echo $q['id'].$opt; ?>">
                                <?php echo $opt; ?>. <?php echo htmlspecialchars($q['option_'.strtolower($opt)]); ?>
                            </label>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
        <button type="submit" class="btn btn-success">Nộp bài</button>
    </form>

</div>
</body>
</html>
