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
$number_of_questions = $_GET['number_of_questions'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    for ($i = 1; $i <= $number_of_questions; $i++) {
        $question_text = $_POST['question_text_' . $i];
        $stmt = $conn->prepare("INSERT INTO questions (test_id, question_text) VALUES (?, ?)");
        $stmt->bind_param("is", $test_id, $question_text);
        $stmt->execute();
        $question_id = $stmt->insert_id;

        for ($j = 1; $j <= 4; $j++) {
            $answer_text = $_POST['answer_text_' . $i . '_' . $j];
            $is_correct = $_POST['is_correct_' . $i] == $j ? 1 : 0;
            $stmt = $conn->prepare("INSERT INTO answers (question_id, answer_text, is_correct) VALUES (?, ?, ?)");
            $stmt->bind_param("isi", $question_id, $answer_text, $is_correct);
            $stmt->execute();
        }
    }

    header("Location: index_teachers.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
    <title>Dodaj pytania</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

<link rel="stylesheet" href="./css/add_questions.css">
</head>
<body>
    <div class="container text-center pt-5">
    <h2 class="title">Dodaj pytania do testu</h2>
    <form method="post" action="" class="form">
        <div class="row g-5">
            <?php for ($i = 1; $i <= $number_of_questions; $i++): ?>
                <div class="col-4">
                    <div class="question">
                    <h3>Pytanie <?= $i ?></h3>
                    <label for="question_text_<?= $i ?>">Treść pytania:</label>
                    <textarea id="question_text_<?= $i ?>" name="question_text_<?= $i ?>"   required></textarea><br>
                    <?php for ($j = 1; $j <= 4; $j++): ?>
                        <label for="answer_text_<?= $i ?>_<?= $j ?>">Odpowiedź <?= chr(64   + $j) ?>:</label>
                        <input type="text" id="answer_text_<?= $i ?>_<?= $j ?>"     name="answer_text_<?= $i ?>_<?= $j ?>" required><br>
                    <?php endfor; ?>
                    <label for="is_correct_<?= $i ?>">Poprawna odpowiedź (numer     odpowiedzi: 1 = a, 2 = b, 3 = c, 4 = d):</label>
                    <input type="number" id="is_correct_<?= $i ?>" name="is_correct_<?=     $i ?>" min="1" max="4" maxlength="1" oninput="this.value = this.value.  slice(0, this.maxLength);" required><br>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
        <button class="form__btn" type="submit" value="Zapisz pytania"> Zapisz pytania</button>
    </form>
    </div>
    <a class='logout-btn' href='create_test.php'>Powrót</a>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>

</body>
</html>
