<html lang="ru">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <title>Регистрация и вход</title>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.1/jquery.min.js"></script>

    <div class="container">
        <br><h3>Регистрация</h3>
        <form>
            <input type="text" name="reg_nick" id="reg_nick" placeholder="Никнейм" class="form-control"><br>
            <button type="button" name="register" id="register" class="btn btn-outline-dark">Зарегистрироваться</button>
        </form>
        <div id="reg_error"></div>
    <script src="config/register.js"></script>
    </div>

    <div class="container">
        <br><h3>Вход</h3>
        <form>
            <input type="text" name="auth_nick" id="auth_nick" placeholder="Никнейм" class="form-control"><br>
            <button type="button" name="authorisation" id="authorisation" class="btn btn-outline-dark">Войти</button>
        </form>
        <div id="auth_error"></div>
    <script src="config/authorisation.js"></script>
    </div>
</body>
</html>
