<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$test_id = $_GET['test_id'];

// Sprawdź, czy użytkownik jest nauczycielem
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

// Sprawdź, czy test należy do nauczyciela
$teacher = mysqli_fetch_assoc($teacherResult);
$teacher_id = $teacher['teacher_id'];

$stmt = $conn->prepare("SELECT * FROM tests WHERE test_id = ? AND teacher_id = ?");
$stmt->bind_param("ii", $test_id, $teacher_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    echo "Brak dostępu do tego testu.";
    exit();
}

// Usuń odpowiedzi uczniów powiązane z pytaniami testu
$stmt = $conn->prepare("DELETE sa FROM student_answers sa
                        JOIN questions q ON sa.question_id = q.question_id
                        WHERE q.test_id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();

// Usuń odpowiedzi powiązane z pytaniami testu
$stmt = $conn->prepare("DELETE FROM answers WHERE question_id IN 
                        (SELECT question_id FROM questions WHERE test_id = ?)");
$stmt->bind_param("i", $test_id);
$stmt->execute();

// Usuń pytania powiązane z testem
$stmt = $conn->prepare("DELETE FROM questions WHERE test_id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();

// Usuń test
$stmt = $conn->prepare("DELETE FROM tests WHERE test_id = ?");
$stmt->bind_param("i", $test_id);
$stmt->execute();

header("Location: teacher_test.php");
exit();
?>
