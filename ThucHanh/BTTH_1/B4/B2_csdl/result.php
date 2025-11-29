<?php
require_once 'config/data.php';

$database = new Database();
$conn = $database->getConnection();

$stmt = $conn->query("SELECT * FROM questions ORDER BY id");
$questions = $stmt->fetchAll(PDO::FETCH_ASSOC);

$score = 0;
$total = count($questions);

foreach ($questions as $q) {
    $user_answer = $_POST['question' . $q['id']] ?? null;

    if ($q['is_multiple']) {
        // Xử lý câu nhiều đáp án
        if (is_array($user_answer)) {
            $user_answer = implode(', ', $user_answer);
        } else {
            $user_answer = '';
        }
    }

    // So sánh đáp án (loại bỏ khoảng trắng thừa)
    $correct = str_replace(' ', '', $q['correct_answer']);
    $user = str_replace(' ', '', $user_answer ?? '');

    if ($correct === $user) {
        $score++;
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Kết Quả</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <div class="alert alert-success text-center">
        <h2>Kết quả: <?php echo $score; ?>/<?php echo $total; ?></h2>
        <p>Điểm: <?php echo round(($score / $total) * 10, 2); ?></p>
    </div>
    <a href="index.php" class="btn btn-primary">Làm lại</a>
</div>
</body>
</html>
