<?php
session_start();
if(!isset($_SESSION['email'])){
    header('Location: index.php');
    exit();
}

include 'db_connect.php'; // Plik z połączeniem do bazy danych

$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$user_id = $user['user_id'];


foreach ($_POST as $key => $value) {
    if (strpos($key, 'answer_') === 0) {
        $question_id = str_replace('answer_', '', $key);
        $answer_id = $value;
        
        $stmt = $conn->prepare("INSERT INTO student_answers (user_id, question_id, answer) VALUES (?, ?, ?)");
        $stmt->bind_param("iis", $user_id, $question_id, $answer_id);
        $stmt->execute();
    }
}

echo'
<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduZSP | Dziękujemy!</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
    integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
<link rel="stylesheet" href="./css/submit_answers.css">
</head>
<body class="container text-center h-100">
    <h1 class="title"> Dziękujemy za wypełnienie testu! </h1>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
    integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
    crossorigin="anonymous"></script>

    <a class="logout-btn" href="index_students.php">Powrót</a>

</body>
</html>';