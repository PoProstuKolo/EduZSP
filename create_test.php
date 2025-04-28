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

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    
    $teacher = mysqli_fetch_assoc($teacherResult);
    $teacher_id = $teacher['teacher_id'];

    $test_name = $_POST['test_name'];
    $number_of_questions = $_POST['number_of_questions'];
    $duration = $_POST['duration'];
    $category = $_POST['category'];

    $stmt = $conn->prepare("INSERT INTO tests (teacher_id, test_name, duration, number_of_questions, category, test_code) VALUES (?, ?, ?, ?, ?, ?)");
    $test_code = substr(str_shuffle("ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789"), 0, 6);
    $stmt->bind_param("isisss", $teacher_id, $test_name, $duration, $number_of_questions, $category, $test_code);
    $stmt->execute();
    $test_id = $stmt->insert_id;

    header("Location: add_questions.php?test_id=" . $test_id . "&number_of_questions=" . $number_of_questions);
    exit();
}
?>

<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />

    <title>Stwórz test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">

    <link rel="stylesheet" href="./css/create_test.css">
</head>

<body>
    <div class="container text-center pt-5">
        <h2 class="title">Stwórz test</h2>
        <form method="post" action="#" class="form">
            <label for="test_name">Nazwa testu:</label>
            <input type="text" id="test_name" name="test_name" required><br>
            <label for="number_of_questions">Ilość pytań:</label>
            <input type="number" id="number_of_questions" name="number_of_questions" required><br>
            <label for="duration">Czas trwania (minuty):</label>
            <input type="number" id="duration" name="duration" required><br>
            <label for="category">Kategoria:</label>
            <input type="text" id="category" name="category" required><br>
            <button class="btn btn-lg form__btn" type="submit" value="Utwórz test"> Utwórz test</button>
        </form>
    </div>

    <a class='logout-btn' href='index_teachers.php'>Powrót</a>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous">
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js"
        integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous">
    </script>
</body>

</html>