<?php
session_start();
if(!isset($_SESSION['email'])) {
    header("Location: login.php");
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

?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index_teachers.css">
</head>
<body>
    <h1 class="role">Twoja rola: Nauczyciel 
        <?php
            echo '('.$user['first_name'].' '.$user['surename'].')';
        ?>
    
    </h1>
    <div class="container">
        <p class="options ">
            Dostępne opcje:
        </p>
        <div class="options__box">
            <a href="create_test.php" class="options__btn">Stwórz test</a>
            <a href="teacher_test.php" class="options__btn">Twoje testy</a>
        </div>
    </div>
    <?php
        $adminQuery = "SELECT * from administrators WHERE user_id =".$userId;
        $adminResult = mysqli_query($conn, $adminQuery);
        if(mysqli_num_rows($adminResult) > 0){
            echo "<a class='logout-btn' href='index_admins.php'>Powrót</a>";
        } else{
            echo "<a class='logout-btn' href='logout.php'>Wyloguj się</a>";
        }
    ?>
</body>
</html>