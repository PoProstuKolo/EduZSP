<?php
session_start();

if(!isset($_SESSION['email'])) {
    header("Location: index.php");
    exit();
}

include 'db_connect.php';

$email = $_SESSION['email'];
$query = "SELECT * FROM users WHERE email='$email'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$userId = $user['user_id'];

$adminQuery = "SELECT * FROM administrators WHERE user_id='$userId'";
$adminResult = mysqli_query($conn, $adminQuery);

if(mysqli_num_rows($adminResult) == 0) {
    header("Location: access_denied.php");
    exit();
}

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    $query = "SELECT * FROM users WHERE user_id='$user_id'";
    $result = mysqli_query($conn, $query);

    if (mysqli_num_rows($result) > 0) {
        $user = mysqli_fetch_assoc($result);
    } else {
        echo "<p>Użytkownik nie znaleziony.</p>";
        exit();
    }
} else {
    echo "<p>Niepoprawne żądanie.</p>";
    exit();
}

?>

<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Informacje o użytkowniku</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/user_detail.css">
</head>
<body>
    <div class="container">
        <h1 class="mb-5 mb-lg-0">Informacje o użytkowniku</h1>
        <p><span class="info__bold">ID:</span> <?php echo $user['user_id']; ?></p>
        <p><span class="info__bold">Imię:</span> <?php echo $user['first_name']; ?></p>
        <p><span class="info__bold">Nazwisko:</span> <?php echo $user['surename']; ?></p>
        <p><span class="info__bold">Numer telefonu:</span> <?php echo $user['mobile_number']; ?></p>
        <p><span class="info__bold">Email:</span> <?php echo $user['email']; ?></p>
        <p><span class="info__bold">Konto aktywne:</span> <?php echo $user['active'] ? "Tak" : "Nie"; ?></p>
        <?php
            $sql_check_teacher = "SELECT * FROM teachers WHERE user_id=".$user_id;
            $result_check_teacher = $conn->query($sql_check_teacher);
            echo "<p><span class='info__bold'>Nauczyciel:</span> " .($result_check_teacher->num_rows > 0 ? "Tak" : "Nie") . "</p>";
            
            $sql_check_ban = "SELECT * FROM bans WHERE user_id=".$user_id;
            $result_check_ban = $conn->query($sql_check_ban);
            echo "<p><span class='info__bold'>Aktywny ban:</span> " .($result_check_ban->num_rows > 0 ? "Tak" : "Nie") . "</p>";
                ?>
        <a href="admin_panel.php" class="info__btn">Powrót</a>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>
