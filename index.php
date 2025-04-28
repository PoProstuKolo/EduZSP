
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
                    <h2 class="login__title">Login - zaloguj się</h2>
                    <div class="login__hr"></div>
                    <form class="login__form" action="login_process.php" method="post">
                        <label class="login__label" for="email">Email:</label>
                        <input class="login__input" type="email" id="email" name="email" required>
                        <label class="login__label mt-3" for="password">Password:</label>
                        <input class="login__input " type="password" id="password" name="password" required>
                        <input class="login__btn" type="submit" value="Login">
                    </form>
                    <p class="login__register-txt">Nie masz konta? <a class="login__register" href="register.php">Zarejestruj się</a></p>
                </div>

            </div>


        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"></script>
</body>

</html>