<?php
$quizFile = __DIR__ . '/Quiz.txt';
$questions = [];

// Đọc và phân tích file quiz
if (file_exists($quizFile)) {
    $content = file_get_contents($quizFile);
    $content = str_replace("\r\n", "\n", $content);
    $blocks = explode("\n\n", trim($content));

    foreach ($blocks as $index => $block) {
        $lines = array_filter(array_map('trim', explode("\n", $block)));
        if (count($lines) < 6) continue;

        $question = [
                'number' => $index + 1,
                'question' => '',
                'answer' => ''
        ];

        foreach ($lines as $line) {
            if (stripos($line, 'ANSWER:') === 0) {
                $question['answer'] = trim(str_replace(['ANSWER:', 'Answer:'], '', $line));
            } elseif (empty($question['question'])) {
                $question['question'] = $line;
            }
        }

        if (!empty($question['question'])) {
            $questions[] = $question;
        }
    }
}

// Tính điểm
$score = 0;
$totalQuestions = count($questions);
$results = [];

foreach ($questions as $q) {
    // Sửa tên input từ 'question_' thành 'q'
    $inputName = 'q' . $q['number'];
    $userAnswer = isset($_POST[$inputName]) ? $_POST[$inputName] : '';

    // Xử lý checkbox (mảng)
    if (is_array($userAnswer)) {
        sort($userAnswer);
        $userAnswer = implode(',', $userAnswer);
    }

    // Chuẩn hóa đáp án để so sánh
    $correctAnswer = strtoupper(str_replace([' ', ','], ['', ','], $q['answer']));
    $userAnswerClean = strtoupper(str_replace([' ', ','], ['', ','], $userAnswer));

    $isCorrect = ($userAnswerClean === $correctAnswer);
    if ($isCorrect) $score++;

    $results[] = [
            'number' => $q['number'],
            'question' => $q['question'],
            'correct' => $isCorrect,
            'userAnswer' => $userAnswer ?: 'Không trả lời',
            'correctAnswer' => $q['answer']
    ];
}

$percentage = $totalQuestions > 0 ? ($score / $totalQuestions) * 100 : 0;
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kết Quả Bài Thi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 0;
        }
        .result-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.3);
        }
        .score-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            border-radius: 15px;
            padding: 40px;
            text-align: center;
            margin-bottom: 30px;
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .score-number {
            font-size: 64px;
            font-weight: bold;
            margin-bottom: 10px;
        }
        .score-percentage {
            font-size: 28px;
            opacity: 0.9;
        }
        .result-item {
            border-radius: 10px;
            padding: 20px;
            margin-bottom: 20px;
            border-left: 5px solid;
            transition: transform 0.2s;
        }
        .result-item:hover {
            transform: translateX(5px);
        }
        .correct-answer {
            background: #d4edda;
            border-color: #28a745;
        }
        .wrong-answer {
            background: #f8d7da;
            border-color: #dc3545;
        }
        .question-number {
            display: inline-block;
            width: 35px;
            height: 35px;
            border-radius: 50%;
            background: white;
            color: #667eea;
            font-weight: bold;
            text-align: center;
            line-height: 35px;
            margin-right: 10px;
        }
        .answer-badge {
            display: inline-block;
            padding: 5px 12px;
            border-radius: 15px;
            font-size: 13px;
            font-weight: 600;
            margin-top: 10px;
        }
        .user-answer {
            background: #e3f2fd;
            color: #1976d2;
        }
        .correct-badge {
            background: #c8e6c9;
            color: #2e7d32;
        }
        .back-button {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 15px 40px;
            font-size: 16px;
            font-weight: bold;
            border-radius: 30px;
            transition: transform 0.2s;
        }
        .back-button:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
        .pass-status {
            font-size: 20px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
<div class="result-container">
    <h1 class="text-center mb-4">🎯 Kết Quả Bài Thi</h1>

    <div class="score-card">
        <div class="score-number"><?= $score ?> / <?= $totalQuestions ?></div>
        <div class="score-percentage"><?= number_format($percentage, 1) ?>%</div>
        <div class="pass-status">
            <?php if ($percentage >= 80): ?>
                🎉 Xuất sắc!
            <?php elseif ($percentage >= 60): ?>
                👍 Khá tốt!
            <?php elseif ($percentage >= 40): ?>
                💪 Cần cố gắng thêm!
            <?php else: ?>
                📚 Hãy ôn tập lại nhé!
            <?php endif; ?>
        </div>
    </div>

    <h4 class="mb-3">📋 Chi tiết các câu hỏi:</h4>

    <?php foreach ($results as $r): ?>
        <div class="result-item <?= $r['correct'] ? 'correct-answer' : 'wrong-answer' ?>">
            <div class="d-flex align-items-start">
                <span class="question-number"><?= $r['number'] ?></span>
                <div class="flex-grow-1">
                    <div class="mb-2">
                        <strong><?= $r['correct'] ? '✅' : '❌' ?></strong>
                        <?= htmlspecialchars($r['question']) ?>
                    </div>
                    <div>
                            <span class="answer-badge user-answer">
                                Bạn chọn: <strong><?= htmlspecialchars($r['userAnswer']) ?></strong>
                            </span>
                        <?php if (!$r['correct']): ?>
                            <span class="answer-badge correct-badge ms-2">
                                    Đáp án đúng: <strong><?= htmlspecialchars($r['correctAnswer']) ?></strong>
                                </span>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    <?php endforeach; ?>

    <div class="text-center mt-4">
        <a href="index.php" class="btn btn-primary back-button">
            🔄 Làm Lại Bài Thi
        </a>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
