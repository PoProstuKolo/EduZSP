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

$user_id = $_GET['user_id'];
$test_id = $_GET['test_id'];

// Pobierz dane ucznia
$stmt = $conn->prepare("SELECT first_name, surename FROM users WHERE user_id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Nie znaleziono ucznia.";
    exit();
}

$student = $result->fetch_assoc();
$name = $student['first_name'];
$surename = $student['surename'];
// Pobierz szczegółowe odpowiedzi ucznia i poprawne odpowiedzi dla testu
$stmt = $conn->prepare("SELECT q.question_text, sa.answer AS student_answer_id, 
                        (SELECT answer_text FROM answers WHERE question_id = q.question_id AND is_correct = 1 LIMIT 1) AS correct_answer_text,
                        sa.answer AS student_answer_id, a.answer_text AS student_answer_text, a.is_correct AS student_answer_correct
                        FROM student_answers sa 
                        JOIN questions q ON sa.question_id = q.question_id 
                        JOIN answers a ON sa.answer = a.answer_id 
                        WHERE sa.user_id = ? AND q.test_id = ?");
$stmt->bind_param("ii", $user_id, $test_id);
$stmt->execute();
$answers = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow" />
    <title>Odpowiedzi ucznia: <?= htmlspecialchars($name." ".$surename) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/view_student_results.css">
</head>
<body>
    <div class="container text-center pt-5">
    <h2 class="title">Odpowiedzi ucznia: <?= htmlspecialchars($name." ".$surename) ?></h2>
    <table class="table__table mt-5">
        <thead class="table__thead">
            <tr class="table__tr">
                <th class="table__th">Pytanie</th>
                <th class="table__th">Odpowiedź ucznia</th>
                <th class="table__th">Poprawna odpowiedź</th>
            </tr>
        </thead>
        <tbody class="table__tbody">
            <?php while ($answer = $answers->fetch_assoc()): ?>
                <tr class="table__tr">
                    <td class="table__td"><?= htmlspecialchars($answer['question_text']) ?></td>
                    <td class="table__td">
                        <?= htmlspecialchars($answer['student_answer_text']) ?>
                        <?= $answer['student_answer_correct'] ? "(Poprawna)" : "(Niepoprawna)" ?>
                    </td>
                    <td class="table__td">
                        <?= htmlspecialchars($answer['correct_answer_text']) ?>
                    </td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>
    <a class='logout-btn' href="view_results.php?test_id=<?= htmlspecialchars($test_id)?>">Powrót</a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
