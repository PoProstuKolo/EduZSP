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

?>


<!DOCTYPE html>
<html lang="pl">
<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" integrity="sha512-SnH5WK+bZxgPHs44uWIX+LLJAJ9/2PkPKZ5QiAj6Ta86w+fsb2TkcmfRyVX3pBnMFcV7oQPJkl9QevSCWr3W6A==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="./css/admin_panel.css">
</head>
<body>
    <h1 class='admin__title'>Panel zarządzania użytkownikami</h1>
    <table>
    <tr>
        <th>ID</th>
        <th>Imię</th>
        <th>Nazwisko</th>
        <th>Numer telefonu</th>
        <th>Email</th>
        <th>Aktywny</th>
        <th>Nauczyciel</th>
        <th>Ban</th>
        <th>Akcja</th>
    </tr>
<?php


// Obsługa formularza edycji
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['edit_user']) && isset($_POST['user_id']) && isset($_POST['active'])) {
        $user_id = $_POST['user_id'];
        $active = $_POST['active'];
        $sql_update = "UPDATE users SET active=$active WHERE user_id=$user_id";
        if ($conn->query($sql_update) === TRUE) {
            echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Aktywność konta została zmieniona.</p>";
        } else {
            echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Błąd zmiany aktywności konta: " . $conn->error . "</p>";
        }

    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['teacher_user']) && isset($_POST['user_id']) && isset($_POST['teacher'])) {
        $user_id = $_POST['user_id'];
        $teacher = $_POST['teacher'];

        if ($teacher == 1) {
            // Sprawdź czy użytkownik jest już nauczycielem
            $sql_check_teacher = "SELECT * FROM teachers WHERE user_id=$user_id";
            $result_check_teacher = $conn->query($sql_check_teacher);
            if ($result_check_teacher->num_rows == 0) {
                // Jeśli użytkownik nie jest jeszcze nauczycielem, zapisz go
                $sql_insert = "INSERT INTO teachers (user_id) VALUES ($user_id)";
                if ($conn->query($sql_insert) === TRUE) {
                    echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Użytkownik został dodany do nauczycieli pomyślnie.</p>";
                } else {
                    echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Błąd dodawania użytkownika do nauczycieli: " . $conn->error . "</p>";
                }
            } else {
                echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Użytkownik już jest nauczycielem.</p>";
            }
        } else {
            // Jeśli użytkownik nie jest nauczycielem, usuń go z tabeli nauczycieli (jeśli był wcześniej dodany)
            $sql_delete = "DELETE FROM teachers WHERE user_id=$user_id";
            if ($conn->query($sql_delete) === TRUE) {
                echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Użytkownik został usunięty z nauczycieli pomyślnie.</p>";
            } else {
                echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Błąd usuwania użytkownika z nauczycieli: " . $conn->error . "</p>";
            }
        }
    }
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if(isset($_POST['ban_user']) && isset($_POST['user_id']) && isset($_POST['ban'])) {
        $user_id = $_POST['user_id'];
        $ban = $_POST['ban'];

        if ($ban == 1) {
            $sql_check_ban = "SELECT * FROM bans WHERE user_id=$user_id";
            $result_check_ban = $conn->query($sql_check_ban);
            if ($result_check_ban->num_rows == 0) {
                $sql_insert = "INSERT INTO bans (user_id) VALUES ($user_id)";
                if ($conn->query($sql_insert) === TRUE) {
                    echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Użytkownik został zbanoway pomyślnie.</p>";
                } else {
                    echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Błąd banowania użytkownika: " . $conn->error . "</p>";
                }
            } else {
                echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Użytkownik już jest zbanowany.</p>";
            }
        } else {
            $sql_delete = "DELETE FROM bans WHERE user_id=$user_id";
            if ($conn->query($sql_delete) === TRUE) {
                echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Użytkownik został odbanowany pomyślnie.</p>";
            } else {
                echo "<p style='font-size: 1.8rem; text-align:center; font-weight: bold;'>Błąd usuwania odbanowania użytkownika: " . $conn->error . "</p>";
            }
        }
    }
    
}

// Zapytanie SQL
$sql = "SELECT * FROM users";
$result = $conn->query($sql);

// Sprawdzenie czy są wyniki
if ($result->num_rows > 0) {
    // Wyświetlenie danych dla każdego użytkownika
    while($row = $result->fetch_assoc()) {
        echo "<tr>";
        echo "<td>" . $row["user_id"]. "</td>";
        echo "<td><a class='panel__user' href='user_detail.php?user_id=" . $row["user_id"] . "'>" . $row["first_name"] . "</a></td>";
        echo "<td>" . $row["surename"]. "</td>";
        echo "<td>" . $row["mobile_number"]. "</td>";
        echo "<td>" . $row["email"]. "</td>";
        echo "<td>" . ($row["active"] ? "Tak" : "Nie") . "</td>";
        
        // Sprawdź czy użytkownik jest nauczycielem
        $sql_check_teacher = "SELECT * FROM teachers WHERE user_id=".$row["user_id"];
        $result_check_teacher = $conn->query($sql_check_teacher);
        echo "<td>" . ($result_check_teacher->num_rows > 0 ? "Tak" : "Nie") . "</td>";
        
        $sql_check_ban = "SELECT * FROM bans WHERE user_id=".$row["user_id"];
        $result_check_ban = $conn->query($sql_check_ban);
        echo "<td>" . ($result_check_ban->num_rows > 0 ? "Tak" : "Nie") . "</td>";
        echo "<td>";
        echo "<form class='ms-5' style='display: inline-block;' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
        echo "<label class='me-4'> Użytkownik aktywny: </label>";
        echo "<select class='admin__select' name='active'>";
        echo "<option value='1'>Tak</option>";
        echo "<option value='0'>Nie</option>";
        echo "</select>";
        echo "<input class='admin__btn' type='submit' name='edit_user' value='Zapisz'>";
        echo "</form>";
        // --------
        echo "<form class='ms-5' style='display: inline-block;' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
        echo "<label class='me-4'> Użytkownik jest nauczycielem: </label>";
        echo "<select class='admin__select' name='teacher'>";
        echo "<option value='1'>Tak</option>";
        echo "<option value='0'>Nie</option>";
        echo "</select>";
        echo "<input class='admin__btn' type='submit' name='teacher_user' value='Zapisz'>";
        echo "</form>";
        // -------
        echo "<form class='ms-5' style='display: inline-block;' method='post'>";
        echo "<input type='hidden' name='user_id' value='" . $row["user_id"] . "'>";
        echo "<label class='me-4'> Zbanować użytkownika:</label>";
        echo "<select class='admin__select' name='ban'>";
        echo "<option value='1'>Tak</option>";
        echo "<option value='0'>Nie</option>";
        echo "</select>";

        echo "<input class='admin__btn' type='submit' name='ban_user' value='Zapisz'>";
        echo "</form>";

        echo "</td>";
        echo "</tr>";
    }
} else {
    echo "<tr><td colspan='8'>Brak użytkowników w bazie danych.</td></tr>";
}

// Zamknięcie połączenia
$conn->close();
?>
</table>
<a class='panel__btn' href='index_admins.php'>Powrót</a>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>
</html>