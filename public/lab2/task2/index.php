<?php
//2 - робота з сесією
session_start();

//логін і пароль для перевірки
$validLogin = "admin";
$validPassword = "4321";
$error = "";

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    if (isset($_POST["logout"])) {
        //вихід чистить сесію і веде на головну
        session_unset();
        session_destroy();
        header("Location: index.php");
        exit;
    }

    $login = trim($_POST["login"] ?? "");
    $password = $_POST["password"] ?? "";

    if ($login === $validLogin && $password === $validPassword) {
        //зберігаємо користувача в сесії
        $_SESSION["user"] = $login;
        header("Location: index.php");
        exit;
    } else {
        $error = "Неправильний логін або пароль";
    }
}
?>
<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <title>Сесія</title>
</head>
<body>
    <h2>Вхід</h2>

    <?php if (isset($_SESSION["user"])): ?>
        <p>Привіт, <?= htmlspecialchars($_SESSION["user"]) ?>! Ви увійшли в систему.</p>
        <form method="post">
            <button type="submit" name="logout">Вихід</button>
        </form>
    <?php else: ?>
        <?php if ($error !== ""): ?>
            <p style="color: red;"><?= $error ?></p>
        <?php endif; ?>
        <form method="post">
            <label for="login">Логін:</label>
            <input type="text" id="login" name="login"><br><br>
            <label for="password">Пароль:</label>
            <input type="password" id="password" name="password"><br><br>
            <button type="submit">Увійти</button>
        </form>
    <?php endif; ?>
</body>
</html>
