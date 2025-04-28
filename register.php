<!DOCTYPE html>
<html lang="pl">

<head>
    <meta charset="UTF-8">
		<meta name="robots" content="noindex, nofollow" />

    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="./css/login.css">
</head>

<body>
    <h1 class="eduzsp__title"><img class="eduzsp__img" src="./img/logo.png" alt="Logo platformy EduZSP">EduZSP</h1>
    <div class="container">
        <div class="row gy-5 m-3 m-md-0">
            <div class="col-12 col-md-6 mx-auto">
                <div class="login__box">
                    <h2 class="login__title">Zarejestuj się</h2>
                    <div class="login__hr"></div>
                    <form class="login__form" action="register_process.php" method="post">
                        <label class="login__label" for="first_name">Imię:</label>
                        <input class="login__input" type="text" id="first_name" name="first_name" required>
                        <label class="login__label mt-3" for="surename">Nazwisko:</label>
                        <input class="login__input" type="text" id="surename" name="surename" required>
                        <label class="login__label mt-3" for="mobile_number">Numer telefonu:</label>
                        <input class="login__input" type="number" min="100000000" max="999999999" maxLength="9" oninput="this.value = this.value.slice(0, this.maxLength);" id="mobile_number" name="mobile_number" required>
                        <label class="login__label mt-3" for="email">Email:</label>
                        <input class="login__input" type="email" id="email" name="email" required>
                        <label class="login__label mt-3" for="password">Hasło:</label>
                        <input class="login__input" type="password" id="password" name="password" required>
                        <input class="login__btn" type="submit" value="Zarejestruj">
                    </form>
                    <p class="login__register-txt">Masz już konto? <a class="login__register" href="index.php">Zaloguj się</a></p>

            </div>


        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>
</html>
