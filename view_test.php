<?php
session_start();
if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

include 'db_connect.php'; // Plik z połączeniem do bazy danych

$test_code = $_GET['code'];

$stmt = $conn->prepare("SELECT test_id, test_name, category, duration FROM tests WHERE test_code = ?");
$stmt->bind_param("s", $test_code);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Nie znaleziono testu o podanym kodzie.";
    exit();
}

$test = $result->fetch_assoc();
$test_id = $test['test_id'];
$test_name = $test['test_name'];
$category = $test['category'];
$duration = $test['duration'];

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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/view_test.css">
</head>

<body>
    <div class="container text-center pt-5">
        <h2 class="title">Test: <?= htmlspecialchars($test_name) ?></h2>
        <h2 class="subtitle">Kategoria: <?= htmlspecialchars($category) ?></h2>
        <p class="countdown">Pozostały czas: <span id="countdown"></span></p>
        <p class="exit-alert">Próba odświeżenia strony lub jej opuszczenia (otworzenie nowej strony w przeglądarce,
            otworzenie innej aplikacji na komputerze) będzie skutkowało przerwaniem egzaminu</p>
        <form id="testForm" method="post" action="submit_answers.php">
            <?php while ($question = $questions->fetch_assoc()): ?>
            <div class="question">
                <p class="question__text"><?= htmlspecialchars($question['question_text']) ?></p>
                <?php
                $stmt = $conn->prepare("SELECT answer_id, answer_text FROM answers WHERE question_id = ?");
                $stmt->bind_param("i", $question['question_id']);
                $stmt->execute();
                $answers = $stmt->get_result();
                ?>
                <?php while ($answer = $answers->fetch_assoc()): ?>
                <label class="question__label">
                    <input class="question__answer" type="radio" name="answer_<?= $question['question_id'] ?>"
                        value="<?= $answer['answer_id'] ?>" required>
                    <?= htmlspecialchars($answer['answer_text']) ?>
                </label><br>
                <?php endwhile; ?>
            </div>
            <?php endwhile; ?>
            <input class="submit-btn" type="submit" value="Zakończ test">
        </form>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous">
    </script>
    <script src="./js/view_test.js"></script>
    <script>
    window.onload = function() {
        const duration = <?php echo $duration * 60; ?>;
        startTimer(duration);

        // Ostrzeżenie przy próbie odświeżenia strony (F5, przyciski)
        window.addEventListener("beforeunload", function(e) {
            e.preventDefault();
            e.returnValue = "Czy na pewno chcesz opuścić stronę?"; // Wymuszony komunikat

        });

        // Blokada klawiszy F5, Ctrl + R
        window.addEventListener("keydown", function(e) {
            if (e.key === "F5" || (e.ctrlKey && e.key === "r") || (e.ctrlKey && e.shiftKey && e.key === "R") || (e.ctrlKey && e.key === "F5")) {
                e.preventDefault();
                document.getElementById("testForm").submit();
            }
        });



        // Zliczanie opuszczeń strony
        window.addEventListener("blur", function() {
            outsideClickCount++;
            if (outsideClickCount === 1) {
                alert("Opuszczenie strony! Powrót jest konieczny do kontynuacji testu.");
            } else if (outsideClickCount === 2) {
                alert("Test zostanie zakończony z powodu ponownego opuszczenia strony.");
                document.getElementById("testForm").submit();
            }
        });
    };
    </script>
</body>

</html>