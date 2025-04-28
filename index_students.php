<?php
session_start();
if (!isset($_SESSION['email'])) {
    header("Location: login.php");
    exit();
}

include 'db_connect.php';

$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$userId = $user['user_id'];


?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>EduZSP</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/index_students.css">
</head>
<body>
<h1 class="role">Twoja rola: Uczeń 
        <?php
            echo '('.$user['first_name'].' '.$user['surename'].')';
        ?>
    
    </h1>
    <div class="container">
        <p class="options ">
            Dostępne opcje:
        </p>
        <div class="options__box">
            <form action="view_test.php?code=" method="GET">
                <label for="code">
                    <input class="options__btn options__btn--input"type="text" placeholder="Wpisz kod do testu" name="code">
                </label>
                <button type="submit" class="options__btn">Przejdź do testu</button>
            </form>
            
        </div>
    </div>

    <a class="logout-btn" href="logout.php">Wyloguj się</a>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>