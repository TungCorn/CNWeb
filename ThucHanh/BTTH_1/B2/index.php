<?php
$quizFile = __DIR__ . '/Quiz.txt';
$questions = [];

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
                'options' => [],
                'answer' => ''
        ];

        foreach ($lines as $line) {
            // Kiểm tra dòng ANSWER
            if (stripos($line, 'ANSWER:') === 0) {
                $question['answer'] = trim(str_replace(['ANSWER:', 'Answer:'], '', $line));
            }
            // Kiểm tra đáp án A. B. C. D.
            elseif (preg_match('/^([A-D])\.\s*(.+)$/i', $line, $matches)) {
                $question['options'][] = [
                        'letter' => strtoupper($matches[1]),
                        'text' => trim($matches[2])
                ];
            }
            // Nếu chưa có câu hỏi thì dòng này là câu hỏi
            elseif (empty($question['question'])) {
                $question['question'] = $line;
            }
        }

        if (!empty($question['question']) && !empty($question['options'])) {
            $questions[] = $question;
        }
    }
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Android</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            padding: 30px 0;
        }
        .quiz-container {
            max-width: 900px;
            margin: 0 auto;
            background: white;
            border-radius: 15px;
            padding: 40px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.2);
        }
        .question-card {
            background: #f8f9fa;
            border-radius: 10px;
            padding: 25px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }
        .question-header {
            display: flex;
            align-items: flex-start;
            margin-bottom: 20px;
        }
        .question-number {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
            margin-right: 15px;
            flex-shrink: 0;
        }
        .question-text {
            font-size: 17px;
            font-weight: 600;
            color: #333;
            flex: 1;
        }
        .form-check {
            background: white;
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 8px;
            margin-bottom: 10px;
            transition: all 0.2s;
            cursor: pointer;
        }
        .form-check:hover {
            border-color: #667eea;
            background: #f0f3ff;
        }
        .form-check-input:checked ~ .form-check-label {
            color: #667eea;
            font-weight: 600;
        }
        .form-check-input:checked {
            background-color: #667eea;
            border-color: #667eea;
        }
        .multi-badge {
            background: #ff9800;
            color: white;
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 11px;
            margin-left: 10px;
        }
        .submit-btn {
            background: linear-gradient(135deg, #667eea, #764ba2);
            border: none;
            padding: 15px 50px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 30px;
            transition: transform 0.2s;
        }
        .submit-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(102, 126, 234, 0.4);
        }
    </style>
</head>
<body>
<div class="quiz-container">
    <h1 class="text-center mb-4">📱 Quiz Android Development</h1>

    <?php if (empty($questions)): ?>
        <div class="alert alert-warning">Không tìm thấy câu hỏi trong file Quiz.txt</div>
    <?php else: ?>
        <div class="alert alert-info text-center mb-4">
            Tổng số câu hỏi: <strong><?= count($questions) ?></strong>
        </div>

        <form method="POST" action="result.php" id="quizForm">
            <?php foreach ($questions as $q): ?>
                <?php
                $isMulti = strpos($q['answer'], ',') !== false;
                $inputType = $isMulti ? 'checkbox' : 'radio';
                $inputName = $isMulti ? "q{$q['number']}[]" : "q{$q['number']}";
                ?>
                <div class="question-card">
                    <div class="question-header">
                        <div class="question-number"><?= $q['number'] ?></div>
                        <div class="question-text">
                            <?= htmlspecialchars($q['question']) ?>
                            <?php if ($isMulti): ?>
                                <span class="multi-badge">Nhiều đáp án</span>
                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="options-list ms-5">
                        <?php foreach ($q['options'] as $option): ?>
                            <div class="form-check">
                                <input class="form-check-input"
                                       type="<?= $inputType ?>"
                                       name="<?= $inputName ?>"
                                       id="q<?= $q['number'] ?>_<?= $option['letter'] ?>"
                                       value="<?= $option['letter'] ?>">
                                <label class="form-check-label" for="q<?= $q['number'] ?>_<?= $option['letter'] ?>">
                                    <strong><?= $option['letter'] ?>.</strong> <?= htmlspecialchars($option['text']) ?>
                                </label>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <input type="hidden" name="answer_<?= $q['number'] ?>" value="<?= htmlspecialchars($q['answer']) ?>">
                </div>
            <?php endforeach; ?>

            <div class="text-center mt-4">
                <button type="submit" class="btn btn-primary submit-btn">📝 Nộp Bài</button>
            </div>
        </form>
    <?php endif; ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('quizForm')?.addEventListener('submit', function(e) {
        const answered = new Set();
        document.querySelectorAll('input[type="radio"]:checked, input[type="checkbox"]:checked').forEach(input => {
            const name = input.name.replace('[]', '');
            answered.add(name);
        });

        if (answered.size < <?= count($questions) ?>) {
            if (!confirm(`Bạn mới trả lời ${answered.size}/<?= count($questions) ?> câu. Nộp bài?`)) {
                e.preventDefault();
            }
        }
    });
</script>
</body>
</html>
