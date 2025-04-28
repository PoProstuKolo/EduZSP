<?php
include 'db_connect.php';

$first_name = $_POST['first_name'];
$surename = $_POST['surename'];
$mobile_number = $_POST['mobile_number'];
$email = $_POST['email'];
$password = $_POST['password'];


// $hashed_password = md5($password);

$sql = "INSERT INTO users (first_name, surename, mobile_number, email, password, active) VALUES ('$first_name', '$surename', '$mobile_number', '$email', '$password', 0)";

if ($conn->query($sql) === TRUE) {
    echo "Rejestracja zakończona pomyślnie!";
} else {
    echo "Błąd podczas rejestracji: " . $conn->error;
}


$conn->close();
?>