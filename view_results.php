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

// Sprawdź nazwę testu
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

// Pobierz wyniki uczniów
$stmt = $conn->prepare("SELECT u.user_id, u.email AS username, u.first_name, u.surename, 
                        (SELECT COUNT(*) FROM student_answers sa 
                         JOIN answers a ON sa.answer = a.answer_id 
                         WHERE sa.user_id = u.user_id AND sa.question_id IN 
                         (SELECT question_id FROM questions WHERE test_id = ?) 
                         AND a.is_correct = 1) AS correct_answers,
                        (SELECT COUNT(*) FROM student_answers sa 
                         WHERE sa.user_id = u.user_id AND sa.question_id IN 
                         (SELECT question_id FROM questions WHERE test_id = ?)) AS total_answers
                        FROM users u
                        WHERE u.user_id IN (SELECT DISTINCT user_id FROM student_answers WHERE question_id IN 
                        (SELECT question_id FROM questions WHERE test_id = ?))");

$stmt->bind_param("iii", $test_id, $test_id, $test_id);
$stmt->execute();
$results = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
	<meta name="robots" content="noindex, nofollow" />
    <title>Wyniki testu: <?= htmlspecialchars($test_name) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/view_results.css">
</head>
<body>
    <div class="container text-center pt-5">
    <h2 class="title">Wyniki testu: <?= htmlspecialchars($test_name) ?></h2>
    <div class="table-responsive">
    <table>
        <thead>
            <tr>
                <th>Użytkownik</th>
                <th>Poprawne odpowiedzi</th>
                <th>Błędne odpowiedzi</th>
                <th>Ocena</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($result = $results->fetch_assoc()): ?>
                <?php
                $correct_answers = $result['correct_answers'];
                $total_answers = $result['total_answers'];
                $wrong_answers = $total_answers - $correct_answers;
                $score_percentage = ($correct_answers / $total_answers) * 100;

                if ($score_percentage == 100) {
                    $grade = "6 | Celujący";
                } elseif ($score_percentage >= 90) {
                    $grade = "5 | Bardzo dobry";
                } elseif ($score_percentage >= 75) {
                    $grade = "4 | Dobry";
                } elseif ($score_percentage >= 60) {
                    $grade = "3 | Dostateczny";
                } elseif ($score_percentage >= 35) {
                    $grade = "2 | Dopuszczający";
                } else {
                    $grade = "1 | Niedostateczny";
                }
                ?>
                <tr>
                    <td>
                        <a class="student" href="view_student_results.php?user_id=<?= $result['user_id'] ?>&test_id=<?= $test_id ?>"><?= htmlspecialchars($result['first_name'])." ".htmlspecialchars($result['surename']) ?></a>
                    </td>
                    <td><?= $correct_answers ?></td>
                    <td><?= $wrong_answers ?></td>
                    <td><?= $grade ?></td>
                </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    </div>

    </div>
    <a class='logout-btn' href='teacher_test.php'>Powrót</a>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>