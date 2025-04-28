<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$userId = $user['user_id'];

$teacherQuery = "SELECT * FROM teachers WHERE user_id='$userId'";
$teacherResult = mysqli_query($conn, $teacherQuery);

if(mysqli_num_rows($teacherResult) == 0) {
    header("Location: access_denied.php");
    exit();
}

$test_id = $_GET['test_id'];

$stmt = $conn->prepare("SELECT test_name FROM tests WHERE test_id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Nie znaleziono testu.";
    exit();
}

$test = $result->fetch_assoc();
$test_name = $test['test_name'];

$stmt = $conn->prepare("SELECT question_id, question_text FROM questions WHERE test_id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();
$questions = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow" />
    <title>Test: <?= htmlspecialchars($test_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/view_test_teacher.css">
</head>
<body>
    <div class="container text-center pt-5">
    <h2 class="title">Podgląd testu: <?= htmlspecialchars($test_name) ?></h2>
    <div class="row">
    <?php while ($question = $questions->fetch_assoc()): ?>
        <div class="col-4">
        <div class="question">
            <p class="question_title"><span class="bold">Pytanie:</span> <?= htmlspecialchars($question['question_text']) ?></p>
            <?php
            $stmt = $conn->prepare("SELECT answer_text, is_correct FROM answers WHERE question_id = ?");
            $stmt->bind_param("i", $question['question_id']);
            $stmt->execute();
            $answers = $stmt->get_result();
            ?>
            <ul class="answer_list">
                <?php while ($answer = $answers->fetch_assoc()): ?>
                    <li <?= $answer['is_correct'] ? 'class="correct"' : '' ?>><?= htmlspecialchars($answer['answer_text']) ?></li>
                <?php endwhile; ?>
            </ul>
        </div>
        </div>
    <?php endwhile; ?>
    </div>
    </div>
    <a class='logout-btn' href='teacher_test.php'>Powrót</a>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
