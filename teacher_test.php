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

if (mysqli_num_rows($teacherResult) == 0) {
    header("Location: access_denied.php");
    exit();
}

$teacher = mysqli_fetch_assoc($teacherResult);
$teacher_id = $teacher['teacher_id'];

$stmt = $conn->prepare("SELECT test_id, test_name, test_code FROM tests WHERE teacher_id = ?");
$stmt->bind_param("i", $teacher_id);
$stmt->execute();
$tests = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />

    <title>Panel nauczyciela</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/teacher_test.css">
</head>
<body>
    <div class="container text-center pt-5">
    <h2 class="title">Twoje testy</h2>
    <ul class="test_list">
        <?php while ($test = $tests->fetch_assoc()): ?>
            <li>
                <?="<span class='test_name'>Nazwa testu:</span> ".htmlspecialchars($test['test_name'])." <span class='text-success fs-2'>(</span><span class='test_name'>kod: </span>".htmlspecialchars($test['test_code'])."<span class='text-success fs-2'>)</span>" ?>
                - <a class="test_link" href="view_test_teacher.php?test_id=<?= $test['test_id'] ?>">Podgląd testu</a>
                - <a class="test_link" href="view_results.php?test_id=<?= $test['test_id'] ?>">Wyniki uczniów</a>
                - <a class="test_link" href="remove_test.php?test_id=<?= $test['test_id'] ?>" onclick="return confirm('Czy na pewno chcesz usunąć ten test?')">Usuń test</a>
            </li>
        <?php endwhile; ?>
    </ul>
    </div>
    
    <a class='logout-btn' href='index_teachers.php'>Powrót</a>

    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
</body>
</html>
