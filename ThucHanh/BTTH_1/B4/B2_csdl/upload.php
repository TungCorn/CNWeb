<?php
require_once 'config/data.php';

$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_FILES['quiz_file'])) {
    $file = $_FILES['quiz_file'];

    if ($file['error'] == 0) {
        $content = file_get_contents($file['tmp_name']);

        // Parse câu hỏi từ file
        $questions = parseQuizFile($content);

        if (empty($questions)) {
            $message = "Không tìm thấy câu hỏi hợp lệ trong file!";
        } else {
            // Lưu vào database
            $database = new Database();
            $conn = $database->getConnection();

            try {
                // Bắt đầu transaction
                $conn->beginTransaction();

                // Xóa toàn bộ câu hỏi cũ
                $stmt = $conn->prepare("DELETE FROM questions");
                $stmt->execute();

                // Prepare statement cho insert
                $stmt = $conn->prepare("INSERT INTO questions (question, option_a, option_b, option_c, option_d, correct_answer, is_multiple) VALUES (?, ?, ?, ?, ?, ?, ?)");

                $success_count = 0;
                foreach ($questions as $q) {
                    if (isset($q['question']) && isset($q['option_a']) && isset($q['option_b']) &&
                        isset($q['option_c']) && isset($q['option_d']) && isset($q['correct_answer'])) {
                        $stmt->execute([
                            $q['question'],
                            $q['option_a'],
                            $q['option_b'],
                            $q['option_c'],
                            $q['option_d'],
                            $q['correct_answer'],
                            $q['is_multiple'] ? 1 : 0
                        ]);
                        $success_count++;
                    }
                }

                $conn->commit();
                $message = "Upload thành công " . $success_count . " câu hỏi mới (đã xóa câu hỏi cũ)!";
            } catch (Exception $e) {
                // Kiểm tra xem có transaction đang active không
                if ($conn->inTransaction()) {
                    $conn->rollBack();
                }
                $message = "Lỗi: " . $e->getMessage();
            }
        }
    } else {
        $message = "Lỗi upload file!";
    }
}

function parseQuizFile($content) {
    $questions = [];
    $lines = explode("\n", $content);
    $current_question = null;
    $i = 0;

    while ($i < count($lines)) {
        $line = trim($lines[$i]);

        if (empty($line)) {
            $i++;
            continue;
        }

        // Bắt đầu câu hỏi mới
        if (!preg_match('/^([A-D]\.|ANSWER:)/i', $line)) {
            if ($current_question && isset($current_question['correct_answer'])) {
                $questions[] = $current_question;
            }

            $current_question = [
                'question' => $line,
                'option_a' => '',
                'option_b' => '',
                'option_c' => '',
                'option_d' => '',
                'correct_answer' => '',
                'is_multiple' => false
            ];
        }
        elseif (preg_match('/^([A-D])\.\s*(.+)$/u', $line, $matches)) {
            if ($current_question) {
                $option = strtolower($matches[1]);
                $current_question['option_' . $option] = trim($matches[2]);
            }
        }
        elseif (preg_match('/^ANSWER:\s*(.+)$/i', $line, $matches)) {
            if ($current_question) {
                $answer = trim($matches[1]);
                $current_question['correct_answer'] = $answer;
                // Kiểm tra có nhiều đáp án không (có dấu phẩy)
                $current_question['is_multiple'] = strpos($answer, ',') !== false;
            }
        }

        $i++;
    }

    if ($current_question && !empty($current_question['correct_answer'])) {
        $questions[] = $current_question;
    }

    return $questions;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>Upload Quiz</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Upload File Quiz</h1>

    <?php if ($message): ?>
        <div class="alert <?php echo strpos($message, 'thành công') !== false ? 'alert-success' : 'alert-danger'; ?>">
            <?php echo $message; ?>
        </div>
    <?php endif; ?>

    <div class="card">
        <div class="card-body">
            <form method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label class="form-label">Chọn file Quiz.txt:</label>
                    <input type="file" name="quiz_file" accept=".txt" class="form-control" required>
                    <small class="text-muted">
                        <strong>Định dạng file:</strong><br>
                        Câu hỏi<br>
                        A. Đáp án A<br>
                        B. Đáp án B<br>
                        C. Đáp án C<br>
                        D. Đáp án D<br>
                        ANSWER: A
                    </small>
                </div>
                <button type="submit" class="btn btn-primary">Upload và Lưu vào CSDL</button>
            </form>
        </div>
    </div>

    <div class="mt-3">
        <a href="index.php" class="btn btn-secondary">Xem danh sách câu hỏi</a>
    </div>
</div>
</body>
</html>
