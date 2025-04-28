<?php
session_start();

include 'db_connect.php';

if(isset($_POST['email'], $_POST['password'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // $password = md5($password);

    $query = "SELECT * FROM users WHERE email='$email' AND password='$password' AND active=1";
    $result = mysqli_query($conn, $query);
    if(mysqli_num_rows($result) == 1) {
        $user = mysqli_fetch_assoc($result);
        $userId = $user['user_id'];

        $adminQuery = "SELECT * FROM administrators WHERE user_id='$userId'";
        $adminResult = mysqli_query($conn, $adminQuery);

        $teacherQuery = "SELECT * FROM teachers WHERE user_id='$userId'";
        $teacherResult = mysqli_query($conn, $teacherQuery);

        if(mysqli_num_rows($adminResult) == 1){
            $_SESSION['email'] = $email;
            header("Location: index_admins.php");
            exit();
        } elseif(mysqli_num_rows($teacherResult) == 1) {
            $_SESSION['email'] = $email;
            header("Location: index_teachers.php");
            exit();
        } else {
            $_SESSION['email'] = $email;
            header("Location: index_students.php");
            exit();
        }
    } else {
        echo "Błędne dane lub konto jest nieaktywne";
    }
} else {
    echo "Uzupełnij wszystkie pola";
}
?>
